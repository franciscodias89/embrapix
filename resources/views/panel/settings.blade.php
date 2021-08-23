@extends('layouts.app')
@section('styles')
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">

<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">

<style>
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

    .card .card-header {
    padding-top: 10px;
    background: #ffffff;
}

    hr {
    margin-top: 1.67rem;
    margin-bottom: 1.67rem;
    border: 0;
    border-top: 1px solid #e3e6ef;
}

.fileuploader-theme-avatar {
    position: relative;
    width: 160px;
    height: 160px;
    padding: 0;
    margin: 30px;
    background: none;
}
.menuItem {
    position: absolute;
    right: 18px;
   
    height: auto;
    font-size: 10px;
    border-radius: 3px;
    padding: 3px 4px 4px;
    line-height: 1;
    letter-spacing: 1px;
    color: #fff;
}

.checkout-shipping-form {
    margin-top: 0px;
}

.contents2 {
    padding: 74px 15px 72px 50px;
    transition: all 0.3s ease;
}

.hiddeen{
        display: none;
    }
    .contentpage {
     margin-left: 40px; 
    overflow: hidden;
    padding: 0px 12.5px 5px 12.5px;
    min-height: 80vh;
    margin-top: 20px; 
}

</style>
@endsection
@section('content')
   
    <div class="contents ">
        <div class="profile-setting ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title"><span data-feather="settings"></span>  Configurações</h4>
                            <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md" 
                            data-toggle="modal" onclick="window.location='{{ route('restaurant.dashboard') }}'" >
                            <i class="la la-arrow-left"></i>Voltar</button>
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
                                </div> --}}
                                <div class="action-btn">
                                    <form action="{{ route('restaurant.updateRestaurant') }}" method="POST" id="publicar_form" enctype="multipart/form-data">
                                        @csrf
                                        <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                        <input hidden type="text" value="1" class="form-control" name="status">
                                    {{-- <button type="submit" form="publicar_form" class="btn btn-success btn-default mr-15 text-capitalize">Enviar para Publicação
                                  </button> --}}
                                </form>
                                </div> 
                            </div>
                        </div>
                    </div>

                    @if(Request::is('store-owner/settings/endwizard'))
                    @else
                    <div class="col-xl-3 col-lg-4 col-sm-5">
                        <!-- Profile Acoount -->
                        <div class="card mb-25">
                            <div class="card-body text-center p-0">
                              
                                <div class="ps-tab p-20 pb-25">
                                    <div class="nav flex-column text-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a 
                                        class="nav-link  <?php if(Request::is('store-owner/settings/profile')) { echo "active"; } ?> " 
                                        id="profile"  
                                        href="{{ route("panel.settingsProfile") }}">
                                        <span data-feather="bookmark"></span>
                                        Perfil
                                        @if($restaurant->status>=1)
                                            <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                            @else
                                            <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                        @endif
                                        </a>

                                        <a class="nav-link <?php if(Request::is('store-owner/settings/address')) { echo "active"; } ?> " 
                                            id="address"  
                                            href="{{ route("panel.settingsAddress") }}"  >
                                            <span data-feather="flag"></span>Endereço 
                                            @if($restaurant->status>=2)
                                            <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                            @else
                                            <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                            @endif
                                        </a>

                                            {{-- @if($restaurant)
                                            <span class="badge badge-success menuItem mr-15"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="badge badge-danger menuItem mr-15"><i class="fas fa-exclamation mr-1 ml-1"></i></span>
                                        @endif --}}

                                        <a class="nav-link  <?php if(Request::is('store-owner/settings/company-data')) { echo "active"; } ?> " 
                                            id="companyData" 
                                            href="{{ route("panel.settingsCompanyData") }}"   >
                                            <span data-feather="file-text"></span>Dados Cadastrais
                                            @if($restaurant->status>=3)
                                            <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                            @else
                                            <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                        @endif
                                    </a>
                                        
                                        <a class="nav-link <?php if((Request::is('store-owner/settings/sales-settings')) ||(Request::is('store-owner/settings/delivery-time')) ||(Request::is('store-owner/settings/selfpickup-time'))  ) { echo "active"; } ?> " 
                                            id="salesSettings" 
                                            href="{{ route("panel.salesSettings") }}" > 
                                            
                                            <span data-feather="shopping-cart"></span>Configurações de Venda
                                            @if($restaurant->status>=4)
                                            <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                            @else
                                            <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                        @endif
                                        </a>

                                        <a class="nav-link <?php if((Request::is('store-owner/settings/payment-settings'))||(Request::is('store-owner/settings/paymentdelivery-settings')) || (Request::is('store-owner/settings/paymentselfpickup-settings'))) { echo "active"; } ?> " 
                                            id="PaymentSettings" 
                                            href="{{ route("panel.PaymentSettings") }}" > 
                                            
                                            <span data-feather="dollar-sign"></span>Formas de Pagamento
                                            @if($restaurant->status>=5)
                                            <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                            @else
                                            <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                        @endif
                                    </a>
                                            @if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3))
                                                <a class="nav-link <?php if((Request::is('store-owner/settings/delivery-calendar'))||(Request::is('store-owner/settings/selfpickup-calendar'))) { echo "active"; } ?> " 
                                                    id="DeliveryCalendar" 
                                                    href="{{ route("panel.DeliveryCalendar") }}" > 
                                                    <span data-feather="clock"></span>Horários
                                                    @if($restaurant->status>=6)
                                                    <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                    @else
                                                    <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                                @endif</a>
                                            @endif
                                            @if($restaurant->delivery_type == 2 )
                                                <a class="nav-link <?php if((Request::is('store-owner/settings/selfpickup-calendar'))||(Request::is('store-owner/settings/selfpickup-calendar'))) { echo "active"; } ?> " 
                                                    id="SelfpickupCalendar" 
                                                    href="{{ route("panel.SelfpickupCalendar") }}" > 
                                                    <span data-feather="clock"></span>Horários
                                                    @if($restaurant->status>=6)
                                                    <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                    @else
                                                    <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                                @endif
                                            </a>
                                            @endif
                                        <a class="nav-link <?php if(Request::is('store-owner/settings/preferences')) { echo "active"; } ?> " 
                                                id="preferences" 
                                                href="{{ route("panel.preferences") }}" > 
                                                <span data-feather="settings"></span>Preferências
                                                @if($restaurant->status>=7)
                                                <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                @else
                                                <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                            @endif</a>
@if($restaurant->status>=8 )
                                            <a class="nav-link <?php if(Request::is('store-owner/settings/printer')) { echo "active"; } ?> " 
                                                id="printer" 
                                                href="{{ route("panel.printer") }}" > 
                                                <span data-feather="settings"></span>Configurar Impressora Térmica
                                                {{-- @if($restaurant->status>=7)
                                                <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                @else
                                                <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                            @endif --}}</a>
                                            @if($restaurant->is_accepted == 0 )
                                            <a class="nav-link <?php if(Request::is('store-owner/settings/user-tester')) { echo "active"; } ?> " 
                                                id="user_tester" 
                                                href="{{ route("panel.UserTester") }}" > 
                                                <span data-feather="settings"></span>Teste do App
                                                {{-- @if($restaurant->status>=7)
                                                <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                @else
                                                <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                            @endif --}}</a>
                                            @endif

                                            @if($restaurant->ask_publish == 0 )
                                            <a class="nav-link <?php if(Request::is('store-owner/settings/publish')) { echo "active"; } ?> " 
                                                id="user_tester" 
                                                href="{{ route("panel.publishStore") }}" > 
                                                <span data-feather="settings"></span>Publicar Loja
                                                <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                                {{-- @if($restaurant->status>=7)
                                                <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                @else
                                                <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                            @endif --}}</a>
                                            @endif
@endif

                                                <a class="nav-link <?php if(Request::is('store-owner/settings/terms')) { echo "active"; } ?> " 
                                                    id="terms" 
                                                    href="{{ route("panel.terms") }}" > 
                                                    <span data-feather="thumbs-up"></span>Termos de Uso
                                                    @if($restaurant->status>=8)
                                                    <span class="badge badge-success menuItem"><i class="fas fa-check"></i></span>
                                                    @else
                                                    <span class="badge badge-danger menuItem"><i class="fas fa-check"></i></span>
                                                @endif</a>

                                       

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Acoount End -->
                    </div>

                    @endif
               
                    <div class="col-xl-9 col-lg-8 col-sm-7">
 {{--                        <div class="as-cover">
                            <div class="as-cover__imgWrapper">
                                <input id="file-upload1" type="file" name="fileUpload" class="d-none">
                                <label for="file-upload1">
                                    <img src="{{ asset('img/ap-header.png') }}" alt="image" class="w-100">
                                    <span class="ap-cover__changeImgBtn">
                                            <span class="btn btn-outline-primary cover-btn">
                                                <span data-feather="camera"></span>Change
                                                Cover</span>
                                        </span>
                                </label>
                            </div>
                        </div> --}}
                        @if($restaurant->status ==17)
                        <div class="alert-icon-big alert alert-danger " role="alert">
                            <div class="alert-icon">
                                <span data-feather="layers"></span>
                            </div>
                            <div class="alert-content">
                                <h6 class='alert-heading'>Configurações Pendentes</h6>
                                <p>Ainda há configurações pendentes em sua conta. Por favor, siga as indicações no menu ao lado (em vermelho) e finalize seu cadastro.</p>
                            </div>
                        </div>
                    @endif
                        <div class="">
                            <div class="tab-content" >
                                @if(Request::is('store-owner/settings/profile'))
                                    @include('panel.storesettings.profile')
                                @endif

                                @if(Request::is('store-owner/settings/address'))
                                    @include('panel.storesettings.address')
                                @endif
                                @if(Request::is('store-owner/settings/sales-settings'))
                                    @include('panel.storesettings.sales_settings')
                                @endif
                                @if(Request::is('store-owner/settings/company-data'))
                                    @include('panel.storesettings.company_data')
                                @endif

                                @if(Request::is('store-owner/settings/delivery-time'))
                                     @include('panel.storesettings.delivery_time')
                                @endif

                                @if(Request::is('store-owner/settings/selfpickup-time'))
                                     @include('panel.storesettings.selfpickup_time')
                                @endif 

                                @if(Request::is('store-owner/settings/payment-settings'))
                                     @include('panel.storesettings.payment_settings')
                                @endif 
                                @if(Request::is('store-owner/settings/paymentdelivery-settings'))
                                     @include('panel.storesettings.paymentdelivery_settings')
                                @endif 
                                @if(Request::is('store-owner/settings/paymentselfpickup-settings'))
                                     @include('panel.storesettings.paymentselfpickup_settings')
                                @endif 
                                @if(Request::is('store-owner/settings/delivery-calendar'))
                                    @include('panel.storesettings.delivery_calendar')
                                @endif
                                @if(Request::is('store-owner/settings/selfpickup-calendar'))
                                     @include('panel.storesettings.selfpickup_calendar')
                                @endif

                                @if(Request::is('store-owner/settings/preferences'))
                                     @include('panel.storesettings.preferences')
                                @endif
                                
                                @if(Request::is('store-owner/settings/printer'))
                                    @include('panel.storesettings.printer')
                                @endif

                                @if(Request::is('store-owner/settings/user-tester'))
                                    @include('panel.storesettings.user_tester')
                                @endif

                                @if(Request::is('store-owner/settings/publish'))
                                @include('panel.storesettings.publish')
                           @endif

                                @if(Request::is('store-owner/settings/terms'))
                                     @include('panel.storesettings.terms')
                                @endif
                                @if(Request::is('store-owner/settings/endwizard'))
                                     @include('panel.storesettings.end')
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
