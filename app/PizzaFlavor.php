<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaFlavor extends Model
{
    
    public function pizza_prices()
    {
        return $this->hasMany('App\PizzaPrice');
    }

    

     /**
     * @return mixed
     */
    public function item_category()
    {
        return $this->belongsTo('App\ItemCategory');
    }
}
