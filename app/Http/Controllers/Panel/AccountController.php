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
use App\Coupon;
use App\FlyerRestaurant;
use App\Order;
use App\PaymentGateway;
use App\PushNotify;
use App\Restaurant;
use App\RestaurantTester;
use App\Sorteio;
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



class AccountController extends Controller

{

   
   /**
     * @param $id
     */
    public function getEditAccount()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        $adminPaymentGateways = PaymentGateway::where('is_active', '1')->get();
        $array_categories=array();
        foreach($restaurant->restaurant_categories as $resCat){
            $array_categories[]=$resCat->id;
        }
        $payoutData = StorePayoutDetail::where('restaurant_id', $id)->first();
        if ($payoutData) {
            $payoutData = json_decode($payoutData->data);
        } else {
            $payoutData = null;
        }

        $restaurant_userTester = RestaurantTester::where('restaurant_id', $id)->first();
        if ($restaurant_userTester) {
            $restaurant_userTester=$restaurant_userTester; 
        }else{
            $restaurant_userTester=null;
            }

        $uploadDir = 'https://app.comprabakana.com.br';
        $logo=$restaurant->image;
        $enabled = true;
        if($logo!=null){
            $default_avatar = $uploadDir.''.''.$logo;
        }else{
            $default_avatar = 'https://app.comprabakana.com.br/assets/img/restaurants/default-logo.png';
        }


        $radius=$restaurant->delivery_radius;


        if ($radius <=20){
            $list=[
                ['id'=>1, 'km'=>1, 'price'=> '0.00','price_free_shipping'=> '30.00', 'time'=>35,'type'=>'min'],
                ['id'=>2, 'km'=>2, 'price'=> '0.00','price_free_shipping'=> '30.00', 'time'=>40,'type'=>'min'],
                ['id'=>3, 'km'=>3,'price'=> '3.00','price_free_shipping'=> '40.00', 'time'=>50,'type'=>'min'],
                ['id'=>4, 'km'=>4, 'price'=> '4.00','price_free_shipping'=> '40.00', 'time'=>60,'type'=>'min'],
                ['id'=>5, 'km'=>5, 'price'=> '5.00','price_free_shipping'=> '50.00', 'time'=>70,'type'=>'min'],
                ['id'=>6, 'km'=>6, 'price'=> '5.00','price_free_shipping'=> '50.00', 'time'=>75,'type'=>'min'],
                ['id'=>7, 'km'=>7, 'price'=> '6.00','price_free_shipping'=> '50.00', 'time'=>80,'type'=>'min'],
                ['id'=>8, 'km'=>8,'price'=> '6.00','price_free_shipping'=> '60.00', 'time'=>85,'type'=>'min'],
                ['id'=>9, 'km'=>9, 'price'=> '6.00','price_free_shipping'=> '60.00', 'time'=>90,'type'=>'min'],
                ['id'=>10, 'km'=>10, 'price'=> '7.00','price_free_shipping'=> '70.00', 'time'=>95,'type'=>'min'],
                ['id'=>11, 'km'=>11, 'price'=> '7.00','price_free_shipping'=> '70.00', 'time'=>100,'type'=>'min'],
                ['id'=>12, 'km'=>12, 'price'=> '8.00','price_free_shipping'=> '70.00', 'time'=>110,'type'=>'min'],
                ['id'=>13, 'km'=>13,'price'=> '8.00','price_free_shipping'=> '80.00', 'time'=>120,'type'=>'min'],
                ['id'=>14, 'km'=>14, 'price'=> '9.00','price_free_shipping'=> '80.00', 'time'=>130,'type'=>'min'],
                ['id'=>15, 'km'=>15, 'price'=> '9.00','price_free_shipping'=> '80.00', 'time'=>140,'type'=>'min'],
                ['id'=>16, 'km'=>16, 'price'=> '9.00','price_free_shipping'=> '90.00', 'time'=>150,'type'=>'min'],
                ['id'=>17, 'km'=>17, 'price'=> '10.00','price_free_shipping'=> '90.00', 'time'=>160,'type'=>'min'],
                ['id'=>18, 'km'=>18,'price'=> '10.00','price_free_shipping'=> '100.00', 'time'=>170,'type'=>'min'],
                ['id'=>19, 'km'=>19, 'price'=> '10.00','price_free_shipping'=> '100.00', 'time'=>180,'type'=>'min'],
                ['id'=>20, 'km'=>20, 'price'=> '10.00','price_free_shipping'=> '100.00', 'time'=>190,'type'=>'min'],
                

            ];

           $radius_vector=array_fill(0, $radius, null);
           //dd($radius_vector);
       
           if($restaurant->delivery_time_vector != null){
            $delivery_time_vector=json_decode($restaurant->delivery_time_vector,true);
            $delivery_time_vector_count=0;
            foreach($delivery_time_vector as $vector){
                $delivery_time_vector_count=$delivery_time_vector_count+1;
            }
            //$delivery_time_vector_count= count($delivery_time_vector);
           }else{
            $delivery_time_vector_count=0; 
           }
            //dd($delivery_time_vector_count);
    
            if($delivery_time_vector_count == $radius){
                $list_distance= $delivery_time_vector;
            }
            if($delivery_time_vector_count < $radius && $delivery_time_vector_count >= 1){
                $list_distance= array_merge($delivery_time_vector,array_slice($list, $delivery_time_vector_count,($radius-$delivery_time_vector_count)));   
            } 
            if($delivery_time_vector_count == 0  ){
                $list_distance= array_slice($list, $delivery_time_vector_count,($radius-$delivery_time_vector_count));   
            } 
            if($delivery_time_vector_count > $radius  ){
                $list_distance= array_slice($delivery_time_vector, ($delivery_time_vector_count - $radius));   
            } 
            //dd(array_merge($delivery_time_vector,array_slice($list, $delivery_time_vector_count,($radius-$delivery_time_vector_count))));
           // dd($delivery_time_vector_count);
            //$list_distance='';
           // $delivery_time_vector='';

        }
        if($radius>20 && $radius<=30){

        }
        if($radius>30 && $radius<=50){

        }

      

        if ($restaurant) {

            return view('panel.account', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'user'=>$user,
           
               
                'default_avatar'=>$default_avatar,
                'enabled'=>$enabled,
                'arraycategories'=>$array_categories,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                'adminPaymentGateways' => $adminPaymentGateways,
                'payoutData' => $payoutData,
                'list_distance'=> $list_distance,
                'radius_vector'=>$radius_vector,
            
                'restaurant_userTester' => $restaurant_userTester,
              
               
            ));
        } else {
            return redirect()->route('restaurantowner.restaurants')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }



 /**
     * @param Request $request
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            if(isset($request->name)){
                $user->name = $request->name;
            }
            if(isset($request->phone)){
                $user->phone = $request->phone;
            }
            

               
            
                    try {

                        $user->save();

                      

                    if (isset($request->api)) {
                        $response=[
                            'success'=>true,
                        ];
                        return response()->json($response, 201);
                    } else { 

                        
                            return redirect()->back()->with(['success' => 'Perfil Salvo com Sucesso']);
                        
                    }
                    } catch (\Illuminate\Database\QueryException $qe) {
                        return redirect()->back()->with(['message' => $qe->getMessage()]);
                    } catch (Exception $e) {
                        return redirect()->back()->with(['message' => $e->getMessage()]);
                    } catch (\Throwable $th) {
                        return redirect()->back()->with(['message' => $th]);
                    }
        }
    }


    

    





    
};
