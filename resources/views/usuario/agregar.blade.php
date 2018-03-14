@php ($menu = 2)
@section('title', 'Agregar contacto')
@section('back', URL::previous() )
@extends('layouts.base')

@section('css')
@endsection

@section('js')
<script src="{{ URL::asset('js/agregarContacto.js')}}"></script>
@endsection

@section('content')
    <div class="card my-3">
        <div class="card-body">
            <form data-url='{{ route('agregar_contacto') }}' id='contactoForm' >
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Correo electronico del contacto a agregar" maxlength="100" required>
                </div>
                <small class="text-secondary">Si el usuario ya esta registrado se agregara a tu lista de contactos, si no esta registrado se le enviara una invitacion.</small>
                <hr>
                <button type="submit" class="btn btn-sm btn-primary">Agregar contacto</button>
                <button type="reset" class="btn btn-sm btn-link text-danger">Limpiar</button>
            </form>
        </div>
    </div>
@endsection