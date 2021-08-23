<div >
    <!-- Edit Profile -->
    <div class="edit-profile edit-social ">
        <div class="card">
            <div class="card-header px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Teste da Loja no Aplicativo</h6>
                    <span class="fs-13 color-light fw-400">Visualize sua loja no APP Compra Bakana mesmo antes de ser publicada oficialmente!</span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    <button type="submit" form="configuracoes_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar 
                    </button>
                    {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="notification-content p-25 border mb-25">
                    <div class="notification-content__title d-flex justify-content-between flex-wrap pb-20 text-capitalize">
                        <h6 class="fs-15 text-light fw-500 lh-normal">Usuário de Teste</h6>
                        <a class="text-primary fs-13" href="#"></a>
                    </div>
                    <div class="global-shadow radius-xl bg-white">
                        <form 
                            action="{{ route('settings.saveUserTester') }}" 
                            method="POST" 
                            id="configuracoes_form" 
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
                                                  <h6>Email de acesso ao APP Compra Bakana</h6>
                                                  <span>Informe abaixo o email de login no App Compra Bakana (pode ser conta do google, apple, ou cadastro feito só com email) </span>
                                                  <div class="form-group"  >
                                                    @if($restaurant_userTester!=null)
                                                    <br>
                                                    <input type="text" value="{{$restaurant_userTester->user_tester_email}}" 
                                                       class="form-control  "
                                                       name="user_tester_email" placeholder="" >
                                                    @else
                                                    <br>
                                                    <input type="text"  
                                                    class="form-control  "
                                                    name="user_tester_email" placeholder="" >
                                                    @endif
                                                    <br>
                                                    <span>Depois de adicionar o email de acesso ao APP no campo acima e clicar em "Salvar", você já poderá acessar o App Compra Bakana (se já estava com o APP aberto, feche-o e abra-o novamente). Você já irá visualizar sua loja na lista de lojas, e poderá simular compras e pedidos para testar o funcionamento do app e o recebimento de pedidos pelo painel.  </span> 
                                                </div>
                                                </div>
                                              

                                          </div>
                                      </div>
                                     

                                      

                                     
                                  
                                  </div>
                              </div>
                                       
            
                                             
                                             
                                          
                    </form>
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
