@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">
{{--  <link href="https://app.comprabakana.com.br/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">
  --}}
  <link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
@endsection
@section('content')

 <style>
  
	.fileuploader {
     max-width: 560px;
      }
	.fileuploader-items .fileuploader-item .column-thumbnail {
    position: relative;
    width: 90px;
    height: 90px;
}
.card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}
.fileuploader {
    
     margin: 0 0 0 0; 
   
}
.modal {
  overflow-y:auto;
}

div.dataTables_wrapper .select2-selection--single {
    background-color: #fff;
    border: 1px solid #e3e6ef;
    border-radius: 4px;
    height: 48px;
    width: 100px;
    display: flex;
    align-items: center;
} 

div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
    float: right;
}

.userDatatable table {
    border-bottom: 0px solid #f1f2f6;
  
}

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: auto;
    height: 48px;
    width: 250px;
    font-size: 14px;
    padding: 20px;
}

label.cabinet{
	display: block;
	cursor: pointer;
}

label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
	width: 300px;
	height: 300px;
  padding-bottom:25px;
  background: white;
}

.cropp {
    /* position: absolute; */
    -webkit-box-flex: 1;
    align-items: center;
    text-align: center;
    align-content: center;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 3.5rem;
    background: #78818a;
}
figure {
    margin: 0 0 1rem;
    max-width: 200px;
}

table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
}
table td{
       word-wrap:break-word;
    }


            .content-wrapper {
                overflow: hidden;
            }
            .bill-calc-table tr td {
                padding: 6px 80px;
            }
            .td-title {
                padding-left: 15px !important;
            }
            .td-data {
                padding-right: 15px !important;
            }
            .hiddeen{
                display: none;
            }
            .contentpage {
             margin-left: 40px; 
            overflow: hidden;
            padding: 0px 12.5px 5px 12.5px;
            min-height: 80vh;
            margin-top: 20px; 
        }
        </style>
 


 <div id="editPizzaCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Categoria de Pizzas</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.saveNewPizzaCategory') }}" method="POST" enctype="multipart/form-data" data-parsley-trigger="keyup" data-parsley-validate>

                    <div class="new-member-modal">
                        <div class="row col-md-12">
                            <div class="col-md-12" style="padding-left: 0px; float: left;"> 
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl15 pr15">
                                        <div class="form-group row" style="margin-left: 15px;"> 
                                            <div class="custom-control custom-switch switch-primary switch-md ">
                                                <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                                                <label id="sabor_ativo" class="custom-control-label" for="status" style="color:#0cb946"> Categoria Ativa</label>
                                                <label id="sabor_desativado" class="custom-control-label hidden" for="status" style="color:#e22f0f"> Categoria Pausada</label>
                                             </div>
                                            </div>
                                       
                                         <div class="form-group ">
                                                <label for="name">Nome da Categoria</label>
                                             <input type="text" class="form-control name" name="name"
                                                id="name" parsley-trigger="change"  data-parsley-group="form-step-1" value="{{ $item_category->name }}"
                                                placeholder="Nome da Categoria.  Ex: Pizzas Salgadas, Pizzas Doces, Pizzas Especiais">
                                        </div>

                                        
                                            
                                        <h5 class="modal-title mb-30"><span class="font-weight-bold mb-30">Tamanhos</span></h5>
                                        <div class='form-group row'>
                                            <div class='col-lg-3'>
                                                Nome do Tamanho
                                        </div>
                                        <div class='col-lg-3'>
                                            N° Pedaços
                                        </div>
                                        <div class='col-lg-2'>
                                            Máx. Sabores Permitido
                                        </div>
                                        <div class='col-lg-2'>
                                            Cód. PDV
                                        </div>
                                        <div class='col-lg-2'>
                                        </div>
                                    </div>
                                        <div class='form-group row'> 
                                            <div class='col-lg-3'>
                                            <input type='text' class='form-control form-control-lg'  value="Pequena" name="pizza_sizes[]" placeholder="Tamanho"> 
                                            </div> 
                                            <div class='col-lg-3'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="4" name="slices[]" placeholder="Pedaços"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            pedaços
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="1" name="flavors_qty[]" placeholder="Sabores">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            sabores
                                                        </span>
                                                    </div> 
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <input type='text' class='form-control form-control-lg'  name="cod_pdv[]" placeholder="Cód PDV"> 
                                            </div> 
                                            <div class='col-lg-2'> 
                                                <button class='remove order-bg-opacity-danger text-danger btn radius-md' data-popup='tooltip' data-placement='right' title='Excluir'><i class='la la-trash'></i>Excluir</button>
                                            </div>
                                            
                                        </div>

                                        <div class='form-group row'> 
                                            <div class='col-lg-3'>
                                            <input type='text' class='form-control form-control-lg'  value="Média" name="pizza_sizes[]" placeholder="Tamanho"> 
                                            </div> 
                                            <div class='col-lg-3'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="6" name="slices[]" placeholder="Pedaços"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            pedaços
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="2" name="flavors_qty[]" placeholder="Sabores">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            sabores
                                                        </span>
                                                    </div> 
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <input type='text' class='form-control form-control-lg'  name="cod_pdv[]" placeholder="Cód PDV"> 
                                            </div> 
                                            <div class='col-lg-2'> 
                                                <button class='remove order-bg-opacity-danger text-danger btn radius-md' data-popup='tooltip' data-placement='right' title='Excluir'><i class='la la-trash'></i>Excluir</button>
                                            </div>
                                            
                                        </div>

                                        <div class='form-group row'> 
                                            <div class='col-lg-3'>
                                            <input type='text' class='form-control form-control-lg'  value="Grande" name="pizza_sizes[]" placeholder="Tamanho"> 
                                            </div> 
                                            <div class='col-lg-3'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="8" name="slices[]" placeholder="Pedaços"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            pedaços
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <div class="input-group input-group-merge">
                                                    <input type='text' class='form-control form-control-lg'  value="2" name="flavors_qty[]" placeholder="Sabores">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            sabores
                                                        </span>
                                                    </div> 
                                                </div>
                                            </div> 
                                            <div class='col-lg-2'>
                                                <input type='text' class='form-control form-control-lg'  name="cod_pdv[]" placeholder="Cód PDV"> 
                                            </div> 
                                            <div class='col-lg-2'> 
                                                <button class='remove order-bg-opacity-danger text-danger btn radius-md' data-popup='tooltip' data-placement='right' title='Excluir'><i class='la la-trash'></i>Excluir</button>
                                            </div>
                                            
                                        </div>

                                        
                                        <div id="addon" class="mt-4">
                                            <legend class="" id="addonsLegend">
                                                
                                                
                                            </legend>
                                        </div>
                    
                                        <a href="javascript:void(0)" onclick="add(this)" class="order-bg-opacity-danger text-danger btn radius-md"> <b><i class="la la-plus"></i></b>Adicionar Tamanho</a>
                                        @csrf

                                        <div class="form-group mb-20 mt-30">
                                            <label ><span
                                                class="text-danger">*</span>Forma de Cálculo para Pizzas de Mais Sabores (2 sabores, etc):</label>
                        {{--                     <select class="js-example-basic-single js-states form-control"
                                                name="person_type" id="select-person_type" required>
                                                <option value="Pessoa Jurídica" class="text-capitalize" >Pessoa Jurídica</option>
                                                <option value="Pessoa Física" class="text-capitalize" >Pessoa Física</option>
                                                
                                            </select> --}}
            
                                            <div class="radio-theme-default custom-radio ">
                                                <input class="radio person_type" type="radio" required name="pizza_more_flavors" value="1" id="pizza_more_flavors1" <?php if ($restaurant->pizza_more_flavors ==1) { echo "checked"; }  ?> >
                                                <label for="pizza_more_flavors1">
                                                <span class="radio-text">Média dos preços dos sabores escolhidos</span>
                                                </label>
                                             </div>
                                             <div class="radio-theme-default custom-radio ">
                                                <input class="radio person_type" type="radio" required name="pizza_more_flavors" value="2" id="pizza_more_flavors2" <?php if ($restaurant->pizza_more_flavors ==2) { echo "checked"; }  ?> >
                                                <label for="pizza_more_flavors2">
                                                <span class="radio-text">Valor cheio do maior preço dentre os sabores escolhidos</span>
                                                </label>
                                             </div>
                                             
            
            
                                        </div>

                                        <div class="form-group">
                                            <label class="">Grupos de Opções (opcional):</label>
                                            <div class="skillsOption">
                                                <select multiple="multiple" class="js-example-basic-single js-states form-control" 
                                                data-plugin="customselect" data-fouc
                                                    name="addon_category_item[]" id="select_addonPizza">
                                                    @foreach($addonCategories as $addonCategory)
                                                    <option value="{{ $addonCategory->id }}" class="text-capitalize">
                                                        {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                         {{--    <div class="col-md-6">
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagem</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                           

                                                                                      

                                        </div>
                                    </div>
                                </div>
                            
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="" aria-hidden="true"></i> <h5>Preço</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            
                                                  
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col --> --}}
                        </div>
                    </div>
                    @csrf
                    <div class="text-right mt-30">
                        <button type="submit" class="btn btn-primary">
                        Salvar Categoria
                            <i class="icon-database-insert ml-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('scripts')
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.js" type="text/javascript"></script>
<script src='https://foliotek.github.io/Croppie/croppie.js'></script>
<script>
    
    
    if (window.location !== window.parent.location ) 
    { 
        //alert('test');
        //hide menu, nav, header and apply custom css colors when on iFrame from dashboard v2
        $('.navbar').addClass('hiddeen');
        $('.left-side-menu').hide();
        $('.content-page').addClass('contentpage');
        $("body").overlayScrollbars({
            scrollbars : {
                visibility       : "auto",
                autoHide         : "leave",
                autoHideDelay    : 500
            }
        });
    }
</script>
<script>




            $('body').on('click', '.addNewFlavor', function () {
   
                var category_id= $(this).data("categoryid");
                $('#item_categoryid').val($(this).data("categoryid"));
   
                var pizza_size='';
                $.ajax({
                     url: "{{ url('/store-owner/get-ajax-pizza-sizes/') }}/"+category_id,
                     type: 'GET',
                     dataType: 'JSON',
                     //data: {_token: $('.csrfToken').val()},
                    
                }).done(function(data) {
                    pizza_size = data;
                    var newAddon = document.createElement("div");
                
                $.each(pizza_size, function(i, item) {
                    newAddon = "<div class='col-lg-6 mt-20' > <label><span class='text-danger'></span>"+pizza_size[i].size+": <i class='icon-question3 ml-1' ></i></label><div class='input-group input-group-merge'><div class='input-group-prepend'> <span class='input-group-text'> R$ </span></div> <input type='text' hidden name='pizza_size_id[]' value="+pizza_size[i].id+"> <input type='text' class='form-control clock form-control-lg dinheiro' name='prices[]' placeholder='Preço'></div></div>";
                    container = $('#precos');
                    container.append(newAddon);
                    $(".dinheiro").mask('#.##0,00', {
                        reverse: true
                     });
                  
                });
                 })
                 .fail(function() {
                     console.log("error");
                 })  
                



    });
    


$('body').tooltip({selector: '[data-popup="tooltip"]'});
    var addonNamePlaceholder = "{{ __('storeDashboard.newAddonCategoryAddonPlaceholderName') }}";
    var addonPricePlaceholder = "{{ __('storeDashboard.newAddonCategoryAddonPlaceholderPrice') }}";
    var addonRemoveTitle = "{{ __('storeDashboard.newAddonCategoryAddonRemove') }}";

    function add(data) {
        $('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div class='form-group row'><div class='col-lg-3'> <input type='text' class='form-control form-control-lg'  name='pizza_sizes[]' placeholder='Tamanho'></div><div class='col-lg-3'><div class='input-group input-group-merge'> <input type='text' class='form-control form-control-lg'  name='slices[]' placeholder='Pedaços'><div class='input-group-prepend'> <span class='input-group-text'> pedaços </span></div></div></div><div class='col-lg-2'><div class='input-group input-group-merge'> <input type='text' class='form-control form-control-lg' name='flavors_qty[]' placeholder='Sabores'><div class='input-group-prepend'> <span class='input-group-text'> sabores </span></div></div></div><div class='col-lg-2'> <input type='text' class='form-control form-control-lg' name='cod_pdv[]' placeholder='Cód PDV'></div><div class='col-lg-2'> <button class='remove order-bg-opacity-danger text-danger btn radius-md' data-popup='tooltip' data-placement='right' title='Excluir'><i class='la la-trash'></i>Excluir</button></div></div>";
        
        document.getElementById('addon').appendChild(newAddon);
    }

    $(function() {
        $('.select').select2({
            minimumResultsForSearch: -1,
        });

        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().remove();
        });
    });


/* $(document).ready(function() {
  $(".preco_oferta input").focus(function() { 
              $('#offer_settings').show('slow');
      //return false;
    });
    
  
 $(".preco_oferta input").blur(function(){
    if( !$(this).val() ) {
            $('#offer_settings').hide('slow'); 
    }
});
}); */

$('input[name=price]').keyup(function(){
if($(this).val().length)
$('#offer_settings').show();
else
$('#offer_settings').hide();

});

$.fn.dataTable.moment('DD/MM/YYYY');

$(function () {
        
        $('body').tooltip({selector: '[data-popup="tooltip"]'});
        
       /*   var datatable = $('#itemsDataTable').DataTable({

            bLengthChange : true,
            searching: true,
            pageLength : 10,
            bInfo: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],  
            order: [[ 0, "desc" ]],
            ajax: '{{ route('restaurant.itemsDataTable') }}',  
            columns: [
                {data: 'id', visible: false, searchable: false},
                {data: 'image'},
                {data: 'name'},
                {data: 'ean', width: "20%"},
                {data: 'price', width: "20%" },
                {data: 'item_category'},
                {data: 'is_active'},
               // {data: 'created_at'},
              
                {data: 'action', sortable: false, searchable: false, reorder: false},
            ],
         
            fixedColumns: { 
                leftColumns: 0,
                rightColumns: 1
            },
            colReorder: {
                   fixedColumnsRight: 1
               },
            drawCallback: function( settings ) {
                /*  $('form-select form-select-sm select2-hidden-accessible').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });  
                

                var newDate = new Date();
                console.log(newDate)
                var newStamp = newDate.getTime();

                

            },
            scrollX: true,
            scrollCollapse: true,
            dom: '<"custom-processing-banner"r>flBtip', 
            language: {
                search: '_INPUT_',
                searchPlaceholder: 'Pesquisar...',
                lengthMenu: '_MENU_',
                paginate: { 'first': 'Primeiro', 'last': 'Último', 'next': '&rarr;', 'previous': '&larr;' },
                processing: '<i class="icon-spinner10 spinner position-left mr-1"></i>Buscando Informações no Servidor...',
                info: "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                emptyTable: "Não foi encontrado nenhum registo",
                loadingRecords: "A carregar...",
                processing: "A processar...",
                
                zeroRecords: "Não foram encontrados resultados",
                infoEmpty: "Mostrando 0 os registros num total de 0",
    infoFiltered: "(filtrado num total de _MAX_ registos)",
    infoThousands: ".",
            },
           buttons: {
                   dom: {
                       button: {
                           className: 'btn btn-sm btn-primary'
                       }
                   },
                   buttons: [
                       {extend: 'csv',  filename: 'produtos-'+ new Date().toISOString().slice(0,10), text: 'CSV'},
                       {extend: 'excel', filename: 'produtos-'+ new Date().toISOString().slice(0,10), text: 'Excel'},
                       
                   ]
               }
        });
        datatable.buttons().container().appendTo($('#but'));

         $('#clearFilterAndState').click(function(event) {
            if (datatable) {
                datatable.state.clear();
                window.location.reload();
            }
         });*/
    
        });


 



 $('#itemsDataTable').DataTable(
        {
            bLengthChange : false,
            searching: false,
            pageLength : 10,
            bInfo: false,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],
            autoWidth: false,
            fixedColumns: { 
                leftColumns: 0,
                rightColumns: 1
            },
            drawCallback: function( settings ) {
                $('select').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });
            },

            language: {
                search: '_INPUT_',
                searchPlaceholder: 'Pesquisar...',
                lengthMenu: '_MENU_',
                paginate: { 'first': 'Primeiro', 'last': 'Último', 'next': '&rarr;', 'previous': '&larr;' },
                processing: '<i class="icon-spinner10 spinner position-left mr-1"></i>Buscando Informações no Servidor...',
                info: "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                emptyTable: "Não foi encontrado nenhum registo",
                loadingRecords: "A carregar...",
                processing: "A processar...",
                
                zeroRecords: "Não foram encontrados resultados",
                infoEmpty: "Mostrando 0 os registros num total de 0",
    infoFiltered: "(filtrado num total de _MAX_ registos)",
    infoThousands: ".",
            },
        }
    ); 

// Less than validator
window.Parsley.addValidator('lt2', {
  validateString: function (value, requirement) {
    var value2= value.toString().replace(",", ".");
    var requirement2= jQuery(requirement).val().toString().replace(",", ".");
    console.log(value2);
    console.log(requirement2);
    return value2 < requirement2;
  },
  messages: {
        pt: ''
  },
  priority: 32
});

// Less than validator
window.Parsley.addValidator('gt2', {
  validateString: function (value, requirement) {
    var value2= value.toString().replace(",", ".");
    var requirement2= jQuery(requirement).val().toString().replace(",", ".");
    console.log(value2);
    console.log(requirement2);
    return value2 > requirement2;
  },
  messages: {
        pt: ''
  },
  priority: 32
});



  $(function () {

    $("#select_addon").select2({
        placeholder: "Selecione uma Opção...",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

    $("#select_addonPizza").select2({
        placeholder: "Selecione uma Opção...",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

    $("#select-unidade").select2({
        placeholder: "Selecione uma Opção...",
        minimumResultsForSearch: Infinity,
        
        allowClear: true,
    });

    $("#item_category_id").select2({
        placeholder: "Selecione uma Opção...",
        minimumResultsForSearch: Infinity,
        dropdownCssClass: "tag",
        //dropdownCssClass: "tag",
        allowClear: true, 
    });

    
         $("#is_offer_notime").click(function () {
            if ($(this).is(":checked")) {
                
                $("#offer_date").find("input").prop("disabled", true).prop("required", false);
                //$("input[name=price]").attr("data-parsley-lt2", '#old_price');
               // $("input[name=old_price]").attr("data-parsley-gt2", '#newSP');
               
            } else {
                
                $("#offer_date").find("input").prop("disabled", false).prop("required", true);
             
            }
        }); 
        $("#is_active").click(function () {
            if ($(this).is(":checked")) {
                $("#produto_ativo").show();
                $("#produto_desativado").hide();
               
            } else {
                $("#produto_ativo").hide();
                $("#produto_desativado").show();
            }
        });
    });

    
    $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		}); 
        
    });   

    $(document).ready(function () {
    $('#abrir').click(function () {
        $('#addNewItemModal').modal({
            show: true
        })
    });
    $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
    });
});

$('#downloadSampleItemCsv').click(function(event) {
           event.preventDefault();
           window.location.href = "{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/docs/items-sample-csv.csv";
       });
        //$('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });
 

    // $('#addDiscountedPrice').click(function(event) {
             //               let price = $('#oldSP').val();
             //               $('#newSP').val(price).attr('required', 'required');;
             //               $('#singlePrice').remove();
             //               $('#discountedTwoPrice').show();
    // });

     function formatState(state) {
			if (!state.id) {
				return state.text;
			}
			var baseUrl = "https://painel.comprabakana.com.br/user/pages/images/flags";
			var $state = $(
				'<span><img src="' + state.media + '" class="img-flag" /> ' + state.text + '</span>'
			);
			return $state;
		};


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
    $(function () {
      
        
        $('.select').select2();

        //Switch Action Function  
         var elems = document.querySelectorAll('.action-switch');
         for (var i = 0; i < elems.length; i++) {
             var switchery = new Switchery(elems[i], { color: '#8360c3' });
         }
         var elemsmb = document.querySelectorAll('.action-switch-mobile');
         for (var i = 0; i < elemsmb.length; i++) {
             var switchery = new Switchery(elemsmb[i], { color: '#8360c3' });
         }     

         $('.action-switch, .action-switch-mobile').click(function(event) {
           console.log("Clicked");
            let id = $(this).attr("data-id")
            let url = "{{ url('/store-owner/item/disable/') }}/"+id;
            let self = $(this);
           $.ajax({
               url: url,
               type: 'GET',
               dataType: 'JSON',
           })
           .done(function(data) {
               console.log(data);
               console.log(self);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Operação Realizada com Sucesso ✅',
                   theme: 'bg-success',
                   life: '1800'
               }); 
           })
           .fail(function(data) {
               console.log(data);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Alguma coisa deu errado. Por favor, tente novamente!',
                   theme: 'bg-danger',
                   life: '1800'
               }); 
           })            
         });
    });

    $(document).ready(function () {
        $('#ean').on('input', function() {
			var ean_digitado = $(this).val();
			if (ean_digitado.length > 7) {
			    var media = 'https://bancoimagenscb.s3-sa-east-1.amazonaws.com/webp3/' + ean_digitado + '.webp';
				var exists = '';
				checkImage(media, function() {
				    $(".gambar").attr("src", media);
                    $("#imagem_banco").attr("value", media);
				});
			};
		});
    });

    function checkImage(imageSrc, good, bad) {
        var img = new Image();
        img.onload = good;
        img.onerror = bad;
        img.src = imageSrc;
	};


    $(".gambar").attr("src", "https://app.comprabakana.com.br/assets/img/drag.png");




var $uploadCrop,
tempFilename,
rawImg,
imageId,
h,
w;
function readFile(input) {
 if (input.files && input.files[0]) {
  var reader = new FileReader();
    reader.onload = function (e) {
        $('.upload-demo').addClass('ready');
        $('#cropImagePop').modal('show');
        rawImg = e.target.result;
        var h = rawImg.height();
        var w = rawImg.width();
    }
    reader.readAsDataURL(input.files[0]);
}
else {
    swal("Sorry - you're browser doesn't support the FileReader API");
}

}

/* $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        }); */

$uploadCrop = $('#upload-demo').croppie({

 viewport: {
    width: 300,
    height: 300,
    type: 'square' //default 'square'
},
 boundary:{
    width: 300,
    height: 300,
}, 

enforceBoundary: false,
enableExif: true
});

$('#cropImagePop').on('shown.bs.modal', function(){
// alert('Shown pop');
$uploadCrop.croppie('bind', {
    url: rawImg
   
}).then(function(){
    console.log('jQuery bind complete');
});
});

$('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
$('#cancelCropBtn').data('id', imageId); readFile(this); });
$('#cropImageBtn').on('click', function (ev) {
$uploadCrop.croppie('result', {
    type: 'base64',
    format: 'jpeg',
    size: {width: 300, height: 300},
    backgroundColor : "#ffffff",
}).then(function (resp) {
    $('#item-img-output').attr('src', resp);
    $('#item-img-output-flavor').attr('src', resp);
    $('#file_output').val(resp);
    $('#file_outputflavor').val(resp);

    $('#cropImagePop').modal('hide');
});
});
// End upload preview image


$(document).ready(function() {
	
	// enable fileuploader plugin
	$('input[name="files"]').fileuploader({
        extensions: null,
		changeInput: ' ',
		theme: 'thumbnails',
        enableApi: true,
		addMore: false,
        
		thumbnails: {
			box: '<div class="fileuploader-items">' +
                      '<ul class="fileuploader-items-list">' +
					      '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                      '</ul>' +
                  '</div>',
			item: '<li class="fileuploader-item">' +
				       '<div class="fileuploader-item-inner">' +
                           
                           '<div class="actions-holder">' +
						   	   '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                           '</div>' +
                           '<div class="thumbnail-holder">' +
                               '${image}' +
                               '<span class="fileuploader-action-popup"></span>' +
                           '</div>' +
                           
                       	   '<div class="progress-holder">${progressBar}</div>' +
                       '</div>' +
                  '</li>',
			item2: null,
			startImageRenderer: true,
            canvasImage: true,
			_selectors: {
				list: '.fileuploader-items-list',
				item: '.fileuploader-item',
				start: '.fileuploader-action-start',
				retry: '.fileuploader-action-retry',
				remove: '.fileuploader-action-remove'
			},
            itemPrepend: true,
			
            popup: {
				arrows: false,
				onShow: function(item) {
					item.popup.html.addClass('is-for-avatar');
                    item.popup.html.on('click', '[data-action="remove"]', function(e) {
                        item.popup.close();
                        item.remove();
                    }).on('click', '[data-action="cancel"]', function(e) {
                        item.popup.close();
                    }).on('click', '[data-action="save"]', function(e) {
						if (item.editor ) {
							item.isSaving = true;
                        	item.editor.save();
						}
						if (item.popup.close)
							item.popup.close();
                    });
                },
				onHide: function(item) {
					if (!item.isSaving && !item.uploaded && !item.appended) {
						item.popup.close = null;
						item.remove();
					}
				} 	
			},
			onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
				var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));
                    plusInput.hide();
                 //plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();
				 
				if(item.format == 'image') {
					item.html.find('.fileuploader-item-icon').hide();
				}
			},
            onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                //if (item.choosed && !item.isSaving) {
					if (item.reader.node && item.reader.width >= 200 && item.reader.height >= 200) {
						//item.image.hide();
						//item.popup.open();
						//item.editor.cropper();
					} else {
						item.remove();
						alert('A imagem é muito pequena! Tamanhp mínimo: 200px vs 200px!');
					}
				//} else if (item.data.isDefault)
				//	item.html.addClass('is-default');
				//else if (item.image.hasClass('fileuploader-no-thumbnail'))
				//	item.html.hide();
            },
            onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
				    api = $.fileuploader.getInstance(inputEl.get(0));
                    plusInput.show();
                html.children().animate({'opacity': 0}, 200, function() {
                    html.remove();
                    
                    if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                        plusInput.show();
                });
            }
		},
        editor: {
			maxWidth: 500,
			maxHeight: 500,
			quality: 80,
            cropper: {
				showGrid: false,
				ratio: '1:1',
				minWidth: 150,
				minHeight: 150,
			},
		
        },
        dragDrop: {
			container: '.fileuploader-thumbnails-input'
		},
		afterRender: function(listEl, parentEl, newInputEl, inputEl) {
			var plusInput = listEl.find('.fileuploader-thumbnails-input'),
				api = $.fileuploader.getInstance(inputEl.get(0));
		
			plusInput.on('click', function() {
				api.open();
			});
            
            api.getOptions().dragDrop.container = plusInput;

          
		},
		
       
    });
});
</script>
@endsection


