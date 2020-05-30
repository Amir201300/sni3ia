<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\car_electricianResource;
use App\Http\Resources\Api\home_servicesResource;
use App\Interfaces\RateInterface;
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
}