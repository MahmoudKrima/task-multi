<?php

namespace App\Services\Api\User\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Traits\ImageTrait;
use App\Support\APIResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\User\UserResource;


class UserAuthService
{
    use ImageTrait;

    function userRegister($request)
    {
        $data = $request->validated();
        $data['status'] = 'active';
        if (!isset($data['image'])) {
            $data['image'] = app('settings')['logo'];
        } else {
            $data['image'] = ImageTrait::uploadImage($request->file('image'), 'admin/images');
        }
        $auth['user'] = Admin::create($data);
        $role = Role::where('name', 'employee')
            ->where('tenant_id', tenant('id'))
            ->first();
        $auth['user']->assignRole($role->name);
        $auth['token'] = $auth['user']->createToken('API Token')->plainTextToken;
        return (new APIResponse())
            ->setData(['user' => new UserResource($auth['user'])])
            ->addAttribute("token", $auth['token'])
            ->setStatusOK()
            ->build();
    }

    function login($request)
    {
        $data = $request->validated();
        $user = Admin::where('email', $data['email'])
            ->first();
        if (!$user) {
            return (new APIResponse())
                ->setErrors([
                    'email' => __('api.not_found')
                ])
                ->setStatusNotFound()
                ->build();
        } elseif ($user->status->value == 'blocked') {
            return (new APIResponse())
                ->setErrors([
                    'email' => __('api.blocked')
                ])
                ->setStatusNotFound()
                ->build();
        } else {
            if ($user || Hash::check($data['password'], $user->password)) {
                $auth['user'] = $user;
                $auth['token'] = $auth['user']->createToken('API Token')->plainTextToken;
                return (new APIResponse())
                    ->setData(['user' => new UserResource($auth['user'])])
                    ->addAttribute("token", $auth['token'])
                    ->setStatusOK()
                    ->build();
            } else {
                return (new APIResponse())
                    ->setErrors([
                        'password' => __('admin.wrong_password')
                    ])
                    ->setStatus(422)
                    ->build();
            }
        }
    }


    function userLogout()
    {
        $user = Auth::guard('admin')->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return (new APIResponse())
            ->setMessage(__('api.success_logout'))
            ->setStatusOK()
            ->build();
    }
}
