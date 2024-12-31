<?php

namespace App\Services\Api\User\Task;

use App\Models\Task;
use App\Models\Admin;
use App\Traits\ImageTrait;
use App\Support\APIResponse;
use App\Events\TaskReminderEvent;
use App\Http\Resources\Api\Task\TaskResource;
use App\Notifications\DueDateReminderNotification;



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

    function store($request)
    {
        $data = $request->validated();
        if(!auth('api_admin')->user()->hasRole('employee') && !isset($data['users'])){
            return (new APIResponse())
                ->isError(__("api.users_required"))
                ->setErrors(['validations' => __("api.users_required")])
                ->build();
        }
        $data['created_by'] = auth('api_admin')->id();
        $task = Task::create($data);

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                $file = ImageTrait::uploadImageS3($attachment, 'uploads/Admin/Task/Attachments');
                $task->attachments()->create([
                    'attachment' => $file,
                ]);
            }
        }
        $admin = auth('api_admin')->user();
        activity()
            ->causedBy($admin)
            ->log($admin->name . ' Created New Task : ' . $task->title);

        if (isset($data['users']) && auth('api_admin')->user()->hasAnyPermission(['task.assign'])) {
            $task->users()->sync($data['users']);
            foreach ($data['users'] as $userId) {
                $user = Admin::find($userId);
                if ($user) {
                    $data = [
                        'user_id' => $user->id,
                        'title' => "New Task",
                        'due_date' => $task->due_date,
                        'message' => "New Task Has Been Assigned To You By " . $admin->name,
                    ];
                    $user->notify(new DueDateReminderNotification($data));
                    event(new TaskReminderEvent($data));
                }
            }
        } else {
            $task->users()->sync($admin->id);
        }

        return (new APIResponse())
        ->setData(['task' => new TaskResource($task)])
        ->setStatusOK()
        ->build();
    }
}
