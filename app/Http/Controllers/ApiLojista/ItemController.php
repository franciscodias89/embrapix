<?php

namespace App\Http\Controllers\ApiLojista;

use App\Http\Controllers\Controller;
use App\Item;

use App\ItemCategory;
use App\Restaurant;
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
use Exception;
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
require_once(base_path('assets/fileuploader/src/php/class.fileuploader.php'));



class ItemController extends Controller
{
    public function paginate($items, $perPage = 30, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }


    /**
     * @param $slug
     */
    public function getRestaurantItems(Request $request)
    {
        $user = auth()->user();
        
        $items = Item::where('restaurant_id', $user->restaurant_id)
        ->join('item_categories', function ($join) {
            $join->on('items.item_category_id', '=', 'item_categories.id');
            
            $join->where('is_enabled', '1');
        })
        ->where('is_active', '1')
        ->with('addon_categories')
        ->with(array('addon_categories.addons' => function ($query) {
            $query->where('is_active', 1);
        }))
        ->orderBy('id','desc')
        ->get(array('items.*', 'item_categories.name as subcategory_name', 'item_categories.parent_id as category_parent_id', 'item_categories.id as category_id'));

           
      
        $items = json_decode($items, true);
        $nearMeItems= new Collection();

        


        if(count($items)>0){
        foreach ($items as $item) {
            $category=ItemCategory::where('id',$item['item_category_id'])->first();
            if($item['is_pizza']==1){
                $item_pizza=getItemPizza($item,$category);
                $nearMeItems->push($item_pizza);
            }else{
                

                if($item['old_price']=="0.00"){
                    $items_cat=getPriceFromAddons($item);
                    $nearMeItems->push($items_cat);
                }else{
                    $nearMeItems->push($item);
                }
                /* if($item['category_parent_id']== null){
                    $category_name=ItemCategory::select('name')->where('id',$item['category_id'])->first();
                    //var_dump($category_parent);
                    $item['item_category_id']=$item['category_id']; 
                    $item['category_name']=$category_name->name;  
                    $array[$item['category_name']][] = $item;
                }else{
                    $category_parent=ItemCategory::select('name')->where('id',$item['category_parent_id'])->first();
                    //var_dump($category_parent);  
                    $item['item_category_id']=$item['category_parent_id']; 
                    $item['category_parent']=$category_parent->name;    
                    $array[$item['category_parent']][] = $item;
                } */
            }
        }
       
    }

      return response()->json($this->paginate($nearMeItems));

    }


/**
     * @param Request $request
     */
    public function updateItem(Request $request)
    {
        $user = auth()->user();
        $restaurantId = $user->restaurant_id;

        $item = Item::where('id', $request->id)
            ->where('restaurant_id', $restaurantId)
            ->first();

        if ($item) {
            $item->name = $request->name;
            $item->restaurant_id = $restaurantId;
            $item->item_category_id = $request->item_category_id;
            $item->image = $request->image;
            $item->ean = $request->ean;
            $item->unidade = $request->unidade;
            $item->codint = $request->codint;
            $item->estoque = $request->estoque;
            $item->start_date = $request->start_date;
            $item->end_date = $request->end_date;
            
            
            if(!empty($request->price)){
                $item->price = formatPriceDBapp($request->price);
                $item->is_offer=1;
                $old_price=formatPriceDBapp($request->old_price);
                $price=formatPriceDBapp($request->price);
                $desconto=round((100*($old_price-$price))/$old_price);
                $item->desconto=$desconto;
                $item->old_price = formatPriceDBapp($request->old_price) == null ? 0 : formatPriceDBapp($request->old_price);
                if ($request->is_offer_notime == 1) {
                    $item->is_offer_notime = 1;
                } else {
                    $item->is_offer_notime = 0;
                }

            }else{
                $item->old_price = formatPriceDBapp($request->old_price) == null ? 0 : formatPriceDBapp($request->old_price);
                $item->is_offer=0;
                $item->price = null;
                $desconto=0;
                $item->desconto=$desconto;
                $item->is_offer_notime = 0;
                $item->start_date = null;
                $item->end_date = null;

            }

            if ($request->is_active == 1) {
                $item->is_active = true;
            } else {
                $item->is_active = false;
            }

            $item->desc = $request->desc;
            $item->long_desc = $request->long_desc;

            $addon_category_item=array();
            if($request->addons_categories){
                foreach($request->addons_categories as $addon){
                    $addon_category_item[]=$addon['id'];

                }
            }
            
     


            try {
                $item->save();
                if (isset($request->addons_categories)) {
                    $item->addon_categories()->sync($addon_category_item);
                }
                if ($request->remove_all_addons == '1') {
                    $item->addon_categories()->sync($addon_category_item);
                }
                return response()->json(['success'=>true]);
                
            } catch (\Illuminate\Database\QueryException $qe) {
                return response()->json(['error'=> $qe->getMessage()]);
            } catch (Exception $e) {
                return response()->json(['error'=> $e->getMessage()]);
            } catch (\Throwable $th) {
                return response()->json(['error'=> $th]);
            }
        }
    }

      /**
     * @param Request $request
     */
    public function searchProductsBYRestaurants(Request $request)
    {
        //get lat and lng and query from user...
        // get all active restauants doing delivery & selfpickup
       /*  $restaurants = Restaurant::where('name', 'LIKE', "%$request->q%")
            ->where('is_accepted', '1')
            ->take(20)->get(); */

            $user = auth()->user();
            $restaurant_id= $user->restaurant_id;

        $items = Item::
            where('name', 'LIKE', "%$request->q%")
            ->where('restaurant_id',$restaurant_id)
            ->with('restaurant')
            ->with('addon_categories')
            ->with(array('addon_categories.addons' => function ($query) {
                $query->where('is_active', 1);
            }))
            ->get();

        $response = [
            
            'items' => $items->take(20),
        ];
        return response()->json($this->paginate($items));
       

    }
  

    /**
     * @param Request $request
     */
    public function saveNewItem(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();
        $restaurant_id= $user->restaurant_id;
        $item = new Item();

        $item->name = $request->name;
        $item->restaurant_id = $restaurant_id;
        $item->item_category_id = $request->item_category_id;
        $item->ean = $request->ean;
        $item->codint = $request->codint;
        $item->unidade = $request->unidade;
        $item->start_date = $request->start_date;
        $item->end_date = $request->end_date;
        $item->image = $request->image;
        $item->desc = $request->desc;
        $item->estoque = $request->estoque;       
        

        if ($request->is_active == 1) {
            $item->is_active = 1;
        } else {
            $item->is_active = 0;
        }

        if(!empty($request->price)){
            $item->price = formatPriceDBapp($request->price);
            $item->is_offer=1;
            $old_price=formatPriceDBapp($request->old_price);
            $price=formatPriceDBapp($request->price);
            $desconto=round((100*($old_price-$price))/$old_price);
            $item->desconto=$desconto;
            $item->old_price = formatPriceDBapp($request->old_price) == null ? 0 : formatPriceDBapp($request->old_price);

           
    
            if ($request->is_offer_notime == 1) {
                $item->is_offer_notime = 1;
            } else {
                $item->is_offer_notime = 0;
            }
        }else{
            $item->old_price = formatPriceDBapp($request->old_price) == null ? 0 : formatPriceDBapp($request->old_price);
            $item->is_offer=0;
            $item->price = null;
            $desconto=0;
            $item->desconto=$desconto;
            $item->is_offer_notime = 0;
                $item->start_date = null;
                $item->end_date = null;
        }
        

        $addon_category_item=array();
        if($request->addons_categories){
            foreach($request->addons_categories as $addon){
                $addon_category_item[]=$addon['id'];

            }
        }

        try {
            $item->save();
            if (isset($request->addons_categories)) {
                $item->addon_categories()->sync($addon_category_item);
            }
            return response()->json(['success'=>true]);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }



};
