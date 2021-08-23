<div >
  <!-- Edit Profile -->
  <div class="edit-profile edit-social ">
      <div class="card">
          <div class="card-header  px-sm-25 px-3">
              <div class="edit-profile__title">
                  <h6>Configurações de Retirada</h6>
                  <span class="fs-13 color-light fw-400"></span>
              </div>
              <div class="button-group d-flex flex-wrap pt-30 mb-15">
                <button type="submit" form="selfpicypsettings_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar 
                </button>
                {{-- <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                </button> --}}
            </div>
          </div>
          <div class="card-body">
              <div class="row justify-content-center">
                  <div class="col-lg-9">
                      <div class="edit-profile__body mx-lg-20">

                        <div class="atbd-nav-controller">
                            <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                
                               <a href="{{ route('panel.salesSettings') }}" class="btn btn-sm btn-outline-light nav-link" id="size-tipo_entrega"  aria-controls="tipo_entrega" aria-selected="false">Tipo de Venda</a>
                               @if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3))
                               <a href="{{ route('panel.DeliveryTime') }}" class="btn btn-sm btn-outline-light nav-link " id="size-default"  aria-controls="default" aria-selected="false"> Tempo de Entrega</a>
                               @endif
                               @if(($restaurant->delivery_type == 2 )|| ($restaurant->delivery_type == 3))
                                <a href="{{ route('panel.SelfpickupTime') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-small"  aria-controls="small" aria-selected="true">Tempo de Retirada</a>
                                @endif
                                
                            </div>
                         </div>


                        <form 
                        action="{{ route('settings.saveSelfpickupTime') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        
                        >
                        @csrf
                        <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">

                        
                        
                        <div class="form-group mb-20 mt-30">
                           

                                 
                                
                                    <label for="delivery_radius">Tempo para Retirada na Loja:</label>
                                    <div class="row">
                                    <div class='col-lg-6' style="float: left;">
                                    <input 
                                    type="number" 
                                    value="{{$restaurant->selfpickup_time}}"
                                    class="form-control  delivery_radius"
                                    name="selfpickup_time" 
                                    placeholder="Tempo para Retirada na Loja " 
                                   required
                                   
                                    >
                                    </div>
                                    <div class='col-lg-6' style="float: right;">
                                       <select class="js-example-basic-single js-states form-control"
                                       name="selfpickup_time_type" id="bank" data-parsley-required="true">
                                       <option value="min" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='min') { echo "selected"; } ?> >Minutos</option>
                                       <option value="horas" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='horas') { echo "selected"; } ?> >Horas</option>
                                       <option value="dias" class="text-capitalize" <?php if ($restaurant->selfpickup_time_type ==='dias') { echo "selected"; } ?> >Dias</option>

                                   </select>
                                 </div>
                              </div>
                              </div>
                                

                        

                              
                              <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                 <button type="submit" class="btn btn-danger btn-default btn-squared mr-15">Salvar e Continuar<i class="ml-10 mr-0 las la-arrow-right"></i>
                                 </button>
                                 
                           </div>
                           
                              
                           </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Edit Profile End -->
</div>

@section('scripts')
<script>
     $(document).ready(function() {
                var status= "<?php  echo $restaurant->status; ?>";  
                 /* if (status<=7) {
                    $('.sidebar').addClass('hiddeen');
                    $('.contents').addClass('contents2');
                } */
                if (status<=20) {
                    $('.sidebar').addClass('collapsed');
                    $('.contents').addClass('expanded');
                }
                });
    </script>
@endsection