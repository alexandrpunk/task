@php ($menu = 2)
@section('title', 'Detalles del encargo')
@if($encargo->id_responsable == Auth::user()->id)
    @section('back', route('mis_pendientes'))
@else
    @section('back', route('mis_encargos'))
@endif
@extends('layouts.base')
@section('css')
@endsection

@section('js')
<script src="{{ URL::asset('js/verEncargo.js')}}"></script>
@endsection

@section('content')
<div class='list-group-item rounded task mt-3' id='encargo' style='border-left-color:{{$encargo->estado->color}};'>
    <div class='encargo-header'>
        <span class='user'>
            @if ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                Te encargaste:
            @elseif ($encargo->id_asignador != Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                Encargado por: {{$encargo->asignador->nombre}} {{$encargo->asignador->apellido}}
            @elseif ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable != Auth::user()->id)
               Encargado a: {{$encargo->responsable->nombre}} {{$encargo->responsable->apellido}}
            @endif            
        </span>
        @if ($encargo->id_responsable == Auth::user()->id && !$encargo->fecha_conclusion)
        <button class="btn btn-sm btn-link float-right {{ $encargo->mute ? 'text-muted' : 'text-dark' }}" id='silenciar' data-muted='{{$encargo->mute}}' data-url="{{route('silenciar_encargo', ['id' => $encargo->id])}}">
            <i class="fas {{ $encargo->mute ? 'fa-bell-slash' : 'fa-bell' }} fa-fw" aria-hidden="true" id='mute-icon'></i> <span class=" d-none d-sm-inline">silenciar</span>
        </button>
        @endif
    </div>
    <div class='encargo-body'>
        <h4>
            {{$encargo->encargo}}
        </h4>
        <span class='time'>
            <i class="fas fa-clock text-primary" aria-hidden="true" id='estado-encargo' title='{{$encargo->estado->nombre}}'></i>
            {{strftime('%d/%m/%y',strtotime($encargo->created_at))}} - {{strftime('%d/%m/%y',strtotime($encargo->fecha_plazo))}}
            <i class="fas {{ $encargo->visto ? 'fa-envelope-open text-info' : 'fa-envelope text-mutted' }} fa-fw " aria-hidden="true" title="{{ $encargo->visto ? 'encargo visto' : 'encargo sin ver' }}"></i>
        </span>
        <hr>
    </div>
    <div id='encargo-opciones'>
        @if( $encargo->fecha_conclusion == null )
            <button data-url='{{route('concluir_encargo', ['id' => $encargo->id])}}' class='btn btn-link text-success btn-sm finalizar-encargo concluir'>
                <i class="fa fa-check fa-fw" aria-hidden="true"></i> concluir
            </button>
            <button data-url="{{route('rechazar_encargo', ['id' => $encargo->id])}}" class='btn btn-link btn-sm text-danger finalizar-encargo rechazar'>
                <i class="fa fa-minus-circle fa-fw" aria-hidden="true"></i> rechazar
            </button>
        @endif
    </div>
</div>

<div class="card my-3">
    <h6 class="card-header font-weight-bold">Comentarios</h6>
    <div class="card-body" id='comentarios'>
        @if (count($encargo->comentarios) > 0)
            @foreach ($encargo->comentarios as $comentario)
            <div class="comentario">
                <label class='text-info'>{{$comentario->usuario->nombre}} {{$comentario->usuario->apellido}} comento:</label>
                <small class="pull-right text-muted">{{ strftime( '%m/%d/%y', strtotime( $comentario->created_at ) ) }}</small>
                <p>{{$comentario->comentario}}</p>
            </div>
            @endforeach
        @else
            <p class='lead text-muted text-center' id='no-coment-text'>Aun no hay comentarios.</p>
        @endif
    </div>
    <div class="card-footer">
        <form data-url="{{route('comentar_encargo', ['id' => $encargo->id])}}" id='comentarios-form'>
            {!! csrf_field() !!}
            <div class="form-group">
                <textarea name='comentario' id='comentario' placeholder="Escribe un comentario o duda..." class="form-control form-control-sm" rows="4" required></textarea>
                <div class="help-block with-errors"></div>
            </div>
            <button class="btn btn-sm btn-info" type="submit">Comentar</button>
        </form>
    </div>
</div>
@endsection