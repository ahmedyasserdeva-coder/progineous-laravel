<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PredefinedReply;
use App\Models\TicketDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredefinedReplyController extends Controller
{
    /**
     * Display a listing of predefined replies.
     */
    public function index(Request $request)
    {
        $query = PredefinedReply::with(['department', 'creator'])->ordered();

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $replies = $query->paginate(20)->withQueryString();
        $departments = TicketDepartment::ordered()->get();

        return view('admin.predefined-replies.index', compact('replies', 'departments'));
    }

    /**
     * Show the form for creating a new predefined reply.
     */
    public function create()
    {
        $departments = TicketDepartment::active()->ordered()->get();
        return view('admin.predefined-replies.create', compact('departments'));
    }

    /**
     * Store a newly created predefined reply.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'department_id' => 'nullable|exists:ticket_departments,id',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['created_by'] = Auth::guard('admin')->id();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        PredefinedReply::create($validated);

        return redirect()->route('admin.predefined-replies.index')
            ->with('success', __('tickets.predefined_replies.created'));
    }

    /**
     * Show the form for editing a predefined reply.
     */
    public function edit(PredefinedReply $predefinedReply)
    {
        $departments = TicketDepartment::active()->ordered()->get();
        return view('admin.predefined-replies.edit', compact('predefinedReply', 'departments'));
    }

    /**
     * Update the specified predefined reply.
     */
    public function update(Request $request, PredefinedReply $predefinedReply)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'department_id' => 'nullable|exists:ticket_departments,id',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $predefinedReply->update($validated);

        return redirect()->route('admin.predefined-replies.index')
            ->with('success', __('tickets.predefined_replies.updated'));
    }

    /**
     * Remove the specified predefined reply.
     */
    public function destroy(PredefinedReply $predefinedReply)
    {
        $predefinedReply->delete();

        return redirect()->route('admin.predefined-replies.index')
            ->with('success', __('tickets.predefined_replies.deleted'));
    }

    /**
     * Get predefined replies for a specific department (API).
     */
    public function getForDepartment(Request $request)
    {
        $departmentId = $request->department_id;
        
        $replies = PredefinedReply::active()
            ->ordered()
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->forDepartment($departmentId);
            }, function ($query) {
                $query->whereNull('department_id');
            })
            ->get(['id', 'name', 'content']);

        return response()->json($replies);
    }
}
