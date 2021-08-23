@extends('layouts.app')
@section("title") {{__('storeDashboard.spPageTitle')}}
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/multiselect/multiselect.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet" />
<style>
    .hidden{ 
    display: none;
}

svg {
    overflow: hidden;
    vertical-align: middle;
    width: 18px;
    height: 18px;
}

.select2-hidden-accessible.parsley-error ~ ul ~ .select2-selection.select2-selection--multiple {
     border-color: #f34943 !important; 
}

.select2-hidden-accessible.parsley-error ~ ul ~ .select2-selection .select2-selection--multiple {
     border-color: #43d39e !important;
}



        .delivery-div {
        background-color: #fafafa;
        padding: 1rem;
    }

    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }

    #mapp {
        width: 100%;
        height: 400px;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    @media (min-width: 992px) {

        .modal-lg,
        .modal-xl {
            max-width: 1200px;
        }
    }

   
    .imagelogo {
    display: block;
    border-radius: 5px;
    border: 1px solid #ddd;
    background-image: url(https://effetech.com.br/assets/img/icone_logoCliente.png);
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    height: 202px;
    width: 204px;
}

img.slider-preview-image {
    width: 200px;
    height: 200px;
    object-fit: contain;
    background-color: white;
}

    
    .fileuploader {
				width: 160px;
				height: 160px;
				margin: 15px;
			}

    
</style>

@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-left mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Início</a></li>
                
                <li class="breadcrumb-item active" aria-current="page">Lojas</li>
            </ol>
        </nav>
             
    </div>
    
</div>


@endsection
@section('content')
<style>
.table-mod tbody tr.item {
    border: 1px solid #f4f4f4;
    border-radius: 4px;
    height: 80px;
    text-align: center;
    -webkit-box-shadow: 0 0 13px 0 rgba(82,63,105,.02);
    box-shadow: 0 0 13px 0 rgba(82,63,105,.02);
}
	.table-mod tbody tr.item {
		background: #f8f9fa;
	}
    .table-mod tbody tr.spacer {
    height: 15px;
}
.text-info {
    color: #5578eb!important;
}
body {
    margin: 0;
    font-family: "Nunito Sans", sans-serif;
    font-size: 1rem;
}
.table-responsive {overflow-x: hidden;}
@media (max-width: 1100px){
    .table-responsive {overflow-x: auto;}
}

.fw-5 {
    
    font-weight: 600!important;
}
.table-mod thead tr th {
    border-bottom: none;
    border-top: none;
    padding: 0 15px 15px;
    color: #5578eb;
    font-weight: 700;
    white-space: nowrap;
    text-align: center;
}
.card-body {
    flex: 1 1 auto;
    padding: 2.2rem;
}
    </style>

<?php include_once base_path('assets/fileuploader/src/php/class.fileuploader.php'); ?>
     
<div class="row">
    <div class="col-md-12">
        <div class="float-left col-md-6">
            <h4><i class="icon-circle-right2 mr-2"></i>
                @if(empty($query))
                <span class="font-weight-bold mr-2">Minhas Lojas</span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ count($restaurants) }}</span>
                @else
                <span class="font-weight-bold mr-2">{{__('storeDashboard.total')}}</span>
                <span class="badge badge-primary badge-pill animated flipInX mr-2">{{ count($restaurants) }}</span>
                <span class="font-weight-bold mr-2">Resultados para  "{{ $query }}"</span>
                @endif
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="col-md-6" style="display: inline-block; vertical-align: top; text-align: right;">
            <div >
                <button type="button" class="btn btn-primary" id="addNewRestaurant"
                    data-toggle="modal" data-target="#addNewRestaurantModal">
                    <b><i class="icon-plus2"></i></b>
                    Adicionar Loja
                </button>
                
            </div>
        </div>
    </div>
</div>
<br>

<div class="content">
    <div class="card">
        <div class="card-body">
         
            <div class="table-mod table-responsive">
                <table class="table mt-4 table-centered  mb-0">
                    <thead >
                        <tr>
                            
                            <th>Logo</th>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Status</th>
                            <th style="width: 15%">Criado em</th>
                            <th class="text-center" style="width: 20%;"><i class="
                                icon-circle-down2"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($restaurants as $restaurant)
                        <tr class="item">
                            
                            <td><img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $restaurant->image }}" alt="{{ $restaurant->name }}" height="80" width="80" style="border-radius: 0.275rem;"></td>
                            <td><span class="fw-5 text-info">{{ $restaurant->name }}</span></td>
                            <td>{{ $restaurant->address }}</td>
                            <td>
                                @if(!$restaurant->is_accepted)
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                    
                                </span>
                                @endif
                                @if($restaurant->is_active)
                                <button type="button" class="btn btn-soft-success">Aberto</button>
                                
                                @else 
                                <button type="button" class="btn btn-soft-danger">Fechado</button>
                               
                                @endif
                                
                            </td>
                            <td>{{ $restaurant->created_at->diffForHumans() }}</td>
                            <td class="text-center" >
                                <div >
                                <div class="" style="display: inline-block; vertical-align: top;">
                                    <a href="{{ route('restaurant.get.editRestaurant', $restaurant->id) }}" class="btn btn-primary"> Editar <i class="icon-database-edit2 ml-1"></i></a>
                                </div>
                                {{-- <div class="" style="display: inline-block; vertical-align: top;">
                                    <a href="{{ route('restaurant.deleteRestaurant', $restaurant->id) }}" class="btn btn-danger" style="font-size: 1em"> <i data-feather="trash-2"></i></a>
                                </div> --}}
                            </div>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="addNewRestaurantModal" class="modal fade"  tabindex="-1" role="dialog"
aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span
                        class="font-weight-bold">{{ __('storeDashboard.spAddNewStoreBtn') }}</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                
                
                <form action="{{ route('restaurant.saveNewRestaurant') }}" method="POST"
                    enctype="multipart/form-data" id="myForm"  class="parsley-examples">
                    <div class="row">
                        <div class="col-md-12">

                            <div id="smartwizard-arrows">
                                <ul>
                                    <li><a href="#form-step-1">Dados Gerais<small class="d-block">Etapa 1</small></a></li>
                                    <li><a href="#form-step-2">Logo<small class="d-block">Etapa 2</small></a></li>
                                    <li><a href="#form-step-3">Endereço<small class="d-block">Etapa 3</small></a></li>
                                    <li><a href="#form-step-4">Delivery<small class="d-block">Etapa 4</small></a></li>
                                    {{-- <li><a href="#form-step-5">Horários de Funcionamento<small class="d-block">Etapa 5</small></a></li> --}}
                                    <li><a href="#form-step-6">Finalizar<small class="d-block">Fim</small></a></li>
                                </ul>
            
                                <div class="p-3">
                                    <div id="form-step-1" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais sobre sua loja</h5>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body pl15 pr15">
                                                <div class="form-group col-md-6"
                                                        style="padding-left: 0px; float: left;">
                                                    <label for="name">Nome da Loja</label>
                                                    <input required type="text" class="form-control" name="name"
                                                        id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                        placeholder="{{ __('storeDashboard.sePhStoreName') }}">
                                                </div>
                                                <div class="form-group col-md-6 pr0"
                                                style="padding-right: 0px; padding-left: 0px; float: right;">
                                                        {{-- @foreach($restaurant->restaurant_categories as $resCat)
                                                        <span class="badge badge-flat border-grey-800" style="font-size: 0.9rem;">{{ $resCat->name }}
                                                        </span> 
                                                        @endforeach--}}
                                                        <div class="sel2">
                                                            <label>Categoria da Loja: </label>
                                                            <select id="select2" multiple class="form-control wide" data-plugin="customselect" parsley-trigger="change" data-parsley-errors-container="#select22"  data-parsley-group="form-step-1" name="restaurant_category_restaurant[]" data-parsley-required>
                                                                @foreach($restaurantCategories as $rC)
                                                                <option value="{{ $rC->id }}" class="text-capitalize">{{ $rC->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div  class="select22" id="select22"></div>
                                                        </div>
                                                        
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Descrição</label>
                                                    <input required type="text" class="form-control"
                                                        name="description" id="description"  data-parsley-group="form-step-1" parsley-trigger="change"
                                                        placeholder="{{ __('storeDashboard.sePhDescription') }}">
                                                        
                                                </div>


                                                <div class="form-group col-md-6"
                                                    style="padding-left: 0px; float: left;">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" name="telefone"
                                                        id="telefone">
                                                        <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="form-group col-md-6 pr0"
                                                    style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="whatsapp">Whatsapp</label>
                                                    <input type="text" class="form-control" name="whatsapp"
                                                        id="whatsapp">
                                                </div>
                                                <div class="form-group col-md-6"
                                                    style="padding-left: 0px; float: left;">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" name="email" id="email">
                                                </div>
                                                <div class="form-group col-md-6 pr0"
                                                style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" name="website"
                                                        id="website">
                                                </div>

                                                <div class="form-group col-md-6"
                                                style="padding-left: 0px; float: left;">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="text" class="form-control" name="facebook"
                                                        id="facebook">
                                                </div>

                                                <div class="form-group col-md-6 pr0"
                                                style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="text" class="form-control" name="instagram"
                                                        id="instagram">
                                                </div>


                                                

                                                </div>
                                            </div>
                                        
                                       

                                        </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>
                                    <div id="form-step-2" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="users">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Logo da Loja</h5>
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
                                                                    <span>Clique no botão abaixo para fazer upload de sua Logo</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12" style="margin-top: 20px;">
                                                                    <div >
                                                                        <input required type="file" class="form-control"
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
                                        </div> <!-- end row -->
                                    </div>
                                    <div id="form-step-3" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <i class="ft-map" aria-hidden="true"></i><h5>
                                                            Endereço da Loja</h5>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body pl15 pr15">
                                                        <div class="form-group col-md-6 float-left">
                                                    <label for="address">Endereço Completo</label>
                                                    <input type="text" required class="form-control" 
                                                    name="address" parsley-trigger="change" 
                                                    data-parsley-group="form-step-3"
                                                        id="address">
                                                </div>
                                                <div class="form-group col-md-6 pr0"
                                                style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="pincode">CEP</label>
                                                    <input type="text" required class="form-control" name="pincode"
                                                        id="pincode" data-parsley-group="form-step-3" parsley-trigger="change" >
                                                </div>
                                            </div>
                                        </div>
                                                <div class="users">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <i class="ft-map" aria-hidden="true"></i><h5>
                                                                Encontre a Loja no Mapa</h5>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="card-body pl15 pr15">
                                                            <div class="form-group">
                                                                <input id="searchMapInputt" name="google_address" required
                                                                    class="form-control" type="text" value=""
                                                                    placeholder="Digite aqui o endereço completo da Loja">
                                                            </div>
                                                            <div class="form-group">
                                                                <div id="mapp"></div>
                                                            </div>
                        
                                                            Endereço Completo: <span id="location-snap"></span>
                                                            <div class="form-group"></div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group col-md-6" style="float: right;">
                                                                        <label for="latitude">Latitude</label>
                                                                        <input readonly type="text" class="form-control" name="latitude"
                                                                            id="latitude" value="">
                                                                    </div>
                                                                    <div class="form-group col-md-6" style="float: right;">
                                                                        <label for="longitude">Longitude</label>
                                                                        <input readonly type="text" class="form-control" name="longitude"
                                                                            id="longitude" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div id="form-step-4" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="users">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i><h5> Configurações
                                                                de
                                                                Delivery</h5>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="card-body pl15 pr15">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group col-md-6"
                                                                        style="padding-left: 0px; float: left;">
                                                                        <label for="min_order_price">Pedido Mínimo (R$)</label>
                                                                        <input type="text"
                                                                            class="form-control min_order_price" data-parsley-group="form-step-4"
                                                                            name="min_order_price" id="min_order_price" value="0" parsley-trigger="change" >
                                                                    </div>
                                                                    <div class="form-group col-md-6 pr0"
                                                                        style="padding-right: 0px; padding-left: 0px; float: right;">
                                                                        <label for="delivery_time">Tempo Estimado de Entrega</label>
                                                                        <input type="text"
                                                                            class="form-control delivery_time"
                                                                            name="delivery_time" id="delivery_time"
                                                                            placeholder="{{ __('storeDashboard.sePhApproxDeliveryTime') }}"
                                                                            required>
                                                                    </div>
                
                
                
                                                                    <div class="form-group col-md-6"
                                                                        style="padding-left: 0px; float: left;">
                                                                        <label for="delivery_type">Tipo de Venda Aceitável</label>
                                                                        <select class="form-control select-search" name="delivery_type"
                                                                            required>
                                                                            <option value="1" class="text-capitalize">Delivery</option>
                                                                            <option value="2" class="text-capitalize">Retirada na Loja
                                                                            </option>
                                                                            <option value="3" class="text-capitalize">Delivery e
                                                                                Retirada na
                                                                                Loja</option>
                                                                        </select>
                                                                    </div>
                
                
                
                                                                    <div class="form-group col-md-6 pr0"
                                                                        style="padding-right: 0px; padding-left: 0px; float: right;">
                                                                        <label for="delivery_radius">Raio de Entrega em Km:</label>
                                                                        <input type="text"
                                                                            class="form-control  delivery_radius"
                                                                            name="delivery_radius" placeholder="Raio de Entrega em Km ">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                    <div class="delivery-div">
                                                                        <div class="form-group row">
                                                                            
                                                                            <div class="col-lg-9">
                                                                                <label ><span
                                                                                    class="text-danger">*</span>Taxa de Entrega:</label>
                                                                                <select class="form-control select-search"
                                                                                    name="delivery_charge_type" id="delivery_charge_type" required>
                                                                                    <option value="FREE" class="text-capitalize">Entrega Gratuita</option>
                                                                                    <option value="FIXED" class="text-capitalize">Taxa Fixa</option>
                                                                                    <option value="DYNAMIC" class="text-capitalize">Taxa Variável</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="hidden" id="deliveryCharge">
                                                                           
                                                                            <div class="col-lg-9">
                                                                                <label >Taxa Fixa:</label>
                                                                                <input type="text"
                                                                                    class="form-control  delivery_charges"
                                                                                    name="delivery_charges"
                                                                                    placeholder="Taxa de Entrega em R$">
                                                                            </div>
                                                                        </div>
                                                                        <div id="dynamicChargeDiv" class="hidden">
                                                                            <div class="form-group">
                                                                                <div class="col-lg-12 row">
                                                                                    <div class="col-lg-6">
                                                                                        <label class="col-lg-12 col-form-label">Taxa Base:</label>
                                                                                        <input type="text"
                                                                                            class="form-control base_delivery_charge"
                                                                                            name="base_delivery_charge"
                                                                                            placeholder="Em R$">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label class="col-lg-12 col-form-label">Distância para Taxa base:</label>
                                                                                        <input type="text"
                                                                                            class="form-control  base_delivery_distance"
                                                                                            name="base_delivery_distance"
                                                                                            placeholder="Em Kilômetros (Km)">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label class="col-lg-12 col-form-label">Taxa Extra:</label>
                                                                                        <input type="text"
                                                                                            class="form-control  extra_delivery_charge"
                                                                                            name="extra_delivery_charge"
                                                                                            placeholder="Em R$">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label class="col-lg-12 col-form-label">Distância para Taxa Extra</label>
                                                                                        <input type="text"
                                                                                            class="form-control  extra_delivery_distance"
                                                                                            name="extra_delivery_distance"
                                                                                            placeholder="Em Kilômetros (Km)">
                                                                                    </div>
                                                                                </div>
                                                                                <p class="help-text mt-2 mb-0 text-muted"> Base delivery
                                                                                    charges will be applied to the
                                                                                    base delivery distance. And for every extra delivery
                                                                                    distance, extra delivery charge
                                                                                    will be applied.</span>
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
                                   {{--  <div id="form-step-5" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">

                                            </div>
                                        </div>
                                    </div> --}}
                                    <div id="form-step-6" role="form" data-toggle="validator">
                                        <div class="row">
                                            <div class="col-12">
                                               
                                                        <div class="text-center">
                                                            <div class="mb-3">
                                                                <i class="uil uil-check-square text-success h2"></i>
                                                            </div>
                                                            <h3>Parabéns! Sua loja foi cadastrada com Sucesso!</h3>
                    
                                                            <p class="w-75 mb-2 mx-auto text-muted">Além das configurações que já foram feitas aqui nesta etapa, é muito importante que faça as configurações de "Horários de Funcionamento" da loja. Depois de clicar em "Salvar Loja", na próxima tela, clique no botão "Editar", e depois na aba "Horários de Funcionamento", e adicione os horários de abertura e fechamento da loja.</p>

                                                            <div class="mb-3" >
                                                                <div class="custom-control custom-checkbox" id="checkbox3">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="sm-arrows-customCheck">
                                                                    <label class="custom-control-label" for="sm-arrows-customCheck">Eu Concordo com os Termos e Condições do App CompraBakana</label>
                                                                </div>
                                                            </div>
                                                        </div>       
                                                
                                                @csrf
                                                <div id="submit2" class="text-center hidden">
                                                    <button type="submit" class="btn btn-primary">
                                                        Salvar Loja
                                                        <i class="icon-database-insert ml-1"></i></button>
                                                </div>
                                                           
                                            </div>
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


@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4L-3lYoVlcWbVOG6gHyUpVUp7M0EEMvM&libraries=places&language=pt_BR&region=BR&callback=initMap" async defer></script>
<script>

$('#checkbox3 input[type=checkbox]').on('change', function () {
  if($(this).prop('checked') == true)
      $("#submit2").show();  // checked
  else if(!$("#checkbox3 input[type=checkbox]:checked").length)
      $("#submit2").hide();  // unchecked
  })


 
 $("#select2").change(function() {
  $("#select2").trigger('input')
});



        $('#smartwizard-arrows').on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
            var elmForm = $("#form-step-" + (stepNumber + 1));
            if (stepDirection === 'forward' && elmForm) {
                elmForm.validator('validate');
                $('#myForm').parsley().validate({
                    group: "form-step-" + (stepNumber + 1)
                });
                var elmErr = elmForm.find('.has-error');
                if (elmErr && elmErr.length > 0) {
                    return false;
                }
                var image = document.getElementById('image').value;
                var step = "form-step-" + (stepNumber + 1);
                if (step == 'form-step-2' && !image) {
                    $('[name="image"]').parsley().validate();
                    return false;
                }
            }
            return true;
        });
    
    function initMap() {
        var lat = -19.9362369;
        var lng = -43.9322733;

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
        });
    }


    function bindDataToForm(address, lat, lng) {
        document.getElementById('location').value = address;
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }
</script>
<script>
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
        $('.select-search').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Select Location',
        });

        var primary = document.querySelector('.switchery-primary');
        var switchery = new Switchery(primary, {
            color: '#2196F3'
        });

        $('.form-control-uniform').uniform();

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
            maxDecimalPlaces: 2
        });
        $('.delivery_charges').numeric({
            allowThouSep: false,
            maxDecimalPlaces: 2
        });
        $('.min_order_price').numeric({
            allowThouSep: false,
            maxDecimalPlaces: 2,
            allowMinus: false
        });
    });


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

        $("[name='delivery_charge_type']").on("change", function () {
            if ($(this).val() == "FIXED") {
                $("[name='base_delivery_charge']").val(null);
                $("[name='base_delivery_distance']").val(null);
                $("[name='extra_delivery_charge']").val(null);
                $("[name='extra_delivery_distance']").val(null);
                $('#dynamicChargeDiv').addClass('hidden');
                $('#deliveryCharge').removeClass('hidden')
            }
            if ($(this).val() == "DYNAMIC") {

                $("[name='delivery_charges']").val(null);
                $('#deliveryCharge').addClass('hidden');
                $('#dynamicChargeDiv').removeClass('hidden')
            }
            if ($(this).val() == "FREE") {

                $('#dynamicChargeDiv').addClass('hidden');
                $('#deliveryCharge').addClass('hidden')
            }


        });



        $('.form-control-uniform').uniform();

        $('#downloadSampleRestaurantCsv').click(function (event) {
            event.preventDefault();
            window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
        });

        $('.rating').numeric({
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







    });

    //Switch Action Function
    if (Array.prototype.forEach) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.action-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#8360c3'
            });
        });
    } else {
        var elems = document.querySelectorAll('.action-switch');
        for (var i = 0; i < elems.length; i++) {
            var switchery = new Switchery(elems[i], {
                color: '#8360c3'
            });
        }
    }

    $('.action-switch').click(function (event) {
        let id = $(this).attr("data-id")
        let url = "{{ url('/admin/store/disable/') }}/" + id;
        window.location.href = url;
    });


    //TRADUÇÃO PARSLEY
    Parsley.addMessages('pt-br', {
        defaultMessage: "Este valor parece ser inválido.",
        type: {
            email: "Este campo deve ser um email válido.",
            url: "Este campo deve ser um URL válida.",
            number: "Este campo deve ser um número válido.",
            integer: "Este campo deve ser um inteiro válido.",
            digits: "Este campo deve conter apenas dígitos.",
            alphanum: "Este campo deve ser alfa numérico."
        },
        notblank: "Este campo não pode ficar vazio.",
        required: "Este campo é obrigatório.",
        pattern: "Este campo parece estar inválido.",
        min: "Este campo deve ser maior ou igual a %s.",
        max: "Este campo deve ser menor ou igual a %s.",
        range: "Este campo deve estar entre %s e %s.",
        minlength: "Este campo é pequeno demais. Ele deveria ter %s caracteres ou mais.",
        maxlength: "Este campo é grande demais. Ele deveria ter %s caracteres ou menos.",
        length: "O tamanho deste campo é inválido. Ele deveria ter entre %s e %s caracteres.",
        mincheck: "Você deve escolher pelo menos %s opções.",
        maxcheck: "Você deve escolher %s opções ou mais",
        check: "Você deve escolher entre %s e %s opções.",
        equalto: "Este valor deveria ser igual."
    });

    Parsley.setLocale('pt-br');

    //TRADUÇÃO PARSLEY

</script>
@endsection

@section('script-bottom')
<script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection