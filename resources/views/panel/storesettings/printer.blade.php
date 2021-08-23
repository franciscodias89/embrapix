<div >
    <!-- Edit Profile -->
    <div class="edit-profile edit-social ">
        <div class="card">
            <div class="card-header px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6>Configurações de Impressora Térmica</h6>
                    <span class="fs-13 color-light fw-400">Instale nosso APP de impressão em impressora térmica e escolha a sua impressora.</span>
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
                        <h6 class="fs-15 text-light fw-500 lh-normal">Impressora Térmica</h6>
                        <a class="text-primary fs-13" href="#"></a>
                    </div>
                    <div class="global-shadow radius-xl bg-white">
                        <form 
                            action="{{ route('settings.savePrinter') }}" 
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
                                                  <h6>Passo 1) Instalar WCPP</h6>
                                                  <br>
                                                  <span>1.1) Faça o download do nosso Programa de Impressão (WebClientPrint Processor (WCPP)) </span>
                                                  <br><br>
                                                  <div > 
                                                    <a href="https://www.neodynamic.com/downloads/wcpp/wcpp-6.0.0.0-win.exe"
                                                       class="btn btn-primary btn-default btn-squared text-capitalize  px-25"
                                                       
                                                       > Download WCPP (Windows)
                                                    </a><br>
                                                    <a href="https://www.neodynamic.com/downloads/wcpp/wcpp-6.0.0.0-intel-x86_64-macosx.dmg"
                                                       class="btn btn-primary btn-default btn-squared text-capitalize  px-25"
                                                       
                                                       > Download WCPP (Mac)
                                                    </a>
                            
                                              </div>
                                              <br>
                                              <span>1.2) Instale o "WebClientPrint Processor (WCPP)"" em seu computador</span>
                                              <br><br>
                                              <span>1.3) Depois de instalado, siga para o próximo passo (Passo 2) Definir Impressora)</span>
                                                  
                                                </div>
                                              

                                          </div>
                                        </div>
                                        <div class="notification-content__body p-25 border-bottom">
                                                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                                              <div class="div col-lg-10 col-sm-10">
                                                  <h6>Passo 2) </h6>
                                                  <br>
                                                  
                                               
                                                     @if($printer_data['printer_name'])
                                                        <span><strong>Impressora Selecionada: </strong>{{ $printer_data['printer_name'] }} </span>
                                                        <br><br><a href="javascript:void(0)"
                                                        class="btn btn-primary btn-default btn-squared text-capitalize  px-25"
                                                        id="trocar"
                                                        > Trocar Impressora
                                                        </a>
                                                        <br><br>
                                                        <div id="loadPrinters">
                                                            <span>Clique no botão abaixo para procurar as impressoras instaladas em seu computador </span>
                                                            <br><br>
                                                            <input type="button"  class="btn btn-primary btn-default btn-squared text-capitalize  px-25" onclick="javascript:jsWebClientPrint.getPrinters();" value="Buscar Impressoras Instaladas..." />
                                                                            
                                                            <br /><br />
                                                            </div>
                                                            <div id="installedPrinters" style="visibility:hidden">
                                                            <br />
    
    
                                                            <label for="installedPrinterName">Selecione uma Impressora:</label>
                                                            <select name="printer_name" id="installedPrinterName"></select>
                                                            </div>
                                                    @else
                                                        <div id="loadPrinters">
                                                        <span>2.1) Clique no botão abaixo para procurar as impressoras instaladas em seu computador </span>
                                                        <br><br>
                                                        <input type="button"  class="btn btn-primary btn-default btn-squared text-capitalize  px-25" onclick="javascript:jsWebClientPrint.getPrinters();" value="Buscar Impressoras Instaladas..." />
                                                                        
                                                        <br /><br />
                                                        </div>
                                                        <div id="installedPrinters" style="visibility:hidden">
                                                        <br />


                                                        <label for="installedPrinterName">Selecione uma Impressora:</label>
                                                        <select name="printer_name" id="installedPrinterName"></select>
                                                        </div>
                                                    @endif
                                                     

                                                
                                              

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





<script type="text/javascript">
	var wcppGetPrintersTimeout_ms = 60000; //60 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

	function wcpGetPrintersOnSuccess(){
		// Display client installed printers
		if(arguments[0].length > 0){
			var p=arguments[0].split("|");
			var options = '';
			for (var i = 0; i < p.length; i++) {
				options += '<option>' + p[i] + '</option>';
			}
			$('#installedPrinters').css('visibility','visible');
			$('#installedPrinterName').html(options);
			$('#installedPrinterName').focus();
			$('#loadPrinters').hide();                                                        
		}else{
			alert("Não há nenhuma impressora instalada em seu computador.");
		}
	}

	function wcpGetPrintersOnFailure() {
		// Do something if printers cannot be got from the client
		alert("Não há nenhuma impressora instalada em seu computador.");
	}

</script>


{!! 

// Register the WebClientPrint script code
// The $wcpScript was generated by PrintESCPOSController@index

$wcpScript;

!!}




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



   
   //$("#loadPrinters").hide();

   $("#trocar").click(function () {
        $("#loadPrinters").show();
    });


    
    var printer_name= "<?php  echo $printer_data['printer_name'] ?>";  
  
   if (printer_name) {
    $('#loadPrinters').hide();
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
