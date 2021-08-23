<?php

namespace App\Http\Controllers;

use App\Addon;
use App\AddonCategory;
use App\Helpers\TranslationHelper;
use App\Item;
use App\IuguSubaccount;
use App\ItemCategory;
use App\Flyer;
use App\FlyerRestaurant;
use App\Order;
use App\PaymentGateway;
use App\PushNotify;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantEarning;
use App\RestaurantPayout;
use App\Sms;
use App\StorePayoutDetail;
use App\User;
use App\Message;
use App\Customer;
use App\Seller;
use Auth;
use Ixudra\Curl\Facades\Curl;
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

class RestaurantOwnerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $restaurant = $user->restaurants;

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $restaurant_user=Restaurant::where('id',$user->restaurant_id)->first();
        $status=$restaurant_user->status;

        if($status==9  ){
            return redirect()->route('restaurant.orders');

        }
        
        
        if(($status==8) && ($restaurant_user->ask_publish==0)){
            return redirect()->route('wizard.wizard_panel');

        }
        if(($status>=8) && ($restaurant_user->ask_publish==1)){
           

        
        

       

        $newOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('orderstatus_id', '1')
            ->orderBy('id', 'DESC')
            ->with('restaurant')
            ->get();

        $newOrdersIds = $newOrders->pluck('id')->toArray();

        $preparingOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->whereIn('orderstatus_id', ['2'])
            ->where('delivery_type', '<>', 2)
            ->orderBy('id', 'DESC')
            ->get();

        $selfpickupOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->whereIn('orderstatus_id', ['2', '7'])
            ->where('delivery_type', 2)
            ->orderBy('orderstatus_id', 'DESC')
            ->get();

        $ongoingOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->whereIn('orderstatus_id', ['3', '4'])
            ->orderBy('orderstatus_id', 'DESC')
            ->get();

        $allItems = Item::whereIn('restaurant_id', $restaurantIds)
           
            ->get();
        $allItemsCount = count($allItems);

        $allOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('orderstatus_id', '5')
            ->with('orderitems')
            ->get();
        $ordersCount = count($allOrders);

        $orderItemsCount = 0;
        foreach ($allOrders as $order) {
            $orderItemsCount += count($order->orderitems);
        }

        $allCompletedOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('orderstatus_id', '5')
            ->with('orderitems', 'orderitems.order_item_addons')
            ->get();

        $totalEarning = 0;
        settype($var, 'float');

        foreach ($allCompletedOrders as $completedOrder) {
            $totalEarning += $completedOrder->total - ($completedOrder->delivery_charge + $completedOrder->tip_amount);
        }

        $zenMode = \Session::get('zenMode');
        
        $restaurant = Restaurant::where('id', $user->restaurant_id)
            ->first();

        $arrayData = [
            'restaurantsCount' => count($user->restaurants),
            'restaurant'=>$restaurant,
            'ordersCount' => $ordersCount,
            'allItems' => $allItemsCount,
            'orderItemsCount' => $orderItemsCount,
            'totalEarning' => number_format($totalEarning, 2, ',', '.'),
            'newOrders' => $newOrders,
            'newOrdersIds' => $newOrdersIds,
            'preparingOrders' => $preparingOrders,
            'ongoingOrders' => $ongoingOrders,
            'selfpickupOrders' => $selfpickupOrders,
        ];

        if ($zenMode == 'true') {
            return view('restaurantowner.dashboardv2', $arrayData);
        }

        return view('restaurantowner.dashboard', $arrayData);

    }
    }


    public function newOrdersNotification()
    {
        $user = Auth::user();

        $restaurant = $user->restaurants;

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $newOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('orderstatus_id', '1')
            ->orderBy('id', 'DESC')
            ->with('restaurant')
            ->get();

        

        return response()->json($newOrders);
    }

    public function newOrdersIdsNotification()
    {
        $user = Auth::user();

        $restaurant = $user->restaurants;

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $newOrders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('orderstatus_id', '1')
            ->orderBy('id', 'DESC')
            ->with('restaurant')
            ->get();

        $newOrdersIds = $newOrders->pluck('id')->toArray();

        return response()->json($newOrdersIds);
    }



    /**
     * @param Request $request
     */
    public function getNewOrders(Request $request)
    {
        $user = Auth::user();

        $restaurant = $user->restaurants;

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $listedOrderIds = $request->listed_order_ids;
        if ($listedOrderIds) {
            $newOrders = Order::whereIn('restaurant_id', $restaurantIds)
                ->whereNotIn('id', $listedOrderIds)
                ->where('orderstatus_id', '1')
                ->orderBy('id', 'DESC')
                ->with('restaurant')
                ->get();
        } else {
            $newOrders = Order::whereIn('restaurant_id', $restaurantIds)
                ->where('orderstatus_id', '1')
                ->orderBy('id', 'DESC')
                ->with('restaurant')
                ->get();
        }

        return response()->json($newOrders);
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

            if (Module::find('ThermalPrinter') && Module::find('ThermalPrinter')->isEnabled()) {

                $printerSetting = PrinterSetting::where('user_id', Auth::user()->id)->first();
                $data = json_decode($printerSetting->data);

                if ($data->automatic_printing == 'FULLINVOICE') {
                    $this->printInvoice($order->unique_order_id);
                }
            }

            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            } else {
                return redirect()->back()->with(array('success' => 'Order Accepted'));
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

            return redirect()->back()->with(array('success' => 'Order Marked as Ready'));
        } else {
            return redirect()->back()->with(array('message' => 'Something went wrong.'));
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

            return redirect()->back()->with(array('success' => 'Order Completed'));
        } else {
            return redirect()->back()->with(array('message' => 'Something went wrong.'));
        }
    }

    public function restaurants()
    {
        $user = Auth::user();
        $restaurants = $user->restaurants;
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();

        return view('restaurantowner.restaurants', array(
            'restaurantCategories' => $restaurantCategories,
            'restaurants' => $restaurants,
        ));
    }

    /**
     * @param $id
     */
    public function getEditRestaurant()
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

            return view('restaurantowner.editRestaurant', array(
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
            return redirect()->route('restaurantowner.restaurants')->with(array('message' => 'Access Denied'));
        }
    }


/**
     * @param $id
     */
    public function uploadLogoRestaurant()
    {
        
        $restaurant_id=$_POST['restaurant_id'];
        $restaurant=Restaurant::where('id',$restaurant_id)->first();
        $configuration = [
            'limit' => 1,
            'fileMaxSize' => 10,
            'extensions' => ['image/*'],
            'title' => 'auto',
            'uploadDir' => base_path('assets/img/restaurants/'),
            'replace' => false,
            'editor' => [
                'maxWidth' => 512,
                'maxHeight' => 512,
                'crop' => false,
                'quality' => 95
            ]
        ];
        
        if (isset($_POST['fileuploader']) && isset($_POST['name'])) {
            $name = str_replace(array('/', '\\'), '', $_POST['name']);
            $editing = isset($_POST['editing']) && $_POST['editing'] == true;
            
            if (is_file($configuration['uploadDir'] . $name)) {
                $configuration['title'] = $name;
                $configuration['replace'] = true;
            }
        }
    
        // initialize FileUploader
        $FileUploader = new FileUploader('files', $configuration);
        
        // call to upload the files
        $data = $FileUploader->upload();
        
        // change file's public data
        if (!empty($data['files'])) {
            $item = $data['files'][0];
            
            $data['files'][0] = array(
                'title' => $item['title'],
                'name' => $item['name'],
                'size' => $item['size'],
                'size2' => $item['size2']
            );
        }
       
      //  FileUploader::resize($filename = $item['name'], $width = 550, $height=null, $crop = false, $quality = 95);

        /* $imagens=array();
		if ($data['isSuccess'] && count($data['files']) > 0) {
			// get uploaded files
            $uploadedFiles = $data['files'];
            //dd($uploadedFiles);

			
				
		
			
		} */
	//	var_dump($uploadedFiles);

		
		/* // if warnings
		if ($data['hasWarnings']) {
			// get warnings
			$warnings = $data['warnings'];

		//	echo '<pre>';
		//	print_r($warnings);
		//	echo '</pre>';
			exit;
		} */
 

        $restaurant->image = '/assets/img/restaurants/'.$item['name'];
        $restaurant->save();

        // export to js
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }


    /**
     * @param $id
     */
    public function disableRestaurant($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        if ($restaurant) {
            //$restaurant->is_schedulable = false;
            $restaurant->toggleActive();
            $restaurant->save();
            return redirect()->back()->with(['success' => 'Operação Realizada com Sucesso!']);
        } else {
            return redirect()->route('restaurant.restaurants');
        }
    }



    /**
     * @param Request $request
     */
    public function saveNewRestaurant(Request $request)
    {
        $restaurant = new Restaurant();

        $restaurant->name = $request->name;
        $restaurant->description = $request->description;

        $image = $request->file('image');
        $rand_name = time() . str_random(10);
        $filename = $rand_name . '.jpg';

        //-ADD
        //Image::make($image)
        //     ->resize(160, 117)
        //     ->save(base_path('assets/img/restaurants/' . $filename), config('settings.uploadImageQuality '), 'jpg');
           
        
        $main_picture = $request->file('image');

        $canvas = Image::canvas(245, 245);
        $image  = Image::make($main_picture->getRealPath())->resize(245, 245, function($constraint)
        {
           $constraint->aspectRatio();
        });
        $canvas->insert($image, 'center');
        $canvas->save(base_path('assets/img/restaurants/' . $filename), config('settings.uploadImageQuality '), 'jpg');
        //-ADD
     

        $restaurant->image = '/assets/img/restaurants/' . $filename;

        $restaurant->delivery_time = $request->delivery_time;
        $restaurant->price_range = $request->price_range;

        if ($request->is_pureveg == 'true') {
            $restaurant->is_pureveg = true;
        } else {
            $restaurant->is_pureveg = false;
        }

        $restaurant->slug = str_slug($request->name) . '-' . str_random(15);
        $restaurant->certificate = $request->certificate;

        $restaurant->address = $request->address;
        $restaurant->pincode = $request->pincode;
        $restaurant->google_address = $request->google_address;
        //--ADD
        $restaurant->telefone = $request->telefone;
        $restaurant->whatsapp = $request->whatsapp;
        $restaurant->email = $request->email;
        $restaurant->website = $request->website;
        $restaurant->facebook = $request->facebook;
        $restaurant->instagram = $request->instagram;

        $restaurant->restaurant_charges = $request->restaurant_charges;
        $restaurant->delivery_charges = $request->delivery_charges;

        if ($request->has('delivery_type')) {
            $restaurant->delivery_type = $request->delivery_type;
        }
        if ($request->delivery_charge_type == 'FREE') {
            $restaurant->delivery_charge_type = 'FREE';
            
        }
        if ($request->delivery_charge_type == 'FIXED') {
            $restaurant->delivery_charge_type = 'FIXED';
            $restaurant->delivery_charges = $request->delivery_charges;
        }
        if ($request->delivery_charge_type == 'DYNAMIC') {
            $restaurant->delivery_charge_type = 'DYNAMIC';
            $restaurant->base_delivery_charge = $request->base_delivery_charge;
            $restaurant->base_delivery_distance = $request->base_delivery_distance;
            $restaurant->extra_delivery_charge = $request->extra_delivery_charge;
            $restaurant->extra_delivery_distance = $request->extra_delivery_distance;
        }
        if ($request->delivery_radius != null) {
            $restaurant->delivery_radius = $request->delivery_radius;
        }

        $restaurant->min_order_price = $request->min_order_price;

        //-ADD

        $restaurant->landmark = $request->landmark;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;

        $restaurant->restaurant_charges = $request->restaurant_charges;

        $restaurant->sku = time() . str_random(10);

        $restaurant->is_active = 0;

        $restaurant->min_order_price = $request->min_order_price;

       
        try {

            $restaurant->save();
            $user = Auth::user();
            $user->restaurants()->attach($restaurant);

            if (isset($request->restaurant_category_restaurant)) {
                $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
           }

            return redirect()->back()->with(array('success' => 'Loja Salva com Sucesso!')); //TRADUCAO
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

    /**
     * @param Request $request
     */
    public function updateRestaurant(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            if(isset($request->name)){
                $restaurant->name = $request->name;
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

            if(isset($request->telefone)){
                $restaurant->telefone = $request->telefone;
            }
            if(isset($request->whatsapp)){
                $restaurant->whatsapp = $request->whatsapp;
            }
            if(isset($request->email)){
                $restaurant->email = $request->email;
            }
            if(isset($request->facebook)){
                $restaurant->facebook = $request->facebook;
            }
            if(isset($request->twitter)){
                $restaurant->twitter = $request->twitter;
            }
            if(isset($request->website)){
                $restaurant->website = $request->website;
            }
            if(isset($request->instagram)){
                $restaurant->instagram = $request->instagram;
            }

            if ($request->manage_stock == 'on') {
                $restaurant->manage_stock = true;
            } else {
                $restaurant->manage_stock = false;
            }
            if ($request->variable_time == 'on') {
                $restaurant->variable_time = true;
            } else {
                $restaurant->variable_time = false;
            }


            if(isset($request->status)){
                $restaurant->status = $request->status;
            }
            if(isset($request->delivery_time)){
                $restaurant->delivery_time = $request->delivery_time;
            }
            if(isset($request->selfpickup_time)){
                $restaurant->selfpickup_time = $request->selfpickup_time;
            }
            if(isset($request->price_range)){
                $restaurant->price_range = $request->price_range;
            }
            if(isset($request->is_pureveg)){
                if ($request->is_pureveg == 'true') {
                    $restaurant->is_pureveg = true;
                } else {
                    $restaurant->is_pureveg = false;
                }
            }
            if(isset($request->certificate)){
            $restaurant->certificate = $request->certificate;
            }
            if(isset($request->google_address)){
            $restaurant->google_address = $request->google_address;
            }
            if(isset($request->address)){
            $restaurant->address = $request->address;
            }
            if(isset($request->pincode)){
            $restaurant->pincode = $request->pincode;
            }
            if(isset($request->landmark)){
            $restaurant->landmark = $request->landmark;
            }
            if(isset($request->latitude)){
            $restaurant->latitude = $request->latitude;
            }
            if(isset($request->longitude)){
            $restaurant->longitude = $request->longitude;
            }

            if (isset($request->delivery_type)) {
                $restaurant->delivery_type = $request->delivery_type;
            }

            if (isset($request->delivery_charge_type)) {
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
            }

            if (isset($request->delivery_radius)) {
                $restaurant->delivery_radius = $request->delivery_radius;
            }
            if (isset($request->min_order_price)) {
            $restaurant->min_order_price = $request->min_order_price;
            }
            if (isset($request->is_schedulable)) {
                if ($request->is_schedulable == 'true') {
                    $restaurant->is_schedulable = true;
                } else {
                    $restaurant->is_schedulable = false;
                }
            }

            $subaccount = IuguSubaccount::where('restaurant_id', $request->id)->first();
            
            if (isset($request->name)) {
                $subaccount->name = $request->name;
            }
            if (isset($request->cpf)) {
                $subaccount->cpf = $request->cpf;
            }

            if (isset($request->company_name)) {
                $subaccount->company_name = $request->company_name;
            }
            if (isset($request->cnpj)) {
                $subaccount->cnpj = $request->cnpj;
            }
            if (isset($request->person_type)) {
                $subaccount->person_type = $request->person_type;
            }
            if (isset($request->resp_name)) {
                $subaccount->resp_name = $request->resp_name;
            }
            if (isset($request->resp_cpf)) {
                $subaccount->resp_cpf = $request->resp_cpf;
            }
            if (isset($request->bank)) {
                $subaccount->bank = $request->bank;
            }
            if (isset($request->bank_ag)) {
                $subaccount->bank_ag = $request->bank_ag;
            }
            if (isset($request->account_type)) {
                $subaccount->account_type = $request->account_type;
            }
            if (isset($request->bank_cc)) {
                $subaccount->bank_cc = $request->bank_cc;
            }

            if (isset($request->telefone)) {
                $subaccount->telephone = $request->telefone;
            }
            if (isset($request->description)) {
                $subaccount->business_type = $request->description;
            }
            $subaccount->automatic_transfer = $request->automatic_transfer;

            $subaccount->save();
            

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
                
            
             //----- Hor�rios que Recebe Pedido - FIM

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

                        if ($request->store_payment_gateways == null) {
                            $restaurant->payment_gateways()->sync($request->store_payment_gateways);
                        }

                        if (isset($request->store_payment_gateways)) {
                            $restaurant->payment_gateways()->sync($request->store_payment_gateways);
                        }

                        $restaurant->save();

                        if (isset($request->restaurant_category_restaurant)) {
                            $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
                    }
                        return redirect()->back()->with(array('success' => 'Estabelecimento Atualizado com Sucesso!'));
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
     * @param $id
     */
    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        if ($restaurant) {
            $items = $restaurant->items;
            foreach ($items as $item) {
                $item->delete();
            }
            $restaurant->delete();
            return redirect()->back()->with(['success' => 'Loja Exclu�da com Sucesso!']);
        } else {
            return redirect()->route('restaurant.restaurants');
        }
    }



   

    /**
     * @param $id
     */
    public function disableCategory($id)
    {
        $itemCategory = ItemCategory::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        if ($itemCategory) {
            $itemCategory->toggleEnable()->save();
            return redirect()->back()->with(array('success' => 'Operation Successful'));
        } else {
            return redirect()->route('restaurant.itemcategories');
        }
    }

    /**
     * @param Request $request
     */
    public function updateItemCategory(Request $request)
    {
        $itemCategory = ItemCategory::where('id', $request->id)->where('user_id', Auth::user()->id)->firstOrFail();
        $itemCategory->name = $request->name;
        $itemCategory->save();
        return redirect()->back()->with(['success' => 'Operation Successful']);
    }


   


/**
 * @param Request $request
 */
    public function searchItems(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $query = $request['query'];

        $items = Item::whereIn('restaurant_id', $restaurantIds)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->with('item_category', 'restaurant')
            ->paginate(20);

        $count = $items->total();

        $restaurants = $user->restaurants;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->get();

        return view('restaurantowner.items', array(
            'items' => $items,
            'count' => $count,
            'restaurants' => $restaurants,
            'query' => $query,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    



/**
 * @param $id
 */
    public function disableItem($id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $item = Item::where('id', $id)
            ->whereIn('restaurant_id', $restaurantIds)
            ->first();
        if ($item) {
            $item->toggleActive()->save();
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with(array('success' => 'Operação Realizada com Sucesso!'));
        } else {
            return redirect()->route('restaurant.items');
        }
    }

   
/**
 * @param Request $request
 */
public function updateFlyer(Request $request)
{
    $flyer = Flyer::where('id', $request->id)->firstOrFail();
    $uploadDir = base_path('assets/img/flyers/');
    $encartesDir = base_path('assets/img/flyers/');
    $preloadedFiles='';

    
    
     
	$uploadsFiles1 = $flyer->image;//array_diff(scandir($uploadDir), array('.', '..'));
			$uploadsFiles=json_decode($uploadsFiles1);
			$preloadedFiles=array();
			foreach($uploadsFiles as $file) {
				// skip if directory
				//if(is_dir($uploadDir . $file))
				//	continue;
						
						// skip if thumbnail
					//	if (substr($uploadDir . $file, 0, 6) == 'thumb_')
					//			continue;
		
				// add file to our array
				// !important please follow the structure below
				$preloadedFiles[] = array(
					"name" => $file,
					"type" => FileUploader::mime_content_type($uploadDir . $file),
					"size" => filesize($uploadDir . $file),
					"file" => $uploadDir . $file,
								"relative_file" => $uploadDir . $file
				);
				//dd($preloadedFiles);
			}
           // $preloadedFiles=$request->fileuploader-list-files;

// initialize FileUploader
$FileUploader = new FileUploader('files', array(
    'limit' => null,
    'maxSize' => null,
    'extensions' => null,
    'uploadDir' => $encartesDir,
    'title' => 'auto',
'files' => $preloadedFiles
));

	// unlink the files
		// !important only for preloaded files
		// you will need to give the array with appendend files in 'files' option of the FileUploader
		//	foreach($FileUploader->getRemovedFiles('file') as $key=>$value) {
		//	unlink($uploadDir . $value['name']);
		//	}

		//echo $list=post('fileuploader-list-files');
		//echo $filess=post('files');
		// call to upload the files
		$data = $FileUploader->upload();
		//var_dump($data);
		// if uploaded and success
		$imagens=array();
		if ($data['isSuccess'] && count($data['files']) > 0) {
			// get uploaded files
            $uploadedFiles = $data['files'];
            //dd($uploadedFiles);

			foreach ($uploadedFiles as $item) {
				FileUploader::resize($filename = $item['file'], $width = 550, $height=null, $crop = false, $quality = 95);
			}
			
		}
	//	var_dump($uploadedFiles);

		
		// if warnings
		if ($data['hasWarnings']) {
			// get warnings
			$warnings = $data['warnings'];

			echo '<pre>';
			print_r($warnings);
			echo '</pre>';
			exit;
		}

		// get the fileList
		$fileList = $FileUploader->getFileList();
//dd($fileList);
		// show
		echo '<pre>';
		print_r($fileList);
		echo '</pre>';


		foreach ($fileList as $row){
			$imagens[]=$row['name'];
        } 
        


        
    $flyer->name = $request->name;
    $flyer->is_active = 1;
     $flyer->start_date = $request->start_date;
    $flyer->end_date = $request->end_date;
//$flyer->image = json_encode($imagens);
    
    try {
        $flyer->save();
        if (isset($request->flyer_restaurant_flyer)) {
            $flyer->restaurants()->sync($request->flyer_restaurant_flyer);
       }
        return redirect()->back()->with(['success' => 'Folheto Salvo com Sucesso!']);
    } catch (\Illuminate\Database\QueryException $qe) {
        return redirect()->back()->with(['message' => $qe->getMessage()]);
    } catch (Exception $e) {
        return redirect()->back()->with(['message' => $e->getMessage()]);
    } catch (\Throwable $th) {
        return redirect()->back()->with(['message' => $th]);
    }
    
}

public function ajax_sort_files(){
    $list = isset($_POST['_list']) ? json_decode($_POST['_list'], true) : null;

print_r($list);
}

  

    public function addonCategories()
    {
        $user = Auth::user();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        $addonCategories->loadCount('addons');

        $count = $addonCategories->total();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        return view('restaurantowner.addonCategories', array(
            'addonCategories' => $addonCategories,
            'restaurant'=>$restaurant,
            'count' => $count,
        ));
    }

    /**
     * @param Request $request
     */
    public function searchAddonCategories(Request $request)
    {
        $query = $request['query'];

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $addonCategories->loadCount('addons');

        $count = $addonCategories->total();

        return view('restaurantowner.addonCategories', array(
            'addonCategories' => $addonCategories,
            'count' => $count,
        ));
    }

    /**
     * @param Request $request
     */
    public function saveNewAddonCategory(Request $request)
    {
        $addonCategory = new AddonCategory();

        $addonCategory->name = $request->name;
        $addonCategory->type = $request->type;

        $addonCategory->min = $request->min;
        $addonCategory->max = $request->max;
        
        //$addonCategory->description = $request->description;
        $addonCategory->user_id = Auth::user()->id;

        if ($request->status == 'on') {
            $addonCategory->status = true;
        } else {
            $addonCategory->status = false;
        }

        try {
            $addonCategory->save();
            if ($request->has('addon_names')) {
                foreach ($request->addon_names as $key => $addon_name) {
                    $addon = new Addon();
                    $addon->name = $addon_name;
                    $addon->description = $request->addon_description[$key];
                    $addon->price = $request->addon_prices[$key];
                    $addon->addon_category_id = $addonCategory->id;
                    $addon->user_id = Auth::user()->id;
                    $addon->save();
                }
            }
            return redirect()->route('restaurant.addonCategories')->with(['success' => 'Grupo de Adicionais Salvo com Sucesso!']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

    public function newAddonCategory()
    {
        return view('restaurantowner.newAddonCategory');
    }

    /**
     * @param $id
     */
    public function getEditAddonCategory($id)
    {
        $addonCategory = AddonCategory::where('id', $id)->with('addons')->first();
        if ($addonCategory) {
            if ($addonCategory->user_id == Auth::user()->id) {
                return view('restaurantowner.editAddonCategory', array(
                    'addonCategory' => $addonCategory,
                    'addons' => $addonCategory->addons,
                    
                ));
            } else {
                return redirect()
                    ->route('restaurant.addonCategories')
                    ->with(array('message' => 'Access Denied'));
            }
        } else {
            return redirect()
                ->route('restaurant.addonCategories')
                ->with(array('message' => 'Access Denied'));
        }
    }

    /**
     * @param Request $request
     */
    public function updateAddonCategory(Request $request)
    {
        $addonCategory = AddonCategory::where('id', $request->id)->first();

        if ($addonCategory) {

            $addonCategory->name = $request->name;
            $addonCategory->type = $request->type;
            $addonCategory->description = $request->description;

            try {
                $addonCategory->save();
                $addons_old = $request->input('addon_old');
                if ($request->has('addon_old')) {
                    foreach ($addons_old as $ad) {
                        $addon_old_update = Addon::find($ad['id']);
                        $addon_old_update->name = $ad['name'];
                        $addon_old_update->price = str_replace(",",".", $ad['price']);
                        $addon_old_update->user_id = Auth::user()->id;
                        $addon_old_update->save();
                    }
                }

                if ($request->addon_names) {
                    foreach ($request->addon_names as $key => $addon_name) {
                        $addon = new Addon();
                        $addon->name = $addon_name;
                        $addon->price =  str_replace(",",".", $request->addon_prices[$key]);
                        $addon->addon_category_id = $addonCategory->id;
                        $addon->user_id = Auth::user()->id;
                        $addon->save();
                    }
                }

                return redirect()->route('restaurant.addonCategories')->with(['success' => 'Grupo de Adicionais atualizado com Sucesso!']);
            } catch (\Illuminate\Database\QueryException $qe) {
                return redirect()->back()->with(['message' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->with(['message' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['message' => $th]);
            }
        }
    }

    public function addons()
    {
        $addons = Addon::where('user_id', Auth::user()->id)->with('addon_category')->paginate();

        $count = $addons->total();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->get();

        return view('restaurantowner.addons', array(
            'addons' => $addons,
            'count' => $count,
            'addonCategories' => $addonCategories,
        ));
    }

    /**
     * @param Request $request
     */
    public function searchAddons(Request $request)
    {
        $query = $request['query'];

        $addons = Addon::where('user_id', Auth::user()->id)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->with('addon_category')
            ->paginate(20);

        $count = $addons->total();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->get();

        return view('restaurantowner.addons', array(
            'addons' => $addons,
            'count' => $count,
            'addonCategories' => $addonCategories,
        ));
    }

    /**
     * @param Request $request
     */
    public function saveNewAddon(Request $request)
    {
        $addon = new Addon();

        $addon->name = $request->name;
        $addon->price = $request->price;
        $addon->user_id = Auth::user()->id;
        $addon->addon_category_id = $request->addon_category_id;

        try {
            $addon->save();
            return redirect()->back()->with(array('success' => 'Addon Saved'));
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(array('message' => 'Something went wrong. Please check your form and try again.'));
        } catch (Exception $e) {
            return redirect()->back()->with(array('message' => $e->getMessage()));
        } catch (\Throwable $th) {
            return redirect()->back()->with(array('message' => $th));
        }
    }

    /**
     * @param $id
     */
    public function getEditAddon($id)
    {
        $addon = Addon::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->get();
        if ($addon) {
            return view('restaurantowner.editAddon', array(
                'addon' => $addon,
                'addonCategories' => $addonCategories,
            ));
        } else {
            return redirect()->route('restaurant.addons')->with(array('message' => 'Access Denied'));
        }
    }

    /**
     * @param Request $request
     */
    public function updateAddon(Request $request)
    {
        $addon = Addon::where('id', $request->id)->first();

        if ($addon) {
            if ($addon->user_id == Auth::user()->id) {
                $addon->name = $request->name;
                $addon->price = $request->price;
                $addon->addon_category_id = $request->addon_category_id;

                try {
                    $addon->save();
                    return redirect()->back()->with(array('success' => 'Addon Updated'));
                } catch (\Illuminate\Database\QueryException $qe) {
                    return redirect()->back()->with(array('message' => 'Something went wrong. Please check your form and try again.'));
                } catch (Exception $e) {
                    return redirect()->back()->with(array('message' => $e->getMessage()));
                } catch (\Throwable $th) {
                    return redirect()->back()->with(array('message' => $th));
                }
            } else {
                return redirect()->route('restaurant.addons')->with(array('message' => 'Access Denied'));
            }
        } else {
            return redirect()->route('restaurant.addons')->with(array('message' => 'Access Denied'));
        }
    }

    /**
     * @param $id
     */
    public function disableAddon($id)
    {
        $addon = Addon::where('id', $id)->firstOrFail();
        if ($addon) {
            $addon->toggleActive()->save();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Something Went Wrong']);
        }
    }

    /**
     * @param $id
     */
    public function deleteAddon($id)
    {
        $addon = Addon::find($id);
        if ($addon->user_id == Auth::user()->id) {
            $addon->delete();

            return redirect()->back()->with(['success' => 'Item Excluído']);
        } else {
            return redirect()->back()->with(['message' => 'Click on Update first, then try deleting again.']);
        }
    }

    public function orders()
    {
        $user = Auth::user();
        
        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();

        $orders = Order::orderBy('id', 'DESC')
           
            ->where('restaurant_id', $user->restaurant_id)
            
            ->get();
        $sellers= Seller::where('restaurant_id',$user->restaurant_id)->where('is_deleted',0)->where('is_active',1)->get();

        //$count = $orders->total();
        // dd($orders);
        return view('panel.orders', array(
            'restaurant'=>$restaurant,
            'orders' => $orders,
            'sellers'=>$sellers,
            //'count' => $count,
        ));
    }

    public function check_message($id,$phone)
    {
        $check=Message::where('restaurant_id',$id)->where('phone',$phone)->whereDate('created_at', '>', Carbon::now()->subDays(1))->get();

        if(count($check)>=1){
            $response = true;
        }else{
            $response=false;
        }

        return response()->json($response);
    }

       
 /**
     * @param Request $request
     */
    public function receiving_message(Request $request)

    {
        $restaurant=Restaurant::where('whats_instance',$request->instance)->first();
        $check=Customer::where('phone',$request->whatsapp)->first();
        $message= new Message();
        $message->message=$request->message;
        $message->phone=$request->phone;


        $message->restaurant_id=$restaurant->id;
        $message->save();


    }
    
 /**
     * @param Request $request
     */
    public function check_contact(Request $request)

    {

        $check=Customer::where('phone',$request->whatsapp)->first();

        if($check){
            $response = $check;
        }else{
            $response=false;
        }

        return response()->json($response);
    }


    
    /**
     * @param Request $request
     */
    public function saveNewOrder(Request $request)
    {
        $user = Auth::user();
       if(isset($request->customer_id)){
           $customer=Customer::where('id',$request->customer_id)->first();

       }else{
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = str_replace(['(','-',')',' '],'',$request->whatsapp);
        $customer->save();

        //SALVAR CONTATO NO GOOGLE
       }
              

        $order = new Order();
        $order->seller_id = $request->seller_id;
        $order->sub_total = str_replace(",",".", $request->sub_total);
        $order->total=str_replace(",",".", $request->total);
        $order->user_id=$user->id;
        $order->restaurant_id=$user->restaurant_id;
        $order->discount_amount=str_replace(",",".", $request->sub_total) - str_replace(",",".", $request->total);
        $order->customer_id = $customer->id;
        $order->seller_id=$request->seller_id;

           try {
            $order->save();

            //ENVIAR MENSAGEM WHATSAPP
            $message='';
            $url_text='https://api.z-api.io/instances/39E0BADAF8E17069BF6B5274800DE1AF/token/36903DACBE920D8C082648E2/send-text';
      
            $data1=[
                'phone'=>'55'.$customer->whatsapp,
                'message'=>$message
            ];
             $response=  Curl::to($url_text)
            ->withHeader('Content-Type: application/json')
            ->withData(json_encode($data1))
            ->post();

          
            return redirect()->route('restaurant.orders')->with(['success' => 'Venda Realizada com Sucesso!']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }


    /**
     * @param Request $request
     */
    public function postSearchOrders(Request $request)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $query = $request['query'];

        $orders = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('unique_order_id', 'LIKE', '%' . $query . '%')
            ->with('accept_delivery.user', 'restaurant')
            ->paginate(20);

        $count = $orders->total();

        return view('restaurantowner.orders', array(
            'orders' => $orders,
            'count' => $count,
        ));
    }

    /**
     * @param $order_id
     */
    public function viewOrder($order_id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();
        
        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        $order = Order::whereIn('restaurant_id', $restaurantIds)
            ->where('unique_order_id', $order_id)
            ->with('orderitems.order_item_addons')
            ->first();

        if ($order) {
            return view('restaurantowner.viewOrder', array(
                'order' => $order,
                'restaurant'=>$restaurant,
            ));
        } else {
            return redirect()->route('restaurantowner.orders');
        }
    }

    /**
     * @param $restaurant_id
     */
    public function earnings($restaurant_id = null)
    {
        if ($restaurant_id) {
            $user = Auth::user();
            $restaurant = $user->restaurants;
            $restaurantIds = $user->restaurants->pluck('id')->toArray();

            $restaurant = Restaurant::where('id', $restaurant_id)->first();
            // check if restaurant exists
            if ($restaurant) {
                //check if restaurant belongs to the auth user
                // $contains = Arr::has($restaurantIds, $restaurant->id);
                $contains = in_array($restaurant->id, $restaurantIds);
                if ($contains) {
                    //true
                    $allCompletedOrders = Order::where('restaurant_id', $restaurant->id)
                        ->where('orderstatus_id', '5')
                        ->get();

                    $totalEarning = 0;
                    settype($var, 'float');

                    foreach ($allCompletedOrders as $completedOrder) {
                        // $totalEarning += $completedOrder->total - $completedOrder->delivery_charge;
                        $totalEarning += $completedOrder->total - ($completedOrder->delivery_charge + $completedOrder->tip_amount);
                    }

                    // Build an array of the dates we want to show, oldest first
                    $dates = collect();
                    foreach (range(-30, 0) as $i) {
                        $date = Carbon::now()->addDays($i)->format('Y-m-d');
                        $dates->put($date, 0);
                    }

                    // Get the post counts
                    $posts = Order::where('restaurant_id', $restaurant->id)
                        ->where('orderstatus_id', '5')
                        ->where('created_at', '>=', $dates->keys()->first())
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get([
                            DB::raw('DATE( created_at ) as date'),
                            DB::raw('SUM( total ) as "total"'),
                        ])
                        ->pluck('total', 'date');

                    // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
                    $dates = $dates->merge($posts);

                    // dd($dates);
                    $monthlyDate = '[';
                    $monthlyEarning = '[';
                    foreach ($dates as $date => $value) {
                        $monthlyDate .= "'" . $date . "' ,";
                        $monthlyEarning .= "'" . $value . "' ,";
                    }

                    $monthlyDate = rtrim($monthlyDate, ' ,');
                    $monthlyDate = $monthlyDate . ']';

                    $monthlyEarning = rtrim($monthlyEarning, ' ,');
                    $monthlyEarning = $monthlyEarning . ']';
                    /*=====  End of Monthly Post Analytics  ======*/

                    $balance = RestaurantEarning::where('restaurant_id', $restaurant->id)
                        ->where('is_requested', 0)
                        ->first();

                    if (!$balance) {
                        $balanceBeforeCommission = 0;
                        $balanceAfterCommission = 0;
                    } else {
                        $balanceBeforeCommission = $balance->amount;
                        $balanceAfterCommission = ($balance->amount - ($restaurant->commission_rate / 100) * $balance->amount);
                        $balanceAfterCommission = number_format((float) $balanceAfterCommission, 2, '.', '');
                    }

                    $payoutRequests = RestaurantPayout::where('restaurant_id', $restaurant_id)->orderBy('id', 'DESC')->get();

                    return view('restaurantowner.earnings', array(
                        'restaurant' => $restaurant,
                        'totalEarning' => $totalEarning,
                        'monthlyDate' => $monthlyDate,
                        'monthlyEarning' => $monthlyEarning,
                        'balanceBeforeCommission' => $balanceBeforeCommission,
                        'balanceAfterCommission' => $balanceAfterCommission,
                        'payoutRequests' => $payoutRequests,
                    ));
                } else {
                    return redirect()->route('restaurant.earnings')->with(array('message' => 'Access Denied'));
                }
            } else {
                return redirect()->route('restaurant.earnings')->with(array('message' => 'Access Denied'));
            }
        } else {
            $user = Auth::user();
            $restaurants = $user->restaurants;
          
        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();

            return view('restaurantowner.earnings', array(
                'restaurants' => $restaurants,
                'restaurant'=>$restaurant,
            ));
        }
    }

    /**
     * @param Request $request
     */
    public function sendPayoutRequest(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->restaurant_id)->first();
        $earning = RestaurantEarning::where('restaurant_id', $request->restaurant_id)
            ->where('is_requested', 0)
            ->first();

        $balanceBeforeCommission = $earning->amount;
        $balanceAfterCommission = ($earning->amount - ($restaurant->commission_rate / 100) * $earning->amount);
        $balanceAfterCommission = number_format((float) $balanceAfterCommission, 2, '.', '');

        if ($earning) {
            $payoutRequest = new RestaurantPayout;
            $payoutRequest->restaurant_id = $request->restaurant_id;
            $payoutRequest->restaurant_earning_id = $earning->id;
            $payoutRequest->amount = $balanceAfterCommission;
            $payoutRequest->status = 'PENDING';
            try {
                $payoutRequest->save();
                $earning->is_requested = 1;
                $earning->restaurant_payout_id = $payoutRequest->id;
                $earning->save();
            } catch (\Illuminate\Database\QueryException $qe) {
                return redirect()->back()->with(array('message' => 'Something went wrong. Please check your form and try again.'));
            } catch (Exception $e) {
                return redirect()->back()->with(array('message' => $e->getMessage()));
            } catch (\Throwable $th) {
                return redirect()->back()->with(array('message' => $th));
            }

            return redirect()->back()->with(array('success' => 'Payout Request Sent'));
        } else {
            return redirect()->route('restaurant.earnings')->with(array('message' => 'Access Denied'));
        }
    }

    /**
     * @param $id
     */
    public function cancelOrder($id, TranslationHelper $translationHelper)
    {
        $keys = ['orderRefundWalletComment', 'orderPartialRefundWalletComment'];
        $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $order = Order::where('id', $id)->whereIn('restaurant_id', $restaurantIds)->first();

        $customer = User::where('id', $order->user_id)->first();

        if ($order && $user) {
            if ($order->orderstatus_id == '1') {
                //change order status to 6 (Canceled)
                $order->orderstatus_id = 6;
                $order->save();
                //refund money if paid online
                // if (!$order->payment_mode == 'COD') {
                //     //paid online or paid fully with wallet (Give full refund)
                //     $customer = User::where('id', $order->user_id)->first();
                //     if ($customer) {
                //         $customer->deposit($order->total * 100, ['description' => $translationData->orderRefundWalletComment . $order->unique_order_id]);
                //     }
                // }

                //if COD, then check if wallet is present
                if ($order->payment_mode == 'COD') {
                    if ($order->wallet_amount != null) {
                        //refund wallet amount
                        $customer->deposit($order->wallet_amount * 100, ['description' => $translationData->orderPartialRefundWalletComment . $order->unique_order_id]);
                    }
                } else {
                    //if online payment, refund the total to wallet
                    $customer->deposit(($order->total) * 100, ['description' => $translationData->orderRefundWalletComment . $order->unique_order_id]);
                }

                //show notification to user
                if (config('settings.enablePushNotificationOrders') == 'true') {
                    //to user
                    $notify = new PushNotify();
                    $notify->sendPushNotification('6', $order->user_id, $order->unique_order_id);
                }

                if (\Illuminate\Support\Facades\Request::ajax()) {
                    return response()->json(['success' => true]);
                } else {
                    return redirect()->back()->with(array('success' => 'Order Canceled'));
                }
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
     * @param Request $request
     */
    public function updateRestaurantScheduleData(Request $request)
    {
        //dd($request);
        //$data = $request->except(['_token', 'restaurant_id']);
        $data = $request->only(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
        $i = 0;
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
                if (Carbon::parse($t1) >= Carbon::parse($t2)) {

                    return redirect()->back()->with(['message' => 'Opening and Closing time is incorrect']);
                }
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

        // Fetches The Restaurant
        $restaurant = Restaurant::where('id', $request->restaurant_id)->first();
        // Enters The Data
        $restaurant->schedule_data = $str;
        // Saves the Data to Database
        $restaurant->save();

        return redirect()->back()->with(['success' => 'Scheduling data saved successfully']);
    }

    public function checkOrderStatusNewOrder(Request $request)
    {
        $order = Order::where('unique_order_id', $request->order_id)->firstOrFail();

        if ($order->orderstatus_id != 1) {
            $data = [
                'reloadPage' => true,
            ];
        } else {
            $data = [
                'reloadPage' => false,
            ];
        }
        return response()->json($data);
    }

    public function checkOrderStatusSelfPickupOrder(Request $request)
    {
        $order = Order::where('unique_order_id', $request->order_id)->firstOrFail();
        if ($request->processSelfPickup) {
            if ($order->orderstatus_id == 5) {
                $data = [
                    'reloadPage' => true,
                ];
            } else {
                $data = [
                    'reloadPage' => false,
                ];
            }
        } else {
            if ($order->orderstatus_id == 2) {
                $data = [
                    'reloadPage' => false,
                ];
            } else {
                $data = [
                    'reloadPage' => true,
                ];
            }
        }

        return response()->json($data);
    }

    private function printInvoice($order_id, $printerSetting = null)
    {
        if (Module::find('ThermalPrinter') && Module::find('ThermalPrinter')->isEnabled()) {
            try {
                $print = new ThermalPrinter();
                $print->printInvoice($order_id);
            } catch (Exception $e) {
                \Session::flash('message', 'Printing Failed. Connection could not be established.');
            }
        }
    }

    public function updateStorePayoutDetails(Request $request)
    {
        $storePayoutDetail = StorePayoutDetail::where('restaurant_id', $request->restaurant_id)->first();
        if ($storePayoutDetail) {
            $storePayoutDetail->data = json_encode($request->except(['restaurant_id', '_token']));
        } else {
            $storePayoutDetail = new StorePayoutDetail();
            $storePayoutDetail->restaurant_id = $request->restaurant_id;
            $storePayoutDetail->data = json_encode($request->except(['restaurant_id', '_token']));
        }
        try {
            $storePayoutDetail->save();
            return redirect()->back()->with(['success' => 'Payout Data Saved']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }

    }
};
