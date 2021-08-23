<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Order;
use App\User;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * @param Request $request
     */
    public function customers(Request $request)
    {
        $user = Auth::user();
        $restaurant_id = $user->restaurant_id;
        $orders = Order::where('restaurant_id', $restaurant_id)->orderBy('id', 'DESC')->get();

            foreach($orders as $order){
                $customers[]=User::where('id',$order->user_id)->first();
            }

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
        
        return view('panel.list', array(
            'customers' => $customers,
            'title'=>'Clientes',
            
            'restaurant'=>$restaurant,
            
        ));
    }

      
    /**
     * @param $id
     */
    public function deleteCoupon($id)
    {
        $coupon = Coupon::where('id', $id)->first();

        if ($coupon) {
            $coupon->is_deleted=1;
            $coupon->is_active=0;
            $coupon->save();
            return redirect()->back()->with(['success' => 'Cupom Excluído com Sucesso']);
        }
        return redirect()->route('panel.coupons');
    }
    
      /**
     * @param $id
     */
    public function restoreCoupon($id)
    {
        $coupon = Coupon::where('id', $id)->first();

        if ($coupon) {
            $coupon->is_deleted=0;
            $coupon->is_active=1;
            $coupon->save();
            return redirect()->back()->with(['success' => 'Cupom Restaurado com Sucesso']);
        }
        return redirect()->route('panel.coupons');
    }

}
