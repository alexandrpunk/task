<div class="list-group" id='lista' role='listbox' aria-label='lista de contactos'>
    @foreach ($contactos as $contacto)
        @if ( is_null($contacto->contacto->display) )
        @php($contacto->contacto->display = 'avatar.jpg')
        @endif
    <div class="list-group-item contacto row mx-0" role='listitem' data-search='{{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}} {{$contacto->contacto->email}} {{$contacto->contacto->telefono}}'>
        <div class="col-12 col-sm-auto px-0 align-self-center text-center" aria-hidden='true'>
            <img class='display' src="{{ url('storage/profile') }}/{{ $contacto->contacto->display }}">
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
            {{--<a href="{{route('encargos_contacto', ['id' => $contacto->contacto->id])}}" class="text-info" aria-label='ver encargos de {{$contacto->contacto->nombre}} {{$contacto->contacto->apellido}}'>ver encargos</a>
            <br>
            <a href="{{route('nuevo_encargo', ['id' => $contacto->contacto->id])}}" class="text-success">hacer encargo</a>--}}
        </div>
    </div>
    @endforeach
</div>