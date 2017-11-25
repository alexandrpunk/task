@section('title', 'Registrar nueva cuenta')
@section('back', route('login'))
@extends('layouts.base')
@section('css')
<style>
.custom-file-control:lang(es)::after {
  content: "Seleccionar imagen...";
}

.custom-file-control:lang(es)::before {
  content: "Subir";
}
.custom-file-control:lang(en)::after {
  content: "Select image...";
}

.custom-file-control:lang(en)::before {
  content: "Upload";
}
</style>
@endsection

@section('js')
@endsection

@section('content')
<div class="card p-3 my-3">
    <form method="POST" action="{{ route('editar_usuario') }}">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="form-group text-center">
                    <img src="http://via.placeholder.com/150x150" alt="" class="rounded">
                    <br>
                    <label for="avatar">Subir imagen</label>
                    <input type="file" id="avatar" name='avatar' class="form-control-file form-control-sm text-truncate w-100" disabled>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nombre" value="{{Auth::user()->nombre}}" placeholder="Nombre" maxlength="100" required readonly>
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="apellido" value="{{Auth::user()->apellido}}"placeholder="Apellido" maxlength="100" required readonly>
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono">Celular</label> <small class='text-muted'>(No es obligatorio)</small>
                    <div class="input-group">
                        <input type="tel" pattern="\d{10}" class="form-control" name="telefono" value="{{Auth::user()->telefono}}" placeholder="Numero Celular" maxlength="10" validationMessage="Debe ser un numero telefonico de 10 digitos" readonly>
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>              
                <hr>
                <button type="reset" class="btn btn-primary" disabled>Reiniciar</button>
                <button type="submit" class="btn btn-success" disabled>Guardar</button>
            </div>
        </div>
    </form>
</div>
@endsection