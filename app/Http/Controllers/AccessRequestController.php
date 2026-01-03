<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessLog;

class AccessRequestController extends Controller
{
    /**
     * Show access request page
     */
    public function showRequestPage(Request $request)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        
        // Get the latest request for this IP
        $accessLog = AccessLog::where('ip_address', $ipAddress)
                             ->where('access_status', 'pending')
                             ->latest()
                             ->first();

        return view('access.request', compact('accessLog', 'ipAddress', 'userAgent'));
    }

    /**
     * Submit access request
     */
    public function submitRequest(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
            'contact_info' => 'required|string|max:255'
        ]);

        $ipAddress = $request->ip();
        
        // Update or create access log
        $accessLog = AccessLog::where('ip_address', $ipAddress)
                             ->where('access_status', 'pending')
                             ->latest()
                             ->first();

        if ($accessLog) {
            $accessLog->update([
                'request_headers' => array_merge($accessLog->request_headers ?? [], [
                    'reason' => $request->reason,
                    'contact_info' => $request->contact_info
                ])
            ]);
        } else {
            AccessLog::logRequest($request);
        }

        return redirect()->route('access.pending')->with('success', __('crm.access_request_submitted'));
    }

    /**
     * Show pending page
     */
    public function showPendingPage()
    {
        return view('access.pending');
    }

    /**
     * Check access status (AJAX)
     */
    public function checkStatus(Request $request)
    {
        $ipAddress = $request->ip();
        $hasAccess = AccessLog::hasAccess($ipAddress);

        return response()->json(['hasAccess' => $hasAccess]);
    }

    /**
     * Admin: Show access requests
     */
    public function adminIndex()
    {
        $requests = AccessLog::where('access_status', 'pending')
                            ->orderBy('access_requested_at', 'desc')
                            ->paginate(20);

        return view('admin.access-requests', compact('requests'));
    }

    /**
     * Admin: Grant access
     */
    public function grantAccess(Request $request, $id)
    {
        $accessLog = AccessLog::findOrFail($id);
        $accessLog->update([
            'access_status' => 'granted',
            'access_granted_at' => now()
        ]);

        return redirect()->back()->with('success', __('crm.access_granted'));
    }

    /**
     * Admin: Deny access
     */
    public function denyAccess(Request $request, $id)
    {
        $accessLog = AccessLog::findOrFail($id);
        $accessLog->update([
            'access_status' => 'denied'
        ]);

        return redirect()->back()->with('success', __('crm.access_denied'));
    }
}
