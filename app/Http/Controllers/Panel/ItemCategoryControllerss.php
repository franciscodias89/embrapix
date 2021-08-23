<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Order;
use App\Restaurant;
use App\ItemCategory;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{  
    /**
     * @param Request $request
     */
    public function itemcategories(Request $request)
    {
        $user = Auth::user();
        $itemCategories = ItemCategory::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)->where('is_deleted',0)
            ->get();
        $itemCategories->loadCount('items');
        $count = count($itemCategories);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        return view('panel.itemcategories', array(
            'itemCategories' => $itemCategories,
            'restaurant'=>$restaurant,
            'count' => $count,
        ));
    }

        /**
     * @param Request $request
     */
    public function itemcategories_deleted(Request $request)
    {
        $user = Auth::user();
        $itemCategories = ItemCategory::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)->where('is_deleted',1)
            ->get();
        $itemCategories->loadCount('items');
        $count = count($itemCategories);
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();
        return view('panel.itemcategories', array(
            'itemCategories' => $itemCategories,
            'restaurant'=>$restaurant,
            'count' => $count,
        ));

       
    }

     
     /**
     * @param Request $request
     */
    public function createItemCategory(Request $request)
    {
        $itemCategory = new ItemCategory();

        $itemCategory->name = $request->name;
        $itemCategory->user_id = Auth::user()->id;

        try {
            $itemCategory->save();
            return redirect()->back()->with(array('success' => 'Categoria Adicionada com Sucesso!'));
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
    public function updateItemCategory(Request $request)
    {
        $itemCategory = ItemCategory::where('id', $request->id)->where('user_id', Auth::user()->id)->firstOrFail();
        $itemCategory->name = $request->name;
        $itemCategory->save();
        return redirect()->back()->with(['success' => 'Categoria Atualizada com Sucesso']);
    }


     
    /**
     * @param $id
     */
    public function deleteItemCategory($id)
    {
        $itemCategory = ItemCategory::where('id', $id)->first();

        if ($itemCategory) {
            $itemCategory->is_deleted=1;
            $itemCategory->is_enabled=0;
            $itemCategory->save();
            return redirect()->back()->with(['success' => 'Categoria Excluída com Sucesso']);
        }
        return redirect()->route('panel.itemcategories');
    }
    
      /**
     * @param $id
     */
    public function restoreItemCategory($id)
    {
        $itemCategory = ItemCategory::where('id', $id)->first();

        if ($itemCategory) {
            $itemCategory->is_deleted=0;
            $itemCategory->is_enabled=1;
            $itemCategory->save();
            return redirect()->back()->with(['success' => 'Categoria Restaurada com Sucesso']);
        }
        return redirect()->route('panel.itemcategories');
    }

}
