<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Flyer;
use App\Sorteio;
use App\Coupon;
use App\PromoSlider;
use App\Slide;
use App\User;
use App\RestaurantCategory;
use App\RestaurantRecommend;
use App\RestaurantApply;
use App\RestaurantTester;
use App\UserLocation;
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
use Spatie\OpeningHours\OpeningHours;




class RestaurantController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
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
    public function getHomeData(Request $request)
    {
        // Cache::forget('stores-delivery-active');
        // Cache::forget('stores-delivery-inactive');
        // die();
      
        // get all active restauants doing delivery
       // if (Cache::has('stores-delivery-active')) {
       //     $restaurants = Cache::get('stores-delivery-active');
        //} else {
         
           // $this->processSuperCache('stores-delivery-active', $restaurants);
       // }

     
            
       
        //Create a new Laravel collection from the array data
        $nearMe = new Collection();
        $nearMeInActive = new Collection();
        /* $nearMeID = new Collection();
        $nearMeInActiveID = new Collection();
        $nearMeIDothers = new Collection();
        $nearMeInActiveIDothers = new Collection(); */

        if($request->user_id!=0){
            $user=User::where('id',$request->user_id)->first();

            if($user->user_type=="LicencerTest"){
                $restaurant_tester=UserLocation::where('user_tester_id',$request->user_id)->first();
                $restaurants=Restaurant::where('location_id',$restaurant_tester->location_id)->get();
           
                foreach($restaurants as $restaurant){

                    if($restaurant){
    
                        if($restaurant->is_accepted==0){
                            
                            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
                            $restaurant['distance']=$restaurant_distance;
                            $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
                            $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
                            $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        
                            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->get();
                    
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
                
                            $nearMe->push($restaurant);
        
                        }
                        
                       
                    } 
            
                }

            }else{
                $restaurant_testerr=RestaurantTester::where('user_tester_id',$request->user_id)->get();

                foreach($restaurant_testerr as $restaurant_tester){

                    if($restaurant_tester){
    
                        
                        $restaurant=Restaurant::where('id',$restaurant_tester->restaurant_id)->first();
        
                        if($restaurant->is_accepted==0){
                            
                            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
                            $restaurant['distance']=$restaurant_distance;
                            $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
                            $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
                            $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
        
                            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->get();
                    
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
                
                            $nearMe->push($restaurant);
        
                        }
                        
                       
                    } 
            
                }

            }

            


           

        }

        
if($user->id == 1){
    $restaurants = Restaurant::where('is_test', null)->get();  
}else{
    $restaurants = Restaurant::where('is_accepted', '1')
    //->where('is_active', 1)
    //->whereIn('delivery_type', [1, 3])
    ->get();   
}
       
       


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
            $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
            $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
            $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();

            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->get();

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
      /*       $delivery_tax='';
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
            $restaurant['delivery_tax']=$delivery_tax; */
           

             if ($restaurant_distance <= $restaurant->delivery_radius) {
                    
                 if($restaurant->is_active == 1){
                    $nearMe->push($restaurant);
                    
                 }else{
                    $nearMeInActive->push($restaurant);
                    
                 }
                 
             } //-ADD
        }

        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $active = $nearMe->map(function ($restaurant) {
            return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
        })->sortBy('distance');// ADD - acrescentado novos campos

        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $active_restaurants = $active->toArray();// ADD - acrescentado novos campos

        $active_restaurants_ids=$active->map(function ($restaurant) {
            return $restaurant->only(['id']);
        })->sortBy('distance')->toArray();// ADD - acrescentado novos campos
        
        $active_restaurants_others=$nearMe->map(function ($restaurant) {
            return $restaurant->only(['id' , 'distance', 'restaurant_items']);
        })->sortBy('distance')->toArray();// ADD - acrescentado novos campos
        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $inactive = $nearMeInActive->map(function ($restaurant) {
            return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
        })->sortBy('distance');// ADD - acrescentado novos campos


        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $inactive_restaurants = $inactive->toArray();// ADD - acrescentado novos campos

        $inactive_restaurants_ids=$inactive->map(function ($restaurant) {
            return $restaurant->only(['id']);
        })->sortBy('distance')->toArray();// ADD - acrescentado novos campos

        $inactive_restaurants_others=$nearMeInActive->map(function ($restaurant) {
            return $restaurant->only(['id' , 'distance' , 'restaurant_items']);
        })->sortBy('distance')->toArray();// ADD - acrescentado novos campos

        $merged = array_merge($active_restaurants, $inactive_restaurants);
       
        $restaurantIds = array_merge($active_restaurants_ids, $inactive_restaurants_ids);
        $restaurantOthers = array_merge($active_restaurants_others, $inactive_restaurants_others);


$categories = RestaurantCategory::where('is_active', '1')->get();

if (Cache::has('other-position-slider')) {
    $otherPosition = Cache::get('other-position-slider');
} else {
    $otherPosition = PromoSlider::whereIn('position_id', [1, 2, 3, 4, 5, 6])->where('is_active', 1)->first();
    $this->processSuperCache('other-position-slider', $otherPosition);
}

if ($otherPosition) {

    // Cache::forget('other-position-slides-' . $otherPosition->id)

    if (Cache::has('other-position-slides-' . $otherPosition->id)) {
        $otherSlides = Cache::get('other-position-slides-' . $otherPosition->id);
    } else {
        $otherSlides = Slide::where('promo_slider_id', $otherPosition->id)
            ->where('is_active', '1')
            ->with('promo_slider')
            ->ordered()
            ->get();
        $this->processSuperCache('other-position-slides-' . $otherPosition->id, $otherSlides);
    }
    
    $slides_array=[];
     foreach($otherSlides as $slide){

        $slider=[
            'id'=>$slide->id,
            'image'=>$slide->image,
            'url'=>$slide->url,
            'data'=>json_decode($slide->data),
        ];
        array_push($slides_array,$slider);
        //$data=json_decode($slide->data);
        //$otherSlides['data']=$data;
    } 
    $otherSlides= $slides_array;
} else {
    $otherSlides = null;
}



        $response=[
            'restaurants'=>array_slice($merged, 0, 20),
            'restaurantsIds'=>$restaurantIds,
            'restaurantsOthers'=>$restaurantOthers,
            'categories' => $categories,
            'otherSlides' => $otherSlides,
           
        ];

        return response()->json($response);
    }



    /**
     * @param Request $request
     * @return mixed
     */
    public function getfreeShippingRestaurants(Request $request)
    {
        // Cache::forget('stores-delivery-active');
        // Cache::forget('stores-delivery-inactive');
        // die();

        
            $restaurants = Restaurant::where('is_accepted', '1')
                ->where('is_active', 1)
                ->with('categories')
                ->where('delivery_charge_type','FREE')
                ->whereIn('id', $request->restaurantsIds)
                ->ordered()
                ->get();
            $this->processSuperCache('stores-delivery-active', $restaurants);
       

        
        return response()->json($this->paginate($restaurants));
    }



 
 

   
    /**
     * @param Request $request
     */
    public function getAllRestaurants(Request $request)
    {

        $restaurants = Restaurant::where('is_accepted', '1')
        ->with('restaurant_categories')
        ->whereIn('id',$request->restaurantsIds)
        ->orderBy('is_active','desc')
        ->get();


    return response()->json($this->paginate($restaurants));


    }




    public function anotherRestaurantData(Request $request)
    {



        $restaurant = Restaurant::where('id', $request->restaurant_id)
        ->first();

        $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
            $restaurant['distance']=$restaurant_distance;
            $restaurant['restaurant_flyers']=Flyer::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
            $restaurant['restaurant_sorteios']=Sorteio::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();
            $restaurant['restaurant_coupon']=Coupon::where('restaurant_id',$restaurant->id)->where('is_active',1)->where('is_deleted',0)->count();

            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->get();

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


        ///----Verificando Horários de Delivery ------///
        if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3)){
                $data=str_replace('"open" :','',$restaurant->schedule_data);
                $data1=str_replace('","close" :"','-',$data);
                $data2=str_replace('{"','"',$data1);
                $data3=str_replace('"}','"',$data2);
                $data4='{'.$data3;
            
                $schedule=  (array) json_decode($data4);
                $schedule_data= OpeningHours::createAndMergeOverlappingRanges($schedule);

                $nextOpenDelivery=$schedule_data->nextOpen(now()); 
                $nextCloseDelivery=$schedule_data->nextClose(now()); 
                $isOpenDeliveryNow= $schedule_data->isOpenAt(now());
        }else{
                $nextOpenDelivery=null; 
                $nextCloseDelivery=null; 
                $isOpenDeliveryNow= null; 
        }

        ///----Verificando Horários de Delivery - FIM ------///

        if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3)){
                ///----Verificando Horários de Retirada ------///
                $data=str_replace('"open" :','',$restaurant->working_time);
                $data1=str_replace('","close" :"','-',$data);
                $data2=str_replace('{"','"',$data1);
                $data3=str_replace('"}','"',$data2);
                $data4=str_replace('_','',$data3);
                $data5='{'.$data4;

                $schedule=  (array) json_decode($data5);
                $working_time= OpeningHours::createAndMergeOverlappingRanges($schedule);

                $nextOpenSelfpickup=$working_time->nextOpen(now()); 
                $nextCloseSelfpickup=$working_time->nextClose(now()); 
                $isOpenSelfpickupNow= $working_time->isOpenAt(now());
        }else{
            $nextOpenSelfpickup=null; 
            $nextCloseSelfpickup=null; 
            $isOpenSelfpickupNow=null;
        }
       
        ///----Verificando Horários de Retirada - FIM ------///
      
        /// ---- Verificando Taxa de Entrega e Tempo de Entrega ----------////

        $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $restaurant);
        $restaurantData['distance']=$restaurant_distance;
      
        $delivery_time_vector=(array) json_decode($restaurant->delivery_time_vector);
        $delivery_tax='';
        $delivery_time=null;
        $delivery_time_type=null;


        // CALCULANDO TAXA DE ENTREGA - INICIO --------------------------
        foreach($delivery_time_vector as $row){
            if($row->km >= $restaurant_distance){
                if(isset($request->amount)){
                        if($row->price_free_shipping !=null && $restaurant->price_free_shipping_active==1 ){
                        
                            if($request->amount >= $row->price_free_shipping){
                                $delivery_tax='0.00';
                            }else{
                                $delivery_tax=str_replace(',','.',$row->price);
                            }
                        
                        }else{
                            $delivery_tax=str_replace(',','.',$row->price); 
                        }
                }
                else{
                    $delivery_tax=str_replace(',','.',$row->price);
                }
                $delivery_time=$row->time;
                $delivery_time_type=$row->type;
                break;
            }
        }

   
        // CALCULANDO TAXA DE ENTREGA - FIM --------------------------
        /// ---- Verificando Taxa de Entrega e Tempo de Entrega FIM ----------////


        $selfpickup_text='';
        $cart_delivery_time_text=$delivery_time.' '.'';
        $cart_selfpickup_time_text=''; 
        $is_closed_text='';

        if($isOpenDeliveryNow){
            $delivery_text= $delivery_time.' '.$delivery_time_type;  
            $cart_delivery_time_text=$delivery_time.' '.$delivery_time_type;
        }
        if($isOpenDeliveryNow == false){
            $delivery_text= $delivery_time.' '.$delivery_time_type;  
            $cart_delivery_time_text=$delivery_time.' '.$delivery_time_type;
        }
        

        if($isOpenSelfpickupNow){
            $selfpickup_text= $restaurant->selfpickup_time.' '.$restaurant->selfpickup_time_type;  
            $cart_selfpickup_time_text=$restaurant->selfpickup_time.' '.$restaurant->selfpickup_time_type;
        }
        if($isOpenSelfpickupNow == false){
            $selfpickup_text= $restaurant->selfpickup_time.' '.$restaurant->selfpickup_time_type; 
            $cart_selfpickup_time_text=$restaurant->selfpickup_time.' '.$restaurant->selfpickup_time_type; 
        }





            $restaurant_itens=Item::where('restaurant_id',$restaurant->id)->get();
            if(!empty($restaurant_itens))
            {
                if(count($restaurant_itens) == 0) {
                    $restaurantcountitens=0;
                }
                else {
                    $restaurantcountitens=count($restaurant_itens);
                }
            } 

                     


        $add = new Restaurant();
        $is_favorite=$add->isFavorites($request->user_id, $request->restaurant_id);

        $message_popup_title=null;//'LOJA FECHADA, mas RECEBENDO PEDIDOS!';
        $message_popup_text=null;//'Olá, esta loja está fechada no momento, mas irá abrir daqui a 2 horas. Mas você já pode fazer seu pedido e aguardar para receber ou retirar na loja';
        $message_checkout_delivery_title=null;//'Olá, só um detalhe!';
        $message_checkout_delivery_text=null;//'<p>A previsão de entrega é de 2 a 4horas, ok?<p><p><strong>Tempo de Entrega</strong> 2 dias</p>';
        $message_checkout_selfpickup_title=null;//'Olá, só um detalhe!';
        $message_checkout_selfpickup_text=null;//'A loja está fechada no momento para retirada, mas você poderá retirar na loja amanhã, de 08 às 18hs.';
        
        
        
        $is_open=$restaurant->is_active;

        //$delivery_text='2 - 4hs';




        $response=[
            'restaurant'=>$restaurant,
            'is_favorite'=>$is_favorite,
            'delivery_tax'=>$delivery_tax,
            'delivery_charge'=>$delivery_tax,
            'restaurant_items'=>$restaurantcountitens,
            'restaurant_distance'=>$restaurant_distance,
            'message_popup_title'=>$message_popup_title,
            'message_popup_text'=>$message_popup_text,
            'message_checkout_delivery_title'=>$message_checkout_delivery_title,
            'message_checkout_delivery_text'=>$message_checkout_delivery_text,
            'message_checkout_selfpickup_title'=>$message_checkout_selfpickup_title,
            'message_checkout_selfpickup_text'=>$message_checkout_selfpickup_text,
            'cart_delivery_time_text'=>$cart_delivery_time_text,
            'cart_selfpickup_time_text'=>$cart_selfpickup_time_text,
            'is_open'=> $is_open,
            'is_closed_text'=>$is_closed_text,
            'delivery_text'=>$delivery_text,
            'selfpickup_text'=>$selfpickup_text,


        ];
        
       
            return response()->json($response);


    }



    
   /**
     * @param Request $request
     */
    public function sendRestaurantApply(Request $request)
    {
       
            $restaurant_apply = new RestaurantApply();
            $restaurant_apply->state = $request->state;
            $restaurant_apply->city = $request->city;
            $restaurant_apply->name = $request->name;
            $restaurant_apply->company = $request->company;
            $restaurant_apply->phone = $request->phone;
            $restaurant_apply->email = $request->email;
            $restaurant_apply->user_id = $request->user_id;
            
            $restaurant_apply->save();
            $response=[
                'sucess'=> true,
                'data'=> $restaurant_apply,
            ];
            return response()->json($response);
       
       

    }

       /**
     * @param Request $request
     */
    public function sendRestaurantReccomend(Request $request)
    {
        
            $RestaurantRecommend = new RestaurantRecommend();
            $RestaurantRecommend->state = $request->state;
            $RestaurantRecommend->city = $request->city;
            $RestaurantRecommend->name = $request->name;
            $RestaurantRecommend->company = $request->company;
          
            $RestaurantRecommend->user_id = $request->user_id;
            
            $RestaurantRecommend->save();
            $response=[
                'sucess'=> true,
                'data'=> $RestaurantRecommend,
            ];
            return response()->json($response);
      
       

    }



};
