<?php
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');
?>
<div class="list-group" role='list'>
    @foreach ($encargos as $encargo)
    <div class='list-group-item task row mx-0 d-flex p-1' role='listitem'>
    <div class="col-auto p-0">
        <span class='estado' style='background-color:{{$encargo->estado()->color}};'>{{$encargo->estado()->nombre}}</span>
        <span class='fecha'><i class="fa fa-clock-o" aria-hidden="true"></i> 12/12/2017</span>
    </div>
    <div class="col">
        <h4 class='descripcion'>{{$encargo->encargo}}</h4>
        <p class='asignador'>Asignado por:{{$encargo->asignador->nombre}} {{$encargo->asignador->apellido}}</p>
    </div>
    <div class="col-1 print">
        <a href="">ver</a>
        <a href="">concluir</a>
    </div>
    </div>
    @endforeach
</div>