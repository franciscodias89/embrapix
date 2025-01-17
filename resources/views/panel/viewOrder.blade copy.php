@extends('layouts.app')
@section('styles')
<style>
   .ap-product .table thead tr th:first-child {
    width: 15%;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgb(228 235 239);
}
table body {
    margin: 0;
    font-family: "Inter", sans-serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.5;
    color: #666d92;
    text-align: left;
    background-color: #fff;
}
   </style>
@endsection
@section('content')
<div class="contents">
   <div class="container-fluid">
      <div class="profile-content mb-50">
         <div class="row">
            <div class="col-lg-12">
               <div class="breadcrumb-main">
                  <h4 class="text-capitalize breadcrumb-title">Pedido: {{ $order->unique_order_id }}</h4>
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
                     </div>
                     <div class="dropdown action-btn">
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

                     <div class="text-right">
                        <a href="{{ route('restaurant.orders') }}"
                            class="btn btn-default btn-white " data-popup="tooltip"
                            title="" data-placement="bottom">
                        <b><i class="la la-arrow-left"></i></b>
                        Voltar
                        </a>
                       
                    </div>

                    @csrf
                <div class="text-right" style="margin-left:20px">
                    <button type="submit"  class="btn btn-primary">
                    Imprimir
                        <i class="icon-database-insert ml-1"></i></button>
                </div>
                  </div> 
               </div>
            </div>
            <div class="cos-lg-3 col-md-3  ">
               <aside class="profile-sider">
                  <!-- Profile Acoount -->
                  <div class="card mb-25">
                     <div class="card-body text-center pt-sm-30 pb-sm-0  px-25 pb-0">
                        <div class="account-profile">
                         {{--   <div class="ap-img w-100 d-flex justify-content-center">
                              <!-- Profile picture image-->
                              <img class="ap-img__main rounded-circle mb-3  wh-120 d-flex bg-opacity-primary" src="{{ $order->user->avatar }}" alt="profile">
                           </div> --}}
                           <div class="ap-nameAddress pb-3 pt-1">
                              <h5 class="ap-nameAddress__title">{{ $order->user->name }}</h5>
                              <p class="ap-nameAddress__subTitle fs-14 m-0"> <strong>Data: &nbsp;</strong> {{ $order->created_at->format('d-m-Y')}}</p>
                              <p class="ap-nameAddress__subTitle fs-14 m-0">
                                 <span ></span><strong>Horário: &nbsp;</strong> {{ $order->created_at->format(' H:i ')}}
                              </p>
                           </div>
                           <div class="" style="display: inline; justify-content: center;">

                             
                             @if($order->orderstatus_id == 1)
                                 <div class="row" style="display: flex; justify-content: center;" >
                                       <a href="{{ route('panel.acceptOrder', $order->id) }}"
                                          class="btn btn-primary btn-default btn-squared text-capitalize  px-25"> Aceitar Pedido
                                       </a>
                                 </div>


                                 <div class="row mt-20" style="display: flex; justify-content: center;" >  

                                    <button type="button" class="btn btn-danger btn-default btn-squared text-capitalize  px-25" id="CancelOrder"
                                    data-toggle="modal" data-target="#CancelOrderModal">
                                    <b><i class="icon-plus2"></i></b>
                                    Cancelar Pedido</button>

                                       
                                 </div>
                            @endif
                            @if($order->delivery_type == 2 && $order->orderstatus_id == 2)
                            <div class="row" style="display: flex; justify-content: center;" >
                            <a href="{{ route('panel.markOrderReady', $order->id) }}"
                                class="btn btn-warning"> Marcar como: Pronto Para Retirada <i
                                class="icon-checkmark3 ml-1"></i></a></div>
                            @endif 
                            @if($order->delivery_type == 2 && $order->orderstatus_id == 7)
                              <div class="row" style="display: flex; justify-content: center;" >
                                 <a href="{{ route('panel.markSelfPickupOrderAsCompleted', $order->id) }}"
                                class="btn btn-success"> Marcar como Entregue <i
                                class="icon-checkmark3 ml-1"></i></a>
                              </div>
                            @endif 

                            @if($order->delivery_type != 2 && $order->orderstatus_id == 2)
                            <div class="row" style="display: flex; justify-content: center;" >
                            <a href="{{ route('panel.markOrderAsOnway', $order->id) }}"
                                class="btn btn-warning"> Marcar como: Saiu para Entrega <i
                                class="icon-checkmark3 ml-1"></i></a>
                              </div>
                            @endif 
                            @if($order->delivery_type != 2 && $order->orderstatus_id == 4)
                              <div class="row" style="display: flex; justify-content: center;" >
                                 <a href="{{ route('panel.markOrderAsDelivered', $order->id) }}"
                                class="btn btn-success"> Marcar como Entregue <i
                                class="icon-checkmark3 ml-1"></i></a>
                              
                              </div>
                            @endif



  
                           </div>
                        </div>
                        <div class="card-footer mt-20 pt-20 pb-20 px-0">
                           <div class="profile-overview d-flex justify-content-between flex-wrap">
                              <div class="po-details">
                                 <h6 class="po-details__title pb-1">0</h6>
                                 <span class="po-details__sTitle">Pedidos no App</span>
                              </div>
                              <div class="po-details">
                                 <h6 class="po-details__title pb-1">0</h6>
                                 <span class="po-details__sTitle">Pedidos na loja</span>
                              </div>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Profile Acoount End -->
                  <!-- Profile User Bio -->
                  <div class="card mb-25">
                     {{-- <div class="user-bio border-bottom">
                        <div class="card-header border-bottom-0 pt-sm-30 pb-sm-0  px-md-25 px-3">
                           <div class="profile-header-title">
                              User Bio
                           </div>
                        </div>
                        <div class="card-body pt-md-1 pt-0">
                           <div class="user-bio__content">
                              <p class="m-0">Nam malesuada dolor tellus pretium amet was hendrerit facilisi id
                                 vitae enim
                                 sed ornare
                                 there suspendisse sed orci neque ac sed aliquet risus faucibus in pretium
                                 molestie nisl
                                 tempor quis odio habitant.
                              </p>
                           </div>
                        </div>
                     </div> --}}
                     <div class="user-info border-bottom">
                        <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                           <div class="profile-header-title">
                              Dados do Cliente
                           </div>
                        </div>
                        <div class="card-body pt-md-1 pt-0">
                           <div class="user-content-info">
                            <p class="user-content-info__item">
                                <span data-feather="user"></span>{{ $order->user->name }}
                             </p>
                              <p class="user-content-info__item">
                                 <span data-feather="mail"></span>{{ $order->user->email }}
                              </p>
                              <p class="user-content-info__item">
                                 <span data-feather="phone"></span>{{ $order->user->phone }}
                                
                              </p>
                             
                              @if($order->delivery_type == 1)
                                         
                                            <p class="user-content-info__item">
                                                <span data-feather="map-pin"></span>{{ $order->address }}
                                               
                                             </p>
                                   
                                       
                                        @endif
                           </div>
                        </div>
                     </div>

                     @if($order->order_comment != NULL)
                      <div class="user-bio border-bottom">
                        <div class="card-header border-bottom-0 pt-sm-30 pb-sm-0  px-md-25 px-3">
                           <div class="profile-header-title">
                             Comentários do Cliente
                           </div>
                        </div>
                        <div class="card-body pt-md-1 pt-0">
                           <div class="user-bio__content">
                              <p class="m-0">{{ $order->order_comment }}
                              </p>
                           </div>
                        </div>
                     </div> 
                     @endif
                     {{-- <div class="user-skils border-bottom">
                        <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                           <div class="profile-header-title">
                              Skills
                           </div>
                        </div>
                        <div class="card-body pt-md-1 pt-0">
                           <ul class="user-skils-parent">
                              <li class="user-skils-parent__item">
                                 <a href="#">UI/UX</a>
                              </li>
                              <li class="user-skils-parent__item">
                                 <a href="#">Branding</a>
                              </li>
                              <li class="user-skils-parent__item">
                                 <a href="#">product design</a>
                              </li>
                              <li class="user-skils-parent__item">
                                 <a href="#">Application</a>
                              </li>
                              <li class="user-skils-parent__item mb-0">
                                 <a href="#">web design</a>
                              </li>
                           </ul>
                        </div>
                     </div> --}}
                    {{--  <div class="db-social border-bottom">
                        <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                           <div class="profile-header-title">
                              Social Profiles
                           </div>
                        </div>
                        <div class="card-body pt-md-1 pt-0">
                           <ul class="db-social-parent mb-0">
                              <li class="db-social-parent__item">
                                 <a class="color-facebook hover-facebook wh-44 fs-22" href="#">
                                 <i class="lab la-facebook-f"></i>
                                 </a>
                              </li>
                              <li class="db-social-parent__item">
                                 <a class="color-twitter hover-twitter wh-44 fs-22" href="#">
                                 <i class="lab la-twitter"></i>
                                 </a>
                              </li>
                              <li class="db-social-parent__item">
                                 <a class="color-ruby hover-ruby  wh-44 fs-22" href="#">
                                 <i class="las la-basketball-ball"></i>
                                 </a>
                              </li>
                              <li class="db-social-parent__item">
                                 <a class="color-instagram hover-instagram wh-44 fs-22" href="#">
                                 <i class="lab la-instagram"></i>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div> --}}
                  </div>
                  <!-- Profile User Bio End -->
               </aside>
            </div>
            <div class="col">
               <!-- Tab Menu -->
             {{--   <div class="ap-tab ap-tab-header">
                  <div class="ap-tab-header__img">
                     <img src="{{ asset('img/ap-header.png') }}" alt="ap-header" class="img-fluid w-100">
                  </div>
                  <div class="ap-tab-wrapper">
                     <ul class="nav px-25 ap-tab-main" id="ap-tab" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" id="ap-overview-tab" data-toggle="pill" href="#ap-overview" role="tab" aria-controls="ap-overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="timeline-tab" data-toggle="pill" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Timeline</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity</a>
                        </li>
                     </ul>
                  </div>
               </div> --}}
               <!-- Tab Menu End -->
               <div class="tab-content " id="ap-tabContent">
                  <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                     <div class="ap-content-wrapper">
                        <div class="row col-lg-12">
                           <div class="col-lg-4 col-md-3 mb-25">
                              <!-- Card 1 -->
                              <div class="ap-po-details radius-xl bg-white d-flex justify-content-between">
                                 <div>
                                    <div class="overview-content">
                                        <p>Status do Pedido</p>
                                        <h3>

                                        <div class="py-1 text-success text-capitalize @if ($order->orderstatus_id == 6) text-danger @endif" style="font-weight: 500;">
                                            @if ($order->orderstatus_id == 1) NOVO PEDIDO @endif
                                            @if ($order->orderstatus_id == 2) EM PREPARAÇÃO @endif
                                            @if ($order->orderstatus_id == 3) SAIU PARA ENTREGA @endif
                                            @if ($order->orderstatus_id == 4) SAIU PARA ENTREGA @endif
                                            @if ($order->orderstatus_id == 5) PEDIDO ENTREGUE @endif
                                            @if ($order->orderstatus_id == 6) CANCELADO @endif
                                            @if ($order->orderstatus_id == 7) {{__('storeDashboard.opOrderStatus7')}} @endif
                                        </div>

                                       </h3>
                                       
                                       <div class="ap-po-details-time">
                                         {{--  <span class="color-success"><i class="las la-arrow-up"></i>
                                          <strong>25%</strong></span>
                                          <small>Since last week</small> --}}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="ap-po-timeChart">
                                    <div class="overview-single__chart d-md-flex align-items-end">
                                       <div class="parentContainer">
                                          <div>
                                            {{-- <img class="ap-img__main rounded-circle mb-3  wh-120 d-flex bg-opacity-primary"  style="width:100px" src="https://app.comprabakana.com.br/assets/img/sucess.png" alt="profile">
                                             <i class="la la-check-circle"></i>--}}
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Card 1 End -->
                           </div>
                           <div class="col-lg-4 col-md-4 mb-25">
                              <!-- Card 2 End  -->
                              <div class="ap-po-details radius-xl bg-white d-flex justify-content-between">
                                 <div>
                                    <div class="overview-content">
                                        <p>Tipo de Entrega</p>
                                        <h3>
                                            <div class="py-1 text-warning" style="font-weight: 500;">
                                                @if($order->delivery_type == 1)
                                                    DELIVERY
                                                @else
                                                    RETIRADA
                                                @endif
                                            </div>



                                        </h3>
                                       
                                       <div class="ap-po-details-time">
                                          {{--<span class="color-success"><i class="las la-arrow-up"></i>
                                           <strong>25%</strong></span>
                                          <small>Since last week</small> --}}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="ap-po-timeChart">
                                    <div class="overview-single__chart d-md-flex align-items-end">
                                       <div class="parentContainer">
                                          <div>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Card 2 End  -->
                           </div>
                           <div class="col-lg-4  col-md-4 mb-25">
                              <!-- Card 3 -->
                              <div class="ap-po-details radius-xl bg-white d-flex justify-content-between">
                                 <div>
                                    <div class="overview-content">
                                        <p>Forma de Pagamento</p>
                                        <h2>

                                            <div class="py-1 text-warning" style="font-weight: 500;">
                                                @if ($order->payment_mode == 'COD')
                                                      @if($order->payment_type =='selfpickup')
                                                      Pagar na Retirada (Dinheiro)
                                                      @endif
                                                      @if($order->payment_type =='delivery')
                                                      Pagar na Entrega (Dinheiro)
                                                      @endif
                                                @endif
                                                @if ($order->payment_mode == 'CREDITCARD')
                                                   @if($order->payment_type =='selfpickup')
                                                   Pagar na Retirada (Cartão de Crédito)
                                                   @endif
                                                   @if($order->payment_type =='delivery')
                                                   Pagar na Entrega (Cartão de Crédito)
                                                   @endif
                                                @endif
                                                @if ($order->payment_mode == 'DEBITCARD')
                                                      @if($order->payment_type =='selfpickup')
                                                      Pagar na Retirada (Cartão de Débito)
                                                      @endif
                                                      @if($order->payment_type =='delivery')
                                                      Pagar na Entrega (Cartão de Débito)
                                                      @endif
                                                @endif
                                                @if ($order->payment_mode == 'PIX')
                                                      @if($order->payment_type =='selfpickup')
                                                      Pagar na Retirada (PIX)
                                                      @endif
                                                      @if($order->payment_type =='delivery')
                                                      Pagar na Entrega (PIX)
                                                      @endif
                                                @endif
                                            </div>
                                        </h2>
                                       
                                       <div class="ap-po-details-time">
                                          {{-- <span class="color-danger"><i class="las la-arrow-down"></i>
                                          <strong>25%</strong></span>
                                          <small>Since last week</small> --}}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="ap-po-timeChart">
                                    <div class="overview-single__chart d-md-flex align-items-end">
                                       <div class="parentContainer">
                                          <div>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Card 3 End -->
                           </div>
                           {{-- <div class="col-lg-12">
                              <!-- Statistics Charts -->
                              <div class="card">
                                 <div class="card-header text-capitalize px-md-25 px-3">
                                    <h6>General Statistics</h6>
                                    <div class="dropdown">
                                       <a href="#" role="button" id="statistics1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <span data-feather="more-horizontal"></span>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="statistics1">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-body">
                                    <div class="ap-statistics-charts">
                                       <div class="parentContainer">
                                          <div>
                                             <canvas id="profile-chart"></canvas>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Statistics Charts End -->
                           </div> --}}

                           @php
                        $subTotal = 0;
                        function calculateAddonTotal($addons) {
                            $total = 0;
                            foreach ($addons as $addon) {
                                $total += $addon->addon_price;
                            }
                            return $total;
                        }
                        @endphp

                           <div class="col-lg-12">
                              <!-- Product Table -->
                              <div class="card mt-25 mb-40">
                                 <div class="card-header text-capitalize px-md-25 px-3">
                                    <h6>Itens do Pedido</h6>
                                    <div class="dropdown">
                                       <a href="#" role="button" id="products" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <span data-feather="more-horizontal"></span>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="products">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card-body p-0">
                                    <div class="ap-product">
                                       <div class="table-responsive">
                                          <table class="table">
                                             <thead>
                                                <tr>
                                                   <th >Imagem</th>
                                                   <th scope="col">Nome do Item</th>
                                                   <th scope="col">Cód. EAN</th>
                                                   <th scope="col">Quantidade</th>
                                                   <th scope="col">Preço Total</th>
                                                   
                                                </tr>
                                             </thead>
                                             <tbody>
                                               
                                                @foreach($order->orderitems as $item)
                                                <tr>
                                                  
                                                   <td><img src="{{ $item->ean }}" style="width:60px"></td>
                                                  <td>{{ $item->name .' - '.$item->codint }}</td>
                                                  <td>{{ $item->ean }}</td>
                                                 

                                                  @if($item->peso)
                                                  <td>{{ 'R$ ' . number_format($item->peso, 3, ',', '.') }}</td>
                                                  @else
                                                  <td>{{ $item->quantity }}</td>
                                                  @endif
                                                  @php
                                        $itemTotal = ($item->price +calculateAddonTotal($item->order_item_addons)) * $item->quantity;
                                         $subTotal = $subTotal + $itemTotal;
                                        @endphp

                                                  <td>{{ 'R$ ' . number_format($itemTotal, 2, ',', '.') }}</td>
                                                  
                                                </tr>
                                                @endforeach
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>


                              <div class="col-lg-8 float-right">
                                <table class="table table-bordered table-striped bill-calc-table">
    
                                        <tr>
                                            <td class="text-left td-title">{{__('storeDashboard.ovSubTotal')}}</td>
                                            <td class="text-right td-data"> {{ 'R$ ' . number_format($subTotal, 2, ',', '.') }}  </td>
                                        </tr>
    
                                        @if($order->coupon_name != NULL)
                                            <tr>
                                                <td class="text-left td-title">{{__('storeDashboard.ovCoupon')}}</td>
                                                <td class="text-right td-data"> {{ $order->coupon_name }} @if($order->coupon_amount != NULL) ({{ 'R$ ' . number_format($order->coupon_amount, 2, ',', '.') }}) @endif</td>
                                            </tr>
                                        @endif
    
                                        @if($order->restaurant_charge != NULL)
                                        <tr>
                                            <td class="text-left td-title">{{__('storeDashboard.ovStoreCharge')}}</td>
                                            <td class="text-right td-data"> {{ 'R$ ' . number_format($order->restaurant_charge, 2, ',', '.') }} </td>
                                        </tr>
                                        @endif
    
                                        <tr>
                                            <td class="text-left td-title">{{__('storeDashboard.ovDeliveryCharge')}}</td>
                                            <td class="text-right td-data"> {{ 'R$ ' . number_format($order->delivery_charge, 2, ',', '.') }}  </td>
                                        </tr>
    
                                        @if($order->tax != NULL)
                                            <tr>
                                                <td class="text-left td-title">{{__('storeDashboard.ovTax')}}</td>
                                                <td class="text-right td-data">{{ $order->tax }}% @if($order->tax_amount != NULL) ({{ config('settings.currencyFormat') }} {{ $order->tax_amount }}) @endif</td>
                                            </tr>
                                        @endif
    
                                        @if($order->wallet_amount != NULL)
                                            <tr>
                                                <td class="text-left td-title">{{__('storeDashboard.ovPaidWithWallet')}} {{ config('settings.walletName') }}</td>
                                                <td class="text-right td-data"> {{ 'R$ ' . number_format($order->wallet_amount, 2, ',', '.') }}  </td>
                                            </tr>
                                        @endif
    
    
                                        @php
                                           if(!is_null($order->tip_amount)) {
                                               $total = $order->total - $order->tip_amount;
                                           } else {
                                               $total = $order->total;
                                           }
                                       @endphp
                                        <tr>
                                            <td class="text-left td-title"><b>{{ __('storeDashboard.ovTotal') }}</b></td>
                                            <td class="text-right td-data"> {{ 'R$ ' . number_format($total, 2, ',', '.') }}  </td>
                                        </tr>
    
                                         @php
                                            if(!is_null($order->tip_amount)) {
                                                $payable = $order->payable - $order->tip_amount;
                                            } else {
                                                $payable = $order->payable;
                                            }
                                        @endphp
                                        @if($order->payable != NULL)
                                            <tr>
                                                <td class="text-left td-title">{{ __('storeDashboard.ovPayable') }}</td>
                                                <td class="text-right td-data"><b> {{ 'R$ ' . number_format($payable, 2, ',', '.') }} </b></td>
                                            </tr>
                                        @endif
                                </table>
                            </div>



                              <!-- Product Table End -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                     <div class="ap-post-content">
                        <div class="row">
                           <div class="col-xxl-8">
                              <!-- Post Area -->
                              <div class="ap-post-form">
                                 <div class="card border mb-25">
                                    <div class="card-header px-md-25 px-3">
                                       <h6>Post something</h6>
                                    </div>
                                    <div class="card-body p-0 px-25">
                                       <div class="d-flex flex-column">
                                          <div class="border-0  flex-1 position-relative">
                                             <div class="pt-20 outline-0 pb-2 pr-0 pl-0 rounded-0 position-relative border-bottom" tabindex="-1">
                                                <span class="ap-profile-image bg-opacity-secondary rounded-circle d-block position-absolute" style="background-image:url('{{ asset('/img/ap-author.png') }}'); background-size: cover;"></span>
                                                <div class="pl-15 ml-5 pt-10">
                                                   <textarea class="form-control border-0 p-0 fs-xl bg-transparent" rows="3" placeholder="Write something..."></textarea>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="ap-post-attach d-flex flex-row align-items-center flex-wrap flex-shrink-0">
                                             <a href="#" class="btn rounded-pill mr-2">
                                             <img class="svg" src="{{ asset('img/svg/image.svg') }}" alt="img">
                                             Photo/Video
                                             </a>
                                             <a href="#" class="btn rounded-pill ap-post-attach__drop">
                                             <span data-feather="more-horizontal"></span>
                                             </a>
                                             <button class="btn btn-primary btn-default btn-squared ml-auto ap-post-attach__btn">public post
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Post Area End -->
                              <!-- Blog Post -->
                              <div class="ap-main-post">
                                 <div class="card mb-25">
                                    <!-- Blog Style -->
                                    <div class="card-body pb-0 px-25 ap-main-post__header">
                                       <div class="d-flex flex-row pb-20 border-top-0 border-left-0 border-right-0 ap-post-content__title align-items-center ">
                                          <div class="d-inline-block align-middle mr-15">
                                             <span class="profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0" style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                          </div>
                                          <h6 class="mb-0 flex-1 text-dark">
                                             Meyri Carles
                                             <small class="m-0 d-block">
                                             2 minuts ago
                                             </small>
                                          </h6>
                                          <div class="dropdown  dropdown-click ">
                                             <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <span data-feather=more-horizontal></span>
                                             </button>
                                             <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                <a class="dropdown-item" href="#">Item One</a>
                                                <a class="dropdown-item" href="#">Item Two</a>
                                                <a class="dropdown-item" href="#">Item Three</a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="mb-15">
                                          <img src="{{ asset('img/post-image.png') }}" alt="post image" class="ap-post-attach__headImg w-100">
                                       </div>
                                       <div class="pb-3 border-top-0 border-left-0 border-right-0 ap-post-content__p">
                                          Nam malesuada dolor tellus pretium amet was hendrerit facilisi
                                          tempor
                                          quis
                                          enim sed ornare there suspendisse sed orci neque ac sed aliquet
                                          risus
                                          faucibus in pretium molestee.
                                       </div>
                                    </div>
                                    <!-- Blog Style End -->
                                    <!-- Blog Style -->
                                    <div class="card-body border-top border-bottom py-0 ap-main-post__reaction">
                                       <div class="d-flex align-items-center demo-h-spacing ap-post-content__feedback">
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="thumbs-up"></span>274
                                          </a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="message-square"></span>56</a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="share-2"></span> share
                                          </a>
                                       </div>
                                    </div>
                                    <!-- Blog Style End -->
                                    <!-- BLog Style -->
                                    <div class="card-body px-25 py-20 ap-main-post__footer">
                                       <div class="ap-post-content-comment">
                                          <div class="pt-0 outline-0 pb-0 pr-0 pl-0 rounded-0 position-relative d-flex align-items-center" tabindex="-1">
                                             <span class="rounded-circle d-block position-absolute wh-36" style="background-image:url('{{ asset('/img/ap-author.png') }}'); background-size: cover;"></span>
                                             <div class="d-flex justify-content-between align-items-center w-100">
                                                <div class=" flex-1 d-flex align-items-center mr-10 ap-post-content-comment__write">
                                                   <input class="form-control border-0 p-0 bg-transparent pr-sm-0 pr-20" placeholder="This is my comment...">
                                                   <div class="d-flex">
                                                      <a href="#">
                                                      <span data-feather="smile"></span></a>
                                                      <a href="#">
                                                      <span data-feather="image"></span></a>
                                                      <a href="#">
                                                      <span data-feather="paperclip"></span></a>
                                                   </div>
                                                </div>
                                                <button type="button" class="border-0 btn-primary wh-50 p-10 rounded-circle">
                                                <span data-feather="send"></span></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- BLog Style -->
                                 </div>
                                 <!-- Blog Post End -->
                              </div>
                              <!-- Blog Post -->
                              <div class="ap-main-post">
                                 <div class="card mb-25">
                                    <!-- Card body -->
                                    <div class="card-body pb-0 px-25 ap-main-post__header">
                                       <div class="d-flex flex-row pb-20 border-top-0 border-left-0 border-right-0 ap-post-content__title align-items-center ">
                                          <div class="d-inline-block align-middle mr-15">
                                             <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0" style="background-image:url('{{ asset('img/author/2.jpg') }}') }}'); background-size: cover;"></span>
                                          </div>
                                          <h6 class="mb-0 flex-1 text-dark">
                                             Alexendra Dhadio
                                             <small class="m-0 d-block">
                                             2 days ago
                                             </small>
                                          </h6>
                                          <div class="dropdown  dropdown-click ">
                                             <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <span data-feather=more-horizontal></span>
                                             </button>
                                             <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                <a class="dropdown-item" href="#">Item One</a>
                                                <a class="dropdown-item" href="#">Item Two</a>
                                                <a class="dropdown-item" href="#">Item Three</a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="pb-3 border-top-0 border-left-0 border-right-0 ap-post-content__p">
                                          Nam malesuada dolor tellus pretium amet was hendrerit facilisi
                                          tempor
                                          quis
                                          enim sed ornare there suspendisse sed orci neque ac sed aliquet
                                          risus
                                          faucibus in pretium molestee.
                                       </div>
                                    </div>
                                    <!-- Card body -->
                                    <!-- Card body -->
                                    <div class="card-body border-top border-bottom py-0 ap-main-post__reaction">
                                       <div class="d-flex align-items-center demo-h-spacing ap-post-content__feedback">
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="thumbs-up"></span>274
                                          </a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="message-square"></span>56</a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="share-2"></span> share
                                          </a>
                                       </div>
                                    </div>
                                    <!-- Card -->
                                    <!-- Card body -->
                                    <div class="card-body px-25 py-20 ap-main-post__footer">
                                       <div class="ap-post-content-comment">
                                          <div class="pt-0 outline-0 pb-0 pr-0 pl-0 rounded-0 position-relative d-flex align-items-center" tabindex="-1">
                                             <span class="rounded-circle d-block position-absolute wh-36" style="background-image:url('{{ asset('/img/ap-author.png') }}'); background-size: cover;"></span>
                                             <div class="d-flex justify-content-between align-items-center w-100">
                                                <div class=" flex-1 d-flex align-items-center mr-10 ap-post-content-comment__write">
                                                   <input class="form-control border-0 p-0 bg-transparent pr-sm-0 pr-20" placeholder="Type your comment...">
                                                   <div class="d-flex">
                                                      <a href="#">
                                                      <span data-feather="smile"></span></a>
                                                      <a href="#">
                                                      <span data-feather="image"></span></a>
                                                      <a href="#">
                                                      <span data-feather="paperclip"></span></a>
                                                   </div>
                                                </div>
                                                <button type="button" class="border-0 btn-primary wh-50 p-10 rounded-circle">
                                                <span data-feather="send"></span></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- Card body -->
                                 </div>
                                 <!-- Blog Post End -->
                              </div>
                              <!-- Blog Post -->
                              <div class="ap-main-post">
                                 <div class="card mb-25">
                                    <!-- Card body -->
                                    <div class="card-body pb-0 px-25 ap-main-post__header">
                                       <div class="d-flex flex-row pb-3 border-top-0 border-left-0 border-right-0 ap-post-content__title align-items-center ">
                                          <div class="d-inline-block align-middle mr-15">
                                             <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0" style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                          </div>
                                          <h6 class="mb-0 flex-1 text-dark fw-500">
                                             Olivia Jon
                                             <small class="m-0 d-block">
                                             19 January at 21:53
                                             </small>
                                          </h6>
                                          <div class="dropdown  dropdown-click ">
                                             <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <span data-feather=more-horizontal></span>
                                             </button>
                                             <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                <a class="dropdown-item" href="#">Item One</a>
                                                <a class="dropdown-item" href="#">Item Two</a>
                                                <a class="dropdown-item" href="#">Item Three</a>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Post Gallery -->
                                       <div class="mb-3 ap-post-gallery">
                                          <!-- Post Gallery top -->
                                          <div class="ap-post-gallery-top">
                                             <div class="ap-post-gallery__item">
                                                <a href="{{ asset('img/506.png') }}"><img src="{{ asset('img/506.png') }}" alt="gallery" class="w-100 img-fluid"></a>
                                             </div>
                                             <div class="ap-post-gallery__item">
                                                <a href="{{ asset('img/907.png') }}"><img src="{{ asset('img/907.png') }}" alt="gallery" class="w-100 img-fluid"></a>
                                             </div>
                                          </div>
                                          <!-- Post Gallery top -->
                                          <!-- Post-Gallery Bottom -->
                                          <div class="ap-post-gallery-bottom">
                                             <div class="ap-post-gallery__item">
                                                <a href="{{ asset('img/brightland_3744.png') }}"><img src="{{ asset('img/brightland_3744.png') }}" alt="gallery" class="w-100 img-fluid"></a>
                                             </div>
                                             <div class="ap-post-gallery__item">
                                                <a href="{{ asset('img/room.png') }}"><img src="{{ asset('img/room.png') }}" alt="gallery" class="w-100 img-fluid"></a>
                                             </div>
                                             <div class="ap-post-gallery__item">
                                                <a href="{{ asset('img/165.png') }}" class="ap-post-gallery-overlay">
                                                   <img src="{{ asset('img/165.png') }}" alt="gallery" class="w-100 img-fluid">
                                                   <div class="ap-post-gallery-overlay__content">
                                                      <span>26<span class="las la-plus"></span></span>
                                                   </div>
                                                </a>
                                             </div>
                                          </div>
                                          <!-- Post-Gallery Bottom -->
                                       </div>
                                       <!-- Post Gallery -->
                                    </div>
                                    <!-- Card body -->
                                    <!-- Card body -->
                                    <div class="card-body border-top border-bottom py-0 ap-main-post__reaction">
                                       <div class="d-flex align-items-center demo-h-spacing ap-post-content__feedback">
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="thumbs-up"></span>274
                                          </a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="message-square"></span>56</a>
                                          <a href="#" class="d-inline-flex align-items-center">
                                          <span data-feather="share-2"></span> share
                                          </a>
                                       </div>
                                    </div>
                                    <!-- Card body -->
                                    <!-- Card body -->
                                    <div class="card-body px-25 py-20 border-bottom ap-main-post__footer">
                                       <div class="ap-post-content-comment">
                                          <div class="pt-0 outline-0 pb-0 pr-0 pl-0 rounded-0 position-relative d-flex align-items-center" tabindex="-1">
                                             <span class="rounded-circle d-block position-absolute wh-36" style="background-image:url('{{ asset('/img/ap-author.png') }}'); background-size: cover;"></span>
                                             <div class="d-flex justify-content-between align-items-center w-100">
                                                <div class=" flex-1 d-flex align-items-center mr-10 ap-post-content-comment__write">
                                                   <input class="form-control border-0 p-0 bg-transparent pr-sm-0 pr-20" placeholder="Type your comment...">
                                                   <div class="d-flex">
                                                      <a href="#">
                                                      <span data-feather="smile"></span></a>
                                                      <a href="#">
                                                      <span data-feather="image"></span></a>
                                                      <a href="#">
                                                      <span data-feather="paperclip"></span></a>
                                                   </div>
                                                </div>
                                                <button type="button" class="border-0 btn-primary wh-50 p-10 rounded-circle">
                                                <span data-feather="send"></span></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- Card body -->
                                    <!-- Card body Commnet -->
                                    <div class="card-body pt-20 ap-main-post__comment">
                                       <div class="ap-post-cc-reply d-flex flex-column align-items-center">
                                          <div class="d-flex flex-row w-100">
                                             <div class="d-inline-block align-middle status status-sm status-success">
                                                <span class=" profile-image bg-opacity-secondary profile-image-md rounded-circle d-block ml-0 wh-36 mr-10" style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="mb-0 flex-1 text-dark">
                                                <div class="cbg-light rounded-xl py-10 px-10">
                                                   <div class="d-flex ap-post-content__title">
                                                      <a href="#" class="fw-500">
                                                         <h6>Hunter Carter</h6>
                                                      </a>
                                                   </div>
                                                   <p class="mb-0 mt-10 text-gray">
                                                      ullamco laboris nisi ut aliquip ex ea commodo
                                                      consequat.
                                                      Duis aute irure dolor in reprehenderit in voluptate
                                                      velit
                                                      esse cillum dolore eu fugiat nulla pariatur.Congrats
                                                      mate!
                                                   </p>
                                                </div>
                                                <ul class="mb-0 d-flex ap-post-cc-reply__reaction">
                                                   <li class="#">
                                                      <a href="#">Like</a>
                                                   </li>
                                                   <li class="#">
                                                      <a href="#">
                                                      reply
                                                      </a>
                                                   </li>
                                                   <li class="#">
                                                      <span>5 months ago</span>
                                                   </li>
                                                </ul>
                                                <div class="ap-post-cc-reply__reply pl-0 d-flex flex-row w-100 pb-0">
                                                   <div class="d-inline-block align-middle status status-sm status-success">
                                                      <span class=" profile-image bg-opacity-secondary profile-image-md rounded-circle d-block ml-0 wh-36 mr-10" style="background-image:url('{{ asset('img/author/2.jpg') }}'); background-size: cover;"></span>
                                                   </div>
                                                   <div class="mb-0 flex-1 text-dark">
                                                      <div class="cbg-light rounded-xl py-10 px-10">
                                                         <div class="d-flex ap-post-content__title">
                                                            <a href="#" class="fw-500">
                                                               <h6>Dr. John Cook PhD</h6>
                                                            </a>
                                                         </div>
                                                         <p class="mb-0 mt-10 text-gray">
                                                            ullamco laboris nisi ut aliquip ex ea
                                                            commodo
                                                            consequat.
                                                            Duis aute irure dolor in reprehenderit in
                                                            voluptate
                                                            velit esse cillum dolore eu fugiat nulla
                                                            pariatur.
                                                         </p>
                                                      </div>
                                                      <ul class="mb-0 d-flex ap-post-cc-reply__reaction">
                                                         <li class="#">
                                                            <a href="#">Like</a>
                                                         </li>
                                                         <li class="#">
                                                            <a href="#" class="color-primary">
                                                            reply
                                                            </a>
                                                         </li>
                                                         <li class="#">
                                                            <span>5 months ago</span>
                                                         </li>
                                                      </ul>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ap-post-cc-reply d-flex flex-column align-items-center mt-20">
                                          <div class="d-flex flex-row w-100">
                                             <div class="d-inline-block align-middle status status-sm status-success">
                                                <span class=" profile-image bg-opacity-secondary profile-image-md rounded-circle d-block ml-0 wh-36 mr-10" style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="mb-0 flex-1 text-dark">
                                                <div class="cbg-light rounded-xl py-10 px-10">
                                                   <div class="d-flex ap-post-content__title">
                                                      <a href="#" class="fw-500">
                                                         <h6>Dr. Codex Lantern</h6>
                                                      </a>
                                                   </div>
                                                   <p class="mb-0 mt-10 text-gray">
                                                      Nam malesuada dolor tellus pretium amet was
                                                      hendrerit
                                                      facilisi tempor quis eni
                                                   </p>
                                                </div>
                                                <ul class="mb-0 d-flex ap-post-cc-reply__reaction">
                                                   <li class="#">
                                                      <a href="#">Like</a>
                                                   </li>
                                                   <li class="#">
                                                      <a href="#">
                                                      reply
                                                      </a>
                                                   </li>
                                                   <li class="#">
                                                      <span>5 months ago</span>
                                                   </li>
                                                </ul>
                                                <div class="ap-post-cc-reply__reply pl-0 d-flex flex-row w-100 pb-0">
                                                   <!-- Card body -->
                                                   <div class="card-body p-0">
                                                      <div class="ap-post-content-comment">
                                                         <div class="pt-0 outline-0 pb-0 pr-0 pl-0 rounded-0 position-relative d-flex align-items-center" tabindex="-1">
                                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                               <div class=" flex-1 d-flex align-items-center mr-10 ap-post-content-comment__write ml-0">
                                                                  <input class="form-control border-0 p-0 bg-transparent pr-sm-0 pr-20" placeholder="Type your comment...">
                                                                  <div class="d-flex">
                                                                     <a href="#">
                                                                     <span data-feather="smile"></span></a>
                                                                     <a href="#">
                                                                     <span data-feather="image"></span></a>
                                                                     <a href="#">
                                                                     <span data-feather="paperclip"></span></a>
                                                                  </div>
                                                               </div>
                                                               <button type="button" class="border-0 btn-primary wh-50 p-10 rounded-circle">
                                                               <span data-feather="send"></span></button>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!-- Card body -->
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <a class="view-more-comment color-primary fs-13 fw-500" href="#">View 53
                                       more
                                       comments</a>
                                    </div>
                                    <!-- Card body Commnet -->
                                    <!-- Card -->
                                 </div>
                                 <!-- Blog Post End -->
                              </div>
                           </div>
                           <div class="col-xxl-4">
                              <!-- Friend Widgets -->
                              <div class="card global-shadow mb-25">
                                 <div class="friends-widget">
                                    <div class="card-header px-md-25 px-3">
                                       <h6>Friends</h6>
                                    </div>
                                    <div class="card-body p-0">
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Meyri Carles</h6>
                                                </a>
                                                <span class="d-block">
                                                UI Designer
                                                </span>
                                             </div>
                                          </div>
                                          <div>
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow">follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Shreyu Neu</h6>
                                                </a>
                                                <span class="d-block">
                                                Product Designer
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Domnic Harris</h6>
                                                </a>
                                                <span class="d-block">
                                                Executive Assistant
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/2.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Khalid Hasan</h6>
                                                </a>
                                                <span class="d-block">
                                                UI director
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/3.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Tuhin Molla</h6>
                                                </a>
                                                <span class="d-block">
                                                System Administrator
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <a class="view-more-comment color-primary fs-13 fw-500 px-25 pb-20" href="#">Load more friends</a>
                                    </div>
                                 </div>
                              </div>
                              <!-- Friend Widgets End -->
                              <!-- Gallery Image -->
                              <div class="card global-shadow mb-25">
                                 <div class="photo-gallery-widget">
                                    <div class="card-header justify-content-between d-flex flex-wrap px-md-25 px-3">
                                       <h6>photos</h6>
                                       <a class="color-primary fs-13 fw-500 mt-lg-0 mt-1" href="#">see all</a>
                                    </div>
                                    <div class="card-body">
                                       <div class="wig">
                                          <div class="wig__item">
                                             <img src="{{ asset('img/315.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/325.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/design.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/99.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/166.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/287.png') }}" alt="gallery">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Gallery Image End -->
                              <!-- Gallery Video Popup -->
                              <div class="card global-shadow mb-25">
                                 <div class="video-gallery-widget">
                                    <div class="card-header justify-content-between d-flex flex-wrap px-md-25 px-3">
                                       <h6>videos</h6>
                                       <a class="color-primary fs-13 fw-500 mt-lg-0 mt-1" href="#">see all</a>
                                    </div>
                                    <div class="card-body">
                                       <div class="wig">
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/juice-2.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/cup-card.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/round-box.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/glass.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/bottles.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/325.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper" href="#">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Gallery Video Popup End -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                     <div class="ap-post-content">
                        <div class="row">
                           <div class="col-xxl-8">
                              <!-- Friend post -->
                              <div class="card global-shadow mb-25">
                                 <div class="friends-widget">
                                    <div class="card-header px-md-25 px-3">
                                       <h6>Friends</h6>
                                    </div>
                                    <div class="card-body p-0 py-10">
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-primary bg-opacity-primary">
                                                <span data-feather="inbox"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">James</span> sent you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-secondary bg-opacity-secondary">
                                                <span data-feather="upload"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Adam </span>upload
                                                      website template for sale
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-success bg-opacity-success">
                                                <span data-feather="log-in"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Mumtahin </span>has
                                                      registered
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-info bg-opacity-info">
                                                <span data-feather="at-sign"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/2.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">James </span>Send you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex align">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-danger bg-opacity-danger">
                                                <span data-feather="heart"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/3.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Adam </span>upload
                                                      website template for sale
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-warning bg-opacity-warning">
                                                <span data-feather="message-square"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">James</span> sent you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-secondary bg-opacity-secondary">
                                                <span data-feather="upload"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0" style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Shreyu Neu</span> sent
                                                      you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-success bg-opacity-success">
                                                <span data-feather="log-in"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Mumtahin </span>has
                                                      registered
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-info bg-opacity-info">
                                                <span data-feather="at-sign"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/2.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">James </span>Send you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex align">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-danger bg-opacity-danger">
                                                <span data-feather="heart"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/3.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Adam </span>upload
                                                      website template for sale
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-warning bg-opacity-warning">
                                                <span data-feather="message-square"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0 " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">James</span> sent you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="ffp d-flex ffp--hover justify-content-between  align-items-center w-100">
                                          <div class="d-flex">
                                             <div class="mr-3 ffp__imgWrapper d-flex align-items-center">
                                                <span class="ffp__icon color-secondary bg-opacity-secondary">
                                                <span data-feather="upload"></span></span>
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block avatar avatar-md m-0" style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffp__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>
                                                      <span class="color-primary">Shreyu Neu</span> sent
                                                      you a
                                                      message
                                                   </h6>
                                                </a>
                                                <p class="d-block">
                                                   5 hours ago
                                                </p>
                                             </div>
                                          </div>
                                          <div class="ffp__button">
                                             <div class="dropdown  dropdown-click ">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather=more-horizontal></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu">
                                                   <a class="dropdown-item" href="#">Item One</a>
                                                   <a class="dropdown-item" href="#">Item Two</a>
                                                   <a class="dropdown-item" href="#">Item Three</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Friend Post End -->
                           </div>
                           <div class="col-xxl-4">
                              <!-- Friend Widgets -->
                              <div class="card global-shadow mb-25">
                                 <div class="friends-widget">
                                    <div class="card-header px-md-25 px-3">
                                       <h6>Friends</h6>
                                    </div>
                                    <div class="card-body p-0">
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Meyri Carles</h6>
                                                </a>
                                                <span class="d-block">
                                                UI Designer
                                                </span>
                                             </div>
                                          </div>
                                          <div>
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow">follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/1.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Shreyu Neu</h6>
                                                </a>
                                                <span class="d-block">
                                                Product Designer
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/4.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Domnic Harris</h6>
                                                </a>
                                                <span class="d-block">
                                                Executive Assistant
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/2.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Khalid Hasan</h6>
                                                </a>
                                                <span class="d-block">
                                                UI director
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <div class="ffw d-flex justify-content-between">
                                          <div class="d-flex flex-wrap">
                                             <div class="mr-3 ffw__imgWrapper">
                                                <span class=" profile-image bg-opacity-secondary rounded-circle d-block ap-profile-image " style="background-image:url('{{ asset('img/author/3.jpg') }}'); background-size: cover;"></span>
                                             </div>
                                             <div class="ffw__title">
                                                <a href="#" class="text-dark fw-500">
                                                   <h6>Tuhin Molla</h6>
                                                </a>
                                                <span class="d-block">
                                                System Administrator
                                                </span>
                                             </div>
                                          </div>
                                          <div class="ffw__button">
                                             <button class="btn btn-default btn-squared btn-outline-light friends-follow"><span data-feather="check"></span>
                                             follow
                                             </button>
                                          </div>
                                       </div>
                                       <a class="view-more-comment color-primary fs-13 fw-500 px-25 pb-20" href="#">Load more friends</a>
                                    </div>
                                 </div>
                              </div>
                              <!-- Friend Widgets End -->
                              <!-- Gallery Image -->
                              <div class="card global-shadow mb-25">
                                 <div class="photo-gallery-widget">
                                    <div class="card-header justify-content-between d-flex flex-wrap px-md-25 px-3">
                                       <h6>photos</h6>
                                       <a class="color-primary fs-13 fw-500 mt-lg-0 mt-1" href="#">see all</a>
                                    </div>
                                    <div class="card-body">
                                       <div class="wig">
                                          <div class="wig__item">
                                             <img src="{{ asset('img/315.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/325.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/design.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/99.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/166.png') }}" alt="gallery">
                                          </div>
                                          <div class="wig__item">
                                             <img src="{{ asset('img/287.png') }}" alt="gallery">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Gallery Image End -->
                              <!-- Gallery Video Popup -->
                              <div class="card global-shadow mb-25">
                                 <div class="video-gallery-widget">
                                    <div class="card-header justify-content-between d-flex flex-wrap px-md-25 px-3">
                                       <h6>videos</h6>
                                       <a class="color-primary fs-13 fw-500 mt-lg-0 mt-1" href="#">see all</a>
                                    </div>
                                    <div class="card-body">
                                       <div class="wig">
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/juice-2.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/cup-card.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/round-box.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/glass.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/bottles.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper popup-youtube" href="https://www.youtube.com/watch?v=i9E_Blai8vk">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                          <div class="wig__item wig-overlay">
                                             <img src="{{ asset('img/325.png') }}" alt="gallery">
                                             <div class="wig-overlay__content">
                                                <a class="wig-overlay__iconWrapper" href="#">
                                                <img class="svg" src="{{ asset('img/svg/play.svg') }}" alt="img">
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Gallery Video Popup End -->
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

<div id="CancelOrderModal" class="modal fade" tabindex="-1">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title"><span class="font-weight-bold">Cancelar Pedido</span></h5>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
               <form action="{{ route('panel.cancelOrder') }}" method="POST">
                   <div class="form-group row">
                      <input hidden name="id" value="{{$order->id }}">
                      <input hidden name="canceled_from" value="StoreOwner">
                       <label class="col-lg-3 col-form-label">Descreva o Motivo:</label>
                       <div class="col-lg-9">
                           <textarea type="text" class="form-control" name="canceled_reason"
                               placeholder="Digite o Motivo do Cancelamento" rows="4" required></textarea>
                       </div>
                   </div>
                   @csrf
                   <div class="text-right">

                     
                       <button type="submit" class="btn btn-danger">
                       Cancelar Pedido
                       
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
<script src="{{ asset('vendor_assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/charts.js') }}"></script>
@endsection