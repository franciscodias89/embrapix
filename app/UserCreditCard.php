<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCreditCard extends Model
{
 /**
     * @return mixed
     */
    public function user() 
    {
        return $this->belongsTo('App\User');  
    }



}
