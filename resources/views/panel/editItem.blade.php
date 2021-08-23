@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
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

     .form-group label {
    /* text-transform: capitalize; */
    font-size: 14px;
    line-height: 1.8571428571;
    font-weight: 500;
    margin-bottom: 8px;
    color: #272b41;
}

.color-dark, .contact-card .cp-info__title, .contact-list .contact-item .contact_title a, .add-contact .add-new-contact label, .mailbox-list__single:hover .time-meta, .mailbox-list__single:hover .mail-content__top .mail-title a, .mailbox-list__single:hover .mail-authorBox .auhor-info .author-name, .task-modal .modal-header h5, .task-card__header .custom-checkbox input[type=checkbox] + label, .task-card .card-header, .kanban-modal__research h6, .kanban-modal__form label, .kanban-modal__header .modal-title, .kanban-list .list-title, .kb__categories li p, .post-pagination p a, .knowledgebase-adv__card .knowledgebase__list li a, .knowledgebase-adv__card .knowledgebase__list li .knowledgebase__list-collapsed, .knowledgebase__more a, .fileM-card .fileM-excerpt, .fileM-wrapper__title, .fileM-sidebar .fileM-types .sidebar__menu-group ul.sidebar_nav li.menu-title span, .testimonial-slider-global .author-thumb p, .changelog-history__title, .v-num, .counting-area .number, .ai-list-item span.active, .application-faqs .panel-title a, .gc__title p, .search-content .keyword-searching, .icon-list i, .icon-list svg, .add-product-status-radio .custom-radio input[type=radio]:checked + label, .upload-media-area__title p, .file-upload__label:hover, .file-upload__label, .add-product__body .form-group label, .table5 .pagination-total-text, table.table-rounded tr th, table.table-rounded tr td, table.table-basic tr td, .orderDatatable-title, .payment-invoice-table.userDatatable table thead tr th, .payment-invoice-qr__address p, .payment-invoice-qr__code p, .payment-invoice-qr__number p, .payment-invoice-qr__number .display-3, .payment-invoice-address__area address, .payment-invoice-logo span, .crc__method, .check-review__contact p, .payment-method-paypal .form-control, .payment-method-card .card-body label, .wizard9 .checkout-progress2 .step.completed span:last-child, .wizard9 .checkout-progress2 .step.current span:last-child, .wizard10 .payment-method-card .select2-container .select2-selection--single .select2-selection__rendered, .wizard10 .payment-method-card .select2-container--default .select2-selection--single .select2-selection__placeholder, .wizard10 .select2-container .select2-selection--single .select2-selection__rendered, .wizard10 .select2-container--default .select2-selection--single .select2-selection__placeholder, .wizard10 .checkout-progress3 .step span:first-child, .checkout-progress div.step.completed span:nth-of-type(2), .checkout-progress div.step.current span:nth-of-type(2), .checkout-progress div.step, .order-summery .total > div span, .Product-cart-title .media p, .product-cart__header th, .quantity .input, .product-details .product-details-brandName span, .product-details__availability .title p, #price-range .price-value, .stars-rating__point, .product-item__body .card-title a, .e-info-modal .e-info-list li .list-line .list-meta, .c-event-dialog .modal-header .modal-title, .fc-listMonth-view .fc-list-day th, #full-calendar .fc-toolbar-chunk .fc-toolbar-title, .date-picker__calendar .ui-datepicker-header .ui-datepicker-title span, .drag-drop-wrap .item_title h6 a, .atbd-tab .nav-link, .atbd-drawer .profile-info__label, .area-drawer-wrapper h1, .area-drawer-wrapper h2, .area-drawer-wrapper h3, .area-drawer-wrapper h4, .area-drawer-wrapper h5, .area-drawer-wrapper h6, .atbd-drawer__body p, .atbd-drawer__header .drawer-title, .page-info__single span, .page-title__left .title-text, .statistics-countdown__time, .statistics-item__number, .atbd-steps__text, .atbd-pop-message__text p, .atbd-submenu li a, .atbd-submenu .submenu-title, .timeline-box--3.basic-timeline .timeline li .timeline-single .timeline-single__days span, .form-basic label, .new-member-modal .form-group label, .userDatatable-inline-title h6, .userDatatable-content, .media-ui .user-group-progress-top p, .user-social-profile .edit-profile__body label, .users-list-body__title span span, .atbd-notice__content .notice-list__text, .signUp-admin-right .card .card-header h6, .edit-profile__body .form-group label, .ap-product .table thead tr th, .sales-target__progress-bar .total-count, .crm .table-selling-content .title, .crm .deals-table-wrap .table--default td, .revenue-chart-box__data, .revenue-chart-legend__data span, .device-pieChart-wrap .pie-chart-legend span, .atbd-empty__text, .atbd-notification-box__close svg, .atbd-notification-box__close img, .atbd-comment-box__content .cci__author-info, .badge.badge-transparent.badge-danger, .dynamic-badge-block .atbd-button-group .btn-icon svg, .strikingDash-top-menu > ul > li .megaMenu-wrapper.megaMenu-wide > li .mega-title, .daterangepicker.single .calendar-table tbody td, .customizer__title, .chartjs-tooltip table tbody td, .atbd-message {
    color: #272b41;
}

label.cabinet{
	display: block;
	cursor: pointer;
}

label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
	width: 300px;
	height: 300px;
  padding-bottom:25px;
  background: white;
}

.cropp {
    /* position: absolute; */
    -webkit-box-flex: 1;
    align-items: center;
    text-align: center;
    align-content: center;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 3.5rem;
    background: #78818a;
}
figure {
    margin: 0 0 1rem;
    max-width: 200px;
}

</style>

@endsection
@section('content')
<?php include_once base_path('assets/fileuploader/src/php/class.fileuploader.php'); ?>
                    <?php
                    $enabled = true;
                    $uploadDir = base_path('');
                    
                    //$uploadDir2 = '../..';
                    $uploadDir2 = base_path('');
                    $uploadDir3 = base_path('assets/img/items/');
                    if (!empty($result)) {
                    $default_avatar = '/assets/default-logo.png';
                    } else {
                    $default_avatar = '/assets/default-logo.png';
                    }
                    
                    
                    $media = array();
                    if (!empty($item)) {
                    $ids = $item->id;
                    $ids_encarte = $ids;
                    $media = json_decode($item->image);
                    //$start_date = ($flyer->start_date);
                    //$start_date = date("d/m/Y H:i", strtotime($start_date));
                   // $end_date = ($flyer->end_date);
                   // $end_date = date("d/m/Y H:i", strtotime($end_date));
                    }
                    
                    
                    $preloadedFiles='';
                    $preloadedFiles2='';
                    if($ids){
                    // scan uploads directory
                    $preloadedFiles = array();
                    $preloadedFiles2 = array();
                    $uploadsFiles = $item->image;//array_diff(scandir($uploadDir), array('.', '..'));
                    //$uploadsFiles=json_decode($uploadsFiles1);
                    // add files to our array with
                    // made to use the correct structure of a file
                    if($uploadsFiles){
                    //foreach ($uploadsFiles as $file) {
                    // skip if directory
                    //if (is_dir($uploadDir . $file))
                    //continue;
                    // add file to our array
                    // !important please follow the structure below

                    if (strpos($uploadsFiles, 'http') !== false) {
			
                        $preloadedFiles[] = array(
                    "name" => $uploadsFiles,
                    "type" => FileUploader::mime_content_type($uploadsFiles),
                    "size" => '',//filesize($uploadDir . $uploadsFiles),
                    "file" =>  $uploadsFiles.'?t='.time(),
                    "local" =>   $uploadsFiles,//.'?t='.time(), // same as in form_upload.php
                    "data" => array(
                    "url" =>  $uploadsFiles,//.'?t='.time(), // (optional)
                    //"thumbnail" => $uploadDir2 . $file.'?t='.time(), // (optional)
                    //"readerForce" => true, // (optional) prevent browser cache
                    
                    ),
                    
                    );
        }else{
            $preloadedFiles[] = array(
                    "name" => $uploadsFiles,
                    "type" => FileUploader::mime_content_type($uploadDir2 . $uploadsFiles),
                    "size" => filesize($uploadDir . $uploadsFiles),
                    //"file" => $uploadDir . $uploadsFiles.'?t='.time(),
                    "file" => 'https://app.comprabakana.com.br' . $uploadsFiles.'?t='.time(),
                    "local" =>  $uploadDir2 . $uploadsFiles,//.'?t='.time(), // same as in form_upload.php
                    "data" => array(
                    "url" => $uploadDir2 . $uploadsFiles,//.'?t='.time(), // (optional)
                    //"thumbnail" => $uploadDir2 . $file.'?t='.time(), // (optional)
                    //"readerForce" => true, // (optional) prevent browser cache
                    ),
                    );
        }
    
                    //var_dump($preloadedFiles);
                    //}
                    
                    }
                    // convert our array into json string
                    $preloadedFiles = json_encode($preloadedFiles);
                    //var_dump($preloadedFiles);
                    }
                    //var_dump($preloadedFiles);
                   // dd($preloadedFiles);
                    ?>


 
 <div class="contents">
    <div class="atbd-page-content">
        <div class="container-fluid">
            <div class="note-wrapper">
                <form action="{{ route('panel.updateItem') }}" method="POST" enctype="multipart/form-data" data-parsley-trigger="keyup" data-parsley-validate>

                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div class="breadcrumb-main">
                            <h4 class="breadcrumb-title">Editando o Produto:  {{ $item->name }}</h4>
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
                                <div class="text-right" >
                                    @if($restaurant->business_type==1)
                                    <a href="{{ route('panel.itemsCardapio') }}"
                                        class="btn btn-default btn-white " data-popup="tooltip"
                                        title="" data-placement="bottom">
                                    <b><i class="la la-arrow-left"></i></b>
                                    Voltar
                                    </a>
                                    @else
                                    <a href="{{ route('panel.items') }}"
                                    class="btn btn-default btn-white " data-popup="tooltip"
                                    title="" data-placement="bottom">
                                <b><i class="la la-arrow-left"></i></b>
                                Voltar
                                </a>

                                    @endif
                                   
                                </div>

                                @csrf
                            <div class="text-right" style="margin-left:20px">
                                <button type="submit" class="btn btn-primary">
                                Salvar Produto
                                    <i class="icon-database-insert ml-1"></i></button>
                            </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                    
                           
                                <div class="card">
                                    <div class="card-body ">
                                <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="" aria-hidden="true"></i> <h5>Informações Gerais do Produto</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            <div class="form-group row" style="margin-left: 15px;"> 
                                                <div class="custom-control custom-switch switch-primary switch-md ">
                                                   
                                                    <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" @if($item->is_active) checked="checked" @endif>
                                                    

                                                    <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Produto Ativo</label>
                                                    <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Produto Desativado</label>
                                                 </div>
                                                </div>
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="restaurant_id" value="{{ $item->restaurant_id }}">
                                            <div class="form-group col-md-6"
                                                style="padding-left: 0px; float: left;">
                                                <label for="ean"><span class="text-danger"></span>Cód. Barras (EAN) (Opcional)</label>
                                                <input 
                                                
                                                type="text" 
                                                class="form-control ean" 
                                                name="ean"
                                                id="ean"
                                                parsley-trigger="change"  
                                                data-parsley-group="form-step-1" 
                                                placeholder="Cód. Barras (EAN) (Opcional)" 
                                                value="{{ $item->ean }}"
                                               >
    
                                                    
                                             </div>
                                             <div class="form-group col-md-6"
                                                    style="padding-left: 0px; float: left;">
                                                    <label for="codint">Código Interno (opcional)</label>
                                                 <input type="text" class="form-control codint" name="codint"
                                                    id="codint" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                    placeholder="Código Interno" value="{{ $item->codint }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="name"><span class="text-danger">*</span>Nome</label>
                                                <input required type="text" class="form-control name" name="name"
                                                    id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                    placeholder="Nome do Produto" value="{{ $item->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="desc">Descrição (opcional)</label>
                                                <textarea  type="text" class="form-control"
                                                    name="desc" id="desc" rows="4" data-parsley-group="form-step-1" parsley-trigger="change"
                                                    placeholder="Descrição do Produto"> {{ $item->desc }}</textarea>
                                            </div>
    
                                            <div class="form-group col-md-6"
                                            style="padding-left: 0px; float: left;">
                                                <div class="">
                                                <label><span class="text-danger">*</span>Categoria do Produto: </label>
                                                <select class="js-example-placeholder-single js-states" name="item_category_id" id="item_category_id" required>
                                                    @foreach ($itemCategories as $itemCategory)
                                                    <option value="{{ $itemCategory->id }}" class="text-capitalize" @if($item->item_category_id == $itemCategory->id) selected="selected" @endif >
                                                        {{ $itemCategory->name }}</option>
                                                    @endforeach
                                                </select>
                                              
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6" style="padding-left: 0px; float: left;">
                                                <label class="">Grupos de Opções (opcional):</label>
                                                <div class="skillsOption">
                                                    <select multiple="multiple" class="js-example-basic-single js-states form-control" 
                                                    data-plugin="customselect" data-fouc
                                                        name="addon_category_item[]" id="select_addon">
                                                        @foreach($addonCategories as $addonCategory)
                                                        @if($addonCategory->is_deleted==0)
                                                        <option value="{{ $addonCategory->id }}" class="text-capitalize" {{isset($item) &&  in_array($item->id, $addonCategory->items()->pluck('item_id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6" style="padding-left: 0px; float: left;">
                                    <div class="users">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagem</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl15 pr15">
                                                
                                                    {{-- <div class="col-md-7" style="padding: 20px;" style="float: right;">
                                                        <br>
                                                        <span>Clique no botão abaixo para fazer upload da imagem</span>
                                                    </div> --}}

                                                    <label class="cabinet center-block">
                                                        <figure>
                                                            <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                                          <figcaption><i class="fa fa-camera" style="font-size: x-large;"></i></figcaption>
                                                    </figure>
                                                        <input type="file" class="item-img file center-block" name="file"/>
                                                        <input type="text" hidden name="file_output" id="file_output"/>
                                                        <input type="text" hidden name="imagem_banco" id="imagem_banco"/>
                                                    </label>
                                                </div>
    
                                                                                          
    
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="users">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <i class="" aria-hidden="true"></i> <h5>Preço e Oferta</h5>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="card-body pl15 pr15">

                                                
                                                @if($item->product_variable!=1)
                                                <div class="form-group row" id="normal_price">
                                                    <div  class="col-lg-6">
                                                            <label><span class="text-danger">*</span>Preço Normal: <i class="icon-question3 ml-1"
                                                                    data-popup="tooltip" title="{{__('storeDashboard.ipmMarkPriceToolTip')}}"
                                                                    data-placement="top"></i></label>
                                                                    <div class="input-group input-group-merge">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                R$
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control dinheiro" 
                                                                            name="old_price"
                                                                            id="old_price"
                                                                            value="{{ $item->old_price }}"
                                                                            placeholder="Preço Normal"
                                                                            data-parsley-required-message="Este campo é obrigatório" 
                                                                            data-parsley-gt2-message="O preço sem desconto deve ser maior do que o preço com desconto" 
                                                                        >
                                                                    </div>
                                                            
                                                    </div>
                                                    <div  class="col-lg-6">
                                                        <label>Preço Oferta (opcional):</label>
                                                        <div class="input-group input-group-merge preco_oferta">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    R$
                                                                </span>
                                                            </div>
                                                            <input type="text" 
                                                            class="form-control dinheiro" 
                                                            name="price"
                                                            placeholder="Preço Oferta" 
                                                            id="price_offer"
                                                            @if($item->price != null)
                                                            value="{{ $item->price }}"
                                                            @endif
                                                            data-parsley-lt2-message="O preço com desconto deve ser menor do que o preço sem desconto" 
                                                            >
                                                        </div>

                                                        
                                                        
                                                    </div>
                                                </div>
                                                @endif
                                                @if($item->product_variable==1)
                                                <div class="form-group" id="variable_price" >
                                                    
                                                    <input hidden value="on" name="is_product_variable">
                                                        
                                                    <div>
                                                        <span class="small" >Utilize essa opção para adicionar variações de preços para este produto. (Ex: Tamanho P, Tamanho M, Tamanho G, etc)</span>
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
                                                    <div id="addon" class="mt-4">
                                                        <legend class="font-weight-semibold text-uppercase font-size-sm hidden" id="addonsLegend">
                                                        </legend>
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="add_price(this)" class="btn btn-primary"> <b><i class="icon-plus22"></i></b>Adicionar Preço</a>
                                                

                                            </div>
                                            @endif
                                            @if($item->product_variable!=1)
                                                <div id="offer_settings" style="display: none">
                                                    <div class="form-group row" style="margin-left: 15px;"> 
                                                        <div class="custom-control custom-switch switch-primary switch-md ">

                                                            @if ($item->is_offer_notime==1)
                                                            <input type="checkbox" name="is_offer_notime" class="custom-control-input" id="is_offer_notime" checked>
                                                            @else
                                                            <input type="checkbox" name="is_offer_notime" class="custom-control-input" id="is_offer_notime" >
                                                            @endif
                                                            
                                                            <label class="custom-control-label" for="is_offer_notime"> Oferta por tempo indeterminado</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row col-md-12" id="offer_date">
                                                        <div class="form-group col-md-6" style="padding-left: 0px;">
                                                            <label for="start_date">Data Início da Oferta</label>
                                                            <input 
                                                            type="date" 
                                                            class="form-control"
                                                            name="start_date" 
                                                            id="start_date"   
                                                            @if($item->start_date) value="{{ date("Y-m-d", strtotime($item->start_date))  }}" @endif
                                                            parsley-trigger="change"
                                                            >
                                                                
                                                        </div>
                                                        <div class="form-group col-md-6 pr0" style="padding-right: 0px; padding-left: 0px;">
                                                            <label for="end_date">Data Fim da Oferta</label>
                                                            <input 
                                                            type="date" 
                                                            class="form-control"
                                                            name="end_date" 
                                                            id="end_date"
                                                            @if($item->end_date)value="{{ date("Y-m-d", strtotime($item->end_date)) }}" @endif  
                                                            parsley-trigger="change"
                                                            >
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div id="outros">  
            
                                                        <div class="form-group mb-20">
                                                            <label ><span
                                                                class="text-danger">*</span>Preço por:</label>
                                                            <select class="js-example-basic-single js-states form-control"
                                                                name="unidade" id="select-unidade" required>
                                                                
                                                                <option value="un" class="text-capitalize" @if($item->unidade =='un') selected="selected" @endif >Unidade</option>
                                                                <option value="kg" class="text-capitalize" @if($item->unidade =='kg') selected="selected" @endif >Kg</option>
                                                                
                                                            </select>
                                                        </div>

                                                        @if($manage_stock)
                                                        <div class="form-group mb-20">
                                                            
                                                                <label><span class="text-danger"></span>Quantidade em Estoque:</label>
                                                           
                                                                <input type="number" class="form-control" name="estoque"
                                                                    placeholder="Estoque" id="estoque" value="{{ $item->estoque }}"
                                                                    data-parsley-required-message="Este campo é obrigatório" 
                                                                >
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            </div>  
                            
                            
                        
                        </div>
                        <div class="col-md-12">
                            <br>
                            <br>
                        </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
   
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="" id="">
            Editar Imagem</h4>
      </div>
      <div class="modal-body">
<div class="cropp">
      <div id="upload-demo" class="center-block"></div>
        </div>
    </div>
       <div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="button" id="cropImageBtn" class="btn btn-primary">Cortar Imagem</button>
</div>
      </div>
    </div>
  </div>



@endsection
@section('scripts')
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.js" type="text/javascript"></script>
<script src='https://foliotek.github.io/Croppie/croppie.js'></script>
<script>
    var addonNamePlaceholder = "Nome";
    var addonPricePlaceholder = "Preço";
    var addonRemoveTitle = "Remover";

    function add_price(data) {
        //$('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div><div class='form-group row'><div class='col-lg-5'> <input type='text' class='form-control form-control-lg' placeholder='Nome da Variação' name='addon_names[]'' required /></div><div class='col-lg-5'><div class='input-group input-group-merge'><div class='input-group-prepend'> <span class='input-group-text'> R$ </span></div> <input type='text' class='form-control form-control-lg dinheiro' name='addon_prices[]'' placeholder='Preço' required /></div></div><div class='col-lg-2'> <button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' style='padding: 5px;' title='"+addonRemoveTitle+"'><i class='la la-trash-alt'></i></button></div></div><div class='form-group row'><div class='col-lg-10'><input type='text' class='form-control form-control-lg' placeholder='Descrição (opcional)' name='addon_description[]' /></div></div></div>";
        document.getElementById('addon').appendChild(newAddon);
        $(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    }

    $(function() {
        
        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().parent().remove();
        });
    }); 


    $("#is_product_variable").click(function () {
            if ($(this).is(":checked")) {
                $("#normal_price").hide().find("input").prop("required", false);
                $("#variable_price").show();
                $("#offer_settings").hide().find("input").prop("required", false);
                $("#outros").hide().find("input").prop("required", false);
            } else {
                $("#normal_price").show().find("input").prop("required", true);
                $("#variable_price").hide().find("input").prop("required", false);
                $("#offer_settings").show().find("input").prop("required", true);
                $("#outros").show().find("input").prop("required", true);
            }
        });

var is_product_variable= "<?php  echo $item->is_product_variable; ?>";  
if (is_product_variable==1) {
    $("#normal_price").hide().find("input").prop("required", false);
                $("#variable_price").show();
                $("#offer_settings").hide().find("input").prop("required", false);
                $("#outros").hide().find("input").prop("required", false);
}
if (is_product_variable== null) {
    $("#normal_price").show().find("input").prop("required", true);
                $("#variable_price").hide().find("input").prop("required", false);
                $("#offer_settings").show().find("input").prop("required", true);
                $("#outros").show().find("input").prop("required", true);
}



</script>

<script>

// Less than validator
window.Parsley.addValidator('lt2', {
  validateString: function (value, requirement) {
    var value2= value.toString().replace(",", ".");
    var requirement2= jQuery(requirement).val().toString().replace(",", ".");
    console.log(value2);
    console.log(requirement2);
    return value2 < requirement2;
  },
  messages: {
        pt: ''
  },
  priority: 32
});

// Less than validator
window.Parsley.addValidator('gt2', {
  validateString: function (value, requirement) {
    var value2= value.toString().replace(",", ".");
    var requirement2= jQuery(requirement).val().toString().replace(",", ".");
    console.log(value2);
    console.log(requirement2);
    return value2 > requirement2;
  },
  messages: {
        pt: ''
  },
  priority: 32
});

$('input[name=price]').keyup(function(){
if($(this).val().length)
$('#offer_settings').show();
else
$('#offer_settings').hide();
});
var price= "<?php  echo $item->price; ?>";  
            if (price) {
                $("#offer_settings").show();
               
            }else{
                $("#offer_settings").hide();
            }
            


  $(function () {

    $("#select_addon").select2({
        placeholder: "Selecione uma Opção...",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

    $("#select-unidade").select2({
        placeholder: "Selecione uma Opção...",
        minimumResultsForSearch: Infinity,
        
        allowClear: true,
    });

    $("#item_category_id").select2({
        placeholder: "Selecione uma Opção...",
        minimumResultsForSearch: Infinity,
        dropdownCssClass: "tag",
        //dropdownCssClass: "tag",
        allowClear: true, 
    });


      /*   var is_offer= "<?php  echo $item->is_offer; ?>";  
            if (is_offer== 1) {
                $("#discountedTwoPrice").show().find("input").prop("required", true);
               // $("input[name=price]").attr("data-parsley-lt2", '#old_price');
               // $("input[name=old_price]").attr("data-parsley-gt2", '#newSP');
                $("#preco").hide();
                $("#precodesconto").show();
            }
            if (is_offer== 0) {
                $("#discountedTwoPrice").hide().find("input").prop("required", false);
                $("#precodesconto").hide();
                $("#preco").show();
            }
    
        $("#is_offer").click(function () {
            if ($(this).is(":checked")) {
                $("#discountedTwoPrice").show().find("input").prop("required", true);
               // $("input[name=price]").attr("data-parsley-lt2", '#old_price');
               // $("input[name=old_price]").attr("data-parsley-gt2", '#newSP');
                $("#preco").hide();
                $("#precodesconto").show();
            } else {
                $("#discountedTwoPrice").hide().find("input").prop("required", false);
                
                $("#precodesconto").hide();
                $("#preco").show();
            }
        }); */

        $("#is_offer_notime").click(function () {
            if ($(this).is(":checked")) {
                
                $("#offer_date").find("input").prop("disabled", true).prop("required", false);
                //$("input[name=price]").attr("data-parsley-lt2", '#old_price');
               // $("input[name=old_price]").attr("data-parsley-gt2", '#newSP');
               
            } else {
                
                $("#offer_date").find("input").prop("disabled", false).prop("required", true);
             
            }
        }); 


        var is_active= "<?php  echo $item->is_active; ?>";  
            if (is_active== 1) {
                $("#produto_ativo").show();
                $("#produto_desativado").hide();
            }
            if (is_active== 0) {
                $("#produto_ativo").hide();
                $("#produto_desativado").show();
            }

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

    
    $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
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

$('#downloadSampleItemCsv').click(function(event) {
           event.preventDefault();
           window.location.href = "{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/docs/items-sample-csv.csv";
       });
        //$('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });
 

    // $('#addDiscountedPrice').click(function(event) {
             //               let price = $('#oldSP').val();
             //               $('#newSP').val(price).attr('required', 'required');;
             //               $('#singlePrice').remove();
             //               $('#discountedTwoPrice').show();
    // });

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

    $(document).ready(function () {
        $('#ean').on('input', function() {
			var ean_digitado = $(this).val();
			if (ean_digitado.length > 7) {
										var media = 'https://bancoimagenscb.s3-sa-east-1.amazonaws.com/webp3/' + ean_digitado + '.webp';
										//var produto_nome = data[0].produto_nome;
										//var produto_category = data[0].produto_category;
										var exists = '';
										checkImage(media, function() {
												//$(".gambar").attr("value", '');
                                                //$(".fileuploader").hide();
                                               // setTimeout(500);
                                                //$(".fileupload2").replaceWith('<div id="file2" class="fileuploader fileuploader-theme-thumbnails"><div class="fileuploader-items"><ul class="fileuploader-items-list"><li class="fileuploader-item file-type-image file-ext-png file-has-popup"><div class="fileuploader-item-inner"><div class="actions-holder"><button type="button" class="fileuploader-action fileuploader-action-remove" id="removerimagem" title="Excluir"><i class="fileuploader-icon-remove"></i></button></div><div class="thumbnail-holder"><div class="fileuploader-item-image"><img src="' + media + '"></div><span class="fileuploader-action-popup"></span></div><div class="progress-holder"></div></div></li><li class="fileuploader-thumbnails-input" style="display: none;"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li></ul></div></div>');
                                               
                                                //$('#removerimagem').on('click', function() {
                                                       // $(".fileuploader-thumbnails-input").show();
                                                       // $(".fileuploader-item").hide();
                                                        //$("input[name=fileuploader-list-files]").attr("value", '');
                                                        //$("input").attr("data-fileuploader-default", ''); 
                                                    //    $(".gambar").attr("src", '');
                                                        //$(".fileuploader").show();
                                                       // setTimeout(500);
                                                        //$("#file2").hide();
                                               //}); 

												
												$(".gambar").attr("src", media);
                                                $("#imagem_banco").attr("value", media);
												//$("input[name=fileuploader-list-files]").attr("value", '[{"file":"' + media + '","is_default":true}]');
                                        });
						};
		});
    });


    
/* 
    $(document).ready(function () {
       
			
			
										var media = "<?php  echo $item->image; ?>";
                                        if(media!=null){
                                            $("input[name=fileuploader-list-files]").attr("value", '');
                                                $(".fileuploader").hide();
                                                setTimeout(500);
                                                $(".fileupload2").replaceWith('<div id="file2" class="fileuploader fileuploader-theme-thumbnails"><div class="fileuploader-items"><ul class="fileuploader-items-list"><li class="fileuploader-item file-type-image file-ext-png file-has-popup"><div class="fileuploader-item-inner"><div class="actions-holder"><button type="button" class="fileuploader-action fileuploader-action-remove" id="removerimagem2" title="Excluir"><i class="fileuploader-icon-remove"></i></button></div><div class="thumbnail-holder"><div class="fileuploader-item-image"><img src="' + media + '"></div><span class="fileuploader-action-popup"></span></div><div class="progress-holder"></div></div></li><li class="fileuploader-thumbnails-input" style="display: none;"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li></ul></div></div>');
                                               
                                                $('#removerimagem2').on('click', function() {
                                                        $(".fileuploader-thumbnails-input").show();
                                                        $(".fileuploader-item").hide();
                                                        $("input[name=fileuploader-list-files]").attr("value", '');
                                                        $("input").attr("data-fileuploader-default", ''); 
                                                        $(".fileuploader-item-image img").attr("src", '');
                                                        $(".fileuploader").show();
                                                        setTimeout(500);
                                                        $("#file2").hide();
                                               }); 

												$("input").attr("data-fileuploader-default", media); 
												$(".fileuploader-item-image img").attr("src", media);
												$("input[name=fileuploader-list-files]").attr("value", '[{"file":"' + media + '","is_default":true}]');
                                        
                                        }
										
												
						
		
    }); */


                function checkImage(imageSrc, good, bad) {
                    var img = new Image();
                    img.onload = good;
                    img.onerror = bad;
                    img.src = imageSrc;
	            };

  
                            // Start upload preview image
                            var image= "<?php  echo $item->image; ?>"; 

                            if(image!=null){

                                if (image.indexOf("http://") == 0 || image.indexOf("https://") == 0) {
                                    $(".gambar").attr("src", image);
                                }
                                else{
                                    $(".gambar").attr("src", "https://app.comprabakana.com.br"+image); 
                                }

                                
                            }else{
                                $(".gambar").attr("src", "https://app.comprabakana.com.br/assets/img/drag.png");
                            }

						var $uploadCrop,
						tempFilename,
						rawImg,
						imageId,
                        h,
                        w;
						function readFile(input) {
				 			if (input.files && input.files[0]) {
				              var reader = new FileReader();
					            reader.onload = function (e) {
									$('.upload-demo').addClass('ready');
									$('#cropImagePop').modal('show');
						            rawImg = e.target.result;
                                    var h = rawImg.height();
                                    var w = rawImg.width();
					            }
					            reader.readAsDataURL(input.files[0]);
					        }
					        else {
						        swal("Sorry - you're browser doesn't support the FileReader API");
						    }
                            
						}
                        

                        
						$uploadCrop = $('#upload-demo').croppie({
                            
							 viewport: {
                                width: 300,
                                height: 300,
                                type: 'square' //default 'square'
                            },
                             boundary:{
                                width: 300,
                                height: 300,
                            }, 
                            
                            enforceBoundary: false,
							enableExif: true
						});
                       
						$('#cropImagePop').on('shown.bs.modal', function(){
							// alert('Shown pop');
							$uploadCrop.croppie('bind', {
				        		url: rawImg
                               
				        	}).then(function(){
				        		console.log('jQuery bind complete');
				        	});
						});

						$('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
						$('#cancelCropBtn').data('id', imageId); readFile(this); });
						$('#cropImageBtn').on('click', function (ev) {
							$uploadCrop.croppie('result', {
								type: 'base64',
								format: 'jpeg',
								size: {width: 300, height: 300},
                                backgroundColor : "#ffffff",
							}).then(function (resp) {
								$('#item-img-output').attr('src', resp);
                                $('#file_output').val(resp);
								$('#cropImagePop').modal('hide');
							});
						});
				// End upload preview image



$(document).ready(function() {
	
	// enable fileuploader plugin
	$('input[name="files"]').fileuploader({
        extensions: null,
		changeInput: ' ',
		theme: 'thumbnails',
        enableApi: true,
		addMore: false,
        
		thumbnails: {
			box: '<div class="fileuploader-items">' +
                      '<ul class="fileuploader-items-list">' +
					      '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                      '</ul>' +
                  '</div>',
			item: '<li class="fileuploader-item">' +
				       '<div class="fileuploader-item-inner">' +
                           
                           '<div class="actions-holder">' +
						   	   '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                           '</div>' +
                           '<div class="thumbnail-holder">' +
                               '${image}' +
                               '<span class="fileuploader-action-popup"></span>' +
                           '</div>' +
                           
                       	   '<div class="progress-holder">${progressBar}</div>' +
                       '</div>' +
                  '</li>',
			item2: null,
			startImageRenderer: true,
            canvasImage: true,
			_selectors: {
				list: '.fileuploader-items-list',
				item: '.fileuploader-item',
				start: '.fileuploader-action-start',
				retry: '.fileuploader-action-retry',
				remove: '.fileuploader-action-remove'
			},
            itemPrepend: true,
			
            popup: {
				arrows: false,
				onShow: function(item) {
					item.popup.html.addClass('is-for-avatar');
                    item.popup.html.on('click', '[data-action="remove"]', function(e) {
                        item.popup.close();
                        item.remove();
                    }).on('click', '[data-action="cancel"]', function(e) {
                        item.popup.close();
                    }).on('click', '[data-action="save"]', function(e) {
						if (item.editor ) {
							item.isSaving = true;
                        	item.editor.save();
						}
						if (item.popup.close)
							item.popup.close();
                    });
                },
				onHide: function(item) {
					if (!item.isSaving && !item.uploaded && !item.appended) {
						item.popup.close = null;
						item.remove();
					}
				} 	
			},
			onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
				var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));
                    plusInput.hide();
                 //plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();
				 
				if(item.format == 'image') {
					item.html.find('.fileuploader-item-icon').hide();
				}
			},
            onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                if (item.choosed ) {
					if (item.reader.node && item.reader.width >= 200 && item.reader.height >= 200) {
						item.image.hide();
						item.popup.open();
						item.editor.cropper();
					} else {
						//item.remove();
						//alert('The image is too small!');
					}
				} else if (item.data.isDefault)
					item.html.addClass('is-default');
				//else if (item.image.hasClass('fileuploader-no-thumbnail'))
					//item.html.hide();
            },
            onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
				    api = $.fileuploader.getInstance(inputEl.get(0));
                    plusInput.show();
                html.children().animate({'opacity': 0}, 200, function() {
                    html.remove();
                    
                    if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                        plusInput.show();
                });
            }
		},
        editor: {
			maxWidth: 400,
			maxHeight: 400,
			quality: 80,
            cropper: {
				showGrid: false,
				ratio: '1:1',
				minWidth: 150,
				minHeight: 150,
			},
		
        },
        dragDrop: {
			container: '.fileuploader-thumbnails-input'
		},
		afterRender: function(listEl, parentEl, newInputEl, inputEl) {
			var plusInput = listEl.find('.fileuploader-thumbnails-input'),
				api = $.fileuploader.getInstance(inputEl.get(0));
		
			plusInput.on('click', function() {
				api.open();
			});
            
            api.getOptions().dragDrop.container = plusInput;

          
		},
		
       
    });
});
</script>
@endsection

