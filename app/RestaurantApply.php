<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantApply extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');  
    }

   
}
