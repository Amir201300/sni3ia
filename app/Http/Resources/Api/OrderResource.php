<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'cost'=>(double)$this->cost,
            'estiamte_time'=>$this->eta,
            'user_id'=>(int)$this->user_id,
            'winch_id'=>(int)$this->winch_id,
            'status'=>(int)$this->status,
            'location_lat'=>$this->location_lat,
            'location_lng'=>$this->location_lng,
            'location_address'=>$this->location_address,
            'destination_lat'=>$this->destination_lat,
            'destination_lng'=>$this->destination_lng,
            'destination_address'=>$this->destination_address,
            'winch_lat'=>$this->winch ? $this->winch->lat : "",
            'winch_lng'=>$this->winch ? $this->winch->lng : "",
            'winch_phone'=>$this->winch ? $this->winch->phone : "",
            'winch_whatsapp'=>$this->winch ? $this->winch->whatsapp : "",
            'user_phone'=>$this->user ? $this->user->phone : "",
            'user_whatsapp'=>$this->user ? $this->user->whatsapp : "",
            'arrived_at'=> date(' H:i', strtotime($this->created_at.' +60 minutes'))
        ];
    }
}


