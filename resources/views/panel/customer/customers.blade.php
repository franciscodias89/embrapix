@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">


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


.card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}


.row {
     margin-right: 0px;
    margin-left: 0px;
}


table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
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


table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
}
table td{
       word-wrap:break-word;
    }

        </style>
 <?php


 //$url = get_url('inc/plugins/fileuploader');

 $preloadedFiles = '';

 ?>
 <?php include_once base_path('assets/fileuploader/src/php/class.fileuploader.php'); ?>

 <div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Clientes</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            {{-- <div class="action-btn">
                                <div class="form-group mb-0">
                                    <div class="input-container icon-left position-relative">
                                            <span class="input-icon icon-left">
                                                <span data-feather="calendar"></span>
                                            </span>
                                        <input type="text" class="form-control form-control-default date-ranger" name="date-ranger" placeholder="Oct 30, 2019 - Nov 30, 2019">
                                        <span class="input-icon icon-right">
                                                <span data-feather="chevron-down"></span>
                                            </span>
                                    </div>
                                </div>
                            </div> --}}
                          {{--   <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <span class="dropdown-item">Export With</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-print"></i> Printer</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-pdf"></i> PDF</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-text"></i> Google Sheets</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-excel"></i> Excel (XLSX)</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-csv"></i> CSV</a>
                                </div>
                            </div>
                            <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-share"></i> Share
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                    <span class="dropdown-item">Share Link</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-facebook"></i> Facebook</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-twitter"></i> Twitter</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-google"></i> Google</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-feed"></i> Feed</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-instagram"></i> Instagram</a>
                                </div>
                            </div>
                            <div class="action-btn">
                                <a href="" class="btn btn-sm btn-primary btn-add">
                                    <i class="la la-plus"></i> Add New</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable orderDatatable global-shadow border py-30 px-sm-30 px-20 bg-white radius-xl w-100 mb-30">
                    <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                            {{-- <div class="project-search order-search  global-shadow mt-10">
                                <form action="/" class="order-search__form">
                                    <span data-feather="search"></span>
                                    <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                                </form>
                            </div><!-- End: .project-search --> --}}
                            <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
                                <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                <div class="project-tap order-project-tap global-shadow">
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.customers') ? 'active' : ''}}" href="{{ route('panel.customers') }}">Todos</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.freeSeparators') ? 'active' : ''}}" href="{{ route('panel.freeSeparators') }}">Livres</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.workingSeparators') ? 'active' : ''}}" href="{{ route('panel.workingSeparators') }}" >Separando Pedidos
                                                </a>
                                        </li> --}}
                                       {{--  <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.deletedSeparators') ? 'active' : ''}}" href="{{ route('panel.deletedSeparators') }}">Lixeira</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div><!-- End: .project-category -->
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                @if($restaurant->status == 8)
                               
                                <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md" 
                                data-toggle="modal" onclick="window.location='{{ route('wizard.wizard_panel') }}'" >
                                <i class="la la-arrow-left"></i>Voltar</button>

                                @endif 
                                <button type="button" class="btn btn-primary" 
                                data-toggle="modal" data-target="#addNewFlyerModal2">
                                <i class="la la-plus"></i>Adicionar Cliente</button>

                                {{-- <a class="btn btn-primary btn-labeled btn-labeled-left" href="{{route('restaurant.newAddonCategory')}}">
                                    <b><i class="icon-plus2"></i></b>
                                    Adicionar Novo Grupo
                                </a> --}}
                            </div>
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->
                    <div class="tab-content" id="ap-tabContent">
                        <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0" id="itemsDataTable">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23e">
                                                        <label for="check-23e">
                                                                    <span class="checkbox-text ml-3">
                                                                        Nome
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        
                                        <th>
                                            <span class="userDatatable-title">CPF</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Telefone</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Status</span>
                                        </th>
                                       
                                        <th>
                                            <span class="userDatatable-title">Compras Efetuadas</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Total Compras</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Última Compra</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Primeira Compra:</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Ações</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr class="item">
                                            
                                            <td> 
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3 d-flex align-items-center">
                                                        <div class="checkbox-group-wrapper">
                                                            <div class="checkbox-group d-flex">
                                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox" id="check-grp-12">
                                                                    <label for="check-grp-12"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="orderDatatable-title">
                                                        <p class="d-block mb-0">
                                                            <span >{{ $customer->name }} </span> 
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                            </td>
                                            
                                            <td>
                                                <div class="orderDatatable-title">
                                                <span >{{ $customer->cpf }}</span> 
                                                </div>
                                            </td>
                                            <td>
                                                <div class="orderDatatable-title">
                                                <span >{{ $customer->phone }}</span> 
                                                </div>
                                            </td>
                                           
                                            <td>
                                                @if($customer->is_deleted==0)
                                                  
                                               
                                                 <div class="orderDatatable-status d-inline-block">
                                                    <span class="order-bg-opacity-success  text-success rounded-pill active">Ativo</span>
                                                </div>
                                                
                                                @endif
                                                @if($customer->is_deleted>0)
                                                 
                                                <div class="orderDatatable-status d-inline-block">
                                                    <span class="order-bg-opacity-danger  text-danger rounded-pill active">Não Ativo</span>
                                                </div>
                                                @endif
                                               
                                            </td>
                                            <td>
                                                <div class="orderDatatable-title">
                                                    <span >{{ $customer->finished }} Pedidos</span> 
                                                    </div>
                                            </td>

                                            <td>
                                                <div class="orderDatatable-title">
                                                    <span >R$ {{ number_format($customer->total,2,",",".") }}</span> 
                                                    </div>
                                            </td>
                                            
                                            
                                            <td><div class="orderDatatable-title float-right">
                                                {{ $last_order->created_at->diffForHumans() }}
                                            </div>
                                            </td>
                                            <td><div class="orderDatatable-title float-right">
                                                {{ $customer->created_at->diffForHumans() }}
                                            </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                       
                                                    @if(Request::is('store-owner/separators/deleted'))
                                                    <li>
                                                        <a href="{{ route('panel.restoreSeparator', $customer->id) }}" title="Restaurar" class="edit">
                                                            <span data-feather="rotate-ccw" ></span></a>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <a href="{{ route('panel.editSeparator', $customer->id) }}" title="Editar" class="edit">
                                                            <span data-feather="edit"></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('panel.deleteSeparator', $customer->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir?')" class="remove">
                                                            <span data-feather="trash-2" ></span></a>
                                                    </li>
                                                    @endif
                                                </ul>
                                              
                                               
                                               
                                                
                                            </td>
                                        </tr>
                                        
                
                     
                
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="mt-3">
                                    {{ $flyers->links() }}
                                </div> --}}
                            </div>
                            <!-- Table Responsive End -->
                        </div>
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23u">
                                                        <label for="check-23u">
                                                                    <span class="checkbox-text ml-3">
                                                                        order id
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customers</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                     
                                    </tbody>
                                </table>
                            </div>
                            <!-- Table Responsive End -->
                        </div>
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23">
                                                        <label for="check-23">
                                                                    <span class="checkbox-text ml-3">
                                                                        order id
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customers</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                           
                                    </tbody>
                                </table>
                            </div>
                            <!-- Table Responsive End -->
                        </div>

                    </div>
                    
                    {{-- <div class="mt-4">
                        {{ $flyers->appends($_GET)->links() }}
                    </div> --}}
                    
                   {{--  <div class="d-flex justify-content-sm-end justify-content-start mt-15 pt-25 border-top">
                        <nav class="atbd-page ">
                            <ul class="atbd-pagination d-flex">
                                <li class="atbd-pagination__item">
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-left"></span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">1</span></a>
                                    <a href="#" class="atbd-pagination__link active"><span class="page-number">2</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">3</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="page-number">...</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">12</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-right"></span></a>
                                    <a href="#" class="atbd-pagination__option">
                                    </a>
                                </li>
                                <li class="atbd-pagination__item">
                                    <div class="paging-option">
                                        <select name="page-number" class="page-selection">
                                            <option value="20">20/page</option>
                                            <option value="40">40/page</option>
                                            <option value="60">60/page</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
                </div><!-- End: .userDatatable -->
            </div><!-- End: .col -->
        </div>
    </div>
</div>












<div id="addNewFlyerModal" class="modal fade">
    <?php


 //$url = get_url('inc/plugins/fileuploader');

 $preloadedFiles = '';

 ?>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Colaborador</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.saveNewFlyer') }}" method="POST" enctype="multipart/form-data">

                    
                        <div class="row col-md-12">
                            <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais do Folheto</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="hidden" name="flyer_restaurant_flyer" id="flyer_restaurant_flyer" value="{{ $restaurant_id }}">
                                                       
                                    <div class="card-body pl15 pr15">
                                        <div class="form-group">
                                            <label for="name">Nome para o Folheto</label>
                                            <input required type="text" class="form-control name" name="name"
                                                id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                placeholder="Nome para o Folheto">
                                        </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-6" style="padding-left: 0px;">
                                            <label for="start_date">Data Início</label>
                                            <input  required type="date" class="form-control"
                                                name="start_date" id="start_date"    parsley-trigger="change"
                                               >
                                                
                                        </div>
                                        <div class="form-group col-md-6 pr0" style="padding-right: 0px; padding-left: 0px;">
                                            <label for="end_date">Data Fim</label>
                                            <input  required type="date" class="form-control"
                                                name="end_date" id="end_date"   parsley-trigger="change"
                                               >
                                                
                                        </div>
                                    </div>
                                    
                                        {{-- <div class="form-group">
                                                <div class="sel2">
                                                    <label>Lojas: </label>
                                                    <select id="select2" multiple class="form-control wide" data-plugin="customselect" parsley-trigger="change" data-parsley-errors-container="#select22"  data-parsley-group="form-step-1" name="flyer_restaurant_flyer[]" data-parsley-required>
                                                        @foreach($restaurants as $restaurant)
                                                        <option value="{{ $restaurant->id }}" class="text-capitalize">{{ $restaurant->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagens</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            <div class="row">
												<div class="col-md-12">
												<div class="form-group">
														<input type="file"   name="files"  data-fileuploader-files='<?php echo $preloadedFiles;?>'>
													</div>
												</div>

											</div>

                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Salvar Folheto
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
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
<script src="https://app.comprabakana.com.br/assets/fileuploader/examples/sorter/default/js/custom.js" type="text/javascript"></script>
<script src="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>


$('#itemsDataTable').DataTable(
        {
            bLengthChange : true,
            searching: true,
            pageLength : 10,
            bInfo: true,
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

   
   $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    });   

    $("#select2").change(function() {
  $("#select2").trigger('input')
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
</script>
@endsection


