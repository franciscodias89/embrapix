
 @extends('layouts.app')
 @section('styles')

 <style>
.select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
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
.buttons-excel {
  float: right;
}
.buttons-csv {
  float: left;
  margin-right: 10px;
}
#but {
float:right;
}

</style>

@endsection

@section("title") Orders - Dashboard
@endsection
@section('content')

<style>
    .pulse {
        display: inline-block;
        width: 12.5px;
        height: 12.5px;
        border-radius: 50%;
        animation: pulse 1.2s infinite;
        vertical-align: middle;
        margin: -3px 5px 0 0;
    }
    .pulse-warning {
        background: #ffc107;
    }
    .pulse-danger {
        background: #ff5722;
    }
    @keyframes pulse {
        0% {
        box-shadow: 0 0 0 0 rgba(255,87,34, 0.5);
        }
        50% {
        box-shadow: 0 0 0 26px rgba(255,87,34, 0);
        }
        100% {
        box-shadow: 0 0 0 0 rgba(255,87,34, 0);
        }
    }
    .linked-item {
        color: #4e535a;
    }
    .linked-item:hover {
        color: #8360c3;
        text-decoration: underline;
        opacity: 1;
    }

    .badge {
    display: inline-block;
    padding: .3125rem .375rem;
    
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 8px;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.order-badge {
    min-width: 120px;
    border-radius: 8px;
}
.border-grey-800 {
    border-color: #b9b9b9;
}

.badge-color-2, .badge-color-3, .badge-color-4, .badge-color-7 {
    color: #fff;
    background-color: #00BCD4;
}
.badge-color-1 {
    color: #fff;
    background-color: #8360c3;
}
.badge-color-5 {
    color: #fff;
    background-color: #66ce66;
}
.badge-color-6, .badge-color-9 {
    color: #fff;
    background-color: #ff7043;
}

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
               @if($restaurant->is_active ==0 && $restaurant->is_accepted ==1)
               <br>
               <div class="alert-icon-big alert alert-danger " role="alert">
                  <div class="alert-icon">
                      <span data-feather="alert-triangle"></span>
                  </div>
                  <div class="alert-content">
                      <h6 class='alert-heading'>Atenção! Sua Loja está FECHADA</h6>
                      <p><strong>Clique no botão acima para abrir sua loja, e receber pedidos.</strong></p>
                      
                      @if($restaurant->business_type ==1) 
                      <p>Atenção! Só faça isso se sua loja realmente estiver aberta e pronta para receber pedidos. Os pedidos que não forem aceitos dentro de 8 minutos serão cancelados automaticamente!</p>
                      @else
                      <p>Atenção! Só faça isso se sua loja realmente estiver aberta e pronta para receber pedidos. Os pedidos que não forem aceitos dentro de 60 minutos serão cancelados automaticamente!</p>
                      @endif
                      
                     
                  </div>
              </div>
            @endif
            </div>
         </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Pedidos</h4>
                            {{-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> --}}
                        </div>
                        {{-- <form action="/" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                            <span data-feather="search"></span>
                            <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                   placeholder="Search by Name" aria-label="Search">
                        </form> --}}
                    </div>
                    <div class="action-btn" id='but'>

                    </div>
 {{--                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#new-member">
                            <i class="las la-plus fs-16"></i>Add New Member</a>
                        <!-- Modal -->
                        <div class="modal fade new-member" id="new-member" role="dialog" tabindex="-1"
                             aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content  radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Create project</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span data-feather="x"></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="new-member-modal">
                                            <form>
                                                <div class="form-group mb-20">
                                                    <input type="text" class="form-control"
                                                           placeholder="Duran Clayton">
                                                </div>
                                                <div class="form-group mb-20">
                                                    <div class="category-member">
                                                        <select
                                                            class="js-example-basic-single js-states form-control"
                                                            id="category-member">
                                                            <option value="JAN">1</option>
                                                            <option value="FBR">2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-20">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                                              rows="3" placeholder="Project description"></textarea>
                                                </div>
                                                <div class="form-group textarea-group">
                                                    <label class="mb-15">status</label>
                                                    <div class="d-flex">
                                                        <div
                                                            class="project-task-list__left d-flex align-items-center">
                                                            <div class="checkbox-group d-flex mr-50 pr-10">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-1" checked>
                                                                    <label for="check-grp-1"
                                                                           class="fs-14 color-light strikethrough">
                                                                        status
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox-group d-flex mr-50 pr-10">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-2">
                                                                    <label for="check-grp-2"
                                                                           class="fs-14 color-light strikethrough">
                                                                        Deactivated
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox-group d-flex">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-3">
                                                                    <label for="check-grp-3"
                                                                           class="fs-14 color-light strikethrough">
                                                                        bloked
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-25">
                                                    <div class="form-group mb-10">
                                                        <label for="name47">project member</label>
                                                        <input type="text" class="form-control" id="name47"
                                                               placeholder="Search members">
                                                    </div>
                                                    <ul class="d-flex flex-wrap mb-20 user-group-people__parent">
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm1.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm2.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm3.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm4.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm5.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="d-flex new-member-calendar">
                                                    <div class="form-group w-100 mr-sm-15 form-group-calender">
                                                        <label for="datepicker">start Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="datepicker"
                                                                   placeholder="mm/dd/yyyy">
                                                            <a href="#">
                                                                <span data-feather="calendar"></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group w-100 form-group-calender">
                                                        <label for="datepicker2">End Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="datepicker2"
                                                                   placeholder="mm/dd/yyyy">
                                                            <a href="#">
                                                                <span data-feather="calendar"></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-group d-flex pt-25">
                                                    <button
                                                        class="btn btn-primary btn-default btn-squared text-capitalize">
                                                        add new project
                                                    </button>
                                                    <button
                                                        class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">
                                                        cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                    <div class="table-responsive">
                        @if(count($orders))
                        <table class="table mb-0 table-borderless" id="ordersDataTable">
                            <thead>
                                <th class="hidden">ID</th>
                            <tr class="userDatatable-header">
                                <th>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-checkbox  check-all">
                                            <input class="checkbox" type="checkbox" id="check-3">
                                            <label for="check-3">
                                                <span class="checkbox-text userDatatable-title">Código do Pedido</span>
                                            </label>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Código do Pedido</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Status</span>
                                </th>
                               
                                <th>
                                    <span class="userDatatable-title">Total</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Pedido Feito em:</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Tempo Decorrido</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title float-right">Ações</span>
                                </th>
                             
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        @else
                        <div class="atbd-empty text-center">
                            <div class="atbd-empty__image">
                                <img src="https://demo.jsnorm.com/laravel/strikingdash/img/folders/1.svg" alt="Admin Empty">
                            </div>
                            <div class="atbd-empty__text">
                                <p class="">Você ainda não tem Nenhum Pedido</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- <div class="d-flex justify-content-end pt-30">
                        <nav class="atbd-page ">
                            <ul class="atbd-pagination d-flex">
                                <li class="atbd-pagination__item">
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="la la-angle-left"></span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">1</span></a>
                                    <a href="#" class="atbd-pagination__link active"><span
                                            class="page-number">2</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">3</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="page-number">...</span></a>
                                    <a href="#" class="atbd-pagination__link"><span
                                            class="page-number">12</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="la la-angle-right"></span></a>
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
                </div>
            </div>
        </div>
    </div>
</div>




{{-- <script src="{{ asset('vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> --}}
@endsection
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
                
    $(function () {
        
        $('body').tooltip({selector: '[data-popup="tooltip"]'});
        
         var datatable = $('#ordersDataTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],  
            order: [[ 0, "desc" ]],
            ajax: '{{ route('restaurant.ordersDataTable') }}',  
            columns: [
                {data: 'id', visible: false, searchable: false},
                {data: 'unique_order_id'},
                {data: 'orderstatus_id', name: "orderstatus.name"},
                //{data: 'payment_mode'},
                {data: 'total'},
                {data: 'created_at'},
                {data: 'live_timer', searchable: false, orderable: false},
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
                $('select').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });
                timer = setInterval(updateClock, 1000);

                var newDate = new Date();
                console.log(newDate)
                var newStamp = newDate.getTime();

                var timer; 

                function updateClock() {

                    $('.liveTimer').each(function(index, el) {
                        var orderCreatedData = $(this).attr("title");
                        var startDateTime = new Date(orderCreatedData); 
                        var startStamp = startDateTime.getTime();
                    

                        newDate = new Date();
                        newStamp = newDate.getTime();
                        var diff = Math.round((newStamp-startStamp)/1000);
                        
                        var d = Math.floor(diff/(24*60*60));
                        diff = diff-(d*24*60*60);
                        var h = Math.floor(diff/(60*60));
                        diff = diff-(h*60*60);
                        var m = Math.floor(diff/(60));
                        diff = diff-(m*60);
                        var s = diff;
                        var checkDay = d > 0 ? true : false;
                        var checkHour = h > 0 ? true : false;
                        var checkMin = m > 0 ? true : false;
                        var checkSec = s > 0 ? true : false;
                        if(d > 1){
                    var formattedTime = checkDay ? d+ " dias" : "";
                }else{
                    var formattedTime = checkDay ? d+ " dia" : "";
                }
                if(h > 1){
                    formattedTime += checkHour ? " " +h+ " horas" : "";
                }else{
                    formattedTime += checkHour ? " " +h+ " hora" : "";
                }
                if(m > 1){
                    formattedTime += checkMin ? " " +m+ " min" : "";
                }else{
                formattedTime += checkMin ? " " +m+ " min" : "";
                }
                if(s > 1){
                    formattedTime += checkSec ? " " +s+ " seg" : "";
                }else{
                    formattedTime += checkSec ? " " +s+ " seg" : "";
                }

                        $(this).text(formattedTime);
                    });
                }
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
                       {extend: 'csv',  filename: 'orders-'+ new Date().toISOString().slice(0,10), text: 'CSV'},
                       {extend: 'excel', filename: 'orders-'+ new Date().toISOString().slice(0,10), text: 'Excel'},
                       
                   ]
               }
        });
        datatable.buttons().container().appendTo($('#but'));

         $('#clearFilterAndState').click(function(event) {
            if (datatable) {
                datatable.state.clear();
                window.location.reload();
            }
         });
    
        });
 

    
</script>

@endsection

{{-- @extends('admin.layouts.master') 
@extends('layouts.vertical',['isDarkSidebar' => false],['isCondensedSidebar' => false])

@section("title") {{__('storeDashboard.opTitle')}}
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{__('storeDashboard.total')}}</span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ $count }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <form action="{{ route('restaurant.post.searchOrders') }}" method="GET">
        <div class="form-group form-group-feedback form-group-feedback-right search-box">
            <input type="text" class="form-control form-control-lg search-input"
                placeholder="{{__('storeDashboard.opSearchPh')}}" name="query">
            <div class="form-control-feedback form-control-feedback-lg">
                <i class="icon-search4"></i>
            </div>
        </div>
        @csrf
    </form>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('storeDashboard.opTableOrderId')}}</th>
                            <th>{{__('storeDashboard.opTableRestName')}}</th>
                            <th>{{__('storeDashboard.opTableStatus')}}</th>
                            <th>{{__('storeDashboard.opPaymentMode')}}</th>
                            <th>{{__('storeDashboard.opTableTotal')}}</th>
                            <th>{{__('storeDashboard.opTableCoupon')}}</th>
                            <th>{{__('storeDashboard.opTableOrderPlacedAt')}}</th>
                            <th class="text-center" style="width: 10%;"><i class="
                                icon-circle-down2"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td><span style="font-size: 0.7rem; font-weight: 700;">{{ $order->unique_order_id }}</span></td>
                            <td>{{ $order->restaurant->name }}</td>
                            <td>
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left">
                                    @if ($order->orderstatus_id == 1) {{__('storeDashboard.opOrderStatus1')}} @endif
                                    @if ($order->orderstatus_id == 2) {{__('storeDashboard.opOrderStatus2')}} @endif
                                    @if ($order->orderstatus_id == 3) {{__('storeDashboard.opOrderStatus3')}} @endif
                                    @if ($order->orderstatus_id == 4) {{__('storeDashboard.opOrderStatus4')}} @endif
                                    @if ($order->orderstatus_id == 5) {{__('storeDashboard.opOrderStatus5')}} @endif
                                    @if ($order->orderstatus_id == 6) {{__('storeDashboard.opOrderStatus6')}} @endif
                                    @if ($order->orderstatus_id == 7) {{__('storeDashboard.opOrderStatus7')}} @endif

                                    @if($order->accept_delivery !== null)
                                    @if($order->orderstatus_id > 2 && $order->orderstatus_id  < 6)
                                    {{__('storeDashboard.opDeliveryBy')}}: <b>{{ $order->accept_delivery->user->name }}</b>
                                    @endif
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                {{ $order->payment_mode }}
                                </span>
                            </td>
                            @php
                               if(!is_null($order->tip_amount)) {
                                   $total = $order->total - $order->tip_amount;
                               } else {
                                   $total = $order->total;
                               }
                             @endphp
                            <td>{{ config('settings.currencyFormat') }} {{ $total }}</td>
                            <td>
                                @if($order->coupon_name == NULL) {{__('storeDashboard.opNone')}} @else
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                {{ $order->coupon_name }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <span  data-popup="tooltip" data-placement="bottom" title="{{ $order->created_at->format('Y-m-d  - h:i A') }}">
                                {{ $order->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('restaurant.viewOrder', $order->unique_order_id) }}"
                                    class="badge badge-primary badge-icon"> {{__('storeDashboard.opView')}} <i
                                    class="icon-file-eye ml-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}