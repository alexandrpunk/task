@php ($menu = 2)
@section('title', 'Agregar contacto')
@section('back', route('listar_contactos'))
@extends('layouts.base')

@section('content')
    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="{{ route('agregar_contacto') }}" data-toggle="validator">
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