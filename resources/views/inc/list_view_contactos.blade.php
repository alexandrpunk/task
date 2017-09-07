<div class="list-group">
    @foreach ($contactos as $contacto)
    <div class="list-group-item">
       <div class="row">
        <div class="col-sm-10 col-xs-7">
            <h4 class="list-group-item-heading">{{$contacto->nombre}} {{$contacto->apellido}}</h4>
            <p class="list-group-item-text">{{$contacto->email}}</p>
            <p class="list-group-item-text small">Telefono: {{$contacto->telefono}}</p>
        </div>
        <div class="col-sm-2 col-xs-5  text-center">
            <div class="btn-group-vertical" role="group" aria-label="...">
                <a href="{{url('/encargos')}}/{{$contacto->id}}" class="btn btn-primary btn-block">
                    <i class="fa fa-address-card-o fa-fw" aria-hidden="true"></i> Encargos
                </a>
                <a href="" class="btn btn-danger btn-block">
                    <i class="fa fa-ban fa-fw" aria-hidden="true"></i> Borrar
                </a>
            </div>
        </div>
        </div>
    </div>
    @endforeach
</div>