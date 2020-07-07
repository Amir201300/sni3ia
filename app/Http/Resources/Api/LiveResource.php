<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $lang=Auth::check() ? getUserLang() : $request->header('lang');
        return [
            'id' => $this->id,
<<<<<<< HEAD
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'desc' => $lang == 'ar' ? $this->desc_ar : $this->desc_en,
            'address' => $lang == 'ar' ? $this->address_ar : $this->address_en,
=======
            'name' => getUserLang() == 'ar' ? $this->name_ar : $this->name_en,
            'desc' => getUserLang() == 'ar' ? $this->desc_ar : $this->desc_en,
            'address' => $this->address,
>>>>>>> 236d713f80561b942be04c05756dc3d36eb80d98
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


