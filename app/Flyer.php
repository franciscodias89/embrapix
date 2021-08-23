<?php

namespace App;

use Event;
use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
  
    /**
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    public static function boot()
    {
        parent::boot();

        static::created(function ($flyer) {
            Event::dispatch('flyer.created', $flyer);
        });

        static::updated(function ($flyer) {
            Event::dispatch('flyer.updated', $flyer);
        });

        static::deleted(function ($flyer) {
            Event::dispatch('flyer.deleted', $flyer);
        });
    }

 
   /**
     * @return mixed
     */
    public function restaurants()  
    {
        return $this->belongsToMany('App\Restaurant', 'flyer_restaurant_flyer', 'flyer_id','restaurant_id');
    }

    /**
     * @return mixed
     */
    public function toggleActive()
    {
        $this->is_active = !$this->is_active;
        return $this;
    }

   

}
