@extends('layouts.wizard')
@section('styles')
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">

<style>
    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }

    #mapp {
        width: 100%;
        height: 400px;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    .card .card-header {
    padding-top: 10px;
    background: #ffffff;
}

    hr {
    margin-top: 1.67rem;
    margin-bottom: 1.67rem;
    border: 0;
    border-top: 1px solid #e3e6ef;
}

.fileuploader-theme-avatar {
    position: relative;
    width: 160px;
    height: 160px;
    padding: 0;
    margin: 30px;
    background: none;
}
body {
   background: #fbfbfb;
}

</style>
@endsection

@section('content')

   <div class="mt-50">
   <div class="container-fluid">
      
      <div class=" checkout wizard1 wizard7 global-shadow px-sm-50 px-20 py-sm-50 py-30 mb-30 bg-white radius-xl w-100">
        
         <div class="row justify-content-center">
           
            <div class="col-xl-8">
               <div class="checkout-progress-indicator content-center">
                  <div class="checkout-progress">
                     <div class="step" id="1">
                        <span>1</span>
                        <span>Perfil</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="2">
                        <span>2</span>
                        <span>Endereço</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="3">
                        <span>3</span>
                        <span>Financeiro</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step current id="4">
                        <span>4</span>
                        <span>Delivery</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="5">
                        <span>5</span>
                        <span>Horários</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="6">
                        <span>6</span>
                        <span>Preferências</span>
                     </div>
                  </div>
               </div>
               <!-- checkout -->
               <div class="row justify-content-center">
                  <div class="col-xl-7 col-lg-8 col-sm-10">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                           <h4 class="fw-500">4. Configurações de Delivery</h4>
                            </div>
                           
                           
                        <div class="card-body px-0 pb-0">


                           <div class="atbd-nav-controller">
                              <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                  <a href="{{ route('wizard.wizard_4') }}" class="btn btn-sm btn-outline-light nav-link" id="size-tipo_entrega" data-toggle="tab" role="tab" aria-controls="tipo_entrega" aria-selected="false">Tipo de Venda</a>
                                  @if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3))
                                  <a href="{{ route('wizard.wizard_4_1') }}" class="btn btn-sm btn-outline-light nav-link " id="size-default" data-toggle="tab" role="tab" aria-controls="default" aria-selected="true"> Tempo de Entrega</a>
                                  @endif
                                  @if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3))
                                  <a href="{{ route('wizard.wizard_4_2') }}" class="btn btn-sm btn-outline-light nav-link " id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Tempo de Retirada</a>
                                  @endif
                                  <a href="{{ route('wizard.wizard_4_3') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Formas de Pagamento</a>
                              </div>
                           </div>
                          
                          
                                       <div class="edit-profile__body">
                                          <form 
                                       action="{{ route('wizard.savewizard_4_3') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                       <input hidden type="text" value="3" class="form-control" name="status">
                                       
                                       <div class="">
                                          <div class="row mt-40">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Pagamento Pelo Aplicativo </span><br><small> (* Recomendado)</small>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="payment_app_accept" id="nc1"  checked="checked" >
                                                <label class="custom-control-label" for="nc1"></label>
                                             </div>
                                             <small> </small>
                                          </div>
                                          @if(($restaurant->delivery_type ==1)||($restaurant->delivery_type ==3))
                                          <div class="row mt-40 mb-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Aceita Pagamento na Entrega?</span> 
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  onchange="valueChanged()" name="payment_delivery_accept" id="nc2" @if($restaurant->payment_delivery_accept) checked="checked" @endif >
                                                <label class="custom-control-label" for="nc2"></label>
                                             </div>
                                             <small> (* Pagamento direto com o Entregador, em dinheiro ou cartão)</small>
                                          </div>
                                          @endif
                                          @if(($restaurant->delivery_type ==2)||($restaurant->delivery_type ==3))
                                          <div class="row mt-30 mb-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Aceita Pagamento na Retirada?</span> 
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input" onchange="valueChanged2()"  name="payment_selfpickup_accept" id="nc3" @if($restaurant->payment_selfpickup_accept) checked="checked" @endif >
                                                
                                                <label class="custom-control-label" for="nc3"></label>
                                             </div>
                                             <small> (* Pagamento feito pelo cliente no balcão da loja, ao retirar o produto na loja, em dinheiro ou cartão)</small>
                                          </div>
                                          @endif
                                      </div>

                                      @if(($restaurant->delivery_type ==1)||($restaurant->delivery_type ==3))
                                      <div id="pagamento_entrega">
                                       <div class="mt-40 mb-30">
                                          <span ><strong>Pagamento na Entrega</strong></span>
                                       </div>
                                       <div class="">
                                          <div class="row">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Dinheiro</span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="delivery_payment_type_money" id="nc4"  @if($delivery_payment_type['delivery_payment_type_money']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc4"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Cartão de Crédito</span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="delivery_payment_type_credit_card" id="nc5"  @if($delivery_payment_type['delivery_payment_type_credit_card']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc5"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Cartão de Débito </span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="delivery_payment_type_debit_card" id="nc6"  @if($delivery_payment_type['delivery_payment_type_debit_card']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc6"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>PIX </span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="delivery_payment_type_pix" id="nc7"  @if($delivery_payment_type['delivery_payment_type_pix']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc7"></label>
                                             </div>
                                          </div>
                                       
                                      </div>
                                    </div>
                                      @endif
                                      @if(($restaurant->delivery_type ==2)||($restaurant->delivery_type ==3))
                                      <div  id="pagamento_retirada">
                                       <div class="mt-40 mb-30">
                                          <span ><strong>Pagamento na Retirada (balcão)</strong></span>
                                       </div>
                                       <div class="">
                                          <div class="row">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Dinheiro</span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_money" id="nc8"  @if($selfpickup_payment_type['selfpickup_payment_type_money']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc8"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Cartão de Crédito </span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_credit_card" id="nc9"  @if($selfpickup_payment_type['selfpickup_payment_type_credit_card']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc9"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Cartão de Débito </span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_debit_card" id="nc10"  @if($selfpickup_payment_type['selfpickup_payment_type_debit_card']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc10"></label>
                                             </div>
                                          </div>
                                          <div class="row mt-30">
                                             <div class="div col-lg-6 col-sm-6">
                                                <span>Pix</span>
                                             </div>
                                             <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_pix" id="nc11"  @if($selfpickup_payment_type['selfpickup_payment_type_pix']) checked="checked" @endif  >
                                                <label class="custom-control-label" for="nc11"></label>
                                             </div>
                                          </div>
                                      </div>
                                    </div>
                                    @endif    
            
                                       
            
                                             
                                             <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                                <button type="submit" class="btn btn-danger btn-default btn-squared mr-15">Salvar e Continuar<i class="ml-10 mr-0 las la-arrow-right"></i>
                                                </button>
                                                
                                          </div>
                                          
                                             
                                          </form>
                                       </div>
                              
                          


        



                        </div>
                     </div>
                     <!-- ends: card -->
                  </div>
                  <!-- ends: col -->
               </div>
            </div>
            <!-- ends: col -->
         </div>
      </div>
      <!-- End: .global-shadow-->
   </div>
</div>
@endsection

@section('scripts')






<script>




$(document).ready(function() {
    $(".dinheiro").mask('#.##0,00', {
        reverse: true
    });
    $(".agencia").mask('000.000.000-00', {
        reverse: true
    });
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cep').mask('00000-000', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
//
//MASCARA DE TELEFONE
    var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('.phone').mask(behavior, options);
//MASCARA DE TELEFONE - FIM



});









function valueChanged()
    {
        if($('#nc2').is(":checked"))   
            $("#pagamento_entrega").show();
        else
            $("#pagamento_entrega").hide();
    }

    function valueChanged2()
    {
        if($('#nc3').is(":checked"))   
            $("#pagamento_retirada").show();
        else
            $("#pagamento_retirada").hide();
    }

$(document).ready(function () {




var payment_selfpickup_accept= "<?php  echo $restaurant->payment_selfpickup_accept; ?>";  
var payment_app_accept= "<?php  echo $restaurant->payment_app_accept; ?>"; 

if (payment_selfpickup_accept== 1) {
  
$('#pagamento_retirada').removeClass('hidden');


}else {
   $('#pagamento_retirada').addClass('hidden');

}
if (payment_delivery_accept== 1) {
  
  $('#pagamento_entrega').removeClass('hidden');
  
  }else {
     $('#pagamento_entrega').addClass('hidden');
  
  }
  







});













// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});












</script>
@endsection
