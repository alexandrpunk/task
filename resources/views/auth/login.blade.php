@section('title', 'Iniciar Sesion')
@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Iniciar Sesion</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{route('login')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" required autocomplete="off">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar Sesion
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <p class="text-center"><a class="" href="{{url('registro')}}">Si no tienes cuenta haz click aqui</a></p>
                    <p class="text-center"><a class="" href="{{route('recuperar_pass')}}">Olvide mi contraseña</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
