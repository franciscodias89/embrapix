<?php

namespace App\Http\Controllers;

use App\User;
use App\IuguSubaccount;
use App\Iugu;
use App\Restaurant;

use Auth;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;

use JWTAuthException;
class RegisterController extends Controller
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



    /**
     * @param Request $request
     */
    public function registerRestaurantDelivery(Request $request)
    {
        // dd($request->all());
   /*      $rules = [
            //'captcha' => ['required', 'captcha'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:8', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
             return redirect()->back()->withErrors($validator);
           // return redirect()->back()->with(['message' => 'Something went wrong. Please try again.']);
        } else { */

            try {
                $user_test = \App\User::where('email', $request->email)->get()->first();

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'delivery_pin' => strtoupper(str_random(5)),
                    'password' => \Hash::make($request->password),
                ]);

                $token = self::getToken($request->email, $request->password); // generate user token

                if (!is_string($token)) {
                    return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
                }

                
                $user->auth_token = $token; // update user token
                $user->save();
                    $restaurant = new Restaurant();
                    $restaurant->name =$request->estabelecimento;
                     $restaurant->rating = 5;
                    $restaurant->slug=strtoupper(str_random(20));
                    $restaurant->sku=strtoupper(str_random(20));
                    $restaurant->is_active=0;
                    $restaurant->contact_manager=$user->name;
                    $restaurant->contact_manager_whatsapp=$user->phone;
                    $restaurant->user_id=$user->id;
                    $restaurant->is_accepted=0;
                    $restaurant->status=0;
                    $restaurant->is_featured=1;
                    $restaurant->delivery_type=3;
                    $restaurant->delivery_radius=10;
                    $restaurant->is_notifiable=1;
                    $restaurant->ask_publish=0;
                    $restaurant->cashback_percent=1;
                    $restaurant->cashback_active=0;
                    $restaurant->min_order_price=5.00;
                    $restaurant->image_top='/assets/img/restaurants/bannertopo.jpeg';
                    //$restaurant->auto_acceptable=0;
                    //$restaurant->is_schedulable=0;
                    $restaurant->price_free_shipping_active=0;
                    $restaurant->accept_outofstock=0;
                    $restaurant->addtime_outofstock=0;
                    $restaurant->restaurant_charges='0.00';
                    //$restaurant->cancel_order_status=1;
                    $restaurant->payment_app_accept = 1;
                    $restaurant->payment_selfpickup_accept = 1;
                    $restaurant->payment_delivery_accept = 1;
                    $selfpickup_payment_type=array();
                    $selfpickup_payment_type['selfpickup_payment_type_money'] = 1;
                    $selfpickup_payment_type['selfpickup_payment_type_credit_card'] = 1;
                    $selfpickup_payment_type['selfpickup_payment_type_debit_card'] = 1;
                    $selfpickup_payment_type['selfpickup_payment_type_pix'] = 1;
                    $restaurant->selfpickup_payment_type=json_encode($selfpickup_payment_type);
        
                    $delivery_payment_type=array();
                    $delivery_payment_type['delivery_payment_type_money'] = 1;
                    $delivery_payment_type['delivery_payment_type_credit_card'] = 1;
                    $delivery_payment_type['delivery_payment_type_debit_card'] = 1;
                    $delivery_payment_type['delivery_payment_type_pix'] = 1;
                            
                    $restaurant->delivery_payment_type=json_encode($delivery_payment_type); 
                    $restaurant->save();

               
                $user->restaurant_id = $restaurant->id; 
                $user->user_type='Store Owner';
                $user->restaurants()->sync($user->restaurant_id);
                $user->save();

                $iugu = new IuguSubaccount();
               
                $iugu->user_id=$user->id;
                $iugu->restaurant_id=$restaurant->id;
                
                $iugu->save();
                
            
                
                
/* 
                if ($request->has('role')) { */
                    /* if ($request->role == 'DELIVERY') {
                        $user->assignRole('Delivery Guy');
                        //return session message...
                        return redirect()->back()->with(['delivery_register_message' => 'Delivery User Registered', 'success' => 'Delivery User Registered']);
                    } */
                   // if ($request->role == 'RESOWN') {
                        $user->assignRole('Store Owner');
                        // login and redirect to dashbaord...
                        Auth::loginUsingId($user->id);
                   // }
                /* } else {
                    $user->assignRole('Customer');
                    return redirect()->back()->with(['success' => 'User Created']);
                } */
            
                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $token,
                        'restaurant' => $restaurant,
                        'email' => $user->email,
                    ],
                    'user' => $user,
                ];

                 if (isset($request->api)) {
                    return response()->json($response, 201);
                } else { 
                    return redirect('/auth/login')->with(['success' => 'Sua Conta foi Criada com Sucesso! Entre agora com seu E-mail e Senha cadastrados!']);
                } 

                

            } catch (\Illuminate\Database\QueryException $qe) {
                return redirect()->back()->with(['message' => 'Deu algo errado com o seu cadastro. Tente novamente com outro email.']);
            } catch (Exception $e) {
                return redirect()->back()->with(['message' => 'Deu algo errado com o seu cadastro. Tente novamente com outro email.']);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['message' => 'Deu algo errado com o seu cadastro. Tente novamente com outro email.']);
            }
        //}
    }
}
