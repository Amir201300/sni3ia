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
            'address'=>$this->destination_address,
            'estiamte_time'=>$this->eta,
            'status'=>(int)$this->status,
            'arrived_at'=> date(' H:i', strtotime($this->created_at.' +60 minutes'))
        ];
    }
}


