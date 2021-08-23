@extends('layouts.app')
@section('styles')
<style>
   .ap-product .table thead tr th:first-child {
    width: 15%;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgb(228 235 239);
}
.displayflex{
   display:flex;
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
                  <h4 class="breadcrumb-title">Pedido: <strong style="color:#74398D">{{ $order->unique_order_id }}</strong></h4>
                  <span >Realizado em: {{ $order->created_at->format('d-m-Y')}} às {{ $order->created_at->format(' H:i ')}}</span>
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
                     

                     

                    @csrf
                <div class="text-right" style="margin-left:20px">
                   {{--  <button type="submit"  class="btn btn-primary">
                    Imprimir
                        <i class="icon-database-insert ml-1"></i></button> --}}

                   {{--   @if(\Nwidart\Modules\Facades\Module::find('ThermalPrinter') && \Nwidart\Modules\Facades\Module::find('ThermalPrinter')->isEnabled() )

                        <button type="button" class="btn btn-sm btn-secondary my-2 ml-2 thermalPrintButton" disabled="disabled" title="{{__('thermalPrinterLang.connectingToPrinterMessage')}}" style="color: #fff; float: right; border-radius: 8px" data-type="kot"><i class="icon-printer4 mr-1 thermalPrinterIcon"></i> {{__('Imprimir')}}</button>
            
                         <button type="button" class="btn btn-sm btn-secondary my-2 ml-2 thermalPrintButton" disabled="disabled" title="{{__('thermalPrinterLang.connectingToPrinterMessage')}}" style="color: #fff; float: right; border-radius: 8px" data-type="invoice"><i class="icon-printer4 mr-1 thermalPrinterIcon"></i> {{__('Imprimir Invoice')}}</button>
             
                        <input type="hidden" id="thermalPrinterCsrf" value="{{ csrf_token() }}">
                        <script>
                            var socket = null;
                            var socket_host = 'ws://127.0.0.1:6441';
            
                            initializeSocket = function() {
                                try {
                                    if (socket == null) {
                                        socket = new WebSocket(socket_host);
                                        socket.onopen = function() {};
                                        socket.onmessage = function(msg) {
                                            let message = msg.data;
                                            $.jGrowl("", {
                                                position: 'bottom-center',
                                                header: message,
                                                theme: 'bg-danger',
                                                life: '5000'
                                            });
                                        };
                                        socket.onclose = function() {
                                            socket = null;
                                        };
                                    }
                                } catch (e) {
                                    console.log("ERROR", e);
                                }
            
                                var checkSocketConnecton = setInterval(function() {
                                    if (socket == null || socket.readyState != 1) {
                                        $('.thermalPrintButton').attr({
                                            disabled: 'disabled',
                                            title: '{{__('thermalPrinterLang.connectingToPrinterFailedMessage')}}'
                                        });
                                    }
                                    if (socket != null && socket.readyState == 1) {
                                         $('.thermalPrintButton').removeAttr('disabled').removeAttr('title');
                                    }
                                    clearInterval(checkSocketConnecton);
                                }, 500)
                            };
            
                            initializeSocket();
            
                           
                        </script>
                        @endif  --}}
                </div>
                  </div> 
               </div>
            </div>
            <div class="row col-lg-12 mb-20 ml-10">
               <div class="text-right mr-20">
                  <a href="{{ route('restaurant.orders') }}"
                      class="btn btn-default btn-white " data-popup="tooltip"
                      title="" data-placement="bottom">
                  <b><i class="la la-arrow-left"></i></b>
                  Voltar
                  </a>
                 
              </div>

               @if($order->orderstatus_id == 1)
               <div class="" style="display: flex; justify-content: center;" id="withPrinter">
                     <a href="{{ route('panel.acceptOrder', $order->id) }}"
                        class="btn btn-primary btn-default btn-squared text-capitalize  px-25"
                        onclick="javascript:jsWebClientPrint.print('order_id=' + {{ $order->id }});"
                        > Aceitar Pedido
                     </a>

               </div>
               <div class="" style="display: none; justify-content: center;" id="withoutPrinter">
                  <a href="{{ route('panel.acceptOrder', $order->id) }}"
                     class="btn btn-primary btn-default btn-squared text-capitalize  px-25"
                     
                     > Aceitar Pedido
                  </a>

            </div>


               <div class="" style="display: flex; justify-content: center; margin-left:20px" >  

                  <button type="button" class="btn btn-danger btn-default btn-squared text-capitalize  px-25" id="CancelOrder"
                  data-toggle="modal" data-target="#CancelOrderModal">
                  <b><i class="icon-plus2"></i></b>
                  Cancelar Pedido</button>

                     
               </div>
          @endif
          @if($order->delivery_type == 2 && $order->orderstatus_id == 2)
          <div class="" style="display: flex; justify-content: center;" >
          <a href="{{ route('panel.markOrderReady', $order->id) }}"
              class="btn btn-warning"> Marcar como: Pronto Para Retirada <i
              class="icon-checkmark3 ml-1"></i></a></div>
          @endif 
          @if($order->delivery_type == 2 && $order->orderstatus_id == 7)
            <div class="" style="display: flex; justify-content: center;" >
               <a href="{{ route('panel.markSelfPickupOrderAsCompleted', $order->id) }}"
              class="btn btn-success"> Marcar como Entregue <i
              class="icon-checkmark3 ml-1"></i></a>
            </div>
          @endif 

          @if($order->delivery_type != 2 && $order->orderstatus_id == 2)
          <div class="" style="display: flex; justify-content: center;" >
          <a href="{{ route('panel.markOrderAsOnway', $order->id) }}"
              class="btn btn-warning"> Marcar como: Saiu para Entrega <i
              class="icon-checkmark3 ml-1"></i></a>
            </div>
          @endif 
          @if($order->delivery_type != 2 && $order->orderstatus_id == 4)
            <div class="" style="display: flex; justify-content: center;" >
               <a href="{{ route('panel.markOrderAsDelivered', $order->id) }}"
              class="btn btn-success"> Marcar como Entregue <i
              class="icon-checkmark3 ml-1"></i></a>
            
            </div>
          @endif

          <div class="" style="display: flex; justify-content: center; margin-left:20px" id="withPrinter2">
            <a href=""
               class="btn btn-default btn-white btn-squared text-capitalize  px-25"
               onclick="javascript:jsWebClientPrint.print('order_id=' + {{ $order->id }});"
               > Imprimir
            </a>

      </div>
            </div>
            <div class="row col-lg-12">
               <div class="col-lg-4 col-md-4 mb-25">
                  <!-- Card 1 -->
                  <div class="ap-po-details radius-xl bg-white d-flex justify-content-between">
                     <div>
                        <div class="overview-content">
                            <p>STATUS DO PEDIDO</p>
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
                            <p>TIPO DE ENTREGA</p>
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
                            <span style="font-size:14px; color:#868eae">FORMA DE PAGAMENTO</span>
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
                                       @if($order->payment_type =='app')
                                             @if($order->payable!=0.00)
                                             Pagto pelo APP (PENDENTE)
                                             @else
                                             Pago pelo APP (Não Cobrar)
                                             @endif
                                          
                                          @endif
                                    @endif
                                    @if ($order->payment_mode == 'DEBITCARD')
                                          @if($order->payment_type =='selfpickup')
                                          Pagar na Retirada (Cartão de Débito)
                                          @endif
                                          @if($order->payment_type =='delivery')
                                          Pagar na Entrega (Cartão de Débito)
                                          @endif
                                          @if($order->payment_type =='app')
                                             @if($order->payable!=0.00)
                                             Pagto pelo APP (PENDENTE)
                                             @else
                                             Pago pelo APP (Não Cobrar)
                                             @endif
                                          
                                          @endif
                                    @endif
                                    @if ($order->payment_mode == 'PIX')
                                          @if($order->payment_type =='selfpickup')
                                          Pagar na Retirada (PIX)
                                          @endif
                                          @if($order->payment_type =='delivery')
                                          Pagar na Entrega (PIX)
                                          @endif
                                          @if($order->payment_type =='app')
                                          Pago pelo APP (Não Cobrar)
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
   <div class="card  mb-40">
      <div class="card-header text-capitalize px-md-25 px-3">
         <h6>Separação do Pedido</h6>
      </div>
      <div class="card-body p-0">
         <div class="row" style="padding:30px">
            <div class="col-lg-8">
               @if($order->orderstatus_id ==2 && $order->separation_status ==null)
               Atribuir Separador
               @endif
               @if($order->separation_status ==11 || $order->separation_status ==12)
               @php
                  $separator_id=$order->separator_id;
                  $name_separator=\App\User::where('id',$separator_id)->first()->name;
               @endphp
               <h3>Pedido em Separação - Responsável: {{ $name_separator }}</h3>
               <br>
               <span></span>
               @endif
               @if($order->separation_status ==13)
               <h3>Pedido Separado</h3>
               @endif

            </div>
            <div class="col-lg-4">
               @if($order->orderstatus_id ==2 && $order->separation_status ==null)
               <button type="button" class="btn btn-danger btn-default btn-squared text-capitalize  px-25" id="selectSeparatorModal"
                  data-toggle="modal" data-target="#selectSeparator">
                  <b><i class="icon-plus2"></i></b>
                  Escolher</button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>

               <div class="col-lg-12">
                  <!-- Product Table -->
                  <div class="card  mb-40">
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
                                      
                                       <td>
                                          <?php

                                          $url = $item->image;
                                          if($item->image == null){ ?>
                                              <img src="https://app.comprabakana.com.br/assets/img/sem_imagem.jpeg"  height="60" width="60" style="border-radius: 0.275rem;">
                                          <?php }else{ 
                                              if(substr($url, 0, 4) == "http"){
                                                  ?>    
                                                  <img src="{{ $item->image }}"  height="60" width="60" style="border-radius: 0.275rem;">
                                                  <?php
                                              } else {?>
                                                  <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $item->image }}"  height="60" width="60" style="border-radius: 0.275rem;">
                                      
                                              <?php } ?>
                                          <?php } ?>

                                                            
                                          
                                          
                                          
                                          
                                          </td>
                                      <td>{{ $item->name .' - '.$item->codint }}
                                    
                                       @if(count($item->order_item_addons))
                                       
                                       <ul>
                                          <strong>Opções:</strong>
                                          @foreach($item->order_item_addons as $addon)
                                          <li> {{ $addon->addon_category_name }}: {{ $addon->addon_name }} ({{ $addon->addon_price }})</li>
                                       </li>
                                          @endforeach
                                          
                                       </ul>
                                       
                                           @endif
                                    
                                    
                                           @if($item->item_obs)
                                       
                                           <ul class="mt-10">
                                              <strong>Observação:</strong>
                                              
                                              <li> {{ $item->item_obs }} </li>
                                           </li>
                                              
                                              
                                           </ul>
                                           
                                               @endif
                                    
                                    
                                    
                                    </td>
                                      <td>{{ $item->ean }}</td>
                                     

                                      @if($item->peso)
                                      <td>{{  str_replace('.', ',',$item->peso). ' kg' }}</td>
                                      @else
                                      <td>{{ $item->quantity }}</td>
                                      @endif
                                      @php

                                      

                                          if($item->peso){
                                                $itemTotal = (($item->price)*($item->peso) +calculateAddonTotal($item->order_item_addons)) * $item->quantity;
                                                $subTotal = $subTotal + $itemTotal;
                                          }else{
                                                $itemTotal = ($item->price +calculateAddonTotal($item->order_item_addons)) * $item->quantity;
                                                $subTotal = $subTotal + $itemTotal;
                                          }
                                              

                               
                                               
                                               

                                          
                                       
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

                  <!-- Product Table End -->
               </div>
            </div>

            <div class="col-md-6 col-lg-6  ">
               
                  <!-- Profile Acoount -->
                
                  <!-- Profile Acoount End -->
                  <!-- Profile User Bio -->
                  
                  <div class="card mb-25">
                     <div class="card-header px-md-25 px-3 ">
                        <h6>Dados do Cliente</h6>
                      </div>
                     <div class="card-body text-center pt-sm-30 pb-sm-0  px-25 pb-0">
                    
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
                                         @php
                                         $location=json_decode($order->location);
                                            $address = explode("-", $location->address)
                                         @endphp
                                            <p class="user-content-info__item">
                                                <span data-feather="map-pin"></span>{{ $address[0] }} {{ $location->house }} - {{ $address[1] }}
                                               
                                             </p>
                                   
                                       
                                        @endif
                           </div>
                        

                     
                      <div class="user-bio border-top mt-30">
                        
                           <div class="title mt-30 mb-30">
                            <strong> Comentários do Cliente </strong>
                           </div>
                        
                        
                           <div class="user-bio__content mt-20 mb-20">
                              <p class="m-0">{{ $order->order_comment }}
                              </p>
                           </div>
                        
                     </div> 
                     
                     
                     
                  </div>
                 {{--  <div class="card-footer mt-20 pt-20 pb-20 px-0">
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
                  </div> --}}
               </div>
                  <!-- Profile User Bio End -->
               
            </div>
           
            <div class="col-md-6 col-lg-6">
               <div class="card mb-25">
                  <div class="card-header px-md-25 px-3">
                     <h6>Resumo do Pedido</h6>
                   </div>
                  <div class="card-body p-0">
                     <div class="ap-product">
                        <div class="table-responsive">
                           <table class="table">
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

<div id="selectSeparator" class="modal fade" >
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title"><span class="font-weight-bold">Selecionar Separador</span></h5>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
               <form action="{{ route('panel.selectSeparator') }}" method="POST">
                  <div class="form-group ">
                     <input hidden name="order_id" value="{{ $order->id }}">
                     <div class="cityOption">
                         <label for="separator_id">Separador:</label>
                           <select  class="js-example-basic-single js-states form-control" id="select-separator"  required parsley-trigger="change" data-parsley-errors-container="#select242"  data-parsley-group="form-step-1" name="separator_id" data-parsley-required>
                              @foreach($separators as $separator)
                              <option value="{{ $separator->id }}" class="text-capitalize" <?php if ($order->separator_id==$separator->id) { echo "selected"; } ?> >{{ $separator->name }} ({{ $separator->running }} pedidos em andamento)</option>
                              @endforeach
                           </select>
                     </div>
                 </div>
                   @csrf
                   <div class="text-right">

                     
                       <button type="submit" class="btn btn-danger">
                       Atribuir Separador
                       
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



<script type="text/javascript">




            var wcppPingTimeout_ms = 500; //60 sec
            var wcppPingTimeoutStep_ms = 500; //0.5 sec
                     
            function wcppDetectOnSuccess(){
                // WCPP utility is installed at the client side
                // redirect to WebClientPrint sample page
                
                // get WCPP version
                var wcppVer = arguments[0];
                if(wcppVer.substring(0, 1) == "6"){
                  $('#withoutPrinter').hide();
                $('#withPrinter').addclass('displayflex');
                $('#withPrinter2').addclass('displayflex');
                }
                
                else{
                  wcppDetectOnFailure();
                } //force to install WCPP v6.0
                   
            }

            function wcppDetectOnFailure() {
                // It seems WCPP is not installed at the client side
                // ask the user to install it
               // $('#withPrinter').hide();
               // $('#withPrinter2').hide();
               // $('#withoutPrinter').addclass('displayflex');
            }

          

</script>
<script type="text/javascript">
	var wcppGetPrintersTimeout_ms = 60000; //60 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec

	function wcpGetPrintersOnSuccess(){
		// Display client installed printers
		if(arguments[0].length > 0){
			var p=arguments[0].split("|");
			var options = '';
			for (var i = 0; i < p.length; i++) {
				options += '<option>' + p[i] + '</option>';
			}
			$('#installedPrinters').css('visibility','visible');
			$('#installedPrinterName').html(options);
			$('#installedPrinterName').focus();
			$('#loadPrinters').hide();                                                        
		}else{
			alert("No printers are installed in your system.");
		}
	}

	function wcpGetPrintersOnFailure() {
		// Do something if printers cannot be got from the client
		alert("No printers are installed in your system.");
	}

</script>

{!! 

   // Register the WebClientPrint script code
   // The $wcpScript was generated by PrintESCPOSController@index
   
   $wcpScript;
   
   !!}

{!! 

   // Register the WebClientPrint script code
   // The $wcpScript was generated by PrintESCPOSController@index
   
   $wcppScript;
   
   !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>




@endsection