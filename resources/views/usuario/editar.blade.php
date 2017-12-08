@php ($menu = 2)
@section('title', 'Registrar nueva cuenta')
@section('back', route('login'))
@extends('layouts.base')
@section('css')
@endsection

@section('js')
<script>
function habilitarEdicion(){
    $( "#editar, #guardar, #cancelar" ).toggleClass( "d-none");
    $("#display, #nombre, #apellido, #telefono").attr("disabled", false);
}

$( "#cancelar" ).click(function( event ) {
    event.preventDefault();
    $('#perfil')[0].reset();
    $( "#editar, #guardar, #cancelar" ).toggleClass( "d-none");
    $("#display, #nombre, #apellido, #telefono").attr("disabled", true);
});

</script>
@endsection

@section('content')
<div class="card p-3 my-3">
    <form method="POST" action="{{ route('editar_usuario') }}" enctype="multipart/form-data" id='perfil'>
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="form-group text-center">
                    <img src="{{ url('storage/profile') }}/{{ Auth::user()->display }}" alt="" class="rounded display">
                    <br>
                    <label for='display'>Subir imagen</label>
                    <input type="file" id='display' name='display' class="form-control-file form-control-sm text-truncate w-100" disabled>
                    <small class="text-muted">La imagen no debe ser mayor a 2mb</small>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id='nombre' class="form-control form-control-sm" name="nombre" value="{{Auth::user()->nombre}}" placeholder="Nombre" maxlength="100" required disabled>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id='apellido' class="form-control form-control-sm" name="apellido" value="{{Auth::user()->apellido}}" placeholder="Apellido" maxlength="100" required  disabled>
                </div>
                <div class="form-group">
                    <label for="telefono">Celular</label> <small class='text-muted'>(No es obligatorio)</small>
                    <input type="tel" id='telefono' pattern="\d{10}" class="form-control form-control-sm" name="telefono" value="{{Auth::user()->telefono}}" placeholder="Numero Celular" maxlength="10" disabled>
                </div>              
                <hr>
                <button type="reset" class="btn btn-primary d-none" id='cancelar'>Cancelar</button>
                <button type="submit" class="btn btn-success d-none"  id='guardar'>Guardar</button>
                <button type='button' class="btn btn-info"  onClick='habilitarEdicion()'  id='editar'>Editar</button>
            </div>
        </div>
    </form>
</div>
@endsection