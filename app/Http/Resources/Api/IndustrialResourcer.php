<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class IndustrialResourcer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $lang=Auth::check() ? getUserLang() : $request->header('lang');

        return [
            'id' => $this->id,
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'desc' => $lang == 'ar' ? $this->desc_ar : $this->desc_en,
            'phone'=>$this->phone,
            'sms'=>$this->sms,
            'rate'=>(int)$this->rate,
            'whatsapp'=>$this->whatsapp,
            'image'=>getImageUrl('Home_service',$this->omage),
            'car_models'=> $this->car_models ? $lang== 'ar' ? $this->car_models->name_ar : $this->car_models->name_en : '',
            'work_shop'=> $this->work_shop ? $lang == 'ar' ? $this->work_shop->name_ar : $this->work_shop->name_en : '',
            'province'=> $this->province ? $lang == 'ar' ? $this->province->name_ar : $this->province->name_en : '',
            'rate_users'=>RateResource::collection($this->rateRelation),
            'rates_count'=>(int)$this->rateRelation->count()
        ];
    }
}


