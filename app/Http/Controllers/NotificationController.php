<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function check()
    {
        $user = Auth::user();
        $unread = $user->unreadNotifications()->count();
        $lastNotification = $user->notifications()->latest()->first();
        
        return response()->json([
            'newNotifications' => $unread,
            'lastNotification' => $lastNotification ? $lastNotification->created_at->toISOString() : null,
            'notifications' => $user->notifications()
                                  ->orderBy('created_at', 'desc')
                                  ->limit(10)
                                  ->get()
                                  ->map(function($notification) {
                                      return [
                                          'id' => $notification->id,
                                          'message' => $notification->data['message'] ?? 'Nouvelle notification',
                                          'url' => $notification->data['url'] ?? '#',
                                          'time' => $notification->created_at->diffForHumans()
                                      ];
                                  })
        ]);
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }
}