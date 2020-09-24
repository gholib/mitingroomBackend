<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/24/2020
 * Time: 12:21 PM
 */

namespace App\Modules\Users\UseCases;


use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyEmail
{
    public static function sendVerificationLink(string $email, string $template = 'emails.verify_email')
    {
        $user = User::where('email', $email)->first();

        $token = Str::random(40);

        $user->verify_token = $token;
        $user->update();

        return self::sendLink($user, $token, $template);
    }


    public static function sendLink ($user, $token, $template = 'emails.verify_email', $subject = 'Забыли пароль?') :bool
    {
        try{
            Mail::send($template, [
                'title' => $user->name,
                'content' => env('APP_URL') . '/api/auth/verify_email/' . trim($user->email). '/' . trim($token)
            ], function ($message) use ($subject, $user) {
                $message->to($user->email)->subject($subject);
            });
        }
        catch(\Exception $e){
            return false;
        }
        return true;
    }

    public static function verifyAccount(User $user)
    {
        $user->verify_token = null;
        $user->verified = 1;

        return $user->update();
    }
}