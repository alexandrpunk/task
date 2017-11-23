@if (count($encargos) == 0)
    @if (Route::currentRouteName() == 'mis_encargos')
        <h1 class="text-muted text-center font-weight-light ">No has hecho ningun encargo aun.</h1>
        <p class="lead text-muted text-center">Puedes hacer uno haciendo click <a href="{{route('nuevo_encargo')}}">aqui</a></p>
    @elseif (Route::currentRouteName() == 'mis_pendientes')
        <h1 class="text-muted text-center font-weight-light ">No tienes ningun pendiente.</h1>
        <p class="lead text-muted text-center">Puedes asignarte uno haciendo click <a href="{{route('nuevo_encargo')}}">aqui</a></p>
    @elseif (Route::currentRouteName() == 'encargos_contacto')
        <h1 class="text-muted text-center font-weight-light ">No le has encargado nada a {{$contacto}}.</h1>
        <p class="lead text-muted text-center">Puedes hacerle uno haciendo click <a href="{{route('nuevo_encargo')}}">aqui</a></p>
    @endif
    
@else
<div class="list-group" role='list' id='encargos' aria-label='lista de encargos'>
    @foreach ($encargos as $encargo)
    <div class='list-group-item task' style='border-left-color:{{$encargo->estado->color}};' role='listitem'>
    <div role='option'>
    <div class='encargo-header'>
        <span class='user'>
            @if ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                Te encargaste:
            @elseif ($encargo->id_asignador != Auth::user()->id && $encargo->id_responsable == Auth::user()->id)
                {{$encargo->asignador->nombre}} {{$encargo->asignador->apellido}} te encargo:
            @elseif ($encargo->id_asignador == Auth::user()->id && $encargo->id_responsable != Auth::user()->id)
               Le encargaste a: {{$encargo->responsable->nombre}} {{$encargo->responsable->apellido}}
            @endif
        </span>
    </div>
    <div class='encargo-body'>
        <h4 class='truncado'>{{$encargo->encargo}}</h4>
        <span class="sr-only">encargado el:{{$encargo->created_at->formatLocalized('%A %d de %B %Y')}}</span>
        <span class="sr-only">con plazo para el: {{strftime('%A %d de %B %Y',strtotime($encargo->fecha_plazo))}}</span>
        <span class="sr-only">@if ($encargo->visto) visto @else sin ver @endif</span>
        <span class="sr-only">@if ($encargo->mute) silenciado @endif</span>
        <span class='time' aria-hidden='true'>
            <i class="fa fa-clock-o text-primary" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{$encargo->estado->nombre}}"></i>
            {{strftime('%d/%m/%y',strtotime($encargo->created_at))}} - {{strftime('%d/%m/%y',strtotime($encargo->fecha_plazo))}}
            @if ($encargo->visto)
                <i class="fa fa-envelope-open fa-fw text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="visto"></i>
            @else
                <i class="fa fa-envelope fa-fw text-mutted" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="sin ver"></i>
            @endif
            @if ($encargo->mute)
                <i class="fa fa-bell-slash fa-fw text-muted" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="silenciado"></i>
            @endif
        </span>
        <hr>
    </div>
    </div>
    <div class='encargo-opciones'>
        <ul class="list-inline options">
            <li class="list-inline-item">
                <a onclick="clickAndDisable(this);" href="{{route('ver_encargo', ['id' => $encargo->id])}}" class='btn text-primary text-center' aria-label='ver encargo'>
                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>ver</span>
                </a>
            </li>
            @if($encargo->visto && $encargo->fecha_conclusion == null)
            <li class="list-inline-item">
                <a href="{{route('concluir_encargo', ['id' => $encargo->id])}}" class='btn text-success text-center' aria-label='concluir encargo'>
                    <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                    <span class='d-block d-sm-inline'>concluir</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    </div>
    @endforeach
</div>
@endif
