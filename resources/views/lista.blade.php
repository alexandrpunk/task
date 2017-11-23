@extends('layouts.base')
<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('title', $titulo)
@if (Route::currentRouteName() == 'encargos_contacto')
@section('back', Route('listar_contactos'))
@endif

@section('css')
@endsection

@section('js')
<script src="/js/listar_encargos.js"></script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
@endsection

@section('content')
    <section class="py-3" role='region'>
     <span class="sr-only" role='heading'>Titulo de la seccion: @yield('title')</span>
        <div class="input-group mb-3" role='search'>
            <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
            <input type="search" class="form-control" oninput="w3.filterHTML('.list-group', '.list-group-item', this.value)" placeholder='buscar...'>
        </div>
        @if (Route::currentRouteName() == 'listar_contactos')
            @include('inc.list_view_contactos')
        @elseif (in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','encargos_contacto'], true))
            @include('inc.list_view_encargos')
        @endif
    </section>
@endsection

@section('footer')
<footer class="fixed-bottom p-3 text-center footer-encargapp">
    @if ( in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','encargos_contacto'], true) )
    <div class="input-group input-group-sm col col-sm-9 mx-sm-auto">
        <div class="input-group-addon d-none d-sm-block" aria-hidden='true'>filtrar</div>
        <select class="form-control form-control-sm" id='estados_tareas' aria-label='filtrar los encargos'>
            <option value="0">Todos</option>
            <option value="1">En progreso</option>
            <option value="2">Cerca de vencer</option>
            <option value="3">Vencidos</option>
            <option value="4">Concluidos a tiempo</option>
            <option value="5">Concluidos a destiempo</option>
            <option value="6">Rechazados</option>
        </select>            
        <span class="input-group-btn">
            <button class="btn btn-sm btn-info" type="button" data-url="{{Request::url()}}" id='filtrar'>filtrar</button>
            <a href="{{route('nuevo_encargo')}}" class="btn btn-sm btn-success">
                <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
            </a>
        </span>
    </div>          
    @else
    <a href="{{route('agregar_contacto')}}" class="btn btn-info btn-sm mx-auto">
        <i class="fa fa-user-plus" aria-hidden="true"></i> agregar nuevo contacto
    </a>
    @endif
</footer>
@endsection
