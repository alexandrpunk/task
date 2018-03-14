@php ($menu = 2)
@section('title', 'Crear Encargo')
@section('back', URL::previous() )
@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/crearEncargo.css')}}">
@endsection

@section('js')
<script src="{{ URL::asset('js/crearEncargo.js')}}"></script>
@endsection

@section('content')
    <div class="card my-3">
        {{--  seleccion de encargado  --}}
        <div class="card-body" id='pagina-contacto'>
            <h3>Seleccionar responsable</h3>
            <div class="form-group">
                <input type="text" class="form-control" id="filtrarContactos" placeholder="Buscar contacto..." onkeyup="filtrarLista()">
                <div class="contact-list">
                @foreach (Auth::user()->contactos as $contacto)
                @if ( is_null($contacto->contacto->display) ) @php($contacto->contacto->display = 'avatar.jpg')@endif
                <div class="contact-item text-truncate" data-nombre='{{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}}' data-email='{{$contacto->contacto->email}}' data-display='{{ url('storage/profile') }}/{{ $contacto->contacto->display }}' data-id='{{$contacto->contacto->id}}' role="option">
                    <img src="{{ url('storage/profile') }}/{{ $contacto->contacto->display }}" class="display-contact">
                    <span>{{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}}</span>
                    <small class='text-muted'> - {{$contacto->contacto->email}}</small>
                </div>
                @endforeach
                </div>
            </div>
        </div>
        {{-- formulario del encargo --}}
        <div class="card-body d-none" id='pagina-encargo'>
            <label aria-hidden="true">Responsable:</label>
            <div class="responsable-view d-none" id="block-responsable">
                <div role='option' class="d-inline-block">
                <div class="sr-only">Responsable: </div>
                <span id='responsable'class="d-inline-block text-truncate"></span>
                </div>
                <button class="btn btn-sm btn-link" id='cambioResponsable' aria-label="cambiar responsable">cambiar</button>
            </div>
            <form data-url='{{Route('nuevo_encargo')}}' id='encargoForm' >
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="encargo" aria-hidden='true'>Encargo</label>
                    <textarea class="form-control form-control-sm" id='encargo' name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required>{{old('encargo')}}</textarea>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-sm-2 mb-sm-0">
                        <label for="fecha_limite" aria-hidden='true'>Fecha limite</label>
                        <input type="date" class="form-control form-control-sm" id='fecha_limite' name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Selecciona la fecha para el encargo" required >
                    </div>
                </div>        
                <hr aria-hidden='true'>
                <button type="submit" class="btn btn-sm btn-success">Enviar encargo</button>
                <button type="reset" class="btn btn-sm btn-link text-danger">Limpiar</button>
            </form>
        </div>
    </div>
@endsection