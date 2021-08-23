<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaPrice extends Model
{
    
    /**
     * @return mixed
     */
    public function pizza_flavors()
    {
        return $this->belongsTo('App\PizzaFlavor');
    }

    
    /**
     * @return mixed
     */
    public function pizza_sizes()
    {
        return $this->belongsTo('App\PizzaSize');
    }
}
