<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\NotificationMethods;
use App\Http\Resources\Api\LiveResource;
use App\Http\Resources\Api\OrderResource;
use App\Models\live_service;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt,DB;
use App\User;
use App\Interfaces\HandleDataInterface;
class OrderController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function looking_for_wench(Request $request)
    {
        //TODO verfied
        $user=User::where('type','winch');
        $user = $user->select(DB::raw('*, ( 6367 * acos( cos( radians('.$request->location_lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$request->location_lng.') ) + sin( radians('.$request->location_lat.') )* sin( radians( lat ) ) ) ) AS distance'))
            ->having('distance', '<', get_seetings()->search_distance)
            ->orderBy('distance')->first();
            if(is_null($user))
            {
                $msg=getUserLang()=='ar' ? 'عفوا ....لا يوجد ونش متوفر حاليا' : 'Sorry, No winch available at the moment';
                return $this->apiResponseMessage(0,$msg,200);
            }
        $validate_order=$this->validate_order($request);
        if(isset($validate_order))
        {
            return $validate_order;
        }
        $order=new Order();
        $order->user_id=Auth::user()->id;
        $order->location_lat=$request->location_lat;
        $order->location_lng=$request->location_lng;
        $order->location_address=$request->location_address;
        $order->destination_lat=$request->destination_lat;
        $order->destination_lng=$request->destination_lng;
        $order->destination_address=$request->destination_address;
        $order->eta='60 min';
        $order->cost='80 $';
        $order->status=1;
        $order->winch_id=$user->id;
        $order->save();
       $this->calluate_distance($order,$request);
        $msg=getUserLang() == 'ar' ? 'تم اضافة الطلب' : 'order added successfully';
        $title=$user->lang=='ar' ? 'طلب جديد'  : 'new order';
        $desc=$user->lang=='ar' ? 'طلب جديد لخدمتك '  : 'A customer has requested your service';
        NotificationMethods::senNotificationToSingleUser($user->firebase_token,$title,$desc,null,1,$order->id);
        return $this->apiResponseData(new OrderResource($order),$msg,200);
    }


    private function calluate_distance($order,$request)
    {
        $bna = new POI($request->location_lat,$request->location_lng); // Nashville International Airport
        $lax = new POI($request->destination_lat, $request->destination_lng); // Los Angeles International Airport
        $distance= $bna->getDistanceInMetersTo($lax);

    }


    /**
     * @param Request $request
     * @param $order_id
     * @param HandleDataInterface $handleData
     * @return mixed
     */
    public function single_order(Request $request,$order_id,HandleDataInterface $handleData)
    {
        return $handleData->getSingleDsta(new Order(),$order_id,$request,new OrderResource(null));
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function validate_order($request)
    {
        $lang=getUserLang();
        $input = $request->all();
        $validationMessages = [
            'location_lat.required' => $lang == 'ar' ?  'من فضلك ادخل خط طول السيارة' :"location lat is required" ,
            'location_lng.required' => $lang == 'ar' ?  'من فضلك ادخل خط عرض السيارة' :"location long is required" ,
            'location_address.required' => $lang == 'ar' ?  'من فضلك ادخل خط عنوان السيارة' :"Car address is required" ,
            'destination_lat.required' => $lang == 'ar' ?  'من فضلك ادخل خط طول وجهتك' :"destination lat is required" ,
            'destination_lng.required' => $lang == 'ar' ?  'من فضلك ادخل خط عرض وجهتك' :"destination long is required" ,
            'destination_address.required' => $lang == 'ar' ?  'من فضلك ادخل خط عنوان وجهتك' :"destination address is required" ,

        ];

        $validator = Validator::make($input, [
            'location_lat' => 'required',
            'location_lng' => 'required',
            'location_address' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
            'destination_address' => 'required',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function change_status($order_id,Request $request)
    {

        $order=Order::find($order_id);
        if(is_null($order))
        {
            $this->not_found_v2(getUserLang());
        }
        $status_valuss=[2,3,4];
        if(!in_array($request->status,$status_valuss)){
            $msg=getUserLang()=='ar' ? 'الحالات المطلوبة يجب ان تكون 2,3,4' : 'you can only send the following statuses 2.3,4';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $order->status=$request->status;
        $order->save();
        $msg=$this->send_notifcation($order);
        return $this->apiResponseData(new OrderResource($order),$msg,200);
    }

    /**
     * @param $order
     * @return string
     */
    private function send_notifcation($order)
    {
        $user=User::find($order->user_id);
        if($order->status == 2) {
            $msg = getUserLang() == 'ar' ? 'تم قبول الطلب' : 'order accepted successfully';
            $title = $user->lang == 'ar' ? 'تم قبول الطلب' : 'order accepted successfully';
            $desc=$user->lang == 'ar' ? $order->id.'تم قبول الطلب رقم ' : 'order number '.$order->id.' accepted successfully';
        }elseif($order->status == 4)
        {
            $msg = getUserLang() == 'ar' ? 'تم اكتمال الطلب' : 'order completed successfully';
            $title = $user->lang == 'ar' ? 'تم اكتمال الطلب' : 'order completed successfully';
            $desc=$user->lang == 'ar' ? $order->id.'تم اكتمال الطلب رقم ' : 'order number '.$order->id.' completed successfully';
        }elseif($order->status == 3){
            $msg = getUserLang() == 'ar' ? 'تم رفض الطلب' : 'order rejected successfully';
            $title = $user->lang == 'ar' ? 'تم رفض الطلب' : 'order rejected successfully';
            $desc=$user->lang == 'ar' ? 'وجاري البحث عن ونش اخر ' .$order->id.'تم رفض الطلب رقم '
                : 'order number '.$order->id.' rejected .... searching for another winch ';

        }
        NotificationMethods::senNotificationToSingleUser($user->firebase_token, $title, $desc, null, 1, $order->id);
        return $msg;
    }


    public function my_orders()
    {
        $user=Auth::user();
        $orders=Order::where('winch_id',$user->id)->where('status',1)->get();
        return $this->apiResponseData(OrderResource::collection($orders),$this->Message(getUserLang(),3),200);
    }



}