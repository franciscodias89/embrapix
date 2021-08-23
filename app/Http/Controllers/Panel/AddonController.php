<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Order;
use App\Addon;
use App\AddonCategory;
use App\Restaurant;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * @param Request $request
     */
    public function addonsCategories(Request $request)
    {
        $user = Auth::user();

        $addonCategories = AddonCategory::where('user_id', $user->id)->where('is_product_variable', null)->where('is_deleted',0)
        ->orderBy('id', 'DESC')
        ->paginate(20);
    $addonCategories->loadCount('addons');

    $count = $addonCategories->total();
    $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

    return view('panel.addons', array(
        'addonCategories' => $addonCategories,
        'restaurant'=>$restaurant,
        'count' => $count,
    ));

    }

        /**
     * @param Request $request
     */
    public function addonCategories_deleted(Request $request)
    {
         $user = Auth::user();

        $addonCategories = AddonCategory::where('user_id', $user->id)->where('is_product_variable', null)->where('is_deleted',1)
        ->orderBy('id', 'DESC')
        ->paginate(20);
    $addonCategories->loadCount('addons');

    $count = $addonCategories->total();
    $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

    return view('panel.addons', array(
        'addonCategories' => $addonCategories,
        'restaurant'=>$restaurant,
        'count' => $count,
    ));
    }

         /**
     * @param Request $request
     */
    public function active_addons(Request $request)
    {
        $user = Auth::user();

        $addonCategories = AddonCategory::where('user_id', $user->id)->where('is_product_variable', null)->where('status',1)->where('is_deleted',0)
        ->orderBy('id', 'DESC')
        ->paginate(20);
    $addonCategories->loadCount('addons');

    $count = $addonCategories->total();
    $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

    return view('panel.addons', array(
        'addonCategories' => $addonCategories,
        'restaurant'=>$restaurant,
        'count' => $count,
    ));
    }

             /**
     * @param Request $request
     */
    public function inactive_addons(Request $request)
    {
        $user = Auth::user();

        $addonCategories = AddonCategory::where('user_id', $user->id)->where('is_product_variable', null)->where('status',0)->where('is_deleted',0)
        ->orderBy('id', 'DESC')
        ->paginate(20);
    $addonCategories->loadCount('addons');

    $count = $addonCategories->total();
    $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

    return view('panel.addons', array(
        'addonCategories' => $addonCategories,
        'restaurant'=>$restaurant,
        'count' => $count,
    ));
    }
  

    /**
     * @param Request $request
     */
    public function saveNewAddonCategory(Request $request)
    {   
        $user = Auth::user();
        $addonCategory = new AddonCategory();

        $addonCategory->name = $request->name;
        $addonCategory->type = $request->type;

        $addonCategory->min = $request->min;
        $addonCategory->max = $request->max;
        
        
        //$addonCategory->description = $request->description;
        $addonCategory->user_id = $user->id;

        if ($request->status == 'on') {
            $addonCategory->status = true;
        } else {
            $addonCategory->status = false;
        }

        try {
            $addonCategory->save();
            
            return redirect()->route('panel.getEditAddonCategory',$addonCategory->id)->with(['success' => 'Grupo de Opções Salvo com Sucesso!']);
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
    public function saveNewAddon(Request $request)
    {   
        $user = Auth::user();

        $addon = new Addon();
                    $addon->name = $request->name;
                    $addon->description = $request->description;
                    $addon->price = formatPriceDB($request->price);
                    $addon->addon_category_id = $request->addon_category_id;
                    $addon->user_id = $user->id;
                    
                    
                    try {
                        $addon->save();

                        $addonCategories = AddonCategory::where('id', $request->addon_category_id)->first();
                        $addon = Addon::where('addon_category_id', $request->addon_category_id)->where('is_deleted',0)->get();
                        $count=count($addon);

                        if($count>=2){
                            $addonCategories->status=1;
                            $addonCategories->save();
                        }
                        
                        return redirect()->route('panel.getEditAddonCategory', $request->addon_category_id)->with(['success' => 'Opção Salva com Sucesso!']);
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
    public function updateAddon(Request $request)
    {
        $user = Auth::user();
        $addon = Addon::where('id', $request->id)->first();
        $addon->name = $request->name;
        $addon->description = $request->description;
        $addon->price = formatPriceDB($request->price);
        $addon->addon_category_id = $addon->addon_category_id;
        $addon->user_id = $user->id;
        

        try {
            $addon->save();
                return redirect()->back()->with(['success' => 'Opção Atualizada com Sucesso!']);
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
    public function getEditAddonCategory($id)
    {
        $user = Auth::user();
        $addonCategory = AddonCategory::where('id', $id)->where('is_product_variable', null)->with('addons')->first();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        
      //  $addons=Addon::where('addon_category_id',$addonCategory->id)->get();
       // $number_addons=count($addons);
        if ($addonCategory) {
            if ($addonCategory->user_id == Auth::user()->id) {
                return view('panel.editAddonCategory', array(
                    'addonCategory' => $addonCategory,
                    'restaurant'=>$restaurant,
                    'addons' => $addonCategory->addons,
                    'countaddons'=>  count($addonCategory->addons),
                    
                ));
            } else {
                return redirect()
                    ->route('panel.addons')
                    ->with(array('message' => 'Access Denied'));
            }
        } else {
            return redirect()
                ->route('panel.addons')
                ->with(array('message' => 'Access Denied'));
        }
       
    }

    /**
     * @param Request $request
     */
    public function updateAddonCategory(Request $request)
    {
        $user = Auth::user();
        $addonCategory = AddonCategory::where('id', $request->id)->first();

        if ($addonCategory) {

            $addonCategory->name = $request->name;
            $addonCategory->type = $request->type;
            

            $addonCategory->min = $request->min;
            $addonCategory->max = $request->max;
            
            
            if ($request->status == 'on') {
                $addonCategory->status = true;
            } else {
                $addonCategory->status = false;
            }

            try {
                $addonCategory->save();
                

                return redirect()->route('panel.addons')->with(['success' => 'Grupo de Opções atualizado com Sucesso!']);
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
    public function deleteAddonCategory($id)
    {
        $addonCategory = AddonCategory::where('id', $id)->first();

        if ($addonCategory) {
            $addonCategory->is_deleted=1;
            $addonCategory->status=0;
            $addonCategory->save();
            return redirect()->back()->with(['success' => 'Grupo de Opções Excluído com Sucesso']);
        }
        return redirect()->route('panel.addons');
    }

     /**
     * @param $id
     */
    public function deleteAddon($id)
    {
        $addon = Addon::where('id', $id)->first();
        $addonCategory_id = $addon->addon_category_id;

        if ($addon) {
            $addon->is_deleted=1;
            $addon->is_active=0;
            $addon->save();
            return redirect()->back()->with(['success' => 'Opção Excluída com Sucesso']);
        }
        return redirect()->route('panel.getEditAddonCategory',$addonCategory_id);
    }
    
      /**
     * @param $id
     */
    public function restoreAddonCategory($id)
    {
        $addon = AddonCategory::where('id', $id)->first();

        if ($addon) {
            $addon->is_deleted=0;
            $addon->status=1;
            $addon->save();
            return redirect()->back()->with(['success' => 'Grupo de Opções Restaurado com Sucesso']);
        }
        return redirect()->route('panel.addons');
    }

}
