<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Show notifications list
     *
     * @return 
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $notifications = Auth::user()
            ->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('notifications', compact('notifications'));
    }

    /**
     * Make notification as read by ajax 
     *
     * @param string $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(string $id): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $notification = Auth::user()->notifications()->find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json(['message' => 'Notification marked as read successfully'], 200);
    }
}
