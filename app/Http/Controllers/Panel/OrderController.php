<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Addon;
use App\AddonCategory;
use App\Helpers\TranslationHelper;
use App\Item;
use App\IuguSubaccount;
use App\ItemCategory;
use App\Flyer;
use App\FlyerRestaurant;
use App\Order;
use App\Orderitem;
use App\PaymentGateway;
use App\PushNotify;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantEarning;
use App\RestaurantPayout;
use App\Sms;
use App\StorePayoutDetail;
use App\User;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Image;
use Modules\ThermalPrinter\Entities\PrinterSetting;
use Modules\ThermalPrinter\Entities\ThermalPrinter;
use Nwidart\Modules\Facades\Module;
use OneSignal;
use FileUploader;
use App\PushToken;

use App\Translation;
use Session;

//require_once(base_path('vendor\WebClientPrint\WebClientPrint.php'));
include_once(app_path() . '/WebClientPrint/WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;

use Ixudra\Curl\Facades\Curl;

class OrderController extends Controller
{
   

    /**
     * @param $order_id
     */
    public function viewOrder($order_id)
    {
        $user = Auth::user();
        $restaurantId = $user->restaurant_id;
        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();

        $order = Order::where('restaurant_id', $restaurantId)
            ->where('unique_order_id', $order_id)
            ->with('orderitems.order_item_addons')
            ->first();
        $agora = Carbon::now();


        $restaurant_id = $restaurantId;
       
        $separators = User::where('restaurant_id', $restaurant_id)->where('user_type','Separator')->orderBy('id', 'DESC')->where('is_deleted',0)->get();
        $separators_array=array();
        foreach($separators as $separator){
            $orders_running= Order::where('restaurant_id', $restaurant_id)->where('separation_status',12)->where('separator_id',$separator->id)->get();
            $orders_finished= Order::where('restaurant_id', $restaurant_id)->where('separation_status',13)->where('separator_id',$separator->id)->get();
           if(isset($orders_running)){
            $running=count($orders_running);
           }else{
            $running=0; 
           }
           if(isset($orders_finished)){
            $finished=count($orders_finished);
           }else{
            $finished=0;  
           }

            $separator['running']=$running;
            $separator['finished']=$finished;
            
                $separators_array[]=$separator;
           
           

        }

        $printerData=Restaurant::where('id',$restaurantId)->first()->printer_data;
        $wcppScript = WebClientPrint::createWcppDetectionScript(action('Panel\WebClientPrintController@processRequest'), Session::getId()); 
        $wcpScript = WebClientPrint::createScript(action('Panel\WebClientPrintController@processRequest'), action('Panel\PrintESCPOSController@printCommands'), Session::getId());  

        if ($order) {
            return view('panel.viewOrder', array(
                'order' => $order,
                'separators'=> $separators_array,
                'agora'=>$agora,
                'wcpScript' => $wcpScript,
                'wcppScript' => $wcppScript,  
                'printerData'=>$printerData,
                'restaurant'=>$restaurant,
            ));
        } else {
            return redirect()->route('restaurantowner.orders');
        }
    }

       /**
     * @param $id
     */
    public function selectSeparator(Request $request)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();
        $id=$request->order_id;
        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order) {
            $order->separator_id = $request->separator_id;
            $order->separation_status=11;
            $order->save();

           /*  if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('7', $order->user_id, $order->unique_order_id);
            } */

            return redirect()->back()->with(array('success' => 'Separador Atribuido'));
        } else {
            return redirect()->back()->with(array('message' => 'Something went wrong.'));
        }
    }


        /**
     * @param $id
     */
    public function acceptOrder($id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '1') {
            $order->orderstatus_id = 2;
            $order->save();

            if (config('settings.enablePushNotificationOrders') == 'true') {
                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('2', $order->user_id, $order->unique_order_id);
            }

            // Send Push Notification to Delivery Guy
            if (config('settings.enablePushNotificationOrders') == 'true') {
                //get restaurant
                $restaurant = Restaurant::where('id', $order->restaurant_id)->first();
                if ($restaurant) {
                    //get all pivot users of restaurant (delivery guy/ res owners)
                    $pivotUsers = $restaurant->users()
                        ->wherePivot('restaurant_id', $order->restaurant_id)
                        ->get();
                    //filter only res owner and send notification.
                    foreach ($pivotUsers as $pU) {
                        if ($pU->hasRole('Delivery Guy')) {
                            //send Notification to Res Owner
                            $notify = new PushNotify();
                            $notify->sendPushNotification('TO_DELIVERY', $pU->id, $order->unique_order_id);
                        }
                    }
                }
            }
            // END Send Push Notification to Delivery Guy

            // Send SMS Notification to Delivery Guy
            if (config('settings.smsDeliveryNotify') == 'true') {
                //get restaurant
                $restaurant = Restaurant::where('id', $order->restaurant_id)->first();
                if ($restaurant) {
                    //get all pivot users of restaurant (delivery guy/ res owners)
                    $pivotUsers = $restaurant->users()
                        ->wherePivot('restaurant_id', $order->restaurant_id)
                        ->get();
                    //filter only res owner and send notification.
                    foreach ($pivotUsers as $pU) {
                        if ($pU->hasRole('Delivery Guy')) {
                            //send sms to Delivery Guy
                            if ($pU->delivery_guy_detail->is_notifiable) {
                                $message = config('settings.defaultSmsDeliveryMsg');
                                $otp = null;
                                $smsnotify = new Sms();
                                $smsnotify->processSmsAction('OD_NOTIFY', $pU->phone, $otp, $message);
                            }
                        }
                    }
                }
            }
            // END Send SMS Notification to Delivery Guy

            /* if (Module::find('ThermalPrinter') && Module::find('ThermalPrinter')->isEnabled()) {

                $printerSetting = PrinterSetting::where('user_id', Auth::user()->id)->first();
                $data = json_decode($printerSetting->data);

                if ($data->automatic_printing == 'FULLINVOICE') {
                    $this->printInvoice($order->unique_order_id);
                }
            } */

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return redirect()->back()->with(array('success' => 'Pedido Aceito com Sucesso!'));
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return redirect()->back()->with(array('message' => 'Something went wrong.'));
            }
        }
    }

     /**
     * @param $id
     */
    public function markOrderReady($id)
    {
        $user = Auth::user();
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

            return redirect()->back()->with(array('success' => 'Marcado como: Pronto para Retirada'));
        } else {
            return redirect()->back()->with(array('message' => 'Something went wrong.'));
        }
    }

         /**
     * @param $id
     */
    public function markOrderAsOnway($id)
    {
        $user = Auth::user();
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

            return redirect()->back()->with(array('success' => 'Marcado como: Saiu para Entrega'));
        } else {
            return redirect()->back()->with(array('message' => 'Algo deu errado!'));
        }
    }


            /**
     * @param $id
     */
    public function markOrderAsDelivered($id)
    {
        $user = Auth::user();
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

            return redirect()->back()->with(array('success' => 'Marcado como: Saiu para Entrega'));
        } else {
            return redirect()->back()->with(array('message' => 'Algo deu errado!'));
        }
    }


      /**
     * @param $id
     */
    public function markSelfPickupOrderAsCompleted($id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        if ($order->orderstatus_id == '7') {
            $order->orderstatus_id = 5;
            $order->delivered_at=Carbon::now();
            $order->save();

            //if selfpickup add amount to restaurant earnings if not COD then add order total
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
            }

            if (config('settings.enablePushNotificationOrders') == 'true') {

                //to user
                $notify = new PushNotify();
                $notify->sendPushNotification('5', $order->user_id, $order->unique_order_id);
            }

            return redirect()->back()->with(array('success' => 'Pedido Finalizado com Sucesso!'));
        } else {
            return redirect()->back()->with(array('message' => 'Alguma coisa está errada! Entre em contato com nosso suporte!.'));
        }
    }

       /**
     * @param $id
     */
    public function cancelOrder(Request $request)
    {
        //$keys = ['orderRefundWalletComment', 'orderPartialRefundWalletComment'];
       // $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

        $user = Auth::user();
        
        $id=$request->id;
        $restaurant_id=$user->restaurant_id;

        $order = Order::where('id', $id)->where('restaurant_id', $restaurant_id)->first();

        

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


                $order_items=Orderitem::where('order_id',$id)->get();
                $restaurant=Restaurant::where('id',$restaurant_id)->first();   
                
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
                    return redirect()->back()->with(array('success' => 'Pedido Cancelado com Sucesso!'));
                }
            }
        } else {
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => false], 406);
            } else {
                return redirect()->back()->with(array('message' => 'Alguma coisa deu errado!.'));
            }
        }
    }


};
