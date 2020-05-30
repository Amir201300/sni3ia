<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\IndustrialResourcer;
use App\Http\Resources\Api\IndustrialSpacifcationResource;
use App\Interfaces\RateInterface;
use App\Models\Car_model;
use App\Models\Industrial;
use App\Models\Province;
use App\Models\Workshop_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\User;
use App\Interfaces\HandleDataInterface;

class IndustrialController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @return mixed
     */
    public function Province(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $Province=Province::where('status',1);
        return $HandleDataInterface->getAllData($Province,$request,new IndustrialSpacifcationResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @return mixed
     */
    public function car_models(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $Province=Car_model::where('status',1);
        return $HandleDataInterface->getAllData($Province,$request,new IndustrialSpacifcationResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @return mixed
     */
    public function work_shops(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $Province=Workshop_type::where('status',1);
        return $HandleDataInterface->getAllData($Province,$request,new IndustrialSpacifcationResource(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @param $car_id
     * @return mixed
     */
    public function industrial_services(Request $request,HandleDataInterface $HandleDataInterface)
    {
        $industrial_services=Industrial::where('car_model_id',$request->car_model_id)->where('workShop_id',$request->workShop_id)
        ->where('province_id',$request->province_id);
        return $HandleDataInterface->getAllData($industrial_services,$request,new IndustrialResourcer(null));
    }

    /**
     * @param Request $request
     * @param HandleDataInterface $HandleDataInterface
     * @param $service_id
     * @return mixed
     */
    public function single_industrial_services(Request $request,HandleDataInterface $HandleDataInterface,$service_id)
    {
        return $HandleDataInterface->getSingleDsta(new Industrial,$service_id,$request,new IndustrialResourcer(null));
    }

    /**
     * @param Request $request
     * @param RateInterface $RateInterface
     * @param $id
     * @return mixed
     */
    public function rate(Request $request,RateInterface $RateInterface,$id)
    {
        return $RateInterface->rating('App\Models\Industrial',$request,new Industrial,$id);
    }
}