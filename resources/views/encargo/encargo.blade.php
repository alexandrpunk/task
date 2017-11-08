@extends('layouts.base')
@section('title', 'Detalles del encargo')

@if($encargo->id_responsable == Auth::user()->id)
    @section('back', route('mis_pendientes'))
@else
    @section('back', route('mis_encargos'))
@endif

@section('css')
@endsection

@section('js')
@endsection
<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
@section('content')
<div class='list-group-item rounded task' style='border-left-color:{{$encargo->estado()->color}};' role='listitem'>
    <div class='encargo-header'>
        <span class='user'>
            @if ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                Te encargaste:
            @elseif ($encargo->id_asignador != Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                Encargado por: {{$encargo->asignador->nombre}} {{$encargo->responsable->apellido}}
            @elseif ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable != Auth::user()->id)
               Encargado a: {{$encargo->responsable->nombre}} {{$encargo->responsable->apellido}}
            @endif
            
        </span>
    </div>
    <div class='encargo-body'>
        <h4>
            {{$encargo->encargo}}
        </h4>
        <span class='time'>
            <i class="fa fa-clock-o text-primary" aria-hidden="true"></i>
            {{strftime('%d/%m/%y',strtotime($encargo->created_at))}} - {{strftime('%d/%m/%y',strtotime($encargo->fecha_plazo))}}
            @if ($encargo->visto)
                <i class="fa fa-envelope-open fa-fw text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="encargo visto"></i>
            @else
                <i class="fa fa-envelope fa-fw text-mutted" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="encargo sin ver"></i>
            @endif
        </span>
        <hr>
    </div>
    <div class='encargo-opciones'>
        <ul class="list-inline options">
            @if($encargo->visto)
            <li class="list-inline-item">
                <a href="{{route('concluir_encargo', ['id' => $encargo->id])}}" class='btn text-success text-center'><i class="fa fa-check fa-fw" aria-hidden="true">
                    </i> concluir
                </a>
            </li>
            <li class="list-inline-item">
                <a href='#' onclick="clickAndDisable(this);"  class='btn text-danger text-center'><i class="fa fa-minus-circle fa-fw" aria-hidden="true">
                    </i> rechazar
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>

<div class="card mt-3">
    <h5 class="card-header">Comentarios</h5>
    <div class="card-body">
        @if (count($encargo->comentarios) > 0)
            @foreach ($encargo->comentarios as $comentario)
            <div class="comentario">
                <label class='text-info'>{{$comentario->usuario->nombre}} {{$comentario->usuario->apellido}} comento:</label>
                <small class="pull-right text-muted">{{$comentario->created_at->formatLocalized('%d de %B %Y')}}</small>
                <p>{{$comentario->comentario}}</p>
            </div>
            @endforeach
        @else
            <p class='lead text-muted text-center'>¡¡¡Ooooohhh!!!, parece que no hay comentarios.</p>
        @endif
    </div>
    <div class="card-footer">
        <form method="POST" action="{{url('/encargos/comentar')}}/{{$encargo->id}}" data-toggle="validator">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for='comentario'>Comentario</label>
                <textarea name='comentario' placeholder="escribe un comentario o duda..." class="form-control" rows="4" required></textarea>
                <div class="help-block with-errors"></div>
            </div>
            <button class="btn btn-sm btn-info" type="submit">Comentar</button>
        </form>
    </div>
</div>
@endsection
