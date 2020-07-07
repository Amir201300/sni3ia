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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function validate_live_service($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name_ar.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالعربية' :"username is required in arabic" ,
            'name_en.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالانجليزيه' :"username is required in english" ,
            'name_ar.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'name_en.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'image.required' => $lang == 'ar' ? 'من فضلك ادخل الصوره' :"an image is required" ,
            'lat.required' => $lang == 'ar' ? 'من فضلك ادخل خط الطول' :"the latitude is required" ,
            'lng.required' => $lang == 'ar' ? 'من فضلك ادخل خط العرض' :"the longitude is required" ,
        ];

        $validator = Validator::make($input, [
            'name_ar' => 'required|min:3',
            'name_en' => 'required|min:3',
            'image' => 'required|image',
            'lat' => 'required',
            'lng' => 'required',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }

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

    /**
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed``
     */
    public function validate_home_service($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name_ar.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالعربية' :"username is required" ,
            'name_en.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالانجليزيه' :"username is required" ,
            'name_ar.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'name_en.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,            'car_electration_id.required' => $lang == 'ar' ? 'من فضلك ادخل الميكانيكي' :"A car electrician is required"  ,
            'image.required' => $lang == 'ar' ? 'من فضلك ادخل الصوره' :"an image is required" ,
            'car_electration_id.required' => $lang == 'ar' ? 'من فضلك ادخل الميكانيكي' :"A car electrician is required"  ,
            'car_electration_id.exists' => $lang == 'ar' ? 'لا يوجد ميكانيكي بهذا الاسم' :"car electrician does not exist"  ,
        ];

        $validator = Validator::make($input, [
            'name_ar' => 'required|min:3',
            'name_en' => 'required|min:3',
            'image' => 'required|image',
            'car_electration_id' => 'required|exists:car_electrations,id',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }

    }

    /**
     * @param $request
     * @return Industrial|mixed
     */

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

    /**
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function validate_industrial($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name_ar.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالعربية' :"username is required in arabic" ,
            'name_en.required' => $lang == 'ar' ?  'من فضلك ادخل الاسم  بالانجليزيه' :"username is required in english" ,
            'name_ar.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'name_en.min' => $lang == 'ar' ? 'عدد الاحرف في اسم المستخدم يجب ان لا تقل عن 3 احرف' :"The username must be at least 3 character" ,
            'image.required' => $lang == 'ar' ? 'من فضلك ادخل الصوره' :"an image is required" ,
            'car_model_id.required' => $lang == 'ar' ? 'من فضلك ادخل نوع السياره' :"A car model is required"  ,
            'car_model_id.exists' => $lang == 'ar' ? 'نوع السياره غير موجود' :"car model does not exist"  ,
            'workShop_id.required' => $lang == 'ar' ? 'من فضلك ادخل الورشه' :"the work shop is required"  ,
            'workShop_id.exists' => $lang == 'ar' ? 'الورشه غير موجوده' :"work shop does not exist"  ,
            'province_id.required' => $lang == 'ar' ? 'من فضلك ادخل المقاطعه' :"the province is required"  ,
            'province_id.exists' => $lang == 'ar' ? 'المقاطعه غير موجوده' :"province does not exist"  ,




        ];

        $validator = Validator::make($input, [
            'name_ar' => 'required|min:3',
            'name_en' => 'required|min:3',
            'image' => 'required|image',
            'car_model_id' => 'required|exists:car_models,id',
            'workShop_id' => 'required|exists:workshop_types,id',
            'province_id' => 'required|exists:provinces,id',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }

    }

}