<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminNotification extends Component
{
    public $notifications;
    public $totalNotifications;

    public function __construct()
    {
        $adminId = Auth::guard('admin')->id();
        $this->notifications = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        $this->totalNotifications =  DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $adminId)
            ->count();
    }

    public function render()
    {
        return view('components.admin-notification');
    }
}
