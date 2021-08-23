<div class="tab-pane fade show " id="v-pills-panelPublicar" role="tabpanel" aria-labelledby="v-pills-panelPublicar-tab">
  <!-- Edit Profile -->
  <div class="edit-profile ">
      <div class="card">
          <div class="card-header px-sm-25 px-3">
              <div class="edit-profile__title">
                  <h6>Publicar sua Loja no Aplicativo</h6>
                  {{-- <span class="fs-13 color-light fw-400">Informações gerais sobre o seu estabelecimento.</span> --}}
              </div>
              
              
          </div>
          <div class="card-body">
              <div class="row justify-content-center">
                  <div class="col-xl-8 col-lg-10 col-sm-10">
                      <div class="edit-profile__body mx-lg-20">
                          
                        <span>Se Você já:</span>
                        <br><br>
                        <span>1) Finalizou o cadastro dos dados de sua loja</span>
                        <br><br>
                        <span>2) Preencheu as informações de Delivery (tempo de entrega, taxas de entrega, etc)</span>
                        <br><br>
                        <span>3) Configurou as formas de Pagamento</span>
                        <br><br>
                        <span>4) Cadastrou Produtos, categorias</span>
                        <br><br>
                        <span>5) Cadastrou Cashback ou pelo menos 1 cupom de desconto</span>
                        <br><br>
                        <span>6) Fez um teste de Pedido em sua loja no app, impressão de pedidos, e está tudo certo com essa parte</span>

                        <br><br>
                        <span>...Você poderá então clicar no botão abaixo e solicitar a publicação de sua loja no App.</span>
                        <br>
                          
                        <form 
                        action="{{ route('settings.publishStore') }}" 
                        method="POST" 
                        id="configuracoes_form" 
                        enctype="multipart/form-data" 
                        data-parsley-trigger="keyup" 
                        data-parsley-validate
                        >
                        @csrf
                                   <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
                              
                              <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                <button type="submit" form="configuracoes_form" class="btn text-white btn-danger btn-default btn-squared text-capitalize m-1">Publicar Loja no APP! 
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