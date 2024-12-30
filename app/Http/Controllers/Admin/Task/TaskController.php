<?php

namespace App\Http\Controllers\Admin\Task;

use App\Enum\TaskStatusEnum;
use Illuminate\Http\Request;
use App\Enum\TaskPriorityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\SearchTaskRequest;
use App\Http\Requests\Admin\Task\StoreTaskRequest;
use App\Http\Requests\Admin\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Admin\Task\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index()
    {
        $tasks = $this->taskService->getAll();
        $creators = $this->taskService->getCreators();
        $status = TaskStatusEnum::cases();
        $priorites = TaskPriorityEnum::cases();
        return view('dashboard.pages.task.index', compact('tasks', 'status', 'priorites', 'creators'));
    }

    public function search(SearchTaskRequest $request)
    {
        $tasks = $this->taskService->filter($request);
        $status = TaskStatusEnum::cases();
        $priorites = TaskPriorityEnum::cases();
        $creators = $this->taskService->getCreators();
        return view('dashboard.pages.task.index', compact('tasks', 'status', 'priorites', 'creators'));
    }

    public function show(Task $task)
    {
        $task = $this->taskService->show($task);
        $status = TaskStatusEnum::cases();
        $priorites = TaskPriorityEnum::cases();
        return view('dashboard.pages.task.show', compact('task', 'priorites', 'status'));
    }

    public function create()
    {
        $status = TaskStatusEnum::cases();
        $priorites = TaskPriorityEnum::cases();
        $users = $this->taskService->getUsers();
        return view('dashboard.pages.task.create', compact('status', 'priorites', 'users'));
    }

    public function store(StoreTaskRequest $request)
    {
        $this->taskService->store($request);
        return back()
            ->with("Success", __('admin.created_successfully'));
    }

    public function edit(Task $task)
    {
        $admin = auth('admin')->user();
        if (!$admin->hasRole('admin') && !$admin->hasRole('manager') && $admin->id != $task->created_by) {
            return back()
                ->with("Error", __('admin.cant_update'));
        }
        $status = TaskStatusEnum::cases();
        $priorites = TaskPriorityEnum::cases();
        $users = $this->taskService->getUsers();
        return view('dashboard.pages.task.edit', compact('status', 'priorites', 'task', 'users'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $admin = auth('admin')->user();
        if (!$admin->hasRole('admin') && !$admin->hasRole('manager') && $admin->id != $task->created_by) {
            return back()
                ->with("Error", __('admin.cant_update'));
        }
        $this->taskService->update($request, $task);
        return back()
            ->with("Success", __('admin.updated_successfully'));
    }

    public function updateStatus(Task $task)
    {
        $this->taskService->updateStatus($task);
        return back()
            ->with("Success", __('admin.updated_successfully'));
    }

    public function delete(Task $task)
    {
        $admin = auth('admin')->user();
        if (!$admin->hasRole('admin') && !$admin->hasRole('manager') && $admin->id != $task->created_by) {
            return back()
                ->with("Error", __('admin.cant_delete'));
        }
        $this->taskService->delete($task);
        return back()
            ->with("Success", __('admin.deleted_successfully'));
    }
}
