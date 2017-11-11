<div class="list-group" role='list'>
    @foreach ($contactos as $contacto)
    <div class="list-group-item contacto row mx-0">
        <div class="col-12 col-sm-auto px-0 align-self-center text-center">
            <img class='rounded mb-2 mb-sm-0' src="http://via.placeholder.com/80x80">
        </div>
        <div class="col-12 col-sm align-self-center">
            <h4 class='nombre'>{{$contacto->nombre}} {{$contacto->apellido}}</h4>
            <span class='email'><i class="fa fa-envelope fa-fw" aria-hidden="true"></i> {{$contacto->email}}</span>
            <span class='telefono'><i class="fa fa-phone fa-fw" aria-hidden="true"></i> {{$contacto->telefono}}</span>
        </div>
        <div class="col-12 col-sm-auto align-self-center px-0 text-center">
            <div class="align-self-baseline">
                <a href="{{route('encargos_contacto', ['id' => $contacto->id])}}" class="btn btn-sm btn-default text-info d-inline-block d-sm-block">
                    <i class="fa fa-address-card fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>encargos</span>
                </a>
                <a href="" class="btn btn-sm btn-default text-success d-inline-block  d-sm-block">
                    <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>encargar</span>
                </a>
                <a href="" class="btn btn-sm btn-default text-danger d-inline-block  d-sm-block">
                    <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class='d-block d-sm-inline'>bloquear</span>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>