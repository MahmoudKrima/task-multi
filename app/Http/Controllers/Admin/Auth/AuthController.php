<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\Auth\AuthService;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Http\Requests\Admin\Auth\ForgetPasswordRequest;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function loginForm()
    {
        return view('dashboard.pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::guard('admin')->attempt($data)) {
            $this->authService->loginSubmit($data['email']);
            return redirect()
                ->route('admin.dashboard.index');
        }
        return back()
            ->with('Error', __('admin.wrong_password'));
    }

    public function forgetPasswordForm()
    {
        return view('dashboard.pages.auth.forget_password');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $data = $request->validated();
        try {
            $this->authService->sendForgetPasswordMail($data['email']);
            return redirect()
                ->route('auth.resetPassword')
                ->with('Success', __('admin.otp_send_successfully'));
        } catch (\Exception $e) {
            return back()
                ->with('Error', __('admin.try_agian_later'));
        }
    }

    public function resetPassword()
    {
        return view('dashboard.pages.auth.reset_password');
    }

    public function resetPasswordSubmit(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $this->authService->resetPassword($data, $data['otp']);
        return redirect()
            ->route('auth.loginForm')
            ->with('Success', __('admin.password_restored_successfully'));
    }

    public function logout()
    {
        Auth::guard('admin')
            ->logout();
        return redirect()
            ->route('auth.loginForm');
    }
}
