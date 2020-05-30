<?php

namespace App\Reposatries;

use App\Interfaces\RateInterface;
use App\Models\Rate;
use Auth,Validator;

class RateReposatry implements RateInterface {
    use \App\Traits\ApiResponseTrait;

    public function rating(string $type, $request,$model,int $model_id)
    {
        $lang=$request->header('lang') ? $request->header('lang') : getUserLang();
        $data=$model::find($model_id);
        if(is_null($data))
        {
            return $this->not_found_v2($lang);
        }
        $validate_rate=$this->validate_rate($request,$lang);
        if(isset($validate_rate))
        {
            return $validate_rate;
        }
        $msg= $this->save_rate($data,$request,$type,$lang);
        $this->cal_rate($data,$request->rate);
        return $this->apiResponseMessage(1,$msg,200);
    }

    /**
     * @param $data
     * @param $request
     * @param $type
     * @param $lang
     * @return string
     */
    private function save_rate($data,$request,$type,$lang)
    {
        $user=Auth::user();
        $rate= Rate::where('user_id',$user->id)->where('RateRelation_id',$data->id)->where('RateRelation_type',$type)->first();
        if(is_null($rate))
        {
            $rate=new Rate();
            $rate->rate=$request->rate;
            $rate->comment=$request->comment;
            $rate->user_id=$user->id;
            $rate->RateRelation_id=$data->id;
            $rate->RateRelation_type=$type;
            $rate->save();
            $msg=$lang=='ar' ? 'تم اضافة التقييم بنجاح' : 'rate added successfully';
        }else{
            $rate->rate=$request->rate;
            $rate->comment=$request->comment;
            $rate->save();
            $msg=$lang=='ar' ? 'تم تعديل التقييم بنجاح' : 'rate edited successfully';
        }
        return $msg;
    }

    /**
     * @param $data
     * @param $rate
     */
    private function cal_rate($data,$rate)
    {
        if($data->rate == 0)
        {
            $newRate=$rate;
        }else{
            $newRate=($rate + $data->rate) / 2;
        }
        $data->rate=$newRate;
        $data->save();
    }


    private function validate_rate($request,$lang)
    {
        $input = $request->all();
        $validationMessages = [
            'rate.required' => $lang == 'ar' ?  'من فضلك ادخل التقييم' :"rate is required" ,
            'rate.integer' => $lang == 'ar' ? 'التقييم يجب ان يكون رقما' :"The rate must be a number" ,
            'rate.between' => $lang == 'ar' ? 'قيمة التقييم يجب ان تكون من 1 الي 5' :"The rate must be between 1 and 5."  ,
        ];

        $validator = Validator::make($input, [
            'rate' => 'required|integer|between:1,5',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }
    }


}