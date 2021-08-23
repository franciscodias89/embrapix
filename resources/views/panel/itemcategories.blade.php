@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection


@section('styles')


@endsection
@section('content')
<style>
  

    .card .card-header {
      padding-top: 10px;
        background: #F4F5F7;
       
    }
    
    
    .row {
         margin-right: 0px;
        margin-left: 0px;
    }
    
    
    table.dataTable tbody td {
        word-break: break-word;
        vertical-align: middle;
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
    
    
    table.dataTable tbody td {
        word-break: break-word;
        vertical-align: middle;
    }
    table td{
           word-wrap:break-word;
        }
    
    
    
            </style>
     
     
    
     <div class="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop-breadcrumb">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">Categorias</h4>
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
                                 <div class="project-category d-flex align-items-center  mt-xl-10 mt-15">
                                    <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                    <div class="project-tap order-project-tap global-shadow">
                                        <ul class="nav px-1" id="ap-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link {{ Route::is('panel.itemcategories') ? 'active' : ''}}" href="{{ route('panel.itemcategories') }}">Todos</a>
                                            </li>
                                           
                                            <li class="nav-item">
                                                <a class="nav-link {{ Route::is('panel.itemcategoriesDeleted') ? 'active' : ''}}" href="{{ route('panel.itemcategoriesDeleted') }}">Lixeira</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- End: .project-category --> 
                            </div><!-- End: .d-flex -->
                            <div class="content-center mt-10">
                                <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                    @if($restaurant->status == 8)
                                   
                                    <button type="button" class="order-bg-opacity-secondary text-secondary btn radius-md" 
                                    data-toggle="modal" onclick="window.location='{{ route('wizard.wizard_panel') }}'" >
                                    <i class="la la-arrow-left"></i>Voltar</button>
    
                                    @endif 
                                    <button type="button" class="btn btn-primary" 
                                    data-toggle="modal" data-target="#addNewItemCategory">
                                    <i class="la la-plus"></i>Adicionar Categoria</button>
    
                                    {{-- <a class="btn btn-primary btn-labeled btn-labeled-left" href="{{route('restaurant.newAddonCategory')}}">
                                        <b><i class="icon-plus2"></i></b>
                                        Adicionar Novo Grupo
                                    </a> --}}
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
                                            
                                            <th><span class="userDatatable-title">Nome</span></th>
                                            <th><span class="userDatatable-title">Número de Items</span></th>
                                            <th><span class="userDatatable-title">Criada em:</span></th>
                                           
                                            <th class="text-center" style="width: 10%;"><i class="
                                                icon-circle-down2"></i><span class="userDatatable-title">Ações</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($itemCategories as $itemCategory)
                                                <tr class="item">
                                                    
                                                    <td style="white-space:normal;">
                                                        <div class="orderDatatable-title">{{ $itemCategory->name }}
                                                        </div>
                                                    </td>
                                                  
                                                    <td><div class="orderDatatable-title">
                                                        {{ $itemCategory->items_count}}
                                                    </td>
                                                                                                        
                                                    <td><div class="orderDatatable-title">{{ $itemCategory->created_at->diffForHumans() }}</div></td>
                                                   
                                                    <td class="text-center">
                                                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                           
                                                            @if(Request::is('store-owner/itemcategories/deleted'))
                                                            <li>
                                                                <a href="{{ route('panel.restoreItemCategory', $itemCategory->id) }}" title="Restaurar" class="edit">
                                                                    <span data-feather="rotate-ccw" ></span></a>
                                                            </li>
                                                            @else
                                                            <li>
                                                                
                                                                
                                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#editItemCategory" data-catid="{{ $itemCategory->id }}" data-catname="{{ $itemCategory->name }}"
                                                                        class="edit editItemCategory"> <span data-feather="edit"></span></a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('panel.deleteItemCategory', $itemCategory->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este item?')" class="remove">
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
                            
                            
    
                        </div>
                        
                         {{-- <div class="mt-4">
                            {{ $coupons->appends($_GET)->links() }}
                        </div>  --}}
                        
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


<div id="addNewItemCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">{{__('storeDashboard.mcpModalTitle')}}</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.createItemCategory') }}" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control " name="name"
                                placeholder="Digite o Nome da Categoria" required>
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
                <h5 class="modal-title"><span class="font-weight-bold">Editar Categoria</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.updateItemCategory') }}" method="POST">
                    <input type="hidden" name="id" id="itemCatId">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Digite o Nome da Categoria" required id="itemCatName">
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
        });
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
            let url = "{{ url('/store-owner/itemcategory/disable/') }}/"+id;
            window.location.href = url;
         });
    });
</script>
@endsection


