<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketDepartment;
use App\Models\TicketAttachment;
use App\Models\Service;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketRepliedMail;
use App\Mail\TicketClosedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the client's tickets.
     */
    public function index(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        $query = Ticket::where('client_id', $client->id)
            ->with(['department', 'assignedAdmin'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', '!=', 'closed');
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Search by ticket number or subject
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(10)->withQueryString();
        $departments = TicketDepartment::active()->ordered()->get();

        // Statistics
        $stats = [
            'total' => Ticket::where('client_id', $client->id)->count(),
            'open' => Ticket::where('client_id', $client->id)->where('status', 'open')->count(),
            'answered' => Ticket::where('client_id', $client->id)->where('status', 'answered')->count(),
            'closed' => Ticket::where('client_id', $client->id)->where('status', 'closed')->count(),
        ];

        return view('frontend.client.tickets.index', compact('tickets', 'departments', 'stats'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create(Request $request)
    {
        $client = Auth::guard('client')->user();
        $departments = TicketDepartment::active()->ordered()->get();
        
        // Get client's services for linking
        $services = Service::where('client_id', $client->id)
            ->whereIn('status', ['active', 'suspended'])
            ->orderBy('type')
            ->get()
            ->groupBy('type');

        // Pre-select service if provided
        $selectedService = null;
        if ($request->filled('service_id')) {
            $selectedService = Service::where('id', $request->service_id)
                ->where('client_id', $client->id)
                ->first();
        }

        return view('frontend.client.tickets.create', compact('departments', 'services', 'selectedService'));
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $client = Auth::guard('client')->user();

        $validated = $request->validate([
            'department_id' => 'required|exists:ticket_departments,id',
            'service_id' => 'nullable|exists:services,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,rtf,xls,xlsx,csv,zip,rar,7z',
        ], [
            'department_id.required' => __('tickets.validation.department_required'),
            'subject.required' => __('tickets.validation.subject_required'),
            'subject.max' => __('tickets.validation.subject_max'),
            'message.required' => __('tickets.validation.message_required'),
            'message.min' => __('tickets.validation.message_min'),
            'priority.required' => __('tickets.validation.priority_required'),
            'attachments.*.max' => __('tickets.validation.attachment_max'),
            'attachments.*.mimes' => __('tickets.validation.attachment_mimes'),
        ]);

        // Verify service belongs to client if provided
        if ($validated['service_id']) {
            $service = Service::where('id', $validated['service_id'])
                ->where('client_id', $client->id)
                ->first();
            
            if (!$service) {
                return back()->withErrors(['service_id' => __('tickets.validation.invalid_service')]);
            }
        }

        // Create ticket
        $ticket = Ticket::create([
            'client_id' => $client->id,
            'department_id' => $validated['department_id'],
            'service_id' => $validated['service_id'] ?? null,
            'service_type' => isset($service) ? $service->type : null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $ticket, null, $client->id, null);
        }

        // Send notification emails
        try {
            // Email to client
            Mail::to($client->email)->queue(new TicketCreatedMail($ticket, $client, 'client'));
            
            // Email to department (if email is set)
            $department = TicketDepartment::find($validated['department_id']);
            if ($department && $department->email) {
                Mail::to($department->email)->queue(new TicketCreatedMail($ticket, $client, 'admin'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send ticket creation email: ' . $e->getMessage());
        }

        return redirect()
            ->route('client.tickets.show', $ticket)
            ->with('success', __('tickets.messages.created_success'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $client = Auth::guard('client')->user();

        // Ensure ticket belongs to client
        if ($ticket->client_id !== $client->id) {
            abort(403);
        }

        $ticket->load([
            'department',
            'assignedAdmin',
            'service',
            'replies' => function ($query) {
                $query->where('is_internal', false)->with(['client', 'admin', 'attachments']);
            },
            'attachments',
        ]);

        return view('frontend.client.tickets.show', compact('ticket'));
    }

    /**
     * Store a reply to the ticket.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $client = Auth::guard('client')->user();

        // Ensure ticket belongs to client
        if ($ticket->client_id !== $client->id) {
            abort(403);
        }

        // Check if ticket is closed
        if ($ticket->isClosed()) {
            return back()->withErrors(['message' => __('tickets.messages.cannot_reply_closed')]);
        }

        $validated = $request->validate([
            'message' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,rtf,xls,xlsx,csv,zip,rar,7z',
        ], [
            'message.required' => __('tickets.validation.reply_required'),
            'message.min' => __('tickets.validation.reply_min'),
        ]);

        // Create reply
        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'client_id' => $client->id,
            'message' => $validated['message'],
            'is_internal' => false,
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $ticket, $reply->id, $client->id, null);
        }

        // Update ticket status
        $ticket->update([
            'status' => 'customer_reply',
            'last_reply_at' => now(),
        ]);

        // Send notification to admin
        try {
            if ($ticket->assignedAdmin && $ticket->assignedAdmin->email) {
                Mail::to($ticket->assignedAdmin->email)->queue(new TicketRepliedMail($ticket, $reply, 'admin'));
            } elseif ($ticket->department && $ticket->department->email) {
                Mail::to($ticket->department->email)->queue(new TicketRepliedMail($ticket, $reply, 'admin'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send ticket reply email: ' . $e->getMessage());
        }

        return back()->with('success', __('tickets.messages.reply_success'));
    }

    /**
     * Close a ticket.
     */
    public function close(Ticket $ticket)
    {
        $client = Auth::guard('client')->user();

        // Ensure ticket belongs to client
        if ($ticket->client_id !== $client->id) {
            abort(403);
        }

        if ($ticket->isClosed()) {
            return back()->withErrors(['message' => __('tickets.messages.already_closed')]);
        }

        $ticket->close(null, $client->id);

        // Send notification
        try {
            Mail::to($client->email)->queue(new TicketClosedMail($ticket, $client));
        } catch (\Exception $e) {
            Log::error('Failed to send ticket closed email: ' . $e->getMessage());
        }

        return back()->with('success', __('tickets.messages.closed_success'));
    }

    /**
     * Reopen a closed ticket.
     */
    public function reopen(Ticket $ticket)
    {
        $client = Auth::guard('client')->user();

        // Ensure ticket belongs to client
        if ($ticket->client_id !== $client->id) {
            abort(403);
        }

        if (!$ticket->isClosed()) {
            return back()->withErrors(['message' => __('tickets.messages.not_closed')]);
        }

        $ticket->reopen();

        return back()->with('success', __('tickets.messages.reopened_success'));
    }

    /**
     * Rate a support reply.
     */
    public function rateReply(Request $request, TicketReply $reply)
    {
        $client = Auth::guard('client')->user();

        // Ensure the reply belongs to a ticket owned by this client
        if ($reply->ticket->client_id !== $client->id) {
            abort(403);
        }

        // Only admin replies can be rated
        if (!$reply->isFromAdmin()) {
            return back()->withErrors(['message' => __('tickets.messages.cannot_rate_own_reply')]);
        }

        $validated = $request->validate([
            'rating' => 'required|in:helpful,not_helpful',
        ]);

        $reply->update([
            'rating' => $validated['rating'],
            'rated_at' => now(),
        ]);

        return back()->with('success', __('tickets.messages.rating_success'));
    }

    /**
     * Download an attachment.
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
        $client = Auth::guard('client')->user();

        // Verify access through ticket or reply
        $hasAccess = false;
        
        if ($attachment->ticket_id) {
            $hasAccess = $attachment->ticket->client_id === $client->id;
        } elseif ($attachment->reply_id) {
            $hasAccess = $attachment->reply->ticket->client_id === $client->id;
        }

        if (!$hasAccess) {
            abort(403);
        }

        $path = Storage::disk($attachment->disk)->path($attachment->path);
        
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, $attachment->filename);
    }

    /**
     * Handle file attachments.
     */
    protected function handleAttachments(array $files, Ticket $ticket, ?int $replyId, ?int $clientId, ?int $adminId): void
    {
        $count = 0;
        foreach ($files as $file) {
            if ($count >= TicketAttachment::MAX_FILES_PER_UPLOAD) {
                break;
            }

            if (!$file->isValid()) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            if (!TicketAttachment::isValidExtension($extension)) {
                continue;
            }

            if (!TicketAttachment::isValidSize($file->getSize())) {
                continue;
            }

            // Generate unique filename
            $filename = Str::uuid() . '.' . $extension;
            $path = "tickets/{$ticket->id}/" . ($replyId ? "replies/{$replyId}/" : '') . $filename;

            // Store file
            Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

            // Create attachment record
            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'reply_id' => $replyId,
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'disk' => 'local',
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by_client_id' => $clientId,
                'uploaded_by_admin_id' => $adminId,
            ]);

            $count++;
        }
    }

    /**
     * Upload image for TinyMCE editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,gif,webp|max:5120', // 5MB max
        ]);

        try {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store in public storage for direct access
            $path = $file->storeAs('ticket-images', $filename, 'public');
            
            // Return the URL for TinyMCE
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        } catch (\Exception $e) {
            Log::error('TinyMCE image upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed'], 500);
        }
    }
}
