<?php

namespace App\Services\Admin\UserSettings;

use App\Filters\ActivationStatusFilter;
use App\Models\User;
use App\Filters\NameFilter;
use App\Filters\PhoneFilter;
use App\Traits\ImageTrait;
use Illuminate\Pipeline\Pipeline;

class UserService
{
    use ImageTrait;

    function getAll()
    {
        return User::orderBy('id', 'desc')
            ->paginate();
    }

    function filterUsers($request)
    {
        $request->validated();
        return app(Pipeline::class)
            ->send(User::query())
            ->through([
                NameFilter::class,
                PhoneFilter::class,
                ActivationStatusFilter::class,
            ])
            ->thenReturn()
            ->orderBy('id', 'desc')
            ->paginate()
            ->withQueryString();
    }

    function updateUser($request, $user)
    {
        $data = $request->validated();
        $data['image'] = ImageTrait::updateImage($user->image, 'uploads/users/profile', 'image');
        $user->update($data);
        return back()
            ->with('Success', __('admin.updated_successfully'));
    }

    function updateStatus($user)
    {
        if ($user->status->value == 'active') {
            $user->update([
                'status' => 'deactive',
            ]);
            // if ($user->app_locale == 'ar') {
            //     $notification['title'] = 'تم حظر عضويتك يا: ' . ' ' . $user->name;
            //     $notification['body'] = 'قامت إدارة تطبيق: ' . ' ' . app('settings')['app_name'] . ' ' . 'بحظر عضويتك لانتهاك سياسة استخدام التطبيق';
            // } else {
            //     $notification['title'] = 'Your Account is Blocked, ' . ' ' . $user->name;
            //     $notification['body'] = 'Admin of: ' . ' ' . app('settings')['app_name'] . ' ' . 'Blocked Your account Because violation of application usage policy';
            // }

            // (new \App\Support\FireBase)->setTitle($notification["title"])->setBody($notification["body"])->setTargetScreen("login_page")->setTargetId("0")->setToken($user->fc_token)->build();
        } else {
            $user->update([
                'status' => 'active',
            ]);

            // if ($user->app_locale == 'ar') {
            //     $notification['title'] = 'تم إعادة تنشيط عضويتك يا: ' . ' ' . $user->name;
            //     $notification['body'] = 'قامت إدارة تطبيق: ' . ' ' . app('settings')['app_name'] . ' ' . 'بإعادة تنشيط حسابك ، الرجاء الالتزام بسياسة استخدام التطبيق لتجنب الحظر مرة أخرى';
            // } else {
            //     $notification['title'] = 'Your Account is Activated, ' . ' ' . $user->name;
            //     $notification['body'] = 'Admin of : ' . ' ' . app('settings')['app_name'] . ' ' . 'Activated Your Account, Please respect app usage ploicy';
            // }

            // (new \App\Support\FireBase)->setTitle($notification["title"])->setBody($notification["body"])->setTargetScreen("user_home")->setTargetId("0")->setToken($user->fc_token)->build();
        }
        return back()
            ->with('Success', __('admin.updated_successfully'));
    }

    // function deleteUser(User $user)
    // {
    //     Storage::disk('public')->delete($user->image);
    //     $user->delete();
    // }
}
