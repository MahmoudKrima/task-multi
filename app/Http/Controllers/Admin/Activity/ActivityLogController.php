<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $activities = Activity::query()
            ->with(['causer', 'subject'])
            ->whereHas('causer', function ($query) {
                $query->where('tenant_id', tenant('id'));
            })
            ->latest()
            ->paginate(10);
        return view('dashboard.pages.activity.index', compact('activities'));
    }
}
