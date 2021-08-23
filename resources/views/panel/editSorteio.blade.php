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
                            <h4 class="breadcrumb-title">Editando Sorteio</h4>
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
                                    <a href="{{ route('restaurant.addonCategories') }}"
                                        class="btn btn-default btn-white " data-popup="tooltip"
                                        title="" data-placement="bottom">
                                    <b><i class="la la-arrow-left"></i></b>
                                    Voltar
                                    </a>
                                   
                                </div>

                                @csrf
                            <div class="text-right" style="margin-left:20px">
                                <button type="submit" form="editaddon" class="btn btn-primary">
                                Salvar Sorteio
                                    <i class="icon-database-insert ml-1"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>

                    
                    

                    <div class="col-md-12">
                        <form action="{{ route('panel.updateSorteio') }}" id="editaddon" method="POST" enctype="multipart/form-data"> 
                            <div class="card">
                                <div class="card-body ">
                                    
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Dados do Sorteio</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl30 pr30">
                                                <input type="hidden" name="id" id="sorteioId" value="{{ $sorteio->id }}">
                                                <div class="row">
                                                    <div class="col-md-5" style="float: right;">

                                                        <img src="https://app.comprabakana.com.br{{ $sorteio->image }}" alt="Image"
                                                        width="160" style="border-radius: 0.275rem;">
                                                    <img class="slider-preview-image hidden" style="border-radius: 0.275rem;" />
    
                                                        
                                                    </div>
                                                    <div class="col-md-7" style="padding: 20px;" style="float: right;">
    
                                                        <br>
                                                        <span>Clique no botão abaixo para fazer upload de uma imagem ilustrativa do sorteio.</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 20px;">
                                                        <div >
                                                            
                                                            <input type="hidden" name="old_image" value="{{ $sorteio->image }}">
                                                            <input  type="file" class="form-control image"
                                                                name="image"  parsley-trigger="change" id="image"
                                                               accept="image/x-png,image/gif,image/jpeg"
                                                                onchange="readURL(this);">
    
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                            
                                                <div class="form-group col-md-12 mt-40" >
                                                    <label for="name"><span class="text-danger"></span>Título:</label>
                                                      <div class="input-group input-group-merge">
                                                        <input 
                                                        type="text" 
                                                        class="form-control form-control-lg" 
                                                        name="name"
                                                        placeholder="" 
                                                        value="{{ $sorteio->name }}"  
                                                        required>
                                                    </div> 
                                                </div>
    
                                                <div class="form-group col-md-12" >
                                                    <label for="description"><span class="text-danger"></span>Descrição:</label>
                                                      <div class="input-group input-group-merge">
                                                        <textarea 
                                                        type="text" 
                                                        class="form-control form-control-lg" 
                                                        name="description"
                                                        placeholder=""   
                                                        required>{{ $sorteio->description }} </textarea>
                                                    </div> 
                                                </div>
                                                
                                                    
                                                
                                            <div class="row col-md-12">
                                                <div class="form-group col-md-6" style="padding-left: 0px;">
                                                    <label for="expiry_date"><span class="text-danger"></span>Data do Sorteio:</label>
                                                        <input type="date" class="form-control form-control-lg" name="expiry_date"
                                                         placeholder=""  value="{{ date("Y-m-d", strtotime($sorteio->expiry_date)) }}"   required>
                                                </div>
                                                <div class="form-group col-md-6" style="padding-right: 0px;">
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
                                                        value="{{ $sorteio->min_subtotal }}"  
                                                        required>
                                                    </div> 
                                                </div>
    
                                            </div> 
                                                
                                                        
                                              
        
                                               
                                                
        
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
        
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Como Funcionam os Sorteios?</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl15 pr15">
                                                
                                                <div class="col-md-12">
                                                    <div class='' style="text-align: center;" >
                                                        <br>  
                                                        <img class="light" style="width: 170px;" src="https://app.comprabakana.com.br/assets/img/sorteios.png" alt="">
                                                        <br><br>     
                                                    </div>
                                                <p><span>Você pode criar quantos sorteios quiser, e poderão concorrer a eles, quem fizer alguma compra em sua loja pelo aplicativo. A cada compra, o usuário ganha um novo cupom para o sorteio (de acordo com o valor mínimo de compra)  </span></p>
                                            <p><strong>Exemplos:</strong></p>
                                            <p>1) Sorteios de Vale-Compras;</p>
                                            <p>2) Sorteios de produtos da loja;</p>
                                            <p>3) Sorteios algum prêmio (Ex: Smartphone, fogão, geladeira, etc.)</p>
                                            
                                            <p></p>
                                            <p> Você pode ainda limitar o valor mínimo de compra, para que o usuário possa ganhar um cupom para o sorteio.</p>
                                            <p></p>
                                            <p>O sorteio será realizado de forma automática pelo sistema Compra Bakana às 23:59 na data prevista para o sorteio, a partir de um sistema seguro que gera números aleatórios, e realiza o sorteio baseado no número de cupons que cada cliente tem durante o período do sorteio.</p>
                                           
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





   
    });
</script>

<script>

function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.slider-preview-image')
                    .removeClass('hidden')
                    .attr('src', e.target.result)
                    .width(120)
                    .height(120);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

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


