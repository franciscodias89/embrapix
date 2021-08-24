<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\AcceptDelivery;
use App\Addon;
use App\AddonCategory;
use App\DeliveryGuyDetail;
use App\Helpers\TranslationHelper;
use App\Http\Middleware\SCLC;
use App\Http\Middleware\SCLCC;
use App\Http\Middleware\SelfHelpM;
use App\Item;
use App\ItemCategory;
use App\Order;
use App\Seller;
use App\Orderstatus;
use App\Page;
use App\Iugu;
use App\Log;
use App\IuguSubaccount;
use App\PaymentGateway;
use App\PopularGeoPlace;
use App\PromoSlider;
use App\PushNotify;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantPayout;
use App\Setting;
use App\Slide;
use App\Sms;
use App\UserLocation;
use App\SmsGateway;
use App\StorePayoutDetail;
use App\Translation;
use App\User;
use App\Flyer;
use App\Coupon;
use App\Sorteio;

use Artisan;
use Auth;
use Bavix\Wallet\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Image;
use Ixudra\Curl\Facades\Curl;
use Omnipay\Omnipay;
use OneSignal;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use JWTAuth;

use JWTAuthException;

class AdminController extends Controller
{

    public function __construct()
    {
        // $this->middleware(SCLC::class);
        // $this->middleware(SCLCC::class);
        // $this->middleware(SelfHelpM::class);
    }

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
     * @return mixed
     */
    public function dashboard(Request $request)
    {
        return redirect()->route('admin.stores');

        /* $displayUsers = User::count();

        $displayRestaurants = Restaurant::count();

        $displaySales = Order::where('orderstatus_id', 5)->get();
        $displayEarnings = $displaySales;

        $displaySales = count($displaySales);

        $total = 0;
        foreach ($displayEarnings as $de) {
            $total += $de->total;
        }
        $displayEarnings = $total;

        $orders = Order::orderBy('id', 'DESC')->with('orderstatus', 'restaurant')->take(10)->get();

        $users = User::orderBy('id', 'DESC')->with('roles')->take(9)->get();

        $todaysDate = Carbon::now()->format('Y-m-d');

        $orderStatusesName = '[';

        $orderStatuses = Orderstatus::get(['name'])
            ->pluck('name')
            ->toArray();
        foreach ($orderStatuses as $key => $value) {
            $orderStatusesName .= "'" . $value . "' ,";
        }
        $orderStatusesName = rtrim($orderStatusesName, ' ,');
        $orderStatusesName = $orderStatusesName . ']';

        $orderStatusOrders = Order::all();
        $ifAnyOrders = $orderStatusOrders->count();
        if ($ifAnyOrders == 0) {
            $ifAnyOrders = false;
        } else {
            $ifAnyOrders = true;
        }

        $orderStatusOrders = $orderStatusOrders->groupBy('orderstatus_id')->map(function ($orderCount) {
            return $orderCount->count();
        });

        $orderStatusesData = '[';
        foreach ($orderStatusOrders as $key => $value) {
            if ($key == 1) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Pedido Realizado'},";
            }
            if ($key == 2) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Preparando o Pedido'},";
            }
            if ($key == 3) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Entregador Atribuído'},";
            }
            if ($key == 4) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Pedido saiu para Entrega'},";
            }
            if ($key == 5) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Entregue'},";
            }
            if ($key == 6) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Cancelado'},";
            }
            if ($key == 7) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Pronto para Retirada'},";
            }
            if ($key == 8) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Aguardando Pagamento'},";
            }
            if ($key == 9) {
                $orderStatusesData .= '{value:' . $value . ", name: 'Falha no Pagamento'},";
            }
        }
        $orderStatusesData = rtrim($orderStatusesData, ',');
        $orderStatusesData .= ']';

        return view('admin.dashboard', array(
            'displayUsers' => $displayUsers,
            'displayRestaurants' => $displayRestaurants,
            'displaySales' => $displaySales,
            'displayEarnings' => number_format((float) $displayEarnings, 2, '.', ''),
            'orders' => $orders,
            'users' => $users,
            'todaysDate' => $todaysDate,
            'orderStatusesName' => $orderStatusesName,
            'orderStatusesData' => $orderStatusesData,
            'ifAnyOrders' => $ifAnyOrders,
        )); */
    }

    

    public function users()
    {
        $roles = Role::all();
        return view('admin.users', array(
            'roles' => $roles,
        ));
    }

/**
 * @param Request $request
 */
    public function saveNewUser(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'delivery_pin' => strtoupper(str_random(5)),
                'password' => \Hash::make($request->password),
            ]);

            if ($request->has('role')) {
                $user->assignRole($request->role);
            }

            if ($user->hasRole('Delivery Guy')) {

                $deliveryGuyDetails = new DeliveryGuyDetail();
                $deliveryGuyDetails->name = $request->delivery_name;
                $deliveryGuyDetails->age = $request->delivery_age;
                if ($request->hasFile('delivery_photo')) {
                    $photo = $request->file('delivery_photo');
                    $filename = time() . str_random(10) . '.' . strtolower($photo->getClientOriginalExtension());
                    Image::make($photo)->resize(250, 250)->save(base_path('/assets/img/delivery/' . $filename));
                    $deliveryGuyDetails->photo = $filename;
                }
                $deliveryGuyDetails->description = $request->delivery_description;
                $deliveryGuyDetails->vehicle_number = $request->delivery_vehicle_number;
                if ($request->delivery_commission_rate != null) {
                    $deliveryGuyDetails->commission_rate = $request->delivery_commission_rate;
                }
                if ($request->tip_commission_rate != null) {
                    $deliveryGuyDetails->tip_commission_rate = $request->tip_commission_rate;
                }
                $deliveryGuyDetails->save();
                $user->delivery_guy_detail_id = $deliveryGuyDetails->id;
                $user->save();

            }

            return redirect()->back()->with(['success' => 'User Created']);
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
    public function postSearchUsers(Request $request)
    {
        $query = $request['query'];

        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->with('roles', 'wallet')
            ->paginate(20);

        $roles = Role::all();

        $count = $users->total();

        return view('admin.users', array(
            'users' => $users,
            'query' => $query,
            'count' => $count,
            'roles' => $roles,
        ));
    }

/**
 * @param $id
 */
// public function getEditUser($id)
    // {
    //     $user = User::where('id', $id)->first();
    //     $roles = Role::get();
    //     // dd($user->delivery_guy_detail);
    //     return view('admin.editUser', array(
    //         'user' => $user,
    //         'roles' => $roles,
    //     ));
    // }
    public function getEditUser($id)
    {
        $user = User::where('id', $id)->with('orders')->first();
        $roles = Role::get();

        // dd($user->delivery_guy_detail);
        return view('admin.editUser', array(
            'orders' => $user->orders,
            'user' => $user,
            'roles' => $roles,
        ));
    }

/**
 * @param Request $request
 */
    public function updateUser(Request $request)
    {
        // dd($request->all());
        $user = User::where('id', $request->id)->first();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->has('password') && $request->password != null) {
                $user->password = \Hash::make($request->password);
            }
            if ($request->roles != null) {
                $user->syncRoles($request->roles);
            }
            $user->save();

            if ($user->hasRole('Delivery Guy')) {

                if ($user->delivery_guy_detail == null) {

                    $deliveryGuyDetails = new DeliveryGuyDetail();
                    $deliveryGuyDetails->name = $request->delivery_name;
                    $deliveryGuyDetails->age = $request->delivery_age;
                    if ($request->hasFile('delivery_photo')) {
                        $photo = $request->file('delivery_photo');
                        $filename = time() . str_random(10) . '.' . strtolower($photo->getClientOriginalExtension());
                        Image::make($photo)->resize(250, 250)->save(base_path('/assets/img/delivery/' . $filename));
                        $deliveryGuyDetails->photo = $filename;
                    }
                    $deliveryGuyDetails->description = $request->delivery_description;
                    $deliveryGuyDetails->vehicle_number = $request->delivery_vehicle_number;

                    if ($request->delivery_commission_rate != null) {
                        $deliveryGuyDetails->commission_rate = $request->delivery_commission_rate;
                    }

                    if ($request->tip_commission_rate != null) {
                        $user->delivery_guy_detail->tip_commission_rate = $request->tip_commission_rate;
                    }

                    if ($request->is_notifiable == 'true') {
                        $deliveryGuyDetails->is_notifiable = true;
                    } else {
                        $deliveryGuyDetails->is_notifiable = false;
                    }

                    if ($request->max_accept_delivery_limit != null) {
                        $deliveryGuyDetails->max_accept_delivery_limit = $request->max_accept_delivery_limit;
                    }

                    $deliveryGuyDetails->save();
                    $user->delivery_guy_detail_id = $deliveryGuyDetails->id;
                    $user->save();
                } else {
                    $user->delivery_guy_detail->name = $request->delivery_name;
                    $user->delivery_guy_detail->age = $request->delivery_age;
                    if ($request->hasFile('delivery_photo')) {
                        $photo = $request->file('delivery_photo');
                        $filename = time() . str_random(10) . '.' . strtolower($photo->getClientOriginalExtension());
                        Image::make($photo)->resize(250, 250)->save(base_path('/assets/img/delivery/' . $filename));
                        $user->delivery_guy_detail->photo = $filename;
                    }
                    $user->delivery_guy_detail->description = $request->delivery_description;
                    $user->delivery_guy_detail->vehicle_number = $request->delivery_vehicle_number;
                    if ($request->delivery_commission_rate != null) {
                        $user->delivery_guy_detail->commission_rate = $request->delivery_commission_rate;
                    }
                    if ($request->tip_commission_rate != null) {
                        $user->delivery_guy_detail->tip_commission_rate = $request->tip_commission_rate;
                    }
                    if ($request->is_notifiable == 'true') {
                        $user->delivery_guy_detail->is_notifiable = true;
                    } else {
                        $user->delivery_guy_detail->is_notifiable = false;
                    }

                    if ($request->max_accept_delivery_limit != null) {
                        $user->delivery_guy_detail->max_accept_delivery_limit = $request->max_accept_delivery_limit;
                    }

                    $user->delivery_guy_detail->save();
                }
            }

            return redirect()->back()->with(['success' => 'User Updated']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

/**
 * @param $id
 */
    public function banUser($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->toggleActive()->save();
        return redirect()->back()->with(['success' => 'Operation Successful']);
    }

    public function manageDeliveryGuys()
    {
        $users = User::role('Delivery Guy')->orderBy('id', 'DESC')->with('roles')->paginate(20);
        $count = $users->total();
        return view('admin.manageDeliveryGuys', array(
            'users' => $users,
            'count' => $count,
        ));
    }

/**
 * @param $id
 */
    public function getManageDeliveryGuysRestaurants($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->hasRole('Delivery Guy')) {
            $userRestaurants = $user->restaurants;
            $userRestaurantsIds = $user->restaurants->pluck('id')->toArray();

            $allRestaurants = Restaurant::get();

            return view('admin.manageDeliveryGuysRestaurants', array(
                'user' => $user,
                'userRestaurants' => $userRestaurants,
                'allRestaurants' => $allRestaurants,
                'userRestaurantsIds' => $userRestaurantsIds,
            ));
        }
    }

/**
 * @param Request $request
 */
    public function updateDeliveryGuysRestaurants(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->restaurants()->sync($request->user_restaurants);
        $user->save();
        return redirect()->back()->with(['success' => 'Delivery Guy Updated']);
    }

    public function manageRestaurantOwners()
    {
        $users = User::role('Store Owner')->orderBy('id', 'DESC')->with('roles')->paginate(20);
        $count = $users->total();

        return view('admin.manageRestaurantOwners', array(
            'users' => $users,
            'count' => $count,
        ));
    }

/**
 * @param $id
 */
    public function getManageRestaurantOwnersRestaurants($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->hasRole('Store Owner')) {
            $userRestaurants = $user->restaurants;
            $userRestaurantsIds = $user->restaurants->pluck('id')->toArray();
            $allRestaurants = Restaurant::get();

            return view('admin.manageRestaurantOwnersRestaurants', array(
                'user' => $user,
                'userRestaurants' => $userRestaurants,
                'allRestaurants' => $allRestaurants,
                'userRestaurantsIds' => $userRestaurantsIds,
            ));
        }
    }

/**
 * @param Request $request
 */
    public function updateManageRestaurantOwnersRestaurants(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->restaurants()->sync($request->user_restaurants);
        $user->save();
        return redirect()->back()->with(['success' => 'Store Owner Updated']);
    }

    public function orders()
    {
        return view('admin.orders');
    }

/**
 * @param Request $request
 */
    public function postSearchOrders(Request $request)
    {
        $query = $request['query'];

        $orders = Order::where('unique_order_id', 'LIKE', '%' . $query . '%')->with('accept_delivery.user', 'restaurant')->paginate(20);

        $count = $orders->total();

        return view('admin.orders', array(
            'orders' => $orders,
            'count' => $count,
        ));
    }

/**
 * @param $order_id
 */
    public function viewOrder($order_id)
    {
        $order = Order::where('unique_order_id', $order_id)->with('orderitems.order_item_addons')->first();
        $users = User::role('Delivery Guy')->get();
        if ($order) {
            return view('admin.viewOrder', array(
                'order' => $order,
                'users' => $users,
            ));
        } else {
            return redirect()->route('admin.orders');
        }
    }

    public function sliders()
    {
        $sliders = PromoSlider::orderBy('id', 'DESC')->with('slides')->get();
        $count = count($sliders);
        return view('admin.sliders', array(
            'sliders' => $sliders,
            'count' => $count,
        ));
    }

/**
 * @param $id
 */
    public function getEditSlider($id)
    {
        $restaurants = Restaurant::get();
        $slider = PromoSlider::where('id', $id)->first();

        if ($slider) {
            return view('admin.editSlider', array(
                'restaurants' => $restaurants,
                'slider' => $slider,
                'slides' => $slider->slides,
            ));
        } else {
            return redirect()->route('admin.sliders');
        }
    }

/**
 * @param Request $request
 */
    public function updateSlider(Request $request)
    {
        $slider = PromoSlider::where('id', $request->id)->first();
        $slider->name = $request->name;
        $slider->position_id = $request->position_id;
        $slider->size = $request->size;
        $slider->save();

        return redirect()->back()->with(['success' => 'Slider Updated']);

    }
/**
 * @param Request $request
 */
    public function createSlider(Request $request)
    {
        $sliderCount = PromoSlider::where('is_active', 1)->count();

        if ($sliderCount >= 2) {
            return redirect()->back()->with(['message' => 'Only two sliders can be created. Disbale or delete some Sliders to create more.']);
        }

        $slider = new PromoSlider();
        $slider->name = $request->name;
        $slider->location_id = '0';
        $slider->position_id = $request->position_id;
        $slider->size = $request->size;
        $slider->save();
        return redirect()->back()->with(['success' => 'New Slider Created']);
    }

/**
 * @param $id
 */
    public function disableSlider($id)
    {
        $slider = PromoSlider::where('id', $id)->first();
        if ($slider) {
            $slider->toggleActive()->save();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->route('admin.sliders');
        }
    }

/**
 * @param $id
 */
    public function deleteSlider($id)
    {
        $slider = PromoSlider::where('id', $id)->first();
        if ($slider) {
            $slides = $slider->slides;
            foreach ($slides as $slide) {
                $slide->delete();
            }
            $slider->delete();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->route('admin.sliders');
        }
    }

/**
 * @param Request $request
 */
    public function saveSlide(Request $request)
    {
        $url = url('/');
        $url = substr($url, 0, strrpos($url, '/')); //this will give url without "/public"

        $slide = new Slide();
        $slide->promo_slider_id = $request->promo_slider_id;
        $slide->name = $request->name;
        $slide->url = $request->url;

        $image = $request->file('image');
        $rand_name = time() . str_random(10);
        $filename = $rand_name . '.' . $image->getClientOriginalExtension();

        Image::make($image)
            ->resize(384, 384)
            ->save(base_path('assets/img/slider/' . $filename));
        $slide->image = '/assets/img/slider/' . $filename;

        if ($request->customUrl != null) {
            $slide->url = $request->customUrl;
        }

        $slide->save();

        return redirect()->back()->with(['success' => 'New Slide Created']);
    }

/**
 * @param $id
 */
    public function editSlide($id)
    {
        $slide = Slide::where('id', $id)->with('promo_slider')->first();
        $restaurants = Restaurant::get();
        if ($slide) {
            return view('admin.editSlide', array(
                'slide' => $slide,
                'restaurants' => $restaurants,
            ));
        } else {
            return redirect()->route('admin.sliders')->with(['message' => 'Slide Not Found']);
        }
    }

/**
 * @param Request $request
 */
    public function updateSlide(Request $request)
    {
        $slide = Slide::where('id', $request->id)->first();
        if ($slide) {
            $slide->name = $request->name;
            if ($request->url != null) {
                $slide->url = $request->url;
            }
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $rand_name = time() . str_random(10);
                $filename = $rand_name . '.' . $image->getClientOriginalExtension();
                Image::make($image)
                    ->resize(384, 384)
                    ->save(base_path('assets/img/slider/' . $filename));
                $slide->image = '/assets/img/slider/' . $filename;
            }
            if ($request->customUrl != null) {
                $slide->url = $request->customUrl;
            }
            $slide->save();
            return redirect()->back()->with(['success' => 'Slide Updated']);
        } else {
            return redirect()->route('admin.sliders')->with(['message' => 'Slide Not Found']);
        }
    }

/**
 * @param Request $request
 */
    public function updateSlidePosition(Request $request)
    {
        Slide::setNewOrder($request->newOrder);
        Artisan::call('cache:clear');
        return response()->json(['success' => true]);
    }

/**
 * @param $id
 */
    public function deleteSlide($id)
    {
        $slide = Slide::where('id', $id)->first();
        if ($slide) {
            $slide->delete();
            return redirect()->back()->with(['success' => 'Deleted']);
        } else {
            return redirect()->route('admin.sliders');
        }
    }

/**
 * @param $id
 */
    public function disableSlide($id)
    {
        $slide = Slide::where('id', $id)->first();
        if ($slide) {
            $slide->toggleActive()->save();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->route('admin.sliders');
        }
    }

    public function restaurants()

    
    {

        $user = Auth::user();

        $count = Restaurant::count();
       
              $restaurants = Restaurant::orderBy('id', 'DESC')->where('is_deleted', 0)->with('users.roles')->paginate(10000);
   

             $count = count($restaurants);



        return view('adm.restaurants', array(
            'restaurants' => $restaurants,
            'count' => $count,
            'user'=>$user,
            
        ));
    }

    public function sortStores()
    {
        $restaurants = Restaurant::where('is_accepted', '1')->with('users.roles')->ordered()->get();
        $count = $restaurants->count();

        $dapCheck = false;
        if (\Module::find('DeliveryAreaPro') && \Module::find('DeliveryAreaPro')->isEnabled()) {
            $dapCheck = true;
        }

        return view('adm.sortStores', array(
            'restaurants' => json_encode($restaurants),
            'count' => $count,
            'dapCheck' => $dapCheck,
        ));
    }

/**
 * @param Request $request
 */
    public function updateStorePosition(Request $request)
    {
        Restaurant::setNewOrder($request->newOrder);
        Artisan::call('cache:clear');
        return response()->json(['success' => true]);
    }

    public function pendingAcceptance()
    {
        $count = Restaurant::count();
        $user = Auth::user();
       
        //dd($location_id);
        if($user->user_type=='Licencer'){
            $location_id=UserLocation::where('user_id',$user->id)->first()->location_id;
           $restaurants = Restaurant::orderBy('id', 'DESC')->with('iugu_subaccounts')->where('is_test', null)->where('location_id', $location_id)->where('is_accepted', '0')->with('users.roles')->paginate(10000);
        }else{
            $restaurants = Restaurant::orderBy('id', 'DESC')->with('iugu_subaccounts')->where('is_test', null)->where('is_accepted', '0')->with('users.roles')->paginate(10000);
        }
        
        
        
        
        
        
        $count = count($restaurants);

        $dapCheck = false;
        if (\Module::find('DeliveryAreaPro') && \Module::find('DeliveryAreaPro')->isEnabled()) {
            $dapCheck = true;
        }


        $restaurants_array= new Collection();
        foreach($restaurants as $restaurant){
            $restaurant_id=$restaurant->id;
            $user=User::where('restaurant_id',$restaurant_id)->first();

            $categories_check= ItemCategory::where('user_id',$user->id)->get();
            if($categories_check){
                $categories_check=count($categories_check);
            }else{
                $categories_check=0;
            }
    
            $restaurant['categories_check']=$categories_check;

            $addons_check= AddonCategory::where('user_id',$user->id)->get();
            if($addons_check){
                $addons_check=count($addons_check);
            }else{
                $addons_check=0;
            }
            $restaurant['addons_check']=$addons_check;
    
            $items_check= Item::where('restaurant_id',$restaurant->id)->get();
            if($items_check){
                $items_check=count($items_check);
            }else{
                $items_check=0;
            }
            $restaurant['items_check']=$items_check;
            
            
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
            $restaurant['flyers_check']=$flyers_check;
    
            $coupons_check= Coupon::whereHas('restaurants', function ($query) use ($restaurant_id) {
                $query->where('restaurants.id', $restaurant_id );
                })->get();
            if($coupons_check){
                $coupons_check=count($coupons_check);
            }else{
                $coupons_check=0;
            }
            $restaurant['coupons_check']=$coupons_check;
    
            $sorteios_check= Sorteio::whereHas('restaurants', function ($query) use ($restaurant_id) {
                $query->where('restaurants.id', $restaurant_id );
                })->get();
            if($sorteios_check){
                $sorteios_check=count($sorteios_check);
            }else{
                $sorteios_check=0;
            }
            $restaurant['sorteios_check']=$sorteios_check;


            //$restaurants_array->push($restaurant);

        }

        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
    /*     $active = $restaurants_array->map(function ($restaurant) {
            return $restaurant;//->only(['id', 'name', 'description', 'image', 'rating', 'delivery_time', 'price_range', 'slug', 'is_featured', 'is_active', 'latitude', 'longitude','delivery_charges','delivery_charge_type','base_delivery_charge','base_delivery_distance','extra_delivery_charge','extra_delivery_distance','min_order_price','is_schedulable','restaurant_categories','distance']);
        });// ADD - acrescentado novos campos

        // $nearMe = $nearMe->shuffle()->sortByDesc('is_featured');
        $active_restaurants = $active->toArray();// ADD - acrescentado novos campos */
        
//dd($active_restaurants);




        return view('adm.restaurants', array(
            'restaurants' => $restaurants,
            'count' => $count,
            'user'=>$user,
            'dapCheck' => $dapCheck,
        ));
    }


    

/**
 * @param $id
 */
    public function disableRestaurant($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        if ($restaurant) {
            $restaurant->is_schedulable = false;
            $restaurant->toggleActive();
            $restaurant->save();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->route('admin.stores');
        }
    }

/**
 * @param $id
 */
    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        if ($restaurant) {
            
                $restaurant->is_deleted=1;
                $restaurant->save();
            
            return redirect()->route('admin.stores');
        } else {
            return redirect()->route('admin.stores');
        }
    }





/**
 * @param Request $request
 */
    public function saveNewRestaurant(Request $request)
    {

        $checkEmail = User::where('email', $request->email)->first();
        $checkPhone = User::where('phone', $request->whatsapp)->first();

        if ($checkPhone || $checkEmail) {
            $response = [
                'email_phone_already_used' => true,
            ];
            return response()->json($response);
        }
        
        $user = User::create([
            'name' => $request->store_name,
            'email' => $request->email,
            'phone' => $request->whatsapp,
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

        $restaurant->name = $request->store_name;
        $restaurant->whatsapp = $request->whatsapp;
        $restaurant->whats_token = $request->whats_token;
        $restaurant->whats_instance = $request->whats_instance;
        $restaurant->is_active = 1;
        $restaurant->status = 9;
        $restaurant->user_id = $user->id;
        $restaurant->is_accepted = 1;



       
        try {
            $restaurant->save();

            $user->restaurant_id = $restaurant->id; 
            $user->user_type='Store Owner';
            $user->restaurants()->sync($user->restaurant_id);
            $user->save();

            $user->assignRole('Store Owner');
            return redirect()->back()->with(['success' => 'Loja Salva com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }


/**
 * @param $id
 */
    public function getEditRestaurant($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();

        $dapCheck = false;
        if (\Module::find('DeliveryAreaPro') && \Module::find('DeliveryAreaPro')->isEnabled()) {
            $dapCheck = true;
        }

        $adminPaymentGateways = PaymentGateway::where('is_active', '1')->get();

        return view('admin.editRestaurant', array(
            'restaurant' => $restaurant,
            'restaurantCategories' => $restaurantCategories,
            'schedule_data' => json_decode($restaurant->schedule_data),
            'dapCheck' => $dapCheck,
            'adminPaymentGateways' => $adminPaymentGateways,
        ));
    }

/**
 * @param Request $request
 */
    public function updateRestaurant(Request $request)
    {
        // dd($request->all());
        $restaurant = Restaurant::where('id', $request->id)->first();

        if ($restaurant) {
            $restaurant->name = $request->name;
            $restaurant->description = $request->description;

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

            $restaurant->rating = $request->rating;
            $restaurant->delivery_time = $request->delivery_time;
            $restaurant->price_range = $request->price_range;

            if ($request->is_pureveg == 'true') {
                $restaurant->is_pureveg = true;
            } else {
                $restaurant->is_pureveg = false;
            }

            if ($request->is_featured == 'true') {
                $restaurant->is_featured = true;
            } else {
                $restaurant->is_featured = false;
            }

            $restaurant->certificate = $request->certificate;

            $restaurant->address = $request->address;
            $restaurant->pincode = $request->pincode;
            $restaurant->landmark = $request->landmark;
            $restaurant->latitude = $request->latitude;
            $restaurant->longitude = $request->longitude;

            $restaurant->restaurant_charges = $request->restaurant_charges;
            $restaurant->delivery_charges = $request->delivery_charges;
            $restaurant->commission_rate = $request->commission_rate;

            if ($request->has('delivery_type')) {
                $restaurant->delivery_type = $request->delivery_type;
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

            if ($request->is_schedulable == 'true') {
                $restaurant->is_schedulable = true;
            } else {
                $restaurant->is_schedulable = false;
            }

            if ($request->is_notifiable == 'true') {
                $restaurant->is_notifiable = true;
            } else {
                $restaurant->is_notifiable = false;
            }

            if ($request->auto_acceptable == 'true') {
                $restaurant->auto_acceptable = true;
            } else {
                $restaurant->auto_acceptable = false;
            }

            $restaurant->custom_message = $request->custom_message;

            try {
                if (isset($request->restaurant_category_restaurant)) {
                    $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
                }

                if ($request->store_payment_gateways == null) {
                    $restaurant->payment_gateways()->sync($request->store_payment_gateways);
                }

                if (isset($request->store_payment_gateways)) {
                    $restaurant->payment_gateways()->sync($request->store_payment_gateways);
                }

                $restaurant->save();

                try {

                    $restaurant->slug = Str::slug($request->store_url);
                    $restaurant->save();

                } catch (\Illuminate\Database\QueryException $qe) {
                    $errorCode = $qe->errorInfo[1];
                    if ($errorCode == 1062) {
                        return redirect()->back()->with(['message' => 'URL should be unique, it should not match with other store URLs']);
                    }
                    return redirect()->back()->with(['message' => $qe->getMessage()]);
                }
                // dd('here');
                // return redirect()->back()->with(['success' => 'Store Updated']);
                return redirect(route('admin.get.editRestaurant', $restaurant->id) . $request->window_redirect_hash)->with(['success' => 'Store Updated']);
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
public function getEditSeller($id)
{
    $restaurant = Restaurant::where('id', $id)->first();
    $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();

    $dapCheck = false;
    if (\Module::find('DeliveryAreaPro') && \Module::find('DeliveryAreaPro')->isEnabled()) {
        $dapCheck = true;
    }

    $adminPaymentGateways = PaymentGateway::where('is_active', '1')->get();

    return view('admin.editRestaurant', array(
        'restaurant' => $restaurant,
        'restaurantCategories' => $restaurantCategories,
        'schedule_data' => json_decode($restaurant->schedule_data),
        'dapCheck' => $dapCheck,
        'adminPaymentGateways' => $adminPaymentGateways,
    ));
}

/**
* @param Request $request
*/
public function updateSeller(Request $request)
{
    // dd($request->all());
    $restaurant = Restaurant::where('id', $request->id)->first();

    if ($restaurant) {
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;

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

        $restaurant->rating = $request->rating;
        $restaurant->delivery_time = $request->delivery_time;
        $restaurant->price_range = $request->price_range;

        if ($request->is_pureveg == 'true') {
            $restaurant->is_pureveg = true;
        } else {
            $restaurant->is_pureveg = false;
        }

        if ($request->is_featured == 'true') {
            $restaurant->is_featured = true;
        } else {
            $restaurant->is_featured = false;
        }

        $restaurant->certificate = $request->certificate;

        $restaurant->address = $request->address;
        $restaurant->pincode = $request->pincode;
        $restaurant->landmark = $request->landmark;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;

        $restaurant->restaurant_charges = $request->restaurant_charges;
        $restaurant->delivery_charges = $request->delivery_charges;
        $restaurant->commission_rate = $request->commission_rate;

        if ($request->has('delivery_type')) {
            $restaurant->delivery_type = $request->delivery_type;
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

        if ($request->is_schedulable == 'true') {
            $restaurant->is_schedulable = true;
        } else {
            $restaurant->is_schedulable = false;
        }

        if ($request->is_notifiable == 'true') {
            $restaurant->is_notifiable = true;
        } else {
            $restaurant->is_notifiable = false;
        }

        if ($request->auto_acceptable == 'true') {
            $restaurant->auto_acceptable = true;
        } else {
            $restaurant->auto_acceptable = false;
        }

        $restaurant->custom_message = $request->custom_message;

        try {
            if (isset($request->restaurant_category_restaurant)) {
                $restaurant->restaurant_categories()->sync($request->restaurant_category_restaurant);
            }

            if ($request->store_payment_gateways == null) {
                $restaurant->payment_gateways()->sync($request->store_payment_gateways);
            }

            if (isset($request->store_payment_gateways)) {
                $restaurant->payment_gateways()->sync($request->store_payment_gateways);
            }

            $restaurant->save();

            try {

                $restaurant->slug = Str::slug($request->store_url);
                $restaurant->save();

            } catch (\Illuminate\Database\QueryException $qe) {
                $errorCode = $qe->errorInfo[1];
                if ($errorCode == 1062) {
                    return redirect()->back()->with(['message' => 'URL should be unique, it should not match with other store URLs']);
                }
                return redirect()->back()->with(['message' => $qe->getMessage()]);
            }
            // dd('here');
            // return redirect()->back()->with(['success' => 'Store Updated']);
            return redirect(route('admin.get.editRestaurant', $restaurant->id) . $request->window_redirect_hash)->with(['success' => 'Store Updated']);
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
    public function saveNewSeller(Request $request)
    {
        // dd($request->all());

        $seller = new Seller();

        $seller->name = $request->name;
        $seller->restaurant_id = $request->store_id;
        

        try {
            $seller->save();
            
            return redirect()->back()->with(['success' => 'Vendedor Adicionado com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }

    }


/**
 * @param $id
 */
    public function disableSeller($id)
    {
        $item = Item::where('id', $id)->first();
        if ($item) {
            $item->toggleActive()->save();
            if (\Illuminate\Support\Facades\Request::ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->route('admin.items');
        }
    }



/**
 * @param $id
 */
    public function deleteSeller($id)
    {
        $seller = Seller::find($id);
        $seller->is_deleted=1;
        $seller->save();

        return redirect()->back()->with(['success' => 'Vendedor Excluído com Sucesso!']);
    }


    public function sellers()
    {

        $sellers = Seller::where('is_deleted',0)->orderBy('id', 'DESC')->get();
        //$count = $sellers->total();
        $stores = Restaurant::where('is_deleted',0)->orderBy('name', 'ASC')->get();

       

        return view('adm.sellers', array(
            'sellers' => $sellers,
            'stores'=> $stores,
            //'count' => $count,
            
        ));
    }

/**
 * @param Request $request
 */
    public function searchAddons(Request $request)
    {
        $query = $request['query'];

        $addons = Addon::where('name', 'LIKE', '%' . $query . '%')->with('addon_category')->paginate(20);

        $count = $addons->total();

        $addonCategories = AddonCategory::all();

        return view('admin.addons', array(
            'addons' => $addons,
            'count' => $count,
            'addonCategories' => $addonCategories,
        ));
    }


/**
 * @param $id
 */
    public function impersonate($id)
    {
        $user = User::where('id', $id)->first();
        if ($user && $user->hasRole('Store Owner')) {
            Auth::user()->impersonate($user);
            return redirect()->route('get.login');

            
        } else {
            return redirect()->route('admin.dashboard')->with(['message' => 'User not found']);
        }
    }

  

    public function sendPushNotificationStoreOwner($restaurant_id)
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
};
