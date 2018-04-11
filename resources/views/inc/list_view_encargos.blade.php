@php \Carbon\Carbon::setLocale('es_MX.utf8');
setlocale(LC_TIME, 'es_MX.utf8');
@endphp
<div class="list-group" role='list' id='lista' aria-label='lista de encargos'>
 @if (count($encargos) == 0)
    @if (Route::currentRouteName() == 'mis_encargos')
        <h1 class="text-muted text-center font-weight-light ">No hay ningun encargo.</h1>
    @elseif (Route::currentRouteName() == 'mis_pendientes')
        <h1 class="text-muted text-center font-weight-light ">No tienes ningun pendiente.</h1>
    @elseif (Route::currentRouteName() == 'encargos_contacto')
        <h1 class="text-muted text-center font-weight-light ">No le has encargado nada a {{$contacto}}.</h1>
    @endif
@else 
    @foreach ($encargos as $encargo)
    <div class='list-group-item task' style='border-left-color:{{$encargo->estado->color}};' role='listitem' data-search='{{$encargo->asignador->nombre}} {{$encargo->asignador->apellido}} {{$encargo->responsable->nombre}} {{$encargo->responsable->apellido}} {{$encargo->created_at->formatLocalized('%A %d de %B %Y')}} {{strftime('%A %d de %B %Y',strtotime($encargo->fecha_plazo))}} {{$encargo->encargo}}'>
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
            <i class="fas fa-clock text-primary" aria-hidden="true" id='estado-encargo' title='{{$encargo->estado->nombre}}'></i>
            {{strftime('%d/%m/%y',strtotime($encargo->created_at))}} - {{strftime('%d/%m/%y',strtotime($encargo->fecha_plazo))}}
            <i class="fas {{ $encargo->visto ? 'fa-envelope-open text-info' : 'fa-envelope text-mutted' }} fa-fw " aria-hidden="true" title="{{ $encargo->visto ? 'encargo visto' : 'encargo sin ver' }}"></i>
        </span>
        <hr>
    </div>
    </div>
    <div class='encargo-opciones'>
        <a href="{{route('ver_encargo', ['id' => $encargo->id])}}" class='btn btn-sm text-primary' aria-label='ver encargo'>
            <i class="fas fa-eye fa-fw" aria-hidden="true"></i> ver
        </a>
        @if( ( $encargo->visto && $encargo->fecha_conclusion == null ) || ( $encargo->id_asignador == Auth::user()->id && $encargo->fecha_conclusion == null ) )
        <button data-url='{{route('concluir_encargo', ['id' => $encargo->id])}}' class='btn btn-link text-success btn-sm finalizar-encargo concluir' aria-label='concluir encargo'>
            <i class="fa fa-check fa-fw" aria-hidden="true"></i> concluir
        </button>
        <button data-url="{{route('rechazar_encargo', ['id' => $encargo->id])}}" class='btn btn-link btn-sm text-danger finalizar-encargo rechazar' aria-label='{{ $encargo->id_asignador == Auth::user()->id  ? "cancelar" : "rechazar" }} encargo'>
            <i class="fa fa-minus-circle fa-fw" aria-hidden="true"></i> {{ $encargo->id_asignador == Auth::user()->id  ? 'cancelar' : 'rechazar' }}
        </button>
        @endif
    </div>
    </div>
    @endforeach
@endif
</div>
