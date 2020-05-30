<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class home_servicesResource extends JsonResource
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
            'car_slectration'=>getUserLang() == 'ar' ? $this->car_electration->name_ar : $this->car_electration->name_en,
            'rate_users'=>RateResource::collection($this->rateRelation),
            'rates_count'=>(int)$this->rateRelation->count()
        ];
    }
}


