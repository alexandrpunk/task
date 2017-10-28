@extends('layouts.base')
@section('title', 'Crear Encargo')
@section('css')
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.913/styles/kendo.common.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.913/styles/kendo.default.mobile.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.913/styles/kendo.bootstrap.min.css" />
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">-->
@endsection

@section('js')
<script src="http://kendo.cdn.telerik.com/2017.3.913/js/kendo.all.min.js"></script>
<script>
    // create ComboBox from select HTML element
    $("#responsable").kendoComboBox({
        suggest: true,
        clearButton: false,
        filter: "contains",
    }); 
    
    $("#responsable").data("kendoComboBox").input.attr("placeholder", "Selecciona un responsable");
    $("#responsable").data("kendoComboBox").text('');
    var widget = $("#responsable").getKendoComboBox();
    widget.input.on("focus", function() {
        widget.open();
    });
     
</script>
<!--<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>-->
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" aria-label="formulario para asignar encargo">
            <label class="sr-only">'formulario para la creacion de encargos'</label>
            <span aria-hidden='true'>
                Crear un nuevo encargo
            </span>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('crear_encargo') }}" data-toggle="validator">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="responsable" aria-hidden='true'>Responsable</label>
                    <select class="form-control" id='responsable' name="responsable" role='combobox' style="width: 100%" required>
                        @foreach ($contactos as $contacto)
                            <option value="{{$contacto->id}}" @php if($contacto->id == old('responsable')){echo 'selected';} @endphp role='option'>
                                {{ $contacto->nombre }} {{ $contacto->apellido }}
                            </option>
                        @endforeach                        
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                
                <div class="form-group">
                    <label for="encargo">Encargo</label>
                    <textarea class="form-control" id='encargo' name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required>{{old('encargo')}}</textarea>
                    <div class="help-block with-errors"></div>
                </div>
                    
                <div class="form-group">
                    <label for="fecha_limite">Fecha limite</label>
                    <input type="date" class="form-control" id='fecha_limite' name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Selecciona la fecha para el encargo" required>
                    <div class="help-block with-errors"></div>
                </div>
                
                
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-primary">Crear encargo</button>
            </form>
        </div>
    </div>
@endsection