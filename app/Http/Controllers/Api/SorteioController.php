<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Sorteio;
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




class SorteioController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
  
    
    /**
     * @param $name
     * @param $data
     */
    private function processSuperCache($name, $data = null)
    {
        if (Module::find('SuperCache') && Module::find('SuperCache')->isEnabled()) {
            $superCache = new SuperCache();
            $superCache->cacheResponse($name, $data);
        }
    }


          /**
     * @param Request $request
     */
    public function getAllSorteios(Request $request)
    {

        $restaurant_ids=$request->restaurantsIds;

          // get all active restauants doing delivery
         // if (Cache::has('coupons')) {
         //   $coupons = Cache::get('coupons');
        //} else {
            $coupons = Sorteio::where('expiry_date', '>=',now())
                ->with('restaurants.categories')
                ->whereIn('restaurant_id', $restaurant_ids)
                ->get();
           // $this->processSuperCache('coupons', $coupons);
       // }


        
    return response()->json($this->paginate($coupons));
  

    }

            /**
     * @param Request $request
     */
    public function getAllRestaurantSorteios(Request $request)
    {

        $restaurant_id=$request->restaurant_id;

          // get all active restauants doing delivery
         // if (Cache::has('coupons')) {
         //   $coupons = Cache::get('coupons');
        //} else {
            $coupons = Sorteio::where('expiry_date', '>=',now())
                
                ->where('restaurant_id', $restaurant_id)
                ->get();
            //$this->processSuperCache('sorteios', $coupons);
       // }


        
    return response()->json($this->paginate($coupons));
  

    }

   /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $restaurant
     * @return boolean
     */
    private function getRestaurantDistance($latitudeFrom, $longitudeFrom, $restaurant)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($restaurant->latitude);
        $lonTo = deg2rad($restaurant->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * 6371; //distance in km
        return $distance;
       
    }



    
};
