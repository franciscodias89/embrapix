<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
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





class AffiliateController extends Controller
{
    public function general()
    {
        $user = Auth::user();

        $usercode=$user->usercode;

        $referrals=User::where('usercode_referral', $usercode)
            ->orderBy('id', 'DESC')
            ->get(['name','created_at']);
            //dd($referrals);
        $referrals_list=$referrals;    
        //$referrals_list['name']=$referrals->name;
       // $referrals_list['created_at']=$referrals->created_at;

       $referral_link=$user->referral_link;


        $text_top='Convide seus amigos para usar o App Compra Bakana, e ganhe 0,1% de todas as compras que eles fizerem no app (através de Cartão de Crédito, Débito ou PIX), todos os meses, para SEMPRE!';    
        $text_whatsapp='Olá, Como vai? Você já conhece o aplicativo Compra Bakana que chegou nesta cidade? Com ele você pode fazer compras em restaurantes, supermercados, farmácias, petshops, e quaisquer outras lojas da sua cidade e receber em sua casa. Além disso, em cada compra você acumula CashBack (dinheiro de volta) que pode ser usado em outras compras. Visualize ofertas, folhetos, compare preços, ganhe cupons de desconto e participe de sorteios. Tudo isso em um único aplicativo! Já viu algo assim? O Compra Bakana é o melhor aplicativo de Compras do Brasil! Baixe agora mesmo, e use o meu código de INDICAÇÃO: *'.$usercode.'* . ';
        $text_others='Olá, Como vai? Você já conhece o aplicativo Compra Bakana que chegou nesta cidade? Com ele você pode fazer compras em restaurantes, supermercados, farmácias, petshops, e quaisquer outras lojas da sua cidade e receber em sua casa. Além disso, em cada compra você acumula CashBack (dinheiro de volta) que pode ser usado em outras compras. Visualize ofertas, folhetos, compare preços, ganhe cupons de desconto e participe de sorteios. Tudo isso em um único aplicativo! Já viu algo assim? O Compra Bakana é o melhor aplicativo de Compras do Brasil! Baixe agora mesmo, e use o meu código de INDICAÇÃO: *'.$usercode.'* . ';
        
        $show_code=1;
        $show_link=1;

        $arrayData = [
            'usercode' => $usercode,
            'referral_link'=>$referral_link,
            'show_code'=>$show_code,
            'show_link'=> $show_link,
            'referrals_list'=>$referrals_list,
            'text_top' => $text_top,
            'text_whatsapp' => $text_whatsapp,
            'text_others' => $text_others,
            
        ];


        return response()->json($arrayData);
    }


    public function insertReferralCode(Request $request)
    {
        $user = Auth::user();

        $usercode_referral=$request->usercode_referral;

        $user->usercode_referral=$usercode_referral;
        $user->save();


        $arrayData = [
            'success' => true,
        ];

        return response()->json($arrayData);
    }



    
};
