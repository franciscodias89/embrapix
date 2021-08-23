@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-left mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Início</a></li>
                
                <li class="breadcrumb-item active" aria-current="page">Produtos</li>
            </ol>
        </nav>
             
    </div>
    
</div>


@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/multiselect/multiselect.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet" />
<link href="https://beta.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">

<!-- styles -->
<link href="https://beta.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://beta.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">
<style>
     .fileuploader {
				width: 160px;
				height: 160px;
				margin: 15px;
			}
  
    </style>

@endsection
@section('content')
 <style>
  
        </style>
 

<div class="row">
    <div class="col-md-12">
        <div class="float-left col-md-6">
            <h4><i class="icon-circle-right2 mr-2"></i>
                @if(empty($query))
                <span class="font-weight-bold mr-2">Produtos</span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ $count }}</span>
                @else
                <span class="font-weight-bold mr-2">{{__('storeDashboard.total')}}</span>
                <span class="badge badge-primary badge-pill animated flipInX mr-2">{{ $count }}</span>
                <span class="font-weight-bold mr-2">Results for "{{ $query }}"</span>
                @endif
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="col-md-6" style="display: inline-block; vertical-align: top; text-align: right;">
            <div >
                <button type="button" class="btn btn-primary" id="addNewItem"
                    data-toggle="modal" data-target="#addNewItemModal">
                    <b><i class="icon-plus2"></i></b>
                    Adicionar Produto
                </button>
                <button type="button" class="btn btn-secondary" id="addBulkItem"
                    data-toggle="modal" data-target="#addBulkItemModal">
                    <b><i class="icon-database-insert"></i></b>
                    Importar CSV
                </button>
            </div>
        </div>
    </div>
</div>
<br>
<div class="content">
    <form action="{{ route('restaurant.post.searchItems') }}" method="GET">
        <div class="form-group form-group-feedback form-group-feedback-right search-box">
            <input type="text" class="form-control form-control-lg search-input" placeholder="Pesquisar Produto"
                name="query">
            <div class="form-control-feedback form-control-feedback-lg">
                <i class="icon-search4"></i>
            </div>
        </div>
        @csrf
    </form>
    @if($agent->isDesktop())
    <div class="card">
        <div class="card-body">
            <div class="table-mod table-responsive">
                <table  class="table dt-responsive nowrap" >
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Loja</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Atributos</th>
                            <th>Criado em:</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr class="item">
                            <td>
                                <?php
                                $url = $item->image;
         
                                 if(substr($url, 0, 4) == "http"){
                                     ?>    
                                     <img src="{{ $item->image }}" alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">
                                     <?php
                                 } else {?>
                                     <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $item->image }}" alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">
                         
                                 <?php } ?>
                                
                            </td>
                            <td><span class="fw-5 text-info">{{ $item->name }}</span></td>
                            <td>{{ $item->restaurant->name }}</td>
                            <td>{{ $item->item_category->name }}</td>
                            <td>{{ str_replace(".",",",$item->price)  }}</td>
                            <td>
                                @if($item->is_recommended)
                               
                                <span class="badge badge-soft-primary">Destaque</span>
                                @endif
                                @if($item->is_popular)
                                <span class="badge badge-soft-danger">Popular</span>
                                @endif
                                @if($item->is_new)
                                <span class="badge badge-soft-success">Novo</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <div class=" align-items-center">
                                    <a href=""
                                        class="btn btn-primary badge-icon"> Editar <i
                                            class="icon-database-edit2 ml-1"></i></a>
                                    
                                            {{-- <a href="{{ route('restaurant.get.editItem', $item->id) }}"
                                        class="btn btn-primary badge-icon"> Editar <i
                                            class="icon-database-edit2 ml-1"></i></a> --}}

                                    {{-- <div class="checkbox checkbox-switchery ml-1" style="padding-top: 0.8rem;">
                                        <label>
                                        <input value="true" type="checkbox" class="action-switch"
                                        @if($item->is_active) checked="checked" @endif data-id="{{ $item->id }}">
                                        </label>
                                    </div> --}}
                                </div>
                            </td>
                        </tr>
                        <tr class="spacer">
                        @endforeach
                        
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
    @else
    @foreach ($items as $item)
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex">
                <div>
                    <?php
                       echo  $url = $item->image;

                        if(substr($url, 0, 4) == "http"){
                            ?>    
                            <img src="{{ $item->image }}" alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">
                            <?php
                        } else {?>
                            <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $item->image }}" alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">
                
                        <?php } ?>
                   </div>
                <div class="ml-3">
                    <h4 class="mb-0"><strong>{{ $item->name }}</strong></h4>
                    <span>{{ $item->restaurant->name }}</span><br>
                    <span>{{ $item->item_category->name }}</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body pt-0 pb-2">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-0"><strong>{{ config('settings.currencyFormat') }}{{ $item->price }}</strong></h4>
                </div>
                <div>
                    @if($item->is_recommended)
                    <span class="badge badge-flat border-grey-800 text-danger text-capitalize mr-1">
                        {{__('storeDashboard.ipRowRecommended')}}
                    </span>
                    @endif
                    @if($item->is_popular)
                    <span class="badge badge-flat border-grey-800 text-primary text-capitalize mr-1">
                        {{__('storeDashboard.ipRowPopular')}}
                    </span>
                    @endif
                    @if($item->is_new)
                    <span class="badge badge-flat border-grey-800 text-default text-capitalize mr-1">
                        {{__('storeDashboard.ipRowNew')}}
                    </span>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('restaurant.get.editItem', $item->id) }}"
                        class="btn btn-secondary btn-labeled btn-labeled-left">
                    <b><i class="icon-database-edit2"></i></b>
                    {{__('storeDashboard.edit')}}
                    </a>
                </div>
                <div>
                    <div class="checkbox checkbox-switchery" style="padding-top: 0.93rem;">
                        <label>
                        <input value="true" type="checkbox" class="action-switch-mobile"
                        @if($item->is_active) checked="checked" @endif data-id="{{ $item->id }}">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="mt-4">
        {{ $items->appends($_GET)->links() }}
    </div>
    @endif
</div>

<div id="searchProduct" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Pesquisar Produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="users">
                            <div class="card">
                                <div class="card-body pl15 pr15">
                                    <div class="form-group">

                                        <label for="itemName">Pesquisar Produto</label>
                                        <select class="form-control " id="select2" style="width: 100%" name="itemName"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


<div id="addNewItemModal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('restaurant.saveNewItem') }}" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="users">
                                <div class="card">
                                    <div class="">
                    
                       
                            <div class="col-md-6" style="padding-left: 0px; float: left;" >
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais do Produto</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl15 pr15">
                                       
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                    <label for="ean">Código de Barras (EAN)</label>
                                    <input required type="text" class="form-control ean" name="ean"
                                        id="ean" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Código de Barras (EAN)">

                                        <button type="button" class="btn btn-primary" id="addNewItem"
                    data-toggle="modal" data-target="#searchProduct">
                    <b><i class="icon-plus2"></i></b>
                    Pesquisar
                </button>
                                </div>
                                
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                    <label for="codint">Código Interno</label>
                                    <input required type="text" class="form-control codint" name="codint"
                                        id="codint" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Código Interno">
                                </div>
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input required type="text" class="form-control name" name="name"
                                        id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Nome do Produto">
                                </div>
                               
                                <div class="form-group">
                                    <label for="desc">Descrição</label>
                                    <input  type="text" class="form-control"
                                        name="desc" id="desc"  data-parsley-group="form-step-1" parsley-trigger="change"
                                        placeholder="Descrição do Produto">
                                        
                                </div>
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                            <div class="sel2">
                                            <label>Categoria do Produto: </label>
                                            <select class="form-control select" name="item_category_id" required>
                                                @foreach ($itemCategories as $itemCategory)
                                                <option value="{{ $itemCategory->id }}" class="text-capitalize">
                                                    {{ $itemCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <div  class="select22" id="select22"></div>
                                        </div>
                                </div>
                                <div class="form-group col-md-6" style="padding-left: 0px; float: left;">
                                    <label class="">Grupo de Adicionais:</label>
                                    <div class="">
                                        <select multiple="multiple" class="form-control wide" data-plugin="customselect" data-fouc
                                            name="addon_category_item[]">
                                            @foreach($addonCategories as $addonCategory)
                                            <option value="{{ $addonCategory->id }}" class="text-capitalize">
                                                {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                            @endforeach
                                        </select>

                                        
                                    </div>
                                </div> 

                               
                                
                                <div class="form-group row" style="display: none;" id="discountedTwoPrice">
                                    <div class="col-lg-6">
                                        <label>Preço (sem desconto) (R$): <i class="icon-question3 ml-1"
                                                data-popup="tooltip" title="{{__('storeDashboard.ipmMarkPriceToolTip')}}"
                                                data-placement="top"></i></label>
                                        <input type="text" class="form-control dinheiro" name="old_price"
                                            placeholder="Preço sem desconto (R$)">
                                    </div>
                                    <div class="col-lg-6">
                                        <label><span class="text-danger">*</span>Preço (com Desconto) (R$):</label>
                                        <input type="text" class="form-control dinheiro" name="price"
                                            placeholder="Preço com desconto (R$)" id="newSP">
                                    </div>
                                </div>
                                <div class="form-group row" id="singlePrice">
                                    
                                    <div class="col-lg-6">
                                        <label><span class="text-danger">*</span>Preço (R$):</label>
                                        <input type="text" class="form-control dinheiro" name="price"
                                            placeholder="Preço (R$)" required id="oldSP">
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left mr-2"
                                            id="addDiscountedPrice">
                                            <b><i class="icon-percent"></i></b>
                                            Marcar como Oferta
                                        </button>
                                    </div>
                                </div>
                               


                                </div>
                            </div>
                            </div> <!-- end col -->
                        
                    
                        
                            <div class="col-md-6" style="padding-left: 0px; float: left;" >
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagem do Produto</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            <div class="row">
                                                <div class="col-md-5" style="float: right;">

                                                    <div class="imagelogo">
                                                        <img class="slider-preview-image hidden" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7" style="padding: 20px;" style="float: right;">

                                                    <br>
                                                    <span>Clique no botão abaixo para fazer upload da imagem</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 20px;">
                                                    <div >
                                                        
                                                        <input  type="file" class="form-control image"
                                                            name="image"  parsley-trigger="change" id="image"
                                                           accept="image/x-png,image/gif,image/jpeg"
                                                            onchange="readURL(this);">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

                    
                    
                    
                    
                    
                    

                   
                    
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Salvar Produto
                            <i class="icon-database-insert ml-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="addBulkItemModal" class="modal fade mt-5" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">{{__('storeDashboard.ipmCsvTitle')}}</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('restaurant.itemBulkUpload') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">{{__('storeDashboard.ipmLabelCsvFile')}}: </label>
                        <div class="col-lg-10">
                            <div class="uploader">
                                <input type="file" accept=".csv" name="item_csv"
                                    class="form-control-uniform form-control-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-left">
                        <button type="button" class="btn btn-primary" id="downloadSampleItemCsv">
                        {{__('storeDashboard.ipmBtnCsvDownloadSample')}}
                            <i class="icon-file-download ml-1"></i>
                        </button>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        {{__('storeDashboard.ipmBtnCsvUpload')}}
                            <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="https://beta.comprabakana.com.br/assets/fileuploader/examples/sorter/default/js/custom.js" type="text/javascript"></script>
<script src="https://beta.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>

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
   
   $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    });   
     $('#addDiscountedPrice').click(function(event) {
                            let price = $('#oldSP').val();
                            $('#newSP').val(price).attr('required', 'required');;
                            $('#singlePrice').remove();
                            $('#discountedTwoPrice').show();
     });

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

           					$('#select2').select2({
						placeholder: 'Digite o Nome do Produto ou Código de Barras',
						minimumInputLength: 4,
						templateResult: formatState,
						language: {
							errorLoading: function() {
								return "Não encontramos nenhum resultado para a pesquisa";
							},
							searching: function() {
								return "Pesquisando...";
							}
						},
						theme: "bootstrap",
						tags: true,

						//templateResult: format,
						ajax: {
							url: "https://painel.comprabakana.com.br/api/ajax_ofertas/",
							dataType: 'json',
							delay: 450,

							processResults: function(data) {
								data = data.map(function(item) {
									return {
										id: item.ean,
										ean: item.ean,
										text: item.text,
										media: item.media,
										produto_nome: item.produto_nome,
										category: item.category
									};
								});
								return {
									results: data
								};
							},

							cache: true
						}

					}).on('change', function(e) {
						var nome = $(this).find(':selected').data().data.produto_nome;
						var pkey = $(this).find(':selected').data().data.ean;
						//document.getElementById("produto_ean").readOnly = true;
						var imagenUrl = $(this).find(':selected').data().data.media;
						//var category = $(this).find(':selected').data().data.category;
						$(".imagembanco").attr("value", imagenUrl);
                        $(".name").attr("value", nome);
						$(".ean").attr("value", pkey); 
                        $("#searchProduct").modal("hide");
						//$(".produto_category").val(category);
                        $('.slider-preview-image').removeClass('hidden').attr("src", imagenUrl);
						/* $("input").attr("data-fileuploader-default", imagenUrl);
						$(".fileuploader-item-image img").attr("src", imagenUrl);
						$("input[type=hidden]").attr("value", '[{"file":"' + imagenUrl + '","is_default":true}]');
 */
					});         
/*     function readURL(input) {
       if (input.files && input.files[0]) {
           let reader = new FileReader();
           reader.onload = function (e) {
               $('.slider-preview-image')
                   .removeClass('hidden')
                   .attr('src', e.target.result)
                   .width(120)
                   .height(120);
           };
           reader.readAsDataURL(input.files[0]);
       }
    } */
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
       /*  $('.summernote-editor').summernote({
                   height: 200,
                   popover: {
                       image: [],
                       link: [],
                       air: []
                     }
            }); */
        
        $('.select').select2();
    
       var recommendeditem = document.querySelector('.recommendeditem');
       new Switchery(recommendeditem, { color: '#f44336' });
    
       var popularitem = document.querySelector('.popularitem');
       new Switchery(popularitem, { color: '#8360c3' });
    
       var newitem = document.querySelector('.newitem');
       new Switchery(newitem, { color: '#333' });

       var vegitem = document.querySelector('.vegitem');
       new Switchery(vegitem, { color: '#008000' });
       
       $('.form-control-uniform').uniform();
       
        $('#downloadSampleItemCsv').click(function(event) {
           event.preventDefault();
           window.location.href = "{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/docs/items-sample-csv.csv";
       });
        $('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });

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
                   header: 'Operation Successful ✅',
                   theme: 'bg-success',
                   life: '1800'
               }); 
           })
           .fail(function(data) {
               console.log(data);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Something went wrong, please try again.',
                   theme: 'bg-danger',
                   life: '1800'
               }); 
           })            
         });
    });
</script>
@endsection


@section('script-bottom')
<!-- Datatables init -->
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>

@endsection