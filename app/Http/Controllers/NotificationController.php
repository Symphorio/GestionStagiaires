<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
public function check()
{
    $user = auth('stagiaire')->user();
    
    // Récupère les 10 dernières notifications (lus + non lus)
    $notifications = Notification::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

    // Compte seulement les non lus
    $unreadCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->count();

    return response()->json([
        'count' => $unreadCount,
        'notifications' => $notifications,
        'hasNew' => $unreadCount > 0,
        'lastChecked' => now()->toDateTimeString()
    ]);
}
    
    public function markAsRead(Request $request)
    {
        $user = auth('stagiaire')->user();
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
}