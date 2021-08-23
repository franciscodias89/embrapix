<?php

namespace App\Http\Controllers\ApiSeparador;

use App\Http\Controllers\Controller;
use App\Item;
use App\ItemCategory;
use App\Restaurant;
use App\Flyer;
use App\Log;
use App\RestaurantCategory;
use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\AcceptDelivery;
use App\Address;
use App\Rating;
use App\RestaurantFavorite;
use App\User;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;
use JWTAuth;
use App\Iugu;
use App\Iugulog;
use JWTAuthException;
use Spatie\Permission\Models\Role;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use App\Addon;
use App\Coupon;

use App\Helpers\TranslationHelper;
use App\IuguLr;
use App\IuguSubaccount;
use App\IuguSubaccountCustomer;
use App\Order;
use App\Orderissue;
use App\Orderitem;
use App\OrderItemAddon;
use App\Orderstatus;
use App\PushNotify;
use App\PushToken;
use App\Sms;
use Hashids;
use Omnipay\Omnipay;
use OneSignal;
use Mail;



class OrderController extends Controller
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
    public function OrderDetails(Request $request)
    {
        $user = auth()->user();

        if ($user) {
// ALTERADO - inclui id, city, complement, etc..
           

            $running_order = Order::where('restaurant_id', $user->restaurant_id)
                ->whereIn('orderstatus_id', ['1', '2', '3', '4', '5', '6', '7', '8']) //ALTERADO - inclui o 5  e 6
                ->where('unique_order_id', $request->unique_order_id)
                ->with('orderitems', 'orderitems.order_item_addons', 'restaurant')
                //->where('orderitems.replaced_by',null)
                ->first();

                $user_order=User::where('id',$running_order->user_id)->first();
                           
               
                $running_order['user_name']= $user_order->name;
                $running_order['user_phone']=$user_order->phone;
                $running_order['user_avatar']=$user_order->avatar;


                if ($user_order->default_address_id !== 0) {
                    $default_address = \App\Address::where('id', $user_order->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                } else {
                    $default_address = null;
                }

            $delivery_details = null;
            if ($running_order) {
                if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 || $running_order->orderstatus_id == 5) {
                    //get assigned delivery guy and get the details to show to customers
                    $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                    if ($delivery_guy) {
                        $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                        $delivery_details = $delivery_user->delivery_guy_detail;
                        if (!empty($delivery_details)) {
                            $delivery_details = $delivery_details->toArray();
                            $delivery_details['phone'] = $delivery_user->phone;
                        }
                    }
                }
            }
            //ALTERADO daqui pra baixo
            $previsao_entrega=null;
            $message =null;
            if($running_order->orderstatus_id == 1){
                $message =[
                    'title'=>'Pedido Realizado',
                    'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                ];
            }
            if($running_order->orderstatus_id == 2){
                $message =[
                    'title'=>'Preparando seu Pedido',
                    'description' => 'Seu pedido está sendo preparado'
                ];
            }
            if($running_order->orderstatus_id == 3){
                $message =[
                    'title'=>'Pedido Realizado com Sucesso',
                    'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                ];
            }
            if($running_order->orderstatus_id == 4){
                $message =[
                    'title'=>'Pedido saiu para Entrega',
                    'description' => 'Em breve você receberá o seu pedido!'
                ];
            }
            if($running_order->orderstatus_id == 5){
                $message =[
                    'title'=>'Pedido Entregue',
                    'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                ];
            }
            if($running_order->orderstatus_id == 6){
                $message =[
                    'title'=>'Pedido Cancelado',
                    'description' => 'Que Pena! Seu pedido foi Cancelado!'
                ];
            }
            if($running_order->orderstatus_id == 7){
                $message =[
                    'title'=>'Pronto para Retirada',
                    'description' => 'Oba! Você já pode retirar o seu pedido!'
                ];
            }
            if($running_order->orderstatus_id == 8){
                $message =[
                    'title'=>'Pedido Realizado com Sucesso',
                    'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                ];
            }
           
            $rating_order = Rating::where('order_id', $running_order->id)->where('rateable_type','App\Restaurant')->get();
                if ($rating_order->isEmpty()) {
                    $running_order['rating_order']=null;  
                } else {
                    $running_order['rating_order']=$rating_order;
                }

                $rating_delivery = Rating::where('order_id', $running_order->id)->where('rateable_type','App\User')->get();
                if ($rating_delivery->isEmpty()) {
                    $running_order['rating_delivery']=null;  
                } else {
                    $running_order['rating_delivery']=$rating_delivery;
                }

            $location=json_decode($running_order->location);
            $running_order['location']=$location;
            $response = [
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'auth_token' => $user->auth_token,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'provider' => $user->provider,
                    'avatar'=> $user->avatar,
                    'default_address_id' => $user->default_address_id,
                    'default_address' => $default_address,
                    'delivery_pin' => $user->delivery_pin,
                    'wallet_balance' => $user->balanceFloat,
                    'avatar' => $user->avatar,
                ],
                  
                'previsao_entrega'=> $previsao_entrega,//ALTERADO
                'message' => $message,//ALTERADO
                'running_order' => $running_order,
                'delivery_details' => $delivery_details,
            ];

            return response()->json($response);
        }

    }

    /**
     * @param $restaurant_id
     */
    private function smsToDelivery($restaurant_id)
    {
        //get restaurant
        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            //get all pivot users of restaurant (Store Ownerowners)
            $pivotUsers = $restaurant->users()
                ->wherePivot('restaurant_id', $restaurant_id)
                ->get();
            //filter only res owner and send notification.
            foreach ($pivotUsers as $pU) {
                if ($pU->hasRole('Delivery Guy')) {
                    if ($pU->delivery_guy_detail->is_notifiable) {
                        $message = config('settings.defaultSmsDeliveryMsg');
                        // As its not an OTP based message Nulling OTP
                        $otp = null;
                        $smsnotify = new Sms();
                        $smsnotify->processSmsAction('OD_NOTIFY', $pU->phone, $otp, $message);
                    }
                }
            }
        }
    }

    private function sendPushNotificationStoreOwner($restaurant_id)
    {
        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            //get all pivot users of restaurant (Store Ownerowners)
            $pivotUsers = $restaurant->users()
                ->wherePivot('restaurant_id', $restaurant_id)
                ->get();
            //filter only res owner and send notification.
            foreach ($pivotUsers as $pU) {
                if ($pU->hasRole('Store Owner')) {
                    // \Log::info('Send Push notification to store owner');
                    $message = config('settings.restaurantNewOrderNotificationMsg');
                    OneSignal::sendNotificationToExternalUser(
                        $message,
                        $pU->id,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null
                    );
                }
            }
        }
    }


    /**
     * @param Request $request
     */
    public function getOrders(Request $request)

    {
        $type = $request->type;
        $user = auth()->user();
        if ($user) {

            if($type=='new'){
                $orders_running = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '11')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                $orders_finished = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '13')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
         
                $running=array();


               
                
               // dd($orders_running);
                foreach ($orders_running as $order){

                    $user_order=User::where('id',$order->user_id)->first();
                               
                    if($user_order){
                        $running_order = $order;
                        $running_order['user_name']= $user_order->name;
                        $running_order['user_phone']=$user_order->phone;
                        $running_order['user_avatar']=$user_order->avatar;
                    }else{
                        $running_order = $order;
                        $running_order['user_name']= 'Desconhecido';//$user_order->name;
                        $running_order['user_phone']='';//$user_order->phone;
                        $running_order['user_avatar']='';//$user_order->avatar;
                    }

        
                    $delivery_details = null;
                    if ($running_order) {
                        if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 ) {
                            //get assigned delivery guy and get the details to show to customers
                            $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                            if ($delivery_guy) {
                                $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                                $delivery_details = $delivery_user->delivery_guy_detail;
                                if (!empty($delivery_details)) {
                                    $delivery_details = $delivery_details->toArray();
                                    $delivery_details['phone'] = $delivery_user->phone;
                                }
                            }
                        }
                    }
                    //ALTERADO daqui pra baixo
                    $previsao_entrega=null;
                    $message =null;
                    if($running_order->orderstatus_id == 1){
                        $message =[
                            'title'=>'Pedido Realizado',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    if($running_order->orderstatus_id == 2){
                        $message =[
                            'title'=>'Preparando seu Pedido',
                            'description' => 'Seu pedido está sendo preparado'
                        ];
                    }
                    if($running_order->orderstatus_id == 3){
                        $message =[
                            'title'=>'Pedido Realizado com Sucesso',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    if($running_order->orderstatus_id == 4){
                        $message =[
                            'title'=>'Pedido saiu para Entrega',
                            'description' => 'Em breve você receberá o seu pedido!'
                        ];
                    }
                    if($running_order->orderstatus_id == 5){
                        $message =[
                            'title'=>'Pedido Entregue',
                            'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                        ];
                    }
                    if($running_order->orderstatus_id == 6){
                        $message =[
                            'title'=>'Pedido Cancelado',
                            'description' => 'Que Pena! Seu pedido foi Cancelado!'
                        ];
                    }
                    if($running_order->orderstatus_id == 7){
                        $message =[
                            'title'=>'Pronto para Retirada',
                            'description' => 'Oba! Você já pode retirar o seu pedido!'
                        ];
                    }
                    if($running_order->orderstatus_id == 8){
                        $message =[
                            'title'=>'Pedido Realizado com Sucesso',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    $rating = Rating::where('order_id', $running_order->id)->get();
                if ($rating->isEmpty()) {
                    $running_order['rating']=null;  
                } else {
                    $running_order['rating']=$rating;
                }
                    $location=json_decode($running_order->location);
                    $running_order['location']=$location;
                    $running[] = [
                        'success' => true,
                        'data' => [
                            'id' => $user->id,
                            'auth_token' => $user->auth_token,
                        ],
                        
                        'previsao_entrega'=> $previsao_entrega,//ALTERADO
                        'message' => $message,//ALTERADO
                        'running_order' => $running_order,
                        'delivery_details' => $delivery_details,
                    ];
    
    
                };
            }
          
            if($type=='running'){
                $orders_running = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '12')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                $orders_finished = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '13')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
         
                $running=array();


               
                
               // dd($orders_running);
                foreach ($orders_running as $order){

                    $user_order=User::where('id',$order->user_id)->first();
                               
                    if($user_order){
                        $running_order = $order;
                        $running_order['user_name']= $user_order->name;
                        $running_order['user_phone']=$user_order->phone;
                        $running_order['user_avatar']=$user_order->avatar;
                    }else{
                        $running_order = $order;
                        $running_order['user_name']= 'Desconhecido';//$user_order->name;
                        $running_order['user_phone']='';//$user_order->phone;
                        $running_order['user_avatar']='';//$user_order->avatar;
                    }
                   

        
                    $delivery_details = null;
                    if ($running_order) {
                        if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 ) {
                            //get assigned delivery guy and get the details to show to customers
                            $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                            if ($delivery_guy) {
                                $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                                $delivery_details = $delivery_user->delivery_guy_detail;
                                if (!empty($delivery_details)) {
                                    $delivery_details = $delivery_details->toArray();
                                    $delivery_details['phone'] = $delivery_user->phone;
                                }
                            }
                        }
                    }
                    //ALTERADO daqui pra baixo
                    $previsao_entrega=null;
                    $message =null;
                    if($running_order->orderstatus_id == 1){
                        $message =[
                            'title'=>'Pedido Realizado',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    if($running_order->orderstatus_id == 2){
                        $message =[
                            'title'=>'Preparando seu Pedido',
                            'description' => 'Seu pedido está sendo preparado'
                        ];
                    }
                    if($running_order->orderstatus_id == 3){
                        $message =[
                            'title'=>'Pedido Realizado com Sucesso',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    if($running_order->orderstatus_id == 4){
                        $message =[
                            'title'=>'Pedido saiu para Entrega',
                            'description' => 'Em breve você receberá o seu pedido!'
                        ];
                    }
                    if($running_order->orderstatus_id == 5){
                        $message =[
                            'title'=>'Pedido Entregue',
                            'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                        ];
                    }
                    if($running_order->orderstatus_id == 6){
                        $message =[
                            'title'=>'Pedido Cancelado',
                            'description' => 'Que Pena! Seu pedido foi Cancelado!'
                        ];
                    }
                    if($running_order->orderstatus_id == 7){
                        $message =[
                            'title'=>'Pronto para Retirada',
                            'description' => 'Oba! Você já pode retirar o seu pedido!'
                        ];
                    }
                    if($running_order->orderstatus_id == 8){
                        $message =[
                            'title'=>'Pedido Realizado com Sucesso',
                            'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                        ];
                    }
                    $rating = Rating::where('order_id', $running_order->id)->get();
                if ($rating->isEmpty()) {
                    $running_order['rating']=null;  
                } else {
                    $running_order['rating']=$rating;
                }
                    $location=json_decode($running_order->location);
                    $running_order['location']=$location;
                    $running[] = [
                        'success' => true,
                        'data' => [
                            'id' => $user->id,
                            'auth_token' => $user->auth_token,
                        ],
                        
                        'previsao_entrega'=> $previsao_entrega,//ALTERADO
                        'message' => $message,//ALTERADO
                        'running_order' => $running_order,
                        'delivery_details' => $delivery_details,
                    ];
    
    
                };
            }
           if ($type=='finished'){
            $orders_finished = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '13')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            $orders_running = Order::where('restaurant_id', $user->restaurant_id)->where('separation_status', '12')->where('separator_id',$user->id)->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            
            $finished=array();
            foreach ($orders_finished as $order){

                $user_order=User::where('id',$order->user_id)->first();
                           
                if($user_order){
                    $running_order = $order;
                    $running_order['user_name']= $user_order->name;
                    $running_order['user_phone']=$user_order->phone;
                    $running_order['user_avatar']=$user_order->avatar;
                }else{
                    $running_order = $order;
                    $running_order['user_name']= 'Desconhecido';//$user_order->name;
                    $running_order['user_phone']='';//$user_order->phone;
                    $running_order['user_avatar']='';//$user_order->avatar;
                }
    
                $delivery_details = null;
                if ($running_order) {
                    if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 || $running_order->orderstatus_id == 5) {
                        //get assigned delivery guy and get the details to show to customers
                        $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                        if ($delivery_guy) {
                            $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                            $delivery_details = $delivery_user->delivery_guy_detail;
                            if (!empty($delivery_details)) {
                                $delivery_details = $delivery_details->toArray();
                                $delivery_details['phone'] = $delivery_user->phone;
                            }
                        }
                    }
                }
                //ALTERADO daqui pra baixo
                $previsao_entrega=null;
                $message =null;
                if($running_order->orderstatus_id == 1){
                    $message =[
                        'title'=>'Novo Pedido',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }
                if($running_order->orderstatus_id == 2){
                    $message =[
                        'title'=>'Preparando Pedido',
                        'description' => 'Seu pedido está sendo preparado'
                    ];
                }
                if($running_order->orderstatus_id == 3){
                    $message =[
                        'title'=>'Pedido Realizado com Sucesso',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }
                if($running_order->orderstatus_id == 4){
                    $message =[
                        'title'=>'Pedido saiu para Entrega',
                        'description' => 'Em breve você receberá o seu pedido!'
                    ];
                }
                if($running_order->orderstatus_id == 5){
                    $message =[
                        'title'=>'Pedido Entregue',
                        'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                    ];
                }
                if($running_order->orderstatus_id == 6){
                    $message =[
                        'title'=>'Pedido Cancelado',
                        'description' => 'Que Pena! Seu pedido foi Cancelado!'
                    ];
                }
                if($running_order->orderstatus_id == 7){
                    $message =[
                        'title'=>'Pronto para Retirada',
                        'description' => 'Oba! Você já pode retirar o seu pedido!'
                    ];
                }
                if($running_order->orderstatus_id == 8){
                    $message =[
                        'title'=>'Pedido Realizado com Sucesso',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }
                $rating_order = Rating::where('order_id', $running_order->id)->where('rateable_type','App\Restaurant')->get();
                if ($rating_order->isEmpty()) {
                    $running_order['rating_order']=null;  
                } else {
                    $running_order['rating_order']=$rating_order;
                }

                $rating_delivery = Rating::where('order_id', $running_order->id)->where('rateable_type','App\User')->get();
                if ($rating_delivery->isEmpty()) {
                    $running_order['rating_delivery']=null;  
                } else {
                    $running_order['rating_delivery']=$rating_delivery;
                }
                $location=json_decode($running_order->location);
                
                $running_order['location']=$location;
                $finished[] = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $user->auth_token,
                       
                    ],
                    
                    'previsao_entrega'=> $previsao_entrega,//ALTERADO
                    'message' => $message,//ALTERADO
                    'running_order' => $running_order,
                    'delivery_details' => $delivery_details,
                ];
            

            }
            $running=$finished;
           }
            
                        
            $response=$this->paginate($running);
           // $response[0]['running_total']=count($orders_running);
            //$response[0]['finished_total']=count($orders_finished);

           
            return response()->json($response);
        }
        return response()->json(['success' => false], 401);
    }

    /**
     * @param Request $request
     */
    public function getOrderItems(Request $request)
    {
        $user = auth()->user();
        if ($user) {

            $items = Orderitem::where('order_id', $request->order_id)->get();
            return response()->json($items);
        }
        return response()->json(['success' => false], 401);

    }



       /**
     * @param $id
     */
    public function acceptSeparation(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->separation_status == '11') {
            $order->separation_status = 12;
            $order->separator_id = $user->id;
            $order->assign_separation_at = now();
            $order->save();

         

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => true]);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }

           /**
     * @param $id
     */
    public function markAsSeparated(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->separation_status == '12') {
            $order->separation_status = 13;
           $order->separated_at = now();
            ////CALCULAR AQUI DE NOVO O PREÇO FINAL DO PEDIDO E ENVIAR PUSH PARA O USUÁRIO dizendo que o pedido já está separado e com o novo preço calculado
            $order->save();

         

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => true]);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }


            /**
     * @param $id
     */
    public function markItemAsSeparated(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
       

        $order_item = OrderItem::where('id', $id)->first();

        if ($order_item) {
            $order_item->status_separation = 1;
            if(isset($request->separator_obs)){
                $order_item->separator_obs = $request->separator_obs;
            }
            $order_item->save();

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => true]);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }


            /**
     * @param $id
     */
    public function getItemByEan(Request $request)
    {
        $ean=$request->ean;
        $user = auth()->user();
       

        $item = Item::where('restaurant_id', $user->restaurant_id)->where('ean', $ean)->first();

        $response=[
            'item'=>$item
        ];
        return response()->json($response);
       
    }

                /**
     * @param $id
     */
    public function markItemAsUnavailable(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
       

        $order_item = OrderItem::where('id', $id)->first();

        if ($order_item) {
            $order_item->status_separation = 2;
            if(isset($request->separator_obs)){
                $order_item->separator_obs = $request->separator_obs;
            }
            $order_item->save();

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => true]);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }


                /**
     * @param $id
     */
    public function substituteItem(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
       

        $order_item = OrderItem::where('id', $id)->first();

        if ($order_item) {

            $replaced_item= new OrderItem();
            $replaced_item->order_id = $order_item->order_id;
            $replaced_item->item_id = $request->item_id;
            $replaced_item->name = $request->name;
            $replaced_item->quantity = $request->quantity;
            $replaced_item->peso = $request->peso;
            $replaced_item->unidade = $request->unidade;
            $replaced_item->price = $request->price;
            $replaced_item->image = $request->image;
            $replaced_item->ean = $request->ean;
            $replaced_item->codint = $request->codint;
            if(isset($request->separator_obs)){
                $replaced_item->separator_obs = $request->separator_obs;
            }
            
            $replaced_item->item_obs = $request->item_obs;
            $replaced_item->status_separation = 1;
            $replaced_item->save();



            $order_item->replaced_by = $replaced_item->id;
            $order_item->status_separation = 2;
            $order_item->save();

            $items = Orderitem::where('order_id', $order_item->order_id)->get();
            $response=[
                'success'=>true,
                'items'=>$items
            ];

            if (\Illuminate\Support\Facades\Request::ajax()) {

                return response()->json($response);
            } else {
                return response()->json($response);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }

                /**
     * @param $id
     */
    public function updateItem(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
       

        $order_item = OrderItem::where('id', $id)->first();
$quantity_old= $order_item->quantity;
$peso_old =$order_item->peso;
$price_old =$order_item->price;

        if ($order_item) {
            if(isset($request->peso)){
                $order_item->price = $request->price;
                $order_item->peso = $request->peso;
                
                $order_item->price_old = $price_old;
                $order_item->peso_old = $peso_old;
                
                $order_item->status_separation = 1;
            }else{
                $order_item->price = $request->price;
               
                $order_item->quantity = $request->quantity;
                $order_item->price_old = $price_old;
               
                $order_item->quantity_old = $quantity_old;
                $order_item->status_separation = 1;
            }
            
            if(isset($request->separator_obs)){
                $order_item->separator_obs = $request->separator_obs;
            }

            $order_item->save();

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => true]);;
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }

   /**
     * @param $id
     */
    public function cancelOrder(Request $request)
    {
        //$keys = ['orderRefundWalletComment', 'orderPartialRefundWalletComment'];
       // $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();
        $id=$request->id;

        $order = Order::where('id', $id)->first();

        

        if ($order && $user) {
            if ($order->orderstatus_id == '1') {
                //change order status to 6 (Canceled)
                $order->orderstatus_id = 6;
                $order->canceled_reason=$request->canceled_reason;
                $order->canceled_from=$request->canceled_from;
                $order->canceled_at=Carbon::now();
                $order->save();
                //refund money if paid online
                // if (!$order->payment_mode == 'COD') {
                //     //paid online or paid fully with wallet (Give full refund)
                //     $customer = User::where('id', $order->user_id)->first();
                //     if ($customer) {
                //         $customer->deposit($order->total * 100, ['description' => $translationData->orderRefundWalletComment . $order->unique_order_id]);
                //     }
                // }

                /* //if COD, then check if wallet is present
                if ($order->payment_mode == 'COD') {
                    if ($order->wallet_amount != null) {
                        //refund wallet amount
                        $customer->deposit($order->wallet_amount * 100, ['description' => $translationData->orderPartialRefundWalletComment . $order->unique_order_id]);
                    }
                } else {
                    //if online payment, refund the total to wallet
                    $customer->deposit(($order->total) * 100, ['description' => $translationData->orderRefundWalletComment . $order->unique_order_id]);
                } */

                /////COLOCAR AQUI PARA CANCELAR FATURA IUGU, SE FOI CANCELADO


                $order_items=Orderitem::where('order_id',$request->order_id)->get();
                $restaurant=Restaurant::where('id',$user->restaurant_id)->first();   
                
                ////////////ATUALIZANDO ESTOQUE //////////////////////////
                if($restaurant->manage_stock == 1){
                        foreach($order_items as $item){
                                $itemdb=Item::where('id',$item->item_id)->first();
                                $quantity_before=$itemdb->estoque;
                                $quantity_item_order=$item->quantity;
                                $quantity_item_now=$quantity_before + $quantity_item_order;
                                $itemdb->estoque=$quantity_item_now;
                                $itemdb->save();
                        }
                }
                ///////////////ATUALIZANDO ESTOQUE - FIM /////////////////


                     $user_id=$order->user_id;
                
                    //to user
                    $notify = new PushNotify();
                    $notify->sendPushNotification('6', $order->user_id, $order->unique_order_id);
                    $secretKey = 'key=' . config('settings.firebaseSecret');


                    $token = PushToken::where('user_id', $user_id)->first();
                    $msgTitle = 'Pedido Cancelado pelo Estabelecimento';//$runningOrderCanceledTitle;
                    $msgMessage = $order->canceled_reason;

                    $click_action = '';//config('settings.storeUrl') . '/my-orders/';
                    $user=User::where('id',$user_id)->first();

                    $data_order=[
                        'user_id'=>$user_id,
                        'token'=>$user->auth_token,
                        'unique_order_id'=>$order->unique_order_id,
                    ];
    
               /*  $order_data = Curl::to('https://app.comprabakana.com.br/public/api/order-details')
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data_order))
                ->post(); */

                $msg = array(
                    'title' => $msgTitle,
                    'message' => $msgMessage,
                    'badge' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                    'icon' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                    'orderstatus_id'=>$order->orderstatus_id,
                    //'data'=>$order_data,
                    'click_action' => $click_action,
                    'unique_order_id' => $order->unique_order_id,  
                );
                $fullData = array(
                    'to' => $token->token,
                    'data' => $msg,
                );
    
                $response = Curl::to('https://fcm.googleapis.com/fcm/send')
                    ->withHeader('Content-Type: application/json')
                    ->withHeader("Authorization: $secretKey")
                    ->withData(json_encode($fullData))
                    ->post();
                

                   /*  $content = array(
                        "en" => $msgTitle
                        );
                    
                    $fields = array(
                        'app_id' => "a9c606e1-42ca-4a8c-8b03-0b2c85721a38",
                        'include_player_ids' => array($token->onesignal_id),
                  
                        'data' => array("foo" => "bar"),
                        'contents' => $content
                    );
                    
                    //$fields = json_encode($fields);

                $response2 = Curl::to('https://onesignal.com/api/v1/notifications')
                    ->withHeader('Content-Type: application/json; charset=utf-8')
                    ->withHeader("Authorization: Basic NzA3N2RiZTgtOWQ2MC00M2YwLThiNWQtNGY1NTAxZTM3OTQ4")
                    ->withData(json_encode($fields))
                    ->post(); */

                if (\Illuminate\Support\Facades\Request::ajax()) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => true]);
                }
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return response()->json(['success' => false], 406);
            }
        }
    }


    
     /**
     * @param $id
     */
    public function markOrderReady(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '2') {
            $order->orderstatus_id = 7;
            $order->save();

            if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('7', $order->user_id, $order->unique_order_id);
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

         /**
     * @param $id
     */
    public function markOrderAsOnway(Request $request)
    {
        $id=$request->id;

        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '2') {
            $order->orderstatus_id = 4;
            $order->save();

            if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('4', $order->user_id, $order->unique_order_id);
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


            /**
     * @param $id
     */
    public function markOrderAsDelivered(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '4') {
            $order->orderstatus_id = 5;
            $order->delivered_at=Carbon::now();
            $order->save();

            if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('5', $order->user_id, $order->unique_order_id);
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


      /**
     * @param $id
     */
    public function markSelfPickupOrderAsCompleted(Request $request)
    {
        $id=$request->id;
        $user = auth()->user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '7') {
            $order->orderstatus_id = 5;
            $order->delivered_at=Carbon::now();
            $order->save();

        /*     //if selfpickup add amount to restaurant earnings if not COD then add order total
            if ($order->payment_mode == 'STRIPE' || $order->payment_mode == 'PAYPAL' || $order->payment_mode == 'PAYSTACK' || $order->payment_mode == 'RAZORPAY' || $order->payment_mode == 'PAYMONGO' || $order->payment_mode == 'MERCADOPAGO') {
                $restaurant_earning = RestaurantEarning::where('restaurant_id', $order->restaurant->id)
                    ->where('is_requested', 0)
                    ->first();
                if ($restaurant_earning) {
                    $restaurant_earning->amount += $order->total;
                    $restaurant_earning->save();
                } else {
                    $restaurant_earning = new RestaurantEarning();
                    $restaurant_earning->restaurant_id = $order->restaurant->id;
                    $restaurant_earning->amount = $order->total;
                    $restaurant_earning->save();
                }
            }
            //if COD, then take the $total minus $payable amount
            if ($order->payment_mode == 'COD') {
                $restaurant_earning = RestaurantEarning::where('restaurant_id', $order->restaurant->id)
                    ->where('is_requested', 0)
                    ->first();
                if ($restaurant_earning) {
                    $restaurant_earning->amount += $order->total;
                    $restaurant_earning->save();
                } else {
                    $restaurant_earning = new RestaurantEarning();
                    $restaurant_earning->restaurant_id = $order->restaurant->id;
                    $restaurant_earning->amount = $order->total;
                    $restaurant_earning->save();
                }
            } */

            if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('5', $order->user_id, $order->unique_order_id);
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    
};
