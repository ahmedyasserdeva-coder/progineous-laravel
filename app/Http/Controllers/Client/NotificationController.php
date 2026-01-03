<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('client_id', Auth::guard('client')->id())
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' 
                ? 'تم تحديد الإشعار كمقروء'
                : 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $updated = Notification::where('client_id', Auth::guard('client')->id())
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'ar' 
                ? 'تم تحديد جميع الإشعارات كمقروءة'
                : 'All notifications marked as read',
            'count' => $updated
        ]);
    }
}
