<?php
namespace App\Http\Controllers;

use App\AcceptDelivery;
use App\Address;
use App\Rating;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantFavorite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;
use JWTAuth;
use App\Iugu;
use JWTAuthException;
use Spatie\Permission\Models\Role;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

class UserController extends Controller
{
    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid..',
                    'token' => $token,
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }

    public function me() {
        return $this->respond(auth()->user());
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {

        $user = \App\User::where('email', $request->email)->get()->first();

        //check if it is coming from social login,
        if ($request->accessToken != null) {

            //check socialtoken validation
            $validation = $this->validateAccessToken($request->email, $request->provider, $request->accessToken);
            if ($validation) {
                if ($user) {
                    //user exists -> check if user has phone
                    if ($user->phone != null) {
                        // user has phone
                        //LOGIN USER
                        $token = JWTAuth::fromUser($user);
                        $user->auth_token = $token;
                        if ($request->phone != null) {
                            $user->phone = $request->phone; // Salvando telefone após novo login
                        }
                        // Add address if address present
                        if ($request->address['lat'] != null) {
                            $address = new Address();
                            $address->user_id = $user->id;
                            $address->latitude = $request->address['lat'];
                            $address->longitude = $request->address['lng'];
                            $address->address = $request->address['address'];
                            $address->house = $request->address['house'];
                            $address->city = $request->address['city'];
                            $address->landmark = $request->address['landmark'];
                            $address->complement = $request->address['complement'];
                            $address->tag = $request->address['tag'];
                            $address->save();
                            $user->default_address_id = $address->id;
                        }

                        $user->save();
                        if ($user->default_address_id !== 0) {
                            // ALTERADO - inclui id, city, complement, etc..
                            $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house', 'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                        } else {
                            $default_address = null;
                        }

                        if ($user->default_credit_card_id !== 0) {
                            $default_credit_card = \App\UserCreditCard::where('id', $user->default_credit_card_id)->get(['id', 'token', 'is_active',  'user_id', 'Brand', 'Holder',  'CardNumber', 'ExpirationDate', 'cpf'])->first();
                        } else {
                            $default_credit_card = null;
                        }

                        $running_order = null;

                        if($user->usercode_referral ){
                            $show_popup_referral=false;
                        }else{
                            $show_popup_referral=false;  
                        }

                        $response = [
                            'success' => true,
                            'data' => [
                                'id' => $user->id,
                                'auth_token' => $token,
                                'name' => $user->name,
                                'email' => $user->email,
                                'avatar'=> $user->avatar,
                                'phone' => $user->phone,
                                'show_popup_referral'=>$show_popup_referral,
                                'provider' => $user->provider,
                                'default_address_id' => $user->default_address_id,
                                'default_address' => $default_address,
                                'default_credit_card' => $default_credit_card,
                        'default_credit_card_id' => $user->default_credit_card_id,
                                'delivery_pin' => $user->delivery_pin,
                                'user_type'=> $user->user_type,
                                'restaurant'=> $user->restaurant_id,
                                'wallet_balance' => $user->balanceFloat,
                            ],
                            'running_order' => $running_order,
                        ];
                        return response()->json($response);
                    }
                    if ($request->phone != null) {
                        $checkPhone = User::where('phone', $request->phone)->first();
                       /*  if ($checkPhone) {
                            $response = [
                                'email_phone_already_used' => true,
                            ];
                            return response()->json($response);
                        } else { */
                            try {
                                $user->phone = $request->phone;

                                if(isset($request->usercode_referral)){
                                    $user->usercode_referral=$request->usercode_referral;
                                }
                                if(isset($request->usercode_referral)){
                                    $user->usercode_referral=$request->usercode_referral;
                                }

                                $user->save();
                                $token = JWTAuth::fromUser($user);
                                $user->auth_token = $token;

                                // Add address if address present
                                if ($request->address['lat'] != null) {
                                    $address = new Address();
                                    $address->user_id = $user->id;
                                    $address->latitude = $request->address['lat'];
                                    $address->longitude = $request->address['lng'];
                                    $address->address = $request->address['address'];
                                    $address->house = $request->address['house'];
                                    $address->city = $request->address['city'];
                                    $address->landmark = $request->address['landmark'];
                                    $address->complement = $request->address['complement'];
                                    $address->tag = $request->address['tag'];
                                    $address->save();
                                    $user->default_address_id = $address->id;
                                }

                                $user->save();
                            } catch (\Throwable $e) {
                                $response = ['success' => false, 'data' => 'Something went wrong. Please try again...'];
                                return response()->json($response, 201);
                            }
                            // ALTERADO - inclui id, city, complement, etc..
                            if ($user->default_address_id !== 0) {
                                $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                            } else {
                                $default_address = null;
                            }

                            if ($user->default_credit_card_id !== 0) {
                                $default_credit_card = \App\UserCreditCard::where('id', $user->default_credit_card_id)->get(['id', 'token', 'is_active',  'user_id', 'Brand', 'Holder',  'CardNumber', 'ExpirationDate', 'cpf'])->first();
                            } else {
                                $default_credit_card = null;
                            }

                            $running_order = null;

                            if($user->usercode_referral ){
                                $show_popup_referral=false;
                            }else{
                                $show_popup_referral=false;  
                            }

                            $response = [
                                'success' => true,
                                'data' => [
                                    'id' => $user->id,
                                    'auth_token' => $token,
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'avatar'=> $user->avatar,
                                    'phone' => $user->phone,
                                    'show_popup_referral'=>$show_popup_referral,
                                    'provider' => $user->provider,
                                    'default_address_id' => $user->default_address_id,
                                    'default_address' => $default_address,
                                    'default_credit_card' => $default_credit_card,
                        'default_credit_card_id' => $user->default_credit_card_id,
                                    'delivery_pin' => $user->delivery_pin,
                                    'user_type'=> $user->user_type,
                                    'restaurant'=> $user->restaurant_id,
                                    'wallet_balance' => $user->balanceFloat,
                                ],
                                'running_order' => $running_order,
                            ];

                            return response()->json($response);
                       // }

                    } else {
                        $response = [
                            'enter_phone_after_social_login' => true,
                        ];
                        return response()->json($response);
                    }


                } else {

                    // there is no user with this email..

                    if ($request->phone != null) {
                        $checkPhone = User::where('phone', $request->phone)->first();
                       /*  if ($checkPhone) {
                            $response = [
                                'email_phone_already_used' => true,
                            ];
                            return response()->json($response);
                        } else { */
                            //reg user


                       

                       // do{
                            $usercode_test= strtoupper(str_random(6));
                       // }while(!empty(User::where('usercode', $usercode_test)->first()));


                         
                         





                            $user = new User();
                            $user->name = $request->name;
                            $user->email = $request->email;
                            $user->usercode = $usercode_test;
                            $user->avatar = $request->avatar;
                            $user->provider=$request->provider;
                            if($request->provider != null){
                                $user->provider=$request->provider;
                            }
                           if(isset($request->usercode_referral)){
                            $user->usercode_referral=$request->usercode_referral;
                           }

                        
                            
                                $data=[
                                    'name'=>$request->name,
                                    'email'=>$request->email,
                                    'api_token'=>'6c91313e841d21b253cadffde8585bce'
                                ];
                                $test = new Iugu;
                                $response=$test->criarCliente($data); 
                                $res=json_decode($response);
                                if(isset($res->id)){
                                    $user->customer_id = $res->id;
                                }
                            

                            $user->phone = $request->phone;
                            $user->password = \Hash::make(str_random(8));
                            $user->delivery_pin = strtoupper(str_random(5));

                            try {
                                $user->save();
                                $user->assignRole('Customer');
                                $token = JWTAuth::fromUser($user);
                                $user->auth_token = $token;

                                // Add address if address present
                                if ($request->address['lat'] != null) {
                                    $address = new Address();
                                    $address->user_id = $user->id;
                                    $address->latitude = $request->address['lat'];
                                    $address->longitude = $request->address['lng'];
                                    $address->address = $request->address['address'];
                                    $address->house = $request->address['house'];
                                    $address->city = $request->address['city'];
                                    $address->landmark = $request->address['landmark'];
                                    $address->complement = $request->address['complement'];
                                    $address->tag = $request->address['tag'];
                                    $address->save();
                                    $user->default_address_id = $address->id;
                                }

                                $user->save();
                            } catch (\Throwable $e) {
                                $response = ['success' => false, 'data' => 'Something went wrong. Please try again...'];
                                return response()->json($response, 201);
                            }

                            if ($user->default_address_id !== 0) {
                                $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                            } else {
                                $default_address = null;
                            }
                            if ($user->default_credit_card_id !== 0) {
                                $default_credit_card = \App\UserCreditCard::where('id', $user->default_credit_card_id)->get(['id', 'token', 'is_active',  'user_id', 'Brand', 'Holder',  'CardNumber', 'ExpirationDate', 'cpf'])->first();
                            } else {
                                $default_credit_card = null;
                            }

                            $running_order = null;


                            if($user->usercode_referral ){
                                $show_popup_referral=false;
                            }else{
                                $show_popup_referral=false;  
                            }

                            $response = [
                                'success' => true,
                                'data' => [
                                    'id' => $user->id,
                                    'auth_token' => $token,
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'show_popup_referral'=>$show_popup_referral,
                                    'avatar' => $user->avatar,
                                    'phone' => $user->phone,
                                    'provider' => $user->provider,
                                    'default_address_id' => $user->default_address_id,
                                    'default_address' => $default_address,
                                    'default_credit_card' => $default_credit_card,
                        'default_credit_card_id' => $user->default_credit_card_id,
                                    'delivery_pin' => $user->delivery_pin,
                                    'user_type'=> $user->user_type,
                                    'restaurant'=> $user->restaurant_id,
                                    'wallet_balance' => $user->balanceFloat,
                                ],
                                'running_order' => $running_order,
                            ];
                            return response()->json($response);
                        //}

                    } else {
                        // SHOW ENTER PHONE NUMBER
                        $response = [
                            'enter_phone_after_social_login' => true,
                        ];
                        return response()->json($response);
                    }
                    return response()->json($response);
                }
            } else {
                $response = false;
                return response()->json($response);
            }
        }

        // if user exists, check user

        if ($request->password != null) {
            if ($user && \Hash::check($request->password, $user->password)) // The passwords match...
            {
                $token = self::getToken($request->email, $request->password);
                $user->auth_token = $token;

                // Add address if address present
                if ($request->address['lat'] != null) {
                    $address = new Address();
                    $address->user_id = $user->id;
                    $address->latitude = $request->address['lat'];
                    $address->longitude = $request->address['lng'];
                    $address->address = $request->address['address'];
                    $address->house = $request->address['house'];
                    $address->city = $request->address['city'];
                    $address->landmark = $request->address['landmark'];
                    $address->complement = $request->address['complement'];
                    $address->tag = $request->address['tag'];
                    $address->save();
                    $user->default_address_id = $address->id;
                }

                $user->save();
                if ($user->default_address_id !== 0) {
                    $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement',  'latitude', 'longitude', 'tag'])->first();
                } else {
                    $default_address = null;
                }

                if ($user->default_credit_card_id !== 0) {
                    $default_credit_card = \App\UserCreditCard::where('id', $user->default_credit_card_id)->get(['id', 'token', 'is_active',  'user_id', 'Brand', 'Holder',  'CardNumber', 'ExpirationDate', 'cpf'])->first();
                } else {
                    $default_credit_card = null;
                }

                $running_order = null;

                if($user->usercode_referral ){
                    $show_popup_referral=false;
                }else{
                    $show_popup_referral=false;  
                }

                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                        'phone' => $user->phone,
                        'show_popup_referral'=>$show_popup_referral,
                        'provider' => $user->provider,
                        'default_address_id' => $user->default_address_id,
                        'default_address' => $default_address,
                        'default_credit_card' => $default_credit_card,
                        'default_credit_card_id' => $user->default_credit_card_id,
                        'delivery_pin' => $user->delivery_pin,
                        'user_type'=> $user->user_type,
                        'restaurant'=> $user->restaurant_id,
                        'wallet_balance' => $user->balanceFloat,
                    ],
                    'running_order' => $running_order,
                ];
                return response()->json($response, 201);
            } else {
                $response = ['success' => false, 'data' => 'DONOTMATCH'];
                return response()->json($response, 201);
            }
        }

    }

/**
 * @param Request $request
 */
    public function register(Request $request)
    {

        $checkEmail = User::where('email', $request->email)->first();
        $checkPhone = User::where('phone', $request->phone)->first();

        if ($checkPhone || $checkEmail) {
            $response = [
                'email_phone_already_used' => true,
            ];
            return response()->json($response);
        }

         //Criar Cliente na Subconta
         $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'api_token'=>'6c91313e841d21b253cadffde8585bce'
        ];
        $test = new Iugu;
        $response=$test->criarCliente($data); 
        $res=json_decode($response);
        $usercode_test= strtoupper(str_random(6));
       
        $payload = [
            'password' => \Hash::make($request->password),
            'email' => $request->email,
            'name' => $request->name,
            'avatar' => $request->avatar,
            'phone' => $request->phone,
            'delivery_pin' => strtoupper(str_random(5)),
            'auth_token' => '',
        ];

        //do{
            $usercode_test= strtoupper(str_random(6));
       // }while(!empty(User::where('usercode', $usercode_test)->first()));

        $payload['usercode']=$usercode_test;

        if(isset($res->id)){
            $payload['customer_id']=$res->id;
        }

        if(isset($request->usercode_referral)){
            $payload['usercode_referral']=$request->usercode_referral;
        }



        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'phone' => ['required'],
            ]);

            $user = new \App\User($payload);
            if ($user->save()) {

                $token = self::getToken($request->email, $request->password); // generate user token

                if (!is_string($token)) {
                    return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
                }

                $user = \App\User::where('email', $request->email)->get()->first();

                $user->auth_token = $token; // update user token

                // Add address if address present
                if ($request->address['lat'] != null) {
                    $address = new Address();
                    $address->user_id = $user->id;
                    $address->latitude = $request->address['lat'];
                    $address->longitude = $request->address['lng'];
                    $address->address = $request->address['address'];
                    $address->house = $request->address['house'];
                    $address->city = $request->address['city'];
                    $address->landmark = $request->address['landmark'];
                    $address->complement = $request->address['complement'];
                    $address->tag = $request->address['tag'];
                    $address->save();
                    $user->default_address_id = $address->id;
                }

                $user->save();
                $user->assignRole('Customer');

                if ($user->default_address_id !== 0) {
                    $default_address = \App\Address::where('id', $user->default_address_id)->get(['id', 'address', 'house',  'city', 'landmark', 'complement', 'latitude', 'longitude', 'tag'])->first();
                } else {
                    $default_address = null;
                }

                if($user->usercode_referral){
                    $show_popup_referral=false;
                }else{
                    $show_popup_referral=false;
                }

                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar'=> $user->avatar,
                        'phone' => $user->phone,
                        'show_popup_referral'=>$show_popup_referral,
                        'provider' => $user->provider,
                        'default_address_id' => $user->default_address_id,
                        'default_address' => $default_address,
                        'delivery_pin' => $user->delivery_pin,
                        'wallet_balance' => $user->balanceFloat,
                    ],
                    'user' => $user,
                    'running_order' => null,
                ];
            } else {
                $response = ['success' => false, 'data' => 'Couldnt register user'];
            }
        } catch (\Throwable $e) {
            $response = ['success' => false, 'data' => 'Couldnt register user.'];
            return response()->json($response, 201);
        }

        return response()->json($response, 201);
    }

/**
 * @param Request $request
 */
    public function updateUserInfo(Request $request)
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
     * @param Request $request
     */
    public function checkRunningOrder(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $running_order = \App\Order::where('user_id', $user->id)
                ->whereIn('orderstatus_id', ['1', '2', '3', '4', '7'])
                ->get();

            if (count($running_order) > 0) {
                $success = true;
                return response()->json($success);
            } else {
                $success = false;
                return response()->json($success);
            }
        }

    }

/**
 * @param $provider
 * @param $accessToken
 */
    public function validateAccessToken($email, $provider, $accessToken)
    {
        if ($provider == 'facebook') {
            // validate facebook access token
            $curl = Curl::to('https://graph.facebook.com/app/?access_token=' . $accessToken)->get();
            $curl = json_decode($curl);

            if (isset($curl->id)) {
                if ($curl->id == config('settings.facebookAppId')) {
                    return true;
                }
                return false;
            }
            return false;

        }
        if ($provider == 'apple') {
            
            return true;

        }
        if ($provider == 'google') {
            // validate google access token
            $curl = Curl::to('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $accessToken)->get();
            $curl = json_decode($curl);

            if (isset($curl->email)) {
                if ($curl->email == $email) {
                    return true;
                }
                return false;
            }
            return false;
        }
    }

    /**
     * @param Request $request
     */
    public function getWalletTransactions(Request $request)
    {
        $user = auth()->user();
        // $user = auth()->user();
        if ($user) {
            // $balance = sprintf('%.2f', $user->balanceFloat);
            $balance = $user->balanceFloat;
            $transactions = $user->transactions()->orderBy('id', 'DESC')->get();

            $response = [
                'success' => true,
                'balance' => $balance,
                'transactions' => $transactions,
            ];
            return response()->json($response);
        } else {
            $response = [
                'success' => false,
            ];
            return response()->json($response);
        }
    }

    /**
     * @param Request $request
     */
    public function changeAvatar(Request $request)
    {
        $user = auth()->user();
        $user->avatar = $request->avatar;
        $user->save();
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     */
    public function checkBan(Request $request)
    {
        $user = auth()->user();
        if ($user->is_active) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

     /**
     * @param Request $request
     * @return mixed
     */
    public function saveRestaurantAsFavorite(Request $request)
    {
        $user = auth()->user();
       $add = new Restaurant();
       $add->addFavorites($request->user_id, $request->restaurant_id);

      $favorite_list= new User();
      $favorite_lists=$favorite_list->favorite_list($request->user_id);

        return response()->json(['success' => true, 'favorite_list'=>$favorite_lists]);
       

    }

    public function isRestaurantFavorite(Request $request)
    {
        $user = auth()->user();
       $add = new Restaurant();
       $is_favorite=$add->isFavorites($request->user_id, $request->restaurant_id);
        if($is_favorite==0){
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
        }
    }

    public function toggleRestaurantAsFavorite(Request $request)
    {
        $user = auth()->user();
       $add = new Restaurant();
       $add->toggleFavorites($request->user_id, $request->restaurant_id);

      $favorite_list= new User();
      $favorite_lists=$favorite_list->favorite_list($request->user_id);

        return response()->json(['success' => true, 'favorite_list'=>$favorite_lists]);
       

    }

         /**
     * @param Request $request
     * @return mixed
     */
    public function removeRestaurantAsFavorite(Request $request)
    {
        $add = new Restaurant();
        $add->removeFavorites($request->user_id, $request->restaurant_id);

        $favorite_list= new User();
        $favorite_lists=$favorite_list->favorite_list($request->user_id);
 
         return response()->json(['success' => true, 'favorite_list'=>$favorite_lists]);
          
        

    }

      /**
     * @param Request $request
     * @return mixed
     */
    public function ListFavoriteRestaurants(Request $request)
    {
        $favorite_list= new User();
        $favorite_lists=$favorite_list->favorite_list($request->user_id);
        $list=array();
        foreach($favorite_lists as $restaurant){
            $restaurant_id=$restaurant->id;
            $store=Restaurant::where('id', $restaurant_id )->first();
            $categories=$store->restaurant_categories()->get();//RestaurantCategory::all();
            $store->categories=$categories;
            $restaurant_distance = $this->getRestaurantDistance($request->latitude, $request->longitude, $store);
            $store['distance']=$restaurant_distance;

            $delivery_tax='';
            $restaurant=$store;
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
            $store['delivery_tax']=$delivery_tax;


            $list[]=$store;


        }
 
         return response()->json($list);

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
