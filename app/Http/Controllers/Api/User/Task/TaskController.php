<?php

namespace App\Http\Controllers\Api\User\Task;

use App\Support\APIResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Task\StoreTaskRequest;
use App\Http\Resources\Api\Task\TaskResource;
use App\Services\Api\User\Task\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService  $taskService) {}

    public function index()
    {
        $tasks = $this->taskService->getAll();
        return (new APIResponse())
            ->setData(TaskResource::collection($tasks))
            ->addAttribute("paginate", api_model_set_paginate($tasks))
            ->isOk()
            ->build();
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->taskService->store($request);
    }

    public function show($id) {}

    // Update the specified task
    public function update(Request $request, $id) {}

    // Remove the specified task
    public function destroy($id) {}
}
