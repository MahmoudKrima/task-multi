<?php

namespace App\Http\Controllers\Admin\Home;

use App\Models\Task;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();

        if (!auth()->guard('admin')->user()->hasRole('employee')) {
            $data['total_tasks'] = Task::select('status', DB::raw('count(*) as count'))
                ->with('creator', 'users', 'attachments')
                ->groupBy('status')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->status->lang() => $item->count];
                })
                ->toArray();

            $data['total_low'] = Task::where('priority', 'low')
                ->with('creator', 'users', 'attachments')
                ->count();
            $data['total_medium'] = Task::where('priority', 'medium')
                ->with('creator', 'users', 'attachments')
                ->count();
            $data['total_high'] = Task::where('priority', 'high')
                ->with('creator', 'users', 'attachments')
                ->count();

            $data['chart2'] = [
                'statusLabels' => [__('admin.low'), __('admin.medium'), __('admin.high')],
                'statusCounts' => [$data['total_low'], $data['total_medium'], $data['total_high']]
            ];

            $data['adminsWithTaskCount'] = Admin::whereHas('tasks')
                ->select('name', 'image')
                ->withCount('tasks')
                ->with('tasks')
                ->limit(8)
                ->get();

            $data['tasksDueDate'] = Task::with('creator', 'users', 'attachments')
                ->orderBy('id', 'desc')
                ->limit(8)
                ->get();
        } else {
            $data['total_tasks'] = Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->with('creator', 'users', 'attachments')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->status->lang() => $item->count];
                })
                ->toArray();

            $data['total_low'] = Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->where('priority', 'low')
                ->with('creator', 'users', 'attachments')
                ->count();
            $data['total_medium'] = Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->where('priority', 'medium')
                ->with('creator', 'users', 'attachments')
                ->count();
            $data['total_high'] = Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->where('priority', 'high')
                ->with('creator', 'users', 'attachments')
                ->count();

            $data['chart2'] = [
                'statusLabels' => [__('admin.low'), __('admin.medium'), __('admin.high')],
                'statusCounts' => [$data['total_low'], $data['total_medium'], $data['total_high']]
            ];

            $data['tasksDueDate'] = Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->with('creator', 'users', 'attachments')
                ->orderBy('id', 'desc')
                ->limit(8)
                ->get();
        }
        return view('dashboard.pages.home.index', compact('data'));
    }
}
