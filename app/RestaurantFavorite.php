<?php

namespace App;

use Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use willvincent\Rateable\Rateable;

class RestaurantFavorite extends Model 
{
       

   
    /**
     * @var array
     */
    protected $hidden = array('created_at', 'updated_at');  

   

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    


}
