<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class live_service extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rateRelation()
    {
        return $this->morphToMany('App\User','RateRelation','rates')->withPivot('rate','comment','created_at');
    }
}
