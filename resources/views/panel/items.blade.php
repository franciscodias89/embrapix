@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="https://app.comprabakana.com.br/assets/fileuploader/examples/thumbnails/css/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">
{{--  <link href="https://app.comprabakana.com.br/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" media="all" rel="stylesheet">
  --}}
  <link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
@endsection
@section('content')
 <style>
  
	.fileuploader {
     max-width: 560px;
      }
	.fileuploader-items .fileuploader-item .column-thumbnail {
    position: relative;
    width: 90px;
    height: 90px;
}
.card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}
.fileuploader {
    
     margin: 0 0 0 0; 
   
}
.modal {
  overflow-y:auto;
}

div.dataTables_wrapper .select2-selection--single {
    background-color: #fff;
    border: 1px solid #e3e6ef;
    border-radius: 4px;
    height: 48px;
    width: 100px;
    display: flex;
    align-items: center;
} 

div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
    float: right;
}

.userDatatable table {
    border-bottom: 0px solid #f1f2f6;
  
}

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: auto;
    height: 48px;
    width: 250px;
    font-size: 14px;
    padding: 20px;
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

table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
}
table td{
       word-wrap:break-word;
    }


        </style>
 
 <?php include_once base_path('assets/fileuploader/src/php/class.fileuploader.php');
 $enabled=true; ?>

 <div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Produtos</h4>
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
                          {{--   <div class="dropdown action-btn">
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
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable orderDatatable global-shadow border py-30 px-sm-30 px-20 bg-white radius-xl w-100 mb-30">
                    <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                            {{-- <div class="project-search order-search  global-shadow mt-10">
                                <form action="/" class="order-search__form">
                                    <span data-feather="search"></span>
                                    <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                                </form>
                            </div><!-- End: .project-search --> --}}
                            <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
                                <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                <div class="project-tap order-project-tap global-shadow">
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.items') ? 'active' : ''}}" href="{{ route('panel.items') }}">Todos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.itemsActive') ? 'active' : ''}}" href="{{ route('panel.itemsActive') }}">Ativos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.itemsInActive') ? 'active' : ''}}" href="{{ route('panel.itemsInActive') }}" >Desativados
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.itemsOffer') ? 'active' : ''}}" href="{{ route('panel.itemsOffer') }}" >Ofertas
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.itemsWithoutImage') ? 'active' : ''}}" href="{{ route('panel.itemsWithoutImage') }}" >Sem Imagem
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.itensDeleted') ? 'active' : ''}}" href="{{ route('panel.itensDeleted') }}">Lixeira</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- End: .project-category -->
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                {{-- <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md">Export</button> --}}
                                @if($restaurant->status == 8)
                               
                                <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md" 
                                data-toggle="modal" onclick="window.location='{{ route('wizard.wizard_panel') }}'" >
                                <i class="la la-arrow-left"></i>Voltar</button>

                                @endif 
                                <button type="button" class="btn btn-primary" id="addNewFlyer"
                                data-toggle="modal" data-target="#addNewFlyerModal">
                                <b><i class="icon-plus2"></i></b>
                                Adicionar Produto</button>
                            </div>
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->
                    <div class="tab-content" id="ap-tabContent">
                        <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                            
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0"  id="itemsDataTable" >
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23e">
                                                        <label for="check-23e">
                                                                    <span class="checkbox-text ml-3">
                                                                        Imagem
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        
                                        <th >
                                            <span class="userDatatable-title">Nome</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Cód. Barras</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title ">Preço (R$)</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title ">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title ">Oferta</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title ">Criado em:</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title ">Ações</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                        <tr class="item">
                                            
                                            <td> 
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3 d-flex align-items-center">
                                                        <div class="checkbox-group-wrapper">
                                                            <div class="checkbox-group d-flex">
                                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox" id="check-grp-12">
                                                                    <label for="check-grp-12"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="orderDatatable-title">
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
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                            </td>
                                            
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title" >
                                                    
                                                <span >{{$item->name}}</span> 
                                            
                                                </div>
                                            </td>
                                            <td>
                                                <div class="orderDatatable-title">
                                                    
                                                    <span >{{ $item->ean }}</span> 
                                                    
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="orderDatatable-title">
                                                    @php $agora= date(now()) @endphp
                                                    
                                                    @if(($item->is_offer_notime ==1))
                                                        <span >De: R${{ str_replace(".",",",$item->old_price)  }}</span><br>
                                                        <span >Por: R${{ str_replace(".",",",$item->price)  }}</span>
                                                    @elseif(date('d/m/Y' ,strtotime($item->start_date)) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($item->end_date)) >=date('d/m/Y' ,strtotime($agora)) && $item->price!=null )
                                                        <span >De: R${{ str_replace(".",",",$item->old_price)  }}</span><br>
                                                        <span >Por: R${{ str_replace(".",",",$item->price)  }}</span>

                                                    @else

                                                    @php
                                                    if($item->old_price=="0.00"){
                                                        $addon_categories=$item['addon_categories'];

                                                        $addon_prices=[];
                                                        foreach($addon_categories as $categories){

                                                            if($categories['type']=="SINGLE"){
                                                                $addons=$categories['addons'];
                                                                foreach($addons as $addon){
                                                                    if($addon['price']!=null){
                                                                        $addon_prices[]=$addon['price'];
                                                                    }
                                                                }
                                                            }
                                                            
                                                        }
                                                        if(!empty($addon_prices)){
                                                            $price_from=min($addon_prices);
                                                        }else{
                                                            $price_from="0.00";
                                                        }
                                                        
                                                    }
                                                         

                                                    @endphp


                                                        @if($item->old_price=="0.00")
                                                        <span >A partir de: R$ {{ str_replace(".",",",$price_from)  }}</span>
                                                        @else

                                                        <span >R$ {{ str_replace(".",",",$item->old_price)  }}</span>
                                                        @endif

                                                    @endif
                                                    
                                                    </div>
                                            </td>  
                                            <td>
                                               
                                                 @if(($item->is_active)==1)
                                               
                                                 <div class="orderDatatable-status d-inline-block">
                                                    <span class="order-bg-opacity-success  text-success rounded-pill active">Ativo</span>
                                                </div>
                                                
                                                @endif
                                                @if(($item->is_active)==0)
                                                <div class="orderDatatable-status d-inline-block">
                                                    <span class="order-bg-opacity-danger  text-danger rounded-pill active">Desativado</span>
                                                </div>
                                                @endif
                                                
                                            </td>
                                            <td>
                                               
                                                
                                                                                                   
                                                @if(($item->is_offer_notime ==1) && ($item->price != null))
                                               <div class="orderDatatable-status d-inline-block">
                                                   <span class="order-bg-opacity-danger  text-danger rounded-pill active">Oferta</span>
                                               </div>
                                               @elseif(date('d/m/Y' ,strtotime($item->start_date)) <=date('d/m/Y' ,strtotime($agora)) && date('d/m/Y' ,strtotime($item->end_date)) >=date('d/m/Y' ,strtotime($agora)) && $item->price!=null )
                                               <div class="orderDatatable-status d-inline-block">
                                                <span class="order-bg-opacity-danger  text-danger rounded-pill active">Oferta</span>
                                            </div>
                                               
                                               @endif
                                               
                                           </td>
                                            <td><div class="orderDatatable-title ">
                                                {{ date('d/m/Y', strtotime($item->created_at)) }}
                                                
                                            </div>
                                            </td>
                                            
                                            <td class="text-center">

                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                       
                                                    @if(Request::is('store-owner/items/deleted'))
                                                    <li>
                                                        <a href="{{ route('panel.restoreItem', $item->id) }}" title="Restaurar" class="edit">
                                                            <span data-feather="rotate-ccw" ></span></a>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <a href="{{ route('panel.get.editItem', $item->id) }}" title="Editar" class="edit">
                                                            <span data-feather="edit"></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('panel.deleteItem', $item->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este item?')" class="remove">
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
                            <!-- Table Responsive End -->
                        </div>
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23u">
                                                        <label for="check-23u">
                                                                    <span class="checkbox-text ml-3">
                                                                        order id
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customers</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                     
                                    </tbody>
                                </table>
                            </div>
                            <!-- Table Responsive End -->
                        </div>
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="bd-example-indeterminate">
                                                    <div class="checkbox-theme-default custom-checkbox  check-all">
                                                        <input class="checkbox" type="checkbox" id="check-23">
                                                        <label for="check-23">
                                                                    <span class="checkbox-text ml-3">
                                                                        order id
                                                                    </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customers</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-right">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                           
                                    </tbody>
                                </table>
                            </div>
                            <!-- Table Responsive End -->
                        </div>

                    </div>
                    
                    {{-- <div class="mt-4">
                        {{ $flyers->appends($_GET)->links() }}
                    </div> --}}
                    
                   {{--  <div class="d-flex justify-content-sm-end justify-content-start mt-15 pt-25 border-top">
                        <nav class="atbd-page ">
                            <ul class="atbd-pagination d-flex">
                                <li class="atbd-pagination__item">
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-left"></span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">1</span></a>
                                    <a href="#" class="atbd-pagination__link active"><span class="page-number">2</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">3</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="page-number">...</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">12</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-right"></span></a>
                                    <a href="#" class="atbd-pagination__option">
                                    </a>
                                </li>
                                <li class="atbd-pagination__item">
                                    <div class="paging-option">
                                        <select name="page-number" class="page-selection">
                                            <option value="20">20/page</option>
                                            <option value="40">40/page</option>
                                            <option value="60">60/page</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
                </div><!-- End: .userDatatable -->
            </div><!-- End: .col -->
        </div>
    </div>
</div>






<div class="modal fade" id="cropImagePop" tabindex="-1" data-focus-on="input:first">
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





<div id="addNewFlyerModal" class="modal fade" tabindex="-1" data-focus-on="input:first">
    <?php


 //$url = get_url('inc/plugins/fileuploader');

 $preloadedFiles = '';

 ?>
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.saveNewItem') }}" method="POST" enctype="multipart/form-data" data-parsley-trigger="keyup" data-parsley-validate>

                    <div class="new-member-modal">
                        <div class="row col-md-12">
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
                                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                                <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Produto Ativo</label>
                                                <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Produto Desativado</label>
                                             </div>
                                            </div>
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
                                            data-parsley-error-message="Este campo é obrigatório! Se não tiver código de barras, você pode colocar aqui qualquer código" >

                                                
                                         </div>
                                         <div class="form-group col-md-6"
                                                style="padding-left: 0px; float: left;">
                                                <label for="codint">Código Interno (opcional)</label>
                                             <input type="text" class="form-control codint" name="codint"
                                                id="codint" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                placeholder="Código Interno">
                                        </div>
                                        <div class="form-group">
                                            <label for="name"><span class="text-danger">*</span>Nome</label>
                                            <input required type="text" class="form-control name" name="name"
                                                id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                                placeholder="Nome do Produto">
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Descrição (opcional)</label>
                                            <textarea  type="text" class="form-control"
                                                name="desc" id="desc" rows="4" data-parsley-group="form-step-1" parsley-trigger="change"
                                                placeholder="Descrição do Produto"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <div class="">
                                            <label><span class="text-danger">*</span>Categoria do Produto: </label>
                                            <select class="js-example-placeholder-single js-states" name="item_category_id" id="item_category_id" required>
                                                @foreach ($itemCategories as $itemCategory)
                                                <option value="{{ $itemCategory->id }}" class="text-capitalize">
                                                    {{ $itemCategory->name }}</option>
                                                @endforeach
                                            </select>
                                          
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="">Grupos de Opções (opcional):</label>
                                            <div class="skillsOption">
                                                <select multiple="multiple" class="js-example-basic-single js-states form-control" 
                                                data-plugin="customselect" data-fouc
                                                    name="addon_category_item[]" id="select_addon">
                                                    @foreach($addonCategories as $addonCategory)
                                                    @if($addonCategory->is_deleted==0)
                                                    <option value="{{ $addonCategory->id }}" class="text-capitalize">
                                                        {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagem</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            <div class="form-group">
                                                <label class="cabinet center-block">
                                                    <figure>
                                                        <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                                      <figcaption><i class="fa fa-camera" style="font-size: x-large;"></i></figcaption>
                                                </figure>
                                                    <input type="file" hidden class="item-img file center-block" name="file"/>
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
                                            
                                                <div class="form-group row">
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
                                                            <input type="text" class="form-control dinheiro" name="price"
                                                            placeholder="Preço Oferta" id="price_offer"
                                                            data-parsley-lt2-message="O preço com desconto deve ser menor do que o preço sem desconto" 
                                                            >
                                                        </div>

                                                        
                                                        
                                                    </div>
                                                </div>
                                                <div id="offer_settings" style="display: none">
                                                    <div class="form-group row" style="margin-left: 15px;"> 
                                                        <div class="custom-control custom-switch switch-primary switch-md ">
                                                            <input type="checkbox" name="is_offer_notime" class="custom-control-input" id="is_offer_notime" >
                                                            <label class="custom-control-label" for="is_offer_notime"> Oferta por tempo indeterminado</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row col-md-12" id="offer_date">
                                                        <div class="form-group col-md-6" style="padding-left: 0px;">
                                                            <label for="start_date">Data Início da Oferta</label>
                                                            <input type="date" class="form-control"
                                                                name="start_date" id="start_date"    parsley-trigger="change"
                                                            >
                                                                
                                                        </div>
                                                        <div class="form-group col-md-6 pr0" style="padding-right: 0px; padding-left: 0px;">
                                                            <label for="end_date">Data Fim da Oferta</label>
                                                            <input type="date" class="form-control"
                                                                name="end_date" id="end_date"   parsley-trigger="change"
                                                            >
                                                                
                                                        </div>
                                                    </div>
                                                </div>
        
                                                    <div class="form-group mb-20">
                                                        <label ><span
                                                            class="text-danger">*</span>Preço Por:</label>
                                                        <select class="js-example-basic-single js-states form-control"
                                                            name="unidade" id="select-unidade" required>
                                                            <option value="un" class="text-capitalize" >Unidade</option>
                                                            <option value="kg" class="text-capitalize" >Kg</option>
                                                            
                                                        </select>
                                                    </div>
                                                   

                                                    @if($manage_stock)
                                                    <div class="form-group mb-20">
                                                        
                                                            <label><span class="text-danger"></span>Quantidade em Estoque:</label>
                                                       
                                                            <input type="number" class="form-control" name="estoque"
                                                                placeholder="Estoque" id="estoque"
                                                                data-parsley-required-message="Este campo é obrigatório" 
                                                            >
                                                    </div>
                                                    @endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Salvar Produto
                            <i class="icon-database-insert ml-1"></i></button>
                    </div>
                </form>
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

/* $(document).ready(function() {
  $(".preco_oferta input").focus(function() { 
              $('#offer_settings').show('slow');
      //return false;
    });
    
  
 $(".preco_oferta input").blur(function(){
    if( !$(this).val() ) {
            $('#offer_settings').hide('slow'); 
    }
});
}); */

$('input[name=price]').keyup(function(){
if($(this).val().length)
$('#offer_settings').show();
else
$('#offer_settings').hide();

});

$.fn.dataTable.moment('DD/MM/YYYY');

$(function () {
        
        $('body').tooltip({selector: '[data-popup="tooltip"]'});
        
       /*   var datatable = $('#itemsDataTable').DataTable({

            bLengthChange : true,
            searching: true,
            pageLength : 10,
            bInfo: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],  
            order: [[ 0, "desc" ]],
            ajax: '{{ route('restaurant.itemsDataTable') }}',  
            columns: [
                {data: 'id', visible: false, searchable: false},
                {data: 'image'},
                {data: 'name'},
                {data: 'ean', width: "20%"},
                {data: 'price', width: "20%" },
                {data: 'item_category'},
                {data: 'is_active'},
               // {data: 'created_at'},
              
                {data: 'action', sortable: false, searchable: false, reorder: false},
            ],
         
            fixedColumns: { 
                leftColumns: 0,
                rightColumns: 1
            },
            colReorder: {
                   fixedColumnsRight: 1
               },
            drawCallback: function( settings ) {
                /*  $('form-select form-select-sm select2-hidden-accessible').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });  
                

                var newDate = new Date();
                console.log(newDate)
                var newStamp = newDate.getTime();

                

            },
            scrollX: true,
            scrollCollapse: true,
            dom: '<"custom-processing-banner"r>flBtip', 
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
           buttons: {
                   dom: {
                       button: {
                           className: 'btn btn-sm btn-primary'
                       }
                   },
                   buttons: [
                       {extend: 'csv',  filename: 'produtos-'+ new Date().toISOString().slice(0,10), text: 'CSV'},
                       {extend: 'excel', filename: 'produtos-'+ new Date().toISOString().slice(0,10), text: 'Excel'},
                       
                   ]
               }
        });
        datatable.buttons().container().appendTo($('#but'));

         $('#clearFilterAndState').click(function(event) {
            if (datatable) {
                datatable.state.clear();
                window.location.reload();
            }
         });*/
    
        });


 



 $('#itemsDataTable').DataTable(
        {
            bLengthChange : true,
            searching: true,
            pageLength : 10,
            bInfo: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],
            autoWidth: false,
            fixedColumns: { 
                leftColumns: 0,
                rightColumns: 1
            },
            drawCallback: function( settings ) {
                $('select').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });
            },

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

    
         $("#is_offer_notime").click(function () {
            if ($(this).is(":checked")) {
                
                $("#offer_date").find("input").prop("disabled", true).prop("required", false);
                //$("input[name=price]").attr("data-parsley-lt2", '#old_price');
               // $("input[name=old_price]").attr("data-parsley-gt2", '#newSP');
               
            } else {
                
                $("#offer_date").find("input").prop("disabled", false).prop("required", true);
             
            }
        }); 
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
				var exists = '';
				checkImage(media, function() {
				    $(".gambar").attr("src", media);
                    $("#imagem_banco").attr("value", media);
				});
			};
		});
    });

    function checkImage(imageSrc, good, bad) {
        var img = new Image();
        img.onload = good;
        img.onerror = bad;
        img.src = imageSrc;
	};


    $(".gambar").attr("src", "https://app.comprabakana.com.br/assets/img/drag.png");




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

/* $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        }); */

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
                //if (item.choosed && !item.isSaving) {
					if (item.reader.node && item.reader.width >= 200 && item.reader.height >= 200) {
						//item.image.hide();
						//item.popup.open();
						//item.editor.cropper();
					} else {
						item.remove();
						alert('A imagem é muito pequena! Tamanhp mínimo: 200px vs 200px!');
					}
				//} else if (item.data.isDefault)
				//	item.html.addClass('is-default');
				//else if (item.image.hasClass('fileuploader-no-thumbnail'))
				//	item.html.hide();
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
			maxWidth: 500,
			maxHeight: 500,
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


