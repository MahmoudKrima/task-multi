<?php

namespace App\Services\Admin\Task;

use App\Models\Task;
use App\Models\Admin;
use App\Traits\ImageTrait;
use App\Filters\TitleFilter;
use App\Filters\TaskStatusFilter;
use Illuminate\Pipeline\Pipeline;
use App\Filters\TaskCreatorFilter;
use App\Filters\TaskDueDateFilter;
use App\Filters\TaskPriorityFilter;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    use ImageTrait;

    function getAll()
    {
        return Task::forAdmin()
            ->paginate();
    }

    function getCreators()
    {
        return Admin::with('activity', 'tasks', 'task_creator')
            ->whereHas('task_creator')
            ->get();
    }

    function getUsers()
    {
        return Admin::with('activity', 'tasks', 'task_creator')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'employee');
            })
            ->get();
    }

    function filter($request)
    {
        $request->validated();
        return app(Pipeline::class)
            ->send(Task::query())
            ->through([
                TitleFilter::class,
                TaskStatusFilter::class,
                TaskCreatorFilter::class,
                TaskPriorityFilter::class,
                TaskDueDateFilter::class,
            ])
            ->thenReturn()
            ->forAdmin()
            ->paginate()
            ->withQueryString();
    }

    public function show($task) {}

    function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth('admin')->id();
        $task = Task::create($data);

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                $file = ImageTrait::uploadImageS3($attachment, 'uploads/Admin/Task/Attachments');
                $task->attachments()->create([
                    'attachment' => $file,
                ]);
            }
        }
        $admin = auth('admin')->user();
        activity()
            ->causedBy($admin)
            ->log($admin->name . ' Created New Task : ' . $task->title);
        if (isset($data['users']) && auth('admin')->user()->hasAnyPermission(['task.assign'])) {
            $task->users()->sync($data['users']);
        } else {
            $task->users()->sync($admin->id);
        }
    }

    function update($request, $task)
    {
        $data = $request->validated();
        $task->update($data);
        if (isset($data['users']) && auth('admin')->user()->hasAnyPermission(['task.assign'])) {
            $task->users()->sync($data['users']);
        }
        $admin = auth('admin')->user();
        activity()
            ->causedBy($admin)
            ->log($admin->name . ' Updated Task : ' . $task->title);
    }

    function updateStatus($task)
    {
        $admin = auth('admin')->user();
        if ($task->status->value == 'pending') {
            $task->update([
                'status' => 'inprogress',
            ]);
            activity()
                ->name('Update Status')
                ->causedBy($admin)
                ->log($admin->name . ' Updated Task Status : ' . $task->title . ' To Inprogress ');
        } else {
            $task->update([
                'status' => 'completed',
            ]);
            activity()
                ->causedBy($admin)
                ->log($admin->name . ' Updated Task Status : ' . $task->title . ' To Completed ');
        }
    }


    function delete($task)
    {
        $admin = auth('admin')->user();
        activity()
            ->causedBy($admin)
            ->log($admin->name . ' Deleted Task : ' . $task->title);
        foreach ($task->attachments as $attachment) {
            Storage::disk('s3')->delete($attachment->attachment);
        }
        $task->delete();
    }
}
