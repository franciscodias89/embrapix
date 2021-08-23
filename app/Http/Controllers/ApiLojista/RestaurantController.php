<?php

namespace App\Http\Controllers\ApiLojista;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\AddonCategory;
use App\Flyer;
use App\PromoSlider;
use App\Slide;
use App\RestaurantCategory;
use App\RestaurantRecommend;
use App\RestaurantApply;
use App\IuguSubaccount;
use Cache;
use DB;
use Auth;
use JWTAuth;
use JWTAuthException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\OpeningHours\OpeningHours;




class RestaurantController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }


    public function getRestaurantData(Request $request)
    {


        $user = auth()->user();
        $restaurant = Restaurant::where('id', $user->restaurant_id)
        ->first();
        $subaccount = IuguSubaccount::where('restaurant_id',$user->restaurant_id)->first();
        $restaurantCategories = RestaurantCategory::where('is_active', '1')->get();
        
        $addonCategories = AddonCategory::where('user_id', $user->id)->where('is_deleted', 0)->where('status', 1)->get();
        $itemCategories = ItemCategory::where('is_enabled', '1')
        ->where('user_id', $user->id)
        ->get();

        $response=[
            'success'=> true,
            'restaurant'=>$restaurant,
            'subaccount'=>$subaccount,
            'restaurantCategories'=>$restaurantCategories,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ];
        
       
            return response()->json($response);


    }



  



};
