<?php
use Carbon\CarbonInterval;




use App\PizzaSize;
use App\PizzaFlavor;
use App\PizzaPrice;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;


use Ixudra\Curl\Facades\Curl;

function timeStrampDiffFormatted($t1, $t2)
{
    $days = $t1->diffInDays($t2);
    $hours = $t1->diffInHours($t2->subDays($days));
    $minutes = $t1->diffInMinutes($t2->subHours($hours));
    $seconds = $t1->diffInSeconds($t2->subMinutes($minutes));
    return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
};

function diffInMins($t1, $t2)
{
    $minutes = $t1->diffInMinutes($t2);
    return $minutes;
}

function returnAcronym($string)
{
    $words = explode(' ', "$string");
    $acronym = '';
    foreach ($words as $w) {
        if (isset($w[0])) {
            $acronym .= $w[0];
        }
    }
    $firstTwoChars = strtoupper(mb_substr($acronym, 0, 2, 'UTF-8'));
    return $firstTwoChars;
}

function formatPriceDB($price)
{
    $price=str_replace(',','.',str_replace('.','',$price));

    return $price;
}


function formatPriceDBapp($price)
{
   

    return $price;
}


/**
     * @param $slug
     */
     function getItemPizza($item,$category)
       {

        $item_category=$category;//ItemCategory::where('id',$item['item_category_id'])->first();
        $addon_categories=$item['addon_categories'];
        $pizza_size_id=$item['pizza_size_id'];
        $pizza_size=PizzaSize::where('id',$pizza_size_id)->first();
        $pizza_flavors=PizzaFlavor::where('item_category_id',$item['item_category_id'])->get();
        $addonCategories= new Collection();

        if($item['pizza_flavors']==1){
            $addons=array();
            $addon_prices=array();
            foreach($pizza_flavors as $flavor){
                $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                $addons[]=[
                    'id'=>'Ad1'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>88,
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0

                ];
                if($price['price']!=null){
                    $addon_prices[]=$price['price'];
                }
                

            }
            
            $addon_categories1=[
                'id'=>88,
                'name'=>'Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons,

            ];
            
            $addonCategories->push($addon_categories1);

            foreach($addon_categories as $row){
                $addonCategories->push($row);
            }
            $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
            if($addon_prices){
                $min_addons=min($addon_prices);
                $item['price_from']=$min_addons;
            }
            

            
        }
        if($item['pizza_flavors']==2){
            $addon_prices=array();
            $addons=array();
            $addons2=array();
            foreach($pizza_flavors as $flavor){
                $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                $addons[]=[
                    'id'=>'Ad2'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add1',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons2[]=[
                    'id'=>'Ad22'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add2',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                if($price['price']!=null){
                    $addon_prices[]=$price['price'];
                }

            }
            
            $addon_categories1=[
                'id'=>'add1',
                'name'=>'Primeiro Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Primeiro Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons,

            ];
            $addon_categories2=[
                'id'=>'add2',
                'name'=>'Segundo Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Segundo Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons2,


            ];
            $addonCategories->push($addon_categories1);
            $addonCategories->push($addon_categories2);

            foreach($addon_categories as $row){
                $addonCategories->push($row);
            }
            $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
            
            if($addon_prices){
                $min_addons=min($addon_prices);
                $item['price_from']=$min_addons;
            }
            
        }
        if($item['pizza_flavors']==3){
            $addon_prices=array();
            $addons=array();
            $addons2=array();
            $addons3=array();
            foreach($pizza_flavors as $flavor){
                $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                $addons[]=[
                    'id'=>'Ad3'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add1',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons2[]=[
                    'id'=>'Ad33'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add2',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons3[]=[
                    'id'=>'Ad33'.$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add3',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                if($price['price']!=null){
                    $addon_prices[]=$price['price'];
                }

            }
            
            $addon_categories1=[
                'id'=>'add1',
                'name'=>'Primeiro Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Primeiro Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons,

            ];
            $addon_categories2=[
                'id'=>'add2',
                'name'=>'Segundo Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Segundo Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons2,


            ];
            $addon_categories3=[
                'id'=>'add3',
                'name'=>'Terceiro Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Terceiro Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons3,


            ];
            $addonCategories->push($addon_categories1);
            $addonCategories->push($addon_categories2);
            $addonCategories->push($addon_categories3);

            foreach($addon_categories as $row){
                $addonCategories->push($row);
            }
            $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
            
            if($addon_prices){
                $min_addons=min($addon_prices);
                $item['price_from']=$min_addons;
            }
            
        }
        if($item['pizza_flavors']==4){
            $addon_prices=array();
            $addons=array();
            $addons2=array();
            $addons3=array();
            $addons4=array();
            foreach($pizza_flavors as $flavor){
                $price=PizzaPrice::where('pizza_flavor_id',$flavor->id)->where('pizza_size_id',$pizza_size['id'])->first();
                $addons[]=[
                    'id'=>$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add1',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons2[]=[
                    'id'=>$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add2',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons3[]=[
                    'id'=>$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add3',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                $addons4[]=[
                    'id'=>$flavor->id,
                    'name'=> $flavor->flavor,
                    'description'=>$flavor->description,
                    'price'=>$price['price'],
                    'addon_category_id'=>'add4',
                    'image'=>$flavor->image,
                    //'is_active'=>1,
                    //'is_deleted'=>0
                ];
                if($price['price']!=null){
                    $addon_prices[]=$price['price'];
                }

            }
            
            $addon_categories1=[
                'id'=>'add1',
                'name'=>'Primeiro Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Primeiro Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
               // 'is_deleted'=>0,
                'addons'=>$addons,

            ];
            $addon_categories2=[
                'id'=>'add2',
                'name'=>'Segundo Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Segundo Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons2,


            ];
            $addon_categories3=[
                'id'=>'add3',
                'name'=>'Terceiro Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Terceiro Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
               // 'is_deleted'=>0,
                'addons'=>$addons3,


            ];
            $addon_categories4=[
                'id'=>'add4',
                'name'=>'Quarto Sabor',
                'type'=>'SINGLE',
                'description'=>'Escolha o Quarto Sabor',
                //'status'=>1,
                'min'=>null,
                'max'=>null,
                'flavor'=>1,
                'pizza_more_flavors'=>$item_category->pizza_more_flavors,
                //'is_deleted'=>0,
                'addons'=>$addons4,


            ];
            $addonCategories->push($addon_categories1);
            $addonCategories->push($addon_categories2);
            $addonCategories->push($addon_categories3);
            $addonCategories->push($addon_categories4);

            foreach($addon_categories as $row){
                $addonCategories->push($row);
            }
            $item['addon_categories']=$addonCategories;//array_merge($addon_categories1,$addon_categories2);
            
            if($addon_prices){
                $min_addons=min($addon_prices);
                $item['price_from']=$min_addons;
            }
        }

        return $item;


    }

    /**
     * @param $slug
     */
   function getPriceFromAddons($item)

    {
        $addon_categories=$item['addon_categories'];

        $addon_prices=[];
        foreach($addon_categories as $categories){

            if($categories['type']=="SINGLE"){
                $addons=$categories['addons'];
                foreach($addons as $addon){
                    if($addon['price']!=null){
                        $addon_prices[]=$addon['price'];
                    }
                }
            }
            
        }
        if(!empty($addon_prices)){
            $item['price_from']=min($addon_prices);
        }else{
            $item['price_from']="0.00";
        }

       
        return $item;
    }



/**
     * @param Request $request
     */
    function Safe2PayEditSubAccount($id_subaccount,$user,$subaccount,$restaurant)
    {
        $token ="3AB033513F5541A99736D7FB50ED1225";
        $Safe2Pay_CreditCard=2.4;
        $Safe2Pay_DebitCard=2.1;
        $Safe2Pay_Pix=1.0;

        if($subaccount->account_type =="Poupança"){
            $account_type="PP";
        }else{
            $account_type="CC"; 
        }
        if($subaccount->plan_model =="1"){
            $comission=$subaccount->comission;
        }else{
            $comission=0; 
        }
    if($subaccount->person_type =="Pessoa Jurídica"){
        $identity=str_replace(".","",str_replace("-","",str_replace("/","",$subaccount->cnpj)));
        $resp_name = $subaccount->resp_name;
        $resp_cpf = str_replace(".","",str_replace("-","",$subaccount->resp_cpf));
        
        $data = [
            "Id"=> $id_subaccount,
            "Name" => $subaccount->company_name, 
            "CommercialName" => $subaccount->name, 
            "Identity" => $identity, 
            "ResponsibleName" => $resp_name, 
            "ResponsibleIdentity" =>  $resp_cpf, 
            "Email" =>  $user->email, 
            "TechName" =>  $resp_name, 
            "TechIdentity" =>  $resp_cpf, 
            "TechEmail" =>  $user->email,
            "IsPanelRestricted" => true,
            "BankData" => [
                  "BankAgency" => $subaccount->bank_ag, 
                  "BankAgencyDigit" => $subaccount->bank_ag_digit, 
                  "BankAccount" => $subaccount->bank_cc, 
                  "BankAccountDigit" => $subaccount->bank_cc_digit, 
                  "Bank" => [
                     "Code" => $subaccount->bank, 
                  ],
                  "AccountType" => [
                    "Code" => $account_type, 
                 ] 
            ], 
            
            "Address" => [
                "ZipCode" => $restaurant->pincode, 
                "Street" => $restaurant->address_street, 
                "Number" => $restaurant->address_number, 
                "Complement" => $restaurant->address_complement, 
                "District" => $restaurant->address_district, 
                "CityName" => $restaurant->address_city, 
                "StateInitials" => $restaurant->address_state, 
                "CountryName" => "Brasil" 
            ], 
            "MerchantSplit" => [
                        [
                           "PaymentMethodCode" => "2", //Cartão de Crédito
                           "IsSubaccountTaxPayer" => true, 
                           "Taxes" => array([
                                "TaxTypeName"=>"1",
                                "Tax"=>strval (($subaccount->credit_card_percent) - $Safe2Pay_CreditCard+$comission) ,
                            ]),
                           
                        ], 
                        [
                            "PaymentMethodCode" => "4", //Cartão de Débito
                            "IsSubaccountTaxPayer" => true, 
                            "Taxes" => array([
                                 "TaxTypeName"=>"1",
                                 "Tax"=> strval (($subaccount->credit_card_percent) - $Safe2Pay_DebitCard+$comission) ,
                             ]), 
                            
                        ],
                        [
                            "PaymentMethodCode" => "6", //PIX
                            "IsSubaccountTaxPayer" => true, 
                            "Taxes" => array([

                                 "TaxTypeName"=>"1",
                                 "Tax"=>strval (($subaccount->credit_card_percent) - $Safe2Pay_Pix+$comission),
                             ]), 
                            
                         ],
                         [
                            "PaymentMethodCode" => "16", //Cartão de Débito
                            "IsSubaccountTaxPayer" => true, 

                        ],
                        
                     ]
        
         ]; 

    }else{

        $identity=str_replace(".","",str_replace("-","",$subaccount->cpf)); 
        $resp_name = $subaccount->resp_name;
        $resp_cpf = str_replace(".","",str_replace("-","",$subaccount->cpf));

        $data = [
            "Id"=> $id_subaccount,
            "Name" => $subaccount->name, 
            "CommercialName" => $subaccount->name, 
            "Identity" => $identity, 
            "ResponsibleName" => $resp_name, 
            "ResponsibleIdentity" =>  $resp_cpf, 
            "Email" =>  $user->email, 
            "IsPanelRestricted" => true,
             
            "BankData" => [
                  "BankAgency" => $subaccount->bank_ag, 
                  "BankAgencyDigit" => $subaccount->bank_ag_digit, 
                  "BankAccount" => $subaccount->bank_cc, 
                  "BankAccountDigit" => $subaccount->bank_cc_digit, 
                  "Bank" => [
                     "Code" => $subaccount->bank, 
                  ],
                  "AccountType" => [
                    "Code" => $account_type, 
                 ] 
            ], 
            
            "Address" => [
                "ZipCode" => $restaurant->pincode, 
                "Street" => $restaurant->address_street, 
                "Number" => $restaurant->address_number, 
                "Complement" => $restaurant->address_complement, 
                "District" => $restaurant->address_district, 
                "CityName" => $restaurant->address_city, 
                "StateInitials" => $restaurant->address_state, 
                "CountryName" => "Brasil" 
            ], 
            "MerchantSplit" => [
                        [
                           "PaymentMethodCode" => "2", //Cartão de Crédito
                           "IsSubaccountTaxPayer" => true, 
                           "Taxes" => array([
                                "TaxTypeName"=>"1",
                                "Tax"=>strval (($subaccount->credit_card_percent) - $Safe2Pay_CreditCard+$comission) ,
                            ]),
                           
                        ], 
                        [
                            "PaymentMethodCode" => "4", //Cartão de Débito
                            "IsSubaccountTaxPayer" => true, 
                            "Taxes" => array([
                                 "TaxTypeName"=>"1",
                                 "Tax"=> strval (($subaccount->credit_card_percent) - $Safe2Pay_DebitCard+$comission) ,
                             ]), 
                            
                        ],
                        [
                            "PaymentMethodCode" => "6", //PIX
                            "IsSubaccountTaxPayer" => true, 
                            "Taxes" => array([

                                 "TaxTypeName"=>"1",
                                 "Tax"=>strval (($subaccount->credit_card_percent) - $Safe2Pay_Pix+$comission),
                             ]), 
                            
                         ],
                         [
                            "PaymentMethodCode" => "16", //Cartão de Débito
                            "IsSubaccountTaxPayer" => true, 

                        ],
                        
                     ]
        
         ]; 

    }

    
        
       

         

        $response = Curl::to('https://api.safe2pay.com.br/v2/Marketplace/Update?id='.$id_subaccount)
         ->withHeader('Content-Type: application/json')
         ->withHeader("x-api-key:".$token)
         ->withData(json_encode($data))
         ->put();
         
         $subaccount->log=$response;
         $subaccount->save();

        return json_decode($response);
    }



    /**
     * @param Request $request
     */
    function Safe2PayCheckTransaction($IdTransaction,$subaccount)
    {
       
        $token=$subaccount->token;

         $data=array();

        $response = Curl::to('https://api.safe2pay.com.br/v2/transaction/Get?Id='.$IdTransaction)
         ->withHeader('Content-Type: application/json')
         ->withHeader("x-api-key:".$token)
         ->withData(json_encode($data))
         ->get();
         
         $subaccount->log=$response;
         $subaccount->save();
         
        return json_decode($response);
    }