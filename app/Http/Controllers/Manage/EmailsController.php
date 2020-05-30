<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth, File, Mail, Crypt;
use App\Models\Produc_view_user;

class EmailsController extends Controller
{

    /**
     * @param $user_id
     * @param $lang
     * @return int
     */

    public static function verify_email($user_id)
    {
        $user = User::find($user_id);
        $lang=$user->lang;
        $email = $user->email;
        $subject = $lang == 'ar' ? "verify your account" : 'تاكيد حسابك';
        $code = mt_rand(999, 9999);
        $user->code=$code;
        $user->save();
        $data = [];
        $data['code'] = $code;
        $data['language'] = $lang;

        $name = $user->name;
        Mail::send('emails.verify_email', $data, function ($mail) use ($email, $name, $subject) {
            $mail->to($email, $name);
            $mail->subject($subject);
        });

        return 1;
    }

    /*
     * @pram emal , code
     * send code to email to use it to change forget password
     */

    public static function forget_password($user, $lang)
    {
        $subject = $lang == 'ar' ? 'اعادة كلمة السر' : "reset password";
        $email = $user->email;
        $data = [];
        $data['code'] = $user->code;
        $data['language'] = $lang;

        $name = $user->username;
        Mail::send('emails.forget_password', $data, function ($mail) use ($email, $name, $subject) {
            $mail->to($email, $name);
            $mail->subject($subject);
        });

        return 1;
    }

}
