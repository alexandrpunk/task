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
        {{--dd($encargo->comentarios)--}}
        <div class="panel panel-info">
            <div class="panel-heading">Comentarios</div>
            <div class="panel-body">
            @if (count($encargo->comentarios) > 0)
               @foreach ($encargo->comentarios as $comentario)
                <div class="comentario">
                    <label>{{$comentario->usuario->nombre}} {{$comentario->usuario->apellido}} comento:</label>
                    <small class="pull-right">{{$comentario->created_at->formatLocalized('%d de %B %Y')}}</small>
                    <p>{{$comentario->comentario}}</p>
                </div>
               @endforeach
            @endif
            </div>
            <div class="panel-footer">
                <form method="POST" action="{{url('/encargos/comentar')}}/{{$encargo->id}}" data-toggle="validator">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for='comentario'>Comentario</label>
                        <textarea name='comentario' placeholder="escribe un comentario sobre el encargo" class="form-control" rows="4" required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <button class="btn btn-info" type="submit">Comentar</button>
                </form>
            </div>
        </div>
    </div><!-- /.container -->
@endsection
