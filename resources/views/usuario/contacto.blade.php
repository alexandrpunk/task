@section('title', 'Contacto y reporte de errores')
@extends('layouts.base')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Añadir contacto a mi lista</div>
        <div class="panel-body">
            <form method="POST" action="{{ route('agregar') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Correo electronico del contacto a agregar" maxlength="100" required>
                    <div class="help-block with-errors"></div>
                </div>
                <p class="help-block">Si el usuario ya esta registrado se agregara a tu lista de contactos, si no esta registrado se le enviara una invitacion.</p>
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-primary">Agregar contacto</button>
            </form>
        </div>
    </div>
@endsection