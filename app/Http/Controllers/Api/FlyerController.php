<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Flyer;
use App\RestaurantCategory;
use Cache;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;




class FlyerController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
  

          /**
     * @param Request $request
     */
    public function getAllFlyers(Request $request)
    {

        $restaurant_ids=$request->restaurantsIds;

        $flyers = Flyer::where('end_date', '>=',now())
        ->where('start_date','<=', now())
        ->with('restaurants')
        ->whereHas('restaurants', function ($query) use ($restaurant_ids) {
                $query->whereIn('restaurants.id', $restaurant_ids );
                })
        
        ->get();

       
        $response =  $this->paginate($flyers);
              

        return response()->json($response);

    }
    
};
