<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Safetransactions extends Model
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
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * @return mixed
     */
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
