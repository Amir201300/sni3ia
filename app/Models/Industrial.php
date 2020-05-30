<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industrial extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car_models()
    {
        return $this->belongsTo(Car_model::class,'car_model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work_shop()
    {
        return $this->belongsTo(Workshop_type::class,'workShop_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rateRelation()
    {
        return $this->morphToMany('App\User','RateRelation','rates')->withPivot('rate','comment','created_at');
    }
}
