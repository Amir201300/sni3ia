<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'name' => getUserLang() == 'ar' ? $this->name_ar : $this->name_en,
            'desc' => getUserLang() == 'ar' ? $this->desc_ar : $this->desc_en,
            'phone'=>$this->phone,
            'sms'=>$this->sms,
            'rate'=>(int)$this->rate,
            'whatsapp'=>$this->whatsapp,
            'image'=>getImageUrl('Home_service',$this->omage),
            'car_models'=> $this->car_models ? getUserLang() == 'ar' ? $this->car_models->name_ar : $this->car_models->name_en : '',
            'work_shop'=> $this->work_shop ? getUserLang() == 'ar' ? $this->work_shop->name_ar : $this->work_shop->name_en : '',
            'province'=> $this->province ? getUserLang() == 'ar' ? $this->province->name_ar : $this->province->name_en : '',
            'rate_users'=>RateResource::collection($this->rateRelation),
            'rates_count'=>(int)$this->rateRelation->count()
        ];
    }
}


