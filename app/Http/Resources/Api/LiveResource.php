<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveResource extends JsonResource
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
            'address' => getUserLang() == 'ar' ? $this->address_ar : $this->address_en,
            'phone'=>$this->phone,
            'sms'=>$this->sms,
            'rate'=>(int)$this->rate,
            'whatsapp'=>$this->whatsapp,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'image'=>getImageUrl('live_service',$this->image),
            'rate_users'=>RateResource::collection($this->rateRelation),
            'rates_count'=>(int)$this->rateRelation->count()
        ];
    }
}


