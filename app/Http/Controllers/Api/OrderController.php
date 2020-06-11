<?php

namespace App\Http\Controllers\Api;

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
     * @param HandleDataInterface $HandleDataInterface
     * @param $car_id
     * @return mixed
     */
    public function live_services(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $live_service=live_service::orderBy('id','desc');
        $live_service = $live_service->select(DB::raw('*, ( 6367 * acos( cos( radians('.$request->lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$request->lng.') ) + sin( radians('.$request->lat.') )* sin( radians( lat ) ) ) ) AS distance'))
            ->having('distance', '<', 50)
            ->orderBy('distance');
        return $HandleDataInterface->getAllData($live_service,$request,new LiveResource(null));
    }

    public function looking_for_wench(Request $request)
    {
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
        $order->save();
        $msg=getUserLang() == 'ar' ? 'تم اضافة الطلب' : 'order added successfully';
        return $this->apiResponseData(new OrderResource($order),$msg,200);
    }


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

}