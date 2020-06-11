<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'type' => $this->type,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' =>(int)$this->status,
            'lang'=>$this->lang,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'token' => $this->token,
            'is_active'=>(int)$this->active,
            'is_verify'=>(int)$this->verify
        ];
    }
}
