@section('title', 'Registrar nueva cuenta')
@section('back', route('login'))
@extends('layouts.base')
@section('css')
@endsection

@section('js')
@endsection

@section('content')
<div class="card p-3 my-3">
    <form method="POST" action="{{ route('editar_usuario') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="form-group text-center">
                    <img src="{{ url('storage/profile') }}/{{ Auth::user()->display }}" alt="" class="rounded display">
                    <br>
                    <label for='display'>Subir imagen</label>
                    <input type="file" id='display' name='display' class="form-control-file form-control-sm text-truncate w-100" >
                    <small class="text-muted">La imagen no debe ser mayor a 2mb</small>
                </div>
            </div>
            <div class="col-12 col-sm-9">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <input type="text" id='nombre' class="form-control form-control-sm" name="nombre" value="{{Auth::user()->nombre}}" placeholder="Nombre" maxlength="100" required >
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-sm" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <div class="input-group">
                        <input type="text" id='apellido' class="form-control form-control-sm" name="apellido" value="{{Auth::user()->apellido}}" placeholder="Apellido" maxlength="100" required >
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-sm" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono">Celular</label> <small class='text-muted'>(No es obligatorio)</small>
                    <div class="input-group">
                        <input type="tel" id='telefono' pattern="\d{10}" class="form-control form-control-sm" name="telefono" value="{{Auth::user()->telefono}}" placeholder="Numero Celular" maxlength="10" >
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-sm" type="button"><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>              
                <hr>
                <button type="reset" class="btn btn-primary" >Reiniciar</button>
                <button type="submit" class="btn btn-success" >Guardar</button>
            </div>
        </div>
    </form>
</div>
@endsection