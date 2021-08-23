
      
     
                   <div class="card checkout-shipping-form px-30 pt-2 pb-30">
                      <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                        <h4 class="fw-500"><strong>Pronto! </strong></h4>
                        
                          </div>
                          <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                            <h4 class="fw-500"><strong>Parabéns, {{ $restaurant->name }}</strong></h4>
                               </div>
                               <div class='' style="text-align: center;" >
                                  <br>  
                                  <img class="light" style="width: 270px;" src="https://app.comprabakana.com.br/assets/img/illustrations/start.png" alt="">
                                  <br><br>     
                              </div>

                          <p><span class="mt-30"> Parabéns! Você já completou as principais etapas de seu cadastro!<span></p>
                              <p><span class="mt-30">  Agora o próximo passo é começar a cadastrar produtos, ofertas, promoções, e...<span></p>
                                  <p><span >   Começar a Vender!!!</span></p>
                     
                      <div class="card-body px-0 pb-0">
                         <div class="edit-profile__body">
                            <form action="{{ route('wizard.savewizard_1') }}" method="POST"  enctype="multipart/form-data">
                               @csrf
                               <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                              

                            
                              

                                 
                               <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                  <a href="{{ route('wizard.wizard_panel') }}" class="btn text-white btn-danger btn-default btn-squared text-capitalize m-1">Vamos Lá!<i class="ml-10 mr-0 las la-arrow-right"></i></a>
                               </div>
                             
                               
                            </form>
                         </div>
                      </div>
                   </div>
                   <!-- ends: card -->
     

@section('scripts')






<script>
  $(document).ready(function() {
                
                    $('.sidebar').addClass('hiddeen');
                    $('.contents').addClass('contents2');
                
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
