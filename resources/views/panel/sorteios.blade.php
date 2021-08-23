@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


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
                        <h4 class="text-capitalize breadcrumb-title">Sorteios</h4>
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
                            {{-- <div class="project-category d-flex align-items-center ml-md-30 mt-xl-10 mt-15">
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
                                            <a class="nav-link" id="activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Desativados
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="draft-tab" data-toggle="pill" href="#draft" role="tab" aria-controls="draft" aria-selected="false">Ofertas</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- End: .project-category --> --}}
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                @if($restaurant->status == 8)
                                <a href="{{ route('wizard.wizard_panel') }}"
                                class="btn btn-light">
                                <b></b>Voltar</a>
                                @endif
                                
                                <button type="button" class="btn btn-primary" id="addNewFlyer"
                                data-toggle="modal" data-target="#addNewAddonModal">
                                <b><i class="icon-plus2"></i></b>
                                Adicionar Sorteio</button>

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
                                        
                                        <th><span class="userDatatable-title">Imagem</span></th>
                                        <th><span class="userDatatable-title">Nome</span></th>
                                        <th><span class="userDatatable-title">Descrição</span></th>
                                        <th><span class="userDatatable-title">Status</span></th>
                                        
                                        <th style="width: 15%"><span class="userDatatable-title">Sorteio em:</span></th>
                                        <th class="text-center" style="width: 10%;"><i class="
                                            icon-circle-down2"></i><span class="userDatatable-title">Ações</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sorteios as $sorteio)
                                            <tr class="item">
                                                <td style="white-space:normal;">
                                                   <img src="{{ $sorteio->image }}" width="100px">
                                                    </div>
                                                </td>
                                                <td style="white-space:normal;">
                                                    <div class="orderDatatable-title">{{ $sorteio->name }}
                                                    </div>
                                                </td>
                                                <td style="white-space:normal;">
                                                    <div class="orderDatatable-title">{{ $sorteio->description }}
                                                    </div>
                                                </td>
                                                
                                                
                                                <td>
                                               
                                                    @if(($sorteio->is_active)==1)
                                                  
                                                    <div class="orderDatatable-status d-inline-block">
                                                       <span class="order-bg-opacity-success  text-success rounded-pill active">Ativo</span>
                                                   </div>
                                                   
                                                   @endif
                                                   @if(($sorteio->is_active)==0)
                                                   <div class="orderDatatable-status d-inline-block">
                                                       <span class="order-bg-opacity-danger  text-danger rounded-pill active">Desativado</span>
                                                   </div>
                                                   @endif
                                                   
                                               </td>
                                              
                                                <td><div class="orderDatatable-title">{{ date('d/m/Y', strtotime($sorteio->expiry_date))  }}</div></td>
                                                <td class="text-center">

                                                   
                                                        <div class="" style="display: inline-block; vertical-align: top;">
                                                            <a href="{{ route('panel.get.getEditSorteio', $sorteio->id) }}" class="btn btn-primary">Editar</a>
                                                        </div>
                                                       
                                                       
                                                        
                                                    
                                                    
                                                </td>
                                                    </div>
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
                    
                     <div class="mt-4">
                        {{ $sorteios->appends($_GET)->links() }}
                    </div> 
                    
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












<div id="addNewAddonModal" class="modal fade">
   
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Sorteio</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.post.saveNewSorteio') }}" method="POST" enctype="multipart/form-data" data-parsley-trigger="keyup" data-parsley-validate>

                    <div class="new-member-modal">
                        <div class="row col-md-12">
                            <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Dados do Sorteio</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl30 pr30">
                                      {{--   <div class="form-group row" style="margin-left: 15px;"> 
                                            <div class="custom-control custom-switch switch-primary switch-md ">
                                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                                <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Sorteio Ativo</label>
                                                <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Sorteio Desativado</label>
                                             </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-md-5" style="float: right;">

                                                    <div class="imagelogo">
                                                        <img class="slider-preview-image hidden" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7" style="padding: 20px;" style="float: right;">

                                                    <br>
                                                    <span>Clique no botão abaixo para fazer upload de uma imagem ilustrativa do sorteio.</span>
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
                                       
                                        
                                            <div class="form-group col-md-12 mt-40" >
                                                <label for="min_subtotal"><span class="text-danger"></span>Título:</label>
                                                  <div class="input-group input-group-merge">
                                                    <input 
                                                    type="text" 
                                                    class="form-control form-control-lg" 
                                                    name="name"
                                                    placeholder=""   
                                                    required>
                                                </div> 
                                            </div>

                                            <div class="form-group col-md-12" >
                                                <label for="min_subtotal"><span class="text-danger"></span>Descrição:</label>
                                                  <div class="input-group input-group-merge">
                                                    <textarea 
                                                    type="text" 
                                                    class="form-control form-control-lg" 
                                                    name="description"
                                                    placeholder=""   
                                                    required></textarea>
                                                </div> 
                                            </div>
                                            
                                                
                                            
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-6" style="padding-left: 0px;">
                                                <label for="expiry_date"><span class="text-danger"></span>Data do Sorteio:</label>
                                                    <input type="date" class="form-control form-control-lg" name="expiry_date"
                                                     placeholder=""  required>
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
                        </div>
                    </div>
                    @csrf
                    <br><br>
                    <div class="text-right" style=" display: inline-block; vertical-align: top;">
                        <button type="submit" style=" display: inline-block; vertical-align: top;" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                        Salvar Sorteio
                        </button>
                        <button  data-dismiss="modal"  style=" marging-left:20px; display: inline-block; vertical-align: top;" class="btn btn-light btn-default btn-squared ">
                            <i class="fas fa-arrow-left"></i>
                        Cancelar
                        </button>
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
<script>
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


function valueChanged()
    {
        if($('#radio-un2').is(":checked")) {
            $("#value_amount").show().find("input").prop("required", true);
            $("#value_percentage").hide().find("input").prop("required", false);
        }else{
            $("#value_amount").hide().find("input").prop("required", false);
            $("#value_percentage").show().find("input").prop("required", true);
        }
        if($('#radio-un4').is(":checked")) {
            $("#value_amount").hide().find("input").prop("required", false);
            $("#value_percentage").show().find("input").prop("required", true);
        }  
            
        else{
            $("#value_amount").show().find("input").prop("required", true);
            $("#value_percentage").hide().find("input").prop("required", false);
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


