@extends('layouts.wizard')
@section('styles')

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

.stuck {
  
  width: 100%;
  height: 400px;
 
  overflow-y: scroll;
}

.stuck p {
  margin: 10px;
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
                     <div class="step " id="4">
                        <span>4</span>
                        <span>Delivery</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step" id="5">
                        <span>5</span>
                        <span>Horários</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="6">
                        <span>6</span>
                        <span>Preferências</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step " id="6">
                        <span>7</span>
                        <span>Termos de Uso</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     <div class="step current" id="6">
                        <span>8</span>
                        <span>Plano</span>
                     </div>
                  </div>
               </div>
               <!-- checkout -->
               <div class="row justify-content-center">
                  <div class="col-xl-12 col-lg-8 col-sm-9">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                           <h4 class="fw-500">8. Escolha o seu Plano (Gratuito por 30 dias)</h4>
                          
                            </div>
                           
                            <br>
                           <span>OBS: Você não precisará pagar nada agora, e nem mesmo cadastrar nenhum cartão de crédito. Isso será necessário somente ao final do período gratuito.</span>
         
                        <div class="card-body px-0 pb-0">

                          
                                       <div class="edit-profile__body"  >
                                          
                                     
                                       
   <div class="row">
         <div class="col-xxl-3 col-lg-3 col-sm-6 mb-30">
            <div class="card h-100">
               <form 
               action="{{ route('wizard.savewizard_8') }}" 
               method="POST" 
               enctype="multipart/form-data" 
               data-parsley-trigger="keyup" 
               data-parsley-validate
               id="mei"
               >
               @csrf
               <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
               <input hidden type="text" value="1" class="form-control" name="plan">
               <div class="card-body p-30">
                  <div class="pricing d-flex align-items-center">
                     <span class=" pricing__tag color-dark order-bg-opacity-dark rounded-pill ">MEI/Autônomo</span>
                  </div>
                  <div class="pricing__price rounded">
                     <p class="pricing_subtitle mb-0 mt-20">de R$87,00 por:</p>
                     <p class="pricing_value display-3 color-dark d-flex align-items-center text-capitalize fw-600 mb-1">
                        <sup>R$</sup>57,00
                        <small class="pricing_user"> /Mês</small>
                     </p>
                  </div>
                  <div class="pricing__features">
                     <ul>
                        <li>
                           <span class="fa fa-check"></span>Marketplace e Delivery Completo
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Até 20 produtos ativos
                        </li>
                        <li>
                           <span class="fa fa-uncheck"></span>1 página de folheto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Cupons de Desconto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Sorteios (1 sorteio ativo)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack CompraBakana
                        </li>
                        <li>
                           <span class="fa fa-uncheck"></span>CashBack da Loja
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Link e QR code direto para Loja
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="price_action d-flex pb-30 pl-30">
                  <button type="submit" id="submit" form="mei" class="btn btn-warning btn-default btn-squared btn-outline-light text-capitalize px-30 color-gray fw-500">Selecionar Plano
                  </button>
               </div>
            </form>
            </div>
            <!-- End: .card -->
         </div>
         <!-- End: .col -->
         <div class="col-xxl-3 col-lg-3 col-sm-6 mb-30">
            <div class="card h-100">
               <form 
               action="{{ route('wizard.savewizard_8') }}" 
               method="POST" 
               enctype="multipart/form-data" 
               data-parsley-trigger="keyup" 
               data-parsley-validate
               id="economico"
               >
               @csrf
               <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
               <input hidden type="text" value="2" class="form-control" name="plan">
               <div class="card-body p-30">
                  <div class="pricing d-flex align-items-center">
                     <span class=" pricing__tag color-primary order-bg-opacity-primary rounded-pill ">ECONÔMICO</span>
                  </div>
                  <div class="pricing__price rounded">
                     <p class="pricing_subtitle mb-0 mt-20">de R$119,00 por:</p>
                     <p class="pricing_value display-3 color-dark d-flex align-items-center text-capitalize fw-600 mb-1">
                        <sup>R$</sup>87,00
                        <small class="pricing_user"> /Mês</small>
                     </p>
                     
                  </div>
                  <div class="pricing__features">
                     <ul>
                        <li>
                           <span class="fa fa-check"></span>Marketplace e Delivery Completo
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Até 50 produtos ativos
                        </li>
                        <li>
                           <span class="fa fa-check"></span>1 página de folheto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Cupons de Desconto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Sorteios (1 sorteio ativo)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack CompraBakana
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack da Loja
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Link e QR code direto para Loja
                        </li>
                     </ul>
                  </div>
               </div>
               
               <div class="price_action d-flex pb-30 pl-30">
                  <button type="submit" id="submit" form="economico" class="btn btn-primary btn-default btn-squared text-capitalize px-30">Selecionar Plano
                  </button>
               </div>
            </form>
            </div>
            <!-- End: .card -->
         </div>
         <!-- End: .col -->
         <div class="col-xxl-3 col-lg-3 col-sm-6 mb-30">
            <div class="card h-100">
               <form 
                                       action="{{ route('wizard.savewizard_8') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       id="pro"
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                       <input hidden type="text" value="3" class="form-control" name="plan">

               <div class="card-body p-30">
                  <div class="pricing d-flex align-items-center">
                     <span class=" pricing__tag color-secondary order-bg-opacity-secondary rounded-pill ">PRO</span>
                  </div>
                  <div class="pricing__price rounded">
                     <p class="pricing_subtitle mb-0 mt-20">de R$329,00 por:</p>
                     <p class="pricing_value display-3 color-dark d-flex align-items-center text-capitalize fw-600 mb-1">
                        <sup>R$</sup>227,00
                        <small class="pricing_user"> /Mês</small>
                     </p>
                    
                  </div>
                  <div class="pricing__features">
                     <ul>
                        <li>
                           <span class="fa fa-check"></span>Marketplace e Delivery Completo
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Até 300 produtos ativos
                        </li>
                        <li>
                           <span class="fa fa-check"></span>8 página de folheto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Cupons de Desconto
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Sorteios (1 sorteio ativo)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack CompraBakana
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack da Loja
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Link e QR code direto para Loja
                        </li>
                     </ul>
                  </div>
               </div>
               
               <div class="price_action d-flex pb-30 pl-30">
                  <button type="submit" id="submit" form="pro" class="btn btn-secondary btn-default btn-squared text-capitalize px-30">Selecionar Plano
                  </button>
               </div>
            </form>
            </div>
            <!-- End: .card -->
         </div>
         <!-- End: .col -->
         <div class="col-xxl-3 col-lg-3 col-sm-6 mb-30">
            <div class="card h-100">
               <form 
                                       action="{{ route('wizard.savewizard_8') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       id="super"
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                       <input hidden type="text" value="4" class="form-control" name="plan">
               <div class="card-body p-30">
                  <div class="pricing d-flex align-items-center">
                     <span class=" pricing__tag color-success order-bg-opacity-success rounded-pill ">SUPER</span>
                  </div>
                  <div class="pricing__price rounded">
                     <p class="pricing_subtitle mb-0 mt-20">de R$499,00 por:</p>
                     <p class="pricing_value display-3 color-dark d-flex align-items-center text-capitalize fw-600 mb-1">
                        <sup>R$</sup>257,00
                        <small class="pricing_user">/Mês</small>
                     </p>
                     
                  </div>
                  <div class="pricing__features">
                     <ul>
                        <li>
                           <span class="fa fa-check"></span>Marketplace e Delivery Completo
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Produtos Ativos Ilimitados
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Páginas de Folheto (ilimitado)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Cupons de Desconto (ilimitado)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Sorteios (ilimitado)
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack CompraBakana
                        </li>
                        <li>
                           <span class="fa fa-check"></span>CashBack da Loja
                        </li>
                        <li>
                           <span class="fa fa-check"></span>Link e QR code direto para Loja
                        </li>
                     </ul>
                  </div>
               </div>
               
               
      
               <div class="price_action d-flex pb-30 pl-30">
                  <button type="submit" id="submit" form="super" class="btn btn-success btn-default btn-squared text-capitalize px-30">Selecionar Plano
                  </button>
               </div>
            </form>
            </div>
            <!-- End: .card -->
         </div>
         <!-- End: .col -->
      </div>

   




                     
            
          
                                             
                                          
                                             
                                          
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
















$(document).ready(function () {




/* var check_terms_conditions= "<?php  echo $restaurant->check_terms_conditions; ?>";  

if (check_terms_conditions==1)  {
  
$('#submit').prop("disabled", false);
}else{
   $('#submit').prop("disabled", true);
}


$("[name='check_terms_conditions']").on("change", function () {
if ($(this).val() == 1) {
    
   $('#submit').prop("disabled", false);
}else{
   $('#submit').prop("disabled", true);
} */



});







// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});












</script>
@endsection
