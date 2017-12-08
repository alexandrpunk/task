@php ($menu = 2)
@section('title', 'Recuperar contraseña')
@section('back', Route('login'))
@extends('layouts.base')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Recuperar contraseña</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Route::currentRouteName() == 'recuperar_pass')
                    <p class="text-center text-info">Se te enviara un enlace a tu correo electronico con el cual podras recuperar tu contraseña</p>
                    <form class="form-horizontal" method="POST" action="{{route('recuperar_pass')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email" class="col-xs-2 control-label">Email:</label>
                            <div class="col-xs-10">
                            <input type="email" class="form-control" id="email" placeholder="Ingrese el correo con el que se registro" name="email">
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success" type="submit">
                                Recuperar contraseña
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="text-center text-info">Ingresa la nueva contraseña para tu cuenta</p>
                        <form class="form-horizontal" role="form" method="POST" action="">
                            {!! csrf_field() !!}
                            <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password_confirmation">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-refresh"></i>Cambiar contraseña
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection