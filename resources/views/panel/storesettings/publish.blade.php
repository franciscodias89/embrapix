<div >
    <!-- Edit Profile -->
    <div class="edit-profile edit-social ">
        <div class="card">
            <div class="card-header px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Publicar Loja no APP</h6>
                    <span class="fs-13 color-light fw-400">Se você já concluiu os cadastros e configurações, você pode solicitar a publicação de sua loja no APP Compra Bakana</span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    
                    {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 col-sm-10">
                        <div class="edit-profile__body mx-lg-20">
                            
                          <span>Se Você já:</span>
                          <br><br>
                          <span>1) Finalizou o cadastro dos dados de sua loja</span>
                          <br><br>
                          <span>2) Preencheu as informações de Delivery (tempo de entrega, taxas de entrega, etc)</span>
                          <br><br>
                          <span>3) Configurou as formas de Pagamento</span>
                          <br><br>
                          <span>4) Cadastrou Produtos, categorias</span>
                          <br><br>
                          <span>5) Cadastrou Cashback ou pelo menos 1 cupom de desconto</span>
                          <br><br>
                          <span>6) Fez um teste de Pedido em sua loja no app, impressão de pedidos, e está tudo certo com essa parte</span>
  
                          <br><br>
                          <span>...Você poderá então clicar no botão abaixo e solicitar a publicação de sua loja no App.</span>
                          <br>
                            
                          <form 
                          action="{{ route('settings.publishStore') }}" 
                          method="POST" 
                          id="configuracoes_form" 
                          enctype="multipart/form-data" 
                          data-parsley-trigger="keyup" 
                          data-parsley-validate
                          >
                          @csrf
                                     <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                
                                <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                  <button type="submit" form="configuracoes_form" class="btn text-white btn-danger btn-default btn-squared text-capitalize m-1">Publicar Loja no APP! 
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
