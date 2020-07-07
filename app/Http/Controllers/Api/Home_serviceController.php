<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\car_electricianResource;
use App\Http\Resources\Api\home_servicesResource;
use App\Interfaces\RateInterface;
use App\Interfaces\Work_shopInterface;
use App\Models\Car_electration;
use App\Models\homeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\User;
use App\Interfaces\HandleDataInterface;
class Home_serviceController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @return mixed
     */
    public function car_electrician(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $car_electrician=Car_electration::where('status',1);
        return $HandleDataInterface->getAllData($car_electrician,$request,new car_electricianResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @param $car_id
     * @return mixed
     */
    public function home_services(Request $request,HandleDataInterface $HandleDataInterface,$car_id)
    {
        $home_services=homeService::where('car_slectration_id',$car_id);
        return $HandleDataInterface->getAllData($home_services,$request,new home_servicesResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @param $service_id
     * @return mixed
     */
    public function single_home_services(Request $request,HandleDataInterface $HandleDataInterface,$service_id)
    {
        return $HandleDataInterface->getSingleDsta(new homeService,$service_id,$request,new home_servicesResource(null));
    }

    /**
     * @param Request $request
     * @param RateInterface $RateInterface
     * @param $id
     * @return mixed
     */
    public function rate(Request $request,RateInterface $RateInterface,$id)
    {
        return $RateInterface->rating('App\Models\homeService',$request,new homeService,$id);
    }

    /**
     * @param Request $request
     * @param Work_shopInterface $work_shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function home_service(Request $request,Work_shopInterface $work_shop){

        $lang=$request->header('lang');
        $validate=$work_shop->validate_home_service($request);
        if(isset($validate)){
            return $validate;
        }
        $request['status']=0;
        $home=$work_shop->save_home_service($request);
        $msg=$lang == 'ar' ? 'تم اضافه الخدمه,برجاء انتظار موافقه الادمن ' : 'order added successfully, approval pending from the admin';
        return $this->apiResponseData(new home_servicesResource($home),$msg,200);

    }
}