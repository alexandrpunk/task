<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
<div class="list-group" role='list'>
    @foreach ($encargos as $encargo)
    <div class="list-group-item task-list" role="listitem">
       <div class="row">
            <div class="col-xs-7 col-sm-10" role="option">
                <label class='sr-only'>Encargo</label>
                <div class="list-group-item-heading">
                    <h4>{{$encargo->encargo}}</h4>
                </div>
                <dl class="dl-horizontal">
                    @if(Route::currentRouteName() == 'mis_pendientes')
                    <dt>Encargado por:</dt>
                    <dd>{{$encargo->asignador->nombre}} {{$encargo->asignador->apellido}}</dd>
                    @else
                    <dt>Encargado a:</dt>
                    <dd>{{$encargo->responsable->nombre}} {{$encargo->responsable->apellido}}</dd>
                    @endif
                    <dt>Asignada el:</dt>
                    <dd>{{$encargo->created_at->formatLocalized('%A %d de %B %Y')}}</dd>
                    <dt>Debe cumplirse para:</dt>
                    <dd>{{strftime('%A %d de %B %Y',strtotime($encargo->fecha_plazo))}}</dd>
                    <dt>Estado:</dt>
                    <dd>
                        <span style="background-color:{{$encargo->estado()->color}};" class="label label-primary">
                            {{$encargo->estado()->nombre}}
                        </span>
                        @if (!$encargo->visto)
                        <span class="label label-info">Sin ver</span>
                        @endif                
                    </dd>
                </dl>
            </div>
            <div class="col-xs-5 col-sm-2 text-center">
               <div class="btn-group-vertical" role="group">
                   <a href="{{url('/encargos/ver')}}/{{$encargo->id}}" class="btn btn-primary" role='button' aria-label='Ver encargo: {{$encargo->encargo}}'>
                       <i class="fa fa-eye" aria-hidden="true"></i> ver
                    </a>
                    @if ($encargo->visto)
                    <a href="{{url('/encargos/concluir')}}/{{$encargo->id}}" class="btn btn-success" role='button' aria-label='Concluir encargo: {{$encargo->encargo}}'>
                        <i class="fa fa-check-circle" aria-hidden="true"></i> concluir
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>