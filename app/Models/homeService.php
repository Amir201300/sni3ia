<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class homeService extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car_electration()
    {
        return $this->belongsTo(Car_electration::class,'car_slectration_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rateRelation()
    {
        return $this->morphToMany('App\User','RateRelation','rates')->withPivot('rate','comment','created_at');
    }


}
