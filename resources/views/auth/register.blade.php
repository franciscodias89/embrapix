

@extends('layouts.app')
@section('content')
    <div class="signUP-admin">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-5 p-0">
                    <div class="signUP-admin-left position-relative">
                        <div class="signUP-overlay">
                            <img class="svg signupTop" src="{{ asset('img/svg/signupTop.svg') }}" alt="img"/>
                            <img class="svg signupBottom" src="{{ asset('img/svg/signupBottom.svg') }}" alt="img"/>
                        </div>
                        <div class="signUP-admin-left__content">
                            <div
                            class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                            
                            <img class="light" style="width: 250px;" src="https://app.comprabakana.com.br/assets/img/CompraBakana2.png" alt="">
                            
                        </div>
                            <h1>Compra Bakana, o APP amigo do comerciante!</h1>
                        </div>
                        <div class="signUP-admin-left__img">
                            <img class="img-fluid svg" src="{{ asset('img/svg/signupIllustration.svg') }}" alt="img"/>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                    <div class="signUp-admin-right  p-md-40 p-10">
                        <div
                            class="signUp-topbar d-flex align-items-center justify-content-md-end justify-content-center mt-md-0 mb-md-0 mt-20 mb-1">
                            <p class="mb-0">
                                Já possui uma conta?
                                <a href="{{ route('post.login') }}" class="color-primary">
                                    Entrar
                                </a>
                            </p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-10 col-md-12 ">
                                <div class="edit-profile mt-md-25 mt-0">
                                    <div class="card border-0">
                                        <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                            <div class="edit-profile__title">
                                                <h6>Cadastre seu Estabelecimento</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="edit-profile__body">

                                                @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>
                                <br>@endif
                                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>
                                <br>@endif

                                                <form method="POST" action="{{ route('registerRestaurantDelivery') }}" class="authentication-form" id="regForm" data-parsley-trigger="keyup" data-parsley-validate>
                                                    @csrf
                                                    <input type="text"
                                                    name="role" value="RESOWN"
                                                    class="hidden"
                                                    id="role" />
                                                    <div class="form-group">
                                                        <label class="form-control-label">Nome (Responsável pelo Cadastro)</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="user"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text"
                                                                required name="name" value="{{ old('name')}}"
                                                                class="form-control " id="validationDefault01"
                                                                id="name" placeholder="Seu Nome Completo" 
                                                                parsley-trigger="change" 
                                                                data-parsley-error-message="Favor inserir o seu Nome Completo" 
                                                                data-parsley-errors-container="#parsley-name"/>
                                                            
                                                            @if($errors->has('name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-name"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">Nome do Estabelecimento</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="home"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text"
                                                                required name="estabelecimento" value="{{ old('estabelecimento')}}"
                                                                class="form-control @if($errors->has('estabelecimento')) is-invalid @endif"
                                                                id="estabelecimento" placeholder="Nome do seu Estabelecimento"
                                                                parsley-trigger="change" 
                                                                data-parsley-error-message="Favor inserir o nome do estabelecimento" 
                                                                data-parsley-errors-container="#parsley-estabelecimento"/>
                                                            

                                                                
                
                                                            @if($errors->has('estabelecimento'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('estabelecimento') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-estabelecimento"></div>
                                                    </div>
                                                    
                                                    <div class="form-group mb-20">
                                                        <label class="form-control-label">Email</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="mail"></i>
                                                                </span>
                                                            </div>
                                                            <input type="email"
                                                                required name="email" value="{{ old('email')}}"
                                                                class="form-control @if($errors->has('email')) is-invalid @endif"
                                                                id="email" placeholder="exemplo@dominio.com" 
                                                                data-parsley-errors-container="#parsley-email"/>
                
                                                            @if($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-email"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-control-label">Telefone (Whatsapp do Responsável pelo Cadastro)</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="mail"></i>
                                                                </span>
                                                            </div>
                                                            <input type="phone"
                                                                required name="phone" value="{{ old('phone')}}"
                                                                class="form-control phone"
                                                                id="phone" placeholder="Ex: (99) 99999-9999" 
                                                                parsley-trigger="change"
                                                            
                                                                data-parsley-errors-container="#parsley-phone"
                                                                />
                
                                                            @if($errors->has('phone'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-phone"></div>
                                                    </div>

                                                  

                                                    <div class="form-group mb-15">
                                                        <label class="form-control-label">Senha</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="lock"></i>
                                                                </span>
                                                            </div>
                                                            <input type="password"
                                                                required name="password"
                                                                class="form-control @if($errors->has('password')) is-invalid @endif"
                                                                id="password" placeholder="Crie uma Senha" 
                                                                parsley-trigger="change"
                                                                data-parsley-minlength="8" 
                                                                data-parsley-uppercase="1"
                                                                data-parsley-uppercase-message="Sua senha precisa ter pelo menos %s letra maiúscula"
                                                                data-parsley-lowercase="1"
                                                                data-parsley-lowercase-message="Sua senha precisa ter pelo menos %s letra minúscula"
                                                                data-parsley-number="1"
                                                                data-parsley-number-message="Sua senha precisa ter pelo menos %s número"
                                                                data-parsley-errors-container="#parsley-password"
                                                                />
                
                                                            @if($errors->has('password'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-password"></div>
                                                    </div>
                                                   

                                                    <div class="form-group mb-15">
                                                        <label class="form-control-label">Confirmar Senha</label>
                                                        <div class="input-group input-group-merge">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="icon-dual" data-feather="lock"></i>
                                                                </span>
                                                            </div>
                                                            <input type="password"
                                                                required name="confirm_password"
                                                                class="form-control @if($errors->has('confirm_password')) is-invalid @endif"
                                                                id="confirm_password" placeholder="Confirme sua Senha" 
                                                                parsley-trigger="change"
                                                                data-parsley-minlength="8" 
                                                                data-parsley-equalto-message="As senhas não conferem"
                                                                data-parsley-equalto="#password"
                                                                data-parsley-minlength-message="Sua senha precisa ter pelo menos 8 caracteres" 
                                                                data-parsley-required="true"
                                                                data-parsley-errors-container="#parsley-confirm_password"/>
                
                                                            @if($errors->has('confirm_password'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div id="parsley-confirm_password"></div>
                                                    </div>

                                                    <div class="signUp-condition">
                                                        <div class="checkbox-theme-default custom-checkbox ">
                                                            <input required class="checkbox" type="checkbox" id="check-1">
                                                            <label for="check-1">
                                                                <span class="checkbox-text">Ao criar a conta, você concorda com nossos
                                                                     <a href="#" class="color-secondary">Termos de Uso</a> e nossa <a href="#"
                                                                                           class="color-secondary">Política de Privacidade</a>
                                                                   </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                        <button
                                                            class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signUp-createBtn signIn-createBtn">
                                                            Criar Conta
                                                        </button>
                                                    </div>
                                                </form>
                                               {{--  <p class="social-connector text-center mb-md-25 mb-15  mt-md-30 mt-20 ">
                                                    <span>Or</span></p>
                                                <div
                                                    class="d-flex align-items-center justify-content-md-start justify-content-center">
                                                    <ul class="signUp-socialBtn">
                                                        <li>
                                                            <button class="btn text-dark px-30">
                                                                <img class="svg"
                                                                src="{{ asset('img/svg/google.svg') }}"
                                                                alt="img"/> Sign up
                                                                with Google
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class=" radius-md wh-48 content-center"><img
                                                                    class="svg" src="{{ asset('img/svg/facebook.svg') }}" alt="img"/>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="radius-md wh-48 content-center"><img
                                                                    class="svg" src="{{ asset('img/svg/twitter.svg') }}" alt="img"/>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>

$(document).ready(function() {
    $(".dinheiro").mask('#.##0,00', {
        reverse: true
    });
    $(".agencia").mask('000.000.000-00', {
        reverse: true
    });
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
//
//MASCARA DE TELEFONE
    var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('.phone').mask(behavior, options);
//MASCARA DE TELEFONE - FIM

});

</script>
@endsection