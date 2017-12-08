@php ($menu = 2)
@section('title', 'Registrar nueva cuenta')
@section('back', route('login'))
@extends('layouts.base')
@section('css')
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.common.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.default.mobile.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.bootstrap.min.css" />
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">-->
<style>

    span.k-widget.k-tooltip-validation {
        display; inline-block;
        text-align: left;
        border: 0;
        padding: 0;
        margin: 0;
        background: none;
        box-shadow: none;
        color: red;
    }

    .k-tooltip-validation .k-warning {
        display: none;
    }
</style>
@endsection

@section('js')
<script src="http://kendo.cdn.telerik.com/2017.3.1026/js/kendo.all.min.js"></script>
<script>
    $("form").kendoValidator({
              rules: {
                  verifyPasswords: function(input){
                     var ret = true;
                             if (input.is("[name=confirmar]")) {
                                 ret = input.val() === $("#password").val();
                             }
                             return ret;
                  }
              },
              messages: {
                  verifyPasswords: "¡Whoops! Las contraseñas con coinciden",
                  required: "Campo obligatorio"
              }
    });
</script>
<!--<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>-->
@endsection

@section('content')
    @if (session('registro_exitoso'))
    <div class="jumbotron text-center">
        <h1>¡Ya casi terminamos tu registro!</h1>
        <p>Tu cuenta ya casi esta lista, hemos enviado un email para a: <code>{{ session('email') }}</code> solicitando la validacion.</p>
        <p><strong>Una vez validado tu correo podras inicar sesion en el sistema.</strong></p>
        <p><small>Si tu direccion de correo es incorrecta solo vuelve a inciar el proceso de registro.</small></p>
    </div>
    @else
    <div class="card p-3 my-3">
        <form method="POST" action="{{ route('registrar') }}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{old('nombre')}}" placeholder="Nombre" maxlength="100" required>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="{{old('apellido')}}" placeholder="Apellido" maxlength="100" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="email">Correo Electronico</label>
                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Correo Electronico" maxlength="100" required >
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="telefono">Celular</label> <small class='text-muted'>(No es obligatorio)</small>
                    <input type="tel" pattern="\d{10}" class="form-control" name="telefono" value="{{old('telefono')}}" placeholder="Numero Celular" maxlength="10" validationMessage="Debe ser un numero telefonico de 10 digitos">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-6 mb-sm-0">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id='password' name="password" placeholder="Contraseña" minlength="8" maxlength="15" required autocomplete="off">
                </div>
                <div class="form-group col-12 col-sm-6  mb-0">
                    <label for="confirmar">Confirmar contraseña</label>
                    <input type="password" class="form-control " name="confirmar" placeholder="Repetir Contraseña" minlength="8" maxlength="15" required autocomplete="off">
                </div>                
            </div>
            <hr>
            <button type="reset" class="btn btn-danger">Limpiar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    @endif
@endsection