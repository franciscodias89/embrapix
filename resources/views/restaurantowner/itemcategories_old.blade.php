@extends('layouts.app')
@section("title") {{__('storeDashboard.mcpPageTitle')}}
@endsection
@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-left mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Início</a></li>
                
                <li class="breadcrumb-item active" aria-current="page">Categorias</li>
            </ol>
        </nav>
             
    </div>
    
</div>


@endsection
@section('content')
<style>
    .table-mod tbody tr.item {
        border: 1px solid #f4f4f4;
        border-radius: 4px;
        height: 80px;
        text-align: center;
        -webkit-box-shadow: 0 0 13px 0 rgba(82,63,105,.02);
        box-shadow: 0 0 13px 0 rgba(82,63,105,.02);
    }
        .table-mod tbody tr.item {
            background: #f8f9fa;
        }
        .table-mod tbody tr.spacer {
        height: 15px;
    }
    .text-info {
        color: #5578eb!important;
    }
   
    .fw-5 {
        
        font-weight: 600!important;
    }
    .table-mod thead tr th {
        border-bottom: none;
        border-top: none;
        padding: 0 15px 15px;
        color: #5578eb;
        font-weight: 700;
        white-space: nowrap;
        text-align: center;
    }
    .card-body {
        flex: 1 1 auto;
        padding: 2.2rem;
    }
        </style>
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="float-left">
                        <h3 class="mb-1 mt-0 mr-2 float-left">Categorias de Produtos </h3> <span class="badge badge-primary badge-pill animated flipInX">{{ $count }}</span>
                    </div>
                    
                   
                    <button type="button" class="btn btn-primary float-right"
                    data-toggle="modal" data-target="#addNewItemCategory">
                <b><i class="icon-plus2"></i></b>
                Adicionar Categoria
                </button>
                </div>
            </div>
            <div class="table-mod table-responsive">
                <table class="table mt-4 table-centered table-striped mb-0">
                    <thead>
                        <tr>
                            
                            <th class="text-center" >Nome</th>
                            <th class="text-center" >Número de Itens</th>
                            {{-- <th>Status</th> --}}
                            <th>Criada em</th>
                            <th class="text-center"><i class="
                                icon-circle-down2"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itemCategories as $itemCategory)
                        <tr class="item">
                            
                            <td class="text-center"><span class="fw-5 text-info">{{ $itemCategory->name }}</span></td>
                            <td class="text-center" >{{ $itemCategory->items_count}}</td>
                            {{-- <td><span class="badge badge-flat border-grey-800 text-default text-capitalize">@if($itemCategory->is_enabled) {{ __('storeDashboard.mcpEnabled')}} @else {{ __('storeDashboard.mcpDisabled')}} @endif</span></td> --}}
                            <td>{{ $itemCategory->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <div class="align-items-center" style="display: inline-block; vertical-align: top; text-align: right;">
                                    
                                   
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#editItemCategory" data-catid="{{ $itemCategory->id }}" data-catname="{{ $itemCategory->name }}"
                                        class="btn btn-primary  editItemCategory"> Editar <i
                                            class="icon-database-edit2 ml-1"></i></a>
                                    </div>
                            </td>
                            
                        </tr>
                        <tr class="spacer">
                        @endforeach
                    </tbody>
                </table>
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
                <form action="{{ route('restaurant.createItemCategory') }}" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">{{__('storeDashboard.mcpModalLabelName')}}:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control " name="name"
                                placeholder="{{__('storeDashboard.mcpModalPlaceHolderName')}}" required>
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
@section('script')
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