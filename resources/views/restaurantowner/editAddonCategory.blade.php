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
                            <h4 class="breadcrumb-title">Editando o Grupo de Adicionais:  {{ $addonCategory->name }}</h4>
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
                                Salvar Grupo
                                    <i class="icon-database-insert ml-1"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>

                    
                    

                    <div class="col-md-12">
                        <form action="{{ route('restaurant.updateAddonCategory') }}" id="editaddon" method="POST" enctype="multipart/form-data"> 
                            <div class="card">
                                <div class="card-body ">
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Dados Gerais</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl30 pr30">
                                                <div class="form-group row" style="margin-left: 15px;"> 
                                                    <div class="custom-control custom-switch switch-primary switch-md ">
                                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                                        <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Grupo de Adicionais Ativo</label>
                                                        <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Grupo de Adicionais Desativado</label>
                                                     </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{ $addonCategory->id }}">
                                                <div class="form-group row" >
                                                    <label for="name"><span class="text-danger">*</span>Nome</label>
                                                    <input required type="text" class="form-control name" name="name"
                                                        id="name" parsley-trigger="change"  value="{{ $addonCategory->name }}" data-parsley-group="form-step-1" 
                                                        placeholder="Nome do Grupo de Adicionais">
                                                </div>
                                                <div class="form-group row" >
                                                    <label for="name"><span class="text-danger">*</span>Tipo</label>
                                                    <i class="fas fa-question-circle" 
                                                    style="margin-left: 5px"  
                                                    tabindex="-1" 
                                                    data-trigger="hover"
                                                    data-html="true"  
                                                    data-toggle="popover" 
                                                    title="Tipo de Opção"  
                                                    data-content="Se for <strong>Única Escolha</strong>, o usuário só poderá escolher uma opção.
                                                    Se for <strong>Múltipla Escolha</strong>, o usuário poderá escolher mais de uma opção"
                                                    ></i>
        
                                                    <div class="radio-theme-default custom-radio " style="margin-left:20px" >
                                                        <input class="radio type" type="radio" name="type" value="SINGLE" id="radio-un2"  <?php if ($addonCategory->type ==='SINGLE') { echo "checked="; }  ?> >
                                                        <label for="radio-un2">
                                                        <span class="radio-text">Única Escolha</span>
                                                        </label>
                                                     </div>
                                                     <div class="radio-theme-default custom-radio" style="margin-left:20px" >
                                                        <input class="radio type" type="radio" name="type" value="MULTI" id="radio-un4" <?php if ($addonCategory->type ==='MULTI') { echo "checked="; }  ?>   >
                                                        <label for="radio-un4">
                                                        <span class="radio-text">Múltipla Escolha</span>
                                                        </label>
                                                     </div>
                                                    
                                                        
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <label for="name"><span class="text-danger">*</span>Descrição</label>
                                                    
                                                        <input type="text" class="form-control form-control-lg" name="description"
                                                            placeholder="Pequena Descrição (60 caracteres)"  value="{{ $addonCategory->description }}" data-parsley-maxlength="50" required>
                                                            <span class="small" > Essa descrição aparecerá no aplicativo, quando o usuário selecionar os grupos de adicionais</span>
                                                    
                                                </div>
                            
                                                                                                                             
        
                                                
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
        
                                    <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Opções</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl15 pr15">
                                                <div id="addon" class="mt-4">
                                                    <legend class="font-weight-semibold text-uppercase font-size-sm hidden" id="addonsLegend">
                                                        
                                                    </legend>
                                                </div>

        
                                                <div>
                                                    <span class="small" >Se selecionou "Única Opção, coloque pelo menos uma opção com valor R$ 0,00"</span>
                                                    <br><br>
                                                </div>
                                                @foreach ($addons as $addon)
                                                <div class='form-group row'> 
                                                    <div class='col-lg-5'>
                                                    <input type="text" hidden name="addon_old[{{$loop->index}}][id]" value="{{$addon->id}}">
                                                        <input type='text' class='form-control clock form-control-lg'  value="{{ $addon->name }}" name="addon_old[{{$loop->index}}][name]" placeholder="Nome"> 
                                                    </div> 
                                                    <div  class='col-lg-5'>
                                                        <input type='text' class='form-control clock form-control-lg dinheiro' value="{{ $addon->price }}" name="addon_old[{{$loop->index}}][price]" placeholder="Preço"> 
                                                    </div> 
                                                   {{--  <div class='col-lg-1'> 
                                                        <div class="checkbox checkbox-switchery ml-1" style="padding-top: 0.8rem;">
                                                            <label>
                                                            <input value="true" type="checkbox" class="action-switch"
                                                            @if($addon->is_active) checked="checked" @endif data-id="{{ $addon->id }}">
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                                    <div class='col-lg-1'> 
                                                    <div class='btn btn-danger' data-popup='tooltip' data-placement='right' onclick="del({{$addon->id}})" style="padding:5px" title='Excluir Item'><i class='la la-trash-alt'></i></div>
                                                    
                                                </div>
                                                    
                                                </div>
                                                @endforeach
                                                <div id="addon" class="timeSlots">
                                                </div>
                                                
                                                <a href="javascript:void(0)" onclick="add(this)" class="btn btn-primary"> <b><i class="icon-plus22"></i></b>Adicionar Opção</a>
                           
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
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="userDatatable orderDatatable global-shadow border py-30 px-sm-30 px-20 bg-white radius-xl w-100 mb-30">
                        <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                            {{-- <div class="d-flex align-items-center flex-wrap justify-content-center"> --}}
                                <div class="d-flex align-items-center flex-wrap justify-content-center">
                                    {{-- <div class="project-search order-search  global-shadow mt-10">
                                        <form action="/" class="order-search__form">
                                            <span data-feather="search"></span>
                                            <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                                        </form>
                                    </div><!-- End: .project-search --> --}}
                                {{--     <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
                                        <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                        <div class="project-tap order-project-tap global-shadow">
                                            <ul class="nav px-1" id="ap-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="ap-overview-tab" data-toggle="pill" href="#ap-overview" role="tab" aria-controls="ap-overview" aria-selected="true">Todos</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="timeline-tab" data-toggle="pill" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Ativos</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Vencidos
                                                        </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="draft-tab" data-toggle="pill" href="#draft" role="tab" aria-controls="draft" aria-selected="false">Futuros</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- End: .project-category --> --}}
                                </div><!-- End: .d-flex -->
                            
                                <div class="content-center mt-10">
                                    <div class="button-group m-0 mb-30 mt-xl-0 mt-sm-10 order-button-group">
                                        {{-- <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md">Export</button> --}}
                                       
                                         <button type="button" class="btn btn-primary" id="NewItemCategory"
                                        data-toggle="modal" data-target="#addNewItemCategory">
                                        <b><i class="icon-plus2"></i></b>
                                        Adicionar Opção</button>
                                    </div>
                                </div><!-- End: .content-center -->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover table-borderless border-0"  id="itemsDataTable" >
                                        <thead>
                                        <tr class="userDatatable-header">
                                            
                                            <th><span class="userDatatable-title">Título</span></th>
                                            <th><span class="userDatatable-title">Descrição</span></th>
                                            <th><span class="userDatatable-title">Preço</span></th>
                                            
                                            <th class="text-center" style="width: 10%;"><i class="
                                                icon-circle-down2"></i><span class="userDatatable-title">Ações</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($addons as $addon)
                                                <tr class="item">
                                                    <td style="white-space:normal;">
                                                        <div class="orderDatatable-title">{{ $addon->name }}
                                                        </div>
                                                    </td>
                                                    <td style="white-space:normal;">
                                                        <div class="orderDatatable-title">{{ $addon->description }}
                                                        </div>
                                                    </td>
                                                    <td style="white-space:normal;">
                                                        <div class="orderDatatable-title">{{ $addon->price }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                        
                                                            @if(Request::is('store-owner/coupons/deleted'))
                                                            <li>
                                                                <a href="{{ route('panel.restoreCoupon', $addon->id) }}" title="Restaurar" class="edit">
                                                                    <span data-feather="rotate-ccw" ></span></a>
                                                            </li>
                                                            @else
                                                            <li>
                                                                <a href="javascript:void(0)" title="Editar" class="edit editItemCategory" data-toggle="modal" data-target="#editItemCategory" data-catid="{{ $addon->id }}" data-catprice="{{ str_replace(".",",",$addon->price) }}" data-catdescription="{{ $addon->description }}"data-catname="{{ $addon->name }}"  >
                                                                    <span data-feather="edit"></span></a>

                                                                    
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('panel.deleteCoupon', $addon->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este item?')" class="remove">
                                                                    <span data-feather="trash-2" ></span></a>
                                                            </li>
                                                            @endif
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


                            
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addNewItemCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">{{__('storeDashboard.mcpModalTitle')}}</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.createAddon') }}" method="POST">
                    <div class="form-group row">
                        <label for="name">Título:</label>
                        
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Digite o Nome da Opção" required id="itemCatName">
                        
                    </div>
                    <div class="form-group row">
                        <label for="description">Descrição:</label>
                        
                            <input type="text" class="form-control form-control-lg" name="description"
                                placeholder="Descrição (opcional)" id="itemCatDescription">
                        
                    </div>
                    <div class="form-group row">
                        <label for="price">Preço:</label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    R$
                                </span>
                            </div>
                            <input type="text" class="form-control form-control-lg dinheiro" name="price"
                                placeholder="Preço" required id="itemCatPrice">
                        </div>  
                        
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Salvar
                        
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="editItemCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Editar Opção</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.updateAddon') }}" method="POST">
                    <input type="hidden" name="id" id="itemCatId">
                    <div class="form-group row">
                        <label for="name">Título:</label>
                        
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Digite o Nome da Opção" required id="itemCatName">
                        
                    </div>
                    <div class="form-group row">
                        <label for="description">Descrição:</label>
                        
                            <input type="text" class="form-control form-control-lg" name="description"
                                placeholder="Descrição (opcional)" id="itemCatDescription">
                        
                    </div>
                    <div class="form-group row">
                        <label for="price">Preço:</label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    R$
                                </span>
                            </div>
                            <input type="text" class="form-control form-control-lg dinheiro" name="price"
                                placeholder="Preço" required id="itemCatPrice">
                        </div>  
                        
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Salvar
                        <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>     



@endsection
@section('scripts')
<script>
    $(function() {
            $('.editItemCategory').click(function(event) {
                $('#itemCatId').val($(this).data("catid"));
                $('#itemCatName').val($(this).data("catname"));
                $('#itemCatDescription').val($(this).data("catdescription"));
                $('#itemCatPrice').val($(this).data("catprice"));
            });
           
        });
    </script>

<script>

    $(function () {
      $('[data-toggle="popover"]').popover()
    })
    
    
    
      $(function () {
    
        $("#select_addon").select2({
            placeholder: "Selecione uma Opção...",
            dropdownCssClass: "tag",
            
            allowClear: true,
        });
    
        $(".dinheiro").mask('#.##0,00', {
                reverse: true
            });
    
        
            
        });
    
        
        $(document).ready(function() {
             
            
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
     
    
    
        function del(id) {
          var r = confirm("Deseja realmente excluir este item?");
          if (r == true) {
            let url = "{{ url('store-owner/addon/delete/') }}/"+id;
            window.location.href = url;
          }
        }

        $(function() {

         $('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });

         //Switch Action Function
         if (Array.prototype.forEach) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.action-switch'));
                elems.forEach(function(html) {
                    var switchery = new Switchery(html, { color: '#8360c3' });
                });
            }
            else {
                var elems = document.querySelectorAll('.action-switch');
                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i], { color: '#8360c3' });
                }
            }

          $('.action-switch').click(function(event) {
             let id = $(this).attr("data-id")
             let url = "{{ url('/store-owner/addon/disable/') }}/"+id;
             window.location.href = url;
          });

      
          

         
      }); 
    
                  
    
    
    </script>
@endsection


