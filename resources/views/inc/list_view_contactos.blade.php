<div class="list-group">
    @foreach ($contactos as $contacto)
    <div class="list-group-item">
       <div class="row">
        <div class="col-xs-7 col-sm-10">
            <h4 class="list-group-item-heading">{{$contacto->nombre}} {{$contacto->apellido}}</h4>
            <p class="list-group-item-text">{{$contacto->email}}</p>
            <p class="list-group-item-text small">Telefono: {{$contacto->telefono}}</p>
        </div>
        <div class="col-xs-5 col-sm-2 text-center">
            <a href="" class="btn btn-sm btn-danger btn-block">borrar</a>
        </div>
        </div>
    </div>
    @endforeach
</div>