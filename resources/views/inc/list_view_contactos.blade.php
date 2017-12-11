<div class="list-group" role='list' aria-label='lista de contactos'>
    @foreach ($contactos as $contacto)
        @if ( is_null($contacto->contacto->display) )
            @php
            $contacto->contacto->display = 'avatar.jpg';
            @endphp

        @endif
    <div class="list-group-item contacto row mx-0">
        <div class="col-12 col-sm-auto px-0 align-self-center text-center" aria-hidden='true'>
            <img class='display mb-2 mb-sm-0' src="{{ url('storage/profile') }}/{{ $contacto->contacto->display }}">
        </div>
        <div class="col-12 col-sm align-self-center" role='option'>
            <h4 class='nombre'>{{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}}</h4>
            <span class='email'>
                <span class="sr-only">email:</span>
                <i class="fa fa-envelope fa-fw" aria-hidden="true"></i> {{$contacto->contacto->email}}
                </span>
            <span class='telefono'>
                <span class="sr-only">telefono:</span>
                <i class="fa fa-phone fa-fw" aria-hidden="true"></i> {{$contacto->contacto->telefono}}
            </span>
        </div>
        <div class="col-12 col-sm-auto align-self-center px-0 text-center">
            <div class="align-self-baseline">
                <a href="{{route('encargos_contacto', ['id' => $contacto->contacto->id])}}" class="btn btn-sm btn-default text-info d-inline-block d-sm-block" aria-label='ver encargos de {{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}}'>
                </a>
                {{--  <a href="" class="btn btn-sm btn-default text-success d-inline-block  d-sm-block">
                    <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>encargar</span>
                </a>  --}}
                {{--  <a href="" class="btn btn-sm btn-default text-danger d-inline-block  d-sm-block">
                    <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>bloquear</span>
                </a>  --}}
            </div>
        </div>
    </div>
    @endforeach
</div>