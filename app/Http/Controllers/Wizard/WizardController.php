<?php

namespace App\Http\Controllers\Wizard;



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
use App\Sorteio;
use App\RestaurantCategory;
use App\RestaurantTester;
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

require_once(base_path('assets/fileuploader/src/php/class.fileuploader.php'));

class WizardController extends Controller

{

      /**
     * @param $id
     */
    public function getEditWizardHome()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        
        $restaurant = Restaurant::where('id', $id)->first();
        
        if ($restaurant) {

            return view('wizard.wizard_home', array(
                
                'restaurant' => $restaurant,
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

   /**
     * @param $id
     */
    public function getEditWizard1()
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

        $uploadDir = 'https://app.comprabakana.com.br';
        $logo=$restaurant->image;
        $enabled = true;
        if($logo!=null){
            $default_avatar = $uploadDir.''.''.$logo;
        }else{
            $default_avatar = 'https://app.comprabakana.com.br/assets/img/restaurants/default-logo.png';
        }

        if ($restaurant) {

            return view('wizard.wizard_1', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'default_avatar'=>$default_avatar,
                'enabled'=>$enabled,
                'arraycategories'=>$array_categories,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                'adminPaymentGateways' => $adminPaymentGateways,
                'payoutData' => $payoutData,
            ));
        } else {
            return redirect()->route('restaurantowner.restaurants')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }


    /**
     * @param $id
     */
    public function getEditWizard2()
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

        $uploadDir = 'https://app.comprabakana.com.br';
        $logo=$restaurant->image;
        $enabled = true;
        if($logo!=null){
            $default_avatar = $uploadDir.''.''.$logo;
        }else{
            $default_avatar = 'https://app.comprabakana.com.br/assets/img/restaurants/default-logo.png';
        }

        if ($restaurant) {

            return view('wizard.wizard_2', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'default_avatar'=>$default_avatar,
                'enabled'=>$enabled,
                'arraycategories'=>$array_categories,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                'adminPaymentGateways' => $adminPaymentGateways,
                'payoutData' => $payoutData,
            ));
        } else {
            return redirect()->route('restaurantowner.restaurants')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

    /**
     * @param $id
     */
    public function getEditWizard3()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
        

        if ($restaurant) {

            return view('wizard.wizard_3', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }


    /**
     * @param $id
     */
    public function getEditWizard4()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_4', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

     /**
     * @param $id
     */
    public function getEditWizard4_1()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
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
            $delivery_time_vector_count= count($delivery_time_vector);
           }else{
            $delivery_time_vector_count=0; 
           }
           // dd($delivery_time_vector);
    
            if($delivery_time_vector_count == $radius){
                $list_distance= $delivery_time_vector;
            }
            if($delivery_time_vector_count < $radius && $delivery_time_vector_count >= 1){
                $list_distance= array_merge($delivery_time_vector,array_slice($list, $delivery_time_vector_count,($radius-$delivery_time_vector_count)));   
            } 
            if($delivery_time_vector_count == 0  ){
                $list_distance= array_slice($list, $delivery_time_vector_count,($radius-$delivery_time_vector_count));   
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

            return view('wizard.wizard_4_1', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'list_distance'=> $list_distance,
               
                'radius_vector'=>$radius_vector,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

     /**
     * @param $id
     */
    public function getEditWizard4_2()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_4_2', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

      /**
     * @param $id
     */
    public function getEditWizard4_3()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
        $delivery_payment_type=json_decode($restaurant->delivery_payment_type,true);
        
        $selfpickup_payment_type=json_decode($restaurant->selfpickup_payment_type,true);


        if ($restaurant) {

            return view('wizard.wizard_4_3', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'selfpickup_payment_type'=>$selfpickup_payment_type,
                'delivery_payment_type'=>$delivery_payment_type,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

         /**
     * @param $id
     */
    public function getEditWizard5()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_5', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

           /**
     * @param $id
     */
    public function getEditWizard5_1()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_5_1', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }


    
           /**
     * @param $id
     */
    public function getEditWizard6()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_6', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

             /**
     * @param $id
     */
    public function getEditWizard7()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_7', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

             /**
     * @param $id
     */
    public function getEditWizard8()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_8', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }


              /**
     * @param $id
     */
    public function getEditWizardEnd()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
       

        if ($restaurant) {

            return view('wizard.wizard_end', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }

         /**
     * @param $id
     */
    public function getEditWizardPanel()
    {
        $user = Auth::user();
        $id=$user->restaurant_id;
        //$restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurant_id=$user->restaurant_id;
        $subaccount = IuguSubaccount::where('restaurant_id', $restaurant_id)->first();
        
        $categories_check= ItemCategory::where('user_id',$user->id)->get();
        if($categories_check){
            $categories_check=count($categories_check);
        }else{
            $categories_check=0;
        }

        $addons_check= AddonCategory::where('user_id',$user->id)->get();
        if($addons_check){
            $addons_check=count($addons_check);
        }else{
            $addons_check=0;
        }

        $items_check= Item::where('restaurant_id',$restaurant->id)->get();
        if($items_check){
            $items_check=count($items_check);
        }else{
            $items_check=0;
        }


        $printer_data= json_decode($restaurant->printer_data,true);

        $printer_name=$printer_data['printer_name'];
       
       
       
        
        
        $flyers_check = Flyer::with('restaurants')
        ->whereHas('restaurants', function ($query) use ($restaurant_id) {
                $query->where('restaurants.id', $restaurant_id );
                })
        ->get();
        if($flyers_check){
            $flyers_check=count($flyers_check);
        }else{
            $flyers_check=0;
        }

        $coupons_check= Coupon::whereHas('restaurants', function ($query) use ($restaurant_id) {
            $query->where('restaurants.id', $restaurant_id );
            })->get();
        if($coupons_check){
            $coupons_check=count($coupons_check);
        }else{
            $coupons_check=0;
        }

        $sorteios_check= Sorteio::whereHas('restaurants', function ($query) use ($restaurant_id) {
            $query->where('restaurants.id', $restaurant_id );
            })->get();
        if($sorteios_check){
            $sorteios_check=count($sorteios_check);
        }else{
            $sorteios_check=0;
        }
        $user_tester=RestaurantTester::where('restaurant_id',$restaurant_id)->first();

        
        if ($restaurant) {

            return view('wizard.panel.wizard_panel', array(
                'restaurantCategories' => $restaurantCategories,
                'restaurant' => $restaurant,
                'subaccount' => $subaccount,
                'categories_check'=>$categories_check,
                'addons_check'=>$addons_check,
                'items_check'=>$items_check,
                'printer_name'=>$printer_name,
                'user_tester'=>$user_tester,
                'flyers_check'=>$flyers_check,
                'coupons_check'=>$coupons_check,
                'sorteios_check'=>$sorteios_check,
                'schedule_data' => json_decode($restaurant->schedule_data),
                'working_time' => json_decode($restaurant->working_time),
                
            ));
        } else {
            return redirect()->route('logout')->with(array('message' => 'Houve alguma falha com seu cadastro! Entre em contato com o Suporte!'));
        }
    }


   

    /**
     * @param Request $request
     */
    public function updateWizard1(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            if(isset($request->name)){
                $restaurant->name = $request->name;
            }
            if(isset($request->contact_manager)){
                $restaurant->contact_manager = $request->contact_manager;
            }
            if(isset($request->contact_manager_whatsapp)){
                $restaurant->contact_manager_whatsapp = $request->contact_manager_whatsapp;
            }
            if(isset($request->description)){
            $restaurant->description = $request->description;
            }
            if(isset($request->image)){
                if ($request->image == null) {
                    $restaurant->image = $request->old_image;
                } else {
                    $image = $request->file('image');
                    $rand_name = time() . str_random(10);
                    $filename = $rand_name . '.jpg';
                    Image::make($image)
                        ->resize(160, 117)
                        ->save(base_path('assets/img/restaurants/' . $filename), config('settings.uploadImageQuality '), 'jpg');
                    $restaurant->image = '/assets/img/restaurants/' . $filename;
                }
            }

            
                $restaurant->telefone = $request->telefone;
                $restaurant->whatsapp = $request->whatsapp;
                $restaurant->email = $request->email;
                $restaurant->facebook = $request->facebook;
                
                $restaurant->website = $request->website;
                $restaurant->instagram = $request->instagram;
                if($restaurant->status==0){
                    $restaurant->status = 1;
                }
                $restaurant->min_order_price = $request->min_order_price;
            
               
            
                    try {

                        $restaurant->save();

                        if (isset($request->restaurant_category_restaurant)) {
                            $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
                    }

                    if (isset($request->api)) {
                        $response=[
                            'success'=>true,
                        ];
                        return response()->json($response, 201);
                    } else { 
                        return redirect()->route('wizard.wizard_2');
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


    /**
     * @param Request $request
     */
    public function updateWizard2(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
         

         
            if(isset($request->google_address)){
            $restaurant->google_address = $request->google_address;
            }
           
                $address1 = $request->address_street.', '.$request->address_number;
                $address2 = $request->address_district.', '.$request->address_city.'-'.$request->address_state;
                if(isset($request->address_complement)){
                    $restaurant->address=$address1.', '.$request->address_complement.', '.$address2;
                }else{
                    $restaurant->address=$address1.', '.$address2;
                }
            
        
                $restaurant->address_street = $request->address_street;
                $restaurant->address_number = $request->address_number;
                $restaurant->address_complement = $request->address_complement;
                $restaurant->address_district = $request->address_district;
                $restaurant->address_state = $request->address_state;
                $restaurant->address_city = $request->address_city;
                $restaurant->pincode = $request->pincode;
                
                $restaurant->latitude = $request->latitude;
                $restaurant->longitude = $request->longitude;
                if($restaurant->status==1){
                    $restaurant->status = 2;
                }
                
           

           
                    try {


                        $restaurant->save();

                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                        return redirect()->route('wizard.wizard_3');
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

    
/**
     * @param Request $request
     */
    public function updateWizard3(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
                $restaurant->person_type = $request->person_type;
                if($restaurant->status== 2){
                    $restaurant->status = 3;
                }
                
                $restaurant->save();            

                $subaccount = IuguSubaccount::where('restaurant_id', $request->id)->first();
            
            
                $subaccount->name = $restaurant->name;
                $subaccount->cpf = $request->cpf;
                $subaccount->company_name = $request->company_name;
                $subaccount->cnpj = $request->cnpj;

                if(($request->person_type) == "Mei" ||($request->person_type) == "Empresa" ){
                    $subaccount->person_type = "Pessoa Jurídica";
                }else{
                    $subaccount->person_type = "Pessoa Física";
                }
                
                $subaccount->resp_name = $request->resp_name;
                $subaccount->resp_cpf = $request->resp_cpf;
                $subaccount->bank = $request->bank;
                $subaccount->bank_ag = $request->bank_ag;
                $subaccount->account_type = $request->account_type;
                $subaccount->bank_cc = $request->bank_cc;
                $subaccount->telephone = $restaurant->contact_manager_whatsapp;
               
                $subaccount->business_type = $restaurant->description;
                $subaccount->automatic_transfer = $request->automatic_transfer;

                $address1 = $restaurant->address_street.', '.$restaurant->address_number;
                $address2 = $restaurant->address_district;
                if(isset($restaurant->address_complement)){
                    $subaccount->address=$address1.', '.$restaurant->address_complement.', '.$address2;
                }else{
                    $subaccount->address=$address1.', '.$address2;
                }
                $subaccount->city = $restaurant->address_city;
                $subaccount->state = $restaurant->address_state;
                $subaccount->cep = $restaurant->pincode;

                
                    try {

                        $subaccount->save();
                        
                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                        return redirect()->route('wizard.wizard_4');
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

 /**
     * @param Request $request
     */
    public function updateWizard4(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            
            if(isset($request->delivery_time)){
                $restaurant->delivery_time = $request->delivery_time;
            }
            if(isset($request->selfpickup_time)){
                $restaurant->selfpickup_time = $request->selfpickup_time;
            }
           
            if (isset($request->delivery_type)) {
                $restaurant->delivery_type = $request->delivery_type;
            }

            if (isset($request->restaurant_charges)) {
                $restaurant->restaurant_charges = $request->restaurant_charges;
            }
           /*  if (isset($request->delivery_charge_type)) {
                if ($request->delivery_charge_type == 'FREE') {
                    $restaurant->delivery_charge_type = 'FREE';
                }
                if ($request->delivery_charge_type == 'FIXED') {
                    $restaurant->delivery_charge_type = 'FIXED';
                    $restaurant->delivery_charges = $request->delivery_charges;
                }
                if ($request->delivery_charge_type == 'DYNAMIC') {
                    $restaurant->delivery_charge_type = 'DYNAMIC';
                    $restaurant->base_delivery_charge = str_replace(',', '.', $request->base_delivery_charge);
                    $restaurant->base_delivery_distance = $request->base_delivery_distance;
                    $restaurant->extra_delivery_charge = str_replace(',', '.', $request->extra_delivery_charge);
                    $restaurant->extra_delivery_distance = $request->extra_delivery_distance;
                }
            } */
            if (isset($request->delivery_radius)) {
                $restaurant->delivery_radius = $request->delivery_radius;
            }
                    try {
                        $restaurant->save();
                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3)){
                                return redirect()->route('wizard.wizard_4_1');
                            }else{
                                return redirect()->route('wizard.wizard_4_2');  
                            }
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



    /**
     * @param Request $request
     */
    public function updateWizard4_1(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {

            if(isset($request->time_km)){



                $restaurant->delivery_time_vector = json_encode($request->time_km);
            }

            if ($request->price_free_shipping_active == 'on') {
                $restaurant->price_free_shipping_active = 1;
            } else {
                $restaurant->price_free_shipping_active= 0;
            }
            
                    try {
                        $restaurant->save();
                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3)){
                                return redirect()->route('wizard.wizard_4_2');
                            }else{
                                return redirect()->route('wizard.wizard_4_3');  
                            }
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


 /**
     * @param Request $request
     */
    public function updateWizard4_2(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {

            if(isset($request->selfpickup_time)){
                $restaurant->selfpickup_time = $request->selfpickup_time;
            }
            if(isset($request->selfpickup_time_type)){
                $restaurant->selfpickup_time_type = $request->selfpickup_time_type;
            }
            
                    try {
                        $restaurant->save();

                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            return redirect()->route('wizard.wizard_4_3');  
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


    /**
     * @param Request $request
     */
    public function updateWizard4_3(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {

            if($restaurant->status==3){
                $restaurant->status = 4;
            }
                
            
            

            if ($request->payment_selfpickup_accept == 'on') {
                $restaurant->payment_selfpickup_accept = 1;
            } else {
                $restaurant->payment_selfpickup_accept= 0;
            }
            if ($request->payment_app_accept == 'on') {
                $restaurant->payment_app_accept = 1;
            } else {
                $restaurant->payment_app_accept= 0;
            }
            if ($request->payment_delivery_accept == 'on') {
                $restaurant->payment_delivery_accept = 1;
            } else {
                $restaurant->payment_delivery_accept= 0;
            }
            $selfpickup_payment_type=array();
            if ($request->selfpickup_payment_type_money == 'on') {
                $selfpickup_payment_type['selfpickup_payment_type_money'] = 1;
            } else {
                $selfpickup_payment_type['selfpickup_payment_type_money']= 0;
            }
            if ($request->selfpickup_payment_type_credit_card == 'on') {
                $selfpickup_payment_type['selfpickup_payment_type_credit_card'] = 1;
            } else {
                $selfpickup_payment_type['selfpickup_payment_type_credit_card'] = 0;
            }
            if ($request->selfpickup_payment_type_debit_card == 'on') {
                $selfpickup_payment_type['selfpickup_payment_type_debit_card'] = 1;
            } else {
                $selfpickup_payment_type['selfpickup_payment_type_debit_card'] = 0;
            }
            if ($request->selfpickup_payment_type_pix == 'on') {
                $selfpickup_payment_type['selfpickup_payment_type_pix'] = 1;
            } else {
                $selfpickup_payment_type['selfpickup_payment_type_pix'] = 0;
            }

            $restaurant->selfpickup_payment_type=json_encode($selfpickup_payment_type);

            $delivery_payment_type=array();
            if ($request->delivery_payment_type_money == 'on') {
                $delivery_payment_type['delivery_payment_type_money'] = 1;
            } else {
                $delivery_payment_type['delivery_payment_type_money']= 0;
            }
            if ($request->delivery_payment_type_credit_card == 'on') {
                $delivery_payment_type['delivery_payment_type_credit_card'] = 1;
            } else {
                $delivery_payment_type['delivery_payment_type_credit_card'] = 0;
            }
            if ($request->delivery_payment_type_debit_card == 'on') {
                $delivery_payment_type['delivery_payment_type_debit_card'] = 1;
            } else {
                $delivery_payment_type['delivery_payment_type_debit_card'] = 0;
            }
            if ($request->delivery_payment_type_pix == 'on') {
                $delivery_payment_type['delivery_payment_type_pix'] = 1;
            } else {
                $delivery_payment_type['delivery_payment_type_pix'] = 0;
            }

            $restaurant->delivery_payment_type=json_encode($delivery_payment_type);
            
                    try {
                        $restaurant->save();

                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            return redirect()->route('wizard.wizard_5');  
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


    /**
     * @param Request $request
     */
    public function updateWizard5(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            
            

            //----- Hor�rios que Recebe Pedido - INICIO
            if(isset($request->monday) || isset($request->tuesday) || isset($request->wednesday) || isset($request->thursday) || isset($request->friday) || isset($request->saturday) || isset($request->sunday)){
                $data = $request->only(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
                $i = 0;
                $str='';
                $str = '{';
                foreach ($data as $day => $times) {
                    $str .= '"' . $day . '":[';
                    if ($times) {
                        foreach ($times as $key => $time) {

                            if ($key % 2 == 0) {
                                $t1 = $time;
                                $str .= '{"open" :' . '"' . $time . '"';

                            } else {
                                $t2 = $time;
                                $str .= '"close" :' . '"' . $time . '"}';
                            }

                            //check if last, if last then dont add comma,
                            if (count($times) != $key + 1) {
                                $str .= ',';
                            }
                        }
                        // dd($t1);
                       /*  if (Carbon::parse($t1) >= Carbon::parse($t2)) {

                            return redirect()->back()->with(['message' => 'Um dos horários de abertura e fechamento estão incorretos']);
                        } */
                    } else {
                        $str .= '}]';
                    }

                    if ($i != count($data) - 1) {
                        $str .= '],';
                    } else {
                        $str .= ']';
                    }
                    $i++;
                }
                    $str .= '}';
                    $restaurant->schedule_data = $str;
            }
                
            
        
                    try {

                        

                        $restaurant->save();

                        if (isset($request->restaurant_category_restaurant)) {
                            $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
                    }

                    if (isset($request->api)) {
                        $response=[
                            'success'=>true,
                        ];
                        return response()->json($response, 201);
                    } else {
                            if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3)){
                                return redirect()->route('wizard.wizard_5_1');
                            }else{
                                return redirect()->route('wizard.wizard_6'); 
                            }
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


    
    /**
     * @param Request $request
     */
    public function updateWizard5_1(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            
            

            //----- Hor�rios de Funcionamento- INICIO
            if(isset($request->_monday) || isset($request->_tuesday) || isset($request->_wednesday) || isset($request->_thursday) || isset($request->_friday) || isset($request->_saturday) || isset($request->_sunday)){
           
                $data = $request->only(['_monday', '_tuesday', '_wednesday', '_thursday', '_friday', '_saturday', '_sunday']);
                $i = 0;
                $str='';
                $str = '{';
                foreach ($data as $day => $times) {
                    $str .= '"' . $day . '":[';
                    if ($times) {
                        foreach ($times as $key => $time) {
 
                            if ($key % 2 == 0) {
                                $t1 = $time;
                                $str .= '{"open" :' . '"' . $time . '"';
 
                            } else {
                                $t2 = $time;
                                $str .= '"close" :' . '"' . $time . '"}';
                            }
 
                            //check if last, if last then dont add comma,
                            if (count($times) != $key + 1) {
                                $str .= ',';
                            }
                        }
                        // dd($t1);
                        /* if (Carbon::parse($t1) >= Carbon::parse($t2)) {
 
                            return redirect()->back()->with(['message' => 'Um dos horários de abertura e fechamento estão incorretos']);
                        } */
                    } else {
                        $str .= '}]';
                    }
 
                    if ($i != count($data) - 1) {
                        $str .= '],';
                    } else {
                        $str .= ']';
                    }
                    $i++;
                }
                    $str .= '}';
                    $restaurant->working_time = $str;
             }
             //----- Hor�rios de Funcionamento - FIM
        
                    try {

                        if($restaurant->status==4){
                            $restaurant->status = 5;
                        }
                        

                        $restaurant->save();

                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            return redirect()->route('wizard.wizard_6');
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

      /**
     * @param Request $request
     */
    public function updateWizard6(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
                        
            if ($request->manage_stock == 'on') {
                $restaurant->manage_stock = true;
            } else {
                $restaurant->manage_stock = false;
            }
            if ($request->accept_outofstock == 'on') {
                $restaurant->accept_outofstock = true;
            } else {
                $restaurant->accept_outofstock = false;
            }
            if($request->addtime_outofstock){
                $restaurant->addtime_outofstock=$request->addtime_outofstock;
            }
            if ($request->variable_time == 'on') {
                $restaurant->variable_time = true;
            } else {
                $restaurant->variable_time = false;
            }
            if($restaurant->status==5){
                $restaurant->status = 6;
            }
           
        
                    try {
                        $restaurant->save();

                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            if($restaurant->check_terms_date){
                                if($restaurant->plan){
                                    return redirect()->route('wizard.wizard_end');
                                }else{
                                    return redirect()->route('wizard.wizard_8');
                                }
                                
                            }else{
                                return redirect()->route('wizard.wizard_7');
                            }
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


      /**
     * @param Request $request
     */
    public function updateWizard7(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
                        
            if ($request->check_terms_date) {
                $restaurant->check_terms_date = now();
            }  
           
            if ($request->check_terms_ip) {
                $restaurant->check_terms_ip = $request->ip();
            }  

            
            if($restaurant->status==6){
                $restaurant->status = 7;
            }
           
            
        
                    try {
                        $restaurant->save();
                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            return redirect()->route('wizard.wizard_8');
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
   

    
      /**
     * @param Request $request
     */
    public function updateWizard8(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
                        
           
            if($restaurant->status==7){
                $restaurant->status = 8;
            }
           
            $restaurant->plan=$request->plan;
            
        
                    try {
                        $restaurant->save();
                        if (isset($request->api)) {
                            $response=[
                                'success'=>true,
                            ];
                            return response()->json($response, 201);
                        } else {
                            return redirect()->route('wizard.wizard_end');
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
