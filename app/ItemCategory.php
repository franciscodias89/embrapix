<?php

namespace App;

use Event;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
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
    public function orders()
    {
        return $this->hasMany('App\Orders');
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
    public function user()
    {
        return $this->belongsTo('App\User');
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
