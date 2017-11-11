@section('title', 'Iniciar Sesion')
@extends('layouts.base')

@section('content')
<div class="col col-md-5 col-sm-9 mx-auto py-3 px-0">
    <div class="card">
        <div class="card-heading text-center">
            <img class='logo-login' src="{{url('/img/logo-encargapp-circle.svg')}}" alt="encargapp">
            <p class='logo-login'>encargapp</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('login')}}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon bg-info text-light"><i class="fa fa-user-circle" aria-hidden="true"></i></div>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block"></span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon bg-info text-light"><i class="fa fa-key" aria-hidden="true"></i></div>
                        <input type="password" class="form-control" name="password" required autocomplete="off">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block"></span>
                    @endif                            
                </div>
                <div class="form-group text-center">
                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block">
                        Iniciar Sesion
                    </button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-info py-1 text-center">
            <a class="small text-light d-block m-1" href="{{route('recuperar_pass')}}">Olvide mi contraseña</a>
            <a class="small text-light font-weight-bold d-block m-1" href="{{url('registro')}}">Si no tienes cuenta haz click aqui</a>
        </div>
    </div>
</div>

@endsection
