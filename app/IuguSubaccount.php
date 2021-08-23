<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IuguSubaccount extends Model
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
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

}
