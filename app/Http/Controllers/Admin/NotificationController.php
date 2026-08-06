<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('admin.notifications', compact('notifications'));
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->each->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function read(Request $request, string $notification)
    {
        if ($n = auth()->user()->notifications()->find($notification)) {
            $n->markAsRead();
        }
        return back();
    }

    // Helper to send system notifications (database)
    public static function notifyAdmins(string $title, string $message): void
    {
    }
}