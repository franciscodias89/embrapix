<?php

namespace App\Http\Controllers;

use App\Addon;
use App\AcceptDelivery;
use App\Coupon;
use App\Helpers\TranslationHelper;
use App\Item;
use App\Iugu;
use App\IuguLr;
use App\IuguSubaccount;
use App\IuguSubaccountCustomer;
use App\Order;
use App\Orderissue;
use App\Orderitem;
use App\OrderItemAddon;
use App\Orderstatus;
use App\PushNotify;
use App\Rating;
use App\Restaurant;
use App\Sms;
use App\User;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Omnipay\Omnipay;
use OneSignal;
use Mail;

class OrderController extends Controller
{

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @param Request $request
     */
    public function placeOrder(Request $request, TranslationHelper $translationHelper)
    {
        $user = auth()->user();

        if ($user) {
            $keys = ['orderPaymentWalletComment', 'orderPartialPaymentWalletComment'];
            $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

            $newOrder = new Order();

            $checkingIfEmpty = Order::count();

            $lastOrder = Order::orderBy('id', 'desc')->first();

            if ($lastOrder) {
                $lastOrderId = $lastOrder->id;
                $newId = $lastOrderId + 1;
                $uniqueId = Hashids::encode($newId);
            } else {
                //first order
                $newId = 1;
            }

            $uniqueId = Hashids::encode($newId);
            $unique_order_id = 'OD' . '-' . date('m-d') . '-' . strtoupper(str_random(4)) . '-' . strtoupper($uniqueId);
            $newOrder->unique_order_id = $unique_order_id;

            $restaurant_id = $request['order'][0]['restaurant_id'];
            $restaurant = Restaurant::where('id', $restaurant_id)->first();

            $newOrder->user_id = $user->id;

            if ($request['pending_payment'] || $request['method'] == 'MERCADOPAGO' || $request['method'] == 'PAYTM') {
                $newOrder->orderstatus_id = '8';
            } elseif ($restaurant->auto_acceptable) {
                $newOrder->orderstatus_id = '2';
                $this->smsToDelivery($restaurant_id);
                if (config('settings.enablePushNotificationOrders') == 'true') {
                    //to user
                    $notify = new PushNotify();
                    $notify->sendPushNotification('2', $newOrder->user_id, $newOrder->unique_order_id);
                }
            } else {
                $newOrder->orderstatus_id = '1';
            }

            $newOrder->location = json_encode($request['location']);

           // $full_address = $request['user']['data']['default_address']['house'] . ', ' . $request['user']['data']['default_address']['address'];
            //$newOrder->address = $full_address;
            $newOrder->address = $request['location']['address'];
            //get restaurant charges
            $newOrder->restaurant_charge = $restaurant->restaurant_charges;

            $newOrder->transaction_id = $request->payment_token;
            
            $orderTotal = 0;
            foreach ($request['order'] as $oI) {
                $originalItem = Item::where('id', $oI['id'])->first();
                if(isset($oI['peso'])){
                    $orderTotal += ($originalItem->price * $oI['quantity']* $oI['peso']); //ADICIONADO MULTIPLICAÇÃO POR PESO
                }else{
                    $orderTotal += ($originalItem->price * $oI['quantity']); 
                }
               

                if (isset($oI['selectedaddons'])) {
                    foreach ($oI['selectedaddons'] as $selectedaddon) {
                        $addon = Addon::where('id', $selectedaddon['addon_id'])->first();
                        if ($addon) {
                            $orderTotal += $addon->price * $oI['quantity'];
                        }
                    }
                }
            }
            $newOrder->sub_total = $orderTotal;

            if ($request->coupon) {
                $coupon = Coupon::where('code', strtoupper($request['coupon']['code']))->first();
                if ($coupon) {
                    $newOrder->coupon_name = $request['coupon']['code'];
                    if ($coupon->discount_type == 'PERCENTAGE') {
                        $percentage_discount = (($coupon->discount / 100) * $orderTotal);
                        if ($coupon->max_discount) {
                            if ($percentage_discount >= $coupon->max_discount) {
                                $percentage_discount = $coupon->max_discount;
                            }
                        }
                        $newOrder->coupon_amount = $percentage_discount;
                        $orderTotal = $orderTotal - $percentage_discount;
                    }
                    if ($coupon->discount_type == 'AMOUNT') {
                        $newOrder->coupon_amount = $coupon->discount;
                        $orderTotal = $orderTotal - $coupon->discount;
                    }
                    $coupon->count = $coupon->count + 1;
                    $coupon->save();
                }
            }
            $subtotal=$orderTotal;

            if ($request->delivery_type == 1) {
                if ($restaurant->delivery_charge_type == 'DYNAMIC') {
                    //get distance between user and restaurant,
                   // if (config('settings.enGDMA') == 'true') {
                        $distance = $request->dis;
                    //} else {
                        //$distance = $this->getDistance($request['location']['latitude'], $request['location']['longitude'], $restaurant->latitude, $restaurant->longitude);
                   // }

                    if ($distance > $restaurant->base_delivery_distance) {
                        $extraDistance = $distance - ($restaurant->base_delivery_distance);
                        $extraCharge = ($extraDistance / ($restaurant->extra_delivery_distance)) * ($restaurant->extra_delivery_charge);
                        $dynamicDeliveryCharge = ($restaurant->base_delivery_charge) + $extraCharge;

                       // if (config('settings.enDelChrRnd') == 'true') {
                        //    $dynamicDeliveryCharge = ceil($dynamicDeliveryCharge);
                       // }
                       

                        $newOrder->delivery_charge = $dynamicDeliveryCharge;
                        $orderTotal = round($orderTotal + $dynamicDeliveryCharge, 2);
                    } else {
                        $newOrder->delivery_charge = $restaurant->base_delivery_charge;
                        $orderTotal = $orderTotal + $restaurant->base_delivery_charge;
                    }
                    //dd($orderTotal);

                } else {
                    $newOrder->delivery_charge = $restaurant->delivery_charges;
                    $orderTotal = $orderTotal + $restaurant->delivery_charges;
                }

            } else {
                $newOrder->delivery_charge = 0;
            }

            $orderTotal = $orderTotal + $restaurant->restaurant_charges;

            if (config('settings.taxApplicable') == 'true') {
                $newOrder->tax = config('settings.taxPercentage');

                $taxAmount = (float) (((float) config('settings.taxPercentage') / 100) * $orderTotal);
            } else {
                $taxAmount = 0;
            }

            $newOrder->tax_amount = $taxAmount;

            $orderTotal = $orderTotal + $taxAmount;

            if (isset($request['tipAmount']) && !empty($request['tipAmount'])) {
                $orderTotal = $orderTotal + $request['tipAmount'];
            }

            //this is the final order total

            if ($request['method'] == 'COD') {
                if ($request->partial_wallet == true) {
                    //deduct all user amount and add
                    $newOrder->payable = $orderTotal - $user->balanceFloat;
                }
                if ($request->partial_wallet == false) {
                    $newOrder->payable = $orderTotal;
                }
            }

            $newOrder->total = $orderTotal;

            //ALTERADO INICIO
            $newOrder->cashback_amount = $subtotal*($restaurant->cashback_percent)/100;
//ALTERADO FIM




            $newOrder->order_comment = $request['order_comment'];

            $newOrder->payment_mode = $request['payment_mode'];
            $newOrder->payment_type = $request['payment_type'];

            $newOrder->restaurant_id = $request['order'][0]['restaurant_id'];

            $newOrder->tip_amount = $request['tipAmount'];

            if ($request->delivery_type == 1) {
                //delivery
                $newOrder->delivery_type = 1;
            } else {
                //selfpickup
                $newOrder->delivery_type = 2;
            }

            $user->delivery_pin = strtoupper(str_random(5));
            $user->save();
            //process paypal payment
            if ($request['method'] == 'CREDITCARD') {
                $dados=array();
                $dados=[
                    'amount'=>$orderTotal,
                    'restaurant_id'=>$restaurant_id,
                    'user_id'=>$user->id,
                    'cpf'=>$request->cpf,
                    'user'=>$user,
                 

                ];

                if(isset($request['iugu_token'])){
                    $dados['token']=$request['iugu_token'];
                }
                if(isset($request['customer_payment_method_id'])){
                    $dados['customer_payment_method_id']=$request['customer_payment_method_id'];
                }
                $pay=$this->IuguMakePaymentCreditCard($dados);
                $res=$pay;

                if(isset($res->success)){
                    if(($pay->success)==false){
                        $lr=$pay->LR;
                        $LRmessages=IuguLr::where('codigo',$lr)->first();
                        $message=[
                            'title'=> $LRmessages->titulo,
                            'description'=> $LRmessages->descricao
                        ];

                        $resp1=[
                            'success'=>false,
                            'data'=>$pay,
                            'message'=>$message
                        ];
                        return response()->json($resp1);
                    }else{

                        $newOrder->transaction_id=$pay->invoice_id;
                        $newOrder->iugu_status=1;
                    //SUCESSO PAGAMENTO CARTAO CREDITO
                        //successfuly received payment
                        $newOrder->save();
                        if ($request->partial_wallet == true) {

                            $userWalletBalance = $user->balanceFloat;
                            $newOrder->wallet_amount = $userWalletBalance;
                            $newOrder->save();
                            //deduct all user amount and add
                            $user->withdraw($userWalletBalance * 100, ['description' => $translationData->orderPartialPaymentWalletComment . $newOrder->unique_order_id]);
                        }
                        foreach ($request['order'] as $orderItem) {
                            $item = new Orderitem();
                            $item->order_id = $newOrder->id;
                            $item->item_id = $orderItem['id'];
                            $item->name = $orderItem['name'];
                            $item->quantity = $orderItem['quantity'];
                            $item->unidade = $orderItem['unidade'];

                            $itemdb=Item::where('id',$orderItem['id'])->first();
                            $item->image=$itemdb->image;
                            $item->ean= $itemdb->ean;
                            $item->codint=$itemdb->codint;

                            
                            if(isset($orderItem['peso'])){
                                $item->peso = $orderItem['peso'];
                            }
                            
                            $item->price = $orderItem['price'];
                            $item->save();
                            if (isset($orderItem['selectedaddons'])) {
                                foreach ($orderItem['selectedaddons'] as $selectedaddon) {
                                    $addon = new OrderItemAddon();
                                    $addon->orderitem_id = $item->id;
                                    $addon->addon_category_name = $selectedaddon['addon_category_name'];
                                    $addon->addon_name = $selectedaddon['addon_name'];
                                    $addon->addon_price = $selectedaddon['price'];
                                    $addon->save();
                                }
                            }
                        }
                        //ALTERADO - INICIO           
                        $previsao_entrega=null;
                        $message =null;
                        if($newOrder->orderstatus_id == 1){
                            $message =[
                                'title'=>'Pedido Realizado',
                                'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                            ];
                        }
                        if($newOrder->orderstatus_id == 2){
                            $message =[
                                'title'=>'Preparando seu Pedido',
                                'description' => 'Seu pedido está sendo preparado'
                            ];
                        }
                        if($newOrder->orderstatus_id == 3){
                            $message =[
                                'title'=>'Pedido Realizado',
                                'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                            ];
                        }
                        if($newOrder->orderstatus_id == 4){
                            $message =[
                                'title'=>'Pedido saiu para Entrega',
                                'description' => 'Em breve você receberá o seu pedido!'
                            ];
                        }
                        if($newOrder->orderstatus_id == 5){
                            $message =[
                                'title'=>'Pedido Entregue',
                                'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                            ];
                        }
                        if($newOrder->orderstatus_id == 6){
                            $message =[
                                'title'=>'Pedido Cancelado',
                                'description' => 'Que Pena! Seu pedido foi Cancelado!'
                            ];
                        }
                        if($newOrder->orderstatus_id == 7){
                            $message =[
                                'title'=>'Pronto para Retirada',
                                'description' => 'Oba! Você já pode retirar o seu pedido!'
                            ];
                        }
                        if($newOrder->orderstatus_id == 8){
                            $message =[
                                'title'=>'Pedido Realizado com Sucesso',
                                'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                            ];
                        }

                        //$items = Orderitem::where('order_id', $newOrder->id)->get();
                        if ($user->default_address_id !== 0) {
                            $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                        } else {
                            $default_address = null;
                        }
                        $running_order = \App\Order::where('id', $newOrder->id)
                        ->with('orderitems', 'orderitems.order_item_addons', 'restaurant')
                        ->first();

                        $delivery_details = null;

                        $rating = Rating::where('order_id', $running_order->id)->get();
                        if ($rating->isEmpty()) {
                            $running_order['rating']=null;
                        } else {
                            $running_order['rating']=$rating;
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
                        //ALTERADO - FIM
                        // Send SMS to restaurant owner only if not configured for auto acceptance, and order staus ID is 1 and sms notify is On by Admin
                        if (!$restaurant->auto_acceptable && $newOrder->orderstatus_id == '1' && config('settings.smsRestaurantNotify') == 'true') {

                            $restaurant_id = $request['order'][0]['restaurant_id'];
                            $this->smsToRestaurant($restaurant_id, $orderTotal);
                        }
                        // END SMS

                        if ($restaurant->auto_acceptable && config('settings.enablePushNotification') && config('settings.enablePushNotificationOrders') == 'true') {

                            //get all pivot users of restaurant (delivery guy/ res owners)
                            $pivotUsers = $restaurant->users()
                                ->wherePivot('restaurant_id', $restaurant->id)
                                ->get();
                            //filter only res owner and send notification.
                            foreach ($pivotUsers as $pU) {
                                if ($pU->hasRole('Delivery Guy')) {
                                    //send Notification to Res Owner
                                    $notify = new PushNotify();
                                    $notify->sendPushNotification('TO_DELIVERY', $pU->id, $newOrder->unique_order_id);
                                }
                            }

                        }

                        /* OneSignal Push Notification to Store Owner */
                       // if ($newOrder->orderstatus_id == '1' && config('settings.oneSignalAppId') != null && config('settings.oneSignalRestApiKey') != null) {
                       //     $this->sendPushNotificationStoreOwner($restaurant_id);
                       // }
                        /* END OneSignal Push Notification to Store Owner */

                        return response()->json($response);


                    //SUCESSOPAGAMENTO CARTAO DE CREDITO - FIM
                    }
                }


       
            }
            //if new payment gateway is added, write elseif here
            else {
                $newOrder->save();
                if ($request['method'] == 'COD') {
                    if ($request->partial_wallet == true) {
                        $userWalletBalance = $user->balanceFloat;
                        $newOrder->wallet_amount = $userWalletBalance;
                        $newOrder->save();
                        //deduct all user amount and add
                        $user->withdraw($userWalletBalance * 100, ['description' => $translationData->orderPartialPaymentWalletComment . $newOrder->unique_order_id]);
                    }
                }

                //if method is WALLET, then deduct amount with appropriate description
                if ($request['method'] == 'WALLET') {
                    $userWalletBalance = $user->balanceFloat;
                    $newOrder->wallet_amount = $orderTotal;
                    $newOrder->save();
                    $user->withdraw($orderTotal * 100, ['description' => $translationData->orderPaymentWalletComment . $newOrder->unique_order_id]);
                }

                foreach ($request['order'] as $orderItem) {
                    $item = new Orderitem();
                    $item->order_id = $newOrder->id;
                    $item->item_id = $orderItem['id'];
                    $item->name = $orderItem['name'];
                    $item->quantity = $orderItem['quantity'];
                    $item->unidade = $orderItem['unidade'];

                    $itemdb=Item::where('id',$orderItem['id'])->first();
                            $item->image=$itemdb->image;
                            $item->ean= $itemdb->ean;
                            $item->codint=$itemdb->codint;

                    if(isset($orderItem['peso'])){
                        $item->peso = $orderItem['peso'];
                    }
                    
                    $item->price = $orderItem['price'];
                    $item->save();
                    if (isset($orderItem['selectedaddons'])) {
                        foreach ($orderItem['selectedaddons'] as $selectedaddon) {
                            $addon = new OrderItemAddon();
                            $addon->orderitem_id = $item->id;
                            $addon->addon_category_name = $selectedaddon['addon_category_name'];
                            $addon->addon_name = $selectedaddon['addon_name'];
                            $addon->addon_price = $selectedaddon['price'];
                            $addon->save();
                        }
                    }
                }

//ALTERADO -INICIO
                $previsao_entrega=null;
                $message =null;
                if($newOrder->orderstatus_id == 1){
                    $message =[
                        'title'=>'Pedido Realizado',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }
                if($newOrder->orderstatus_id == 2){
                    $message =[
                        'title'=>'Preparando seu Pedido',
                        'description' => 'Seu pedido está sendo preparado'
                    ];
                }
                if($newOrder->orderstatus_id == 3){
                    $message =[
                        'title'=>'Pedido Realizado',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }
                if($newOrder->orderstatus_id == 4){
                    $message =[
                        'title'=>'Pedido saiu para Entrega',
                        'description' => 'Em breve você receberá o seu pedido!'
                    ];
                }
                if($newOrder->orderstatus_id == 5){
                    $message =[
                        'title'=>'Pedido Entregue',
                        'description' => 'Oba! Seu Pedido já foi entregue com Sucesso!'
                    ];
                }
                if($newOrder->orderstatus_id == 6){
                    $message =[
                        'title'=>'Pedido Cancelado',
                        'description' => 'Que Pena! Seu pedido foi Cancelado!'
                    ];
                }
                if($newOrder->orderstatus_id == 7){
                    $message =[
                        'title'=>'Pronto para Retirada',
                        'description' => 'Oba! Você já pode retirar o seu pedido!'
                    ];
                }
                if($newOrder->orderstatus_id == 8){
                    $message =[
                        'title'=>'Pedido Realizado com Sucesso',
                        'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                    ];
                }

                //$items = Orderitem::where('order_id', $newOrder->id)->get();
                if ($user->default_address_id !== 0) {
                    $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                } else {
                    $default_address = null;
                }
                $running_order = \App\Order::where('id', $newOrder->id)
                ->with('orderitems', 'orderitems.order_item_addons', 'restaurant')
                ->first();

                $location=json_decode($running_order->location);
                $running_order['location']=$location;
                $delivery_details = null;
                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $user->auth_token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
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
//ALTERADO - FIM

                // Send SMS
                if (!$restaurant->auto_acceptable && $newOrder->orderstatus_id == '1' && config('settings.smsRestaurantNotify') == 'true') {

                    $restaurant_id = $request['order'][0]['restaurant_id'];
                    $this->smsToRestaurant($restaurant_id, $orderTotal);

                }
                // END SMS

                if ($restaurant->auto_acceptable && config('settings.enablePushNotification') && config('settings.enablePushNotificationOrders') == 'true') {
                    //get all pivot users of restaurant (delivery guy/ res owners)
                    $pivotUsers = $restaurant->users()
                        ->wherePivot('restaurant_id', $restaurant->id)
                        ->get();
                    //filter only res owner and send notification.
                    foreach ($pivotUsers as $pU) {
                        if ($pU->hasRole('Delivery Guy')) {
                            //send Notification to Res Owner
                            $notify = new PushNotify();
                            $notify->sendPushNotification('TO_DELIVERY', $pU->id, $newOrder->unique_order_id);
                        }
                    }

                }

                /* OneSignal Push Notification to Store Owner */
                /* if ($newOrder->orderstatus_id == '1' && config('settings.oneSignalAppId') != null && config('settings.oneSignalRestApiKey') != null) {
                    $this->sendPushNotificationStoreOwner($restaurant_id);
                } */
                /* END OneSignal Push Notification to Store Owner */
                $order_code=$newOrder->unique_order_id;
                $order_link='https://app.comprabakana.com.br/public/store-owner/order/'.$order_code;
                $userx=User::where('restaurant_id',$restaurant->id)->first();
                $data = [
                    'name' => $restaurant->name,
                    'email' => $userx->email,
                    'order_link' => $order_link,
                    'order_code'=>$order_code,
                ];
                try {

                    //send the mail to the requested user's email
                    Mail::send('emails.NewOrder', ['mailData' => $data], function ($message) use ($data) {
                        $message->subject('Novo Pedido - '.$data['order_code'].'');
                        $message->from(config('settings.sendEmailFromEmailAddress'), config('settings.sendEmailFromEmailName'));
                        $message->to($data['email']);
                    });
    
                    
    
                    $response = [
                        'success' => true,
                        'message' => 'Password reset mail sent',
                    ];
                    return response()->json($response);
                } catch (Exception $e) {
                    $response = [
                        'success' => false,
                        'message' => $e->getMessage(),
                        'error_code' => 'SWR', //Something Went Wrong
                    ];
                    return response()->json($response);
                }

                $login = 'franciscorcc';
$token = '5f6d546c6d3e5d68228bdc32a9938206';
$numero =  str_replace(['(',' ','-',')'],'',$userx->phone);
$msg = urlencode("Chegou NOVO PEDIDO no App COMPRA BAKANA. Acesse o painel e confira os detalhes do pedido");
$send = file_get_contents("http://painel.kingsms.com.br/kingsms/api.php?acao=sendsms&login=$login&token=$token&numero=$numero&msg=$msg");






                return response()->json($response);
            }

        }
    }

    public function Orders(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            //$orders_finished = Order::where('user_id', $user->id)->whereIn('orderstatus_id', ['5','6','10'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            $orders_running = Order::where('user_id', $user->id)->whereIn('orderstatus_id', ['1','2','3','4','7','8','9'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
          $orders_running=$orders_running::paginate(4);
        }
        return response()->json($orders_running);
    }
    /**
     * @param Request $request
     */
    public function getOrders(Request $request)

    {
        $type = $request->type;
        $user = auth()->user();
        if ($user) {
                        
            if($type=='running'){
                $orders_running = Order::where('user_id', $user->id)->whereIn('orderstatus_id', ['1','2','3','4','7','8','9'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                $running=array();
              
                foreach ($orders_running as $order){
    
                            
                    $running_order = $order;
        
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
            $orders_finished = Order::where('user_id', $user->id)->whereIn('orderstatus_id', ['5','6','10'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            $finished=array();
            foreach ($orders_finished as $order){

                 
                $running_order = $order;
    
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
     * @param Request $request
     */
    public function sendOrderIssue(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $orderissue = new Orderissue();
            $orderissue->order_id = $request->order_id;
            $orderissue->restaurant_id = $request->restaurant_id;
            $orderissue->user_id = $user->id;
            $orderissue->comment = $request->comment;
            $orderissue->save();
            $response=[
                'sucess'=> true,
                'orderissue'=> $orderissue,
            ];
            return response()->json($response);
        }
        return response()->json(['success' => false], 401);

    }

    

    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     * @return mixed
     */
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
     * @param $restaurant_id
     * @param $orderTotal
     */
    private function smsToRestaurant($restaurant_id, $orderTotal)
    {
        //get restaurant
        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        if ($restaurant) {
            if ($restaurant->is_notifiable) {
                //get all pivot users of restaurant (Store Ownerowners)
                $pivotUsers = $restaurant->users()
                    ->wherePivot('restaurant_id', $restaurant_id)
                    ->get();
                //filter only res owner and send notification.
                foreach ($pivotUsers as $pU) {
                    if ($pU->hasRole('Store Owner')) {
                        // Include Order orderTotal or not ?
                        switch (config('settings.smsRestOrderValue')) {
                            case 'true':
                                $message = config('settings.defaultSmsRestaurantMsg') . round($orderTotal);
                                break;
                            case 'false':
                                $message = config('settings.defaultSmsRestaurantMsg');
                                break;
                        }
                        // As its not an OTP based message Nulling OTP
                        $otp = null;
                        $smsnotify = new Sms();
                        $smsnotify->processSmsAction('OD_NOTIFY', $pU->phone, $otp, $message);
                    }
                }
            }
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



    public function IuguCriarClienteSubconta($user,$restaurant_id)
    {

        $id_contamaster= '9393337C51E1255200137219AFFD83E7';
        $live_token_master ='6c91313e841d21b253cadffde8585bce';
        $test_token_master ='9da2d495e5957b8feb914eb36010c3a6';
        
        $id_subconta=   '71266658C07C4AA5963D3565D21785E4';
        $live_token_subconta ='9b654e4f417ae5ce63924facbc59e01b';
        $test_token_subconta ='5d5dd8312c6e06f19c901fe046588f0b';

       // $user = auth()->user();
        $subaccount=IuguSubaccount::where('restaurant_id',$restaurant_id)->first();
        //$subaccountCustomer=IuguSubaccountCustomer::where('restaurant_id',$restaurant_id)->where('user_id',$user->id)->first();
        
        $api_token=$subaccount->live_api_token;

        //Criar Cliente na Subconta
        $data=[
            'name'=>$user->name,
            'email'=>$user->email,
            'api_token'=>$api_token
        ];
        $test = new Iugu;
        $response=$test->criarCliente($data); 
        $res=json_decode($response);
        if(isset($res->id)){
            if ($user) {
            $iugu = new IuguSubaccountCustomer();
            $iugu->customer_id=$res->id;
            $iugu->name=$user->name;
            $iugu->email=$user->email;
            $iugu->user_id=$user->id;
            $iugu->restaurant_id=$restaurant_id;
            $iugu->is_active=1;
            $iugu->save();


            //Vinculando Cliente da Subconta à Conta Master
            $data1=[
                'customer_id_contamaster'=>$user->customer_id,
                'customer_id_subconta'=>$iugu->customer_id,
                'api_token'=>$api_token  // CONFERIR SE É ISSO MESMO ou SE USA A KEY DA CONTA MASTER
            ];
            $test = new Iugu;
            $response1=$test->vincularClienteContaMaster($data1); 
            $res1=json_decode($response1);
            if(isset($res1->errors)){
                $resp1=[
                    'sucess'=>false,
                    'data'=>$res1
                ];
                return $resp1;
            }else{
                $resp1=[
                    'sucess'=>true,
                    'data'=>'',
                   ];
                   
                   $iugu_vinculate = IuguSubaccountCustomer::where('id', $iugu->id)->firstOrFail();
                   $iugu_vinculate->vinculated=1;
                   $iugu_vinculate->save();
                
            }



            }
        }
        if(isset($res->errors)){
            $resp=[
                'sucess'=>false,
                'data'=>$res
            ];
            return $resp;
        }else{
            $resp=[
                'sucess'=>true,
                'data'=>'',
               ];
            return $resp;
        }

   



    }



    public function IuguMakePaymentCreditCard($request)
    {
        $user = $request['user'];
        $subaccount=IuguSubaccount::where('restaurant_id',$request['restaurant_id'])->first();
        $subaccountCustomer=IuguSubaccountCustomer::where('restaurant_id',$request['restaurant_id'])->where('user_id',$user->id)->first();
        
        if(empty($subaccountCustomer)){
            $create=$this->IuguCriarClienteSubconta($user,$request['restaurant_id']);
            if(isset($create['success'])){
                if(($create['success'])==false){
                    $resp1=[
                        'sucess'=>false,
                        'data'=>$create['data']
                    ];
                    return response()->json($resp1);
                }
            }
        }

        $api_token=$subaccount->live_api_token;
        $method=null; // não precisa se tiver o token
        
        $subaccountCustomerID=IuguSubaccountCustomer::where('restaurant_id',$request['restaurant_id'])->where('user_id',$user->id)->first();
       
        $restrict_payment_method=false; //Se true, restringe o método de pagamento da cobrança para o definido em method, que no caso será apenas bank_slip.
        $customer_id=$subaccountCustomerID->customer_id; //ID do Cliente. Utilizado para vincular a Fatura a um Cliente
        $invoice_id=null; //ID da Fatura a ser utilizada para pagamento
        $email=$user->email;//E-mail do Cliente (não é preenchido caso seja enviado um "invoice_id")
        $months=null; //Número de Parcelas (2 até 12), não é necessário passar 1. Não é preenchido caso o método de pagamento seja "bank_slip". O valor mínino de cada parcela é de R$5,00.
        $keep_dunning=false;//Por padrão, a fatura é cancelada caso haja falha na cobrança, a não ser que este parâmetro seja enviado como "true". Obs: Funcionalidade disponível apenas para faturas criadas no momento da cobrança.
        $order_id=null;//Por padrão, a fatura é cancelada caso haja falha na cobrança, a não ser que este parâmetro seja enviado como "true". Obs: Funcionalidade disponível apenas para faturas criadas no momento da cobrança.


        $address=[
            'street'=>'',
            'number'=>'',
            'district'=>'',
            'city'=>'',
            'state'=>'',
            'zip_code'=>'',
            'complement'=>'',

        ];
        $payer=[
            'cpf_cnpj'=>$request['cpf'],
            'name'=>$user->Name,
            'phone_prefix'=>substr($user->phone,1,-12),
            'phone'=>substr($user->phone, -10),
            'email'=>$user->email,
            'address'=>$address,

         ];

         $items=[
            'description'=>$user->id,
            'quantity'=>1,
            'price_cents'=>$request['amount']*100,
         ];


         $data=[
            'api_token'=>$api_token,
            'method'=>$method,
            'restrict_payment_method'=>$restrict_payment_method,
            'customer_id'=>$customer_id,
            'invoice_id'=>$invoice_id,
            'email'=>$email,
            'months'=>$months,
            'keep_dunning'=>$keep_dunning,
            'order_id'=>$order_id,
            'items'=>$items,
            'payer'=>$payer,
            'address'=>$address,
 
        ];

        if(isset($request['token'])){
            if($request['token']!=null){
                $data['token']=$request['token'];
            }
        }
        if(isset($request['customer_payment_method_id'])){
            if($request['customer_payment_method_id']!=null){
                $data['customer_payment_method_id']=$request['customer_payment_method_id'];
            }
           
        }


        $test = new Iugu;
            $response1=$test->criarCobranca($data); 
            $res1=json_decode($response1);
           /*  if(($res1['status'])=='captured'){
                $resp1=[
                    'sucess'=>true,
                    'data'=>$res1
                ];
                return $resp1;
            } else{
                $resp1=[
                    'sucess'=>false,
                    'data'=>$res1,
                   ];
                return $resp1;  
                   
            } */
            return $res1;


    }









}
