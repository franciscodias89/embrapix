<?php

namespace App\Http\Controllers\Webhooks;

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


class WebhooksController extends Controller
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
    public function webhookTransactionSafe2pay(Request $request)
    {

        $safetransaction= Safetransactions::where('IdTransaction',$request->IdTransaction)->first();
        $safetransaction->Status=number_format($request->TransactionStatus['Code']);
        $safetransaction->Message=$request->TransactionStatus['Name'];
       // $safetransaction->PaymentDate=strtotime($request->PaymentDate);
       // $safetransaction->CreatedDate=strtotime($request->IncluedDate);
        $safetransaction->Amount=$request->Amount;
        $safetransaction->NetValue=$request->NetValue;
        $safetransaction->TaxValue=$request->TaxValue;
        $safetransaction->NegotiationTax=$request->NegotiationTax;
        $safetransaction->IsTransferred=$request->IsTransferred;
        $safetransaction->ReleaseDate=strtotime($request->ReleaseDate);
        $safetransaction->PaymentMethod=$request->PaymentMethod['Code'];
        $safetransaction->save();



    }





    
};
