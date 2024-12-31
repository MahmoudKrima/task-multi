<?php

namespace App\Services\Api\User\Task;

use App\Models\Task;



class TaskService
{

    function getAll()
    {
        $admin = auth('api_admin')->user();
        if (!$admin->hasRole('employee')) {
            return Task::with('creator', 'users', 'attachments')
                ->orderBy('id', 'desc')
                ->paginate();
        } else {
            return Task::where('created_by', $admin->id)
                ->orWhereHas('users', function ($q) use ($admin) {
                    $q->where('user_id', $admin->id);
                })
                ->with('creator', 'users', 'attachments')
                ->distinct()
                ->orderBy('id', 'desc')
                ->paginate();
        }
    }
}
