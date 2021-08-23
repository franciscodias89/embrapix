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
                     <div class="step current" id="6">
                        <span>6</span>
                        <span>Preferências</span>
                     </div>
                     <div class="current"><img src="{{ asset('img/svg/checkout.svg') }}" alt="img" class="svg"></div>
                     @if($restaurant->check_terms_date==null){
                     <div class="step " id="7">
                        <span>7</span>
                        <span>Termos de Uso</span>
                     </div>
                     @endif

                  </div>
               </div>
               <!-- checkout -->
               <div class="row justify-content-center">
                  <div class="col-xl-7 col-lg-8 col-sm-10">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                           <h4 class="fw-500">6. Preferências e Configurações Gerais</h4>
                            </div>
                           
                           
                        <div class="card-body px-0 pb-0">


                          
                          
                          
                                       <div class="edit-profile__body">
                                          <form 
                                       action="{{ route('wizard.savewizard_6') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
            
                                      {{--  <div class="notification-content__body p-25 border-bottom">
                                          <div class="d-flex justify-content-between flex-wrap align-items-center">
                                              <div class="div col-lg-10 col-sm-10">
                                                  <h6>Ativar Tempo de Entrega/Retirada por produto</h6>
                                                  <span>Ao ativar, cada produto terá um campo para preenchimento de previsão de entrega ou retirada. Ideal quando se tem produtos com prazos de entrega variáveis.</span>
                                              </div>
                                              <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                  <input type="checkbox" class="custom-control-input"  name="variable_time" id="nc1" @if($restaurant->variable_time) checked="checked" @endif >
                                                  <label class="custom-control-label" for="nc1"></label>
                                              </div>
                                          </div>
                                      </div> --}}
                                      <div class="notification-content__body p-25 border-bottom">
                                          <div class="d-flex justify-content-between flex-wrap align-items-center">
                                              <div class="div col-lg-10 col-sm-10">
                                                  <h6>Gerenciar Estoque</h6>
                                                  <span>Ao selecionar, aparecerá um campo de "estoque" no cadastro dos produtos, que deverá ser preenchido. A cada nova venda, a quantidade de produtos em estoque será atualizada. </span>
                                              </div>
                                              <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                                  <input type="checkbox" class="custom-control-input" onchange="valueChanged4()" name="manage_stock" id="nc7" @if($restaurant->manage_stock) checked="checked" @endif >
                                                  <label class="custom-control-label"  for="nc7"></label>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="notification-content__body p-25 border-bottom" id="accept_outofstock">
                                       <div class="d-flex justify-content-between flex-wrap align-items-center">
                                           <div class="div col-lg-10 col-sm-10">
                                               <h6>Aceita Pedidos fora de Estoque (Encomenda)</h6>
                                               <span>Somente marque este item se você irá aceitar pedidos que acabaram ou não estão em estoque. </span>
                                           </div>
                                           <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                               <input type="checkbox" class="custom-control-input" onchange="valueChanged5()" name="accept_outofstock" id="nc8" @if($restaurant->accept_outofstock) checked="checked" @endif >
                                               <label class="custom-control-label"  for="nc8"></label>
                                           </div>
                                       </div>
                                       </div>

                                       <div class="notification-content__body p-25 border-bottom" id="addtime_outofstock">
                                          <div class="d-flex justify-content-between flex-wrap align-items-center">
                                              <div class="div col-lg-7 col-sm-7">
                                                  <h6>Adicionar tempo para pedidos fora de estoque (encomenda)</h6>
                                                  <span>Número de dias a mais que será acrescentado ao tempo previsto de entrega. </span>
                                              </div>
                                              <div class="custom-control custom-switch my-lg-0 my-10 col-lg-5 col-sm-5" style="float: right">
                                                <div class="input-group input-group-merge">
                                              
                                                   <input required type="text" value="<?php if ($restaurant->addtime_outofstock != null){ echo $restaurant->addtime_outofstock; };?>" class="form-control" name="addtime_outofstock"
                                                   id="addtime_outofstock" placeholder="">
                                                   <div class="input-group-prepend">
                                                     <span class="input-group-text">
                                                         dias
                                                     </span>
                                                 </div>
                                               </div>
                                              </div>
                                          </div>
                                          </div>

                                     
                                  
                                  </div>
                              </div>
                                       
            
                                             
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
 

function valueChanged4()
    {
        if($('#nc7').is(":checked"))   
            $("#accept_outofstock").show();
        else
            $("#accept_outofstock").hide();
    }

    function valueChanged5()
    {
        if($('#nc8').is(":checked"))   
            $("#addtime_outofstock").show().find("input").prop("required", true);
        else
            $("#addtime_outofstock").hide().find("input").prop("required", false);
    }

   var manage_stock= "<?php  echo $restaurant->manage_stock; ?>";  
   var accept_outofstock= "<?php  echo $restaurant->accept_outofstock; ?>"; 

   if (manage_stock== 1) {
   $('#accept_outofstock').removeClass('hidden');
   }else {
      $('#accept_outofstock').addClass('hidden');
   }
   if (accept_outofstock== 1) {
     $('#addtime_outofstock').removeClass('hidden').find("input").prop("required", true);
   }else {
     $('#addtime_outofstock').addClass('hidden').find("input").prop("required", false);
   }


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











$(document).ready(function () {




var delivery_type= "<?php  echo $restaurant->delivery_type; ?>";  

if ((delivery_type==1) || (delivery_type==3)) {
  
$('#raio_entrega').removeClass('hidden').find("input").prop("required", true);;
}
if (delivery_type==2) {
   $('#raio_entrega').addClass('hidden').find("input").prop("required", false);;

}
  


$("[name='delivery_type']").on("change", function () {
if ($(this).val() == 1) {
    
   $('#raio_entrega').removeClass('hidden').find("input").prop("required", true);;
}
if ($(this).val() == 2) {

   $('#raio_entrega').addClass('hidden').find("input").prop("required", false);;
}
if ($(this).val() == 3) {

   $('#raio_entrega').removeClass('hidden').find("input").prop("required", true);;
}


});







// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});








});



</script>
@endsection
