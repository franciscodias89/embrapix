
 @extends('layouts.app')
 @section('styles')
 
 <style>
 .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #e3e6ef;
    border-radius: 4px;
    height: 48px;
    width: 100px;
    display: flex;
    align-items: center;
} 
#itemsDataTable tr td{
    white-space: pre-wrap;
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
.buttons-excel {
  float: right;
}
.buttons-csv {
  float: left;
  margin-right: 10px;
}
#but {
float:right;
}

</style>

@endsection

@section("title") Produtos - Dashboard
@endsection
@section('content')

<style>
    .pulse {
        display: inline-block;
        width: 12.5px;
        height: 12.5px;
        border-radius: 50%;
        animation: pulse 1.2s infinite;
        vertical-align: middle;
        margin: -3px 5px 0 0;
    }
    .pulse-warning {
        background: #ffc107;
    }
    .pulse-danger {
        background: #ff5722;
    }
    @keyframes pulse {
        0% {
        box-shadow: 0 0 0 0 rgba(255,87,34, 0.5);
        }
        50% {
        box-shadow: 0 0 0 26px rgba(255,87,34, 0);
        }
        100% {
        box-shadow: 0 0 0 0 rgba(255,87,34, 0);
        }
    }
    .linked-item {
        color: #4e535a;
    }
    .linked-item:hover {
        color: #8360c3;
        text-decoration: underline;
        opacity: 1;
    }

    .badge {
    display: inline-block;
    padding: .3125rem .375rem;
    
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 8px;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.order-badge {
    min-width: 120px;
    border-radius: 8px;
}
.border-grey-800 {
    border-color: #b9b9b9;
}

.badge-color-2, .badge-color-3, .badge-color-4, .badge-color-7 {
    color: #fff;
    background-color: #00BCD4;
}
.badge-color-1 {
    color: #fff;
    background-color: #8360c3;
}
.badge-color-5 {
    color: #fff;
    background-color: #66ce66;
}
.badge-color-6, .badge-color-9 {
    color: #fff;
    background-color: #ff7043;
}
</style>
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Produtos</h4>
                            {{-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> --}}
                        </div>
                        {{-- <form action="/" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                            <span data-feather="search"></span>
                            <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search"
                                   placeholder="Search by Name" aria-label="Search">
                        </form> --}}
                    </div>
                    <div class="action-btn" id='but'>

                    </div>
                    <div >
                        <button type="button" class="btn btn-primary" id="addNewItem"
                            data-toggle="modal" data-target="#addNewItemModal">
                            <b><i class="icon-plus2"></i></b>
                            Adicionar Produto
                        </button>
                        <button type="button" class="btn btn-secondary" id="addBulkItem"
                            data-toggle="modal" data-target="#addBulkItemModal">
                            <b><i class="icon-database-insert"></i></b>
                            Importar CSV
                        </button>
                    </div>
 {{--                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#new-member">
                            <i class="las la-plus fs-16"></i>Add New Member</a>
                        <!-- Modal -->
                        <div class="modal fade new-member" id="new-member" role="dialog" tabindex="-1"
                             aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content  radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Create project</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span data-feather="x"></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="new-member-modal">
                                            <form>
                                                <div class="form-group mb-20">
                                                    <input type="text" class="form-control"
                                                           placeholder="Duran Clayton">
                                                </div>
                                                <div class="form-group mb-20">
                                                    <div class="category-member">
                                                        <select
                                                            class="js-example-basic-single js-states form-control"
                                                            id="category-member">
                                                            <option value="JAN">1</option>
                                                            <option value="FBR">2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-20">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                                              rows="3" placeholder="Project description"></textarea>
                                                </div>
                                                <div class="form-group textarea-group">
                                                    <label class="mb-15">status</label>
                                                    <div class="d-flex">
                                                        <div
                                                            class="project-task-list__left d-flex align-items-center">
                                                            <div class="checkbox-group d-flex mr-50 pr-10">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-1" checked>
                                                                    <label for="check-grp-1"
                                                                           class="fs-14 color-light strikethrough">
                                                                        status
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox-group d-flex mr-50 pr-10">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-2">
                                                                    <label for="check-grp-2"
                                                                           class="fs-14 color-light strikethrough">
                                                                        Deactivated
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox-group d-flex">
                                                                <div
                                                                    class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                    <input class="checkbox" type="checkbox"
                                                                           id="check-grp-3">
                                                                    <label for="check-grp-3"
                                                                           class="fs-14 color-light strikethrough">
                                                                        bloked
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-25">
                                                    <div class="form-group mb-10">
                                                        <label for="name47">project member</label>
                                                        <input type="text" class="form-control" id="name47"
                                                               placeholder="Search members">
                                                    </div>
                                                    <ul class="d-flex flex-wrap mb-20 user-group-people__parent">
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm1.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm2.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm3.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm4.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img class="rounded-circle wh-34"
                                                                             src="{{ asset('img/tm5.png') }}"
                                                                             alt="author"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="d-flex new-member-calendar">
                                                    <div class="form-group w-100 mr-sm-15 form-group-calender">
                                                        <label for="datepicker">start Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="datepicker"
                                                                   placeholder="mm/dd/yyyy">
                                                            <a href="#">
                                                                <span data-feather="calendar"></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group w-100 form-group-calender">
                                                        <label for="datepicker2">End Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control" id="datepicker2"
                                                                   placeholder="mm/dd/yyyy">
                                                            <a href="#">
                                                                <span data-feather="calendar"></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-group d-flex pt-25">
                                                    <button
                                                        class="btn btn-primary btn-default btn-squared text-capitalize">
                                                        add new project
                                                    </button>
                                                    <button
                                                        class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">
                                                        cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                    <div class="table-responsive">
                        <table class="table mb-0 table-borderless" id="itemsDataTable">
                            <thead>
                                <th class="hidden">ID</th>
                            <tr class="userDatatable-header">
                                <th>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-checkbox  check-all">
                                            <input class="checkbox" type="checkbox" id="check-3">
                                            <label for="check-3">
                                                <span class="checkbox-text userDatatable-title">Código do Produto</span>
                                            </label>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Imagem</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Nome</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Código do Produto</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Preço</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Categoria</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Status</span>
                                </th>
                               {{--  <th>
                                    <span class="userDatatable-title">Criado Em:</span>
                                </th> --}}
                                 <th>
                                    <span class="userDatatable-title float-right">Ações</span>
                                </th>
                             
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="d-flex justify-content-end pt-30">
                        <nav class="atbd-page ">
                            <ul class="atbd-pagination d-flex">
                                <li class="atbd-pagination__item">
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="la la-angle-left"></span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">1</span></a>
                                    <a href="#" class="atbd-pagination__link active"><span
                                            class="page-number">2</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">3</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="page-number">...</span></a>
                                    <a href="#" class="atbd-pagination__link"><span
                                            class="page-number">12</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span
                                            class="la la-angle-right"></span></a>
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
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addNewItemModal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('restaurant.saveNewItem') }}" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="users">
                                <div class="card">
                                    <div class="">
                    
                       
                            <div class="col-md-6" style="padding-left: 0px; float: left;" >
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Informações Gerais do Produto</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl15 pr15">
                                       
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                    <label for="ean">Código de Barras (EAN)</label>
                                    <input required type="text" class="form-control ean" name="ean"
                                        id="ean" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Código de Barras (EAN)">

                                        <button type="button" class="btn btn-primary" id="addNewItem"
                    data-toggle="modal" data-target="#searchProduct">
                    <b><i class="icon-plus2"></i></b>
                    Pesquisar
                </button>
                                </div>
                                
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                    <label for="codint">Código Interno</label>
                                    <input required type="text" class="form-control codint" name="codint"
                                        id="codint" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Código Interno">
                                </div>
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input required type="text" class="form-control name" name="name"
                                        id="name" parsley-trigger="change"  data-parsley-group="form-step-1" 
                                        placeholder="Nome do Produto">
                                </div>
                               
                                <div class="form-group">
                                    <label for="desc">Descrição</label>
                                    <input  type="text" class="form-control"
                                        name="desc" id="desc"  data-parsley-group="form-step-1" parsley-trigger="change"
                                        placeholder="Descrição do Produto">
                                        
                                </div>
                                <div class="mb-25 ">
                                    <div class="">
                                       <select name="select-busca" id="select-busca" class="form-control ">
                                          
                                       </select>
                                    </div>
                                 </div>
                                <div class="form-group col-md-6"
                                        style="padding-left: 0px; float: left;">
                                            <div class="sel2">
                                            <label>Categoria do Produto: </label>
                                            <select class="form-control select" name="item_category_id" required>
                                                @foreach ($itemCategories as $itemCategory)
                                                <option value="{{ $itemCategory->id }}" class="text-capitalize">
                                                    {{ $itemCategory->name }}</option>
                                                @endforeach
                                            </select>
                                           
                                        </div>
                                </div>
                                <div class="form-group col-md-6" style="padding-left: 0px; float: left;">
                                    <label class="">Grupo de Adicionais:</label>
                                    <div class="">
                                        <select multiple="multiple" class="form-control wide" data-plugin="customselect" data-fouc
                                            name="addon_category_item[]">
                                            @foreach($addonCategories as $addonCategory)
                                            <option value="{{ $addonCategory->id }}" class="text-capitalize">
                                                {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                            @endforeach
                                        </select>

                                        
                                    </div>
                                </div> 

                               
                                
                                <div class="form-group row" style="display: none;" id="discountedTwoPrice">
                                    <div class="col-lg-6">
                                        <label>Preço (sem desconto) (R$): <i class="icon-question3 ml-1"
                                                data-popup="tooltip" title="{{__('storeDashboard.ipmMarkPriceToolTip')}}"
                                                data-placement="top"></i></label>
                                        <input type="text" class="form-control dinheiro" name="old_price"
                                            placeholder="Preço sem desconto (R$)">
                                    </div>
                                    <div class="col-lg-6">
                                        <label><span class="text-danger">*</span>Preço (com Desconto) (R$):</label>
                                        <input type="text" class="form-control dinheiro" name="price"
                                            placeholder="Preço com desconto (R$)" id="newSP">
                                    </div>
                                </div>
                                <div class="form-group row" id="singlePrice">
                                    
                                    <div class="col-lg-6">
                                        <label><span class="text-danger">*</span>Preço (R$):</label>
                                        <input type="text" class="form-control dinheiro" name="price"
                                            placeholder="Preço (R$)" required id="oldSP">
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left mr-2"
                                            id="addDiscountedPrice">
                                            <b><i class="icon-percent"></i></b>
                                            Marcar como Oferta
                                        </button>
                                    </div>
                                </div>
                               


                                </div>
                            </div>
                            </div> <!-- end col -->
                        
                    
                        
                            <div class="col-md-6" style="padding-left: 0px; float: left;" >
                                <div class="users">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <i class="<?//= $module_icon ?>" aria-hidden="true"></i> <h5>Imagem do Produto</h5>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body pl15 pr15">
                                            <div class="row">
                                                <div class="col-md-5" style="float: right;">

                                                    <div class="imagelogo">
                                                        <img class="slider-preview-image hidden" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7" style="padding: 20px;" style="float: right;">

                                                    <br>
                                                    <span>Clique no botão abaixo para fazer upload da imagem</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 20px;">
                                                    <div >
                                                        <input class="imagembanco" type="hidden" name="imagembanco" id="imagembanco">
                                                        <input  type="file" class="form-control image"
                                                            name="image"  parsley-trigger="change" id="image"
                                                           accept="image/x-png,image/gif,image/jpeg"
                                                            onchange="readURL(this);">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
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
<div id="addBulkItemModal" class="modal fade mt-5" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">{{__('storeDashboard.ipmCsvTitle')}}</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('restaurant.itemBulkUpload') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">{{__('storeDashboard.ipmLabelCsvFile')}}: </label>
                        <div class="col-lg-10">
                            <div class="uploader">
                                <input type="file" accept=".csv" name="item_csv"
                                    class="form-control-uniform form-control-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-left">
                        <button type="button" class="btn btn-primary" id="downloadSampleItemCsv">
                        {{__('storeDashboard.ipmBtnCsvDownloadSample')}}
                            <i class="icon-file-download ml-1"></i>
                        </button>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        {{__('storeDashboard.ipmBtnCsvUpload')}}
                            <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <div id="searchProduct" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Pesquisar Produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="users">
                            <div class="card">
                                <div class="card-body pl15 pr15">
                                    <div  class="select22" id="select22"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <script src="{{ asset('vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> --}}
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>

<script>
    $(function () {
        
        $('body').tooltip({selector: '[data-popup="tooltip"]'});
        
         var datatable = $('#itemsDataTable').DataTable({
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
                });  */
                

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
         });
    
        });
 

    
</script>
<script>
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
   
   $(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
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
      
           					$('#select-busca').select2({
						placeholder: 'Digite o Nome do Produto ou Código de Barras',
						minimumInputLength: 4,
                        dropdownParent: $("#addNewItemModal"),
						//templateResult: formatState,
						language: {
							errorLoading: function() {
								return "Não encontramos nenhum resultado para a pesquisa";
							},
							searching: function() {
								return "Pesquisando...";
							}
						},
						theme: "bootstrap",
						tags: true,

						//templateResult: format,
						ajax: {
							url: "https://painel.comprabakana.com.br/api/ajax_ofertas/",
							dataType: 'json',
							delay: 450,
                      

							processResults: function(data) {
								data = data.map(function(item) {
									return {
										id: item.ean,
										ean: item.ean,
										text: item.text,
										media: item.media,
										produto_nome: item.produto_nome,
										category: item.category
									};
								});
								return {
									results: data
								};
							},

							cache: true
						}

					}).on('change', function(e) {
						//var nome = $(this).find(':selected').data().data.produto_nome;
                        //$("#example").select2().find(":selected").data("id");
                        //var dataname = $("option[value=" + $(this).val() + "]", this).attr('data-ean');
                        //console.log($(e.target).select2("data-ean"));

                        
 // alert(dataTypeAttribute);
						var pkey = $(this).find(':selected').data().data.ean;
                        var nome = $(this).find(':selected').data().data.produto_nome;
                        //alert(pkey);
						//document.getElementById("produto_ean").readOnly = true;
						var imagenUrl = $(this).find(':selected').data().data.imagem;
						//var category = $(this).find(':selected').data().data.category;
						$(".imagembanco").attr("value", imagenUrl);
                        $(".name").attr("value", nome);
						$(".ean").attr("value", pkey); 
                        $("#searchProduct").modal("hide");
						//$(".produto_category").val(category);
                        $('.slider-preview-image').removeClass('hidden').attr("src", imagenUrl);
						/* $("input").attr("data-fileuploader-default", imagenUrl);
						$(".fileuploader-item-image img").attr("src", imagenUrl);
						$("input[type=hidden]").attr("value", '[{"file":"' + imagenUrl + '","is_default":true}]');
 */
					});         
/*     function readURL(input) {
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
    } */
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
        /* $('.summernote-editor').summernote({
                   height: 200,
                   popover: {
                       image: [],
                       link: [],
                       air: []
                     }
            });
        
        $('.select').select2(); */
    
       var recommendeditem = document.querySelector('.recommendeditem');
       new Switchery(recommendeditem, { color: '#f44336' });
    
       var popularitem = document.querySelector('.popularitem');
       new Switchery(popularitem, { color: '#8360c3' });
    
       var newitem = document.querySelector('.newitem');
       new Switchery(newitem, { color: '#333' });

       var vegitem = document.querySelector('.vegitem');
       new Switchery(vegitem, { color: '#008000' });
       
       $('.form-control-uniform').uniform();
       
        $('#downloadSampleItemCsv').click(function(event) {
           event.preventDefault();
           window.location.href = "{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/docs/items-sample-csv.csv";
       });
        $('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });

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
                   header: 'Operation Successful ✅',
                   theme: 'bg-success',
                   life: '1800'
               }); 
           })
           .fail(function(data) {
               console.log(data);
               $.jGrowl("", {
                   position: 'bottom-center',
                   header: 'Something went wrong, please try again.',
                   theme: 'bg-danger',
                   life: '1800'
               }); 
           })            
         });
    });
</script>
@endsection

{{-- @extends('admin.layouts.master') 
@extends('layouts.vertical',['isDarkSidebar' => false],['isCondensedSidebar' => false])

@section("title") {{__('storeDashboard.opTitle')}}
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{__('storeDashboard.total')}}</span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ $count }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <form action="{{ route('restaurant.post.searchOrders') }}" method="GET">
        <div class="form-group form-group-feedback form-group-feedback-right search-box">
            <input type="text" class="form-control form-control-lg search-input"
                placeholder="{{__('storeDashboard.opSearchPh')}}" name="query">
            <div class="form-control-feedback form-control-feedback-lg">
                <i class="icon-search4"></i>
            </div>
        </div>
        @csrf
    </form>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('storeDashboard.opTableOrderId')}}</th>
                            <th>{{__('storeDashboard.opTableRestName')}}</th>
                            <th>{{__('storeDashboard.opTableStatus')}}</th>
                            <th>{{__('storeDashboard.opPaymentMode')}}</th>
                            <th>{{__('storeDashboard.opTableTotal')}}</th>
                            <th>{{__('storeDashboard.opTableCoupon')}}</th>
                            <th>{{__('storeDashboard.opTableOrderPlacedAt')}}</th>
                            <th class="text-center" style="width: 10%;"><i class="
                                icon-circle-down2"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td><span style="font-size: 0.7rem; font-weight: 700;">{{ $order->unique_order_id }}</span></td>
                            <td>{{ $order->restaurant->name }}</td>
                            <td>
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left">
                                    @if ($order->orderstatus_id == 1) {{__('storeDashboard.opOrderStatus1')}} @endif
                                    @if ($order->orderstatus_id == 2) {{__('storeDashboard.opOrderStatus2')}} @endif
                                    @if ($order->orderstatus_id == 3) {{__('storeDashboard.opOrderStatus3')}} @endif
                                    @if ($order->orderstatus_id == 4) {{__('storeDashboard.opOrderStatus4')}} @endif
                                    @if ($order->orderstatus_id == 5) {{__('storeDashboard.opOrderStatus5')}} @endif
                                    @if ($order->orderstatus_id == 6) {{__('storeDashboard.opOrderStatus6')}} @endif
                                    @if ($order->orderstatus_id == 7) {{__('storeDashboard.opOrderStatus7')}} @endif

                                    @if($order->accept_delivery !== null)
                                    @if($order->orderstatus_id > 2 && $order->orderstatus_id  < 6)
                                    {{__('storeDashboard.opDeliveryBy')}}: <b>{{ $order->accept_delivery->user->name }}</b>
                                    @endif
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                {{ $order->payment_mode }}
                                </span>
                            </td>
                            @php
                               if(!is_null($order->tip_amount)) {
                                   $total = $order->total - $order->tip_amount;
                               } else {
                                   $total = $order->total;
                               }
                             @endphp
                            <td>{{ config('settings.currencyFormat') }} {{ $total }}</td>
                            <td>
                                @if($order->coupon_name == NULL) {{__('storeDashboard.opNone')}} @else
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                {{ $order->coupon_name }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <span  data-popup="tooltip" data-placement="bottom" title="{{ $order->created_at->format('Y-m-d  - h:i A') }}">
                                {{ $order->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('restaurant.viewOrder', $order->unique_order_id) }}"
                                    class="badge badge-primary badge-icon"> {{__('storeDashboard.opView')}} <i
                                    class="icon-file-eye ml-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}