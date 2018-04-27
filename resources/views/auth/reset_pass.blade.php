@php ($menu = 2)
@section('back', Route('login'))
@extends('layouts.base')
@section('js')
<script src="{{ URL::asset('js/resetPassword.js')}}"></script>
@endsection

@section('content')
<div class="card p-3 my-3 col-md-8 mx-auto">
@if (Route::currentRouteName() == 'recuperar_pass')
@section('title', 'Recuperar contraseña')
<form data-url="{{route('recuperar_pass')}}" id='password-request-form'>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="email" >Ingrese el correo con el que se registro</label>
        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
        <small class="text-secondary">Se te enviara un enlace a tu correo electronico con el cual podras recuperar tu contraseña.</small>
    </div>
    <input class="btn btn-sm btn-success" type="submit" value="recuperar" title='solicitar la recuperacion de la contraseña'>
    <input class='btn btn-sm btn-link text-danger' type="reset" value="limpiar" title='limpiar formulario de recuperacion'>
</form>
@else
@section('title', 'Reestablecer contraseña')
<form data-url="{{URL::current()}}" id="reestablecer-form">
    {!! csrf_field() !!}
    <div class="form-group">
        <label for='email'>Correo electronico registrado</label>
        <input type="email" class="form-control form-control-sm" name="email" id='email' value="{{ $email or old('email') }}">
    </div>
    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control form-control-sm mb-2" name="password" id='password'>
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input type="password" class="form-control form-control-sm" name="password_confirmation" id='password_confirmation'>
    </div>
    <input class="btn btn-sm btn-success" type="submit" value="cambiar contraseña">
</form>
<form ></form>
<small class="text-secondary mt-2">Completa el formulario para reestablecer tu contraseña.</small>
@endif
</div>
@endsection