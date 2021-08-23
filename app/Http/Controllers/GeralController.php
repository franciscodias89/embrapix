<?php
namespace App\Http\Controllers;

use App\AcceptDelivery;
use App\Address;
use App\Rating;
use App\Restaurant;
use App\RestaurantCategory;
use App\RestaurantFavorite;
use App\User;
use App\Iugu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;
use JWTAuth;
use JWTAuthException;
use Spatie\Permission\Models\Role;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

class GeralController extends Controller
{
    /**
      * @param $request
     * @return mixed
     */
    public function GeralInformations(Request $request)
    {
        $user = auth()->user();  
        $versao_android_atual='2.0.1';
        $versao_ios_atual='2.0.2';

        $versao_minima_android='2.0.0';
        $versao_minima_ios='2.0.1';
        $link_android='https://play.google.com/store/apps/details?id=com.comprabakana';
        $link_ios='https://apps.apple.com/us/app/compra-bakana/id1498707340?ls=1';
        
        $version=[
            'versao_android_atual' =>  $versao_android_atual,
            'versao_ios_atual' =>  $versao_ios_atual,
            'versao_minima_android' =>  $versao_minima_android,
            'versao_minima_ios' =>$versao_minima_ios,
            'link_android'=>$link_android,
            'link_ios'=>$link_ios,
            'link_termos_de_uso'=>'https://comprabakana.com.br/termos-de-uso-app',
            'link_politicas_de_privacidade'=> 'https://comprabakana.com.br/politicas-de-privacidade-app'
        ];

        $account_id_iugu_mestre='';
        $keys=[
            'account_id'=> $account_id_iugu_mestre,
        ];
        $response=[
            'version'=>$version,
            'keys'=>$keys
        ];
        
      
        return response()->json($response);
    }

    public function TestIugu(Request $request)
    {
        $user = auth()->user();
        $name='Francisco Teste';
        $commissions=[
            'cents'=>'40',
            'percent'=>'1.5',
            'credit_card_cents'=>'40',
            'credit_card_percent'=>'1.5',
            'pix_cents'=>'30',
            'pix_percent'=>'1',
            'permit_aggregated'=>true,
        ];
        
        $data=[
            'name'=>$name,
            'commissions'=>$commissions
        ];

        $test = new Iugu;
        $response=$test->criarSubconta($data);

        return $response;

    }


    public function TestIuguCriarCliente(Request $request)
    {

        $id_contamaster= '9393337C51E1255200137219AFFD83E7';
        $live_token_master ='6c91313e841d21b253cadffde8585bce';
        $test_token_master ='9da2d495e5957b8feb914eb36010c3a6';
        
        $id_subconta=   '71266658C07C4AA5963D3565D21785E4';
        $live_token_subconta ='9b654e4f417ae5ce63924facbc59e01b';
        $test_token_subconta ='5d5dd8312c6e06f19c901fe046588f0b';

        $user = auth()->user();
        $name='Thais Helena dos Santos Dias';
       $email='thaishelenapsi@gmail.com';
       $api_token='';
        
        
        
        $data=[
            'name'=>$name,
            'email'=>$email,
            'api_token'=>$api_token
        ];

        $test = new Iugu;
        $response=$test->criarSubconta($data);

        return $response;

    }
    
};
