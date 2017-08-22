@extends('layouts.base')
@section('title', 'Lista de Contactos')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
@endsection

<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('content')
    <div class="container">
        <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="<?php if (Route::currentRouteName() == 'mis_encargos') {echo 'active';} ?>">
                            <a href="{{route('mis_encargos')}}">Mis Encargos</a>
                        </li>
                        <li class="<?php if (Route::currentRouteName() == 'mis_tareas') {echo 'active';} ?>">
                            <a href="{{route('mis_tareas')}}">Mis tareas</a>
                        </li>
                        <li class="<?php if (Route::currentRouteName() == 'listar_contactos') {echo 'active';} ?>">
                            <a href="{{route('listar_contactos')}}">Contactos</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-panel" id="tareas">
                            @if (Route::currentRouteName() == 'listar_contactos')
                                @include('inc.list_view_contactos')
                            @elseif (Route::currentRouteName() == 'mis_tareas' || Route::currentRouteName() == 'mis_encargos')
                                @include('inc.list_view_tareas')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
@endsection