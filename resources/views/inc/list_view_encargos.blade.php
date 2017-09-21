<div class="list-group" role="grid">
    @foreach ($encargos as $encargo)
    <div class="list-group-item task-list" role="row">
       <div class="row">
            <div class="col-xs-7 col-sm-10">
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
                    @include('inc.estado_label')                    
                    </dd>
                </dl>
            </div>
            <div class="col-xs-5 col-sm-2 text-center">
               <div class="btn-group-vertical" role="group">
                   <a href="{{url('/encargos/ver')}}/{{$encargo->id}}" class="btn btn-primary">
                       <i class="fa fa-eye" aria-hidden="true"></i> ver
                    </a>
                    @if ($encargo->visto)
                    <a href="{{url('/encargos/concluir')}}/{{$encargo->id}}" class="btn btn-success">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> concluir
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>