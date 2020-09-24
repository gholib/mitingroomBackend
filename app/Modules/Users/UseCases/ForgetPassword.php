<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/24/2020
 * Time: 11:00 AM
 */

namespace App\Modules\Users\UseCases;


use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPassword
{
    public function forgotPassword(string $email, string $template = 'emails.forgot_password', string $subject = 'Забыли пароль?')
    {
        $user = User::where('email', $email)->first();

        $token = Str::random(40);

        $user->reset_password_token = $token;
        $user->update();

        return self::forgotPasswordMail($user, $token, $template,  $subject);
    }

    public static function forgotPasswordMail ($user, $token, $template = 'emails.forgot_password', $subject = 'Забыли пароль?') :bool
    {
        try{
            Mail::send($template, [
                'title' => $user->name,
                'content' => env('FRONTEND_URL') . '/reset-password/' . trim($user->email). '/' . trim($token)
            ], function ($message) use ($subject, $user) {
                $message->to($user->email)->subject($subject);
            });
        }
        catch(\Exception $e){
            return false;
        }
        return true;
    }

    public function resetPassword (array $data) :bool
    {
        $user = User::where('email', $data['email'])->first();
        $user->reset_password_token = null;
        $user->password = bcrypt($data['password']);

        return $user->save();
    }
}