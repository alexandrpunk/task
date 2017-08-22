<div class="list-group">
    @foreach ($encargos as $encargo)
    <div class="list-group-item task-list">
       <div class="row">
        <div class="col-xs-12 col-sm-10">
            <div class="list-group-item-heading">
                <h4>{{$encargo->encargo}}</h4>
            </div>
            <dl class="dl-horizontal">
                @if(Route::currentRouteName() == 'mis_tareas')
                <dt>Encargado por:</dt>
                <dd>{{$encargo->asignador->nombre}}</dd>
                @else
                <dt>Encargado a:</dt>
                <dd>{{$encargo->responsable->nombre}}</dd>
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
        <div class="col-xs-12 col-sm-2 text-center">
            @if (!$encargo->visto)
            <a href="{{url('/encargos/ver')}}/{{$encargo->id}}" class="btn btn-sm btn-primary">ver encargo</a>
            @else
            <a href="{{url('/encargos/ver')}}/{{$encargo->id}}" class="btn btn-sm btn-primary">ver encargo</a>
            <a href="{{url('/encargos/concluir')}}/{{$encargo->id}}" class="btn btn-sm btn-success">concluir encargo</a>
            @endif
        </div>
        </div>
    </div>
    @endforeach
</div>