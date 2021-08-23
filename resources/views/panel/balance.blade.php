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

<style>
    .selling-badge {
    height: 24px;
    padding: 0 8px;
    border-radius: 4px;
    font-size: 12px;
    line-height: 1.6666666667;
    font-weight: 500;
    width: -webkit-max-content;
    width: -moz-max-content;
    width: max-content;
    text-transform: capitalize;
}
.content-center, .layout-button button, .form-control.ih-small, .form-control.ih-medium, .form-control.ih-large, .bookmark__button .btn, .kanban-modal__list button, .kanban-modal__research button, .add-card-btn, .comment-respond button, .knowledgebase-help .card-body button, .knowledgebase-help .card-body, .knowledgebase-adv__collapse .changelog__accordingArrow, .fileM-Modal-overlay .modal-footer button, .testimonial-slider-global .slider-arrow, .banner-feature--15 button, .banner-feature--14 button, .coming-social ul li a, .pricing__badge, .pricing__tag, .application-faqs .button-group button, .order-profile-icon, .orderDatatable_actions li a, .orderDatatable-status span, .order-button-group button, .payment-invoice__btn button, .wizard9 .checkout-progress2 .step span:first-child, .wizard10 .payment-success-modal .modal-icon, .product-cart .actions button, .quantity .bttn, .like-icon, .date-picker__prev, .date-picker__next, .ui-datepicker-header a.ui-corner-all, .timeline-box--3.basic-timeline .timeline > li .timeline-single__buble--svg, .timeline-box--3.basic-timeline .timeline > li .timeline-single__buble, .timeline-box .timeline-single__badge, .media-ui--completed .progress-icon, .icon-list-social__link, .userDatatable-content-status, .users-list__button button, .user-member .action-btn a, .select2-container--default .select2-selection--multiple .select2-selection__choice, .account-profile #remove_pro_pic, .account-profile-cards__button button, .wig-overlay__iconWrapper, .wig-overlay__content, .ffp__icon, .ap-post-attach__btn, .db-social-parent__item a, .user-skils-parent__item a, .ap-nameAddress__subTitle, .selling-badge, .revenue-chart-box__Icon, .custom-checkbox input:indeterminate ~ label::after, .feature-cards figcaption button, .media-badge {
    display: flex;
    align-items: center;
    justify-content: center;
}
div.dataTables_wrapper div.dataTables_info {
    /* padding-top: .85em; */
    /* padding-left: .85em; */
    padding: 20px;
}
div.dataTables_wrapper div.dataTables_paginate {
    margin: 20px;
    white-space: nowrap;
    text-align: right;
}
.atbd-empty {
    padding: 70px;
}
.atbd-empty__text p {
    font-size: 16px;
    line-height: 1.5714285714;
    font-weight: 400;
    margin-bottom: 0;
}

    </style>
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


        </style>
 
 <?php include_once base_path('assets/fileuploader/src/php/class.fileuploader.php');
 $enabled=true; ?>

 <div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        <h4 class="breadcrumb-title">Saldo e Extrato</h4>
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
            <div class="col-xxl-4 col-md-4 col-ssm-12 mb-30">
                <!-- Card 3 -->
                <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1>R$  {{ str_replace(".",",",floatval($totalEarning)) }}</h1>
                         <p>Total a Receber</p>
                         {{-- <div class="ap-po-details-time">
                            <span class="color-danger"><i class="las la-arrow-down"></i>
                            <strong>25%</strong></span>
                            <small>Desde a Última Semana</small>
                         </div> --}}
                      </div>
                   </div>
                   <div class="ap-po-timeChart">
                      <div class="overview-single__chart d-md-flex align-items-end">
                         <div class="parentContainer">
                            <div>
                               <canvas id="mychart10"></canvas>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <!-- Card 3 End -->
             </div>
            <div class="col-xxl-4 col-md-4 col-ssm-12 mb-30">
                <!-- Card 1 -->
                <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1>{{ $ordersCount }}</h1>
                         <p>Pedidos Processados</p>
                         {{-- <div class="ap-po-details-time">
                            <span class="color-success"><i class="las la-arrow-up"></i>
                            <strong>25%</strong></span>
                            <small>Desde a Última Semana</small>
                         </div> --}}
                      </div>
                   </div>
                   <div class="ap-po-timeChart">
                      <div class="overview-single__chart d-md-flex align-items-end">
                         <div class="parentContainer">
                            <div>
                               <canvas id="mychart8"></canvas>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <!-- Card 1 End -->
             </div>
             <div class="col-xxl-4 col-md-4 col-ssm-12 mb-30">
                <!-- Card 2 End  -->
                <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
                   <div>
                      <div class="overview-content">
                         <h1>R$ 0,00</h1>
                         <p>Total Depositado</p>
                         {{-- <div class="ap-po-details-time">
                            <span class="color-success"><i class="las la-arrow-up"></i>
                            <strong>45%</strong></span>
                            <small>Desde a Última Semana</small>
                         </div> --}}
                      </div>
                   </div>
                   <div class="ap-po-timeChart">
                      <div class="overview-single__chart d-md-flex align-items-end">
                         <div class="parentContainer">
                            <div>
                               <canvas id="mychart9"></canvas>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <!-- Card 2 End  -->
             </div>
             
            
            <div class="col-lg-12">
                <h4 class="breadcrumb-title mb-25">Transações</h4>
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
                                            <a class="nav-link {{ Route::is('panel.balance.deposits') ? 'active' : ''}}" href="{{ route('panel.balance.deposits') }}">Todos</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.balance.depositSuccess') ? 'active' : ''}}" href="{{ route('panel.balance.depositSuccess') }}">Realizados</a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.balance.depositPendent') ? 'active' : ''}}" href="{{ route('panel.balance.depositPendent') }}" >Pendentes / Futuros
                                                </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div><!-- End: .project-category -->
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            {{-- <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                {{-- <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md">Export</button>
                               
                                <button type="button" class="btn btn-primary" id="addNewFlyer"
                                data-toggle="modal" data-target="#addNewFlyerModal">
                                <b><i class="icon-plus2"></i></b>
                                Adicionar Produto</button>
                            </div> --}}
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->
                    <div class="tab-content" id="ap-tabContent">
                        <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                            
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0"  id="itemsDataTable" >
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23e">
                                                        <label for="check-23e">
                                                                    <span class="checkbox-text ml-3">
                                                                        Data
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th >
                                            <span class="userDatatable-title">ID do Pedido</span>
                                        </th>
                                        <th >
                                            <span class="userDatatable-title">Total</span>
                                        </th>
                                        <th >
                                            <span class="userDatatable-title">Tarifa Pagamento</span>
                                        </th>
                                        <th >
                                            <span class="userDatatable-title">Comissão</span>
                                        </th>
                                        <th >
                                            <span class="userDatatable-title">Valor Líquido</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                      
                                        <th>
                                            <span class="userDatatable-title ">Ações</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($orders as $item)
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
                                                        {{ date('d/m/Y', strtotime($item->created_at)) }}
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                            </td>
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    
                                                <span >{{$item->order_id}}</span> 
                                            
                                                </div>
                                            </td>
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    
                                                <span >R$ {{str_replace(".",",",$item->Amount)}}</span> 
                                            
                                                </div>
                                            </td>
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    
                                                <span >R$ {{number_format((($item->Amount)*(($item->credit_card_percent))/100),2,",",".") }}</span> 
                                            
                                                </div>
                                            </td>
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    @if($item->plan_model==1)   
                                                        <span >R$ {{number_format((($item->Amount)*(($item->comission))/100),2,",",".") }}</span> 
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    @if($item->plan_model==1)
                                                        <span >R$ {{ number_format((($item->Amount)-($item->Amount)*(($item->comission))/100-($item->Amount)*(($item->credit_card_percent))/100),2,",",".") }}</span> 
                                                    @endif
                                                    @if($item->plan_model==2)
                                                        <span >R$ {{ number_format((($item->Amount)-($item->Amount)*(($item->credit_card_percent))/100),2,",",".") }}</span> 
                                                    @endif
                                                </div>
                                            </td>
                                             
                                             
                                           
                                            <td>
                                               
                                                
                                                                                                   
                                                @if(($item->IsTransferred ==1))
                                               <div class="orderDatatable-status d-inline-block">
                                                   <span class="order-bg-opacity-success  text-success rounded-pill active">Depositado</span>
                                               </div>
                                                @endif
                                                @if(($item->IsTransferred ==0))
                                                <div class="orderDatatable-status d-inline-block">
                                                    <span class="order-bg-opacity-danger  text-danger rounded-pill active">A Depositar</span>
                                                </div>
                                                 @endif

                                               
                                           </td>
                                           
                                            
                                            <td class="text-center">

                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                       
                                                    
                                                {{--     <li>
                                                        <a href="{{ route('panel.balance.details', $item->id) }}" title="Ver Detalhes" class="view">
                                                            <span data-feather="eye"></span></a>
                                                    </li> --}}
                                                   
                                                  
                                                </ul>

                                                
                                               
                                               
                                                
                                            </td>
                                        </tr>
                                        
                
                     
                
                                        
                                        @endforeach 
                                    </tbody>
                                </table>
                                {{-- <div class="mt-3">
                                    {{ $items->links() }}
                                </div> --}}
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






<div class="modal fade" id="cropImagePop" tabindex="-1" data-focus-on="input:first">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="" id="">
            Editar Imagem</h4>
      </div>
      <div class="modal-body">
<div class="cropp">
      <div id="upload-demo" class="center-block"></div>
        </div>
    </div>
       <div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="button" id="cropImageBtn" class="btn btn-primary">Cortar Imagem</button>
</div>
      </div>
    </div>
  </div>








@endsection
@section('scripts')


<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>

<script>


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




  
</script>
@endsection


