@extends('layouts.base')
@section('title', $titulo)
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">
@endsection

@section('js')
<script src="/js/listar_encargos.js"></script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
@endsection

<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('content')
    <div class="panel with-nav-tabs panel-default" role>
        <div class="panel-heading">
            @if (Route::currentRouteName() == 'encargos_contacto')
            <ul class="nav nav-tabs" role="tablist" aria-label="Opciones de vista">
                <li role="tab" aria-label="Volver a la lista de contactos">
                    <a href="{{route('listar_contactos')}}"><i class="fa fa-fw fa-step-backward" aria-hidden="true"></i></a>
                </li>
                <li class='active' role="tab" aria-label="Encargos del contacto:">
                    <a href="{{route('listar_contactos')}}">{{$contacto}}</a>
                </li>
            </ul>
            @else
            <ul class="nav nav-tabs" role="tablist" aria-label="Opciones de vista">
                <li class="<?php if ( in_array(Route::currentRouteName(), ['inicio','mis_encargos'], true) ) {echo 'active';} ?>"  role="tab" aria-label="Ver Encargos">
                    <a href="{{route('mis_encargos')}}">Encargos</a>
                </li>
                <li class="<?php if (Route::currentRouteName() == 'mis_pendientes') {echo 'active';} ?>"  role="tab"  aria-label="Ver Pendientes">
                    <a href="{{route('mis_pendientes')}}">Pendientes</a>
                </li>
                <li class="<?php if (Route::currentRouteName() == 'listar_contactos') {echo 'active';} ?>"  role="tab" aria-label="Ver contactos">
                    <a href="{{route('listar_contactos')}}">Contactos</a>
                </li>
            </ul>
            @endif
        </div>
        <div class="panel-body full-height">
            <div class="tab-content">
                <div class="input-group" style='margin-bottom:15px;'>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></span>
                    <input type="search" class="form-control" oninput="w3.filterHTML('.list-group', '.list-group-item', this.value)" placeholder='buscar...'>
                </div>
                <div class="tab-panel" id="tareas" role="tabpanel" aria-label="Listado">
                    @if (Route::currentRouteName() == 'listar_contactos')
                        @include('inc.list_view_contactos')
                    @elseif (Route::currentRouteName() == 'mis_pendientes' || Route::currentRouteName() == 'mis_encargos' || Route::currentRouteName() == 'encargos_contacto')
                        @include('inc.list_view_encargos')
                    @endif
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
        @if ( in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','encargos_contacto'], true) )
        <div class="input-group col-md-6  col-md-offset-3">
            <div class="input-group-addon hidden-xs" aria-hidden='true'>filtrar</div>
            <select class="form-control" id='estados_tareas' aria-label='filtrar los encargos'>
                <option value="0">Todos</option>
                <option value="1">En progreso</option>
                <option value="2">Cerca de vencer</option>
                <option value="3">Vencidos</option>
                <option value="4">Concluidos a tiempo</option>
                <option value="5">Concluidos a destiempo</option>
            </select>            
            <span class="input-group-btn">
                <button class="btn btn-info" type="button" data-url="{{Request::url()}}" id='filtrar'>filtrar</button>
                <a href="{{route('nuevo_encargo')}}" class="btn btn-success">
                    <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
                </a>
            </span>
        </div>          
        @else
        <a href="{{url('/contactos/agregar')}}" class="btn btn-info">
            <i class="fa fa-user-plus" aria-hidden="true"></i> agregar nuevo contacto
        </a>
        @endif
        </div>
    </div>
@endsection

