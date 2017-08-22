@extends('layouts.base')
@section('title', 'Detalles del encargo')
@section('css')
@endsection

@section('js')
@endsection
<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('content')
    <div class="container">
       
        <div class="panel panel-default">
            <div class="panel-body task">
                <dl class="dl-horizontal">
                    <dt>Detalles del encargo:</dt>
                    <dd>{{$encargo->encargo}}</dd>
                    <dt>Encargado por:</dt>
                    <dd>{{$encargo->responsable->nombre}}</dd>
                    <dt>Asignada el:</dt>
                    <dd>{{$encargo->created_at->formatLocalized('%A %d de %B %Y')}}</dd>
                    <dt>Debe cumplirse para:</dt>
                    <dd>{{strftime('%A %d de %B %Y',strtotime($encargo->fecha_plazo))}}</dd>
                    <dt>Estado:</dt>
                    <dd>
                    @include('inc.estado_label') 
                    </dd>
                </dl>
                <hr>
                @if (!$encargo->fecha_conclusion)
                <a href="{{url('/encargos/concluir')}}/{{$encargo->id}}" class="btn btn-sm btn-success">concluir encargo</a>
                @endif
            </div>
        </div>
    </div><!-- /.container -->
@endsection
