@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('styles')

<style>
  .card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}


.color-dark, .contact-card .cp-info__title, .contact-list .contact-item .contact_title a, .add-contact .add-new-contact label, .mailbox-list__single:hover .time-meta, .mailbox-list__single:hover .mail-content__top .mail-title a, .mailbox-list__single:hover .mail-authorBox .auhor-info .author-name, .task-modal .modal-header h5, .task-card__header .custom-checkbox input[type=checkbox] + label, .task-card .card-header, .kanban-modal__research h6, .kanban-modal__form label, .kanban-modal__header .modal-title, .kanban-list .list-title, .kb__categories li p, .post-pagination p a, .knowledgebase-adv__card .knowledgebase__list li a, .knowledgebase-adv__card .knowledgebase__list li .knowledgebase__list-collapsed, .knowledgebase__more a, .fileM-card .fileM-excerpt, .fileM-wrapper__title, .fileM-sidebar .fileM-types .sidebar__menu-group ul.sidebar_nav li.menu-title span, .testimonial-slider-global .author-thumb p, .changelog-history__title, .v-num, .counting-area .number, .ai-list-item span.active, .application-faqs .panel-title a, .gc__title p, .search-content .keyword-searching, .icon-list i, .icon-list svg, .add-product-status-radio .custom-radio input[type=radio]:checked + label, .upload-media-area__title p, .file-upload__label:hover, .file-upload__label, .add-product__body .form-group label, .table5 .pagination-total-text, table.table-rounded tr th, table.table-rounded tr td, table.table-basic tr td, .orderDatatable-title, .payment-invoice-table.userDatatable table thead tr th, .payment-invoice-qr__address p, .payment-invoice-qr__code p, .payment-invoice-qr__number p, .payment-invoice-qr__number .display-3, .payment-invoice-address__area address, .payment-invoice-logo span, .crc__method, .check-review__contact p, .payment-method-paypal .form-control, .payment-method-card .card-body label, .wizard9 .checkout-progress2 .step.completed span:last-child, .wizard9 .checkout-progress2 .step.current span:last-child, .wizard10 .payment-method-card .select2-container .select2-selection--single .select2-selection__rendered, .wizard10 .payment-method-card .select2-container--default .select2-selection--single .select2-selection__placeholder, .wizard10 .select2-container .select2-selection--single .select2-selection__rendered, .wizard10 .select2-container--default .select2-selection--single .select2-selection__placeholder, .wizard10 .checkout-progress3 .step span:first-child, .checkout-progress div.step.completed span:nth-of-type(2), .checkout-progress div.step.current span:nth-of-type(2), .checkout-progress div.step, .order-summery .total > div span, .Product-cart-title .media p, .product-cart__header th, .quantity .input, .product-details .product-details-brandName span, .product-details__availability .title p, #price-range .price-value, .stars-rating__point, .product-item__body .card-title a, .e-info-modal .e-info-list li .list-line .list-meta, .c-event-dialog .modal-header .modal-title, .fc-listMonth-view .fc-list-day th, #full-calendar .fc-toolbar-chunk .fc-toolbar-title, .date-picker__calendar .ui-datepicker-header .ui-datepicker-title span, .drag-drop-wrap .item_title h6 a, .atbd-tab .nav-link, .atbd-drawer .profile-info__label, .area-drawer-wrapper h1, .area-drawer-wrapper h2, .area-drawer-wrapper h3, .area-drawer-wrapper h4, .area-drawer-wrapper h5, .area-drawer-wrapper h6, .atbd-drawer__body p, .atbd-drawer__header .drawer-title, .page-info__single span, .page-title__left .title-text, .statistics-countdown__time, .statistics-item__number, .atbd-steps__text, .atbd-pop-message__text p, .atbd-submenu li a, .atbd-submenu .submenu-title, .timeline-box--3.basic-timeline .timeline li .timeline-single .timeline-single__days span, .form-basic label, .new-member-modal .form-group label, .userDatatable-inline-title h6, .userDatatable-content, .media-ui .user-group-progress-top p, .user-social-profile .edit-profile__body label, .users-list-body__title span span, .atbd-notice__content .notice-list__text, .signUp-admin-right .card .card-header h6, .edit-profile__body .form-group label, .ap-product .table thead tr th, .sales-target__progress-bar .total-count, .crm .table-selling-content .title, .crm .deals-table-wrap .table--default td, .revenue-chart-box__data, .revenue-chart-legend__data span, .device-pieChart-wrap .pie-chart-legend span, .atbd-empty__text, .atbd-notification-box__close svg, .atbd-notification-box__close img, .atbd-comment-box__content .cci__author-info, .badge.badge-transparent.badge-danger, .dynamic-badge-block .atbd-button-group .btn-icon svg, .strikingDash-top-menu > ul > li .megaMenu-wrapper.megaMenu-wide > li .mega-title, .daterangepicker.single .calendar-table tbody td, .customizer__title, .chartjs-tooltip table tbody td, .atbd-message {
    color: #272b41;
}
</style>

@endsection
@section('content')

                   

 
 <div class="contents">
    <div class="atbd-page-content">
        <div class="container-fluid">
            <div class="note-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-main">
                            <h4 class="breadcrumb-title">Configurando CashBack (Programa de Fidelidade)</h4>
                            <div class="breadcrumb-action justify-content-center flex-wrap">
                               {{--  <div class="action-btn">
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
                                </div> --}}
                               
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12">
                        <form 
                        action="{{ route('panel.updateCashback') }}" 
                        method="POST" 
                        enctype="multipart/form-data"
                        data-parsley-trigger="keyup" 
                        data-parsley-validate
                        > 
                            <div class="card">
                                <div class="card-body ">
                                            <div class="col-md-6" style="padding-left: 0px; float: left;" > 
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <i class="" aria-hidden="true"></i> <h5>CashBack da Loja </h5>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body pl15 pr15">
                                                        <input type="hidden" name="id" value="{{ $restaurant->id }}">
                                                        <div class="row mt-40 mb-30">
                                                            <div class="div col-lg-6 col-sm-6">
                                                               <span>Ativar CashBack em sua Loja</span>
                                                            </div>
                                                            <div class="custom-control custom-switch my-lg-0 my-10 col-lg-2 col-sm-2">
                                                               <input type="checkbox" class="custom-control-input" onchange="valueChanged()" name="cashback_active" id="nc1"  @if($restaurant->cashback_active) checked="checked" @endif >
                                                               <label class="custom-control-label" for="nc1"></label>
                                                            </div>
                                                            <small> </small>
                                                         </div>


                                                         

                                                        
                                                        <div class="form-group hidden" id="cashback_percent">
                                                            <label for="cashback_percent">Porcentagem de CashBack (sua loja)</label>
                                                            <div class="input-group input-group-merge">
                                                                
                                                                <input 
                                                                required 
                                                                type="number" 
                                                                class="form-control name" 
                                                                name="cashback_percent"
                                                                id="cashback_percent" 
                                                                parsley-trigger="change"  
                                                                data-parsley-group="form-step-1" 
                                                                placeholder="Porcentagem de CashBack" 
                                                                data-parsley-max="100" 
                                                                value="{{ $restaurant->cashback_percent }}"
                                                                >
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="icon-dual" data-feather="percent"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group hidden" id="cashbakana">
                                                            <label for="cashback_percent">Porcentagem de CashBack (CompraBakana)</label>
                                                            <div class="input-group input-group-merge">
                                                                
                                                                <input 
                                                            required 
                                                            disabled
                                                            type="number" 
                                                            class="form-control name" 
                                                            name="cashback_percent"
                                                            id="cashback_percent" 
                                                            parsley-trigger="change"  
                                                            data-parsley-group="form-step-1" 
                                                            placeholder="Porcentagem de CashBack" 
                                                            data-parsley-max="100" 
                                                            data-parsley-min="1" 
                                                            value="1"
                                                            >
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="icon-dual" data-feather="percent"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div id="cashback_active_message">
                                                        <span>Os usuários que comprarem em sua loja terão</span><strong> {{ $restaurant->cashback_percent }}% de Cashback </strong><span>(dinheiro de volta) em todas as compras, e poderão usar esse saldo em futuras compras em sua loja no aplicativo. </span>
                                                        </div>
                                                        
                                                        <div id="cashback_non_active_message">
                                                        <span>O Cashback de sua Loja está <strong style="color:red">DESATIVADO</strong>. Sugerimos que você ative o Cashback e coloque no campo acima pelo menos 1% de cashback, para que sua loja fique mais atrativa, atraia novos clientes, e fidelize os clientes atuais. Mas é claro, isso é opcional, não é obrigatório!</span>
                                                        </div>
                                                        

                                                        <div class="mt-30">
                                                            @if($restaurant->payment_app_accept ==1)
                                                            <span>Além do Cashback de sua loja, os usuários que fizerem qualquer compra com os meios de pagamento do aplicativo (cartão de crédito ou PIX) terão mais </span><strong> 1% de Cashback </strong><span>(dinheiro de volta). Esse saldo poderá ser usado para compras em quaisquer lojas. Inclusive, os usuários poderão usar saldo acumulado de compras em outras lojas, para comprar na Sua Loja. </span>
                                                        @else
                                                        <span>Sua Loja não está apta a ter o Cashback de 1% do CompraBakana, pois você desabilitou o "pagamento pelo aplicativo". Para habilitar, vá até <strong>Configurações->Delivery->Formas de Pagamento</strong></span>
                                                   
                                                        @endif
                                                        </div>
                                                    
                                                      
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6" style="padding-left: 0px; float: left;">
                                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>O que é o CashBack?</h5>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="card-body pl15 pr15">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class='' style="text-align: center;" >
                                                                        <br>  
                                                                        <img class="light" style="width: 270px;" src="https://app.comprabakana.com.br/assets/img/cashback2.png" alt="">
                                                                        <br><br>     
                                                                    </div>
                                                                <p><span>CashBack significa <strong>"Dinheiro de Volta"</strong>, e é um dos melhores mais preferidos <strong>"Programas de Fidelidade"</strong> no momento. </span></p>
                                                            <p>Exemplo:</p>
                                                            <p>Sua Loja oferece 1% de cashback. O João faz uma compra no valor de R$100,00 e ganha R$1,00 de cashback. Assim, a cada compra, ele vai acumulando saldo de cashback no aplicativo.</p>
                                                            <p>O João poderá usar esse saldo depois para pagar "parte" ou "total" de alguma próxima compra em sua loja. Vamos supor que ele acumulou R$10,00, e vai fazer uma nova compra no valor de R$ 50,00, e deseja utilizar esse saldo. Ele então pagará R$40,00 (os R$ 10,00 será considerado um desconto de sua loja).
                                                            </div>

                                                        </div>
                                                    </div>
                                                
                                            </div> <!-- end col -->
                                        
                                        
                                    @csrf
                                        
                                    
                                </div>
                            </div>
                            
                           

                            @csrf
                        <div class="text-right  mb-40" style="margin-left:20px">
                            <button type="submit" class="btn btn-primary">
                            Salvar Alterações
                                <i class="icon-database-insert ml-1"></i></button>
                        </div>
                        </form>  
                    </div>

                    
              
                </div>
            </div>
        </div>
    </div>
</div>
        



@endsection
@section('scripts')

<script>

function valueChanged()
    {
        if($('#nc1').is(":checked")) {
            $("#cashback_percent").show();
            $("#cashback_active_message").show();
            $("#cashback_non_active_message").hide();
        }  
            
        else{
            $("#cashback_percent").hide();
           $("#cashback_non_active_message").show();
           $("#cashback_active_message").hide();
        }
           

    }

    $(document).ready(function () {




var cashback_active= "<?php  echo $restaurant->cashback_active; ?>";  
var payment_app_accept= "<?php  echo $restaurant->payment_app_accept; ?>"; 

if (cashback_active== 1) {
  
$('#cashback_percent').removeClass('hidden');
$("#cashback_active_message").show();
$("#cashback_non_active_message").hide();

}else {
   $('#cashback_percent').addClass('hidden');
   $("#cashback_non_active_message").show();
   $("#cashback_active_message").hide();
}

if (payment_app_accept== 1) {
  
  $('#cashbakana').removeClass('hidden');
  
  }else {
     $('#cashbakana').addClass('hidden');
  
  }
  







});



    </script>





@endsection


