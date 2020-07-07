<?php

namespace App\Reposatries;

use App\Interfaces\Work_shopInterface;
use App\Models\homeService;
use App\Models\Industrial;
use App\Models\live_service;
use Auth,Validator;

class Work_shopReposatry implements Work_shopInterface {
    use \App\Traits\ApiResponseTrait;

    /**
     * @param $request
     * @return live_service|mixed
     */
    public function save_live_service($request)
    {

        $live_service=new Live_service;
        $live_service->name_ar=$request->name_ar;
        $live_service->name_en=$request->name_en;
        $live_service->desc_ar=$request->desc_ar;
        $live_service->desc_en=$request->desc_en;
        $live_service->phone=$request->phone;
        $live_service->sms=$request->sms;
        $live_service->lat=$request->lat;
        $live_service->lng=$request->lng;
        $live_service->whatsapp=$request->whatsapp;
        $live_service->status=$request->status;
        $live_service->image=saveImage('live_service',$request->image);
        $live_service->save();
        return $live_service;
    }

    /**
     * @param $request
     * @return homeService|mixed
     */
    public function save_home_service($request)
    {


        $home_service=new homeService();
        $home_service->name_ar=$request->name_ar;
        $home_service->name_en=$request->name_en;
        $home_service->desc_ar=$request->desc_ar;
        $home_service->desc_en=$request->desc_en;
        $home_service->image=saveImage('home_service',$request->image);
        $home_service->phone=$request->phone;
        $home_service->sms=$request->sms;
        $home_service->whatsapp=$request->whatsapp;
        $home_service->car_electration_id=$request->car_electration_id;
        $home_service->status=$request->status;
        $home_service->save();
        return $home_service;
    }

    public function save_industrial($request)
    {

        $industrial=new Industrial();
        $industrial->name_ar=$request->name_ar;
        $industrial->name_en=$request->name_en;
        $industrial->desc_ar=$request->desc_ar;
        $industrial->desc_en=$request->desc_en;
        $industrial->image=saveImage('live_service',$request->image);
        $industrial->phone=$request->phone;
        $industrial->sms=$request->sms;
        $industrial->whatsapp=$request->whatsapp;
        $industrial->car_model_id=$request->car_model_id;
        $industrial->workShop_id=$request->workShop_id;
        $industrial->province_id=$request->province_id;
        $industrial->status=$request->status;
        $industrial->save();
        return $industrial;
    }

}