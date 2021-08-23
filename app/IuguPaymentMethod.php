<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IuguPaymentMethod extends Model
{
 /**
     * @return mixed
     */
    public function user() 
    {
        return $this->belongsTo('App\User');  
    }



}
