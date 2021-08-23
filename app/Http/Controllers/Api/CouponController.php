<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Coupon;
use App\Order;
use App\RestaurantCategory;
use Cache;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;




class CouponController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
  
    
    /**
     * @param $name
     * @param $data
     */
    private function processSuperCache($name, $data = null)
    {
        if (Module::find('SuperCache') && Module::find('SuperCache')->isEnabled()) {
            $superCache = new SuperCache();
            $superCache->cacheResponse($name, $data);
        }
    }


          /**
     * @param Request $request
     */
    public function getAllCoupons(Request $request)
    {

        $restaurant_ids=$request->restaurantsIds;

          // get all active restauants doing delivery
         // if (Cache::has('coupons')) {
         //   $coupons = Cache::get('coupons');
        //} else {
            $coupons = Coupon::where('expiry_date', '>=',now())->where('is_deleted', 0)->where('is_active', 1)
                ->with('restaurants.categories')
                ->whereHas('restaurants', function ($query) use ($restaurant_ids) {
                    $query->whereIn('restaurants.id', $restaurant_ids );
                        })
                ->get();
            $this->processSuperCache('coupons', $coupons);
       // }


        
    return response()->json($this->paginate($coupons));
  

    }

      /**
     * @param Request $request
     */
    public function getCouponsBYRestaurantID(Request $request)
    {
        $restaurant_id=$request->restaurant_id;
        $coupons = Coupon::where('expiry_date', '>=',now())->where('is_deleted', 0)->where('is_active', 1)
        ->with('restaurants')
        ->whereHas('restaurants', function ($query) use ($restaurant_id) {
                $query->where('restaurants.id', $restaurant_id );
                })
        ->get();
        $coupons_list=$coupons->only(['id', 'name','description', 'code','discount_type', 'discount','expiry_date','is_active']);
    return response()->json($coupons);
  
    }
    

    /**
     * @param Request $request
     */
    public function applyCoupon(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            $response = [
                'success' => false,
                'type' => 'NOTLOGGEDIN',
            ];
            return response()->json($response);
        }

        $coupon = Coupon::where('code', $request->coupon)->first();

        if ($coupon && $coupon->is_active) {

            //check if coupon belongs to the restaurant
            if (in_array($request->restaurant_id, $coupon->restaurants()->pluck('restaurant_id')->toArray())) {
                //check if expirty date is correct
                if ($coupon->expiry_date->gt(Carbon::now()) && $coupon->count < $coupon->max_count) {
                    //check if min-subtotal is proper
                    if ($request->subtotal >= $coupon->min_subtotal) {
                        //get user orders
                        

                        if ($coupon->user_type == 'ONCE') {
                            $orderAlreadyPlacedWithCoupon = Order::where('user_id', $user->id)->where('coupon_name', $coupon->code)->first();
                            if ($orderAlreadyPlacedWithCoupon) {
                                $response = [
                                    'success' => false,
                                    'type' => 'ALREADYUSEDONCE',
                                    'message' => 'Este cupom só pode ser usado uma única vez por usuário!',
                                ];
                                return response()->json($response);
                            }
                        }
                        if ($coupon->user_type == 'ONCENEW') {
                            $orders_on_store= Order::where('restaurant_id',$request->restaurant_id)->where('user_id',$user->id)->get();
                            $userOrderCount = count($orders_on_store);
                            if ($userOrderCount != 0) {
                                $response = [
                                    'success' => false,
                                    'type' => 'FORNEWUSER',  
                                    'message' => 'Este cupom só pode ser usado em sua primeira compra neste estabelecimento!',
                                ];
                                return response()->json($response);
                            }
                        }
                        if ($coupon->user_type == 'CUSTOM') {
                            $orderAlreadyPlacedWithCoupon = Order::where('user_id', $user->id)->where('coupon_name', $coupon->code)->get()->count();
                            if ($orderAlreadyPlacedWithCoupon >= $coupon->max_count_per_user) {
                                $response = [
                                    'success' => false,
                                    'type' => 'MAXLIMITREACHEDPERUSER',
                                    'message' => 'Este cupom já atingiu o limite de Max limit reached for this coupon',
                                ];
                                return response()->json($response);
                            }
                        }
                        $coupon->success = true;
                        return response()->json($coupon);
                    } else {
                        $response = [
                            'success' => false,
                            'type' => 'MINSUBTOTAL',
                            'message' => $coupon->subtotal_message,
                        ];
                        return response()->json($response);
                    }

                } else {
                    $response = [
                        'success' => false,
                    ];
                    return response()->json($response);
                }
            } else {
                $response = [
                    'success' => false,
                ];
                return response()->json($response);
            }
        } else {
            $response = [
                'success' => false,
            ];
            return response()->json($response);
        }
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
