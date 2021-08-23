<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
 /**
     * @return mixed
     */
    public function user() 
    {
        return $this->belongsTo('App\User');  
    }

    /**
     * @return mixed
     */
    public function location() 
    {
        return $this->belongsTo('App\Location');  
    }



}
