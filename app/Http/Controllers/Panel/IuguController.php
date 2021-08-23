<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Addon;
use App\AcceptDelivery;
use App\Coupon;
use App\Helpers\TranslationHelper;
use App\Iugu;
use App\IuguSubaccount;

use App\Order;
use App\Orderissue;
use App\Orderitem;
use App\OrderItemAddon;
use App\Orderstatus;
use App\PushNotify;
use App\Rating;
use App\Restaurant;
use App\Sms;
use App\User;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Omnipay\Omnipay;
use OneSignal;

class IuguController extends Controller
{

    

    /**
     * @param Request $request
     */
    public function CreateIuguSubAccount(Request $request)
    {
        $user = auth()->user();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
       
        $commissions=[
            'cents'=>25,
            'percent'=>1.5,
            'credit_card_cents'=>25,
            'credit_card_percent'=>1.5,
            'pix_cents'=>25,
            'pix_percent'=>1.5,
            'permit_aggregated'=>true,
        ];
        
        $data=[
            'name'=>$restaurant->name,
            'commissions'=>$commissions
        ];

        $test = new Iugu;
        $response=$test->criarSubconta($data); 
        $res=json_decode($response);
        if(isset($res->account_id)){

            
            $restaurant->account_iugu_id=$res->account_id;
            $restaurant->save();


       
        

        $iugu = IuguSubaccount::where('restaurant_id',$user->restaurant_id)->first();
        $iugu->account_id=$res->account_id;
        $iugu->user_token=$res->user_token;
        $iugu->live_api_token=$res->live_api_token;
        $iugu->test_api_token=$res->test_api_token;
        $iugu->is_verified=0;
        $iugu->bank_slip_cents=$res->commissions->bank_slip_cents;
        $iugu->bank_slip_percent=$res->commissions->bank_slip_percent;
        $iugu->cents=$res->commissions->cents;
        $iugu->credit_card_cents=$res->commissions->credit_card_cents;
        $iugu->comissions_id=$res->commissions->id;
        $iugu->pix_cents=$res->commissions->pix_cents;
        $iugu->pix_percent=$res->commissions->pix_percent;
        $iugu->recipient_account_id=$res->commissions->recipient_account_id;
        $iugu->split_id=$res->commissions->split_id;
        $iugu->save();
        }
        if(isset($res->errors)){
            $resp1=[
                'sucess'=>false,
                'data'=>$res
            ];
            return redirect()->back()->with(['message' => ''.$resp1.'']);;
        }




    }
}
