<?php

namespace App\Http\Controllers\ApiEntregador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use Auth;




class GeneralInformationsController extends Controller
{
      /**
      * @param $request
     * @return mixed
     */
    public function GeneralInformations(Request $request)
    {
          
        $link_url=$request->link_url;
        $link_username=$request->link_username;

        $restaurant=Restaurant::where('id',1)->with('categories')->first();

             

        $versao_android_atual='1.0.0';
        $versao_ios_atual='1.0.0';

        $versao_minima_android='1.0.0';
        $versao_minima_ios='1.0.0';
        $link_android='https://play.google.com/store/apps/details?id=com.comprabakana';
        $link_ios='https://apps.apple.com/us/app/compra-bakana/id1498707340?ls=1';
        
        $version=[
            'versao_android_atual' =>  $versao_android_atual,
            'versao_ios_atual' =>  $versao_ios_atual,
            'versao_minima_android' =>  $versao_minima_android,
            'versao_minima_ios' =>$versao_minima_ios,
            'link_android'=>$link_android,
            'link_ios'=>$link_ios,
            'link_termos_de_uso'=>'https://comprabakana.com.br/termos-de-uso-lojista',
            'link_politicas_de_privacidade'=> 'https://comprabakana.com.br/politicas-de-privacidade-app'
        ];

       

     
        

        $response=[
            'version'=>$version,
            


        ];
        
      
        return response()->json($response);
    }


    
};
