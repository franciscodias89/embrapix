@extends('layouts.app')
@section("title") {{__('storeDashboard.spPageTitle')}}
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/multiselect/multiselect.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet" />

<style>
    .hidden{ 
    display: none;
}



.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: #f8f9fa;
    background-color: #5369f8;
    box-shadow: 0 0.05rem 0.01rem rgba(75, 75, 90, 0.075);
}
.nav-link:hover, .nav-link:focus {
    text-decoration: none;
    background-color: #e2e7f1;
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

    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: #6c757d;
    background-color: #fff;
    height: 50px;
    box-shadow: 0 0.05rem 0.01rem rgba(75, 75, 90, 0.075);
}
.nav-pills .nav-link {
    background-color: transparent;
    color: #6c757d;
    line-height: 35px;
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
.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: #f8f9fa;
    background-color: #5369f8;
    box-shadow: 0 0.05rem 0.01rem rgba(75, 75, 90, 0.075);
}
.nav-pills .nav-link:hover {
    background-color: #e2e7f1;
    color: #6c757d;
    line-height: 35px;
}
.nav-pills .nav-link {
   
}
.nav-pills {
    background: #f3f4f7;
    border-radius: 0.3rem;
    padding: 15px 2px;
}

.nav-tabs > li > a, .nav-pills > li > a {
    color: #4B4B5A;
    font-weight: 600;
}
body {
    font-size: 0.975rem;
    font-weight: 400;
    line-height: 1.5;
   
}
.card-body {
    flex: 1 1 auto;
    padding: 2rem;
}
</style>
<form action="{{ route('restaurant.updateRestaurant') }}" method="POST" id="formgeral" enctype="multipart/form-data"> 
<div class="col-md-12 row" style="margin-bottom: 25px;">
                
    <div class="float-left col-md-6">
        <div class="">
            <div class="">
                <h4><i class="icon-circle-right2 mr-2"></i>
                    <span class="font-weight-bold mr-2">Editando a Loja: </span>
                    <span class="badge badge-primary badge-pill animated flipInX">"{{ $restaurant->name }}"</span>
                </h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="display: inline-block; vertical-align: top; text-align: right;">
    
    <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
    <div class="" style="display: inline-block; vertical-align: top;">
        <div class="btn-group btn-group-justified" style="width: 150px">
            @if($restaurant->is_active)
            <h5> ABERTO </h5>
           <div class="spinner-grow text-success m-2" role="status">
                        <span class="sr-only">Aberto...</span>
           </div>
            
            
            @else
            <h5> FECHADO </h5>
           <div class="spinner-grow text-danger m-2" role="status">
                        <span class="sr-only">Fechado...</span>
           </div>
            @endif 
        </div>
    </div>
    
            @csrf
            <div class="" style="display: inline-block; vertical-align: top;">
                <div class="btn-group btn-group-justified" style="width: 150px">
                    @if($restaurant->is_active)
                   <a href="{{ route('restaurant.disableRestaurant', $restaurant->id) }}"
                        class="btn btn-danger mr-2" data-popup="tooltip"
                        title="Os usuários do APP não poderão realizar compras na sua loja se estiver fechada" data-placement="bottom">
                    <b><i class="icon-switch2"></i></b>
                    Fechar Loja
                    </a>
                    @else
                    <a href="{{ route('restaurant.disableRestaurant', $restaurant->id) }}"
                        class="btn btn-success  mr-2" data-popup="tooltip"
                        title="A loja está fechada. Abra a loja para aceitar pedidos." data-placement="bottom">
                    <b><i class="icon-switch2"></i></b>
                    Abrir Loja
                    </a>
                    @endif 
                </div>
            </div>
            <div class="" style="display: inline-block; vertical-align: top;">
       
                <a href="{{ route('restaurant.restaurants') }}"
                    class="btn btn-outline-info" data-popup="tooltip"
                    title="Os usuários do APP não poderão realizar compras na sua loja se estiver fechada" data-placement="bottom">
                <b><i class="icon-switch2"></i></b>
                Voltar
                </a>
            
        </div>
       
            <div class="" style="display: inline-block; vertical-align: top;">
                <button type="submit"  class="btn btn-primary">
                Salvar Alterações
                <i class="icon-database-insert ml-1"></i>
                </button>
            </div>
        </div> 
    </div>
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            
                <input type="hidden" name="id" value="{{ $restaurant->id }}">
                <ul class="nav nav-pills navtab-bg nav-justified col-xl-3 float-left" style="display:block">
                <li class="nav-item">
                    <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                        <span class="d-block d-sm-none"><i class="uil-home-alt"></i></span>
                        <span class="d-none d-sm-block">Informações Gerais</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link ">
                        <span class="d-block d-sm-none"><i class="uil-user"></i></span>
                        <span class="d-none d-sm-block">Logomarca</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#menu3" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uil-envelope"></i></span>
                        <span class="d-none d-sm-block">Endereço e Mapa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#menu4" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uil-envelope"></i></span>
                        <span class="d-none d-sm-block">Configurações de Delivery</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#menu5" data-toggle="tab" aria-expanded="false" class="nav-link">
                        <span class="d-block d-sm-none"><i class="uil-envelope"></i></span>
                        <span class="d-none d-sm-block">Horários de Funcionamento</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content text-muted col-md-9 float-right ml-20" style="padding: 0px 30px 20px 30px;">
                
                    
                <div class="tab-pane show active" id="home1">
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
                                    <input required type="text" value="{{ $restaurant->name }}" class="form-control" name="name"
                                    id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                    placeholder="{{ __('storeDashboard.sePhStoreName') }}">
                                    </div>
                                    
                                    <div class="form-group col-md-6 pr0"
                                        style="padding-right: 0px; padding-left: 0px; float: right;">
                                    
                                    <div class="sel2">
                                        <label>Categoria da Loja: </label>
                                        <select id="select2" multiple class="form-control wide" data-plugin="customselect" parsley-trigger="change" data-parsley-errors-container="#select22"  data-parsley-group="form-step-1" name="restaurant_category_restaurant[]" data-parsley-required>
                                            @foreach($restaurantCategories as $rC)
                                            <option value="{{ $rC->id }}" class="text-capitalize" <?php if (in_array($rC->id, $arraycategories)) { echo "selected"; } ?> >{{ $rC->name }}</option>
                                            @endforeach
                                        </select>
                                        <div  class="select22" id="select22"></div>
                                    </div>
                                    
                                </div>

                            <div class="form-group">
                                <label for="description" data-toggle="tooltip" data-placement="right"
                                title="Pequena descrição sobre sua loja" >Descrição</label>
                                <input required type="text" class="form-control"
                                    name="description" value="{{ $restaurant->description }}" id="description"  data-parsley-group="form-step-1" parsley-trigger="change"
                                    placeholder="Pequeno texto que descreva seu estabelecimento">
                                    
                            </div>


                            <div class="form-group col-md-6"
                                style="padding-left: 0px; float: left;">
                                <label for="telefone">Telefone</label>
                                <input type="text" value="{{ $restaurant->telefone }}" class="form-control" name="telefone"
                                    id="telefone">
                                    <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-md-6 pr0"
                                style="padding-right: 0px; padding-left: 0px; float: right;">
                                <label for="whatsapp">Whatsapp</label>
                                <input type="text" class="form-control" value="{{ $restaurant->whatsapp }}" name="whatsapp"
                                    id="whatsapp">
                            </div>
                            <div class="form-group col-md-6"
                                style="padding-left: 0px; float: left;">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" value="{{ $restaurant->email }}" name="email" id="email">
                            </div>
                            <div class="form-group col-md-6 pr0"
                            style="padding-right: 0px; padding-left: 0px; float: right;">
                                <label for="website">Website</label>
                                <input type="text" class="form-control" value="{{ $restaurant->website }}"name="website"
                                    id="website">
                            </div>

                            <div class="form-group col-md-6"
                            style="padding-left: 0px; float: left;">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" value="{{ $restaurant->facebook }}" name="facebook"
                                    id="facebook">
                            </div>

                            <div class="form-group col-md-6 pr0"
                            style="padding-right: 0px; padding-left: 0px; float: right;">
                                <label for="instagram">Instagram</label>
                                <input type="text" class="form-control" value="{{ $restaurant->instagram }}" name="instagram"
                                    id="instagram">
                            </div>


                            

                            </div>
                        </div>
                        </div> <!-- end col -->  



                </div>
                </div>
                <div class="tab-pane" id="profile1">
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
                                        <input type="text" name="old_image" hidden value="{{$restaurant->image}}">
                                        <div class="row">
                                            <div class="col-md-5" style="float: right;">

                                                <div class="imagelogo">
                                                    <img class="slider-preview-image" src="{{ $restaurant->image }}"/>
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
                                                    <input type="file" class="form-control"
                                                        name="image"   id="image"
                                                       accept="image/x-png,image/gif,image/jpeg" value="{{ $restaurant->image }}" 
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
                <div class="tab-pane" id="menu3">
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
                                name="address" value="{{ $restaurant->address }}" parsley-trigger="change" 
                                data-parsley-group="form-step-3"
                                    id="address">
                            </div>
                            <div class="form-group col-md-6 pr0"
                            style="padding-right: 0px; padding-left: 0px; float: right;">
                                <label for="pincode">CEP</label>
                                <input type="text" required  value="{{ $restaurant->pincode }}" class="form-control" name="pincode"
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
                                            <input id="searchMapInputt" name="google_address" value="{{$restaurant->google_address}}" required
                                                class="form-control" type="text" 
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
                                                    <input readonly type="text" value="{{$restaurant->latitude}}"class="form-control" name="latitude"
                                                        id="latitude" value="">
                                                </div>
                                                <div class="form-group col-md-6" style="float: right;">
                                                    <label for="longitude">Longitude</label>
                                                    <input readonly type="text" value="{{$restaurant->longitude}}" class="form-control" name="longitude"
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

                <div class="tab-pane" id="menu4">
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
                                                    <input type="text" value="{{$restaurant->min_order_price}}"
                                                        class="form-control dinheiro" data-parsley-group="form-step-4"
                                                        name="min_order_price" id="min_order_price" value="0" parsley-trigger="change" >
                                                </div>
                                                <div class="form-group col-md-6 pr0"
                                                    style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="delivery_time">Tempo Estimado de Entrega</label>
                                                    <input type="text" value="{{$restaurant->delivery_time}}"
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
                                                        <option value="1" class="text-capitalize" <?php if ($restaurant->delivery_type === 1) { echo "selected"; } ?> >Somente Delivery</option>
                                                        <option value="2" class="text-capitalize" <?php if ($restaurant->delivery_type === 2) { echo "selected"; } ?> >Somente Retirada na Loja</option>
                                                        <option value="3" class="text-capitalize" <?php if ($restaurant->delivery_type === 3) { echo "selected"; } ?> >Delivery e Retirada na Loja</option>
                                                    </select>
                                                </div>



                                                <div class="form-group col-md-6 pr0"
                                                    style="padding-right: 0px; padding-left: 0px; float: right;">
                                                    <label for="delivery_radius">Raio de Entrega em Km:</label>
                                                    <input type="text" value="{{$restaurant->delivery_radius}}" 
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
                                                                <option value="FREE" class="text-capitalize" <?php if ($restaurant->delivery_charge_type ==='FREE') { echo "selected"; } ?> >Entrega Gratuita</option>
                                                                <option value="FIXED" class="text-capitalize" <?php if ($restaurant->delivery_charge_type ==='FIXED') { echo "selected"; } ?> >Taxa Fixa</option>
                                                                <option value="DYNAMIC" class="text-capitalize" <?php if ($restaurant->delivery_charge_type ==='DYNAMIC') { echo "selected"; } ?> >Taxa Variável</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="hidden" id="deliveryCharge">
                                                    
                                                        <div class="col-lg-9">
                                                            <label >Taxa Fixa:</label>
                                                            <input type="text" value="{{$restaurant->delivery_charges}}"
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
                                                                    <input type="text" value="{{$restaurant->base_delivery_charge}}"
                                                                        class="form-control dinheiro"
                                                                        name="base_delivery_charge"
                                                                        placeholder="Em R$">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="col-lg-12 col-form-label">Distância base:</label>
                                                                    <input type="text" value="{{$restaurant->base_delivery_distance}}"
                                                                        class="form-control  base_delivery_distance"
                                                                        name="base_delivery_distance"
                                                                        placeholder="Em Kilômetros (Km)">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="col-lg-12 col-form-label">Taxa Extra:</label>
                                                                    <input type="text" value="{{$restaurant->extra_delivery_charge}}"
                                                                        class="form-control  dinheiro"
                                                                        name="extra_delivery_charge"
                                                                        placeholder="Em R$">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="col-lg-12 col-form-label">Distância Extra</label>
                                                                    <input type="text" value="{{$restaurant->extra_delivery_distance}}"
                                                                        class="form-control  extra_delivery_distance"
                                                                        name="extra_delivery_distance"
                                                                        placeholder="Em Kilômetros (Km)">
                                                                </div>
                                                            </div>
                                                            <p class="help-text mt-2 mb-0 text-muted"> A "Taxa Base" será aplicada à "Distância Base", e,
                                                                para cada "Distância Extra", será aplicado uma "Taxa Extra"</span>
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

                
<div class="tab-pane" id="menu5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ft-map" aria-hidden="true"></i><h5>
                    Horários de Funcionamento</h5>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                
                     <br><br> <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
                    
                    <div class="form-group row mb-0">
                        <div class="col-lg-12">
                            <h4>Segunda-Feira</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->monday) && count($schedule_data->monday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->monday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text"  class="form-control clock" value="{{$time->open}}"
                                name="monday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text"  class="form-control clock" value="{{$time->close}}"
                                name="monday[]" required>
                        </div>
                        <div class="col-lg-2" day="monday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="monday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="monday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Terça-Feira</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->tuesday) && count($schedule_data->tuesday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->tuesday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock " value="{{$time->open}}"
                                name="tuesday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock " value="{{$time->close}}"
                                name="tuesday[]" required>
                        </div>
                        <div class="col-lg-2" day="tuesday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="tuesday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="tuesday" class="btn btn-primary mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Quarta-Feira</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->wednesday) && count($schedule_data->wednesday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->wednesday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->open}}"
                                name="wednesday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->close}}"
                                name="wednesday[]" required>
                        </div>
                        <div class="col-lg-2" day="wednesday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="wednesday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="wednesday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Quinta-Feira</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->thursday) && count($schedule_data->thursday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->thursday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->open}}"
                                name="thursday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->close}}"
                                name="thursday[]" required>
                        </div>
                        <div class="col-lg-2" day="thursday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="thursday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="thursday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Sexta-Feira</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->friday) && count($schedule_data->friday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->friday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->open}}"
                                name="friday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->close}}"
                                name="friday[]" required>
                        </div>
                        <div class="col-lg-2" day="friday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif 
                    <div id="friday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="friday" class="btn btn-primary mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Sábado</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->saturday) && count($schedule_data->saturday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->saturday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->open}}"
                                name="saturday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->close}}"
                                name="saturday[]" required>
                        </div>
                        <div class="col-lg-2" day="saturday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="saturday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="saturday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-lg-4">
                            <h4>Domingo</h4>
                        </div>
                    </div>
                    <!-- Checks if there is any schedule data -->
                    @if(!empty($schedule_data->sunday) && count($schedule_data->sunday) > 0)
                    <!-- If yes Then Loop Each Data as Time SLots -->
                    @foreach($schedule_data->sunday as $time)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->open}}"
                                name="sunday[]" required>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                            <input type="text" class="form-control clock" value="{{$time->close}}"
                                name="sunday[]" required>
                        </div>
                        <div class="col-lg-2" day="sunday">
                            <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                            <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Horário">
                            <i class="uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div id="sunday" class="timeSlots">
                    </div>
                    <a href="javascript:void(0)" onclick="add(this)" data-day="sunday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                    <hr>
                    
                
            </div>
        </div>
    </div>

</div>

            </div>
        
        </div>
    </div>
</div>

</form> 


@endsection
@section('script')

<script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4L-3lYoVlcWbVOG6gHyUpVUp7M0EEMvM&libraries=places&language=pt_BR&region=BR&callback=initMap" async defer></script>

<script>

$(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
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
        para.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><label class='col-form-label'>Abre às:</label><input type='text' class='form-control clock' name='"+day+"[]' required> </div> <div class='col-lg-5'> <label class='col-form-label'>Fecha às:</label><input type='text' class='form-control clock' name='"+day+"[]'  required> </div> <div class='col-lg-2'> <label class='col-form-label text-center' style='width: 70px'></span>Remover</label><br><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='uil-trash-alt'></i></button></div></div>";
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

        $('body').tooltip({
            selector: 'button'
        });
        
        $('.clock').flatpickr({
            enableTime: true,
    noCalendar: true,
    time_24hr: true,
    dateFormat: "H:i",
        });
        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
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
    
       $('.form-control-uniform').uniform();

       $('.delivery_time').numeric({allowThouSep:false});
       $('.price_range').numeric({allowThouSep:false});
       $('.latitude').numeric({allowThouSep:false});
       $('.longitude').numeric({allowThouSep:false});
       $('.restaurant_charges').numeric({ allowThouSep:false, maxDecimalPlaces: 2 });
       $('.delivery_charges').numeric({ allowThouSep:false, maxDecimalPlaces: 2 });
       $('.min_order_price').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
    });

    $("#select2").change(function() {
  $("#select2").trigger('input')
})

function initMap() {
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
        });
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