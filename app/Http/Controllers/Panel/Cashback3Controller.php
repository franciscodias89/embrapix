<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Restaurant;
use Auth;
use Exception;
use Illuminate\Http\Request;


class CashbackController extends Controller
{
    public function getEditCashback()
    {
        $user = Auth::user();
        $restaurant=Restaurant::where('id',$user->restaurant_id)->first();

        $arrayData = [
            'restaurant'=>$restaurant,
        ];

            return view('panel.editCashback', $arrayData);

    }
   


    public function updateCashBack(Request $request)
    {
        $user = Auth::user();

        $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        $restaurant->cashback_percent=$request->cashback_percent;    
        if ($request->cashback_active == 'on') {
            $restaurant->cashback_active = true;
        } else {
            $restaurant->cashback_active = false;
        }

            try {
                $restaurant->save();
                
                return redirect()->route('panel.cashback')->with(array('success' => 'Cashback Atualizado com Sucesso!'));
            } catch (\Illuminate\Database\QueryException $qe) {
                return redirect()->back()->with(['message' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->with(['message' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['message' => $th]);
            }
    }

    

};
