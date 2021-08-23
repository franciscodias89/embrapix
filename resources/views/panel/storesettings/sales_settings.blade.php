<div >
    <!-- Edit Profile -->
    <div class="edit-profile ">
        <div class="card">
            <div class="card-header  px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Configurações de Venda</h6>
                    <span class="fs-13 color-light fw-400"></span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    <button type="submit" form="salessettings_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
                    </button>
                    {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 col-sm-10">
                        <div class="edit-profile__body mx-lg-20">

                            <div class="atbd-nav-controller">
                                <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                    <a href="{{ route('panel.salesSettings') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-tipo_entrega"  aria-controls="tipo_entrega" aria-selected="true">Tipo de Venda</a>
                                    
                                    @if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3))
                               <a href="{{ route('panel.DeliveryTime') }}" class="btn btn-sm btn-outline-light nav-link " id="size-default"  aria-controls="default" aria-selected="false"> Tempo de Entrega</a>
                               @endif
                               @if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3))
                                <a href="{{ route('panel.SelfpickupTime') }}" class="btn btn-sm btn-outline-light nav-link " id="size-small"  aria-controls="small" aria-selected="false">Tempo de Retirada</a>
                                @endif
                                    
                                </div>
                             </div>
                            <form action="{{ route('settings.saveSalesSettings') }}" method="POST" id="salessettings_form" enctype="multipart/form-data">
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

                                       <div class="form-group mb-20">
                                        <label for="min_order_price">Pedido Mínimo</label>
        
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    R$
                                                </span>
                                            </div>
                                            <input required type="text" value="<?php if ($restaurant->min_order_price != null){ echo $restaurant->min_order_price; }else{echo '5,00';};?>" class="form-control dinheiro" name="min_order_price"
                                            id="min_order_price" 
                                            
                                            placeholder="Pedido Mínimo"
                                            data-parsley-lt2="5,00"
                                            data-parsley-lt2-message="O Pedido Mínimo deve ser maior ou igual a R$ 5,00" 
                                            >
                                        </div>
                                          <p><small>Menor valor de um pedido, sem contar a taxa de entrega.</small></p>
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
                                          <input type="number" min="2" max="20" 
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
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->
</div>

@section('scripts')






<script>
 $(document).ready(function() {
                var status= "<?php  echo $restaurant->status; ?>";  
              
                /* if (status<=7) {
                    $('.sidebar').addClass('hiddeen');
                    $('.contents').addClass('contents2');
                } */
                if (status<=20) {
                    $('.sidebar').addClass('collapsed');
                    $('.contents').addClass('expanded');
                }
                });



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