@extends('layouts.base')
@section('title', 'Crear Encargo')
@section('css')
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">-->
@endsection

@section('js')
<!--<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>-->
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Crear un nuevo encargo</div>
        <div class="panel-body">
            <form method="POST" action="{{ route('crear_encargo') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="encargo">Responsable</label>
                    <select class="form-control" name="responsable" placeholder="Selecciona al responsable del encargo" required>
                        @foreach ($contactos as $contacto)
                            <option value="{{$contacto->id}}" <?php if($contacto->id == old('responsable') || $contacto->id == Auth::user()->id ){echo 'selected';} ?> >
                                {{ $contacto->nombre }} {{ $contacto->apellido }}
                            </option>
                        @endforeach                        
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <label for="encargo">Encargo</label>
                    <textarea class="form-control" name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required>{{old('encargo')}}</textarea>
                    <div class="help-block with-errors"></div>
                </div>
                    
                <div class="form-group">
                    <label for="fecha_limite">Fecha limite</label>
                    <input type="date" class="form-control" name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Describe tu encargo aqui" required>
                    <div class="help-block with-errors"></div>
                </div>
                
                
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-primary">Crear encargo</button>
            </form>
        </div>
    </div>
@endsection