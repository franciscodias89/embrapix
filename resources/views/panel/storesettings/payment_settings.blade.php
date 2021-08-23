<div >
    <!-- Edit Profile -->
    <div class="edit-profile ">
        <div class="card">
            <div class="card-header  px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Configurações de Pagamento (App)</h6>
                    <span class="fs-13 color-light fw-400"></span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    <button type="submit" form="payment_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
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
                                  <a href="{{ route('panel.PaymentSettings') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-tipo_entrega"  aria-controls="tipo_entrega" aria-selected="true">Pagamento pelo App</a>
                                  @if(($restaurant->delivery_type ==1)||($restaurant->delivery_type ==3))
                                  <a href="{{ route('panel.PaymentDeliverySettings') }}" class="btn btn-sm btn-outline-light nav-link" id="size-default"  aria-controls="default" aria-selected="false"> Pagamento na Entrega</a>
                                  @endif
                                  @if(($restaurant->delivery_type ==2)||($restaurant->delivery_type ==3))
                                  <a href="{{ route('panel.PaymentSelfpickupSettings') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small"  aria-controls="small" aria-selected="false">Pagamento na Retirada</a>
                                  @endif
                              </div>
                           </div>

                           <form 
                           action="{{ route('settings.savePaymentSettings') }}" 
                           method="POST" 
                           enctype="multipart/form-data" 
                           data-parsley-trigger="keyup" 
                           id="payment_form"
                           data-parsley-validate
                           >
                           @csrf
                           <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                           <input hidden type="text" value="3" class="form-control" name="status">
                           <input hidden type="text" value="paymentapp" class="form-control" name="tipo">

                              <div class="notification-content p-25 border mb-25 mt-25">
                                 <div class="notification-content__title d-flex justify-content-between flex-wrap pb-20 text-capitalize">
                                    <h6 class="fs-15 text-light fw-500 lh-normal">Pagamento pelo App</h6>
                                    <a class="text-primary fs-13" href="#"></a>
                                 </div>
                                 <div class="global-shadow radius-xl bg-white">
                                    <div class="notification-content__body p-25 border-bottom">
                                       <div class="d-flex justify-content-between flex-wrap align-items-center">
                                          <div class="div col-lg-10 col-sm-10">
                                             <h6>Habilitar Pagamento pelo App (CompraBakana Pay)</h6> <br><small> (* Recomendado)</small>
                                             <span>Ao habilitar o pagamento pelo app, os usuários poderão pagar com cartão de crédito ou PIX diretamente através do aplicativo. Serão cobradas taxas de cartão de crédito, somente se o usuário optar pelo pagamento no App. </span>
                                          </div>
                                          <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2" style="float: right">
                                             <input type="checkbox" class="custom-control-input" onchange="valueChanged4()" name="payment_app_accept" id="nc1" @if($restaurant->payment_app_accept) checked="checked" @endif >
                                             <label class="custom-control-label"  for="nc1"></label>
                                          </div>
                                       </div>
                                 </div>
                                 </div>

                                 <div class="global-shadow radius-xl bg-white" id="contabancaria">
                                    <div class="notification-content__body p-25 border-bottom">
                                       <div class="d-flex justify-content-between flex-wrap align-items-center">
                                          <div class="div col-lg-12 col-sm-12">
                                             <h6>Dados Bancários para Recebimento</h6> <br><small></small>
                                             <span> Esta é a conta bancária onde você receberá os pagamentos referentes às suas vendas no aplicativo. Você poderá alterar a conta bancária depois. </span>
                                          </div>
                                             <div class="div col-lg-12 col-sm-12"><br>
                                                <span class="mb-40 mt-20">Se você marcou "MEI" ou "Empresa" (Pessoa jurídica), os dados bancários abaixo devem estar relacionados ao seu CNPJ. Se você marcou "Pessoa Física", os dados bancários devem ser relacionados ao seu CPF.</span>
                                                                                                       
                                                                      <div class="form-group mb-20 mt-20">
                                                                          <label ><span
                                                                              class="text-danger">*</span>Banco:</label>
                                                                          <select class="js-example-basic-single js-states form-control"
                                                                              name="bank" id="bank" >
                                                                              <option value="341" class="text-capitalize" <?php if ($subaccount->bank ==='341') { echo "selected"; } ?> >Itaú</option>
                                                                              <option value="237" class="text-capitalize" <?php if ($subaccount->bank ==='237') { echo "selected"; } ?> >Bradesco</option>
                                                                              <option value="104" class="text-capitalize" <?php if ($subaccount->bank ==='104') { echo "selected"; } ?> >Caixa Econômica</option>
                                                                              <option value="001" class="text-capitalize" <?php if ($subaccount->bank ==='001') { echo "selected"; } ?> >Banco do Brasil</option>
                                                                              <option value="033" class="text-capitalize" <?php if ($subaccount->bank ==='033') { echo "selected"; } ?> >Santander</option>
                                                                              <option value="041" class="text-capitalize" <?php if ($subaccount->bank ==='041') { echo "selected"; } ?> >Banrisul</option>
                                                                              <option value="748" class="text-capitalize" <?php if ($subaccount->bank ==='748') { echo "selected"; } ?> >Sicredi</option>
                                                                              <option value="756" class="text-capitalize" <?php if ($subaccount->bank ==='756') { echo "selected"; } ?> >Sicoob</option>
                                                                              <option value="077" class="text-capitalize" <?php if ($subaccount->bank ==='077') { echo "selected"; } ?> >Inter</option>
                                                                              <option value="070" class="text-capitalize" <?php if ($subaccount->bank ==='070') { echo "selected"; } ?> >BRB</option>
                                                                              <option value="085" class="text-capitalize" <?php if ($subaccount->bank ==='085') { echo "selected"; } ?> >Via Credi</option>
                                                                              <option value="655" class="text-capitalize" <?php if ($subaccount->bank ==='655') { echo "selected"; } ?> >Neon</option>
                                                                              <option value="260" class="text-capitalize" <?php if ($subaccount->bank ==='260') { echo "selected"; } ?> >Nubank</option>
                                                                              <option value="290" class="text-capitalize" <?php if ($subaccount->bank ==='290') { echo "selected"; } ?> >Pagseguro</option>
                                                                              <option value="212" class="text-capitalize" <?php if ($subaccount->bank ==='212') { echo "selected"; } ?> >Banco Original</option>
                                                                              <option value="422" class="text-capitalize" <?php if ($subaccount->bank ==='422') { echo "selected"; } ?> >Safra</option>
                                                                              <option value="746" class="text-capitalize" <?php if ($subaccount->bank ==='746') { echo "selected"; } ?> >Modal</option>
                                                                              <option value="021" class="text-capitalize" <?php if ($subaccount->bank ==='021') { echo "selected"; } ?> >Banestes</option>
                                                                              <option value="274" class="text-capitalize" <?php if ($subaccount->bank ==='274') { echo "selected"; } ?> >Money Plus</option>
                                                                              <option value="389" class="text-capitalize" <?php if ($subaccount->bank ==='389') { echo "selected"; } ?> >Mercantil do Brasil</option>
                                          
                                                                              
                                                                          </select>
                                                                      </div>
                                          </div>
                                                                    <div class="row" style="margin-left: 5px">
                                                                     <div class="div col-lg-6 col-sm-5" >
                                                                        <div class="form-group mb-20">
                                                                            <label for="bank_ag">Agência</label>
                                                                            <input  type="text" value="{{ $subaccount->bank_ag }}" 
                                                                            class="form-control bank_ag" name="bank_ag"
                                                                            id="bank_ag"  >
                                                                        </div>
                                                                        
                                                                     </div>
                                                                     <div class="div col-lg-2 col-sm-2" >
                                                                        <div class="form-group mb-20">
                                                                            <label for="bank_ag">Dígito</label>
                                                                            <input  type="text" value="{{ $subaccount->bank_ag_digit }}" 
                                                                            class="form-control bank_ag" 
                                                                            name="bank_ag_digit"
                                                                            id="bank_ag_digit"  >
                                                                        </div>
                                                                        
                                                                     </div>
                                                                     
                                                                    </div>
                                                                     <div class="row" style="margin-left: 5px">
                                                                     <div class="div col-lg-6 col-sm-5">
                                                                        <div class="form-group mb-20">
                                                                          <label for="bank_cc">Conta Corrente</label>
                                                                          <input  type="text" value="{{ $subaccount->bank_cc }}" 
                                                                          class="form-control bank_cc" name="bank_cc"
                                                                          id="bank_cc"  >
                                                                      </div>
                                                                     </div>
                                                                     <div class="div col-lg-2 col-sm-2" >
                                                                        <div class="form-group mb-20">
                                                                          <label for="bank_cc">Dígito</label>
                                                                          <input  type="text" 
                                                                          value="{{ $subaccount->bank_cc_digit }}" 
                                                                          class="form-control bank_cc" 
                                                                          name="bank_cc_digit"
                                                                          id="bank_cc_digit"  >
                                                                      </div>
                                                                     </div>
                                                                     
                                                                    </div>
                                                                    </div>
                                                                     <div class="div col-lg-12 col-sm-12">
                                                                        <div class="form-group mb-20">
                                                                          <label ><span
                                                                              class="text-danger">*</span>Tipo de Conta:</label>
                                                                          <select class="js-example-basic-single js-states form-control"
                                                                              name="account_type" id="account_type">
                                                                              <option value="Corrente" class="text-capitalize" <?php if ($subaccount->account_type ==='Corrente') { echo "selected"; } ?> >Corrente</option>
                                                                              <option value="Poupança" class="text-capitalize" <?php if ($subaccount->account_type ==='Poupança') { echo "selected"; } ?> >Poupança</option>
                                                                          </select>
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











    function valueChanged4()
    {
        if($('#nc1').is(":checked")){
            $("#contabancaria").show();
            $("#bank_ag").prop("required", true);
            //$("#bank_ag_digit").prop("required", true);
            $("#bank_cc").prop("required", true);
            //$("#bank_cc_digit").prop("required", true);
        }   
            
        else{
            $("#contabancaria").hide();
            $("#bank_ag").prop("required", false);
           // $("#bank_ag_digit").prop("required", false);
            $("#bank_cc").prop("required", false);
           /// $("#bank_cc_digit").prop("required", false);
        }
           
    }

$(document).ready(function () {




  
var payment_app_accept= "<?php  echo $restaurant->payment_app_accept; ?>"; 

if (payment_app_accept== 1) {
  
    $("#contabancaria").show();
            $("#bank_ag").prop("required", true);
            //$("#bank_ag_digit").prop("required", true);
            $("#bank_cc").prop("required", true);
            //$("#bank_cc_digit").prop("required", true);


}else {
    $("#contabancaria").hide();
            $("#bank_ag").prop("required", false);
            //$("#bank_ag_digit").prop("required", false);
            $("#bank_cc").prop("required", false);
            //$("#bank_cc_digit").prop("required", false);

}

  







});













// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});












</script>
@endsection
