@extends('layouts.app')
@section("title") Stores - Dashboard
@endsection
@section('content')
<style>
    .delivery-div {
        background-color: #fafafa;
        padding: 1rem;
    }

    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }
</style>
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


<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        
                        <h4 class="text-capitalize breadcrumb-title">Minhas Lojas</h4>
                       
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
                                
                                <form action="{{ route('admin.post.searchRestaurants') }}" method="GET">
                                    <div class="order-search__form">
                                        <span data-feather="search"></span>
                                        <input type="text" class="form-control form-control-lg search-input" placeholder="Search with store name"
                                            name="query">
                                    </div>
                                    <button type="submit" class="hidden">Pesquisar</button>
                                    @csrf
                                </form>
                            </div><!-- End: .project-search -->  --}}
                            {{-- <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
                                <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                <div class="project-tap order-project-tap global-shadow">
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="ap-overview-tab" data-toggle="pill" href="#ap-overview" role="tab" aria-controls="ap-overview" aria-selected="true">Todos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="timeline-tab" data-toggle="pill" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Ativos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Desativados
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="draft-tab" data-toggle="pill" href="#draft" role="tab" aria-controls="draft" aria-selected="false">Ofertas</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- End: .project-category --> --}}
                            {{-- <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
                                <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                <div class="project-tap order-project-tap global-shadow">
                                    @role('Admin')
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('admin.pendingAcceptance') ? 'active' : ''}}" href="{{ route('admin.pendingAcceptance') }}">Lojas Pendentes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('admin.restaurants') ? 'active' : ''}}" href="{{ route('admin.restaurants') }}">Lojas Publicadas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('admin.askedPublish') ? 'active' : ''}}" href="{{ route('admin.askedPublish') }}" >Solicitaram Publicação
                                                </a>
                                        </li>
                                        
                                    </ul>
                                    @endrole

                                    @role('Licencer')
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('licencer.pendingAcceptance') ? 'active' : ''}}" href="{{ route('licencer.pendingAcceptance') }}">Lojas Pendentes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('licencer.restaurants') ? 'active' : ''}}" href="{{ route('licencer.restaurants') }}">Lojas Publicadas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('licencer.askedPublish') ? 'active' : ''}}" href="{{ route('licencer.askedPublish') }}" >Solicitaram Publicação
                                                </a>
                                        </li>
                                        
                                    </ul>
                                    @endrole

                                </div>
                            </div><!-- End: .project-category --> --}}
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                 
                              
                                {{-- <a class="btn btn-primary btn-labeled btn-labeled-left" href="{{route('restaurant.newAddonCategory')}}">
                                    <b><i class="icon-plus2"></i></b>
                                    Adicionar Novo Grupo
                                </a> --}}
                            </div>
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->
                    <div class="tab-content" id="ap-tabContent">
                        <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                            @php
                                                       // dd($restaurants);
                                                    @endphp
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0"  id="itemsDataTable" >
                                    <thead>
                                    <tr class="userDatatable-header">
                                        
                                        <th><span class="userDatatable-title">ID</span></th>
                                      {{--   <th><span class="userDatatable-title">Logo</span></th> --}}
                                        <th><span class="userDatatable-title">Nome</span></th>
                                        <th><span class="userDatatable-title">Fazer Login</span></th>
                                     {{--    <th style="width: 15%"><span class="userDatatable-title">Vendedores</span></th> --}}
                                      
                                        <th style="width: 15%"><span class="userDatatable-title">Adicionado em:</span></th>
                                        <th class="text-center" style="width: 10%;"><i class="
                                            icon-circle-down2"></i><span class="userDatatable-title">Ações</span></th>
                                    </tr>
                                   </thead>
                                    <tbody>
                                        @foreach ($restaurants as $restaurant)
                                        <tr class="item">
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title">{{ $restaurant->id }}
                                                </div>
                                            </td>
                                           {{--  <td><img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $restaurant->image }}"
                                                    alt="" height="80" width="80"
                                                    style="border-radius: 0.275rem;"></td> --}}
                                            
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title">{{ $restaurant->name }}
                                                </div>
                                            </td>
                                            
                                            <td>
                                            @if(count($restaurant->users))
                                            @php
                                                $resUsercount = 0;
                                               
                                            @endphp
                                                @foreach($restaurant->users as $restaurantUser)
                                                    @if($restaurantUser->hasRole("Store Owner"))
                                                    @php
                                                        $resUsercount++;
                                                    @endphp
                                                       
                                                        <div>
                                                            <a href="{{ route('admin.impersonate', $restaurantUser->id) }}"
                                                                        class="mr-1" data-popup="tooltip"
                                                            data-placement="left" title="Login as {{ $restaurantUser->name }}" style="border: 1px solid #E0E0E0; border-radius: 0.275rem; padding: 1.5px 4px;"> <i class="fas fa-arrow-alt-circle-right"></i></a>
                                                        <a href="{{ route('admin.get.editUser', $restaurantUser->id) }}">{{ $restaurantUser->name }}</a>
                                                        </div>
                                                      

                                                    @endif
                                                @endforeach
                                                
                                            @if($resUsercount == 0)
                                            <div class="orderDatatable-status d-inline-block">
                                                <span class="order-bg-opacity-success  text-success rounded-pill active">UNASSIGNED</span>
                                            </div>
                                                
                                            @endif
                                            @else
                                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                                    UNASSIGNED
                                                </span>
                                            @endif
                                            </td>
                                            
                                            <td>{{ date('d/m/Y H:i:s', strtotime($restaurant->created_at)) }}</td>
                                            <td class="text-center">
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                   
                                                    @if(Request::is('store-owner/coupons/deleted'))
                                                    <li>
                                                        <a href="{{ route('panel.restoreCoupon', $restaurant->id) }}" title="Restaurar" class="edit">
                                                            <span data-feather="rotate-ccw" ></span></a>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <a href="{{ route('panel.get.getEditCoupon', $restaurant->id) }}" title="Editar" class="edit">
                                                            <span data-feather="edit"></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('panel.deleteCoupon', $restaurant->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este item?')" class="remove">
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
                                    {{ $restaurants->appends($_GET)->links() }}
                                </div> --}}
                                {{-- <div class="mt-3">
                                    {{ $items->links() }}
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
                    
                     <div class="mt-4">
                        {{-- {{ $coupons->appends($_GET)->links() }} --}}
                    </div> 
                    
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
    <div id="editItemCategory" class="modal fade"  role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="title" class="font-weight-bold"></span></h5>
                    <button type="button" class="close" onclick="javascript:window.location.reload()" data-dismiss="modal">&times;</button>
                </div>
               
                <div class="modal-body">
                    <form action="{{ route('admin.updatePlanTaxes') }}" method="POST">
                        <input type="hidden" name="id" id="idsubaccount">
                        <div class="form-group mb-20">
                            <label >Modalidade:</label>
                            <select class="form-control"
                            name="plan_model" id="plan_model" >
                            <option value="1" class="text-capitalize" selected >Comissionamento</option>
                            <option value="2" class="text-capitalize" >Mensalidade</option>
                            
                        </select>
                        </div>
                        <div class="form-group mb-20" id="plan_div">
                            <label ><span
                                class="text-danger"></span>Plano:</label>
                            <select class="form-control"
                                name="plan" id="plan" >
                                <option value="1" class="text-capitalize" >Plano de Teste - Ilimitado</option>
                                <option value="2" class="text-capitalize" >Plano 2</option>
                                
                            </select>

                        </div>
                     
                        <div class="form-group mb-20" id="free_days_div">
                            <label >Período Gratuito (dias):</label>
                            <div >
                                <input type="text" class="form-control form-control-lg" name="free_days"
                                    placeholder="Periodo Gratis (em Dias)"  id="free_days">
                            </div>
                        </div>
                        <div class="form-group mb-20" id="comission_div">
                            <label >Comissão (CBK) (%):</label>
                            <div >
                                <input type="text" class="form-control form-control-lg dinheiro" name="comission"
                                    placeholder="Comissão CBK"  id="comission">
                            </div>
                        </div>
                        <div class="form-group mb-20">
                            <label >Taxa CBK Pay (%):</label>
                            <div >
                                <input type="text" class="form-control form-control-lg dinheiro" name="credit_card_percent"
                                    placeholder="Taxa CBK Pay"  id="credit_card_percent">
                            </div>
                        </div>

                        <div class="form-group mb-20">
                            <label >Observação:</label>
                            <div >
                                <input type="text" class="form-control form-control-lg dinheiro" name="obs"
                                    placeholder="Observação"  id="obs">
                            </div>
                        </div>
                        @csrf
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                            Salvar
                            <i class="icon-database-insert ml-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="errorSafe2Pay" class="modal fade"  role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="title" class="font-weight-bold"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
               
                <div class="modal-body">
                  
                       
                        <span id="errorSafe" class="font-weight-bold"></span>
                     
                       
                        
                        
                   
                </div>
            </div>
        </div>
    </div>
    

@endsection
@section('scripts')

<script>
$(function() {

         $('body').on('click', '.editItemCategory', function () {
        
            $('#idsubaccount').val($(this).data("id"));
            //$('#plan').val($(this).data("plan"));
            $('#credit_card_percent').val($(this).data("credit_card_percent"));
            $('#free_days').val($(this).data("free_days"));
            $('#comission').val($(this).data("comission"));
            $('#obs').val($(this).data("obs"));
            $('#title').text($(this).data("title"));
            var value = $(this).data("id");
            //alert(value);
            //$('#plan').find('option[value="' + value + '"]').attr("selected", true);
            //$('[name=plan]').val(""+$(this).data("plan")+"");
            $("#plan").select2().select2('val',''+$(this).data("plan")+'');
            $("#plan_model").select2().select2('val',''+$(this).data("plan_model")+'');
            var plan_model = $(this).data("plan_model");
            var plan = $(this).data("plan");
            $('#free_days_div').hide();
            $("#plan_div").hide();
            //alert(plan_model);
            if(plan_model==1){
                $('#free_days_div').hide();
                $("#plan_div").hide();
                $("#comission_div").show();
            }
            if(plan_model==2){
                $('#free_days_div').show();
                $("#plan_div").show();
                $("#comission_div").hide();
            }

      
           
        });

        $('.errorSafe2Pay').click(function(event) {
            
            $('#errorSafe').text($(this).data("log"));
            //var value = $(this).data("plan");
            //alert(value);
            //$('#plan').find('option[value="' + value + '"]').attr("selected", true);
            //$('[name=plan]').val(""+$(this).data("plan")+"");
            

      
           
        });
        
    });

    $('#plan_model').on('change', function() {
      var data = $("#plan_model option:selected").val();
      if(data==1){
        $('#free_days_div').hide();
        $("#plan_div").hide();
        $("#comission_div").show();
      }else{
        $('#free_days_div').show();
        $("#plan_div").show();
        $("#comission_div").hide();
      }
      
    })

    
    $('#plan').select2({
        dropdownParent: $('#editItemCategory'),
        minimumResultsForSearch: Infinity,
    });

    $('#plan_model').select2({
        dropdownParent: $('#editItemCategory'),
        minimumResultsForSearch: Infinity,
    });

    $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');


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
            

            'order': [[0, 'desc']],
            
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
</script>
@endsection