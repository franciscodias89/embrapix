<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Order;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * @param Request $request
     */
    public function coupons(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();
       
        $coupons = Coupon::whereHas('restaurants', function($query) use ($restaurantIds) {
            $query->whereIn('restaurant_id', $restaurantIds);
        })->orderBy('id', 'DESC')->where('is_deleted',0)->get();

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurants = Restaurant::all();
        $todaysDate = Carbon::now()->format('m-d-Y');
        return view('panel.coupons', array(
            'coupons' => $coupons,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'todaysDate' => $todaysDate,
        ));
    }

        /**
     * @param Request $request
     */
    public function coupons_deleted(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();
       
        $coupons = Coupon::whereHas('restaurants', function($query) use ($restaurantIds) {
            $query->whereIn('restaurant_id', $restaurantIds);
        })->orderBy('id', 'DESC')->where('is_deleted',1)->get();

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurants = Restaurant::all();
        $todaysDate = Carbon::now()->format('m-d-Y');
        return view('panel.coupons', array(
            'coupons' => $coupons,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'todaysDate' => $todaysDate,
        ));
    }

         /**
     * @param Request $request
     */
    public function coupons_expired(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();
       
        $coupons = Coupon::whereHas('restaurants', function($query) use ($restaurantIds) {
            $query->whereIn('restaurant_id', $restaurantIds);
        })->orderBy('id', 'DESC')->where('is_deleted',0)->where('expiry_date','<', now())->get();

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurants = Restaurant::all();
        $todaysDate = Carbon::now()->format('m-d-Y');
        return view('panel.coupons', array(
            'coupons' => $coupons,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'todaysDate' => $todaysDate,
        ));
    }

             /**
     * @param Request $request
     */
    public function coupons_nonexpired(Request $request)
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();
       
        $coupons = Coupon::whereHas('restaurants', function($query) use ($restaurantIds) {
            $query->whereIn('restaurant_id', $restaurantIds);
        })->orderBy('id', 'DESC')->where('is_deleted', 0)->where('expiry_date','>=', now())->get();

        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        $restaurants = Restaurant::all();
        $todaysDate = Carbon::now()->format('m-d-Y');
        return view('panel.coupons', array(
            'coupons' => $coupons,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'todaysDate' => $todaysDate,
        ));
    }
  

    /**
     * @param Request $request
     */
    public function saveNewCoupon(Request $request)
    {   
        $user = Auth::user();
        $cod_coupon=strtoupper(str_random(20));
        $coupon_verify=Coupon::where('code',$cod_coupon)->first();
        if($coupon_verify){
            $cod_coupon=strtoupper(str_random(20));
        }else{
            $cod_coupon=$cod_coupon;
        }
//dd($cod_coupon);
        
        // dd($request->all());
        $coupon = new Coupon();

       
        
        

        if($request->user_type === 'ONCENEW'){
            if($request->discount_type === 'PERCENTAGE'){
                $description=''.$request->discount_percent.'% de desconto em compras acima de '.$request->min_subtotal.' (novos clientes)';
            }
            if($request->discount_type === 'AMOUNT'){
                $description='R$ '.$request->discount_amount.' de desconto em compras acima de '.$request->min_subtotal.' (novos clientes)';
            }
        }else{
            if($request->discount_type === 'PERCENTAGE'){
                $description=''.$request->discount_percent.'% de desconto em compras acima de '.$request->min_subtotal;
            }
            if($request->discount_type === 'AMOUNT'){
                $description='R$ '.$request->discount_amount.' de desconto em compras acima de '.$request->min_subtotal;
            }
        }
        $coupon->name = $description;
        $coupon->description = $description;
        $coupon->code = $cod_coupon;
        $coupon->discount_type = $request->discount_type;
        
        if($request->discount_type ==='AMOUNT'){
            $coupon->discount = str_replace(",",".", $request->discount_amount);  
        }else{
            $coupon->discount = $request->discount_percent;
        }
       


        $coupon->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d H:i:s');
        $coupon->restaurant_id = $user->restaurant_id;

        $coupon->max_count = $request->max_count;

        $coupon->min_subtotal =  str_replace(",",".", $request->min_subtotal);
        if ($request->discount_type == 'PERCENTAGE') {
            $coupon->max_discount = $request->max_discount;
        } else {
            $coupon->max_discount = null;
        }
        
        $coupon->subtotal_message = 'Cupom válido somente para compras acima de: R$ '.$coupon->min_subtotal;

        if ($request->is_active == 'on') {
            $coupon->is_active = true;
        } else {
            $coupon->is_active = false;
        }

        $coupon->user_type = $request->user_type;
        if ($request->user_type == 'CUSTOM') {
            $coupon->max_count_per_user = $request->max_count_per_user;
        }

        try {
            $coupon->save();
            $coupon->restaurants()->sync($user->restaurant_id);
            return redirect()->back()->with(['success' => 'Cupom Criado com Sucesso']);
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
    public function getEditCoupon($id)
    {
        $user = Auth::user();
        $coupon = Coupon::where('id', $id)->first();
        $restaurants = Restaurant::all();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        if ($coupon) {
            return view('panel.editCoupon', array(
                'coupon' => $coupon,
                'restaurants' => $restaurants,
                'restaurant'=>$restaurant,

            ));
        }
        return redirect()->route('panel.coupons');
    }

    /**
     * @param Request $request
     */
    public function updateCoupon(Request $request)
    {
        $user = Auth::user();
        $coupon = Coupon::where('id', $request->id)->first();

        if ($coupon) {

         
//dd($cod_coupon);
        
        // dd($request->all());
      

       
        
        

        if($request->user_type === 'ONCENEW'){
            if($request->discount_type === 'PERCENTAGE'){
                $description=''.$request->discount_percent.'% de desconto em compras acima de '.$request->min_subtotal.' (novos clientes)';
            }
            if($request->discount_type === 'AMOUNT'){
                $description='R$ '.$request->discount_amount.' de desconto em compras acima de '.$request->min_subtotal.' (novos clientes)';
            }
        }else{
            if($request->discount_type === 'PERCENTAGE'){
                $description=''.$request->discount_percent.'% de desconto em compras acima de '.$request->min_subtotal;
            }
            if($request->discount_type === 'AMOUNT'){
                $description='R$ '.$request->discount_amount.' de desconto em compras acima de '.$request->min_subtotal;
            }
        }
        $coupon->name = $description;
        $coupon->description = $description;
       
        $coupon->discount_type = $request->discount_type;
        
        if($request->discount_type ==='AMOUNT'){
            $coupon->discount = str_replace(",",".", $request->discount_amount);  
        }else{
            $coupon->discount = $request->discount_percent;
        }
       


        $coupon->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d H:i:s');
        $coupon->restaurant_id = $user->restaurant_id;

        $coupon->max_count = $request->max_count;

        $coupon->min_subtotal =  str_replace(",",".", $request->min_subtotal);
        if ($request->discount_type == 'PERCENTAGE') {
            $coupon->max_discount = $request->max_discount;
        } else {
            $coupon->max_discount = null;
        }
        
        $coupon->subtotal_message = 'Cupom válido somente para compras acima de: R$ '.$coupon->min_subtotal;

        if ($request->is_active == 'on') {
            $coupon->is_active = true;
        } else {
            $coupon->is_active = false;
        }

        $coupon->user_type = $request->user_type;
        if ($request->user_type == 'CUSTOM') {
            $coupon->max_count_per_user = $request->max_count_per_user;
        }

        try {
            $coupon->save();
            $coupon->restaurants()->sync($user->restaurant_id);
                return redirect()->back()->with(['success' => 'Cupom Atualizado com Sucesso!']);
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
