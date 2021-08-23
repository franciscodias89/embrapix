<?php

namespace App;

use Event;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');

    public static function boot()
    {
        parent::boot();

    
    }

   

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }


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
    public function toggleEnable()
    {
        $this->is_enabled = !$this->is_enabled;
        return $this;
    }
}
