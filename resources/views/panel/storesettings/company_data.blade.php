<div >
  <!-- Edit Profile -->
  <div class="edit-profile edit-social ">
      <div class="card">
          <div class="card-header  px-sm-25 px-3">
              <div class="edit-profile__title">
                  <h6>Dados Cadastrais</h6>
                  <span class="fs-13 color-light fw-400">Os campos abaixo devem ser preenchidos com muito cuidado, pois são dados importantes para a criação da sua conta no CompraBakana.</span>
              </div>
              <div class="button-group d-flex flex-wrap pt-30 mb-15">
                <button type="submit" form="companydata_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
                </button>
                {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                </button> --}}
            </div>
          </div>
          <div class="card-body">
              <div class="row justify-content-center">
                  <div class="col-lg-6">
                      <div class="edit-profile__body mx-lg-20">
                        <form action="{{ route('settings.saveCompanyData') }}" method="POST" id="companydata_form" enctype="multipart/form-data">
                            @csrf
                            <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">

                               <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
                            <div class="form-group mb-20">
                                <label ><span
                                    class="text-danger">*</span>Tipo:</label>
            {{--                     <select class="js-example-basic-single js-states form-control"
                                    name="person_type" id="select-person_type" required>
                                    <option value="Pessoa Jurídica" class="text-capitalize" >Pessoa Jurídica</option>
                                    <option value="Pessoa Física" class="text-capitalize" >Pessoa Física</option>
                                    
                                </select> --}}

                                <div class="radio-theme-default custom-radio ">
                                    <input class="radio person_type" type="radio" name="person_type" value="Mei" id="radio-un2" <?php if ($restaurant->person_type ==='Mei') { echo "checked"; }  ?> >
                                    <label for="radio-un2">
                                    <span class="radio-text">MEI (Microempreendedor Individual)</span>
                                    </label>
                                 </div>
                                 <div class="radio-theme-default custom-radio ">
                                    <input class="radio person_type" type="radio" name="person_type" value="Empresa" id="radio-un1" <?php if ($restaurant->person_type ==='Empresa') { echo "checked"; }  ?> >
                                    <label for="radio-un1">
                                    <span class="radio-text">Empresa (de qualquer porte, exceto MEI)</span>
                                    </label>
                                 </div>
                                 <div class="radio-theme-default custom-radio " >
                                    <input class="radio person_type" type="radio" name="person_type" value="Pessoa Física" id="radio-un4" <?php if ($restaurant->person_type ==='Pessoa Física') { echo "checked"; } ?> >
                                    <label for="radio-un4">
                                    <span class="radio-text">Pessoa Física</span>
                                    </label>
                                 </div>


                            </div>
                            <div id="pessoafisicaDIV" class="hidden">
                                <div class="form-group mb-20">
                                    <label for="name">Nome Completo</label>
                                    <input 
                                    type="text" 
                                    value="{{ $subaccount->name }}" 
                                    class="form-control name" 
                                    name="name"
                                    id="name" 
                                    placeholder="Nome Completo"
                                    
                                    >
                                </div>
                                <div class="form-group mb-20">
                                    <label for="cpf">CPF</label>
                                    <input type="text" value="{{ $subaccount->cpf }}" class="form-control cpf" name="cpf"
                                    id="cpf" placeholder="Ex: 999.999.999-99" >
                                </div>
                            </div>
                            <div id="pessoajuridicaDIV" >
                                <div class="form-group mb-20">
                                    <label for="company_name">Razão Social</label>
                                    <input type="text" value="{{ $subaccount->company_name }}" class="form-control company_name" name="company_name"
                                    id="company_name" required placeholder="Razão Social" >
                                </div>
                                <div class="form-group mb-20">
                                    <label for="cnpj">CNPJ</label>
                                    <input  type="text" value="{{ $subaccount->cnpj }}" class="form-control cnpj" name="cnpj"
                                    id="cnpj" required placeholder="Ex: 99.999.999/9999-99" >
                                </div>
                                <div class="form-group mb-20">
                                    <label for="resp_name">Nome Completo do Responsável</label>
                                    <input  type="text" value="{{ $subaccount->resp_name }}" class="form-control resp_name" name="resp_name"
                                    id="resp_name" required placeholder="Nome Completo"  >
                                </div>
                                <div class="form-group mb-20">
                                    <label for="resp_cpf">CPF do Responsável</label>
                                    <input  type="text" value="{{ $subaccount->resp_cpf }}" class="form-control cpf" name="resp_cpf"
                                    id="resp_cpf" placeholder="Ex: 999.999.999-99" >
                                </div>
                            </div>
                     <!---       
<span class="mb-40 mt-20">Se você marcou "MEI" ou "Empresa" (Pessoa jurídica), os dados bancários abaixo devem estar relacionados ao seu CNPJ. Se você marcou "Pessoa Física", os dados bancários devem ser relacionados ao seu CPF.</span>
<br><br>
<span class="mb-40 mt-20">Esta é a conta bancária onde você receberá os pagamentos referentes às suas vendas no aplicativo. Você poderá alterar a conta bancária depois.</span>
                         
                            <div class="form-group mb-20 mt-20">
                                <label ><span
                                    class="text-danger">*</span>Banco:</label>
                                <select class="js-example-basic-single js-states form-control"
                                    name="bank" id="bank" data-parsley-required="true">
                                    <option value="Itaú" class="text-capitalize" <?php if ($subaccount->bank ==='Itaú') { echo "selected"; } ?> >Itaú</option>
                                    <option value="Bradesco" class="text-capitalize" <?php if ($subaccount->bank ==='Bradesco') { echo "selected"; } ?> >Bradesco</option>
                                    <option value="Caixa Econômica" class="text-capitalize" <?php if ($subaccount->bank ==='Caixa Econômica') { echo "selected"; } ?> >Caixa Econômica</option>
                                    <option value="Banco do Brasil" class="text-capitalize" <?php if ($subaccount->bank ==='Banco do Brasil') { echo "selected"; } ?> >Banco do Brasil</option>
                                    <option value="Santander" class="text-capitalize" <?php if ($subaccount->bank ==='Santander') { echo "selected"; } ?> >Santander</option>
                                    <option value="Banrisul" class="text-capitalize" <?php if ($subaccount->bank ==='Banrisul') { echo "selected"; } ?> >Banrisul</option>
                                    <option value="Sicredi" class="text-capitalize" <?php if ($subaccount->bank ==='Sicredi') { echo "selected"; } ?> >Sicredi</option>
                                    <option value="Sicoob" class="text-capitalize" <?php if ($subaccount->bank ==='Sicoob') { echo "selected"; } ?> >Sicoob</option>
                                    <option value="Inter" class="text-capitalize" <?php if ($subaccount->bank ==='Inter') { echo "selected"; } ?> >Inter</option>
                                    <option value="BRB" class="text-capitalize" <?php if ($subaccount->bank ==='BRB') { echo "selected"; } ?> >BRB</option>
                                    <option value="Via Credi" class="text-capitalize" <?php if ($subaccount->bank ==='Via Credi') { echo "selected"; } ?> >Via Credi</option>
                                    <option value="Neon" class="text-capitalize" <?php if ($subaccount->bank ==='Neon') { echo "selected"; } ?> >Neon</option>
                                    <option value="Votorantim" class="text-capitalize" <?php if ($subaccount->bank ==='Votorantim') { echo "selected"; } ?> >Votorantim</option>
                                    <option value="Nubank" class="text-capitalize" <?php if ($subaccount->bank ==='Nubank') { echo "selected"; } ?> >Nubank</option>
                                    <option value="Pagseguro" class="text-capitalize" <?php if ($subaccount->bank ==='Pagseguro') { echo "selected"; } ?> >Pagseguro</option>
                                    <option value="Banco Original" class="text-capitalize" <?php if ($subaccount->bank ==='Banco Original') { echo "selected"; } ?> >Banco Original</option>
                                    <option value="Safra" class="text-capitalize" <?php if ($subaccount->bank ==='Safra') { echo "selected"; } ?> >Safra</option>
                                    <option value="Modal" class="text-capitalize" <?php if ($subaccount->bank ==='Modal') { echo "selected"; } ?> >Modal</option>
                                    <option value="Banestes" class="text-capitalize" <?php if ($subaccount->bank ==='Banestes') { echo "selected"; } ?> >Banestes</option>
                                    <option value="Money Plus" class="text-capitalize" <?php if ($subaccount->bank ==='Money Plus') { echo "selected"; } ?> >Money Plus</option>
                                    <option value="Mercantil do Brasil" class="text-capitalize" <?php if ($subaccount->bank ==='Mercantil do Brasil') { echo "selected"; } ?> >Mercantil do Brasil</option>

                                    
                                </select>
                            </div>
                              <div class="form-group mb-20">
                                  <label for="bank_ag">Agência</label>
                                  <input  type="text" value="{{ $subaccount->bank_ag }}" class="form-control bank_ag" name="bank_ag"
                                  id="bank_ag" placeholder="Agência Bancária" data-parsley-required="true">
                              </div>
                              <div class="form-group mb-20">
                                <label ><span
                                    class="text-danger">*</span>Tipo de Conta:</label>
                                <select class="js-example-basic-single js-states form-control"
                                    name="account_type" id="account_type" data-parsley-required="true">
                                    <option value="Corrente" class="text-capitalize" <?php if ($subaccount->account_type ==='Corrente') { echo "selected"; } ?> >Corrente</option>
                                    <option value="Poupança" class="text-capitalize" <?php if ($subaccount->account_type ==='Poupança') { echo "selected"; } ?> >Poupança</option>
                                </select>
                            </div>

                              <div class="form-group mb-20">
                                <label for="bank_cc">Conta Corrente</label>
                                <input  type="text" value="{{ $subaccount->bank_cc }}" class="form-control bank_cc" name="bank_cc"
                                id="bank_cc" placeholder="Agência Bancária" data-parsley-required="true">
                            </div> -->

                                   
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







    /* $('body').tooltip({
        selector: 'button'
    }); */
    


$("#select2").change(function() {
$("#select2").trigger('input')
})

$("#select-categories").select2({
        placeholder: "Selecione uma Categoria",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

$(".person_type").on('change', function () {
        if (($(this).val() == "Mei") ||($(this).val() == "Empresa") ) {
            $('#pessoafisicaDIV').addClass('hidden').find("input").prop("required", false);
     
            $('#pessoajuridicaDIV').removeClass('hidden').find("input").prop("required", true);
        }
        if ($(this).val()  == "Pessoa Física") {
            $('#pessoajuridicaDIV').addClass('hidden').find("input").prop("required", false);
          
            $('#pessoafisicaDIV').removeClass('hidden').find("input").prop("required", true);
        }
});

$("#bank").select2({
        placeholder: "Selecione uma Opção...",
        dropdownCssClass: "option2",
        
        allowClear: true,
    });



var person_type= "<?php  echo $restaurant->person_type; ?>";  
if ((person_type==='Mei') || (person_type==='Empresa')) {
    $('#pessoafisicaDIV').addClass('hidden').find("input").prop("required", false);
   
    $('#pessoajuridicaDIV').removeClass('hidden').find("input").prop("required", true);
}
if (person_type=== "Pessoa Física") {
    $('#pessoajuridicaDIV').addClass('hidden').find("input").prop("required", false);
    
    $('#pessoafisicaDIV').removeClass('hidden').find("input").prop("required", true);
}




function bindDataToForm(address, lat, lng) {
    document.getElementById('location').value = address;
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
}


$(document).ready(function () {



if (Array.prototype.forEach) {
var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
elems.forEach(function (html) {
    var switchery = new Switchery(html, {
        color: '#2196F3'
    });
});
} else {
var elems = document.querySelectorAll('.switchery-primary');
for (var i = 0; i < elems.length; i++) {
    var switchery = new Switchery(elems[i], {
        color: '#2196F3'
    });
}
}

var delivery_charge_type= "<?php  echo $restaurant->delivery_charge_type; ?>";  

if (delivery_charge_type==='DYNAMIC') {
  
$('#deliveryCharge').addClass('hidden');
$('#dynamicChargeDiv').removeClass('hidden')
}
if (delivery_charge_type=== "FIXED") {
    
    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').removeClass('hidden')
}
if (delivery_charge_type=== "FREE") {

$('#dynamicChargeDiv').addClass('hidden');
$('#deliveryCharge').addClass('hidden')
}  


$("[name='delivery_charge_type']").on("change", function () {
if ($(this).val() == "FIXED") {
    
    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').removeClass('hidden')
}
if ($(this).val() == "DYNAMIC") {

   
    $('#deliveryCharge').addClass('hidden');
    $('#dynamicChargeDiv').removeClass('hidden')
}
if ($(this).val() == "FREE") {

    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').addClass('hidden')
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