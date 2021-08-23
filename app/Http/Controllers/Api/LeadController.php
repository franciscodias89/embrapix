<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
use App\Flyer;
use App\RestaurantCategory;
use Cache;
use DB;
use Spatie\JsonApiPaginate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\DeliveryAreaPro\DeliveryArea;
use Modules\SuperCache\SuperCache;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;




class LeadController extends Controller
{
    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    } 
   
   
       /**
     * @param Request $request
     */
    public function getAllCashBacks(Request $request)
    {
        
        $restaurants = Restaurant::where('is_accepted', '1')
            ->with('categories')
            ->where('cashback_percent', '!=', 0)
            ->where('cashback_active', 1)
            ->whereIn('id', $request->restaurantsIds)
            ->get();

        $response = $this->paginate($restaurants);

        return response()->json($response);

    }


         /**
     * @param Request $request
     */
    public function getCashBackAmountUser(Request $request)
    {
        $user = auth()->user();

        $cashbakana='0.00';
        $cashback_stores_total='0.00';
        $cashback_stores=[];
    /*     $cashback_stores=[
            [
                'id'=> 1,
                'name'=>'Supermercado Progresso',
                'amount'=>'45.36',
            ],
            [
                'id'=> 2,
                'name'=>'Supermercado Bergão',
                'amount'=>'15.25',
            ],
            [
                'id'=> 7,
                'name'=>'Farmácia DrogaLíder',
                'amount'=>'18.40',
            ],

        ]; */
        $response=[
            'cashbakana'=>$cashbakana,
            'cashback_stores_total'=>$cashback_stores_total,
            'cashback_stores'=>$cashback_stores,
        ];


       

        return response()->json($response);

    }

    

    
};
