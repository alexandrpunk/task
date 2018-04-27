@php ($menu = 2)
@section('title', 'Iniciar Sesion')
@extends('layouts.base')
@section('js')
<script src="{{ URL::asset('js/login.js')}}"></script>
@endsection

@section('content')
<div class="col-md-5 card p-0 my-3 mx-auto">
    <div class="card-heading text-center">
        <img class='logo-login' src="{{url('/img/logo-encargapp-circle.svg')}}" alt="encargapp">
        <p class='logo-login'>encargapp</p>
    </div>
    <div class="card-body pb-0">
        <form data-url="{{route('login')}}" id='login-form'>
            {{ csrf_field() }}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend text-light">
                        <span class="input-group-text bg-info text-light">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </span>
                    </div>
                    <input type="email" class="form-control form-control-sm" name="email" required autofocus placeholder="correo electronico">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend text-light">
                        <span class="input-group-text bg-info text-light">
                            <i class="fas fa-key" aria-hidden="true"></i>
                        </span>
                    </div>
                    <input type="password" class="form-control form-control-sm" name="password" required autocomplete="false" placeholder="contraseña">
                </div>                            
            </div>
            <div class="form-group text-center">
                <label><input type="checkbox"> Recordarme </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-info btn-block">
                    Iniciar Sesion
                </button>
                <a class="small text-info d-block text-center my-2" href="{{route('recuperar_pass')}}">Olvide mi contraseña</a>
            </div>
        </form>
    </div>
    <div class="card-footer bg-info  text-center">
        <a class="small text-light font-weight-bold d-block" href="{{url('registro')}}">Si no tienes cuenta haz click aqui</a>
    </div>
</div>
@endsection
