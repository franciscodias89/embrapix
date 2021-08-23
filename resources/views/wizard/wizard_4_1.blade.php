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
                  <div class="col-xl-8 col-lg-9 col-sm-10">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                           <h4 class="fw-500">4. Configurações de Delivery</h4>
                            </div>
                           
                           
                        <div class="card-body px-0 pb-0">


                           <div class="atbd-nav-controller">
                              <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                  
                                 <a href="{{ route('wizard.wizard_4') }}" class="btn btn-sm btn-outline-light nav-link" id="size-tipo_entrega" data-toggle="tab" role="tab" aria-controls="tipo_entrega" aria-selected="false">Tipo de Venda</a>
                                 <a href="{{ route('wizard.wizard_4_1') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-default" data-toggle="tab" role="tab" aria-controls="default" aria-selected="true"> Tempo de Entrega</a>
                                  @if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3))
                                  <a href="{{ route('wizard.wizard_4_2') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Tempo de Retirada</a>
                                  @endif
                                  <a href="{{ route('wizard.wizard_4_3') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small" data-toggle="tab" role="tab" aria-controls="small" aria-selected="false">Formas de Pagamento</a>
                              </div>
                           </div>
                          
                          
                                       <div class="edit-profile__body">
                                          <form 
                                       action="{{ route('wizard.savewizard_4_1') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
            
                                       
                                       
                                       <div class="form-group mb-20 mt-30">
                                          <label ><span
                                                class="text-danger">*</span>Configure abaixo o tempo de entrega e a taxa de entrega para cada faixa de distância.</label>

                                       {{--          <span>ATENÇÃO!! Apareça em uma lista especial e ganhe destaque no Compra Bakana com entrega grátis até 1 km.</span> --}}
                                                <br><br>
                                                <div class="d-flex justify-content-between flex-wrap align-items-center">
                                                   <div class="div col-lg-10 col-sm-10">
                                                       <h6>Habilitar Entrega Grátis para compras acima de R$</h6>
                                                       <span>Ao selecionar, aparecerá um campo de "Entrega Grátis acima de (R$)" na tabela abaixo, que deverá ser preenchido para cada distância </span>
                                                   </div>
                                                   <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                                       <input type="checkbox" class="custom-control-input" onchange="valueChanged10()" name="price_free_shipping_active" id="nc10" @if($restaurant->price_free_shipping_active) checked="checked" @endif >
                                                       <label class="custom-control-label"  for="nc10"></label>
                                                   </div>
                                               </div>

                                                <div class='form-group row mt-40' style="vertical-align: middle"> 
                                                   <div class='col-lg-2' >
                                                      <span style="vertical-align: middle" ><strong>Distância</strong></span>
                                                   </div>
                                                   <div class='col-lg-2'>
                                                      <span><strong>Taxa (R$)</strong></span>
                                                   </div>
                                                   <div class='col-lg-3' id="price_free_shipping_title">
                                                      <span><strong>Entrega Grátis acima de (R$):</strong></span>
                                                   </div>
                                                   <div class='col-lg-2'>
                                                      <span><strong>Tempo</strong></span>
                                                   </div>
                                                   <div class='col-lg-3'>
                                                      <span><strong>Min/Horas/Dias</strong></span>
                                                   </div>

                                                </div>
                                                @foreach ($radius_vector as $vector)

                                                <div class='form-group row'> 
                                                    <div class=''>
                                                    <input type="text" hidden name="time_km[{{$loop->index}}][id]" value="{{$list_distance[$loop->index]['id']}}">
                                                   </div>  

                                                   <div class='col-lg-2'>
                                                      @if(($list_distance[$loop->index]['km'])=='1')
                                                      <span> Até {{ $list_distance[$loop->index]['km'] }} Km 
                                                      @else
                                                      <span> De {{ $list_distance[$loop->index -1]['km'] }} a {{ $list_distance[$loop->index]['km'] }} Km  
                                                      @endif
                                                    <input type='text' class='form-control clock form-control-lg' hidden  value="{{ $list_distance[$loop->index]['km'] }}" name="time_km[{{$loop->index}}][km]" placeholder="Km"> 
                                                   </div>  
                                                   <div  class='col-lg-2'> 
                                                    <input type='text' class='form-control clock form-control-lg dinheiro' value="{{ $list_distance[$loop->index]['price'] }}" name="time_km[{{$loop->index}}][price]" placeholder="Preço"> 
                                                   </div>  
                                                   <div  class='col-lg-3 price_free_shipping'> 
                                                      <input type='text' class='form-control clock form-control-lg dinheiro' @if(isset($list_distance[$loop->index]['price_free_shipping'])) value="{{  $list_distance[$loop->index]['price_free_shipping']  }}" @endif name="time_km[{{$loop->index}}][price_free_shipping]" placeholder="Valor"> 
                                                     </div> 
                                                   <div  class='col-lg-2'> 
                                                         <input type='number' class='form-control clock form-control-lg' value="{{ $list_distance[$loop->index]['time'] }}" name="time_km[{{$loop->index}}][time]" placeholder="Tempo"> 
                                                   </div> 
                                                   <div  class='col-lg-3'>

                                                      <select  class="js-example-basic-single js-states form-control"   required parsley-trigger="change" data-parsley-errors-container="#select22"  data-parsley-group="form-step-1" name="time_km[{{$loop->index}}][type]" data-parsley-required>
                                             
                                                         <option value="min" class="text-capitalize" <?php if ($list_distance[$loop->index]['type'] =='min') { echo "selected"; } ?> > Minutos</option>
                                                         <option value="horas" class="text-capitalize" <?php if ($list_distance[$loop->index]['type'] =='horas') { echo "selected"; } ?> > Horas</option>
                                                         <option value="dias" class="text-capitalize" <?php if ($list_distance[$loop->index]['type'] =='dias') { echo "selected"; } ?> > Dias</option>
                                                      </select>
                                                   </div> 
                                                   {{--  <div class='col-lg-1'> 
                                                        <div class="checkbox checkbox-switchery ml-1" style="padding-top: 0.8rem;">
                                                            <label>
                                                            <input value="true" type="checkbox" class="action-switch"
                                                            @if($addon->is_active) checked="checked" @endif data-id="{{ $addon->id }}">
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                                    <div class='col-lg-1'> 
                                                    
                                                    
                                                </div>
                                                    
                                                </div>
                                                @endforeach
            
                                       
            
                                             
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

var price_free_shipping_active= "<?php  echo $restaurant->price_free_shipping_active; ?>"; 

if (price_free_shipping_active== 1) {
$('.price_free_shipping').removeClass('hidden');
$('#price_free_shipping_title').removeClass('hidden');
}else {
   $('.price_free_shipping').addClass('hidden');
   $('#price_free_shipping_title').addClass('hidden');
}
function valueChanged10()
    {
        if($('#nc10').is(":checked")) {
         $(".price_free_shipping").show();
            $("#price_free_shipping_title").show();
        }              
        else{
         $(".price_free_shipping").hide();
            $("#price_free_shipping_title").hide();
        }
            
    }


/* $("#select-time_type[]").select2({
        placeholder: "Selecione uma Opção",
        dropdownCssClass: "tag",
        
        allowClear: true,
    }); */

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
  
$('#raio_entrega').removeClass('hidden').find("input").prop("required", true);
}
if (delivery_type==2) {
   $('#raio_entrega').addClass('hidden').find("input").prop("required", false);

}
  


$("[name='delivery_type']").on("change", function () {
if ($(this).val() == 1) {
    
   $('#raio_entrega').removeClass('hidden').find("input").prop("required", true);
}
if ($(this).val() == 2) {

   $('#raio_entrega').addClass('hidden').find("input").prop("required", false);
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
