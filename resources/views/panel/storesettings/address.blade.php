<div >
    <!-- Edit Profile -->
    <div class="edit-profile">
        <div class="card">
            <div class="card-header  px-sm-25 px-3">
                <div class="edit-profile__title">
                    <h6> Endereço</h6>
                    <span class="fs-13 color-light fw-400">Atualize as informações de endereço de sua loja</span>
                </div>
                <div class="button-group d-flex flex-wrap pt-30 mb-15">
                    <button type="submit" form="endereco_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
                    </button>
                  {{--   <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-11 col-sm-11">
                        <div class="edit-profile__body mx-lg-20">
                            <form action="{{ route('settings.saveAddress') }}" method="POST" id="endereco_form" enctype="multipart/form-data">
                                @csrf
                                <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                <input hidden type="text" value="2" class="form-control" name="etapa">

                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="form-group col-md-9" style="float: left;">
                                           <label for="address_street">Logradouro (Rua/Avenida)</label>
                                           <input required type="text" name="address_street" class="form-control"  value="{{ $restaurant->address_street }}" parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                               id="address_street" >
                                       </div>
                                       <div class="form-group col-md-3" style="float: right;">
                                           <label for="address">Número</label>
                                           <input required type="text" name="address_number" class="form-control"  value="{{ $restaurant->address_number }}" parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                               id="address" >
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="form-group col-md-6" style="float: left;">
                                           <label for="address_complement">Complemento</label>
                                           <input type="text" name="address_complement" class="form-control"  value="{{ $restaurant->address_complement }}" parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                               id="address_complement" >
                                           
                                       </div>
                                       <div class="form-group col-md-6" style="float: right;">
                                           <label for="address_district">Bairro</label>
                                           <input required type="text" name="address_district" class="form-control"  value="{{ $restaurant->address_district }}" parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                               id="address_district" >
                                       </div>             
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-12">
                                       <div class="form-group col-md-6" style="float: left;">
                                           <label for="address_state">Estado</label>
                                           <input required type="text" name="address_state" 
                                           class="form-control"  
                                           value="{{ $restaurant->address_state }}" parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                               id="address_state" >
                                           
                                       </div>
                                       <div class="form-group col-md-6" style="float: right;">
                                           <label for="address_city">Cidade</label>
                                           <input 
                                           required 
                                           type="text" 
                                           name="address_city" 
                                           class="form-control"  
                                           value="{{ $restaurant->address_city }}" 
                                           parsley-trigger="change" 
                                           data-parsley-group="form-step-3"
                                           id="address_city" >
                                       </div>             
                                   </div>
                               </div>
                                
                             
                                <div class="form-group col-md-12 mb-20">
                                    <label for="pincode">CEP</label>
                                    <input type="text" required  value="{{ $restaurant->pincode }}" class="form-control cep" name="pincode"
                                    id="pincode" placeholder="99999-999">
                                </div>
                             
                           
                           
                                <div class="form-group mb-20 mt-40 col-md-12">
                                    <label for="google_address">Digite seu endereço completo abaixo para localizar
                                        seu estabelecimento no mapa</label>
                                        <p><small>Essa é uma das <strong>informações mais importantes.</strong> <strong>Digite, com cuidado</strong> o endereço do seu negócio no campo abaixo, e selecione o resultado que aparecer como opção dentro do mapa,<strong> até que seu endereço seja identificado no mapa abaixo!</strong> </small></p>
                             
                                    <input required id="searchMapInputt" name="google_address" value="{{$restaurant->google_address}}" required
                                        class="form-control" type="text" 
                                        placeholder="Digite aqui o endereço completo da Loja">
                                </div>
                                <div class="form-group col-md-12">
                                    <div id="mapp"></div>
                                </div>
                                <span class="fs-13 color-light fw-400"> Endereço Completo: </span> <span class="fs-13 color-light fw-400" id="location-snap"></span>
                           

                                
                                <div class="form-group"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6" style="float: right;">
                                            <label for="latitude">Latitude</label>
                                            <input readonly required type="text" value="{{$restaurant->latitude}}"class="form-control" name="latitude"
                                                id="latitude" value="">
                                        </div>
                                        <div class="form-group col-md-6" style="float: right;">
                                            <label for="longitude">Longitude</label>
                                            <input 
                                            readonly 
                                            required 
                                            type="text" 
                                            value="{{$restaurant->longitude}}" 
                                            class="form-control" 
                                            name="longitude"
                                            id="longitude"
                                            value="" 
                                            data-parsley-error-message="Você precisa digitar no campo acima do mapa um endereço válido. Certifique de que este endereço esteja correto!" >

                                        </div>
                                    </div>

                                    <div class="col-md-12 hidden" id="message_error_map">
                                        <span style="color:red" > Você precisa digitar no campo acima do mapa um endereço válido. Certifique de que este endereço esteja correto!</span>
                                    </div>
                                </div>
                              

                                  
                                  <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                   <button type="submit" id="submitmap" class="btn btn-danger btn-default btn-squared mr-15">Salvar e Continuar<i class="ml-10 mr-0 las la-arrow-right"></i>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAP5VyOjNJvOI9eFZYXoWbzF_rI81ikZNs&libraries=places&language=pt_BR&region=BR&callback=initMap" async defer></script>

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
   
   if ($("#longitude").val()!='') {
            
            $('#message_error_map').addClass('hidden');
            $('#submitmap').attr("disabled", false);
     
        }else{
            $('#message_error_map').removeClass('hidden');
            $('#submitmap').attr("disabled", true);
        }

$("#longitude ").on('blur', function () {
        if ($(this).val()!='') {
            $('#message_error_map').addClass('hidden');
            $('#submitmap').attr("disabled", false);
        }else{
            $('#message_error_map').removeClass('hidden');
            $('#submitmap').attr("disabled", true);
        }
});

function initMap() {
    setTimeout(1000);
    var lat = "<?php echo $restaurant->latitude; ?>";
    var lng = "<?php echo $restaurant->longitude; ?>";

    var map = new google.maps.Map(document.getElementById('mapp'), {
        center: {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        },
        zoom: 15
    });
    console.log(map);
    var input = document.getElementById('searchMapInputt');

    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();

        /* If the place has a geometry, then present it on a map. */
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);

        /* Location details */
        document.getElementById('location-snap').innerHTML = place.formatted_address;
        document.getElementById('latitude').innerHTML = place.geometry.location.lat();
        document.getElementById('longitude').innerHTML = place.geometry.location.lng();

        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
        document.getElementById("latitude").readOnly = true;
        document.getElementById("longitude").readOnly = true;
        document.getElementById("submitmap").disabled = false;
        document.getElementById("message_error_map").style.visibility = "hidden";
    });
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

function readURL(input) {
    
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('.slider-preview-image')
                .removeClass('hidden')
                .attr('src', e.target.result);



        };

        //ocument.getElementsByClassName(".slider-preview-image").style.objectFit = "cover";
        reader.readAsDataURL(input.files[0]);
    }
}
 function add(data) {
    var para = document.createElement("div");
    let day = data.getAttribute("data-day");
    let randomNum = 'clock'+Math.random(); 
    para.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><label class='col-form-label'>Abre às:</label><input type='text' class='form-control clock' name='"+day+"[]' required> </div> <div class='col-lg-5'> <label class='col-form-label'>Fecha às:</label><input type='text' class='form-control clock' name='"+day+"[]'  required> </div> <div class='col-lg-2'> <label class='col-form-label text-center' style='width: 70px'></span>Remover</label><br><button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i></button></div></div>";
    document.getElementById(day).appendChild(para);
    var parent = document.getElementById('id');
    initializeFlatPicker(para);
  

}

function initializeFlatPicker (context) {
$(".clock", context || document).flatpickr({
enableTime: true,
noCalendar: true,
time_24hr: true,
dateFormat: "H:i",
});
}



$(function () {

    /* $('body').tooltip({
        selector: 'button'
    }); */
    
    $('.clock').flatpickr({
        enableTime: true,
noCalendar: true,
time_24hr: true,
dateFormat: "H:i",
    });
    $(document).on("click", ".remove", function() {
        //$(this).tooltip('hide')
        $(this).parent().parent().remove();
    });
    
    $('.select').select2({
        minimumResultsForSearch: Infinity,
    });

     if (Array.prototype.forEach) {
           var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
           elems.forEach(function(html) {
               var switchery = new Switchery(html, { color: '#2196F3' });
           });
       }
       else {
           var elems = document.querySelectorAll('.switchery-primary');
           for (var i = 0; i < elems.length; i++) {
               var switchery = new Switchery(elems[i], { color: '#2196F3' });
           }
       }

//    $('.form-control-uniform').uniform();

   
});

$("#select2").change(function() {
$("#select2").trigger('input')
})

$("#select-categories").select2({
        placeholder: "Selecione uma Categoria",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

$(".person_type").on('change', function () {
        if ($(this).val() == "Pessoa Jurídica") {
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



var person_type= "<?php  echo $subaccount->person_type; ?>";  
if (person_type==='Pessoa Jurídica') {
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

/* $('.rating').numeric({
allowThouSep: false,
min: 1,
max: 5,
maxDecimalPlaces: 1
});
$('.delivery_time').numeric({
allowThouSep: false
});
$('.price_range').numeric({
allowThouSep: false
});
$('.latitude').numeric({
allowThouSep: false
});
$('.longitude').numeric({
allowThouSep: false
});
$('.restaurant_charges').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.delivery_charges').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.commission_rate').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
max: 100,
allowMinus: false
});

$('.delivery_radius').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});

$('.base_delivery_charge').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.base_delivery_distance').numeric({
allowThouSep: false,
maxDecimalPlaces: 0,
allowMinus: false
});
$('.extra_delivery_charge').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.extra_delivery_distance').numeric({
allowThouSep: false,
maxDecimalPlaces: 0,
allowMinus: false
});

$('.min_order_price').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
 */






});

    </script>
@endsection