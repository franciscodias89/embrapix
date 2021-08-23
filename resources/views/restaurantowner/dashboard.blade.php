@extends('layouts.app')
@section('styles')
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
.img-thumbnail {
    padding: 0.25rem;
   
     border: 0px solid #ffffff;
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

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
      OneSignal.init({
        appId: "{{ config('settings.oneSignalAppId') }}",
      });
    });
    let user_id = "{{ Auth::user()->id }}";
    
    OneSignal.push(function() {
      OneSignal.on('subscriptionChange', function(isSubscribed) {
        if (isSubscribed) {
          OneSignal.push(function() {
            OneSignal.setExternalUserId(user_id);
          });
        }
      });
    });
</script>

<div class="contents expanded">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            @if($restaurant->is_accepted ==0)
            <br>
            <div class="alert-icon-big alert alert-info " role="alert">
               <div class="alert-icon">
                   <span data-feather="layers"></span>
               </div>
               <div class="alert-content">
                   <h6 class='alert-heading'>Olá, Seja Bem-Vindo!</h6>
                   <p><strong>Sua Loja ainda não foi publicada no APP!<strong></p>
                   <br>
                   <p>Recebemos o seu pedido de publicação da sua loja e já estamos avaliando. Dentro de até 2 dias úteis, caso não esteja faltando nada com seu cadastro ou com cadastro de produtos, sua loja será publicada e você já poderá começar a vender pelo App Compra Bakana! </p>
                   <br>
                  
               </div>
           </div>
         @endif
         </div>
      </div>
      @if($restaurant->is_active ==0 && $restaurant->is_accepted ==1)
      <div class="row">
         <div class="col-lg-12">
            
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
        
         </div>
      </div>
      @endif
      <div class="row">
         <div class="col-lg-12">
            
           
            <div class="breadcrumb-main">
               <h4 class="text-capitalize breadcrumb-title">Dashboard</h4>
               
               

               
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
                  {{-- <div class="dropdown action-btn">
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
         <div class="col-xxl-3 col-md-3 col-ssm-12 mb-30">
            <!-- Card 1 -->
            <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
               <div>
                  <div class="overview-content">
                     <h1 style="color:#FD4B53">{{ $ordersCount }}</h1>
                     <p>Pedidos Processados</p>
                     {{-- <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i>
                        <strong>25%</strong></span>
                        <small>Desde a Última Semana</small>
                     </div> --}}
                  </div>
               </div>
              {{--  <div class="ap-po-timeChart">
                  <div class="overview-single__chart d-md-flex align-items-end">
                     <div class="parentContainer">
                        <div>
                           <canvas id="mychart8"></canvas>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
            <!-- Card 1 End -->
         </div>
         <div class="col-xxl-3 col-md-3 col-ssm-12 mb-30">
            <!-- Card 2 End  -->
            <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
               <div>
                  <div class="overview-content">
                     <h1 style="color:#FD4B53">{{ $orderItemsCount }}</h1>
                     <p>Produtos Vendidos</p>
                     {{-- <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i>
                        <strong>45%</strong></span>
                        <small>Desde a Última Semana</small>
                     </div> --}}
                  </div>
               </div>
               {{-- <div class="ap-po-timeChart">
                  <div class="overview-single__chart d-md-flex align-items-end">
                     <div class="parentContainer">
                        <div>
                           <canvas id="mychart9"></canvas>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
            <!-- Card 2 End  -->
         </div>
         <div class="col-xxl-3 col-md-3 col-ssm-12 mb-30">
            <!-- Card 3 -->
            <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
               <div>
                  <div class="overview-content">
                     <h1 style="color:#FD4B53">R$  {{ $totalEarning }}</h1>
                     <p>Total em Vendas</p>
                     {{-- <div class="ap-po-details-time">
                        <span class="color-danger"><i class="las la-arrow-down"></i>
                        <strong>25%</strong></span>
                        <small>Desde a Última Semana</small>
                     </div> --}}
                  </div>
               </div>
               {{-- <div class="ap-po-timeChart">
                  <div class="overview-single__chart d-md-flex align-items-end">
                     <div class="parentContainer">
                        <div>
                           <canvas id="mychart10"></canvas>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
            <!-- Card 3 End -->
         </div>
         <div class="col-xxl-3 col-md-3 col-ssm-12 mb-30">
            <!-- Card 1 -->
            <div class="ap-po-details p-25 radius-xl bg-white d-flex justify-content-between">
               <div>
                  <div class="overview-content">
                     <h1 style="color:#FD4B53">{{ $allItems }}</h1>
                     <p>Produtos Cadastrados</p>
                     {{-- <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i>
                        <strong>35%</strong></span>
                        <small>Since last week</small>
                     </div> --}}
                  </div>
               </div>
               {{-- <div class="ap-po-timeChart">
                  <div class="overview-single__chart d-md-flex align-items-end">
                     <div class="parentContainer">
                        <div>
                           <canvas id="mychart11"></canvas>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
            <!-- Card 1 End -->
         </div>
         <div class="col-xl-6 col-lg-6 mb-30">
          


            <div class="card broder-0">
               <div class="card-header">
                  <h6>Total de Vendas</h6>
                  <div class="card-extra">
                     <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                        <li>
                           <a href="#tl_revenue-week" data-toggle="tab" id="tl_revenue-week-tab" role="tab" aria-selected="false">Semanal</a>
                        </li>
                        <li>
                           <a href="#tl_revenue-month" data-toggle="tab" id="tl_revenue-month-tab" role="tab" aria-selected="false">Mensal</a>
                        </li>
                        <li>
                           <a class="active"  href="#tl_revenue-year" data-toggle="tab" id="tl_revenue-year-tab" role="tab" aria-selected="true">Anual</a>
                        </li>
                     </ul>
                     <div class="dropdown dropleft">
                        <a href="#" role="button" id="revenue1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span data-feather="more-horizontal"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="revenue1">
                           <a class="dropdown-item" href="#">Action</a>
                           <a class="dropdown-item" href="#">Another action</a>
                           <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- ends: .card-header -->
               <div class="card-body pt-0">
                  <div class="tab-content">
                     <div class="tab-pane fade" id="tl_revenue-week" role="tabpanel" aria-labelledby="tl_revenue-week-tab">
                        <div class="revenue-labels">
                           <div>
                              <strong class="text-primary" >R$ {{ $totalEarning }} </strong>
                              <span>Período Atual</span>
                           </div>
                           <div>
                              <strong>R$ 0,00</strong>
                              <span>Período Anterior</span>
                           </div>
                        </div>
                        <!-- ends: .performance-stats -->
                        <div class="wp-chart">
                           <div class="parentContainer">
                              <div>
                                 <canvas id="myChart6W"></canvas>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="tl_revenue-month" role="tabpanel" aria-labelledby="tl_revenue-month-tab">
                        <div class="revenue-labels">
                            <div>
                                <strong class="text-primary">R$ {{ $totalEarning }} </strong>
                                <span>Período Atual</span>
                             </div>
                             <div>
                                <strong>R$  0,00</strong>
                                <span>Período Anterior</span>
                             </div>
                        </div>
                        <!-- ends: .performance-stats -->
                        <div class="wp-chart">
                           <div class="parentContainer">
                              <div>
                                 <canvas id="myChart6M"></canvas>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade active show" id="tl_revenue-year" role="tabpanel" aria-labelledby="tl_revenue-year-tab">
                        <div class="revenue-labels">
                            <div>
                                <strong class="text-primary">R$ {{ $totalEarning }} </strong>
                                <span>Período Atual</span>
                             </div>
                             <div>
                                <strong>R$  0,00</strong>
                                <span>Período Anterior</span>
                             </div>
                        </div>
                        <!-- ends: .performance-stats -->
                        <div class="wp-chart">
                           <div class="parentContainer">
                              <div>
                                 <canvas id="myChart6"></canvas>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- ends: .card-body -->
            </div>
         </div>
         <div class="col-xl-6 col-lg-6 mb-30">
            <div class="card border-0">
              
               <div class="card-body p-0">
                  <a  target="_blank" href="https://play.google.com/store/apps/details?id=com.lojistacomprabakana"><img src="https://app.comprabakana.com.br/assets/img/ParceiroBakana.png" class="media-object  img-responsive img-thumbnail"></a>
                </div>
            </div>
         </div>
         {{-- <div class="col-xl-6 col-lg-6 mb-30">
            <div class="card border-0">
               <div class="card-header">
                  <h6>Pedidos</h6>
                  <div class="card-extra">
                     <ul class="card-tab-links mr-3 nav-tabs nav">
                        <li>
                           <a href="#s_revenue-today" class="active" data-toggle="tab" id="s_revenue-today-tab" role="tab" area-controls="s_revenue-table" aria-selected="true">Novos</a>
                        </li>
                        <li>
                           <a href="#s_revenue-preparando" data-toggle="tab" id="s_revenue-preparando-tab" role="tab" area-controls="s_revenue-table" aria-selected="false">Preparando</a>
                        </li>
                        <li>
                           <a href="#s_revenue-month" data-toggle="tab" id="s_revenue-month-tab" role="tab" area-controls="s_revenue-table" aria-selected="false">Saiu para Entrega</a>
                        </li>
                        <li>
                           <a href="#s_revenue-year" data-toggle="tab" id="s_revenue-year-tab" role="tab" area-controls="s_revenue-table" aria-selected="false">Entregue</a>
                        </li>
                     </ul>
                     <div class="dropdown dropleft">
                        <a href="#" role="button" id="action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span data-feather="more-horizontal"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="action">
                           <a class="dropdown-item" href="#">Action</a>
                           <a class="dropdown-item" href="#">Another action</a>
                           <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-body p-0">
                  <div class="tab-content">
                    <div class="tab-pane fade active show" id="s_revenue-today" role="tabpanel" aria-labelledby="s_revenue-today-tab">
                        
                        <div class="table-responsive">
                            @if(count($newOrders))
                           <table class="table table--default" id="novospedidos">
                            <thead>
                                <tr>
                                    <th>Código do pedido</th>
                                    {{-- <th class="text-center"><i class="
                                        icon-circle-down2"></i></th> --}}
                                    {{-- <th>{{__('storeDashboard.dashboardStore')}}</th> 
                                    <th>Tipo</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newOrders as $nO)
                                <tr>
                                    <td>
                                        <a href="{{ route('panel.viewOrder', $nO->unique_order_id) }}"
                                            class="letter-icon-title">{{ $nO->unique_order_id }}</a>
                                    </td>
                                    <td>
                                        @if($nO->delivery_type == 2)
                                        <div class="d-flex justify-content-end">
                                            <span class="selling-badge order-bg-opacity-primary color-primary">Retirada</span>
                                         </div>
                                        @endif 
                                        @if($nO->delivery_type == 1)
                                        <div class="d-flex justify-content-end">
                                            <span class="selling-badge order-bg-opacity-info color-info">Delivery</span>
                                         </div>
                                        @endif 
                                    </td>
                                   {{--  <td class="text-center new-order-actions">
                                        <a href="{{ route('restaurant.acceptOrder', $nO->id) }}"
                                            class="btn btn-primary btn-labeled btn-labeled-left mr-2 accpetOrderBtnTableList"> <b><i
                                            class="icon-checkmark3 ml-1"></i> </b> {{__('storeDashboard.dashboardAcceptOrder')}} </a>
                                        <a href="{{ route('restaurant.cancelOrder', $nO->id) }}"
                                            class="btn btn-danger btn-labeled btn-labeled-right mr-2 cancelOrderBtnTableList" data-popup="tooltip"
                                            data-placement="right" title="{{ __('storeDashboard.dashboardDoubleClickMsg') }}"> <b><i
                                            class="icon-cross ml-1"></i></b> {{__('storeDashboard.dashboardCancelOrder')}} </a>
                                    </td> --}}
                                    {{-- <td>
                                        {{ $nO->restaurant->name }}
                                    </td> 
                                     @php
                                        if(!is_null($nO->tip_amount)) {
                                            $nOTotal = $nO->total - $nO->tip_amount;
                                        } else {
                                            $nOTotal = $nO->total;
                                        }
                                    @endphp
                                    <td>
                                        <span class="text-semibold no-margin">{{ config('settings.currencyFormat') }}
                                        {{ number_format($nOTotal, 2, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                        <span class="selling-badge order-bg-opacity-success color-success">
                                        Novo Pedido
                                        </span>
                                    </div>
                                      
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                           @else
                        <div class="atbd-empty text-center">
                            <div class="atbd-empty__image">
                                <img src="https://demo.jsnorm.com/laravel/strikingdash/img/folders/1.svg" alt="Admin Empty">
                            </div>
                            <div class="atbd-empty__text">
                                <p class="">Nenhum Pedido</p>
                            </div>
                        </div>
                        @endif
                        </div>
                        
                    </div>
                    <div class="tab-pane fade fade" id="s_revenue-preparando" role="tabpanel" aria-labelledby="s_revenue-preparando-tab">
                        
                        <div class="table-responsive">
                            @if(count($preparingOrders))
                           <table class="table table--default" id="preparando">
                            <thead>
                                <tr>
                                    <th>Código do pedido</th>
                                    {{-- <th class="text-center"><i class="
                                        icon-circle-down2"></i></th> --}}
                                    {{-- <th>{{__('storeDashboard.dashboardStore')}}</th> 
                                    <th>Tipo</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($preparingOrders as $nO)
                                <tr>
                                    <td>
                                        <a href="{{ route('panel.viewOrder', $nO->unique_order_id) }}"
                                            class="letter-icon-title">{{ $nO->unique_order_id }}</a>
                                    </td>
                                    <td>
                                        @if($nO->delivery_type == 2)
                                        <div class="d-flex justify-content-end">
                                            <span class="selling-badge order-bg-opacity-primary color-primary">Retirada</span>
                                         </div>
                                        @endif 
                                        @if($nO->delivery_type == 1)
                                        <div class="d-flex justify-content-end">
                                            <span class="selling-badge order-bg-opacity-info color-info">Delivery</span>
                                         </div>
                                        @endif 
                                    </td>
                                   {{--  <td class="text-center new-order-actions">
                                        <a href="{{ route('restaurant.acceptOrder', $nO->id) }}"
                                            class="btn btn-primary btn-labeled btn-labeled-left mr-2 accpetOrderBtnTableList"> <b><i
                                            class="icon-checkmark3 ml-1"></i> </b> {{__('storeDashboard.dashboardAcceptOrder')}} </a>
                                        <a href="{{ route('restaurant.cancelOrder', $nO->id) }}"
                                            class="btn btn-danger btn-labeled btn-labeled-right mr-2 cancelOrderBtnTableList" data-popup="tooltip"
                                            data-placement="right" title="{{ __('storeDashboard.dashboardDoubleClickMsg') }}"> <b><i
                                            class="icon-cross ml-1"></i></b> {{__('storeDashboard.dashboardCancelOrder')}} </a>
                                    </td> --}}
                                    {{-- <td>
                                        {{ $nO->restaurant->name }}
                                    </td> 
                                     @php
                                        if(!is_null($nO->tip_amount)) {
                                            $nOTotal = $nO->total - $nO->tip_amount;
                                        } else {
                                            $nOTotal = $nO->total;
                                        }
                                    @endphp
                                    <td>
                                        <span class="text-semibold no-margin">{{ config('settings.currencyFormat') }}
                                        {{ number_format($nOTotal, 2, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                        <span class="selling-badge order-bg-opacity-primary color-primary">
                                        Preparando
                                        </span>
                                    </div>
                                      
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                           @else
                        <div class="atbd-empty text-center">
                            <div class="atbd-empty__image">
                                <img src="https://demo.jsnorm.com/laravel/strikingdash/img/folders/1.svg" alt="Admin Empty">
                            </div>
                            <div class="atbd-empty__text">
                                <p class="">Nenhum Pedido</p>
                            </div>
                        </div>
                        @endif
                        </div>
                        
                    </div>
  
                  </div>
               </div>
            </div>
         </div> --}}
         
         {{-- 
         <div class="col-xxl-4 col-lg-6 mb-30">
            <div class="card border-0">
               <div class="card-header">
                  <h6>Top Selling Products</h6>
                  <div class="card-extra">
                     <ul class="card-tab-links mr-3 nav-tabs nav" role="tablist">
                        <li>
                           <a class="active" href="#t_selling-today" data-toggle="tab" id="t_selling-today-tab" role="tab" aria-selected="true">Today</a>
                        </li>
                        <li>
                           <a href="#t_selling-week" data-toggle="tab" id="t_selling-week-tab" role="tab" aria-selected="true">Week</a>
                        </li>
                        <li>
                           <a href="#t_selling-month" data-toggle="tab" id="t_selling-month-tab" role="tab" aria-selected="true">Month</a>
                        </li>
                        <li>
                           <a href="#t_selling-year" data-toggle="tab" id="t_selling-year-tab" role="tab" aria-selected="true">Year</a>
                        </li>
                     </ul>
                     <div class="dropdown dropleft">
                        <a href="#" role="button" id="todo12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span data-feather="more-horizontal"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="todo12">
                           <a class="dropdown-item" href="#">Action</a>
                           <a class="dropdown-item" href="#">Another action</a>
                           <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-body p-0">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="t_selling-today" role="tabpanel" aria-labelledby="t_selling-today-tab">
                        <div class="selling-table-wrap">
                           <div class="table-responsive">
                              <table class="table table--default">
                                 <thead>
                                    <tr>
                                       <th>Prduct Name</th>
                                       <th>Price</th>
                                       <th>Sold</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>Samsung Galaxy S8 256GB</td>
                                       <td>$289</td>
                                       <td>339</td>
                                       <td>$60,258</td>
                                    </tr>
                                    <tr>
                                       <td>Half Sleeve Shirt</td>
                                       <td>$29</td>
                                       <td>136</td>
                                       <td>$2,483</td>
                                    </tr>
                                    <tr>
                                       <td>Marco Shoes</td>
                                       <td>$59</td>
                                       <td>448</td>
                                       <td>$19,758</td>
                                    </tr>
                                    <tr>
                                       <td>15" Mackbook Pro</td>
                                       <td>$1,299</td>
                                       <td>159</td>
                                       <td>$197,458</td>
                                    </tr>
                                    <tr>
                                       <td>Apple iPhone X</td>
                                       <td>$899</td>
                                       <td>146</td>
                                       <td>115,254</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="t_selling-week" role="tabpanel" aria-labelledby="t_selling-week-tab">
                        <div class="selling-table-wrap">
                           <div class="table-responsive">
                              <table class="table table--default">
                                 <thead>
                                    <tr>
                                       <th>Prduct Name</th>
                                       <th>Price</th>
                                       <th>Sold</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>Samsung Galaxy S8 256GB</td>
                                       <td>$289</td>
                                       <td>339</td>
                                       <td>$60,258</td>
                                    </tr>
                                    <tr>
                                       <td>Half Sleeve Shirt</td>
                                       <td>$29</td>
                                       <td>136</td>
                                       <td>$2,483</td>
                                    </tr>
                                    <tr>
                                       <td>Marco Shoes</td>
                                       <td>$59</td>
                                       <td>448</td>
                                       <td>$19,758</td>
                                    </tr>
                                    <tr>
                                       <td>15" Mackbook Pro</td>
                                       <td>$1,299</td>
                                       <td>159</td>
                                       <td>$197,458</td>
                                    </tr>
                                    <tr>
                                       <td>Apple iPhone X</td>
                                       <td>$899</td>
                                       <td>146</td>
                                       <td>115,254</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="t_selling-month" role="tabpanel" aria-labelledby="t_selling-month-tab">
                        <div class="selling-table-wrap">
                           <div class="table-responsive">
                              <table class="table table--default">
                                 <thead>
                                    <tr>
                                       <th>Prduct Name</th>
                                       <th>Price</th>
                                       <th>Sold</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>Samsung Galaxy S8 256GB</td>
                                       <td>$289</td>
                                       <td>339</td>
                                       <td>$60,258</td>
                                    </tr>
                                    <tr>
                                       <td>Half Sleeve Shirt</td>
                                       <td>$29</td>
                                       <td>136</td>
                                       <td>$2,483</td>
                                    </tr>
                                    <tr>
                                       <td>Marco Shoes</td>
                                       <td>$59</td>
                                       <td>448</td>
                                       <td>$19,758</td>
                                    </tr>
                                    <tr>
                                       <td>15" Mackbook Pro</td>
                                       <td>$1,299</td>
                                       <td>159</td>
                                       <td>$197,458</td>
                                    </tr>
                                    <tr>
                                       <td>Apple iPhone X</td>
                                       <td>$899</td>
                                       <td>146</td>
                                       <td>115,254</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="t_selling-year" role="tabpanel" aria-labelledby="t_selling-year-tab">
                        <div class="selling-table-wrap">
                           <div class="table-responsive">
                              <table class="table table--default">
                                 <thead>
                                    <tr>
                                       <th>Prduct Name</th>
                                       <th>Price</th>
                                       <th>Sold</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>Samsung Galaxy S8 256GB</td>
                                       <td>$289</td>
                                       <td>339</td>
                                       <td>$60,258</td>
                                    </tr>
                                    <tr>
                                       <td>Half Sleeve Shirt</td>
                                       <td>$29</td>
                                       <td>136</td>
                                       <td>$2,483</td>
                                    </tr>
                                    <tr>
                                       <td>Marco Shoes</td>
                                       <td>$59</td>
                                       <td>448</td>
                                       <td>$19,758</td>
                                    </tr>
                                    <tr>
                                       <td>15" Mackbook Pro</td>
                                       <td>$1,299</td>
                                       <td>159</td>
                                       <td>$197,458</td>
                                    </tr>
                                    <tr>
                                       <td>Apple iPhone X</td>
                                       <td>$899</td>
                                       <td>146</td>
                                       <td>115,254</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xxl-4 col-lg-6 mb-30">
            <div class="card border-0">
               <div class="card-header">
                  <h6>Sales by Location</h6>
                  <div class="card-extra">
                     <ul class="card-tab-links mr-3 nav-tabs nav">
                        <li>
                           <a href="#sb_location-today" class="active" data-toggle="tab" id="sb_location-today-tab" role="tab" area-controls="sb_location-table" aria-selected="true">Today</a>
                        </li>
                        <li>
                           <a href="#sb_location-week" data-toggle="tab" id="sb_location-week-tab" role="tab" area-controls="sb_location-table" aria-selected="false">Week</a>
                        </li>
                        <li>
                           <a href="#sb_location-month" data-toggle="tab" id="sb_location-month-tab" role="tab" area-controls="sb_location-table" aria-selected="false">Month</a>
                        </li>
                        <li>
                           <a href="#sb_location-year" data-toggle="tab" id="sb_location-year-tab" role="tab" area-controls="sb_location-table" aria-selected="false">Year</a>
                        </li>
                     </ul>
                     <div class="dropdown dropleft">
                        <a href="#" role="button" id="somethings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span data-feather="more-horizontal"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="somethings">
                           <a class="dropdown-item" href="#">Action</a>
                           <a class="dropdown-item" href="#">Another action</a>
                           <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="sb_location-today" role="tabpanel" aria-labelledby="sb_location-today-tab">
                        <div class="d-flex align-items-center justify-content-center">
                           <div class="regions-svg">
                              <div id="region-map"></div>
                           </div>
                        </div>
                        <div>
                           <div class="table-responsive table-top-location">
                              <table class="table table--default table-borderless mb-0">
                                 <thead>
                                    <tr>
                                       <th>Top Location</th>
                                       <th>Order</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>United States</td>
                                       <td>457</td>
                                       <td>$26,457</td>
                                    </tr>
                                    <tr>
                                       <td>Australia</td>
                                       <td>658</td>
                                       <td>$44,658</td>
                                    </tr>
                                    <tr>
                                       <td>Canada</td>
                                       <td>698</td>
                                       <td>$101,698</td>
                                    </tr>
                                    <tr>
                                       <td>Japan</td>
                                       <td>856</td>
                                       <td>$2,856</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="sb_location-week" role="tabpanel" aria-labelledby="sb_location-week-tab">
                        <div class="d-flex align-items-center justify-content-center">
                           <div class="regions-svg">
                              <div id="region-map_W"></div>
                           </div>
                        </div>
                        <div>
                           <div class="table-responsive table-top-location">
                              <table class="table table--default table-borderless mb-0">
                                 <thead>
                                    <tr>
                                       <th>Top Location</th>
                                       <th>Order</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>United States</td>
                                       <td>457</td>
                                       <td>$26,457</td>
                                    </tr>
                                    <tr>
                                       <td>Australia</td>
                                       <td>658</td>
                                       <td>$44,658</td>
                                    </tr>
                                    <tr>
                                       <td>Canada</td>
                                       <td>698</td>
                                       <td>$101,698</td>
                                    </tr>
                                    <tr>
                                       <td>Japan</td>
                                       <td>856</td>
                                       <td>$2,856</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="sb_location-month" role="tabpanel" aria-labelledby="sb_location-month-tab">
                        <div class="d-flex align-items-center justify-content-center">
                           <div class="regions-svg">
                              <div id="region-map_M"></div>
                           </div>
                        </div>
                        <div>
                           <div class="table-responsive table-top-location">
                              <table class="table table--default table-borderless mb-0">
                                 <thead>
                                    <tr>
                                       <th>Top Location</th>
                                       <th>Order</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>United States</td>
                                       <td>457</td>
                                       <td>$26,457</td>
                                    </tr>
                                    <tr>
                                       <td>Australia</td>
                                       <td>658</td>
                                       <td>$44,658</td>
                                    </tr>
                                    <tr>
                                       <td>Canada</td>
                                       <td>698</td>
                                       <td>$101,698</td>
                                    </tr>
                                    <tr>
                                       <td>Japan</td>
                                       <td>856</td>
                                       <td>$2,856</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="sb_location-year" role="tabpanel" aria-labelledby="sb_location-year-tab">
                        <div class="d-flex align-items-center justify-content-center">
                           <div class="regions-svg">
                              <div id="region-map_Y"></div>
                           </div>
                        </div>
                        <div>
                           <div class="table-responsive table-top-location">
                              <table class="table table--default table-borderless mb-0">
                                 <thead>
                                    <tr>
                                       <th>Top Location</th>
                                       <th>Order</th>
                                       <th>Revenue</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>United States</td>
                                       <td>457</td>
                                       <td>$26,457</td>
                                    </tr>
                                    <tr>
                                       <td>Australia</td>
                                       <td>658</td>
                                       <td>$44,658</td>
                                    </tr>
                                    <tr>
                                       <td>Canada</td>
                                       <td>698</td>
                                       <td>$101,698</td>
                                    </tr>
                                    <tr>
                                       <td>Japan</td>
                                       <td>856</td>
                                       <td>$2,856</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xxl-4 col-lg-6 mb-30">
            <div class="revenue-device-chart">
               <div class="card broder-0">
                  <div class="card-header">
                     <h6>Revenue By Device</h6>
                     <div class="card-extra">
                        <ul class="card-tab-links nav-tabs nav" role="tablist">
                           <li>
                              <a class="active" href="#rb_device-today" data-toggle="tab" id="rb_device-today-tab" role="tab" aria-selected="true">Today</a>
                           </li>
                           <li>
                              <a href="#rb_device-week" data-toggle="tab" id="rb_device-week-tab" role="tab" aria-selected="false">Week</a>
                           </li>
                           <li>
                              <a href="#rb_device-month" data-toggle="tab" id="rb_device-month-tab" role="tab" aria-selected="false">Month</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!-- ends: .card-header -->
                  <div class="card-body">
                     <div class="tab-content">
                        <div class="tab-pane fade active show" id="rb_device-today" role="tabpanel" aria-labelledby="rb_device-today-tab">
                           <div class="revenue-pieChart-wrap">
                              <div>
                                 <canvas id="chartDoughnut3"></canvas>
                              </div>
                           </div>
                           <div class="revenue-chart-legend-list">
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-success"></span>
                                    <span>Desktop</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$83</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>45%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-info"></span>
                                    <span>Mobile</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$70</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>30%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-warning"></span>
                                    <span>Tablets</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$20</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>25%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                           </div>
                        </div>
                        <div class="tab-pane fade" id="rb_device-week" role="tabpanel" aria-labelledby="rb_device-week-tab">
                           <div class="revenue-pieChart-wrap">
                              <div>
                                 <canvas id="chartDoughnut3W"></canvas>
                              </div>
                           </div>
                           <div class="revenue-chart-legend-list">
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-success"></span>
                                    <span>Desktop</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$483</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>45%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-info"></span>
                                    <span>Mobile</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$870</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>30%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-warning"></span>
                                    <span>Tablets</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$420</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>25%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                           </div>
                        </div>
                        <div class="tab-pane fade" id="rb_device-month" role="tabpanel" aria-labelledby="rb_device-month-tab">
                           <div class="revenue-pieChart-wrap">
                              <div>
                                 <canvas id="chartDoughnut3M"></canvas>
                              </div>
                           </div>
                           <div class="revenue-chart-legend-list">
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-success"></span>
                                    <span>Desktop</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$5,870</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>45%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-info"></span>
                                    <span>Mobile</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$4,483</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>30%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                              <div class="revenue-chart-legend d-flex justify-content-between">
                                 <div class="revenue-chart-legend__label">
                                    <span class="label-dot dot-warning"></span>
                                    <span>Tablets</span>
                                 </div>
                                 <div class="revenue-chart-legend__data">
                                    <span>$2,420</span>
                                 </div>
                                 <div class="revenue-chart-legend__percentage">
                                    <span>25%</span>
                                 </div>
                              </div>
                              <!-- ends: .revenue-chart-legend -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- ends: .card-body -->
               </div>
            </div>
         </div> --}}
      </div>
      <!-- ends: .row -->
   </div>
</div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script>




    $('#novospedidos').DataTable(
        {
            bLengthChange : false,
            searching: false,
            pageLength : 5,
            bInfo: false,
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

    $('#preparando').DataTable(
        {
            bLengthChange : false,
            searching: false,
            pageLength : 5,
            bInfo: false,
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
{{-- 
<script>
   $(function() {
       var touchtime = 0;
       
       let notification = document.createElement('audio');
       let notificationFileRoute = 'https://app.comprabakana.com.br/assets/backend/tones/{{ config('settings.restaurantNotificationAudioTrack') }}.mp3';
          notification.setAttribute('src', notificationFileRoute);
          notification.setAttribute('type', 'audio/mp3');
          // notification.setAttribute('muted', 'muted');
          notification.setAttribute('loop', 'true');
       
       $(".stopSound").click(function(event) {
           notification.pause();
           notification.currentTime = 0;
       });
       
       
          



     
       const newOrderJson = @json($newOrders);
       console.log(newOrderJson);
   
       setInterval(function() {
           $.ajax({
               url: '{{ route('restaurant.getNewOrders') }}',
               type: 'POST',
               dataType: 'json',
               data: {listed_order_ids: @json($newOrdersIds), _token: $('.csrfToken').val()},
           })
   
           .done(function(newArray) {
               console.log("New Array", newArray)
               console.log(newOrderJson.length);
               console.log(newArray.length );
   
               if (newArray.length > 0) {
                   //if new orders, then lenght will be greater, if order cancelled, then it should not go inside this 
                   console.log("NEW ORDER")
               
                   $('#newOrderModal').modal({
                       backdrop: 'static',
                       keyboard: false
                   });
   
                   //play sound
                   notification.play();
   
                   console.log("New Array", newArray)
                   // const newOrder = newArray[0];
   
                   let newOrderData = "";
                   $.map(newArray, function(order, index) {
                       if(order.delivery_type == 2) {
                           var selfPickup = '<span class="badge badge-flat border-danger-800 text-default text-capitalize ml-1">{{__('storeDashboard.dashboardSelfPickup')}}</span>'
                       } else {
                           selfPickup = "";
                       }
   
                       let viewOrderURL = "{{ url('/store-owner/order') }}/" + order.unique_order_id;
                       
                       console.log(order);

                       if (order.tip_amount != null) {
                           var orderTotal = parseFloat(order.total) - parseFloat(order.tip_amount); 
                       } else {
                            var orderTotal = order.total;
                       }
                       newOrderData +='<div class="popup-order mb-3"><div class="text-center my-3 h5"><strong><span class="text-semibold no-margin">{{ config('settings.currencyFormat') }}'+orderTotal+'</span> <i class="icon-arrow-right5"></i> <a href="'+viewOrderURL+'">'+order.unique_order_id+'</a> <i class="icon-arrow-right5"></i>'+order.restaurant.name+'</strong> '+ selfPickup +'</div>';
   
                       newOrderData += '<div class="d-flex justify-content-center"><button data-id="'+order.id+'" class="btn btn-primary btn-labeled btn-labeled-left mr-2 acceptOrderBtn"><b><i class="icon-checkmark3 ml-1"></i></b> {{__('storeDashboard.dashboardAcceptOrder')}} </a> <button data-id="'+order.id+'" class="btn btn-danger btn-labeled btn-labeled-right mr-2 cancelOrderBtnPopup" data-popup="tooltip" data-placement="top" title="{{__('storeDashboard.dashboardDoubleClickMsg')}}"> <b><i class="icon-cross ml-1"></i></b> {{__('storeDashboard.dashboardCancelOrder')}}  </a></div></div>'
                       
   
                       $('#newOrdersData').html(newOrderData);
                       $('#newOrdersNoOrdersMessage').remove();
                   });
                   
               } else {
                   console.log("NO New Order")
                   //when orde has been accepted or denied, length will be 0, close the model
                   $('#newOrderModal').modal('hide');
               }
           })
           .fail(function() {
               console.log("error");
           })  
       }, {{ config("settings.restaurantNewOrderRefreshRate") }} * 1000); //all API every x seconds (config settings from admin)
       
       //reload page when popup closed
       $('#newOrderModal').on('hidden.bs.modal', function () {
           window.location.reload();
       })
   
   
       //on single click, accpet order and disable block
       $('body').on("click", ".acceptOrderBtn", function(e) {
           
           let context = $(this).parents('.popup-order');
           context.addClass('popup-order-processing').prepend('<div class="d-flex pt-2 pr-2 float-right"><i class="icon-spinner10 spinner"></i></div>')
           console.log("HERE", context);
   
           let id = $(this).attr("data-id");
           let acceptOrderUrl = "{{ url('/store-owner/orders/accept-order') }}/" +id;
           $.ajax({
               url: acceptOrderUrl,
               type: 'GET',
               dataType: 'JSON',
           })
           .done(function(data) {
               $(context).remove();
               //count number of order on popup, if 0 then remove popup
               if ($('.popup-order').length == 0) {
                   $('#newOrderModal').modal('hide');
               }
               $.jGrowl("{{__('storeDashboard.orderAcceptedNotification')}}", {
                   position: 'bottom-center',
                   header: '{{__('storeDashboard.successNotification')}}',
                   theme: 'bg-success',
                   life: '5000'
               });
           })
           .fail(function() {
               console.log("error")
               $.jGrowl("{{__('storeDashboard.orderSomethingWentWrongNotification')}}", {
                   position: 'bottom-center',
                   header: '{{__('storeDashboard.woopssNotification')}}',
                   theme: 'bg-warning',
                   life: '5000'
               });
           })
       });
       
       $('body').on("click", ".accpetOrderBtnTableList", function(e) {
           $(this).parents('.new-order-actions').addClass('popup-order-processing');
       });
   
       //on Single click donot cancel order table list
       $('body').on("click", ".cancelOrderBtnTableList", function(e) {
           return false;
       });
   
       $('body').on("click", ".cancelOrderBtnTableList", function(e) {
           e.preventDefault()
           if (((new Date().getTime()) - touchtime) < 500) {
               $(this).parents('.new-order-actions').addClass('popup-order-processing');
               window.location = this.href;
               return false;
           }
           touchtime = new Date().getTime();
       });
   
       //on Single click donot cancel order popup
       $('body').on("click", ".cancelOrderBtnPopup", function(e) {
           return false;
       });
       
       $('.actionAfterAccept').click(function(event) {
         $(this).parents('.accepted-order-actions').addClass('popup-order-processing');
       });
       
   
       $('body').on("click", ".cancelOrderBtnPopup", function(e) {
           e.preventDefault()
   
           if (((new Date().getTime()) - touchtime) < 500) {
   
               let context = $(this).parents('.popup-order');
               context.addClass('popup-order-processing').prepend('<div class="d-flex pt-2 pr-2 float-right"><i class="icon-spinner10 spinner"></i></div>')
               console.log("HERE", context);
               
               let id = $(this).attr("data-id");
               let cancelOrderURL = "{{ url('/store-owner/orders/cancel-order') }}/" +id;
               $.ajax({
                   url: cancelOrderURL,
                   type: 'GET',
                   dataType: 'JSON',
               })
               .done(function(data) {
                   $(context).remove();
                   //count number of order on popup, if 0 then remove popup
                   if ($('.popup-order').length == 0) {
                       $('#newOrderModal').modal('hide');
                   }
                   $.jGrowl("{{__('storeDashboard.orderCanceledNotification')}}", {
                       position: 'bottom-center',
                       header: '{{__('storeDashboard.successNotification')}}',
                       theme: 'bg-success',
                       life: '5000'
                   });
               })
               .fail(function() {
                   console.log("error");
                   $.jGrowl("{{__('storeDashboard.orderSomethingWentWrongNotification')}}", {
                       position: 'bottom-center',
                       header: '{{__('storeDashboard.woopssNotification')}}',
                       theme: 'bg-warning',
                       life: '5000'
                   });
               })
           }
           touchtime = new Date().getTime();
       });
   });
</script> --}}

<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>
@endsection
