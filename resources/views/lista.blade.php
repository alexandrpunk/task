@extends('layouts.base')
@section('title', 'Lista de Contactos')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">
@endsection

@section('js')
<script src="/js/listar_encargos.js"></script>
@endsection

<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('content')
    <div class="container">
       {{Route::currentRouteName()}}
        <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="<?php if (Route::currentRouteName() == 'mis_encargos') {echo 'active';} ?>">
                            <a href="{{route('mis_encargos')}}">Mis Encargos</a>
                        </li>
                        <li class="<?php if (Route::currentRouteName() == 'mis_pendientes') {echo 'active';} ?>">
                            <a href="{{route('mis_pendientes')}}">Mis pendientes</a>
                        </li>
                        <li class="<?php if (Route::currentRouteName() == 'listar_contactos') {echo 'active';} ?>">
                            <a href="{{route('listar_contactos')}}">Contactos</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body full-height">
                    <div class="tab-content">
                        <div class="tab-panel" id="tareas">
                            @if (Route::currentRouteName() == 'listar_contactos')
                                @include('inc.list_view_contactos')
                            @elseif (Route::currentRouteName() == 'mis_pendientes' || Route::currentRouteName() == 'mis_encargos')
                                @include('inc.list_view_encargos')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                @if (Route::currentRouteName() == 'mis_encargos' || Route::currentRouteName() == 'mis_pendientes')
                <div class="input-group col-md-6  col-md-offset-3">
                    <span class="input-group-addon" title="seleccione la forma de filtrar los encargos">Ver por:</span>
                    <select class="form-control" id='estados_tareas'>
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
                            <i class="fa  fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
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
        </div>
    </div><!-- /.container -->
@endsection