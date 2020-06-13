<?php
namespace App\Http\Controllers\Api;
use App\Models\Order;
use App\Models\email;
use Mail;
use App\User;
use App\Models\notification;
use Kreait\Firebase\Messaging\CloudMessage;

define('API_ACCESS_KEY', 'AAAASwSSKjc:APA91bHdk2U8Fb1YFdngyEKxt3zEWN54THHS1oLkhMPJ55RsifIAU4VmpXkMAWySsqBSxZZOquftiZSoyKNS6xNL9OIJCc_ejWDHZBtG3fV4QkP9ruYix0_fkw1DTQ6HrozVGH7EtHCz');

class NotificationMethods
{
    public static function senNotificationToSingleUser($token, $title, $desc, $img,$click_actione,$redirect_id)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = array
                        (
            'body'  => $desc,
            'title'     => $title,
            'image'=>"$img",
            'vibrate'   => 1,
            'sound'     => 1,
            'click_action'=>$click_actione,
            'status'=>$click_actione,
            'redirect_id'=>$redirect_id,
            );
        $fields = array(
            'to' => $token,
            'data' => $msg,
            'notification' => $msg,
           
        );
        $headers = array(
            'Authorization: key='.API_ACCESS_KEY,
            'Content-type: Application/json'
        );
        try{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        } catch(Exeption $e){
            return $e ;
        }

        return $result ;
    }


    public static function senNotificationToMultiUsers($title, $desc, $img ,$id ,$click_action)
    {
        $usersTokens=User::pluck('fire_base_token')->toArray();
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = array
                        (
            'body'  => $desc,
            'title'     => $title,
            'image'=>"$img",
            'vibrate'   => 1,
            'sound'     => "1",
            'click_action'=>(string)$click_action,
            'status'=>(string)$click_action,
            'redirect_id'=>$id,

        );

        $fields = array(
            'registration_ids' => $usersTokens,
            'data' => $msg,
            'notification' => $msg,

        );
        $headers = array(
            'Authorization: key='.API_ACCESS_KEY,
            'Content-type: Application/json'
        );
        try{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        } catch(Exeption $e){
            return $e ;
        }

        return $result ;
    }


    public static function saveNotification($title_ar,$title_en,$desc_ar,$desc_en,$image,$user_id,$tobic)
    {
        $notification=new notification;
        $notification->title_ar=$title_ar;
        $notification->title_en=$title_en;
        $notification->desc_ar=$desc_ar;
        $notification->desc_en=$desc_en;
        $notification->user_id=$user_id;
        $notification->tobic=$tobic;
        $notification->save();
    }
}
