<?php

namespace App\Http\Controllers\Admin\UserSettings;

use App\Enum\ActivationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\SearchUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\UserSettings\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    // public function index()
    // {
    //     $users = $this->userService->getAll();
    //     $status = ActivationStatusEnum::cases();
    //     return view('dashboard.pages.users.index', compact('users', 'status'));
    // }

    // public function search(SearchUserRequest $request)
    // {
    //     $users = $this->userService->filterUsers($request);
    //     $status = ActivationStatusEnum::cases();
    //     return view('dashboard.pages.users.index', compact('users', 'status'));
    // }

    // public function edit(User $user)
    // {
    //     return view('dashboard.pages.users.edit', compact('user'));
    // }

    // public function update(UpdateUserRequest $request, User $user)
    // {
    //     return $this->userService->updateUser($request, $user);
    // }

    // public function editStatus(User $user)
    // {
    //     $this->userService->updateStatus($user);
    //     return back()
    //         ->with('Success', __('admin.updated_successfully'));
    // }

    // public function delete(User $user)
    // {
    //     $this->userService->deleteUser($user);
    //     return back()
    //         ->with('Success', __('admin.deleted_successfully'));
    // }
}
