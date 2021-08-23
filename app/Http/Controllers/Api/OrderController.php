<?php

namespace App\Http\Controllers\Api;

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
//use App\Address;
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
use App\PushToken;
use App\Helpers\TranslationHelper;
use App\IuguLr;
use App\IuguSubaccount;
use App\IuguSubaccountCustomer;
use App\Order;
use App\Orderissue;
use App\Orderitem;
use App\OrderItemAddon;
use App\RestaurantCustomer;
use App\Orderstatus;
use App\PushNotify;
use App\Safetransactions;
use App\Sms;
use Hashids;
use Omnipay\Omnipay;
use OneSignal;
use Mail;
use Safe2Pay\API\PaymentRequest;
use Safe2Pay\Models\Payment\CreditCard;
use Safe2Pay\Models\Transactions\Transaction;
use Safe2Pay\Models\General\Customer;
use Safe2Pay\Models\General\Product;
use Safe2Pay\Models\General\Address;

use Safe2Pay\Models\Core\Config as Enviroment;


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
    public function Safe2PayCreditCard($user,$cpf,$token_cartao,$location,$subaccount,$restaurant,$order_id,$totalCreditCard)
    {
        $token=$subaccount->token;


        $data = [
            "IsSandbox" => false, 
            "Application" => $order_id, 
            "Vendor" => $restaurant->name, 
            "CallbackUrl" => "https://app.comprabakana.com.br/api/safe2pay-a10960ad-60c0-46e1-b0ad-2b1a59c6cb36", 
            "PaymentMethod" => "2", 
            "Reference" => "COMPRABAKANA", 
            "ShouldUseAntiFraud"=>false,
            "Customer" => [
                  "Name" => $user->name, 
                  "Identity" => $cpf, 
                  "Phone" => $user->phone,//str_replace(['(', ')', '-', ' '],'',), 
                  "Email" => $user->email, 
                  "Address" => [
                     "ZipCode" => "90670090", 
                     "Street" => $location['address'], 
                     "Number" => $location['house'], 
                     "Complement" => $location['complement'], 
                     "District" => $location['address'], 
                     "CityName" => $location['city'], 
                     "StateInitials" => 'MG', 
                     "CountryName" => "Brasil" 
                  ] 
               ], 
            "Products" => [
                        [
                           "Code" => $order_id, 
                           "Description" => $order_id, 
                           "UnitPrice" => $totalCreditCard, 
                           "Quantity" => 1 
                        ], 
                        
                     ], 
            "PaymentObject" => [
                                    "token" => $token_cartao, 
                                    
                                    "IsPreAuthorization"=>false,
                                    "IsApplyInterest"=>false,
                                     
                                    "InstallmentQuantity" => 1, 
                                    "SoftDescriptor" => "COMPRABAK" 
                                 ] 
         ]; 

         $log= new Log();
         $log->url='https://payment.safe2pay.com.br/v2/Payment';
         $log->request=json_encode($data);
        // $log->response=$response;
         $log->user_id=$user->id;
         $log->restaurant_id=$restaurant->id;
         $log->save();

         $response = Curl::to('https://payment.safe2pay.com.br/v2/Payment')
         ->withHeader('Content-Type: application/json')
         ->withHeader("x-api-key: $token")
         ->withData(json_encode($data))
         ->post();

         $log= new Log();
         $log->url='https://payment.safe2pay.com.br/v2/Payment';
         $log->request=json_encode($data);
         $log->response=$response;
         $log->user_id=$user->id;
         $log->restaurant_id=$restaurant->id;
         $log->save();



// /* 
//         $enviroment = new Enviroment();
//         $enviroment->setAPIKEY($token);

//         //Inicializar método de pagamento
//         $payload = new Transaction();
//         //Ambiente de homologação
//         $payload->setIsSandbox(true);
//         //Descrição geral 
//         $payload->setApplication($unique_order_id);
//         //Nome do vendedor
//         $payload->setVendor($restaurant->name);
//         //Url de callback
//         $payload->setCallbackUrl("https://webhook.site/a10960ad-60c0-46e1-b0ad-2b1a59c6cb36");

//         //Código da forma de pagamento
//         // 1 - Boleto bancário
//         // 2 - Cartão de crédito
//         // 3 - Criptomoeda
//         // 4 - Cartão de débito 
//         // 6 - Pix
//         $payload->setPaymentMethod("2");

//         //Inicialização do cartão de crédito (
//             /* Holder, Nome impresso no cartão de crédito do comprador. Ex: João da Silva
//             CardNumber,  Número do cartão de crédito do comprador. Ex: 4122XXXXXXXX6740
//             ExpirationDate, Data de expiração do cartão de crédito do comprador. Ex: MM/YYYY
//             SecurityCode,  Código de verificação do cartão de crédito. Ex: 241
//             InstallmentQuantity, (Int) Número de parcelas. Ex: 03
//             IsPreAuthorization, (bool) Realizar a pré-autorização de uma transação com cartão de crédito, sem realizar a captura.
//             IsApplyInterest, (bool) Se deve cobrar juros ao valo da compra.
//             InterestRate, (decimal) Valor, em percentual (%), de juros que deve ser cobrado.
//             SoftDescriptor (string) Descrição que será enviada para a fatura do cliente. Se não enviado, serão utilizados os primeiros caracteres */
//             $Token='';
//         $CreditCard = new CreditCard("João da Silva", "4444333322221111", "12/2021", "241", $Token, 1, false, false, 2.32
//                                      , "Teste");

//         //Objeto de pagamento - para cartão de crédito
//         $payload->setPaymentObject($CreditCard);

//         $Products = array();

//        // for ($i = 0; $i < 10; $i++) {

//             $payloadProduct = new Product();
//             $payloadProduct->setCode($unique_order_id);
//             $payloadProduct->setDescription("Pedido n°: ".$unique_order_id);
//             $payloadProduct->setUnitPrice($totalCreditCard);
//             $payloadProduct->setQuantity(1);

//             array_push($Products, $payloadProduct);
//        // };

//         $payload->setProducts($Products);


//         //Customer
//         $Customer = new Customer();
//         $Customer->setName($user->name);
//         $Customer->setIdentity($cpf);
//         $Customer->setEmail($user->email);
//         $Customer->setPhone($user->phone);

//         $Customer->Address = new Address();
//         $Customer->Address->setZipCode("90620000");
//         $Customer->Address->setStreet($location->address);
//         $Customer->Address->setNumber($location->house);
//         $Customer->Address->setComplement($location->complement);
//         $Customer->Address->setDistrict($location->address);
//         $Customer->Address->setStateInitials($location->city);
//         $Customer->Address->setCityName($location->city);
//         $Customer->Address->setCountryName("Brasil");


//         $payload->setCustomer($Customer);

//         $response = PaymentRequest::CreatePayment($payload);

//         ///echo(json_encode($response)); */

        return json_decode($response);
    }

    public function testCreditCard(Request $request){

        
    }

/**
     * @param Request $request
     */
    public function checkCartItemsAvailability(Request $request)
    {
        $items = $request->order;
        $array_items_out_of_stock = [];
        $restaurant=Restaurant::where('id',$request->restaurant_id)->first();

        if($restaurant->manage_stock ==1){
            foreach ($items as $item) {
                $oneItem = Item::where('id', $item['id'])->first();
                if ($oneItem) {
                    if(($oneItem->estoque) < ($item['quantity']))
                    {
                        array_push($array_items_out_of_stock, $oneItem);
                    }
                }
            }
    
            if(count($array_items_out_of_stock)){
                $show_popup=true;
                $menu = "<p>Os Itens:</p><ul>";
    
                foreach ($array_items_out_of_stock as $item) {
                    $menu .= "<li>";
                    $menu .= "<span>".$item['name']." (".$item['estoque']."un)</span>";
                    $menu .= "</li>";
                }
                $menu .= "</ul>";
                $menu .= "<p>Estão <strong>sem estoque</strong> no momento e por isso seu prazo de entrega está maior. Para não atrasar sua entrega, exclua estes itens do carrinho e depois faça seu pedido separadamente.</p>";
                $message=$menu;
                $title='Atenção!';
              
                
            }else{
                $show_popup=false;
                $message=null;
                $title=null;
            }
        }else{
            $show_popup=false;
                $message=null;
                $title=null;
        }
        

       

        $response=[
            'show_popup'=>false,//$show_popup,
            'title'=>null,//$title,
            'message'=>null,//$message,

        ];

        return response()->json($response);
    }


         public function placeOrder_OrderSubTotal($request){
            $orderTotal = 0;
            foreach ($request['order'] as $oI) {
                $originalItem = Item::where('id', $oI['id'])->first();
                $agora = Carbon::now();
                if(($originalItem->is_offer_notime ==1) && ($originalItem->price != null)){
                    $original_item_price=$originalItem->price;
                }elseif(date('d/m/Y' ,strtotime($originalItem->start_date)) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($originalItem->end_date)) >=date('d/m/Y' ,strtotime($agora)) && $originalItem->price!=null )
                {
                    $original_item_price=$originalItem->price;
                }else{
                    $original_item_price=$originalItem->old_price;
                }
                
                if(isset($oI['peso'])){
                    $orderTotal += ($original_item_price * $oI['quantity']* $oI['peso']); //ADICIONADO MULTIPLICAÇÃO POR PESO
                }else{
                    $orderTotal += ($original_item_price * $oI['quantity']); 
                }
               //$item_category=ItemCategory::where('id',$oI['item_category_id'])->first();
                //$pizza_more_flavors=$item_category->pizza_more_flavors;
                
                $addons_flavors_total=[];
                $item=Item::where('id',$oI['id'])->first();
                $item_flavors=$item->pizza_flavors;


                
                if (isset($oI['selectedaddons'])) {
                    $count=count($oI['selectedaddons']);

                    if($count>0){
                        foreach ($oI['selectedaddons'] as $selectedaddon) {
                            //$addon = Addon::where('id', $selectedaddon['addon_id'])->first();
                           // if ($addon) {
                                if( $selectedaddon['more_flavors']==1 && $selectedaddon['flavor']==1){
                                    $orderTotal += ($selectedaddon['price'])/$item_flavors * $oI['quantity'];
                                }elseif( $selectedaddon['more_flavors']==2 && $selectedaddon['flavor']==1){
                                    $addons_flavors_total[]=$selectedaddon['price'];
                                }else{
                                    $orderTotal += $selectedaddon['price'] * $oI['quantity'];
                                }
                                
                           // }
    
                        }
                        if($selectedaddon['more_flavors']==2 && $selectedaddon['flavor']==1){
                            $orderTotal += max($addons_flavors_total) * $oI['quantity'];
                        }
                    }
                 
                }


               
            }
            return $orderTotal;
         }

         public function placeOrder_UniqueId($lastOrder){
            
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
            
            return $unique_order_id;
         }

         public function placeOrder_Coupon($request,$orderTotal){
            if ($request->coupon) {
                $coupon = Coupon::where('code', strtoupper($request['coupon']))->first();
                $coupon_array=array();
                if ($coupon) {
                    $coupon_array['coupon_name'] = $request['coupon'];
                    if ($coupon->discount_type == 'PERCENTAGE') {
                        $percentage_discount = (($coupon->discount / 100) * $orderTotal);
                        if ($coupon->max_discount) {
                            if ($percentage_discount >= $coupon->max_discount) {
                                $percentage_discount = $coupon->max_discount;
                            }
                        }
                        $coupon_array['coupon_amount'] = $percentage_discount;
                        $orderTotal = $orderTotal - $percentage_discount;
                    }
                    if ($coupon->discount_type == 'AMOUNT') {
                        $coupon_array['coupon_amount'] = $coupon->discount;
                        $orderTotal = $orderTotal - $coupon->discount;
                    }
                    $coupon->count = $coupon->count + 1;
                    $coupon->save();
                }
                $coupon_array['orderTotal'] =$orderTotal;
                return $coupon_array;
            }

         }
   
         public function placeOrder_DeliveryTax($request,$restaurant,$subtotal_items){
            $restaurant_distance = $request->dis;      
            $delivery_time_vector=(array) json_decode($restaurant->delivery_time_vector);
            $delivery_tax='';

            foreach($delivery_time_vector as $row){
                if($row->km >= $restaurant_distance){
                    if($row->price_free_shipping !=null && $restaurant->price_free_shipping_active==1 ){
                        
                            if($subtotal_items >= $row->price_free_shipping){
                                $delivery_tax='0.00';
                            }else{
                                $delivery_tax=str_replace(',','.',$row->price);
                            }
                          
                    }
                    else{
                        $delivery_tax=str_replace(',','.',$row->price);
                    }
                    break;
                }
            }
            return $delivery_tax;

         }

         public function placeOrder_OrderTotal($request,$restaurant){
            $orderSubTotal=$this->placeOrder_OrderSubTotal($request);
            //$subtotal_items=$orderSubTotal;
            $orderTotal=$orderSubTotal;

            if ($request->coupon) {
               $orderTotal=$this->placeOrder_Coupon($request,$orderSubTotal)['orderTotal'];
            }

            if ($request->delivery_type == 1) {
                $delivery_tax=$this->placeOrder_DeliveryTax($request,$restaurant,$orderTotal);
                $orderTotal = $orderTotal + $delivery_tax;
            }
            $orderTotal = $orderTotal + $restaurant->restaurant_charges;

            if (isset($request['tipAmount']) && !empty($request['tipAmount'])) {
                $orderTotal = $orderTotal + $request['tipAmount'];
            }

            return $orderTotal;

         }

         public function placeOrder_RunOrder($request,$translationHelper,$user,$pay){

            $keys = ['orderPaymentWalletComment', 'orderPartialPaymentWalletComment'];
            $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);
            $lastOrder = Order::orderBy('id', 'desc')->first();

            $restaurant_id = $request['order'][0]['restaurant_id'];
            $restaurant = Restaurant::where('id', $restaurant_id)->first();
            
            $newOrder = new Order();
            $newOrder->unique_order_id = $this->placeOrder_UniqueId($lastOrder);
            $newOrder->user_id = $user->id;
            $newOrder->orderstatus_id = '1';
            $newOrder->location = json_encode($request['location']);
            $newOrder->address = $request['location']['address'];
            $newOrder->restaurant_charge = $restaurant->restaurant_charges;
            $orderSubTotal=$this->placeOrder_OrderSubTotal($request);
            
            $subtotal_items=$orderSubTotal;
            $newOrder->sub_total = $subtotal_items;
            $orderTotal=$orderSubTotal;

            if ($request->coupon) {
                $newOrder->coupon_amount =$this->placeOrder_Coupon($request,$orderSubTotal)['coupon_amount'];
                $newOrder->coupon_name =$this->placeOrder_Coupon($request,$orderSubTotal)['coupon_name'];
                $orderTotal=$this->placeOrder_Coupon($request,$orderSubTotal)['orderTotal'];
            }
            $subtotal=$orderTotal;

            if ($request->delivery_type == 1) {
                $delivery_tax=$this->placeOrder_DeliveryTax($request,$restaurant,$orderTotal);
                $newOrder->delivery_charge = $delivery_tax;
                $newOrder->delivery_tax = $delivery_tax;
               // $orderTotal = $orderTotal + $delivery_tax;

            } else {
                $newOrder->delivery_charge = '0.00';
                $newOrder->delivery_tax ='0.00';
            }
                
           
            $orderTotal=$this->placeOrder_OrderTotal($request,$restaurant);
            //this is the final order total

            if ($request['payment_mode'] == 'COD') {
                if ($request->partial_wallet == true) {
                    //deduct all user amount and add
                    $newOrder->payable = $orderTotal - $user->balanceFloat;
                }
                if ($request->partial_wallet == false) {
                    $newOrder->payable = $orderTotal;
                }
            }

            if ($request['payment_mode'] == 'COD') {
                if ($request->partial_wallet == true) {
                    $userWalletBalance = $user->balanceFloat;
                    $newOrder->wallet_amount = $userWalletBalance;
                    $newOrder->save();
                    //deduct all user amount and add
                    $user->withdraw($userWalletBalance * 100, ['description' => $translationData->orderPartialPaymentWalletComment . $newOrder->unique_order_id]);
                }
            }

            $newOrder->total = $orderTotal;
            if($restaurant->cashback_active==1){
                $cashback_store=$restaurant->cashback_percent;
            }else{
                $cashback_store=0;
            }

            if($request['payment_mode'] == 'CREDITCARD'){

                

                $cashback_amount=$subtotal*($cashback_store)/100 + $subtotal*0.01;

                $user->deposit($subtotal*0.01, ['description' =>  $newOrder->id]);
                $newOrder->paid_cashbakana =$subtotal*0.01;
                $newOrder->paid_cashback_store =$subtotal*($cashback_store)/100;
                   
            }else{
                $cashback_amount=$subtotal*($cashback_store)/100;
                $newOrder->paid_cashback_store =$subtotal*($cashback_store)/100;
            }

            $newOrder->cashback_amount = $cashback_amount;
            $newOrder->order_comment = $request['order_comment'];
            $newOrder->payment_mode = $request['payment_mode'];
            $newOrder->payment_type = $request['payment_type'];
            $newOrder->cod_change = $request['troco'];
            $newOrder->restaurant_id = $request['order'][0]['restaurant_id'];
            $newOrder->tip_amount = $request['tipAmount'];
            $newOrder->delivery_type = $request->delivery_type;
          

            $user->delivery_pin = strtoupper(str_random(5));
            $user->save();

            if (($request['payment_mode'] == 'CREDITCARD') && ($request['payment_type'] == 'app')) {
            $newOrder->transaction_id=$pay->ResponseDetail->IdTransaction;
            $newOrder->iugu_status=1;
            $newOrder->paid_cbkpay=$orderTotal;
            $newOrder->error_payment=false;


            }

            
            //if method is WALLET, then deduct amount with appropriate description
            if ($request['payment_mode'] == 'WALLET') {
                $userWalletBalance = $user->balanceFloat;
                $newOrder->wallet_amount = $orderTotal;
                $newOrder->save();
                $user->withdraw($orderTotal * 100, ['description' => $translationData->orderPaymentWalletComment . $newOrder->unique_order_id]);
            }

                    
            $newOrder->save();

$restaurant_customer_old=RestaurantCustomer::where('restaurant_id',$restaurant->id)->where('user_id',$user->id)->first();
        if(isset($restaurant_customer_old)){
            
            $restaurant_customer_old->user_id=$user->id;
            $restaurant_customer_old->restaurant_id=$restaurant->id;
            $restaurant_customer_old->total=$restaurant_customer_old->total +$newOrder->total;
            $restaurant_customer_old->save(); 
        }else{
            $restaurant_customer= new RestaurantCustomer();
            $restaurant_customer->user_id=$user->id;
            $restaurant_customer->restaurant_id=$restaurant->id;
            $restaurant_customer->total=$newOrder->total;
            $restaurant_customer->save();
        }
          
            
          

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
                            $item->item_obs = $orderItem['item_obs'];

                            $itemdb=Item::where('id',$orderItem['id'])->first();
                            $item->image=$itemdb->image;
                            $item->ean= $itemdb->ean;
                            $item->codint=$itemdb->codint;

                            
                            if(isset($orderItem['peso'])){
                                $item->peso = $orderItem['peso'];
                            }
                            
                            $originalItem = $itemdb;
                            $agora = Carbon::now();
                            if(($originalItem->is_offer_notime ==1) && ($originalItem->price != null)){
                                $original_item_price=$originalItem->price;
                            }elseif(date('d/m/Y' ,strtotime($originalItem->start_date)) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($originalItem->end_date)) >=date('d/m/Y' ,strtotime($agora)) && $originalItem->price!=null )
                            {
                                $original_item_price=$originalItem->price;
                            }else{
                                $original_item_price=$originalItem->old_price;
                            }


                            $item->price = $original_item_price;
                            $item->save();

                            ////////////ATUALIZANDO ESTOQUE //////////////////////////
                            if($restaurant->manage_stock == 1){
                                $quantity_before=$itemdb->estoque;
                                $quantity_item_order=$orderItem['quantity'];
                                $quantity_item_now=$quantity_before - $quantity_item_order;
                                $itemdb->estoque=$quantity_item_now;
                                $itemdb->save();

                            }
                            ///////////////ATUALIZANDO ESTOQUE - FIM /////////////////
                            $addons_flavors_total=[];
                            
                            $item_flavors=$itemdb->pizza_flavors;

                            if (isset($orderItem['selectedaddons'])) {
                                foreach ($orderItem['selectedaddons'] as $selectedaddon) {
                                    

                                    if($itemdb['is_pizza']==1 && $selectedaddon['more_flavors']==1 && $selectedaddon['flavor']==1){
                                        $addon = new OrderItemAddon();
                                        $addon->orderitem_id = $item->id;
                                        $addon->addon_category_name = $selectedaddon['addon_category_name'];
                                        $addon->addon_name = $selectedaddon['addon_name'];
                                        $addon->addon_price= ($selectedaddon['price'])/$item_flavors ;
                                        $addon->save();
                                    }else{
                                        $addon = new OrderItemAddon();
                                        $addon->orderitem_id = $item->id;
                                        $addon->addon_category_name = $selectedaddon['addon_category_name'];
                                        $addon->addon_name = $selectedaddon['addon_name'];
                                        $addon->addon_price = $selectedaddon['price'];
                                        $addon->save();

                                    }

                                }
                            }


                            
            







                        }

                        return $newOrder;

         }



/**
     * @param Request $request
     */
    public function placeOrder(Request $request, TranslationHelper $translationHelper)
    {
        $user = auth()->user();

        if ($user) {
            $restaurant_id = $request['order'][0]['restaurant_id'];
            $restaurant = Restaurant::where('id', $restaurant_id)->first();
            $lastOrder = Order::orderBy('id', 'desc')->first();

            //-----------PAGAMENTO COM CARTAO DE CREDITO--------------INICIO--------------------------------------
            if (($request['payment_mode'] == 'CREDITCARD') && ($request['payment_type'] == 'app')) {
                
                $subaccount=IuguSubaccount::where('restaurant_id',$restaurant->id)->first();
                $orderTotal=$this->placeOrder_OrderTotal($request,$restaurant);
                $totalCreditCard=$orderTotal;
                $order_id=$this->placeOrder_UniqueId($lastOrder);
                $pay=$this->Safe2PayCreditCard($user,$request->cpf,$request->iugu_token,$request->location,$subaccount,$restaurant,$order_id,$totalCreditCard);
                $res=$pay;

                if(isset($res)){
                    if(($pay->HasError==true)){
                        $message=[
                            'title'=> 'Erro na Transação',
                            'description'=> $pay->Error
                        ];
                        $resp1=[
                            'success'=>false,
                            'data'=>$pay,
                            'message'=>$message
                        ];
                        return response()->json($resp1);
                    }
                    
                    if(($pay->ResponseDetail->Status =='8')){
                        $message=[
                            'title'=> $pay->ResponseDetail->Message,
                            'description'=> $pay->ResponseDetail->Description
                        ];
                        $resp1=[
                            'success'=>false,
                            'data'=>$pay,
                            'message'=>$message
                        ];
                        return response()->json($resp1);  

                    }
                    if(($pay->ResponseDetail->Status =='3')){

                        $newOrder=$this->placeOrder_RunOrder($request,$translationHelper,$user,$pay);


                       

                            //------- Salvando Dados da Transação ----------
                          $IdTransaction=$newOrder->transaction_id;
            
                            $safetransaction_response= $this->Safe2PayCheckTransaction($IdTransaction,$subaccount);

                            $log= new Log();
                            $log->url='https://payment.safe2pay.com.br/v2/Payment';
                            $log->request=$IdTransaction;
                            $log->response=json_encode($safetransaction_response);
                            $log->user_id=$user->id;
                            $log->restaurant_id=$restaurant->id;
                            $log->save(); 

                            $pay=$safetransaction_response;

                            if(($pay->HasError==true)){
                                
                               
                            }else{
                                //$array = json_decode(json_encode($pay->ResponseDetail->CheckingAccounts), true);
                                if(isset($pay->ResponseDetail->CheckingAccounts)){
                                    $array = json_decode(json_encode($pay->ResponseDetail->CheckingAccounts), true);
                                    $IsTransferred=$array[0]['IsTransferred'];
                                    $ReleaseDate=$array[0]['ReleaseDate'];
                                    

                                }else{
                                    $IsTransferred=false;
                                    $ReleaseDate="";
                                }
                               
                                $safetransaction = new Safetransactions();
                                $safetransaction->IdTransaction = $IdTransaction;
                                $safetransaction->Status = $pay->ResponseDetail->Status;
                                $safetransaction->Amount = $pay->ResponseDetail->Amount;
                                $safetransaction->NetValue = $pay->ResponseDetail->NetValue;
                                $safetransaction->TaxValue = $pay->ResponseDetail->TaxValue;
                                $safetransaction->NegotiationTax = $pay->ResponseDetail->NegotiationTax;
                                $safetransaction->Message = $pay->ResponseDetail->Message;
                                $safetransaction->IsTransferred=$IsTransferred;
                                $safetransaction->ReleaseDate=$ReleaseDate;
                                $safetransaction->PaymentMethod=$pay->ResponseDetail->PaymentMethod;
                                $safetransaction->order_id=$newOrder->id;
                                $safetransaction->PaymentDate=$newOrder->created_at;
                                $safetransaction->CreatedDate=$newOrder->created_at;
                                $safetransaction->restaurant_id=$restaurant->id;
                                $safetransaction->user_id=$user->id;
                                $safetransaction->credit_card_percent=$subaccount->credit_card_percent;
                                $safetransaction->debit_card_percent=$subaccount->debit_card_percent;
                                $safetransaction->pix_percent=$subaccount->pix_percent;
                                $safetransaction->comission=$subaccount->comission;
                                $safetransaction->plan_model=$subaccount->plan_model;
                                $safetransaction->save();
                            }

                             
            
                          

 
                    }
                }

            }else{
                $pay=array();
                $newOrder=$this->placeOrder_RunOrder($request,$translationHelper,$user,$pay);
            }


       




            $previsao_entrega=null;
            $message =null;
            if($newOrder['orderstatus_id'] == 1){
                $message =[
                    'title'=>'Pedido Realizado',
                    'description' => 'Aguardando o estabelecimento confirmar seu Pedido'
                ];
            }

      
                        if ($user->default_address_id !== 0) {
                            $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                        } else {
                            $default_address = null;
                        }
                        $running_order = \App\Order::where('id', $newOrder['id'])
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
                        if (!$restaurant->auto_acceptable && $newOrder['orderstatus_id'] == '1' && config('settings.smsRestaurantNotify') == 'true') {

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
                                    $notify->sendPushNotification('TO_DELIVERY', $pU->id, $newOrder['unique_order_id']);
                                }
                            }

                        }

                        /* OneSignal Push Notification to Store Owner */
                        //if ($newOrder->orderstatus_id == '1' && config('settings.oneSignalAppId') != null && config('settings.oneSignalRestApiKey') != null) {
                        //    $this->sendPushNotificationStoreOwner($restaurant_id);
                       // }
                        /* END OneSignal Push Notification to Store Owner */

                   


                   
                


       


                


                    //////PUSH to APP lojista
                        
                        //to user
                    // $notify = new PushNotify();
                    // $notify->sendPushNotification('1', $newOrder->user_id, $newOrder->unique_order_id);
                        $secretKey = 'key=AAAAFBuVDzA:APA91bFnHFU--727N58zbfOWInPrMEeBTOl-U0amqQFw0f6P6HQoTAD2-Ijn7xnz55o-aD0EFpIMeuYt8Aek1mR_ayU_d-pcgu-OlROYk-Hv3mEuzQWTz3X_oIy5OXkA7PS2mrAjvPmz';


                        $token = PushToken::where('user_id', $restaurant->user_id)->first();
                        $msgTitle = 'Novo Pedido!';//$runningOrderCanceledTitle;
                        $msgMessage = 'Novo pedido no APP! Confira!';

                        $click_action = '';//config('settings.storeUrl') . '/my-orders/';
                        $user=User::where('id',$newOrder['user_id'])->first();

                        $data_order=[
                            'user_id'=>$newOrder['user_id'],
                            'token'=>$user->auth_token,
                            'unique_order_id'=>$newOrder['unique_order_id'],
                        ];

                    /*  $order_data = Curl::to('https://app.comprabakana.com.br/public/api/order-details')
                        ->withHeader('Content-Type: application/json')
                        ->withData(json_encode($data_order))
                        ->post(); */

                    if($token){
                        $msg = array(
                            'title' => $msgTitle,
                            'message' => $msgMessage,
                            'badge' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                            'icon' => 'https://app.comprabakana.com.br/assets/img/favicon90x90.png',
                            'orderstatus_id'=>$newOrder['orderstatus_id'],
                            //'data'=>$order_data,
                            'click_action' => $click_action,
                            'unique_order_id' => $newOrder['unique_order_id'],  
                        );
                        /* $fullData = array(
                            'to' => $token->token,
                            'data' => $msg,
                        ); */
            
                        $msg_ios = array(
                            'title' => $msgTitle,
                            'body' => $msgMessage,
                            'sound'=>'default',
                            
                        );
                        $fullData = array(
                            'to' => $token->token,
                            'notification' => $msg_ios,
                            'data'=>$msg
                        );
            
                        $response_push = Curl::to('https://fcm.googleapis.com/fcm/send')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader("Authorization: $secretKey")
                            ->withData(json_encode($fullData))
                            ->post();

                            $running_order = \App\Order::where('id', $newOrder['id'])->first();
                            $running_order->response_push=$response_push;
                            $running_order->save();
                    }
            

                /* OneSignal Push Notification to Store Owner */
                /* if ($newOrder->orderstatus_id == '1' && config('settings.oneSignalAppId') != null && config('settings.oneSignalRestApiKey') != null) {
                    $this->sendPushNotificationStoreOwner($restaurant_id);
                } */
                /* END OneSignal Push Notification to Store Owner */

                /// Enviando Email para o Lojista - INICIO /////
                $order_code=$newOrder['unique_order_id'];
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
    
                    
    
                    $response_email = [
                        'success' => true,
                        'message' => 'Password reset mail sent',
                    ];
                   // return response()->json($response);
                } catch (Exception $e) {
                    $response_email = [
                        'success' => false,
                        'message' => $e->getMessage(),
                        'error_code' => 'SWR', //Something Went Wrong
                    ];
                    //return response()->json($response);
                }






                return response()->json($response);
           

            
        }
    }

    /**
     * @param Request $request
     */
  public function Safe2PayCheckTransaction($IdTransaction,$subaccount)
    {
       
        $token=$subaccount->token;

         $data=array();

        $response = Curl::to('https://api.safe2pay.com.br/v2/transaction/Get?Id='.$IdTransaction)
         ->withHeader('Content-Type: application/json')
         ->withHeader("x-api-key:".$token)
         ->withData(json_encode($data))
         ->get();
         
        // $subaccount->log=$response;
         //$subaccount->save();
         
        return json_decode($response);
    }

/**
     * @param Request $request
     */
    public function placePayment(Request $request, TranslationHelper $translationHelper)
    {
        $user = auth()->user();

        if ($user) {
            $order_id=$request->order_id;
            $restaurant_id = $request->restaurant_id;
            $restaurant = Restaurant::where('id', $restaurant_id)->first();
            $order = Order::where('id',$order_id)->first();
            $payable = $order->payable;

            //-----------PAGAMENTO COM CARTAO DE CREDITO--------------INICIO--------------------------------------
           
                
                $subaccount=IuguSubaccount::where('restaurant_id',$restaurant->id)->first();
                $orderTotal=$payable;
                $totalCreditCard=$orderTotal;
                $unique_order_id=$order->unique_order_id;
                $pay=$this->Safe2PayCreditCard($user,$request->cpf,$request->iugu_token,$request->location,$subaccount,$restaurant,$unique_order_id,$totalCreditCard);
                $res=$pay;

                if(isset($res)){
                    if(($pay->HasError==true)){
                        $message=[
                            'title'=> 'Erro no Pagamento',
                            'description'=> $pay->Error
                        ];
                        $resp1=[
                            'success'=>false,
                            'data'=>$pay,
                            'message'=>$message
                        ];
                        return response()->json($resp1);
                    }
                    
                    if(($pay->ResponseDetail->Status =='8')){
                        $message=[
                            'title'=> $pay->ResponseDetail->Message,
                            'description'=> $pay->ResponseDetail->Description
                        ];
                        $resp1=[
                            'success'=>false,
                            'data'=>$pay,
                            'message'=>$message
                        ];
                        return response()->json($resp1);  

                    }
                    if(($pay->ResponseDetail->Status =='3')){

                        $order->payable="0.00";
                        $order->transaction_id=$pay->ResponseDetail->IdTransaction;
                        $order->iugu_status=1;
                        $order->paid_cbkpay=$totalCreditCard;
                        $order->payment_type="app";
                        $order->payment_mode="CREDITCARD";
                        $order->error_payment=false;
                        $order->save();
                        $message=[
                            'title'=> 'Pagamento Efetuado com Sucesso!',
                            'description'=> 'Transação Aprovada! Tudo certo com sua Compra!'
                        ];
                        
                        $response=[
                            'status'=> true,
                            'data'=>$pay,
                            'message'=>$message,
                        ];

                        //------- Salvando Dados da Transação ----------
                        $IdTransaction=$pay->ResponseDetail->IdTransaction;
                                    
                        $safetransaction_response= $this->Safe2PayCheckTransaction($IdTransaction,$subaccount);

                        $log= new Log();
                        $log->url='https://payment.safe2pay.com.br/v2/Payment';
                        $log->request=$IdTransaction;
                        $log->response=json_encode($safetransaction_response);
                        $log->user_id=$user->id;
                        $log->restaurant_id=$restaurant->id;
                        $log->save(); 

                        $pay=$safetransaction_response;

                        if(($pay->HasError==true)){
                            
                        
                        }else{
                            //$array = json_decode(json_encode($pay->ResponseDetail->CheckingAccounts), true);
                            if(isset($pay->ResponseDetail->CheckingAccounts)){
                                $array = json_decode(json_encode($pay->ResponseDetail->CheckingAccounts), true);
                                $IsTransferred=$array[0]['IsTransferred'];
                                $ReleaseDate=$array[0]['ReleaseDate'];
                                

                            }else{
                                $IsTransferred=false;
                                $ReleaseDate="";
                            }
                        
                            $safetransaction = new Safetransactions();
                            $safetransaction->IdTransaction = $IdTransaction;
                            $safetransaction->Status = $pay->ResponseDetail->Status;
                            $safetransaction->Amount = $pay->ResponseDetail->Amount;
                            $safetransaction->NetValue = $pay->ResponseDetail->NetValue;
                            $safetransaction->TaxValue = $pay->ResponseDetail->TaxValue;
                            $safetransaction->NegotiationTax = $pay->ResponseDetail->NegotiationTax;
                            $safetransaction->Message = $pay->ResponseDetail->Message;
                            $safetransaction->IsTransferred=$IsTransferred;
                            $safetransaction->ReleaseDate=$ReleaseDate;
                            $safetransaction->PaymentMethod=$pay->ResponseDetail->PaymentMethod;
                            $safetransaction->order_id=$order->id;
                            $safetransaction->PaymentDate=$order->created_at;
                            $safetransaction->CreatedDate=$order->created_at;
                            $safetransaction->restaurant_id=$restaurant->id;
                            $safetransaction->user_id=$user->id;
                            $safetransaction->credit_card_percent=$subaccount->credit_card_percent;
                            $safetransaction->debit_card_percent=$subaccount->debit_card_percent;
                            $safetransaction->pix_percent=$subaccount->pix_percent;
                            $safetransaction->comission=$subaccount->comission;
                            $safetransaction->plan_model=$subaccount->plan_model;
                            $safetransaction->save();
                        }




                    }
                }

          


         
                




                return response()->json($response);
           

            
        }
    }



/**
     * @param Request $request
     */
    public function cancelOrder(Request $request, TranslationHelper $translationHelper)
    {
        $user = auth()->user();
        $keys = ['orderRefundWalletComment', 'orderPartialRefundWalletComment'];
        $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

        $order = Order::where('id', $request->order_id)->first();

        

        //check if user is cancelling their own order...
        if ($order->user_id == $user->id && ($order->orderstatus_id == 1)) {

            //if payment method is not COD, and order status is 1 (Order placed) then refund to wallet
            $refund = false;

            /* //if COD, then check if wallet is present
            if ($order->payment_mode == 'COD') {
                if ($order->wallet_amount != null) {
                    //refund wallet amount
                    $user->deposit($order->wallet_amount * 100, ['description' => $translationData->orderPartialRefundWalletComment . $order->unique_order_id]);
                    $refund = true;
                }
            } else {
                //if online payment, refund the total to wallet
                $user->deposit(($order->total) * 100, ['description' => $translationData->orderRefundWalletComment . $order->unique_order_id]);
                $refund = true;
            } */

            //cancel order  
            
            $order->canceled_from='User';
            $order->canceled_at=Carbon::now();
            $order->orderstatus_id = 6; //6 means canceled..
            $order->save();  



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

            
            
               /*  $notify = new PushNotify();
                $notify->sendPushNotification('6', $order->user_id, $order->unique_order_id); */

                
            

            $response = [
                'success' => true,  
               // 'refund' => $refund,
                //'envio'=>$envio,
                'message'=> 'Pedido Cancelado com Sucesso',
            ];

            return response()->json($response);

        } else {
            $response = [
                'success' => false,
                'refund' => false,
                'message'=> 'Não foi possível cancelar o seu pedido!',
            ];
            return response()->json($response);
        }

    }




     /**
 * @param Request $request
 */
    public function OrderDetails(Request $request)
    {
        $user = auth()->user();

        if ($user) {
// ALTERADO - inclui id, city, complement, etc..
            if ($user->default_address_id !== 0) {
                $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
            } else {
                $default_address = null;
            }

            $running_order = \App\Order::where('user_id', $user->id)
                ->whereIn('orderstatus_id', ['1', '2', '3', '4', '5', '6', '7', '8']) //ALTERADO - inclui o 5  e 6
                ->where('unique_order_id', $request->unique_order_id)
                ->with('orderitems', 'orderitems.order_item_addons', 'restaurant')
                ->first();

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
       // $method=null; // não precisa se tiver o token
        
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
            'price_cents'=>intval($request['amount'])*100,
         ];


         $data=[
            'api_token'=>$api_token,
            //'method'=>$method,
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
            $response2=json_decode($response1);
            
            $log = new Log();
                $log->request=json_encode($data);
                $log->response=json_encode($response2);
                $log->user_id=$user->id;
                $log->restaurant_id=$request['restaurant_id'];
                $log->save(); 

            return $res1;


    }






    
};
