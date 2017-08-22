@section('title', 'Registro')
@extends('layouts.base')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('registrar') }}" data-toggle="validator">
           {!! csrf_field() !!}
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{old('nombre')}}" placeholder="Nombre" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" value="{{old('apellido')}}" placeholder="Apellido" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electronico</label>
                <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Correo Electronico" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="phone" class="form-control" name="telefono" value="{{old('telefono')}}" placeholder="Numero Telefonico" maxlength="100">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id='password' name="password" placeholder="Contraseña" minlength="8" maxlength="15" required>
                <input type="password" class="form-control " name="password-comp" placeholder="Repetir Contraseña" data-match="#password" data-match-error="Whoops, las contraseñas no coinciden" minlength="8" maxlength="15" required>
                <div class="help-block with-errors"></div>
            </div>
            
            <button type="reset" class="btn btn-danger">Limpiar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div><!-- /.container -->
@endsection