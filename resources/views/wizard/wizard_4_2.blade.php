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
                                  <a href="{{ route('wizard.wizard_4_1') }}" class="btn btn-sm btn-outline-light nav-link " id="size-default" data-toggle="tab" role="tab" aria-controls="default" aria-selected="true"> Tempo de Entrega</a>
                                  <a href="{{ route('wizard.wizard_4_2') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Tempo de Retirada</a>
                                  <a href="{{ route('wizard.wizard_4_3') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Formas de Pagamento</a>
                              </div>
                           </div>
                          
                          
                                       <div class="edit-profile__body">
                                          <form 
                                       action="{{ route('wizard.savewizard_4_2') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
            
                                       
                                       
                                       <div class="form-group mb-20 mt-30">
                                          

                                                
                                               
                                                   <label for="delivery_radius">Tempo para Retirada na Loja:</label>
                                                   <div class="row">
                                                   <div class='col-lg-6' style="float: left;">
                                                   <input 
                                                   type="number" 
                                                   value="{{$restaurant->selfpickup_time}}"
                                                   class="form-control  delivery_radius"
                                                   name="selfpickup_time" 
                                                   placeholder="Tempo para Retirada na Loja " 
                                                  required
                                                  
                                                   >
                                                   </div>
                                                   <div class='col-lg-6' style="float: right;">
                                                      <select class="js-example-basic-single js-states form-control"
                                                      name="selfpickup_time_type" id="bank" data-parsley-required="true">
                                                      <option value="min" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='min') { echo "selected"; } ?> >min</option>
                                                      <option value="horas" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='horas') { echo "selected"; } ?> >horas</option>
                                                      <option value="dias" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='dias') { echo "selected"; } ?> >dias</option>

                                                  </select>
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
