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
use Spatie\JsonApiPaginate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;




class OffersController extends Controller
{
    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    } 
   
   
       /**
     * @param Request $request
     */
    public function getAllOffers(Request $request)
    {
        $maxResults=30;
        $items = Item::
            where('is_active', '1')
            ->where('is_deleted', 0)
            ->whereIn('restaurant_id', $request->restaurantsIds)
            ->with('restaurant')
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();

       

        $response = $this->paginate($items);
      
        

        return response()->json($response);

    }

    
};
