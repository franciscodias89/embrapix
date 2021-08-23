@extends('layouts.wizard')
@section('styles')

<style>
    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }

    #mapp {
        width: 100%;
        height: 400px;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    .card .card-header {
    padding-top: 10px;
    background: #ffffff;
}

    hr {
    margin-top: 1.67rem;
    margin-bottom: 1.67rem;
    border: 0;
    border-top: 1px solid #e3e6ef;
}

.fileuploader-theme-avatar {
    position: relative;
    width: 160px;
    height: 160px;
    padding: 0;
    margin: 30px;
    background: none;
}
body {
   background: #fbfbfb;
}

</style>
@endsection

@section('content')

   <div class="mt-50">
   <div class="container-fluid">
     
      <div class=" checkout wizard1 wizard7 global-shadow px-sm-50 px-20 py-sm-50 py-30 mb-30 bg-white radius-xl w-100">
        
         <div class="row justify-content-center">
           
            <div class="col-xl-8">
               
               <div class="row justify-content-center">
                  <div class="col-xl-7 col-lg-8 col-sm-10">
                     <div class="card checkout-shipping-form px-30 pt-2 pb-30 border-color">
                        <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                          <h4 class="fw-500"><strong>Pronto! </strong></h4>
                          
                            </div>
                            <div class="card-header border-bottom-0 align-content-start pb-sm-0 pb-1 px-0">
                              <h4 class="fw-500"><strong>Parabéns, {{ $restaurant->name }}</strong></h4>
                                 </div>
                                 <div class='' style="text-align: center;" >
                                    <br>  
                                    <img class="light" style="width: 270px;" src="https://app.comprabakana.com.br/assets/img/illustrations/start.png" alt="">
                                    <br><br>     
                                </div>

                            <p><span class="mt-30"> Parabéns! Você já completou as principais etapas de seu cadastro!<span></p>
                                <p><span class="mt-30">  Agora o próximo passo é começar a cadastrar produtos, ofertas, promoções, e...<span></p>
                                    <p><span >   Começar a Vender!!!</span></p>
                       
                        <div class="card-body px-0 pb-0">
                           <div class="edit-profile__body">
                              <form action="{{ route('wizard.savewizard_1') }}" method="POST"  enctype="multipart/form-data">
                                 @csrf
                                 <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                                

                              
                                

                                   
                                 <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                    <a href="{{ route('wizard.wizard_panel') }}" class="btn text-white btn-danger btn-default btn-squared text-capitalize m-1">Vamos Lá!<i class="ml-10 mr-0 las la-arrow-right"></i></a>
                                 </div>
                               
                                 
                              </form>
                           </div>
                        </div>
                     </div>
                     <!-- ends: card -->
                  </div>
                  <!-- ends: col -->
               </div>
            </div>
            <!-- ends: col -->
         </div>
      </div>
      <!-- End: .global-shadow-->
   </div>
</div>
@endsection

@section('scripts')


@endsection
