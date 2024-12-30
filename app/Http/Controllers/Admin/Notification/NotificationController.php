<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth('admin')->user()->notifications()->latest()->take(4)->get();
        $totalNotifications = auth('admin')->user()->unreadNotifications->count();

        return response()->json([
            'total' => $totalNotifications,
            'notifications' => $notifications
        ]);
    }

    public function showAll()
    {
        $notifications = auth('admin')->user()->notifications()->paginate();
        return view('dashboard.pages.notifications.index', compact('notifications'));
    }

    public function delete($id)
    {
        $notification = auth('admin')->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            auth('admin')->user()->notifications()->where('id', $id)->delete();
            return back()
                ->with('Success', __('admin.deleted_successfully'));
        }
        return back()
            ->with('Error', __('admin.not_found_data'));
    }

    public function deleteAll()
    {
        auth('admin')->user()->notifications()->delete();
        return redirect(route('admin.notifications.showAll'))
            ->with('Success', __('admin.deleted_successfully'));
    }
}
