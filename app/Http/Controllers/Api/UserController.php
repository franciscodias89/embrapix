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
use App\Address;
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
use App\Orderstatus;
use App\PushNotify;
use App\UserClaim;
use Hashids;
use Omnipay\Omnipay;
use OneSignal;
use Mail;



class UserController extends Controller
{
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
  

    public function userClaim(Request $request){
        $user = auth()->user();

        $userClaim= new UserClaim();
        $userClaim->type=$request->type;
        $userClaim->text=$request->text;
        $userClaim->name=$user->name;
        $userClaim->email=$user->email;
        $userClaim->phone=$user->phone;
        $userClaim->user_id=$user->id;
        $userClaim->store=$request->store;
        $userClaim->city=$request->city;
        $userClaim->state=$request->state;

        try {
            $userClaim->save();
           
            $response = [
                'success' => true,
                'message' => 'Registrado com Sucesso',
            ];
           // return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'error_code' => 'SWR', //Something Went Wrong
            ];
            
        }
        
        return response()->json($response);



    }




    
};
