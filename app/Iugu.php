<?php

namespace App;

use App\Alert;
use App\Orderstatus;
use App\PushToken;
use App\Translation;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;

class Iugu
{

/**
     * @param $data
     */
    public function criarSubconta($data)
    {
       $name=$data['name'];
       $commissions=[
           'cents'=>$data['commissions']['cents'],
           'percent'=>$data['commissions']['percent'],
           'credit_card_cents'=>$data['commissions']['credit_card_cents'],
           'credit_card_percent'=>$data['commissions']['credit_card_percent'],
           'pix_cents'=>$data['commissions']['pix_cents'],
           'pix_percent'=>$data['commissions']['pix_percent'],
           'permit_aggregated'=>true,
       ];
       
       $data=[
           'name'=>$name,
           'commissions'=>$commissions
       ];
       $secretKey='6c91313e841d21b253cadffde8585bce';
       $response = Curl::to('https://api.iugu.com/v1/marketplace/create_account?api_token='.$secretKey)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->post();

       return $response;
    }

    /**
     * @param $data
     */
    public function verificarSubconta($data)
    {
       $account_id=$data['account_id'];
       $user_token=$data['user_token'];
       $data=[
           'price_range'=>$data['data']['price_range'],
           'physical_products'=>true,
           'business_type'=>$data['data']['business_type'],
           'person_type'=>$data['data']['person_type'],
           'automatic_transfer'=>$data['data']['automatic_transfer'],
           'cnpj'=>$data['data']['cnpj'],
           'cpf'=>$data['data']['cpf'],
           'company_name'=>$data['data']['company_name'],
           'name'=>$data['data']['name'],
           'address'=>$data['data']['address'],
           'cep'=>$data['data']['cep'],
           'city'=>$data['data']['city'],
           'state'=>$data['data']['state'],
           'telephone'=>$data['data']['telephone'],
           'resp_name'=>$data['data']['resp_name'],
           'resp_cpf'=>$data['data']['resp_cpf'],
           'bank'=>$data['data']['bank'],
           'bank_ag'=>$data['data']['bank_ag'],
           'account_type'=>$data['data']['account_type'],
           'bank_cc'=>$data['data']['bank_cc']
    
       ];
       
       $data=[
         'data'=>$data
       ];
       $secretKey='6c91313e841d21b253cadffde8585bce';
       $response = Curl::to('https://api.iugu.com/v1/accounts/'.$account_id.'/request_verification?api_token='.$user_token)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->post();

       return $response;
    }

    /**
     * @param $data
     */
    public function criarCliente($data)
    {
       $name=$data['name'];
       $email=$data['email'];
       $api_token=$data['api_token'];
       /* $notes=
       $phone=
       $phone_prefix=
       $zip_code=
       $number=
       $street=
       $city=
       $state=
       $district=
       $complement= */

              
       $data=[
           'name'=>$name,
           'email'=>$email
       ];

       $secretKey=$api_token;
       $response = Curl::to('https://api.iugu.com/v1/customers?api_token='.$secretKey)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->post();

       return $response;  
    }


    /**
     * @param $data
     */
    public function criarFormadePagamento($data)
    {
       $customer_id=$data['customer_id'];
       $description=$data['description'];
       $token=$data['token'];
       
       
       $data=[
           
           'description'=>$description,
           'token'=>$token
       ];
       $secretKey='6c91313e841d21b253cadffde8585bce';
       $response = Curl::to('https://api.iugu.com/v1/customers/'.$customer_id.'/payment_methods?api_token='.$secretKey)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->post();

       return $response;
    }


       /**
     * @param $data
     */
    public function vincularClienteContaMaster($data)
    {
       $customer_id_contamaster=$data['customer_id_contamaster'];
       $customer_id_subconta=$data['customer_id_subconta'];
       $api_token=$data['api_token'];
       
       
       $data=[
           'proxy_payments_from_customer_id'=>$customer_id_contamaster, 
       ];
       $secretKey=$api_token;
       $response = Curl::to('https://api.iugu.com/v1/customers/'.$customer_id_subconta.'/?api_token='.$secretKey)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->put();

       return $response;
    }


      /**
     * @param $data
     */
    public function criarCobranca($data)
    {
        $api_token=$data['api_token'];
        //$method=$data['method']; // não precisa se tiver o token
        if(isset($data['token'])){
            $token =$data['token'];
        }
        if(isset($data['customer_payment_method_id'])){
            $customer_payment_method_id=$data['customer_payment_method_id'];
        }
        
        $restrict_payment_method=$data['restrict_payment_method']; //Se true, restringe o método de pagamento da cobrança para o definido em method, que no caso será apenas bank_slip.
        $customer_id=$data['customer_id']; //ID do Cliente. Utilizado para vincular a Fatura a um Cliente
        $invoice_id=$data['invoice_id']; //ID da Fatura a ser utilizada para pagamento
        $email=$data['email'];//E-mail do Cliente (não é preenchido caso seja enviado um "invoice_id")
        $months=$data['months']; //Número de Parcelas (2 até 12), não é necessário passar 1. Não é preenchido caso o método de pagamento seja "bank_slip". O valor mínino de cada parcela é de R$5,00.
        $keep_dunning=$data['keep_dunning'];//Por padrão, a fatura é cancelada caso haja falha na cobrança, a não ser que este parâmetro seja enviado como "true". Obs: Funcionalidade disponível apenas para faturas criadas no momento da cobrança.
        $order_id=$data['order_id'];//Por padrão, a fatura é cancelada caso haja falha na cobrança, a não ser que este parâmetro seja enviado como "true". Obs: Funcionalidade disponível apenas para faturas criadas no momento da cobrança.


        $item=[
           'description'=>$data['items']['description'],
           'quantity'=>$data['items']['quantity'],
           'price_cents'=>$data['items']['price_cents'],
        ];
        $items=[
            $item
        ];

        $address=[
            'street'=>$data['address']['street'],
            'number'=>$data['address']['number'],
            'district'=>$data['address']['district'],
            'city'=>$data['address']['city'],
            'state'=>$data['address']['state'],
            'zip_code'=>$data['address']['zip_code'],
            'complement'=>$data['address']['complement'],

        ];
        $payer=[
            'cpf_cnpj'=>$data['payer']['cpf_cnpj'],
            'name'=>$data['payer']['name'],
            'phone_prefix'=>$data['payer']['phone_prefix'],
            'phone'=>$data['payer']['phone'],
            'email'=>$data['payer']['email'],
            'address'=>$address,

         ];
         $data=array();
        
      
       $data=[
           
           
           'restrict_payment_method'=>$restrict_payment_method,
           'customer_id'=>$customer_id,
           //'invoice_id'=>$invoice_id,
           'email'=>$email,
           //'months'=>$months,
           'keep_dunning'=>$keep_dunning,
           //'order_id'=>$order_id,
           'items'=>$items,
           'payer'=>$payer,

       ];
       if(isset($token)){
        $data['token'] =$token;
    }
    if(isset($customer_payment_method_id)){
        $data['customer_payment_method_id']=$customer_payment_method_id;
    }

       $secretKey=$api_token;
       $response = Curl::to('https://api.iugu.com/v1/charge?api_token='.$secretKey)
                ->withHeader('Content-Type: application/json')
                ->withData(json_encode($data))
                ->post();

       return $response;
    }


}
