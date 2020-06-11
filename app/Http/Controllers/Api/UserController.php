<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\Http\Resources\Api\UserResource;
use App\User;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Controllers\Manage\EmailsController;

class UserController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /*
     * @pram request array
     * @return  response()->json
     */

    public function register(Request $request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'username.required' => $lang == 'ar' ?  'من فضلك ادخل اسم المستخدم' :"username is required" ,
            'username.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'password.required' => $lang == 'ar' ? 'من فضلك ادخل كلمة السر' :"password is required"  ,
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' :"email is required"  ,
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' :"email is already teken" ,
            'email.regex'=>$lang=='ar'? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
            'phone.required' => $lang == 'ar' ? 'من فضلك ادخل رقم الهاتف' :"phone is required"  ,
            'phone.unique' => $lang == 'ar' ? 'رقم الهاتف موجود لدينا بالفعل' :"phone is already teken" ,
            'phone.min' => $lang == 'ar' ?  'رقم الهاتف يجب ان لا يقل عن 7 ارقام' :"The phone must be at least 7 numbers" ,
            'password.min' => $lang == 'ar' ?  'كلمة السر يجب ان لا يقل عن 6 احرف او ارقام' :"The password must be at least 6 character" ,
            'phone.numeric' => $lang == 'ar' ?  'رقم الهاتف يجب ان يكون رقما' :"The phone must be a number" ,
            'type.required' => $lang == 'ar' ? 'من فضلك ادخل نوع المستخدم' :"type is required"  ,
            'type.in' => $lang == 'ar' ?  'القيمة المدخلة غير صحيحة' :"The selected amount type is invalid" ,
        ];

        $validator = Validator::make($input, [
            'username' => 'required|min:3',
            'type' => 'required|in:user,winch',
            'phone' => 'required|unique:users|min:7|numeric',
            'email' => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|min:6',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }

        $user = new User();
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->type = $request->type;
        $user->lat  = $request->lat;
        $user->lng  = $request->lng;
        $user->status  = 0;
        $user->lang=$lang;
        $user->password = Hash::make($request->password);
        if($request->firebase_token) {
            $user->firebase_token = $request->firebase_token;
        }
        $user->save();
        $token = $user->createToken('TutsForWeb')->accessToken;
        $user['token']=$token;
        EmailsController::verify_email($user->id);
        $msg=$lang == 'ar' ? 'تم التسجيل بنجاح' : 'register success';
        return $this->apiResponseData(new UserResource($user),$msg,200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resend_code(Request $request)
    {
        $user=Auth::user();
        $lang=$user->lang;
        if($user->status == 1){
            $msg=$lang == 'ar' ? 'الحساب مفعل' : 'The account already verified';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $send_mail=EmailsController::verify_email($user->id);
        if($send_mail == 1)
        {
            $msg=$lang == 'ar' ? 'تم اعادة ارسال كود التفعيل بنجاح' : 'The activation code was successfully resent';
            return $this->apiResponseMessage(1,$msg,200);
        }
        $msg=$lang == 'ar' ? 'حدث خطا حاول مجددا' : 'Error...try again';
        return $this->apiResponseMessage(0,$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function check_code(Request $request)
    {
        $user=Auth::user();
        $lang=$user->lang;
        if($request->code == $user->code)
        {
            $user->code=null;
            $user->status=1;
            $user->save();
            $msg=$lang == 'ar' ? 'تم التفعيل بنجاح' : 'The account was successfully activation';
            return $this->apiResponseMessage(1,$msg,200);
        }
        $msg=$lang == 'ar' ? 'الكود غير مطابق' : 'code mismatch';
        return $this->apiResponseMessage(0,$msg,200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function change_lang(Request $request)
    {
        $user=Auth::user();
        $lang=$request->lang;
        $langs=['ar','en'];
        if(!in_array($request->lang,$langs))
        {
            $msg=$lang == 'ar' ? 'اللغه غير موجودة' : 'language not found';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $user->lang=$request->lang;
        $user->save();
        $msg=$lang == 'ar' ? 'تم تغيير اللغه بنجاح' : 'language changed successfully';
        return $this->apiResponseMessage(1,$msg,200);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $lang = $request->header('lang');
        $user=User::where('phone',$request->emailOrPhone)->first();
        if(is_null($user))
        {
            $user=User::where('email',$request->emailOrPhone)->first();
            if(is_null($user))
            {
                $msg=$lang=='ar' ?  'البيانات المدخلة غير موجودة لدينا ':'user not exist' ;
                return $this->apiResponseMessage( 0,$msg, 200);
            }
        }
        $password=Hash::check($request->password,$user->password);
        if($password==true){
            $token = $user->createToken('TutsForWeb')->accessToken;
            if($request->firebase_token)
            {
                $user->firebase_token=$request->firebase_token;
                $user->save();
            }
            $user['token']=$token;
            $msg=$lang=='ar' ? 'تم تسجيل الدخول بنجاح':'login success' ;
            return $this->apiResponseData(new UserResource($user),$msg,200);
        }

        $msg=$lang=='ar' ?  'كلمة السر غير صحيحة' :'Password is not correct' ;
        return $this->apiResponseMessage( 0,$msg, 400);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        $user = Auth::user();
        $lang = $user->lang;
        $check=$this->not_found($user,'العضو','user',$lang);
        if(isset($check))
        {
            return $check;
        }
        if(!$request->newPassword){
            $msg=$lang=='ar' ? 'يجب ادخال كلمة السر الجديدة' : 'new password is required';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $password=Hash::check($request->oldPassword,$user->password);
        if($password==true){
            $user->password=Hash::make($request->newPassword);
            $user->save();
            $msg=$lang=='ar' ? 'تم تغيير كلمة السر بنجاح' : 'password changed successfully';
            return $this->apiResponseMessage( 1,$msg, 200);

        }else{
            $msg=$lang=='ar' ? 'كلمة السر القديمة غير صحيحة' : 'invalid old password';
            return $this->apiResponseMessage(0,$msg, 401);

        }
    }
    /*
     * Edit user
     * @pram old passsword , newpassword
    */


    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        $id=Auth::user()->id;
        $lang = $user->lang;
        $input = $request->all();
        $validationMessages = [
            'username.required' => $lang == 'ar' ?  'من فضلك ادخل اسم المستخدم' :"username is required" ,
            'username.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 5 احرف' :"The username must be at least 5 character" ,
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' :"email is required"  ,
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' :"email is already teken" ,
            'email.regex'=>$lang=='ar'? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
            'phone.required' => $lang == 'ar' ? 'من فضلك ادخل رقم الهاتف' :"phone is required"  ,
            'phone.unique' => $lang == 'ar' ? 'رقم الهاتف موجود لدينا بالفعل' :"phone is already teken" ,
            'phone.min' => $lang == 'ar' ?  'رقم الهاتف يجب ان لا يقل عن 7 ارقام' :"The phone must be at least 7 numbers" ,
            'phone.numeric' => $lang == 'ar' ?  'رقم الهاتف يجب ان يكون رقما' :"The phone must be a number" ,
        ];

        $validator = Validator::make($input, [
            'phone' => 'required|min:7|numeric|unique:users,phone,'.$id,
            'email' => 'required|unique:users,email,'.$id.'|regex:/(.+)@(.+)\.(.+)/i',
            'username' => 'required|min:5',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }


        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->lat  = $request->lat;
        $user->lng  = $request->lng;
        $user->lang=$lang;
        $user->save();
        $user['token']=null;
        $msg=$lang=='ar' ?  'تم تعديل البيانات بنجاح' :'your data edited successfully' ;
        return $this->apiResponseData(  new UserResource($user),  $msg,200);
    }

    /*
     * get user information from token auth
     */
    public function my_info(Request $request)
    {
        $lang = $request->header('lang');
        $user=Auth::user();
        $user['token']=null;
        $msg=$lang=='ar' ?  'تمت العملية بنجاح' :'success' ;
        return $this->apiResponseData(new UserResource($user),$msg);
    }


    /*
     *@pram Email to check exist in database
     *@return  if exist send code to email , not exist sent error message
     */

    public function forget_password(Request $request){
        $lang=$request->header('lang');
        $user=User::where('email',$request->email)->first();
        $check=$this->not_found($user,'البريد الالكتروني','Email Address',$lang);
        if(isset($check)){
            return $check;
        }
        $lang=$user->lang;
        $code=mt_rand(999,9999);
        $user->code=$code;
        $user->save();
        EmailsController::forget_password($user,$lang);
        $msg=$lang=='ar' ? 'تفحص بريدك الالكتروني' : 'check your mail';
        return $this->apiResponseMessage(1,$msg,200);
    }

    /*
     * @pram code , new password
     * @return if code incorrect error message , elseif correct change password successfully
     */
    public function reset_password(Request $request)
    {
        $lang=$request->header('lang');
        if(!$request->code){
            $msg=$lang=='ar' ? 'من فضلك ادخل الكود' : 'code is required';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $user=User::where('code',$request->code)->first();
        if(is_null($user)){
            $msg=$lang=='ar' ? 'الكود غير صحيح' : 'code is incorrect';
            return $this->apiResponseMessage(0,$msg,200);
        }
        if(!$request->password){
            $msg=$lang=='ar' ? 'من فضلك ادخل كلمة السر الجديدة' : 'new password is required';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $lang=$user->lang;
        $user->password=Hash::make($request->password);
        $user->code=null;
        $user->save();
        $msg=$lang=='ar' ? 'تم تغيير كلمة السر بنجاح' : 'password changed successfully';
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $lang=$request->header('lang');
        $user=Auth::user();
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });
        $msg=$lang=='ar' ? 'تم تسجيل الخروج بنجاح' : 'logout successfully';
        return $this->apiResponseMessage(1,$msg,200);
    }

    public function delete_user($id)
    {
        User::where('id',$id)->delete();
        $msg= 'deleted successfully';
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function active_winch(Request $request)
    {
        $user=Auth::user();
        $user->active=$request->active;
        $user->save();
        $msg= getUserLang() == 'ar' ? 'تم تعديل الحالة بنجاح' : 'active edited successfully';
        return $this->apiResponseMessage(1,$msg,200);

    }

}