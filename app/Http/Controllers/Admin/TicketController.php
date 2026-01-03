<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketDepartment;
use App\Models\TicketAttachment;
use App\Models\Admin;
use App\Mail\TicketRepliedMail;
use App\Mail\TicketClosedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Client;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display the support overview dashboard.
     */
    public function overview()
    {
        // Basic Statistics
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'customer_reply' => Ticket::where('status', 'customer_reply')->count(),
            'answered' => Ticket::where('status', 'answered')->count(),
            'on_hold' => Ticket::where('status', 'on_hold')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'unassigned' => Ticket::whereNull('assigned_admin_id')->where('status', '!=', 'closed')->count(),
        ];

        // Priority breakdown
        $priorityStats = [
            'urgent' => Ticket::where('priority', 'urgent')->where('status', '!=', 'closed')->count(),
            'high' => Ticket::where('priority', 'high')->where('status', '!=', 'closed')->count(),
            'medium' => Ticket::where('priority', 'medium')->where('status', '!=', 'closed')->count(),
            'low' => Ticket::where('priority', 'low')->where('status', '!=', 'closed')->count(),
        ];

        // Today's statistics
        $todayStats = [
            'new' => Ticket::whereDate('created_at', Carbon::today())->count(),
            'closed' => Ticket::whereDate('closed_at', Carbon::today())->count(),
            'replies' => TicketReply::whereDate('created_at', Carbon::today())->count(),
        ];

        // This week's statistics
        $weekStats = [
            'new' => Ticket::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'closed' => Ticket::whereBetween('closed_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
        ];

        // Department statistics
        $departmentStats = TicketDepartment::withCount([
            'tickets',
            'tickets as open_tickets_count' => function ($query) {
                $query->where('status', '!=', 'closed');
            }
        ])->ordered()->get();

        // Staff performance (tickets handled this month)
        $staffPerformance = Admin::withCount([
            'assignedTickets as total_assigned' => function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            },
            'assignedTickets as closed_tickets' => function ($query) {
                $query->where('status', 'closed')->whereMonth('closed_at', Carbon::now()->month);
            },
            'ticketReplies as replies_count' => function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            }
        ])->orderByDesc('replies_count')->take(10)->get();

        // Recent tickets (last 10)
        $recentTickets = Ticket::with(['client', 'department', 'assignedAdmin'])
            ->latest()
            ->take(10)
            ->get();

        // Tickets needing attention (urgent/high priority, unanswered)
        $urgentTickets = Ticket::with(['client', 'department'])
            ->whereIn('priority', ['urgent', 'high'])
            ->whereIn('status', ['open', 'customer_reply'])
            ->orderByRaw("FIELD(priority, 'urgent', 'high')")
            ->latest()
            ->take(5)
            ->get();

        // Average response time (in hours) - last 30 days
        $avgResponseTime = $this->calculateAverageResponseTime();

        // Tickets chart data (last 7 days)
        $chartData = $this->getTicketsChartData();

        return view('admin.tickets.overview', compact(
            'stats',
            'priorityStats',
            'todayStats',
            'weekStats',
            'departmentStats',
            'staffPerformance',
            'recentTickets',
            'urgentTickets',
            'avgResponseTime',
            'chartData'
        ));
    }

    /**
     * Calculate average response time in hours.
     */
    private function calculateAverageResponseTime()
    {
        $tickets = Ticket::where('created_at', '>=', Carbon::now()->subDays(30))
            ->whereHas('replies', function ($query) {
                $query->whereNotNull('admin_id');
            })
            ->with(['replies' => function ($query) {
                $query->whereNotNull('admin_id')->orderBy('created_at', 'asc');
            }])
            ->get();

        if ($tickets->isEmpty()) {
            return 0;
        }

        $totalMinutes = 0;
        $count = 0;

        foreach ($tickets as $ticket) {
            $firstAdminReply = $ticket->replies->first();
            if ($firstAdminReply) {
                $totalMinutes += $ticket->created_at->diffInMinutes($firstAdminReply->created_at);
                $count++;
            }
        }

        if ($count === 0) {
            return 0;
        }

        return round($totalMinutes / $count / 60, 1); // Return hours
    }

    /**
     * Get tickets chart data for the last 7 days.
     */
    private function getTicketsChartData()
    {
        $labels = [];
        $newTickets = [];
        $closedTickets = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D');
            $newTickets[] = Ticket::whereDate('created_at', $date)->count();
            $closedTickets[] = Ticket::whereDate('closed_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'new' => $newTickets,
            'closed' => $closedTickets,
        ];
    }

    /**
     * Display a listing of all tickets.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['client', 'department', 'assignedAdmin'])
            ->latest();

        // Filter by flagged tickets
        if ($request->filled('flagged') && $request->flagged == 1) {
            $query->where('is_flagged', true);
        }

        // Filter by active tickets (all except closed)
        if ($request->filled('active') && $request->active == 1) {
            $query->where('status', '!=', 'closed');
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', '!=', 'closed');
            } elseif ($request->status === 'flagged') {
                $query->where('is_flagged', true);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Filter by assigned admin
        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_admin_id');
            } elseif ($request->assigned_to === 'me') {
                $query->where('assigned_admin_id', Auth::guard('admin')->id());
            } else {
                $query->where('assigned_admin_id', $request->assigned_to);
            }
        }

        // Search by ticket number, subject, or client name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->paginate(20)->withQueryString();
        $departments = TicketDepartment::ordered()->get();
        $admins = Admin::orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'customer_reply' => Ticket::where('status', 'customer_reply')->count(),
            'answered' => Ticket::where('status', 'answered')->count(),
            'on_hold' => Ticket::where('status', 'on_hold')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'unassigned' => Ticket::whereNull('assigned_admin_id')->where('status', '!=', 'closed')->count(),
            'my_tickets' => Ticket::where('assigned_admin_id', Auth::guard('admin')->id())->where('status', '!=', 'closed')->count(),
            'flagged' => Ticket::where('is_flagged', true)->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'departments', 'admins', 'stats'));
    }

    /**
     * Show the form for creating a new ticket on behalf of a client.
     */
    public function create()
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $departments = TicketDepartment::active()->ordered()->get();
        $admins = Admin::orderBy('name')->get();

        return view('admin.tickets.create', compact('clients', 'departments', 'admins'));
    }

    /**
     * Store a new ticket created by admin on behalf of a client.
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'department_id' => 'required|exists:ticket_departments,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_admin_id' => 'nullable|exists:admins,id',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,rtf,xls,xlsx,csv,zip,rar,7z',
        ]);

        // Generate unique ticket number
        $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
        while (Ticket::where('ticket_number', $ticketNumber)->exists()) {
            $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
        }

        // Create the ticket
        $ticket = Ticket::create([
            'ticket_number' => $ticketNumber,
            'client_id' => $validated['client_id'],
            'department_id' => $validated['department_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'status' => 'open',
            'assigned_admin_id' => $validated['assigned_admin_id'] ?? $admin->id,
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $ticket, null, null, $admin->id);
        }

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', __('tickets.messages.ticket_created_successfully'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load([
            'client',
            'department',
            'assignedAdmin',
            'service',
            'replies.client',
            'replies.admin',
            'replies.attachments',
            'attachments',
        ]);

        $departments = TicketDepartment::active()->ordered()->get();
        $admins = Admin::orderBy('name')->get();

        return view('admin.tickets.show', compact('ticket', 'departments', 'admins'));
    }

    /**
     * Store a reply to the ticket.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'message' => 'required|string|min:5',
            'is_internal' => 'nullable|boolean',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,rtf,xls,xlsx,csv,zip,rar,7z',
        ]);

        $isInternal = $request->boolean('is_internal', false);

        // Create reply
        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'admin_id' => $admin->id,
            'message' => $validated['message'],
            'is_internal' => $isInternal,
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $ticket, $reply->id, null, $admin->id);
        }

        // Update ticket status only for non-internal replies
        if (!$isInternal) {
            $ticket->update([
                'status' => 'answered',
                'last_reply_at' => now(),
            ]);

            // Auto-assign to current admin if unassigned
            if (!$ticket->assigned_admin_id) {
                $ticket->update(['assigned_admin_id' => $admin->id]);
            }

            // Send notification to client
            try {
                Mail::to($ticket->client->email)->queue(new TicketRepliedMail($ticket, $reply, 'client'));
            } catch (\Exception $e) {
                Log::error('Failed to send ticket reply email: ' . $e->getMessage());
            }
        }

        return back()->with('success', $isInternal 
            ? __('tickets.messages.internal_note_added')
            : __('tickets.messages.reply_success'));
    }

    /**
     * Update ticket properties (status, priority, department, assignment).
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:open,answered,customer_reply,on_hold,closed',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'department_id' => 'nullable|exists:ticket_departments,id',
            'assigned_admin_id' => 'nullable|exists:admins,id',
        ]);

        $updates = array_filter($validated, fn($value) => !is_null($value));

        // Handle closing
        if (isset($updates['status']) && $updates['status'] === 'closed') {
            $updates['closed_at'] = now();
            $updates['closed_by_admin_id'] = Auth::guard('admin')->id();
        }

        // Handle reopening
        if (isset($updates['status']) && $updates['status'] !== 'closed' && $ticket->status === 'closed') {
            $updates['closed_at'] = null;
            $updates['closed_by_admin_id'] = null;
            $updates['closed_by_client_id'] = null;
        }

        $ticket->update($updates);

        // Send notification if ticket was closed
        if (isset($updates['status']) && $updates['status'] === 'closed') {
            try {
                Mail::to($ticket->client->email)->queue(new TicketClosedMail($ticket, $ticket->client));
            } catch (\Exception $e) {
                Log::error('Failed to send ticket closed email: ' . $e->getMessage());
            }
        }

        return back()->with('success', __('tickets.messages.updated_success'));
    }

    /**
     * Toggle flag on a ticket.
     */
    public function toggleFlag(Ticket $ticket)
    {
        $admin = Auth::guard('admin')->user();

        if ($ticket->is_flagged) {
            // Unflag the ticket
            $ticket->update([
                'is_flagged' => false,
                'flagged_by_admin_id' => null,
                'flagged_at' => null,
            ]);
            $message = __('tickets.messages.unflagged_success');
        } else {
            // Flag the ticket
            $ticket->update([
                'is_flagged' => true,
                'flagged_by_admin_id' => $admin->id,
                'flagged_at' => now(),
            ]);
            $message = __('tickets.messages.flagged_success');
        }

        return back()->with('success', $message);
    }

    /**
     * Delete a ticket.
     */
    public function destroy(Ticket $ticket)
    {
        // Delete all attachments
        foreach ($ticket->attachments as $attachment) {
            $attachment->deleteFile();
        }

        foreach ($ticket->replies as $reply) {
            foreach ($reply->attachments as $attachment) {
                $attachment->deleteFile();
            }
        }

        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', __('tickets.messages.deleted_success'));
    }

    /**
     * Department management - index.
     */
    public function departments()
    {
        $departments = TicketDepartment::withCount('tickets')->ordered()->get();
        return view('admin.tickets.departments.index', compact('departments'));
    }

    /**
     * Store a new department.
     */
    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        TicketDepartment::create($validated);

        return back()->with('success', __('tickets.messages.department_created'));
    }

    /**
     * Update a department.
     */
    public function updateDepartment(Request $request, TicketDepartment $department)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $department->update($validated);

        return back()->with('success', __('tickets.messages.department_updated'));
    }

    /**
     * Delete a department.
     */
    public function destroyDepartment(TicketDepartment $department)
    {
        if ($department->tickets()->exists()) {
            return back()->withErrors(['message' => __('tickets.messages.department_has_tickets')]);
        }

        $department->delete();

        return back()->with('success', __('tickets.messages.department_deleted'));
    }

    /**
     * Download an attachment.
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
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
     * Bulk actions on tickets.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:close,delete,assign,change_priority,change_department',
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:tickets,id',
            'assigned_admin_id' => 'required_if:action,assign|nullable|exists:admins,id',
            'priority' => 'required_if:action,change_priority|nullable|in:low,medium,high,urgent',
            'department_id' => 'required_if:action,change_department|nullable|exists:ticket_departments,id',
        ]);

        $tickets = Ticket::whereIn('id', $validated['ticket_ids'])->get();
        $admin = Auth::guard('admin')->user();

        switch ($validated['action']) {
            case 'close':
                foreach ($tickets as $ticket) {
                    $ticket->close($admin->id);
                }
                $message = __('tickets.messages.bulk_closed', ['count' => count($validated['ticket_ids'])]);
                break;

            case 'delete':
                foreach ($tickets as $ticket) {
                    foreach ($ticket->attachments as $attachment) {
                        $attachment->deleteFile();
                    }
                    foreach ($ticket->replies as $reply) {
                        foreach ($reply->attachments as $attachment) {
                            $attachment->deleteFile();
                        }
                    }
                    $ticket->delete();
                }
                $message = __('tickets.messages.bulk_deleted', ['count' => count($validated['ticket_ids'])]);
                break;

            case 'assign':
                Ticket::whereIn('id', $validated['ticket_ids'])
                    ->update(['assigned_admin_id' => $validated['assigned_admin_id']]);
                $message = __('tickets.messages.bulk_assigned', ['count' => count($validated['ticket_ids'])]);
                break;

            case 'change_priority':
                Ticket::whereIn('id', $validated['ticket_ids'])
                    ->update(['priority' => $validated['priority']]);
                $message = __('tickets.messages.bulk_priority_changed', ['count' => count($validated['ticket_ids'])]);
                break;

            case 'change_department':
                Ticket::whereIn('id', $validated['ticket_ids'])
                    ->update(['department_id' => $validated['department_id']]);
                $message = __('tickets.messages.bulk_department_changed', ['count' => count($validated['ticket_ids'])]);
                break;

            default:
                $message = __('tickets.messages.unknown_action');
        }

        return back()->with('success', $message);
    }
}
