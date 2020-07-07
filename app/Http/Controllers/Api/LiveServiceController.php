<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Manage\Live_serviceController;
use App\Http\Resources\Api\LiveResource;
use App\Interfaces\RateInterface;
use App\Interfaces\Work_shopInterface;
use App\Models\live_service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt,DB;
use App\User;
use App\Interfaces\HandleDataInterface;
class LiveServiceController extends Controller
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

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @param $service_id
     * @return mixed
     */
    public function single_live_services(Request $request,HandleDataInterface $HandleDataInterface,$service_id)
    {
        return $HandleDataInterface->getSingleDsta(new live_service,$service_id,$request,new LiveResource(null));
    }

    /**
     * @param Request $request
     * @param RateInterface $RateInterface
     * @param $id
     * @return mixed
     */
    public function rate(Request $request,RateInterface $RateInterface,$id)
    {
        return $RateInterface->rating('App\Models\live_service',$request,new live_service,$id);
    }

    public function live_service(Request $request,Work_shopInterface $work_shop){

            $lang=$request->header('lang');
            $request['status']=0;
            $live=$work_shop->save_live_service($request);
            $msg=$lang == 'ar' ? 'تم اضافه الخدمه,برجاء انتظار موافقه الادمن ' : 'order added successfully, approval pending from the admin';
            return $this->apiResponseData(new LiveResource($live),$msg,200);
    }
}