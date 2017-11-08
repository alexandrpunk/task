<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
<div class="list-group" role='list'>
    @foreach ($encargos as $encargo)
    <div class='list-group-item task' style='border-left-color:{{$encargo->estado()->color}};' role='listitem'>
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
        <h4 class='truncado'>{{$encargo->encargo}}</h4>
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
            <li class="list-inline-item">
                <a onclick="clickAndDisable(this);" href="{{route('ver_encargo', ['id' => $encargo->id])}}" class='btn text-primary text-center'>
                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>ver</span>
                </a>
            </li>
            @if($encargo->visto)
            <li class="list-inline-item">
                <a href="{{route('concluir_encargo', ['id' => $encargo->id])}}" class='btn text-success text-center'><i class="fa fa-check fa-fw" aria-hidden="true">
                    </i> <span class='d-block d-sm-inline'>concluir</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href='#' onclick="clickAndDisable(this);"  class='btn text-danger text-center'><i class="fa fa-minus-circle fa-fw" aria-hidden="true">
                    </i> <span class='d-block d-sm-inline '>rechazar</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    </div>
    @endforeach
</div>