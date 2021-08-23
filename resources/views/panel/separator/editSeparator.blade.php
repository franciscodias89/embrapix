@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('styles')
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">

<style>
  .card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}
	.fileuploader {
                max-width: 560px;
            }
	.fileuploader-items .fileuploader-item .column-thumbnail {
    position: relative;
    width: 90px;
    height: 90px;
    }
    label {
    /* text-transform: capitalize; */
    font-size: 14px;
    line-height: 1.8571428571;
    font-weight: 500;
    margin-bottom: 8px;
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
                            <h4 class="breadcrumb-title">Editando o Usuário:  {{ $separator->name }}</h4>
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
                                    <a href="{{ route('panel.separators') }}"
                                        class="btn btn-default btn-white " data-popup="tooltip"
                                        title="" data-placement="bottom">
                                    <b><i class="la la-arrow-left"></i></b>
                                    Voltar
                                    </a>
                                   
                                </div>

                                @csrf
                            <div class="text-right" style="margin-left:20px">
                                <button type="submit" form="flyer" class="btn btn-primary">
                                Salvar Usuário
                                    <i class="icon-database-insert ml-1"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12">
                        <form action="{{ route('panel.updateSeparator') }}" method="POST" id="flyer" enctype="multipart/form-data"> 
                            <div class="card">
                                <div class="card-body ">
                                            <div class="col-md-6" style="padding-left: 0px; float: left;" > 
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais</h5>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="card-body pl15 pr15">
                                                        <input type="hidden" name="id" id="flyerId" value="{{ $separator->id }}">
                                                       
                                                        <div class="card-body pl15 pr15">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Nome do Funcionário</label>
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="icon-dual" data-feather="user"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text"
                                                                        required name="name" 
                                                                        class="form-control " id="validationDefault01"
                                                                        id="name" placeholder="Nome Completo" 
                                                                        parsley-trigger="change" 
                                                                        value="{{ $separator->name }}"
                                                                        data-parsley-error-message="Favor inserir o  Nome Completo" 
                                                                        data-parsley-errors-container="#parsley-name"/>
                                                                    
                                                                    @if($errors->has('name'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div id="parsley-name"></div>
                                                            </div>
                                                            <div class="form-group mb-20">
                                                                <label class="form-control-label">Email</label>
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="icon-dual" data-feather="mail"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="email"
                                                                        required name="email" value="{{ old('email')}}"
                                                                        class="form-control @if($errors->has('email')) is-invalid @endif"
                                                                        id="email" placeholder="exemplo@dominio.com" 
                                                                        value="{{ $separator->email }}"
                                                                        data-parsley-errors-container="#parsley-email"/>
                        
                                                                    @if($errors->has('email'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('email') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div id="parsley-email"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-control-label">Telefone (Whatsapp)</label>
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="icon-dual" data-feather="phone"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="phone"
                                                                        required name="phone" 
                                                                        class="form-control phone"
                                                                        id="phone" placeholder="Ex: (99) 99999-9999" 
                                                                        parsley-trigger="change"
                                                                    value="{{ $separator->phone }}"
                                                                        data-parsley-errors-container="#parsley-phone"
                                                                        />
                        
                                                                    @if($errors->has('phone'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div id="parsley-phone"></div>
                                                            </div>
                    
                                                          
                    
                                                            <div class="form-group mb-15">
                                                                <label class="form-control-label">Senha</label>
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="icon-dual" data-feather="lock"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="password"
                                                                         name="password"
                                                                        class="form-control @if($errors->has('password')) is-invalid @endif"
                                                                        id="password" placeholder="Crie uma Senha" 
                                                                        parsley-trigger="change"
                                                                        data-parsley-minlength="8" 
                                                                        data-parsley-uppercase="1"
                                                                        data-parsley-uppercase-message="Sua senha precisa ter pelo menos %s letra maiúscula"
                                                                        data-parsley-lowercase="1"
                                                                        data-parsley-lowercase-message="Sua senha precisa ter pelo menos %s letra minúscula"
                                                                        data-parsley-number="1"
                                                                        data-parsley-number-message="Sua senha precisa ter pelo menos %s número"
                                                                        data-parsley-errors-container="#parsley-password"
                                                                        />
                        
                                                                    @if($errors->has('password'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('password') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div id="parsley-password"></div>
                                                            </div>
                                                           
                    
                                                            <div class="form-group mb-15">
                                                                <label class="form-control-label">Confirmar Senha</label>
                                                                <div class="input-group input-group-merge">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="icon-dual" data-feather="lock"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="password"
                                                                         name="confirm_password"
                                                                        class="form-control @if($errors->has('confirm_password')) is-invalid @endif"
                                                                        id="confirm_password" placeholder="Confirme sua Senha" 
                                                                        parsley-trigger="change"
                                                                        data-parsley-minlength="8" 
                                                                        data-parsley-equalto-message="As senhas não conferem"
                                                                        data-parsley-equalto="#password"
                                                                        data-parsley-minlength-message="Sua senha precisa ter pelo menos 8 caracteres" 
                                                                        
                                                                        data-parsley-errors-container="#parsley-confirm_password"/>
                        
                                                                    @if($errors->has('confirm_password'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div id="parsley-confirm_password"></div>
                                                            </div>
                                                    
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-6" style="padding-left: 0px; float: left;">
                                                
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Foto</h5>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="card-body pl15 pr15">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                <div class="form-group">
                                                                </div>
                                                                </div>

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
<script src="https://app.comprabakana.com.br/assets/fileuploader/examples/sorter/default/js/custom.js" type="text/javascript"></script>
<script src="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>



   
   $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    });   

    $("#select2").change(function() {
  $("#select2").trigger('input')
});

     $('#addDiscountedPrice').click(function(event) {
                            let price = $('#oldSP').val();
                            $('#newSP').val(price).attr('required', 'required');;
                            $('#singlePrice').remove();
                            $('#discountedTwoPrice').show();
     });

     function formatState(state) {
			if (!state.id) {
				return state.text;
			}
			var baseUrl = "https://painel.comprabakana.com.br/user/pages/images/flags";
			var $state = $(
				'<span><img src="' + state.media + '" class="img-flag" /> ' + state.text + '</span>'
			);
			return $state;
		};


    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.slider-preview-image')
                    .removeClass('hidden')
                    .attr('src', e.target.result);



            };
            //ocument.getElementsByClassName(".slider-preview-image").style.objectFit = "cover";
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function () {
        
        
        $('.select').select2();
    
       
       
       
       
       
        //Switch Action Function  
         var elems = document.querySelectorAll('.action-switch');
         for (var i = 0; i < elems.length; i++) {
             var switchery = new Switchery(elems[i], { color: '#8360c3' });
         }
         var elemsmb = document.querySelectorAll('.action-switch-mobile');
         for (var i = 0; i < elemsmb.length; i++) {
             var switchery = new Switchery(elemsmb[i], { color: '#8360c3' });
         }     

         $('.action-switch, .action-switch-mobile').click(function(event) {
           console.log("Clicked");
            let id = $(this).attr("data-id")
            let url = "{{ url('/store-owner/item/disable/') }}/"+id;
            let self = $(this);
           $.ajax({
               url: url,
               type: 'GET',
               dataType: 'JSON',
           })
           .done(function(data) {
               console.log(data);
               console.log(self);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Operação Realizada com Sucesso ✅',
                   theme: 'bg-success',
                   life: '1800'
               }); 
           })
           .fail(function(data) {
               console.log(data);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Alguma coisa deu errado. Por favor, tente novamente!',
                   theme: 'bg-danger',
                   life: '1800'
               }); 
           })            
         });
    });
</script>
@endsection


