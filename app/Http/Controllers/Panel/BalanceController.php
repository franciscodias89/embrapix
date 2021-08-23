<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Flyer;
use App\Order;
use App\Restaurant;
use App\Safetransactions;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;
use FileUploader;


class BalanceController extends Controller
{
    
    public function balance()
    {
        $user = Auth::user();

        $restaurantId = $user->restaurant_id;
       
       /*  $orders = Order::where('restaurant_id', $restaurantId)
        ->orderBy('id', 'DESC')
        ->where('transaction_id','!=',null)
        ->get(); */

        $orders = Safetransactions::where('restaurant_id', $restaurantId)
        ->orderBy('id', 'DESC')
        ->get();

        $totalEarning = 0;
        
        foreach ($orders as $completedOrder) {
            $totalEarning += $completedOrder->Amount;// - ($completedOrder->delivery_charge + $completedOrder->tip_amount);
        }
       
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        $ordersCount = count($orders);

        $deposits = array();

        $agora = Carbon::now();
        return view('panel.balance', array(
            'ordersCount' => $ordersCount,
            'orders'=>$orders,
            'totalEarning' => $totalEarning,
            'agora'=> $agora,
            'deposits'=> $deposits,
            'restaurants' => $restaurant,
            'restaurant'=>$restaurant,
  
        ));
    }

    
}
