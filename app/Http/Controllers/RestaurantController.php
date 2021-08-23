<?php

namespace App\Http\Controllers;

use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Flyer;
use App\Sorteio;
use App\Coupon;
use App\PizzaSize;
use App\PizzaFlavor;
use App\PizzaPrice;
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

class RestaurantController extends Controller
{


    public function pagination($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    private function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * 6371;
    }

    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $restaurant
     * @return boolean
     */
    private function checkOperation($latitudeFrom, $longitudeFrom, $restaurant)
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

        //if any delivery area assigned
        if (count($restaurant->delivery_areas) > 0) {
            //check if delivery pro module exists,
            if (Module::find('DeliveryAreaPro') && Module::find('DeliveryAreaPro')->isEnabled()) {
                $dap = new DeliveryArea();
                return $dap->checkArea($latitudeFrom, $longitudeFrom, $restaurant->delivery_areas);
            } else {
                //else use geenral distance
                if ($distance <= $restaurant->delivery_radius) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            //if no delivery areas, then use general distance
            if ($distance <= $restaurant->delivery_radius) {
                return true;
            } else {
                return false;
            }
        }
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
     * @return mixed
     */
    public function getDeliveryRestaurants(Request $request)
    {
        // Cache::forget('stores-delivery-active');
        // Cache::forget('stores-delivery-inactive');
        // die();

        // get all active restauants doing delivery
        if (Cache::has('stores-delivery-active')) {
            $restaurants = Cache::get('stores-delivery-active');
        } else {
            $restaurants = Restaurant::where('is_accepted', '1')
                ->where('is_active', 1)
                //->whereIn('delivery_type', [1, 3])
                ->ordered()
                ->get();
            $this->processSuperCache('stores-delivery-active', $restaurants);
        }

        //Create a new Laravel collection from the array data
        $nearMe = new Collection();

        foreach ($restaurants as $restaurant) {
            // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $nearMe->push($restaurant);
            // }
            //$check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            //if ($check) {
            //    $nearMe->push($restaurant);
            //}
            //-ADD 
            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
            $restaurant['distance']=$restaurant_distance;
            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->where('items.is_deleted', 0)->get();

            if(!empty($restaurant_itens))
            {
                
                if(count($restaurant_itens) == 0) {
                    $restaurant['restaurant_items']=0;
                }
                else {
                    $restaurant['restaurant_items']=count($restaurant_itens);
                }
                
            } 

            if($restaurant_itens)
            $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $restaurant->categories=$categories;
            $delivery_tax='';
            if($restaurant->delivery_charge_type === 'DYNAMIC'){
                $distance_restante=$restaurant_distance-($restaurant->base_delivery_distance);
                $delivery_tax=(($restaurant->base_delivery_distance)*($restaurant->base_delivery_charge))+($distance_restante/($restaurant->extra_delivery_distance))*($restaurant->extra_delivery_charge);
                $restaurant->delivery_tax=$delivery_tax;
            }
            if($restaurant->delivery_charge_type === 'FIXED'){
                $delivery_tax=$restaurant->delivery_charges;
                $restaurant->delivery_tax=$delivery_tax;
            }
            if($restaurant->delivery_charge_type === 'FREE'){
                $delivery_tax='free';
                $restaurant->delivery_tax=$delivery_tax;
            }
            $restaurant['delivery_tax']=$delivery_tax;
             if ($restaurant_distance <= $restaurant->delivery_radius) {
                 $nearMe->push($restaurant);
             } //-ADD
        }
        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $nearMe = $nearMe->map(function ($restaurant) {
            return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
        });// ADD - acrescentado novos campos
        $nearMe = $nearMe->sortBy('distance');
        // $onlyInactive = $nearMe->where('is_active', 0)->get();
        // dd($onlyInactive);
        $nearMe = $nearMe->toArray();

        if (config('settings.randomizeStores') == 'true') {
            shuffle($nearMe);
            usort($nearMe, function ($left, $right) {
                return $right['is_featured'] - $left['is_featured'];
            });
        }

        if (Cache::has('stores-delivery-inactive')) {
            $inactiveRestaurants = Cache::get('stores-delivery-inactive');
        } else {
            $inactiveRestaurants = Restaurant::where('is_accepted', '1')
                ->where('is_active', 0)
                
                //->whereIn('delivery_type', [1, 3])
                ->ordered()
                ->get();
            $this->processSuperCache('stores-delivery-inactive', $inactiveRestaurants);
        }

        $nearMeInActive = new Collection();
        foreach ($inactiveRestaurants as $inactiveRestaurant) {
            // $distance = $this->getDistance($request->latitude, $request->longitude, $inactiveRestaurant->latitude, $inactiveRestaurant->longitude);
            // if ($distance <= $inactiveRestaurant->delivery_radius) {
            //     $nearMeInActive->push($inactiveRestaurant);
            // }
            //$check = $this->checkOperation($request->latitude, $request->longitude, $inactiveRestaurant);
            //if ($check) {
            //    $nearMeInActive->push($inactiveRestaurant);
            //}
             //-ADD 
             $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $inactiveRestaurant);
             $inactiveRestaurant['distance']=$restaurant_distance;
             $categories=$inactiveRestaurant->restaurant_categories()->get();//RestaurantCategory::all();
             $inactiveRestaurant->categories=$categories;

            $delivery_tax='';
            if($inactiveRestaurant->delivery_charge_type === 'DYNAMIC'){
                $distance_restante=$restaurant_distance-($inactiveRestaurant->base_delivery_distance);
                $delivery_tax=(($inactiveRestaurant->base_delivery_distance)*($inactiveRestaurant->base_delivery_charge))+($distance_restante/($inactiveRestaurant->extra_delivery_distance))*($inactiveRestaurant->extra_delivery_charge);
                $inactiveRestaurant->delivery_tax=$delivery_tax;
            }
            if($inactiveRestaurant->delivery_charge_type === 'FIXED'){
                $delivery_tax=$inactiveRestaurant->delivery_charges;
                $inactiveRestaurant->delivery_tax=$delivery_tax;
            }
            if($inactiveRestaurant->delivery_charge_type === 'FREE'){
                $delivery_tax='free';
                $inactiveRestaurant->delivery_tax=$delivery_tax;
            }
            $inactiveRestaurant['delivery_tax']=$delivery_tax;

              if ($restaurant_distance <= $inactiveRestaurant->delivery_radius) {
                $nearMeInActive->push($inactiveRestaurant);
              } //-ADD
        }
        $nearMeInActive = $nearMeInActive->map(function ($inactiveRestaurant) {
            return $inactiveRestaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
        });// ADD - acrescentado novos campos
        $nearMeInActive = $nearMeInActive->toArray();

        $merged = array_merge($nearMe, $nearMeInActive);

        return response()->json($merged);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSelfPickupRestaurants(Request $request)
    {
        // sleep(500);
        // get all active restauants doing selfpickups
        if (Cache::has('stores-selfpickup-active')) {
            $restaurants = Cache::get('stores-selfpickup-active');
        } else {
            $restaurants = Restaurant::where('is_accepted', '1')
                ->where('is_active', 1)
                ->whereIn('delivery_type', [2, 3])
                ->ordered()
                ->get();
            $this->processSuperCache('stores-selfpickup-active', $restaurants);
        }

        //Create a new Laravel collection from the array data
        $nearMe = new Collection();

        foreach ($restaurants as $restaurant) {
            $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $nearMe->push($restaurant);
            // }
            $restaurant->distance = $distance;
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            if ($check) {
                $nearMe->push($restaurant);
            }
        }

        $nearMe = $nearMe->map(function ($restaurant) {
            return $restaurant->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'distance']);
        });

        $nearMe = $nearMe->toArray();
        if (config('settings.randomizeStores') == 'true') {
            shuffle($nearMe);
            usort($nearMe, function ($left, $right) {
                return $right['is_featured'] - $left['is_featured'];
            });
        }

        if (config('settings.sortSelfpickupStoresByDistance') == 'true') {
            $nearMe = collect($nearMe)->sortBy('distance')->toArray();
        }

        if (Cache::has('stores-selfpickup-inactive')) {
            $inactiveRestaurants = Cache::get('stores-selfpickup-inactive');
        } else {
            $inactiveRestaurants = Restaurant::where('is_accepted', '1')
                ->where('is_active', 0)
                ->whereIn('delivery_type', [2, 3])
                ->ordered()
                ->get();
            $this->processSuperCache('stores-selfpickup-inactive', $inactiveRestaurants);
        }

        $nearMeInActive = new Collection();
        foreach ($inactiveRestaurants as $inactiveRestaurant) {
            $distance = $this->getDistance($request->latitude, $request->longitude, $inactiveRestaurant->latitude, $inactiveRestaurant->longitude);
            // if ($distance <= $inactiveRestaurant->delivery_radius) {
            //     $nearMeInActive->push($inactiveRestaurant);
            // }
            $inactiveRestaurant->distance = $distance;
            $check = $this->checkOperation($request->latitude, $request->longitude, $inactiveRestaurant);
            if ($check) {
                $nearMeInActive->push($inactiveRestaurant);
            }
        }
        $nearMeInActive = $nearMeInActive->map(function ($restaurant) {
            return $restaurant->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'distance']);
        });
        $nearMeInActive = $nearMeInActive->toArray();

        if (config('settings.sortSelfpickupStoresByDistance') == 'true') {
            $nearMeInActive = collect($nearMeInActive)->sortBy('distance')->toArray();
        }

        $merged = array_merge($nearMe, $nearMeInActive);

        return response()->json($merged);
    }

    /**
     * @param $slug
     */
    public function getRestaurantInfo($slug)
    {
        // Cache::forget('store-info-' . $slug);

        if (Cache::has('store-info-' . $slug)) {
            $restaurantInfo = Cache::get('store-info-' . $slug);
        } else {
            $restaurantInfo = Restaurant::where('slug', $slug)->first();

            $restaurantInfo->makeHidden(['delivery_areas']);
            $this->processSuperCache('store-info-' . $slug, $restaurantInfo);
        }

        return response()->json($restaurantInfo);
    }
    // /**
    //  * @param $id
    //  */
    // public function getRestaurantInfoById($id)
    // {
    //     $restaurant = Restaurant::where('id', $id)->first();
    //     $restaurant->makeHidden(['delivery_areas']);

    //     return response()->json($restaurant);
    // }

     /**
     * @param Request $request
     */
    public function getRestaurantInfoById(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->restaurant_id)->first();
        
        if ($restaurant) {
            $restaurant->makeHidden(['delivery_areas']);
            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
      
           
            $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $restaurant->categories=$categories;
            $restaurant->distance = $restaurant_distance;
            return response()->json($restaurant);
        }
    }

    /**
     * @param Request $request
     */
    public function getRestaurantInfoAndOperationalStatus(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            $restaurant->makeHidden(['delivery_areas']);
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            $is_operational = false;
            if ($check) {
                $is_operational = true;
            }
            $restaurant->is_operational = $is_operational;
            return response()->json($restaurant);
        } else {
            abort(400, 'Restaurant ID not passed or not found.');
        }

    }


    
    /**
     * @param $slug
     */
    public function getRestaurantItems($slug)
    {
        // Cache::forget('store-info-' . $slug);
        Cache::forever('items-cache', 'true');
        if (Cache::has('store-info-' . $slug)) {
            $restaurant = Cache::get('store-info-' . $slug);
        } else {
            $restaurant = Restaurant::where('slug', $slug)->first();
            $this->processSuperCache('store-info-' . $slug, $restaurant);
        }
        $user_id=$restaurant->user_id;
        $categories=ItemCategory::where('user_id',$user_id)->where('parent_id',null)->orderBy('sort_id','ASC')->get();
        $array = [];
        
    foreach($categories as $category){

        $ids=[];
        $subcategories=ItemCategory::where('parent_id',$category->id)->orderBy('sort_id','ASC')->get();
       
        $ids[]=$category->id;
        foreach($subcategories as $row){
            $ids[]=$row->id;
        }
       
        if($restaurant->business_type==1){
            $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
            ->where('is_active', 1)
            ->where('items.is_deleted', 0)
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1)->where('is_deleted', 0);
            }))
            ->get();
        }else{
            $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
            ->where('is_active', 1)
            ->where('items.is_deleted', 0)
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1)->where('is_deleted', 0);
            }))
            ->limit(10)->get();
        }

        $items = json_decode($items, true);
        $items_cat=[];

        if(count($items)>0){
        foreach ($items as $item) {
            if($item['is_pizza']==1){
                $items_cat[]=getItemPizza($item,$category);
            }else{
                

                if($item['old_price']=="0.00"){
                    $items_cat[]=getPriceFromAddons($item);
                }else{
                    $items_cat[]=$item;
                }
                /* if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;
                } */
            }
        }
        $category_name=$category->name;
        $array[$category_name]=$items_cat;  
    }
   // $category_array=[$category_name =>$items_cat];
   //$collection->push($category_array);
   
    }
        $recommended =[];
        return response()->json(array(
            'recommended' => $recommended,
            'items' => $array,
        ));

    }


    /**
     * @param $slug
     */
    public function getRestaurantItems2($slug)
    {
        // Cache::forget('store-info-' . $slug);
        Cache::forever('items-cache', 'true');
        if (Cache::has('store-info-' . $slug)) {
            $restaurant = Cache::get('store-info-' . $slug);
        } else {
            $restaurant = Restaurant::where('slug', $slug)->first();
            $this->processSuperCache('store-info-' . $slug, $restaurant);
        }

       if($restaurant->business_type==1){

          $items = Item::where('restaurant_id', $restaurant->id)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        
                        $join->where('is_enabled', '1');
                    })
                    ->where('is_active', 1)
                    ->where('items.is_deleted', 0)
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->get(array('items.*', 'item_categories.name as subcategory_name', 'item_categories.parent_id as category_parent_id', 'item_categories.id as category_id'));
            

        $items = json_decode($items, true);

        $array = [];
        foreach ($items as $item) {
           

            if($item['is_pizza']==1){
                $item_category=ItemCategory::where('id',$item['item_category_id'])->first();
                $addon_categories=$item['addon_categories'];
                $pizza_size_id=$item['pizza_size_id'];
                $pizza_size=PizzaSize::where('id',$pizza_size_id)->first();
                $pizza_flavors=PizzaFlavor::where('item_category_id',$item['item_category_id'])->get();
                $addonCategories= new Collection();

                if($item['pizza_flavors']==1){
                    $addons=array();
                    $addon_prices=array();
                    foreach($pizza_flavors as $flavor){
                        $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                        $addons[]=[
                            'id'=>'Ad1'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>88,
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0

                        ];
                        if($price['price']!=null){
                            $addon_prices[]=$price['price'];
                        }
                        

                    }
                    
                    $addon_categories1=[
                        'id'=>88,
                        'name'=>'Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons,

                    ];
                    
                    $addonCategories->push($addon_categories1);

                    foreach($addon_categories as $row){
                        $addonCategories->push($row);
                    }
                    $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
                    if($addon_prices){
                        $min_addons=min($addon_prices);
                        $item['price_from']=$min_addons;
                    }
                    

                    
                }
                if($item['pizza_flavors']==2){
                    $addon_prices=array();
                    $addons=array();
                    $addons2=array();
                    foreach($pizza_flavors as $flavor){
                        $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                        $addons[]=[
                            'id'=>'Ad2'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add1',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons2[]=[
                            'id'=>'Ad22'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add2',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        if($price['price']!=null){
                            $addon_prices[]=$price['price'];
                        }

                    }
                    
                    $addon_categories1=[
                        'id'=>'add1',
                        'name'=>'Primeiro Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Primeiro Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons,

                    ];
                    $addon_categories2=[
                        'id'=>'add2',
                        'name'=>'Segundo Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Segundo Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons2,


                    ];
                    $addonCategories->push($addon_categories1);
                    $addonCategories->push($addon_categories2);

                    foreach($addon_categories as $row){
                        $addonCategories->push($row);
                    }
                    $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
                    
                    if($addon_prices){
                        $min_addons=min($addon_prices);
                        $item['price_from']=$min_addons;
                    }
                    
                }
                if($item['pizza_flavors']==3){
                    $addon_prices=array();
                    $addons=array();
                    $addons2=array();
                    $addons3=array();
                    foreach($pizza_flavors as $flavor){
                        $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                        $addons[]=[
                            'id'=>'Ad3'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add1',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons2[]=[
                            'id'=>'Ad33'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add2',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons3[]=[
                            'id'=>'Ad33'.$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add3',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        if($price['price']!=null){
                            $addon_prices[]=$price['price'];
                        }

                    }
                    
                    $addon_categories1=[
                        'id'=>'add1',
                        'name'=>'Primeiro Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Primeiro Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons,

                    ];
                    $addon_categories2=[
                        'id'=>'add2',
                        'name'=>'Segundo Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Segundo Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons2,


                    ];
                    $addon_categories3=[
                        'id'=>'add3',
                        'name'=>'Terceiro Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Terceiro Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons3,


                    ];
                    $addonCategories->push($addon_categories1);
                    $addonCategories->push($addon_categories2);
                    $addonCategories->push($addon_categories3);

                    foreach($addon_categories as $row){
                        $addonCategories->push($row);
                    }
                    $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
                    
                    if($addon_prices){
                        $min_addons=min($addon_prices);
                        $item['price_from']=$min_addons;
                    }
                    
                }
                if($item['pizza_flavors']==4){
                    $addon_prices=array();
                    $addons=array();
                    $addons2=array();
                    $addons3=array();
                    $addons4=array();
                    foreach($pizza_flavors as $flavor){
                        $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                        $addons[]=[
                            'id'=>$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add1',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons2[]=[
                            'id'=>$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add2',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons3[]=[
                            'id'=>$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add3',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        $addons4[]=[
                            'id'=>$flavor->id,
                            'name'=> $flavor->flavor,
                            'description'=>$flavor->description,
                            'price'=>$price['price'],
                            'addon_category_id'=>'add4',
                            'image'=>$flavor->image,
                            'is_active'=>1,
                            'is_deleted'=>0
                        ];
                        if($price['price']!=null){
                            $addon_prices[]=$price['price'];
                        }

                    }
                    
                    $addon_categories1=[
                        'id'=>'add1',
                        'name'=>'Primeiro Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Primeiro Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons,

                    ];
                    $addon_categories2=[
                        'id'=>'add2',
                        'name'=>'Segundo Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Segundo Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons2,


                    ];
                    $addon_categories3=[
                        'id'=>'add3',
                        'name'=>'Terceiro Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Terceiro Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons3,


                    ];
                    $addon_categories4=[
                        'id'=>'add4',
                        'name'=>'Quarto Sabor',
                        'type'=>'SINGLE',
                        'description'=>'Escolha o Quarto Sabor',
                        'status'=>1,
                        'min'=>null,
                        'max'=>null,
                        'flavor'=>1,
                        'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                        'is_deleted'=>0,
                        'addons'=>$addons4,


                    ];
                    $addonCategories->push($addon_categories1);
                    $addonCategories->push($addon_categories2);
                    $addonCategories->push($addon_categories3);
                    $addonCategories->push($addon_categories4);

                    foreach($addon_categories as $row){
                        $addonCategories->push($row);
                    }
                    $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
                    
                    if($addon_prices){
                        $min_addons=min($addon_prices);
                        $item['price_from']=$min_addons;
                    }
                }
                
                if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;
    
        
                }

            }else{

                if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;

        
                }

            }
        }

        $recommended =[];

       }else{

        if (Cache::has('items-recommended-' . $restaurant->id) && Cache::has('items-all-' . $restaurant->id)) {
            $recommended = Cache::get('items-recommended-' . $restaurant->id);
            $array = Cache::get('items-all-' . $restaurant->id);
        } else {
            if (config('settings.showInActiveItemsToo') == 'true') {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        $join->where('is_enabled', '1');
                    })
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as category_name'));
            } else {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        
                        $join->where('is_enabled', '1');
                    })
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as subcategory_name', 'item_categories.parent_id as category_parent_id', 'item_categories.id as category_id'));
            }

            $items = json_decode($items, true);

            $array = [];
            foreach ($items as $item) {
                if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;

        
                }
            }

            $this->processSuperCache('items-recommended-' . $restaurant->id, $recommended);
            $this->processSuperCache('items-all-' . $restaurant->id, $array);
        }

       }

        

        return response()->json(array(
            'recommended' => $recommended,
            'items' => $array,
        ));

    }

        /**
     * @param Request $request
     */
    public function getAllOffers(Request $request)
    {
        //get lat and lng and query from user...
        // get all active restauants doing delivery & selfpickup
        $restaurants = Restaurant::where('name', 'LIKE', "%$request->q%")
            ->where('is_accepted', '1')
            ->take(20)->get();
            
        //Create a new Laravel collection from the array data
        $nearMeRestaurants = new Collection();

        foreach ($restaurants as $restaurant) {

            $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $restaurant->categories=$categories;
            // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $nearMeRestaurants->push($restaurant);
            // }
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            if ($check) {
                $nearMeRestaurants->push($restaurant);
            }
        }
  
        $items = Item::
            where('is_active', '1')
            ->where('name', 'LIKE', "%$request->q%")
            ->where('items.is_deleted', 0)
            ->with('restaurant')
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();

        $nearMeItems = new Collection();
        foreach ($items as $item) {

            if ($item->restaurant->is_active) {
                $itemRestro = $item->restaurant;
                // $distance = $this->getDistance($request->latitude, $request->longitude, $itemRestro->latitude, $itemRestro->longitude);
                // if ($distance <= $itemRestro->delivery_radius) {
                //     $nearMeItems->push($item);
                // }
                $check = $this->checkOperation($request->latitude, $request->longitude, $itemRestro);
                if ($check) {
                    $nearMeItems->push($item);
                }
            }

        }

        $response = [
            'restaurants' => $nearMeRestaurants,
            'items' => $nearMeItems->take(20),
        ];

        return response()->json($response);

    }

    /**
     * @param Request $request
     */
    public function searchRestaurants(Request $request)
    {
        //get lat and lng and query from user...
        // get all active restauants doing delivery & selfpickup
        $restaurants = Restaurant::where('name', 'LIKE', "%$request->q%")
            ->where('is_accepted', '1')
            ->take(20)->get();
            
        //Create a new Laravel collection from the array data
        $nearMeRestaurants = new Collection();

        foreach ($restaurants as $restaurant) {

            $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $restaurant->categories=$categories;
            // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $nearMeRestaurants->push($restaurant);
            // }
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            if ($check) {
                $nearMeRestaurants->push($restaurant);
            }
        }
  
        $items = Item::
            where('is_active', '1')
            ->where('name', 'LIKE', "%$request->q%")
            ->where('items.is_deleted', 0)
            ->with('restaurant')
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();

           // $items = json_decode($items, true);

        $nearMeItems = new Collection();


      
        $items = json_decode($items, true);
        $nearMeItems= new Collection();

        


        if(count($items)>0){
        foreach ($items as $item) {
            $category=ItemCategory::where('id',$item['item_category_id'])->first();
            if($item['is_pizza']==1){
                $item_pizza=getItemPizza($item,$category);
                $nearMeItems->push($item_pizza);
            }else{
                

                if($item['old_price']=="0.00"){
                    $items_cat=getPriceFromAddons($item);
                    $nearMeItems->push($items_cat);
                }else{
                    $nearMeItems->push($item);
                }
                /* if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;
                } */
            }
        }
       
    }



        $response = [
            'restaurants' => $nearMeRestaurants,
            'items' => $nearMeItems->take(50),
        ];

        return response()->json($response);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkRestaurantOperationService(Request $request)
    {
        $check = false;

        $restaurant = Restaurant::where('id', $request->restaurant_id)->first();
        if ($restaurant) {
            // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $status = true;
            // }
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            return $check;
        }
        return response()->json($check);
    }

    /**
     * @param Request $request
     */
    public function getSingleItem(Request $request)
    {
        if (Cache::has('item-single-' . $request->id)) {
            $item = Cache::get('item-single-' . $request->id);
        } else {

            if (config('settings.showInActiveItemsToo') == 'true') {
                $item = Item::where('id', $request->id)
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->first();
            } else {
                $item = Item::where('id', $request->id)
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->first();
            }

            $this->processSuperCache('item-single-' . $request->id, $item);
        }

        if ($item) {
            return response()->json($item);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getFilteredRestaurants(Request $request)
    {
        $activeFilteredRestaurants = Restaurant::where('is_accepted', '1')
            ->where('is_active', 1)
            ->whereHas('restaurant_categories', function ($query) use ($request) {
                $query->whereIn('restaurant_category_id', $request->category_ids);
            })->get();

        $nearMe = new Collection();

        foreach ($activeFilteredRestaurants as $restaurant) {
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            if ($check) {
                $nearMe->push($restaurant);
            }
        }
        $nearMe = $nearMe->map(function ($restaurant) {
            return $restaurant->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active']);
        });
        $nearMe = $nearMe->toArray();

        $inActiveFilteredRestaurants = Restaurant::where('is_accepted', '1')
            ->where('is_active', 0)
            ->whereHas('restaurant_categories', function ($query) use ($request) {
                $query->whereIn('restaurant_category_id', $request->category_ids);
            })->get();

        $nearMeInActive = new Collection();

        foreach ($inActiveFilteredRestaurants as $restaurant) {
            $check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            if ($check) {
                $nearMeInActive->push($restaurant);
            }
        }

        $nearMeInActive = $nearMeInActive->map(function ($restaurant) {
            return $restaurant->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active']);
        });
        $nearMeInActive = $nearMeInActive->toArray();

        $merged = array_merge($nearMe, $nearMeInActive);

        return response()->json($merged);
    }

    /**
     * @param Request $request
     */
    public function checkCartItemsAvailability(Request $request)
    {
        $items = $request->items;
        $activeItemIds = [];
        foreach ($items as $item) {
            $oneItem = Item::where('id', $item['id'])->first();
            if ($oneItem) {
                if (!$oneItem->is_active) {
                    array_push($activeItemIds, $oneItem->id);
                }
            }
        }
        return response()->json($activeItemIds);
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

     //----ADD
    /**
     * @param Request $request
     */
    public function getAllRestaurantsBYCategory(Request $request)
    {

        $categoryId=$request->category_id;
 // get all active restauants doing delivery
 if (Cache::has('stores-delivery-active')) {
    $restaurants = Cache::get('stores-delivery-active');
} else {
    $restaurants = Restaurant::where('is_accepted', '1')
        ->where('is_active', 1)
        //->whereIn('delivery_type', [1, 3])
        ->with('restaurant_categories')
        ->whereHas('restaurant_categories', function ($query) use ($categoryId) {
                $query->where('restaurant_categories.id', $categoryId );
                })
        ->ordered()
        ->get();
    $this->processSuperCache('stores-delivery-active', $restaurants);
}


    //Create a new Laravel collection from the array data
    $nearMe = new Collection();

    foreach ($restaurants as $restaurant) {
        // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
        // if ($distance <= $restaurant->delivery_radius) {
        //     $nearMe->push($restaurant);
        // }
        
        //$check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
        //if ($check) {
        //    $nearMe->push($restaurant);
       // }
        //-ADD 
        $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
        $restaurant['distance']=$restaurant_distance;
        $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();

        $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $restaurant->categories=$categories;
         if ($restaurant_distance <= $restaurant->delivery_radius) {
             $nearMe->push($restaurant);
         } //-ADD
        
    }
   
    // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
    $nearMe = $nearMe->map(function ($restaurant) {
        return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
    });// ADD - acrescentado novos campos
    $nearMe = $nearMe->sortBy('distance');
    // $onlyInactive = $nearMe->where('is_active', 0)->get();
    // dd($onlyInactive);
    $nearMe = $nearMe->toArray();

    if (config('settings.randomizeStores') == 'true') {
        shuffle($nearMe);
        usort($nearMe, function ($left, $right) {
            return $right['is_featured'] - $left['is_featured'];
        });
    }

    if (Cache::has('stores-delivery-inactive')) {
        $inactiveRestaurants = Cache::get('stores-delivery-inactive');
    } else {
        $inactiveRestaurants = Restaurant::where('is_accepted', '1')
            ->where('is_active', 0)
            //->whereIn('delivery_type', [1, 3])
            ->where('is_accepted',1)
            ->with('restaurant_categories')
            ->whereHas('restaurant_categories', function ($query) use ($categoryId) {
                    $query->where('restaurant_categories.id', $categoryId );
                    })
            ->ordered()
            
            ->get();
        $this->processSuperCache('stores-delivery-inactive', $inactiveRestaurants);
    }

    $nearMeInActive = new Collection();
    foreach ($inactiveRestaurants as $inactiveRestaurant) {
        // $distance = $this->getDistance($request->latitude, $request->longitude, $inactiveRestaurant->latitude, $inactiveRestaurant->longitude);
        // if ($distance <= $inactiveRestaurant->delivery_radius) {
        //     $nearMeInActive->push($inactiveRestaurant);
        // }
        //$check = $this->checkOperation($request->latitude, $request->longitude, $inactiveRestaurant);
        //if ($check) {
       //     $nearMeInActive->push($inactiveRestaurant);
        //}
        //-ADD 
        $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $inactiveRestaurant);
        $restaurant['distance']=$restaurant_distance;
        $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$inactiveRestaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$inactiveRestaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$inactiveRestaurant->id)->where('is_active',1)->where('is_deleted',0)->count();

        $categories=$inactiveRestaurant->restaurant_categories()->get();//RestaurantCategory::all();
            $inactiveRestaurant->categories=$categories;
         if ($restaurant_distance <= $inactiveRestaurant->delivery_radius) {
             $nearMeInActive->push($inactiveRestaurant);
         } //-ADD
    }
    $nearMeInActive = $nearMeInActive->map(function ($restaurant) {
        return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
    });  // ADD - acrescentado novos campos
    $nearMeInActive = $nearMeInActive->toArray();

    $merged = array_merge($nearMe, $nearMeInActive);
    


    

    return response()->json($merged);




    }
//-----ADD

  /**
     * @param $slug
     */
    public function getOffersBYstore($slug)
    {
        // Cache::forget('store-info-' . $slug);
        Cache::forever('items-cache', 'true');
        if (Cache::has('store-info-' . $slug)) {
            $restaurant = Cache::get('store-info-' . $slug);
        } else {
            $restaurant = Restaurant::where('slug', $slug)->first();
            $this->processSuperCache('store-info-' . $slug, $restaurant);
        }
        $user_id=$restaurant->user_id;
        $categories=ItemCategory::where('user_id',$user_id)->where('parent_id',null)->orderBy('sort_id','ASC')->get();
        $array = [];
        
    foreach($categories as $category){

        $ids=[];
        $subcategories=ItemCategory::where('parent_id',$category->id)->orderBy('sort_id','ASC')->get();
       
        $ids[]=$category->id;
        foreach($subcategories as $row){
            $ids[]=$row->id;
        }
       
        if($restaurant->business_type==1){
            $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
            ->where('is_active', 1)
            ->where('items.is_deleted', 0)
            ->where('price','!=',null)
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();
        }else{
            $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
            ->where('is_active', 1)
            ->where('items.is_deleted', 0)
            ->with('addon_categories')
            ->where('price','!=',null)
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->limit(10)->get();
        }

        $items = json_decode($items, true);
        $items_cat=[];

        if(count($items)>0){
        foreach ($items as $item) {

            $agora= date(now());
                                                    
            if(($item['is_offer_notime'] ==1)){
                if($item['is_pizza']==1){
                    $items_cat[]=getItemPizza($item,$category);
                }else{
                    $items_cat[]=$item;
                }
            }
            elseif(date('d/m/Y' ,strtotime($item['start_date'])) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($item['end_date'])) >=date('d/m/Y' ,strtotime($agora)) && $item['price']!=null )
             {
                if($item['is_pizza']==1){
                    $items_cat[]=getItemPizza($item,$category);
                }else{
                    $items_cat[]=$item;
                }

             }   

        }
        $category_name=$category->name;
        $array[$category_name]=$items_cat;  
    }
   // $category_array=[$category_name =>$items_cat];
   //$collection->push($category_array);
   
    }
        $recommended =[];
        return response()->json(array(
            'recommended' => $recommended,
            'items' => $array,
        ));

    }

    public function getCategoriesIds($category)
{
    if(!empty($category))
    {
        $array = array($category->id);
        if(count($category->subcategories) == 0) return $array;
        else return array_merge($array, $this->getChildrenIds($category->subcategories));
    } 
    else return null;
}

public function getChildrenIds($subcategories)
{
    $array = array();
    foreach ($subcategories as $subcategory)
    {
        array_push($array, $subcategory->id);
        if(count($subcategory->subcategories))
            $array = array_merge($array, $this->getChildrenIds($subcategory->subcategories));
    }
    return $array;
}

        /**
     * @param Request $request
     */
    public function getRestaurantItemsBYCategory(Request $request)
    {
        $slug=$request->slug;
        $category_id=$request->category_id;
        $ids =$this->getCategoriesIds(ItemCategory::with('subcategories')->where('id', $category_id)->where('is_deleted', 0)->first());
      
        // Cache::forget('store-info-' . $slug);
        Cache::forever('items-cache', 'true');
        if (Cache::has('store-info-' . $slug)) {
            $restaurant = Cache::get('store-info-' . $slug);
        } else {
            $restaurant = Restaurant::where('slug', $slug)->first();
            $this->processSuperCache('store-info-' . $slug, $restaurant);
        }

        // Cache::forget('items-recommended-' . $restaurant->id);
        // Cache::forget('items-all-' . $restaurant->id);

        if (Cache::has('items-recommended-' . $restaurant->id) && Cache::has('items-all-' . $restaurant->id)) {
            $recommended = Cache::get('items-recommended-' . $restaurant->id);
            $array = Cache::get('items-all-' . $restaurant->id);
        } else {
            if (config('settings.showInActiveItemsToo') == 'true') {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')->whereIn('item_category_id', $ids)
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        $join->where('is_enabled', '1');
                    })
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as category_name'));
            } else {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')->whereIn('item_category_id', $ids)
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)->whereIn('item_category_id', $ids)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        $join->where('is_enabled', '1');
                    })
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as category_name'));
            }

            $items = json_decode($items, true);
            
            $items_cat=[];
            $array = [];


        
    
            if(count($items)>0){
            foreach ($items as $item) {
                $category=ItemCategory::where('id',$item['item_category_id'])->first();
                if($item['is_pizza']==1){
                    $items_cat[]=getItemPizza($item,$category);
                }else{
                    
    
                    if($item['old_price']=="0.00"){
                        $items_cat[]=getPriceFromAddons($item);
                    }else{
                        $items_cat[]=$item;
                    }
                    /* if($item['category_parent_id']== null){
                        $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                        //var_dump($category_parent);
                        $item['item_category_id']=$item['category_id']; 
                        $item['category_name']=$category_name->name;  
                        $array[$item['category_name']][] = $item;
                    }else{
                        $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                        //var_dump($category_parent);  
                        $item['item_category_id']=$item['category_parent_id']; 
                        $item['category_parent']=$category_parent->name;    
                        $array[$item['category_parent']][] = $item;
                    } */
                }
            }
            $category_name=$category->name;
            $array[$category_name]=$items_cat;  
        }

            
          

           // $this->processSuperCache('items-recommended-' . $restaurant->id, $recommended);
           // $this->processSuperCache('items-all-' . $restaurant->id, $array);
        }

        $recommended=[];

        return response()->json(array(
            'recommended' => $recommended,
            'items' => $array,
        ));

    }

           /**
     * @param Request $request
     */
    public function getRestaurantItemsBYSubCategory(Request $request)
    {
        $slug=$request->slug;
        $subcategory_id=$request->subcategory_id;
        //$ids =$this->getCategoriesIds(ItemCategory::with('subcategories')->where('id', $category_id)->first());
      
        // Cache::forget('store-info-' . $slug);
        Cache::forever('items-cache', 'true');
        if (Cache::has('store-info-' . $slug)) {
            $restaurant = Cache::get('store-info-' . $slug);
        } else {
            $restaurant = Restaurant::where('slug', $slug)->first();
            $this->processSuperCache('store-info-' . $slug, $restaurant);
        }

        // Cache::forget('items-recommended-' . $restaurant->id);
        // Cache::forget('items-all-' . $restaurant->id);

        if (Cache::has('items-recommended-' . $restaurant->id) && Cache::has('items-all-' . $restaurant->id)) {
            $recommended = Cache::get('items-recommended-' . $restaurant->id);
            $array = Cache::get('items-all-' . $restaurant->id);
        } else {
            if (config('settings.showInActiveItemsToo') == 'true') {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')->where('item_category_id', $subcategory_id)
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)->where('item_category_id', $subcategory_id)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        $join->where('is_enabled', '1');
                    })
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as category_name'));
            } else {
                $recommended = Item::where('restaurant_id', $restaurant->id)->where('is_recommended', '1')->where('item_category_id', $subcategory_id)
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get();

                // $items = Item::with('add')
                $items = Item::where('restaurant_id', $restaurant->id)->where('item_category_id', $subcategory_id)
                    ->join('item_categories', function ($join) {
                        $join->on('items.item_category_id', '=', 'item_categories.id');
                        $join->where('is_enabled', '1');
                    })
                    ->where('is_active', '1')
                    ->with('addon_categories')
                    ->with(array('addon_categories.addons' => function ($query) {
                        $query->where('is_active', 1);
                    }))
                    ->where('items.is_deleted', 0)
                    ->get(array('items.*', 'item_categories.name as category_name'));
            }

            $items = json_decode($items, true);

            $array = [];
            foreach ($items as $item) {
                $array[$item['category_name']][] = $item;
            }

            $this->processSuperCache('items-recommended-' . $restaurant->id, $recommended);
            $this->processSuperCache('items-all-' . $restaurant->id, $array);
        }

        return response()->json(array(
           // 'recommended' => $recommended,
            'items' => $array,
        ));

    }


    
     /**
     * @param Request $request
     */
    public function searchProductsBYRestaurants(Request $request)
    {
        //get lat and lng and query from user...
        // get all active restauants doing delivery & selfpickup
        $restaurants = Restaurant::where('name', 'LIKE', "%$request->q%")
            ->where('is_accepted', '1')
            ->take(20)->get();

     

        $items = Item::
            where('is_active', '1')
            ->where('name', 'LIKE', "%$request->q%")
            ->where('items.is_deleted', 0)
            ->where('restaurant_id',$request->restaurant_id)
            ->with('restaurant')
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();

            $items = json_decode($items, true);
            $nearMeItems= new Collection();

            

    
            if(count($items)>0){
            foreach ($items as $item) {
                $category=ItemCategory::where('id',$item['item_category_id'])->first();
                if($item['is_pizza']==1){
                    $item_pizza=getItemPizza($item,$category);
                    $nearMeItems->push($item_pizza);
                }else{
                    
    
                    if($item['old_price']=="0.00"){
                        $items_cat=getPriceFromAddons($item);
                        $nearMeItems->push($items_cat);
                    }else{
                        $nearMeItems->push($item);
                    }
                    /* if($item['category_parent_id']== null){
                        $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                        //var_dump($category_parent);
                        $item['item_category_id']=$item['category_id']; 
                        $item['category_name']=$category_name->name;  
                        $array[$item['category_name']][] = $item;
                    }else{
                        $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                        //var_dump($category_parent);  
                        $item['item_category_id']=$item['category_parent_id']; 
                        $item['category_parent']=$category_parent->name;    
                        $array[$item['category_parent']][] = $item;
                    } */
                }
            }
           
        }

        $response = [
            
            'items' => $nearMeItems->take(50),
        ];

        return response()->json($response);

    }

     //----ADD
    /**
     * @param Request $request
     */
    public function getFlyersBYRestaurant(Request $request)
    {
        $restaurant_id=$request->restaurant_id;

    $flyers = Flyer::where('end_date', '>=',now())
        ->where('start_date','<=', now())
        ->with('restaurants')
        ->whereHas('restaurants', function ($query) use ($restaurant_id) {
                $query->where('restaurants.id', $restaurant_id );
                })
        ->get();
    return response()->json($flyers);
    }
//-----ADD

  //----ADD
    /**
     * @param Request $request
     */
    public function getAllFlyers(Request $request)
    {

        // get all active restauants doing delivery
       /*  if (Cache::has('stores-delivery-active')) {
            $restaurants = Cache::get('stores-delivery-active');
        } else { */
            $restaurants = Restaurant::get();
            //$this->processSuperCache('stores-delivery-active', $restaurants);
        // }

        //Create a new Laravel collection from the array data
        $nearMe = new Collection();

        foreach ($restaurants as $restaurant) {
            // $distance = $this->getDistance($request->latitude, $request->longitude, $restaurant->latitude, $restaurant->longitude);
            // if ($distance <= $restaurant->delivery_radius) {
            //     $nearMe->push($restaurant);
            // }
            //$check = $this->checkOperation($request->latitude, $request->longitude, $restaurant);
            //if ($check) {
            //    $nearMe->push($restaurant);
            //}
            //-ADD 
            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
            
            $restaurant['distance']=$restaurant_distance;
           // $categories=$restaurant->restaurant_categories()->get();//RestaurantCategory::all();
           // $restaurant->categories=$categories;
             if ($restaurant_distance <= 20) {
                 $nearMe->push($restaurant);
             } //-ADD
        }
        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $nearMe = $nearMe->map(function ($restaurant) {
            return $restaurant->only(['id']);
        });// ADD - acrescentado novos campos
       // $nearMe = $nearMe->sortBy('distance');
        // $onlyInactive = $nearMe->where('is_active', 0)->get();
        // dd($onlyInactive);
        $nearMe = $nearMe->toArray();


        $restaurant_ids=$nearMe;

        $flyers = Flyer::where('end_date', '>=',now())
        ->where('start_date','<=', now())
        ->with('restaurants')
        ->whereHas('restaurants', function ($query) use ($restaurant_ids) {
                $query->whereIn('restaurants.id', $restaurant_ids );
                })
        
        ->get();
    return response()->json($flyers);
    }


   
//-----ADD

};
