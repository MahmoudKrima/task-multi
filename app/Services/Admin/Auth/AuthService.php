<?php

namespace App\Services\Admin\Auth;

use App\Models\Admin;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordAdminMail;

class AuthService
{
    private function getAdminByMail($email)
    {
        return Admin::where('email', $email)
            ->where('status', 'active')
            ->first();
    }

    function loginSubmit($email)
    {
        $admin = $this->getAdminByMail($email);
        Auth::guard('admin')
            ->login($admin);
    }

    function sendForgetPasswordMail($email)
    {
        $admin = $this->getAdminByMail($email);
        $otp = rand(100000, 999999);
        $subject  = 'Reset Password';
        $body = 'Enter This OTP To Reset Your Password : ' . $otp;
        Mail::to($admin)
            ->send(new ForgetPasswordMail($subject, $body));
        $admin->update([
            "otp"   => $otp
        ]);
    }

    function checkAdminForResetPassword($otp)
    {
        return Admin::where('otp', $otp)
            ->where('status', 'active')
            ->first();
    }

    function resetPassword($data, $otp)
    {
        $admin = $this->checkAdminForResetPassword($otp);
        $data['otp'] = null;
        $admin->update($data);
    }
}
