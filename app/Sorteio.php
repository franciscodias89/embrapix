<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sorteio extends Model
{
    /**
     * @var array
     */
    protected $dates = ['expiry_date'];

    /**
     * @return mixed
     */
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

     /**
     * @return mixed
     */
    public function restaurants()  
    {
        return $this->belongsToMany('App\Restaurant', 'sorteio_restaurant', 'sorteio_id','restaurant_id');
    }

   
}
