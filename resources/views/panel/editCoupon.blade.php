@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('styles')

<style>
  .card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}
.row {
     margin-right: 0px;
    margin-left: 0px;
}
label {
    display: inline-block;
    margin-bottom: 10px;
    font-size: 14px;
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
                            <h4 class="breadcrumb-title">Editando Cupom de Desconto</h4>
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
                                <div class="text-right">
                                    <a href="{{ route('panel.coupons') }}"
                                        class="btn btn-default btn-white " data-popup="tooltip"
                                        title="" data-placement="bottom">
                                    <b><i class="la la-arrow-left"></i></b>
                                    Voltar
                                    </a>
                                   
                                </div>

                                @csrf
                            <div class="text-right" style="margin-left:20px">
                                <button type="submit" form="editaddon" class="btn btn-primary">
                                Salvar Cupom
                                    <i class="icon-database-insert ml-1"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>

                    
                    

                    <div class="col-md-12">
                        <form action="{{ route('panel.updateCoupon') }}" id="editaddon" method="POST" enctype="multipart/form-data"> 
                            <div class="card">
                                <div class="card-body ">
                                    
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Dados do Cupom</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl30 pr30">
                                                <div class="form-group row" style="margin-left: 15px;"> 
                                                    <div class="custom-control custom-switch switch-primary switch-md ">
                                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                                        <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Cupom de Desconto Ativo</label>
                                                        <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Cupom de Desconto Desativado</label>
                                                     </div>
                                                    </div>
                                               
                                                    <input hidden type="text" name="id" value="{{$coupon->id  }}" >
                                                       
                                               
                                                    <div class="form-group row">
                                                    <label for="name"><span class="text-danger">*</span>Tipo de Desconto</label>
                                                    <i class="fas fa-question-circle" 
                                                    style="margin-left: 5px"  
                                                    tabindex="-1" 
                                                    data-trigger="hover"
                                                    data-html="true"  
                                                    data-toggle="popover" 
                                                    title="Tipo de Desconto"  
                                                    data-content="Exemplos: <strong>1) Desconto em Reais</strong> (R$ 10,00 de desconto) <strong> 2) Desconto em Porcentagem</strong> (Desconto de 10%)"
                                                    ></i>
                                                    
                                                <div class="inline-block">
                                                    <div class="radio-theme-default custom-radio " style="margin-left:20px" >
                                                        <input class="radio discount_type" type="radio" name="discount_type" value="AMOUNT" <?php if ($coupon->discount_type ==='AMOUNT') { echo "checked="; }  ?>  id="radio-un2" >
                                                        <label for="radio-un2">
                                                        <span class="radio-text">Desconto em Reais (R$)</span>
                                                        </label>
                                                     </div>
                                                     
                                                     <div class="radio-theme-default custom-radio" style="margin-left:20px" >
                                                        <input class="radio discount_type" type="radio" name="discount_type" value="PERCENTAGE" <?php if ($coupon->discount_type ==='PERCENTAGE') { echo "checked="; }  ?>  id="radio-un4"  >
                                                        <label for="radio-un4">
                                                        <span class="radio-text">Desconto em Porcentagem (%)</span>
                                                        </label>
                                                     </div>
                                                    </div>
                                                    </div>
                                                        
                                                    
                                                    <div class="row col-md-12">
                                                    <div class="form-group col-md-6 " style="padding-left: 0px;" id="value_amount">
                                                        <label for="name"><span class="text-danger">*</span>Valor do Desconto</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    R$
                                                                </span>
                                                            </div>
                                                            <input 
                                                            type="text" 
                                                            class="form-control form-control-lg dinheiro" 
                                                            name="discount_amount"
                                                            value="{{ $coupon->discount }}"
                                                            placeholder=""   
                                                            required>
                                                        </div>  
                                                    </div>
                                                
                                                    <div class="form-group col-md-6" style="padding-left: 0px;" id="value_percentage">
                                                        <label for="name"><span class="text-danger">*</span>Porcentagem de Desconto</label>
                                                        <div class="input-group input-group-merge">  
                                                            <input 
                                                            type="number" 
                                                            class="form-control form-control-lg" 
                                                            name="discount_percent"
                                                            placeholder=""
                                                            value="{{ $coupon->discount }}"
                                                            data-parsley-max="100"   
                                                            >
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="percent"></i>
                                                                </span>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6" style="padding-right: 0px;">
                                                        <label for="expiry_date"><span class="text-danger"></span>Data de Expiração:</label>
                                                            <input 
                                                            type="date" 
                                                            class="form-control form-control-lg" 
                                                            name="expiry_date"
                                                            placeholder=""
                                                            value="{{ date("Y-m-d", strtotime($coupon->expiry_date)) }}"  
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="row col-md-12">
                                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                                        <label for="min_subtotal"><span class="text-danger"></span>Para compras acima de:</label>
                                                            
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    R$
                                                                </span>
                                                            </div>
                                                            <input 
                                                            type="text" 
                                                            class="form-control form-control-lg dinheiro" 
                                                            name="min_subtotal"
                                                            placeholder="" 
                                                            value="{{ $coupon->min_subtotal }}"    
                                                            required>
                                                        </div> 
        
        
        
                                                    </div>
                                                    <div class="form-group col-md-6" style="padding-right: 0px;">
                                                        <label for="max_count"><span class="text-danger"></span>N° de Cupons Disponíveis:</label>
                                                            <input type="number" class="form-control form-control-lg" value="20" name="max_count"
                                                                placeholder=""  data-parsley-min="1" required>
                                                    </div>
                                                </div>
        
                                                <div class="form-group row">
                                                    <label><span class="text-danger">*</span>Como o Cupom poderá ser usado?</label>
                                                    
                                                <select class="form-control select-search select" name="user_type" required>
                                                    <option value="ALL" class="" <?php if ($coupon->user_type ==='ALL') { echo "selected"; } ?> >
                                                        Número ILIMITADO de vezes por cada cliente
                                                    </option>
                                                    <option value="ONCENEW" class="" <?php if ($coupon->user_type ==='ONCENEW') { echo "selected"; } ?> >
                                                        Somente para NOVOS CLIENTES em suas PRIMEIRAS COMPRAS
                                                    </option>
                                                    <option value="ONCE" class="" <?php if ($coupon->user_type ==='ONCE') { echo "selected"; } ?> >
                                                        UMA VEZ por cliente
                                                    </option>
                                                    <option value="CUSTOM" class="" <?php if ($coupon->user_type ==='CUSTOM') { echo "selected"; } ?> >
                                                        DEFINIR número de vezes por cliente
                                                    </option>
                                                 </select>
                                                 
                                                </div>
                                                <div class="form-group row hidden" id="maxUsePerUser">
                                                    <label >Número máximo de vezes por cliente: </label>
                                                    
                                                        <input type="number" class="form-control form-control-lg max_count_per_user" name="max_count_per_user"
                                                            placeholder="Número máximo de vezes por cliente" value="{{ $coupon->max_count_per_user }}">
                                                    
                                                </div>
        
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
        
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Como Funciona o Cupom de Desconto?</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl15 pr15">
                                                
                                                <div class="col-md-12">
                                                    <div class='' style="text-align: center;" >
                                                        <br>  
                                                        <img class="light" style="width: 170px;" src="https://app.comprabakana.com.br/assets/img/cupom.png" alt="">
                                                        <br><br>     
                                                    </div>
                                                <p><span>Você pode criar Cupons de Descontos com objetivos diferentes  </span></p>
                                            <p><strong>Exemplos:</strong></p>
                                            <p>1) Cupom de R$ 10,00 para compras acima de R$ 50,00;</p>
                                            <p>2) Cupom de R$ 10,00 para compras acima de R$ 50,00 somente para NOVOS CLIENTES (primeira compra);</p>
                                            <p>3) Cupom de 10% de desconto para compras acima de R$ 80,00</p>
                                            <p>4) Cupom de 10% de desconto para compras acima de R$ 80,00 somente para NOVOS CLIENTES (primeira compra);</p>
                                            <p></p>
                                            <p> Você pode ainda limitar a quantidade de cupons disponíveis, e o número de vezes que cada cliente poderá usar o cupom.</p>
                                            </div>
                                                
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                        
                                        
                                    @csrf
                                        
                                    
                                </div>
                            </div>
                            <br><br>
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
$(document).ready(function () {
var discount_type= "<?php  echo $coupon->discount_type; ?>";  
 

if (discount_type== 'AMOUNT') {
  
$('#value_amount').removeClass('hidden').find("input").prop("required", true);
$("#value_percentage").addClass('hidden').find("input").prop("required", false);


}


if (discount_type== 'PERCENTAGE') { 
    $('#value_percentage').removeClass('hidden').find("input").prop("required", true);
$("#value_amount").addClass('hidden').find("input").prop("required", false);
}

});


    $("[name='user_type']").change(function() {
        let selectedUserType = $(this).val();
        if (selectedUserType == "CUSTOM") {
             $("[name='max_count_per_user']").attr('required', 'required');
            $('#maxUsePerUser').removeClass('hidden');
        } else {
           $("[name='max_count_per_user']").removeAttr('required')
           $('#maxUsePerUser').addClass('hidden');
        }
    });
</script>

<script>
$(document).ready(function() {
$(".discount_type").on('change', function () {
        if ($(this).val() == "AMOUNT"  ) {
            $("#value_amount").removeClass('hidden').find("input").prop("required", true);
            $("#value_percentage").addClass('hidden').find("input").prop("required", false);
        }
        if ($(this).val()  == "PERCENTAGE") {
            $("#value_amount").addClass('hidden').find("input").prop("required", false);
            $("#value_percentage").removeClass('hidden').find("input").prop("required", true);
        }
});

});


$(function () {
  $('[data-toggle="popover"]').popover()
})


$(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		}); 
        
    }); 
  

    
    $(document).ready(function() {

        
        $("#is_active").click(function () {
            if ($(this).is(":checked")) {
                $("#produto_ativo").show();
                $("#produto_desativado").hide();
               
            } else {
                $("#produto_ativo").hide();
                $("#produto_desativado").show();
            }
        });
        
    });   

    $(document).ready(function () {
    $('#abrir').click(function () {
        $('#addNewItemModal').modal({
            show: true
        })
    });
    $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
    });
});


$('body').tooltip({selector: '[data-popup="tooltip"]'});
    var addonNamePlaceholder = "Nome";
    var addonPricePlaceholder = "Preço";
    var addonRemoveTitle = "Remover";

    function add(data) {
        //$('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><input type='text' class='form-control  form-control-lg' placeholder='"+addonNamePlaceholder+"' name='addon_names[]' required> </div> <div class='col-lg-5'> <input type='text' class='form-control form-control-lg dinheiro' name='addon_prices[]' placeholder='"+addonPricePlaceholder+"'  required> </div> <div class='col-lg-2'><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' style='padding:5px' title='"+addonRemoveTitle+"'><i class='la la-trash-alt'></i></button></div></div>";
        document.getElementById('addon').appendChild(newAddon);
        $(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    }

    $(function() {
        $('.select').select2({
            minimumResultsForSearch: -1,
        });

        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().remove();
        });
    }); 
 



              


</script>

@endsection


