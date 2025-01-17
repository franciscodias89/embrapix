@extends('layouts.non-auth')

@section('content')

<div class="account-pages my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-6 p-5">
                                <div class="mx-auto mb-5">
                                    <a href="/">
                                        <img src="../assets/images/logo_site_cor.png" alt="" height="45" />
                                        
                                    </a>
                                </div>

                                <h6 class="h5 mb-0 mt-4">Seja Bem-Vindo(a)!</h6>
                                <p class="text-muted mt-1 mb-4">Digite seu email e senha para acessar o painel. </p>

                                @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>
                                <br>@endif
                                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>
                                <br>@endif

                                <form action="{{ route('post.login') }}" method="post" class="authentication-form">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="mail"></i>
                                                </span>
                                            </div>
                                            <input type="email"
                                                class="form-control @if($errors->has('email')) is-invalid @endif" id="
                                                email" placeholder="hello@coderthemes.com" name="email" value="{{ old('email')}}" />

                                            @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label class="form-control-label">Senha</label>
                                       {{--  <a href="{{ route('password.request') }}"
                                            class="float-right text-muted text-unline-dashed ml-1">Forgot your
                                            password?</a> --}}
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password"
                                                placeholder="Enter your password"  name="password" />

                                            @if($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="checkbox-signin"
                                            checked="checked" />
                                            <label class="custom-control-label" for="checkbox-signin">Permanecer Conectado</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> Entrar
                                        </button>
                                    </div>
                                </form>

                             {{-- <div class="py-3 text-center"><span class="font-size-16 font-weight-bold">Or</span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="" class="btn btn-white"><i
                                                class='uil uil-google icon-google mr-2'></i>With Google</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="" class="btn btn-white"><i
                                                class='uil uil-facebook mr-2 icon-fb'></i>With Facebook</a>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-lg-6 d-none d-md-inline-block">
                                <div class="auth-page-sidebar">
                                    <div class="overlay"></div>
                                    <div class="auth-user-testimonial">
                                        <p class="font-size-24 font-weight-bold text-white mb-1">I simply love it!</p>
                                        <p class="lead">"It's a elegent templete. I love it very much!"</p>
                                        <p>- Admin User</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Ainda não possui uma conta? <a href="/register"
                                class="text-primary font-weight-bold ml-1">Cadastre-se</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

@endsection