<?php

namespace App;

use App\Alert;
use App\Orderstatus;
use App\PushToken;
use App\Restaurant;
use App\Translation;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;

class PushNotify
{
    /**
     * @param $orderstatus_id
     * @param $user_id
     */
    public function sendPushNotification($orderstatus_id, $user_id, $unique_order_id)
    {

        //check if admin has set a default translation?

        //ALTERADO - desabilitei as traduções e coloquei o texto diretamente logo abaixo
        
         $translation = Translation::where('is_default', 1)->first();
        if ($translation) {
            //if yes, then take the default translation and use instread of translations from config
            $translation = json_decode($translation->data);

            $runningOrderPreparingTitle = $translation->runningOrderPreparingTitle;
            $runningOrderPreparingSub = $translation->runningOrderPreparingSub;
            $runningOrderDeliveryAssignedTitle = $translation->runningOrderDeliveryAssignedTitle;
            $runningOrderDeliveryAssignedSub = $translation->runningOrderDeliveryAssignedSub;
            $runningOrderOnwayTitle = $translation->runningOrderOnwayTitle;
            $runningOrderOnwaySub = $translation->runningOrderOnwaySub;
            $runningOrderDelivered = !empty($translation->runningOrderDelivered) ? $translation->runningOrderDelivered : config('settings.runningOrderDelivered');
            $runningOrderDeliveredSub = !empty($translation->runningOrderDeliveredSub) ? $translation->runningOrderDelivered : config('settings.runningOrderDeliveredSub');
            $runningOrderCanceledTitle = $translation->runningOrderCanceledTitle;
            $runningOrderCanceledSub = $translation->runningOrderCanceledSub;
            $runningOrderReadyForPickup = $translation->runningOrderReadyForPickup;
            $runningOrderReadyForPickupSub = $translation->runningOrderReadyForPickupSub;
            $deliveryGuyNewOrderNotificationMsg = $translation->deliveryGuyNewOrderNotificationMsg;
            $deliveryGuyNewOrderNotificationMsgSub = $translation->deliveryGuyNewOrderNotificationMsgSub;

        } else {
            //else use from config
            $runningOrderPreparingTitle = config('settings.runningOrderPreparingTitle');
            $runningOrderPreparingSub = config('settings.runningOrderPreparingSub');
            $runningOrderDeliveryAssignedTitle = config('settings.runningOrderDeliveryAssignedTitle');
            $runningOrderDeliveryAssignedSub = config('settings.runningOrderDeliveryAssignedSub');
            $runningOrderOnwayTitle = config('settings.runningOrderOnwayTitle');
            $runningOrderOnwaySub = config('settings.runningOrderOnwaySub');
            $runningOrderDelivered = config('settings.runningOrderDelivered');
            $runningOrderDeliveredSub = config('settings.runningOrderDeliveredSub');
            $runningOrderCanceledTitle = config('settings.runningOrderCanceledTitle');
            $runningOrderCanceledSub = config('settings.runningOrderCanceledSub');
            $runningOrderReadyForPickup = config('settings.runningOrderReadyForPickup');
            $runningOrderReadyForPickupSub = config('settings.runningOrderReadyForPickupSub');
            $deliveryGuyNewOrderNotificationMsg = config('settings.deliveryGuyNewOrderNotificationMsg');
            $deliveryGuyNewOrderNotificationMsgSub = config('settings.deliveryGuyNewOrderNotificationMsgSub');
        }
 
        $secretKey = 'key=' . config('settings.firebaseSecret');

        $token = PushToken::where('user_id', $user_id)->first();
        $device_os=$token->device_os;
        $codigo_pedido= substr($unique_order_id, -9);
        if ($token) {
            if ($orderstatus_id == '2') {
                $msgTitle = 'Preparando Pedido';//$runningOrderPreparingTitle;
                $msgMessage = 'Seu Pedido está sendo preparado!';//$runningOrderPreparingSub;
                $click_action = '';//config('settings.storeUrl') . '/running-order/' . $unique_order_id;
            }
            if ($orderstatus_id == '3') {
                $msgTitle = '';//$runningOrderDeliveryAssignedTitle;
                $msgMessage = '';//$runningOrderDeliveryAssignedSub;
                $click_action = '';//config('settings.storeUrl') . '/running-order/' . $unique_order_id;
            }
            if ($orderstatus_id == '4') {
                $msgTitle = 'Pedido saiu para Entrega';//$runningOrderOnwayTitle;
                $msgMessage = 'Em breve você receberá o seu pedido!';//$runningOrderOnwaySub;
                $click_action = '';//config('settings.storeUrl') . '/running-order/' . $unique_order_id;
            }
            if ($orderstatus_id == '5') {
                $msgTitle = 'Pedido Entregue!';//$runningOrderDelivered;
                $msgMessage = 'Oba! Seu Pedido já foi entregue com Sucesso!';//$runningOrderDeliveredSub;
                $click_action = '';//config('settings.storeUrl') . '/my-orders/';
            }
            if ($orderstatus_id == '6') {
                $msgTitle = 'Pedido Cancelado';//$runningOrderCanceledTitle;
                $msgMessage = 'Que Pena! Seu pedido foi Cancelado!';//$runningOrderCanceledSub;
                $click_action = '';//config('settings.storeUrl') . '/my-orders/';
            }
            if ($orderstatus_id == '7') {
                $msgTitle = 'Pedido Pronto para Retirada';//$runningOrderReadyForPickup;
                $msgMessage = 'Oba! Você já pode retirar o seu pedido!';//$runningOrderReadyForPickupSub;
                $click_action = '';//;config('settings.storeUrl') . '/running-order/' . $unique_order_id;
            }
            if ($orderstatus_id == 'TO_RESTAURANT') {
                $msgTitle = '';//$restaurantNewOrderNotificationMsg;
                $msgMessage = '';//$restaurantNewOrderNotificationMsgSub;
                $click_action = config('settings.storeUrl') . '/public/restaurant-owner/dashboard';
            }
            if ($orderstatus_id == 'TO_DELIVERY') {
                $msgTitle = $deliveryGuyNewOrderNotificationMsg;
                $msgMessage = $deliveryGuyNewOrderNotificationMsgSub;
                $click_action = config('settings.storeUrl') . '/delivery/orders/' . $unique_order_id;
            }
            $order=Order::where('unique_order_id',$unique_order_id)->first();
            /* $user=User::where('id',$user_id)->first();

            $data_order=[
                'user_id'=>$user_id,
                'token'=>$user->auth_token,
                'unique_order_id'=>$unique_order_id,
            ];

            $order_data = Curl::to('https://app.comprabakana.com.br/public/api/order-details')
            ->withHeader('Content-Type: application/json')
            ->withData(json_encode($data_order))
            ->post(); */


            $msg = array(
                'title' => $msgTitle,
                'message' => $msgMessage,
                'badge' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                'icon' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                'orderstatus_id'=>$orderstatus_id,
                'click_action' => $click_action,
                //'data'=>$order_data,
                'unique_order_id' => $unique_order_id,  
            );

            $msg_ios = array(
                'title' => $msgTitle,
                'body' => $msgMessage,
                'sound'=>'default',
                  
            );
            
            
            //dd($order);
            $restaurant= Restaurant::where('id',$order->restaurant_id)->first();  
            
            $alert = new Alert();
            $alert->data = json_encode($msg);
            $alert->user_id = $user_id;
            $alert->is_read = 0;
            $alert->type = 'firebase';
            $alert->logo = $restaurant->image;
            $alert->save();

            

         
                $fullData = array(
                    'to' => $token->token,
                    'notification' => $msg_ios,
                    'data'=>$msg
                );
            
            $response = Curl::to('https://fcm.googleapis.com/fcm/send')
                ->withHeader('Content-Type: application/json')
                ->withHeader("Authorization: $secretKey")
                ->withData(json_encode($fullData))
                ->post();
        }
        return $response;
    }

    /**
     * @param $user_id
     * @param $amount
     * @param $message
     * @param $type
     */
    public function sendWalletAlert($user_id, $amount, $message, $type)
    {

        $amountWithCurrency = config('settings.currencySymbolAlign') == 'left' ? config('settings.currencyFormat') . $amount : $amount . config('settings.currencyFormat');

        $msg = array(
            'title' => config('settings.walletName'),
            'message' => $amountWithCurrency . ' ' . $message,
            'is_wallet_alert' => true,
            'transaction_type' => $type,
        );

        $alert = new Alert();
        $alert->data = json_encode($msg);
        $alert->user_id = $user_id;
        $alert->is_read = 0;
        $alert->save();

    }

}
