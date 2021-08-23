<div >
    <!-- Edit Profile -->
    <div class="edit-profile ">
        <div class="card">
            <div class="card-header  px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Configurações de Pagamento (Retirada)</h6>
                    <span class="fs-13 color-light fw-400"></span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    <button type="submit" form="paymentselfpickup_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
                    </button>
                    {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-sm-10">
                        <div class="edit-profile__body mx-lg-20">

                           <div class="atbd-nav-controller">
                              <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                  <a href="{{ route('panel.PaymentSettings') }}" class="btn btn-sm btn-outline-light nav-link " id="size-tipo_entrega"  aria-controls="tipo_entrega" aria-selected="false">Pagamento pelo App</a>
                                  @if(($restaurant->delivery_type ==1)||($restaurant->delivery_type ==3))
                                  <a href="{{ route('panel.PaymentDeliverySettings') }}" class="btn btn-sm btn-outline-light nav-link" id="size-default"  aria-controls="default" aria-selected="false"> Pagamento na Entrega</a>
                                  @endif
                                  @if(($restaurant->delivery_type ==2)||($restaurant->delivery_type ==3))
                                  <a href="{{ route('panel.PaymentSelfpickupSettings') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-small"  aria-controls="small" aria-selected="true">Pagamento na Retirada</a>
                                  @endif
                              </div>
                           </div>

                           <form 
                           action="{{ route('settings.savePaymentSelfpickupSettings') }}" 
                           method="POST" 
                           enctype="multipart/form-data" 
                           data-parsley-trigger="keyup"
                           id="paymentselfpickup_form" 
                           data-parsley-validate
                           >
                           @csrf
                           <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                           <input hidden type="text" value="3" class="form-control" name="status">
                           <input hidden type="text" value="paymentselfpickup" class="form-control" name="tipo">

                              <div class="notification-content p-25 border mb-25 mt-25">
                                 <div class="notification-content__title d-flex justify-content-between flex-wrap pb-20 text-capitalize">
                                    <h6 class="fs-15 text-light fw-500 lh-normal">Pagamento na Retirada (Balcão)</h6>
                                    <a class="text-primary fs-13" href="#"></a>
                                 </div>
                                 <div class="global-shadow radius-xl bg-white">
                                    <div class="notification-content__body p-25 border-bottom">
                                       <div class="d-flex justify-content-between flex-wrap align-items-center">
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>Habilitar Pagamento na Retirada</h6> <br><small></small>
                                             <span>Ao habilitar o pagamento pelo app, os usuários poderão pagar diretamente no balcão da loja (ao retirar o produto), em dinheiro ou cartão (usando a maquinhinha da loja). Não será cobrada nenhuma taxa. </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input" onchange="valueChanged5()" name="payment_selfpickup_accept" id="nc1" @if($restaurant->payment_selfpickup_accept) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc1"></label>
                                          </div>
                                       </div>
                                 </div>
                                 </div>
                                 <div class="global-shadow radius-xl bg-white" id="pagamento_retirada">
                                    <div class="notification-content__body p-25 border-bottom">
                                       <div class="d-flex justify-content-between flex-wrap align-items-center">
                                          <div class="mt-40 mb-30">
                                             <span ><strong>Formas de Pagamento:</strong></span>
                                          </div>
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>Dinheiro</h6> <br><small></small>
                                             <span> </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_money" id="nc8" @if($selfpickup_payment_type['selfpickup_payment_type_money']) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc8"></label>
                                          </div>
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>Cartão de Crédito</h6> <br><small></small>
                                             <span> </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_credit_card" id="nc9" @if($selfpickup_payment_type['selfpickup_payment_type_credit_card']) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc9"></label>
                                          </div>
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>Cartão de Débito</h6> <br><small></small>
                                             <span> </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_debit_card" id="nc10" @if($selfpickup_payment_type['selfpickup_payment_type_debit_card']) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc10"></label>
                                          </div>
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>PIX</h6> <br><small></small>
                                             <span> </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input"  name="selfpickup_payment_type_pix" id="nc11" @if($selfpickup_payment_type['selfpickup_payment_type_pix']) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc11"></label>
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









    function valueChanged5()
    {
        if($('#nc1').is(":checked")){
         $("#pagamento_retirada").show();
        }   
            
        else{
         $("#pagamento_retirada").hide();
        }
           
    }

$(document).ready(function () {




var payment_selfpickup_accept= "<?php  echo $restaurant->payment_selfpickup_accept; ?>";  
var payment_app_accept= "<?php  echo $restaurant->payment_app_accept; ?>"; 

if (payment_selfpickup_accept== 1) {
  
   $("#pagamento_retirada").show();


}else {
   $("#pagamento_retirada").hide();

}








});













// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});












</script>
@endsection
