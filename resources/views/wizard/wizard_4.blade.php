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
                     <div class="step current" id="4">
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
                                  <a href="{{ route('wizard.wizard_4') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-tipo_entrega" data-toggle="tab" role="tab" aria-controls="tipo_entrega" aria-selected="true">Tipo de Venda</a>
                                  <a href="{{ route('wizard.wizard_4_1') }}" class="btn btn-sm btn-outline-light nav-link" id="size-default" data-toggle="tab" role="tab" aria-controls="default" aria-selected="false"> Tempo de Entrega</a>
                                  <a href="{{ route('wizard.wizard_4_2') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Tempo de Retirada</a>
                                  <a href="{{ route('wizard.wizard_4_3') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Formas de Pagamento</a>
                              </div>
                           </div>
                          
                          
                                       <div class="edit-profile__body">
                                          <form 
                                       action="{{ route('wizard.savewizard_4') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
            
                                       
                                       
                                       <div class="form-group mb-20 mt-30">
                                          <label ><span
                                                class="text-danger">*</span>Tipo de Venda Aceitável:</label>
                        
            
                                          <div class="radio-theme-default custom-radio ">
                                                <input class="radio delivery_type" type="radio" name="delivery_type" value="1" id="radio-un2" <?php if ($restaurant->delivery_type == 1) { echo "checked"; } ?> >
                                                <label for="radio-un2">
                                                <span class="radio-text">Somente Delivery</span>
                                                </label>
                                             </div>
                                             <div class="radio-theme-default custom-radio ">
                                                <input class="radio delivery_type" type="radio" name="delivery_type" value="2" id="radio-un1" <?php if ($restaurant->delivery_type == 2) { echo "checked"; } ?>  >
                                                <label for="radio-un1">
                                                <span class="radio-text">Somente Retirada na Loja</span>
                                                </label>
                                             </div>
                                             <div class="radio-theme-default custom-radio " >
                                                <input class="radio delivery_type" type="radio" name="delivery_type" value="3" id="radio-un4" <?php if ($restaurant->delivery_type == 3) { echo "checked"; } ?> >
                                                <label for="radio-un4">
                                                <span class="radio-text">Delivery e Retirada na Loja</span>
                                                </label>
                                             </div>
            
            
                                       </div>
            
                                       <div class="form-group  pr0"  >
                                          <label for="restaurant_charges">Taxa de Serviço:</label><small> (opcional)</small>
                                          <input type="text" value="{{$restaurant->restaurant_charges}}" 
                                             class="form-control  dinheiro"
                                             name="restaurant_charges" placeholder="" value="{{$restaurant->restaurant_charges  }}">
                                             <small> A Taxa de Serviço é opcional (Ex: taxa para embalagem ou organização dos produtos, etc)</small>
                                    </div>
            
                                    <div class="form-group  pr0 hidden"  id="raio_entrega">
                                          <label for="delivery_radius">Raio de Entrega em Km:</label>
                                          <input type="number" 
                                          value="{{$restaurant->delivery_radius}}" 
                                          class="form-control delivery_radius"
                                          name="delivery_radius" 
                                          placeholder="Raio de Entrega em Km "
                                          data-parsley-max="20" 
                                          data-parsley-min="1"
                                          required
                                          >
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
