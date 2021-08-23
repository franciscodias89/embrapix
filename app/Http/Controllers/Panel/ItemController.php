<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Addon;
use App\AddonCategory;
use App\Helpers\TranslationHelper;
use App\Item;
use App\IuguSubaccount;
use App\ItemCategory;
use App\Flyer;
use App\FlyerRestaurant;
use App\Order;
use App\PaymentGateway;
use App\PizzaFlavor;
use App\PizzaPrice;
use App\PizzaSize;
use App\PushNotify;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantEarning;
use App\RestaurantPayout;
use App\Sms;
use App\StorePayoutDetail;
use App\User;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Image;
use Modules\ThermalPrinter\Entities\PrinterSetting;
use Modules\ThermalPrinter\Entities\ThermalPrinter;
use Nwidart\Modules\Facades\Module;
use OneSignal;
use FileUploader;

require_once(base_path('assets/fileuploader/src/php/class.fileuploader.php'));

class ItemController extends Controller
{
  
    public function items()
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $items = Item::whereIn('restaurant_id', $restaurantIds)
            ->orderBy('id', 'DESC')
            ->where('is_deleted', 0)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itemsActive()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

        $items = Item::where('restaurant_id', $restaurant_id)
            ->orderBy('id', 'DESC')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itemsInActive()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

        $items = Item::where('restaurant_id', $restaurant_id)
            ->orderBy('id', 'DESC')
            ->where('is_deleted', 0)
            ->where('is_active', 0)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itensDeleted()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

        $items = Item::where('restaurant_id', $restaurant_id)
            ->orderBy('id', 'DESC')
            ->where('is_deleted', 1)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itemsWithoutImage()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

        $items = Item::where('restaurant_id', $restaurant_id)
            ->orderBy('id', 'DESC')
            ->where('image', null)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itemsOffer()
    {
        $user = Auth::user();

        $restaurant_id = $user->restaurant_id;

        $items = Item::where('restaurant_id', $restaurant_id)
            ->orderBy('id', 'DESC')
            ->where('price', '!=', null)
            ->with('item_category', 'restaurant')
            ->get();



            $agora = Carbon::now();
            //dd($flyers);
             $items2=array();
             foreach($items as $item){

                if(($item->is_offer_notime ==1)){
                    $items2[]=$item;

                }elseif(date('d/m/Y' ,strtotime($item->start_date)) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($item->end_date)) >=date('d/m/Y' ,strtotime($agora)) && $item->price!=null )
                {
                    $items2[]=$item;

                }
                 
             }





        $count = count($items2);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', Auth::user()->id)
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.items', array(
            'items' => $items2,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }

    public function itemsCardapio()
    {
        $user = Auth::user();

        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $items = Item::whereIn('restaurant_id', $restaurantIds)
            ->orderBy('id', 'DESC')
            ->where('is_deleted', 0)
            ->with('item_category', 'restaurant')
            ->get();

        $count = count($items);

        $restaurants = $user->restaurants;
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        $itemCategories = ItemCategory::where('is_enabled', '1')
            ->where('user_id', $user->id)
            ->where('is_deleted', 0)
            ->with('items')
            ->orderBy('id','DESC')
            ->get();
        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.itemsCardapio', array(
            'items' => $items,
            'count' => $count,
            'agora'=> $agora,
            'manage_stock'=>$manage_stock,
            'restaurants' => $restaurants,
            'restaurant'=>$restaurant,
            'itemCategories' => $itemCategories,
            'addonCategories' => $addonCategories,
        ));
    }


    public function geteditPizzaCategory($id)
    {
        $user = Auth::user();

       
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        

        $itemCategory = ItemCategory::where('id', $id)->first();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->get();
        $agora = Carbon::now();
        return view('panel.editPizzaCategory', array(
            'item_category' => $itemCategory,
      
            'restaurant'=>$restaurant,
            
            'addonCategories' => $addonCategories,
        ));
    }


    public function getAjaxPizzaSizesFromCategory($id)
    {
        $pizza_sizes=PizzaSize::where('item_category_id',$id)->get();

        
        return json_encode($pizza_sizes);
    }

    public function getAjaxPizzaSizesFromID($id)
    {
        $pizza_sizes=PizzaSize::where('id',$id)->get();

        
        return json_encode($pizza_sizes);
    }

    public function getAjaxPizzaPricesFromCategory($id)
    {
        $pizza_sizes=PizzaPrice::where('item_category_id',$id)->get();

        
        return json_encode($pizza_sizes);
    }


    /**
     * @param Request $request
     */
    public function saveNewFlavor(Request $request)
    {
        $user = Auth::user();
        $restaurant_id= $user->restaurant_id;
        $item = new PizzaFlavor();

        $item->flavor = $request->name;
        $item->cod_pdv = $request->codint;
        $item->cod_pdv = $request->codint;

        if ($request->status == 'on') {
            $item->status = 1;
        } else {
            $item->status = 0;
        }
       
        $item->restaurant_id = $restaurant_id;
        $item->item_category_id = $request->item_category_id;

        if($request->file_output){
            $image = $request->file_output;

            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $image = base64_decode($image);
            //$image = base64_decode($request->file_output);
            $rand_name = time() . str_random(10);
            $filename = $rand_name . '.jpg';
                $width = 300;
                $height = 300;
                
                $img = Image::make($image);
                
                /* // we need to resize image, otherwise it will be cropped 
                if ($img->width() > $width) { 
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                
                if ($img->height() > $height) {
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    }); 
                }
                $img->resizeCanvas($width, $height, 'center', false, '#ffffff'); */
                $img->save(base_path('assets/img/items/' . $filename),config('settings.uploadImageQuality '), 'jpg');

           $item->image = '/assets/img/items/' . $filename;
        }
       
        if(!empty($request->imagem_banco)){
            $item->image=$request->imagem_banco;
        }
        
        $item->description = $request->desc;

        try {
            $item->save();

            if ($request->has('pizza_size_id')) {
                foreach ($request->pizza_size_id as $key => $pizza_size_id) {

                    $size = new PizzaPrice();
                    $size->price = formatPriceDB($request->prices[$key]);
                    $size->item_category_id = $item->item_category_id;
                    $size->restaurant_id = $restaurant_id;
                    $size->pizza_size_id = $pizza_size_id;
                    $size->status = 1;
                    $size->pizza_flavor_id = $item->id;

                    $size->save();
                }
            }
            /* if (isset($request->addon_category_item)) {
                $item->addon_categories()->sync($request->addon_category_item);
            } */
            return redirect()->back()->with(['success' => 'Sabor Salvo com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

    /**
     * @param Request $request
     */
    public function updateFlavor(Request $request)
    {
        $user = Auth::user();
        $restaurant_id= $user->restaurant_id;
        $item = PizzaFlavor::where('id',$request->id)->first();

        $item->flavor = $request->name;
        $item->cod_pdv = $request->codint;
        $item->cod_pdv = $request->codint;

        if ($request->status == 'on') {
            $item->status = 1;
        } else {
            $item->status = 0;
        }
       
        $item->restaurant_id = $restaurant_id;
        $item->item_category_id = $request->item_category_id;

        if($request->file_output){
            $image = $request->file_output;

            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $image = base64_decode($image);
            //$image = base64_decode($request->file_output);
            $rand_name = time() . str_random(10);
            $filename = $rand_name . '.jpg';
                $width = 300;
                $height = 300;
                
                $img = Image::make($image);
                
              
                $img->save(base_path('assets/img/items/' . $filename),config('settings.uploadImageQuality '), 'jpg');


            $item->image = '/assets/img/items/' . $filename;
        }

        if(!empty($request->imagem_banco)){
            $item->image=$request->imagem_banco;
        }
        
        $item->description = $request->desc;

        try {
            $item->save();

            if ($request->has('pizza_size_id')) {
                foreach ($request->pizza_size_id as $key => $pizza_size_id) {

                    $size = PizzaPrice::where('pizza_flavor_id',$item->id)->first();
                    $size->price = $request->prices[$key];
                    $size->item_category_id = $item->item_category_id;
                    $size->restaurant_id = $restaurant_id;
                    $size->pizza_size_id = $pizza_size_id;
                    $size->status = 1;
                    $size->pizza_flavor_id = $item->id;

                    $size->save();
                }
            }
            /* if (isset($request->addon_category_item)) {
                $item->addon_categories()->sync($request->addon_category_item);
            } */
            return redirect()->back()->with(['success' => 'Sabor Salvo com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }


    /**
     * @param Request $request
     */
    public function saveNewPizzaCategory(Request $request)
    {
        $user = Auth::user();
        $restaurant_id= $user->restaurant_id;

        $category= new ItemCategory();
        $category->name =$request->name;
        $category->user_id =$user->id;
        $category->pizza_more_flavors=$request->pizza_more_flavors;
        $category->is_pizza=1;
        
        try {

        $category->save();

        if ($request->has('pizza_sizes')) {
            foreach ($request->pizza_sizes as $key => $pizza_size) {

                

               


                $size = new PizzaSize();
                $size->size = $pizza_size;
                $size->item_category_id = $category->id;
                $size->restaurant_id = $restaurant_id;
                $size->status = 1;
                $size->slices = $request->slices[$key];
                $size->product_id = null;
                $size->flavors_qty = $request->flavors_qty[$key];
                $size->cod_pdv = $request->cod_pdv[$key];
                
                $size->save();

                for ($i = 1; $i <= $size->flavors_qty; $i++) {

                    $item= new Item();
                    if($i==1){
                        $item->name='Pizza '.$pizza_size.' ('.$i.' Sabor)';
                    }else{
                        $item->name='Pizza '.$pizza_size.' ('.$i.' Sabores)';
                    }
                    
                    $item->ean=$request->cod_pdv[$key];
                    $item->codint=$request->cod_pdv[$key];
                    $item->is_active=1;
                    $item->item_category_id=$category->id;
                    $item->is_pizza=1;
                    $item->restaurant_id=$restaurant_id;
                    $item->unidade="un";
                    $item->pizza_size_id=$size->id;
                    $item->pizza_flavors=$i;
                    $item->old_price=0.00;
                    $item->save();  

                    if (isset($request->addon_category_item)) {
                        $item->addon_categories()->sync($request->addon_category_item);
                    } 

                }

               
                
            }
        }

             if (isset($request->addon_category_item)) {
                $item->addon_categories()->sync($request->addon_category_item);
            } 
            return redirect()->back()->with(['success' => 'Categoria Salva com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

    /**
     * @param Request $request
     */
    public function updatePizzaCategory(Request $request)
    {
        $user = Auth::user();
        $restaurant_id= $user->restaurant_id;

        $category= ItemCategory::where('id', $request->id)->first();;
        $category->name =$request->name;
        $category->is_pizza=1;
        
        try {

        $category->save();

        $pizza_sizes_old = $request->input('edit_old');
        if ($request->has('edit_old')) {

            foreach ($pizza_sizes_old as $ad) {
                $pizza_sizes_old_update = PizzaSize::find($ad['id']);
                $pizza_sizes_old_update->size = $ad['pizza_sizes'];
                $pizza_sizes_old_update->item_category_id = $category->id;
                $pizza_sizes_old_update->restaurant_id = $restaurant_id;
                $pizza_sizes_old_update->status = 1;
                $pizza_sizes_old_update->slices = $ad['slices'];
                $pizza_sizes_old_update->flavors_qty = $ad['flavors_qty'];
                $pizza_sizes_old_update->cod_pdv = $ad['cod_pdv'];
               // $pizza_sizes_old_update->user_id = Auth::user()->id;
                $pizza_sizes_old_update->save();

                for ($i = 1; $i <= $pizza_sizes_old_update->flavors_qty; $i++) {

                    $item= Item::where('pizza_size_id',$pizza_sizes_old_update->id)->where('pizza_flavors',$i)->first();
                    if($i==1){
                        $item->name='Pizza '.$pizza_sizes_old_update->size.' ('.$i.' Sabor)';
                    }else{
                        $item->name='Pizza '.$pizza_sizes_old_update->size.' ('.$i.' Sabores)';
                    }

                
                $pizza_size=$pizza_sizes_old_update->size;
                
                $item->ean=$pizza_sizes_old_update->cod_pdv;
                $item->codint=$pizza_sizes_old_update->cod_pdv;
                $item->is_active=1;
                $item->item_category_id=$category->id;
                $item->is_pizza=1;
                $item->unidade="un";
                $item->old_price=0.00;
                $item->save();

                if (isset($request->addon_category_item)) {
                    $item->addon_categories()->sync($request->addon_category_item);
                } 

            }

            }
        }

    



        if ($request->has('pizza_sizes')) {
            foreach ($request->pizza_sizes as $key => $pizza_size) {

                
                $size = new PizzaSize();
                $size->size = $pizza_size;
                $size->item_category_id = $category->id;
                $size->restaurant_id = $restaurant_id;
                $size->status = 1;
                $size->slices = $request->slices[$key];
                $size->product_id = null;
                $size->flavors_qty = $request->flavors_qty[$key];
                $size->cod_pdv = $request->cod_pdv[$key];
                
                $size->save();

                for ($i = 1; $i <= $size->flavors_qty; $i++) {

                    $item= new Item();
                    if($i==1){
                        $item->name='Pizza '.$pizza_size.' ('.$i.' Sabor)';
                    }else{
                        $item->name='Pizza '.$pizza_size.' ('.$i.' Sabores)';
                    }
                    
                    $item->ean=$request->cod_pdv[$key];
                    $item->codint=$request->cod_pdv[$key];
                    $item->is_active=1;
                    $item->item_category_id=$category->id;
                    $item->is_pizza=1;
                    $item->restaurant_id=$restaurant_id;
                    $item->unidade="un";
                    $item->pizza_size_id=$size->id;
                    $item->pizza_flavors=$i;
                    $item->old_price=0.00;
                    $item->save();  

                    if (isset($request->addon_category_item)) {
                        $item->addon_categories()->sync($request->addon_category_item);
                    } 

                }
            }
        }

            /* if (isset($request->addon_category_item)) {
                $item->addon_categories()->sync($request->addon_category_item);
            } */
            return redirect()->back()->with(['success' => 'Categoria Atualizada com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }


    /**
     * @param Request $request
     */
    public function saveNewItem(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $restaurant_id= $user->restaurant_id;
        $item = new Item();

        $item->name = $request->name;
        $item->ean = $request->ean;
        $item->codint = $request->codint;
        
        $item->start_date = $request->start_date;
        $item->end_date = $request->end_date;
        
        if ($request->is_active == 'on') {
            $item->is_active = 1;
        } else {
            $item->is_active = 0;
        }
if($request->is_product_variable=='on'){
    $item->unidade = 'un';
    $item->price=0.00;
    $item->old_price=0.00;
    $item->is_offer_notime = 0;
    $item->product_variable = 1;

    $addonCategory = new AddonCategory();

        $addonCategory->name = 'Escolha uma Variação';
        $addonCategory->type = 'SINGLE';
        $addonCategory->user_id = $user->id;
        $addonCategory->status = true;
        $addonCategory->is_product_variable=true;
        $addonCategory->save();
        if ($request->has('addon_names')) {
            foreach ($request->addon_names as $key => $addon_name) {
                $addon = new Addon();
                $addon->name = $addon_name;
                $addon->description = $request->addon_description[$key];
                $addon->price = $request->addon_prices[$key];
                $addon->addon_category_id = $addonCategory->id;
                $addon->user_id = $user->id;
                $addon->save();
            }
        }
        
        $addon_category_item=[$addonCategory->id];

        $item->addon_category_price_variable_id=$addonCategory->id;


}else{
    $item->unidade = $request->unidade;
        if(!empty($request->price)){
            $item->price = formatPriceDB($request->price);
            $item->is_offer=1;
            $old_price=formatPriceDB($request->old_price);
            $price=formatPriceDB($request->price);
            $desconto=round((100*($old_price-$price))/$old_price);
            $item->desconto=$desconto;
            $item->old_price = formatPriceDB($request->old_price) == null ? 0 : formatPriceDB($request->old_price);

           
    
            if ($request->is_offer_notime == 'on') {
                $item->is_offer_notime = 1;
            } else {
                $item->is_offer_notime = 0;
            }
        }else{
            $item->old_price = formatPriceDB($request->old_price) == null ? 0 : formatPriceDB($request->old_price);
            $item->is_offer=0;
            $item->price = null;
            $desconto=0;
            $item->desconto=$desconto;
            $item->is_offer_notime = 0;
                $item->start_date = null;
                $item->end_date = null;
        }

    }
       
        $item->restaurant_id = $restaurant_id;
        $item->item_category_id = $request->item_category_id;


          
        if($request->file_output){
            $image = $request->file_output;

            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $image = base64_decode($image);
            //$image = base64_decode($request->file_output);
            $rand_name = time() . str_random(10);
            $filename = $rand_name . '.jpg';
                $width = 300;
                $height = 300;
                
                $img = Image::make($image);
                
                /* // we need to resize image, otherwise it will be cropped 
                if ($img->width() > $width) { 
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                
                if ($img->height() > $height) {
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    }); 
                }
                
                $img->resizeCanvas($width, $height, 'center', false, '#ffffff'); */
                $img->save(base_path('assets/img/items/' . $filename),config('settings.uploadImageQuality '), 'jpg');








            $item->image = '/assets/img/items/' . $filename;
        }
       

        if(!empty($request->imagem_banco)){
            $item->image=$request->imagem_banco;
        }

        
        $item->desc = $request->desc;
        if(isset($request->estoque)){
            $item->estoque = $request->estoque;
        }
        
        $item->is_deleted = 0;

     /* 
        $configuration = [
            'limit' => 1,
            'fileMaxSize' => 10,
            'extensions' => ['image/*'],
            'title' => 'auto',
            'uploadDir' => base_path('assets/img/items/'),
            'replace' => false,
            'editor' => [
                'maxWidth' => 500,
                'maxHeight' => 500,
                'crop' => false,
                'quality' => 60
            ]
        ];
        
        if (isset($_POST['fileuploader']) && isset($_POST['name'])) {
            $name = str_replace(array('/', '\\'), '', $_POST['name']);
            $editing = isset($_POST['editing']) && $_POST['editing'] == true;
            
            if (is_file($configuration['uploadDir'] . $name)) {
                $configuration['title'] = $name;
                $configuration['replace'] = true;
            }
        }
    
        // initialize FileUploader
        $FileUploader = new FileUploader('files', $configuration);
        
        // call to upload the files
        $data = $FileUploader->upload(); */
        
        // change file's public data
  /*       if ($request->file) {
            $item2 = $data['files'][0];
            
            $data['files'][0] = array(
                'title' => $item2['title'],
                'name' => $item2['name'],
                'size' => $item2['size'],
                'size2' => $item2['size2']
            );
            $item->image = '/assets/img/items/'.$item2['name'];


            $width = 200;
            $height = 200;
            
            $img = Image::make(base_path('assets/img/items/' . $item2['name']));
            
            // we need to resize image, otherwise it will be cropped 
            if ($img->width() > $width) { 
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            
            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            
            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            $img->save(base_path('assets/img/items/teste/' . $item2['name']));










        }else{

            if($_POST['fileuploader-list-files']!='[]'){
                $imagem=$_POST['fileuploader-list-files'];
                $logo1=json_decode($imagem);
                $logo=$logo1[0]->file;
                $item->image=$logo;
            }
            $item->image=null;
        }
    // export to js
    header('Content-Type: application/json');
    echo json_encode($data);

    //} */

  

        try {
            $item->save();
            if (isset($addon_category_item)) {
                $item->addon_categories()->sync($addon_category_item);
            }
            if (isset($request->addon_category_item)) {
                $item->addon_categories()->sync($request->addon_category_item);
            }
            return redirect()->back()->with(['success' => 'Produto Salvo com Sucesso']);
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect()->back()->with(['message' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message' => $th]);
        }
    }

     /**
     * @param Request $request
     */
    public function updateItem(Request $request)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $item = Item::where('id', $request->id)
            ->whereIn('restaurant_id', $restaurantIds)
        
            ->first();

        if ($item) {
            $item->name = $request->name;
            $item->restaurant_id = $request->restaurant_id;
            $item->item_category_id = $request->item_category_id;

           /*  if ($request->image == null) {
                $item->image = $request->old_image;
            } else {
                $image = $request->file('image');
                $rand_name = time() . str_random(10);
                $filename = $rand_name . '.jpg';
                Image::make($image)
                    ->resize(486, 355)
                    ->save(base_path('assets/img/items/' . $filename), config('settings.uploadImageQuality '), 'jpg');
                $item->image = '/assets/img/items/' . $filename;
            } */

            $item->ean = $request->ean;
            $item->unidade = $request->unidade;
            $item->codint = $request->codint;
            $item->estoque = $request->estoque;
            $item->start_date = $request->start_date;
            $item->end_date = $request->end_date;
            
            
          /*   if(!empty($request->price)){
                $item->price = str_replace(",",".", $request->price);
                $item->is_offer=1;
                $old_price=str_replace(",",".", $request->old_price);
                $price=str_replace(",",".", $request->price);
                $desconto=round((100*($old_price-$price))/$old_price);
                $item->desconto=$desconto;
                $item->old_price = str_replace(",",".", $request->old_price) == null ? 0 : str_replace(",",".", $request->old_price);
            }else{
                $item->old_price = str_replace(",",".", $request->old_price) == null ? 0 : str_replace(",",".", $request->old_price);
                $item->is_offer=0;
                $desconto=0;
                $item->price=null;
                $item->desconto=$desconto;
            } */
            if($request->is_product_variable=='on'){
                $item->unidade = 'un';
                $item->price=0.00;
                $item->old_price=0.00;
                $item->is_offer_notime = 0;
                $item->product_variable = 1;
            
                $addonCategory_id = $item->addon_category_price_variable_id;
                //$addonCategory=AddonCategory::where('id',$addonCategory_id)->first();
            

                    
                $addons_old = $request->input('addon_old');
                if ($request->has('addon_old')) {
                    foreach ($addons_old as $ad) {
                        $addon_old_update = Addon::find($ad['id']);
                        $addon_old_update->name = $ad['name'];
                        $addon_old_update->price = str_replace(",",".", $ad['price']);
                        $addon_old_update->user_id = $user->id;
                        $addon_old_update->save();
                    }
                }

                if ($request->addon_names) {
                    foreach ($request->addon_names as $key => $addon_name) {
                        $addon = new Addon();
                        $addon->name = $addon_name;
                        $addon->price =  str_replace(",",".", $request->addon_prices[$key]);
                        $addon->addon_category_id = $addonCategory_id;
                        $addon->user_id = $user->id;
                        $addon->save();
                    }
                }
                    
                    $addon_category_item=[$addonCategory_id];
            
            
            }else{
            if(!empty($request->price)){
                $item->price = formatPriceDB($request->price);
                $item->is_offer=1;
                $old_price=formatPriceDB($request->old_price);
                $price=formatPriceDB($request->price);
                $desconto=round((100*($old_price-$price))/$old_price);
                $item->desconto=$desconto;
                $item->old_price = formatPriceDB($request->old_price) == null ? 0 : formatPriceDB($request->old_price);
                if ($request->is_offer_notime == 'on') {
                    $item->is_offer_notime = 1;
                } else {
                    $item->is_offer_notime = 0;
                }

            }else{
                $item->old_price = formatPriceDB($request->old_price) == null ? 0 : formatPriceDB($request->old_price);
                $item->is_offer=0;
                $item->price = null;
                $desconto=0;
                $item->desconto=$desconto;
                $item->is_offer_notime = 0;
                $item->start_date = null;
                $item->end_date = null;

            }
        }

            if ($request->is_active == 'on') {
                $item->is_active = true;
            } else {
                $item->is_active = false;
            }

         

            $item->desc = $request->desc;


         /*    if (isset($_POST['fileuploader-list-files'])){

                $imagem=$_POST['fileuploader-list-files'];
                $logo1=json_decode($imagem);
                $logo=$logo1[0]->file;
                $item->image=$logo;
    
            }else{ */
    
                if($request->file_output){
                    $image = $request->file_output;

                    list($type, $image) = explode(';', $image);
                    list(, $image)      = explode(',', $image);
                    $image = base64_decode($image);
                    //$image = base64_decode($request->file_output);
                    $rand_name = time() . str_random(10);
                    $filename = $rand_name . '.jpg';
                        $width = 300;
                        $height = 300;
                        
                        $img = Image::make($image);
                        
                        /* // we need to resize image, otherwise it will be cropped 
                        if ($img->width() > $width) { 
                            $img->resize($width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        
                        if ($img->height() > $height) {
                            $img->resize(null, $height, function ($constraint) {
                                $constraint->aspectRatio();
                            }); 
                        }
                        
                        $img->resizeCanvas($width, $height, 'center', false, '#ffffff'); */
                        $img->save(base_path('assets/img/items/' . $filename),config('settings.uploadImageQuality '), 'jpg');
        
        
        
        
        
        
        
        
                    $item->image = '/assets/img/items/' . $filename;
                }
    
                if(!empty($request->imagem_banco)){
                    $item->image=$request->imagem_banco;
                }
            
         /* 
            $configuration = [
                'limit' => 1,
                'fileMaxSize' => 10,
                'extensions' => ['image/*'],
                'title' => 'auto',
                'uploadDir' => base_path('assets/img/items/'),
                'replace' => false,
                'editor' => [
                    'maxWidth' => 170,
                    'maxHeight' => 170,
                    'crop' => false,
                    'quality' => 60
                ]
            ];
            
            if (isset($_POST['fileuploader']) && isset($_POST['name'])) {
                $name = str_replace(array('/', '\\'), '', $_POST['name']);
                $editing = isset($_POST['editing']) && $_POST['editing'] == true;
                
                if (is_file($configuration['uploadDir'] . $name)) {
                    $configuration['title'] = $name;
                    $configuration['replace'] = true;
                }
            }
        
            // initialize FileUploader
            $FileUploader = new FileUploader('files', $configuration);
            
            // call to upload the files
            $data = $FileUploader->upload();
            
            // change file's public data
            if (!empty($data['files'])) {
                $item2 = $data['files'][0];
                
                $data['files'][0] = array(
                    'title' => $item2['title'],
                    'name' => $item2['name'],
                    'size' => $item2['size'],
                    'size2' => $item2['size2']
                );
                $item->image = '/assets/img/items/'.$item2['name'];
            }else{
               

                if($_POST['fileuploader-list-files']!='[]'){
                    $imagem=$_POST['fileuploader-list-files'];
                    $logo1=json_decode($imagem);
                    $logo=$logo1[0]->file;
                    $uploadDir = base_path('');
                    $item->image=str_replace($uploadDir,"", $logo);
                }
                $item->image=null;
            }
        // export to js
        header('Content-Type: application/json');
        echo json_encode($data);
    
        //} */




            try {
                $item->save();
                if (isset($request->addon_category_item)) {
                    $item->addon_categories()->sync($request->addon_category_item);
                }
                if ($request->remove_all_addons == '1') {
                    $item->addon_categories()->sync($request->addon_category_item);
                }
                if($restaurant->business_type==1){
                    return redirect()->route('panel.itemsCardapio')->with(array('success' => 'Produto Atualizado com Sucesso!'));
                }else{
                    return redirect()->route('panel.items')->with(array('success' => 'Produto Atualizado com Sucesso!'));
                }

               
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
    public function getEditItem($id)
    {
        $user = Auth::user();
        $restaurantIds = $user->restaurants->pluck('id')->toArray();

        $item = Item::where('id', $id)
            ->whereIn('restaurant_id', $restaurantIds)
            ->first();

        $addonCategories = AddonCategory::where('user_id', Auth::user()->id)->get();

        if($item->product_variable==1){

            $addons=Addon::where('addon_category_id',$item->addon_category_price_variable_id)->get();
        }else{
            $addons=[];
        }
        


        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $manage_stock = $restaurant->manage_stock;

        if ($item) {
            $restaurants = $user->restaurants;
            $itemCategories = ItemCategory::where('is_enabled', '1')
                ->where('user_id', Auth::user()->id)
                ->get();

            return view('panel.editItem', array(
                'item' => $item,
                'restaurants' => $restaurants,
                'restaurant'=>$restaurant,
                'addons'=>$addons,
                'manage_stock' => $manage_stock,
                'itemCategories' => $itemCategories,
                'addonCategories' => $addonCategories,
            ));
        } else {
           
            return redirect()->route('panel.items')->with(array('message' => 'Access Denied'));
        }
    }

    /**
     * @param $id
     */
    public function deleteItem($id)
    {
        $item = Item::where('id', $id)->first();

        if ($item) {
            $item->is_deleted=1;
            $item->is_active=0;
            $item->save();
            return redirect()->back()->with(['success' => 'Produto Excluído com Sucesso']);
        }
        return redirect()->route('panel.items');
    }

      /**
     * @param $id
     */
    public function deleteItemCategory($id)
    {
        $category = ItemCategory::where('id', $id)->first();
        $items=Item::where('item_category_id',$category->id)->get();
       


        if ($category) {

            $category->is_deleted=1;
            $category->save();
            
            foreach($items as $item){
                $item->is_deleted=1;
                $item->save();

            }
            


           
            return redirect()->back()->with(['success' => 'Categoria Excluída com Sucesso']);
        }
        return redirect()->route('panel.itemsCardapio');
    }
    
    /**
     * @param $id
     */
    public function deletePizzaCategory($id)
    {
        $category = ItemCategory::where('id', $id)->first();
        $items=Item::where('item_category_id',$category->id)->get();
        $pizza_flavors=PizzaFlavor::where('item_category_id',$category->id)->get();
        $pizza_sizes=PizzaSize::where('item_category_id',$category->id)->get();
        $pizza_prices=PizzaPrice::where('item_category_id',$category->id)->get();


        if ($category) {

            $category->is_deleted=1;
            $category->save();
            
            foreach($items as $item){
                $item->is_deleted=1;
                $item->save();

            }
            foreach($pizza_flavors as $pizza_flavor){
                $pizza_flavor->is_deleted=1;
                $pizza_flavor->save();
            }
            foreach($pizza_prices as $pizza_price){
                $pizza_price->is_deleted=1;
                $pizza_price->save();
            }
            foreach($pizza_sizes as $pizza_size){
                $pizza_size->is_deleted=1;
                $pizza_size->save();
            }


           
            return redirect()->back()->with(['success' => 'Categoria Excluída com Sucesso']);
        }
        return redirect()->route('panel.itemsCardapio');
    }

    /**
     * @param $id
     */
    public function deletePizzaFlavor($id)
    {
        $item = PizzaFlavor::where('id', $id)->first();

        if ($item) {
            $item->is_deleted=1;
            $item->status=0;
            $item->save();
            return redirect()->back()->with(['success' => 'Sabor Excluído com Sucesso']);
        }
        return redirect()->route('panel.itemsCardapio');
    }
    
      /**
     * @param $id
     */
    public function restoreItem($id)
    {
        $item = Item::where('id', $id)->first();

        if ($item) {
            $item->is_deleted=0;
            $item->is_active=1;
            $item->save();
            return redirect()->back()->with(['success' => 'Produto Restaurado com Sucesso']);
        }
        return redirect()->route('panel.items');
    }

}
