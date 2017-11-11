@extends('layouts.base')
@section('title', 'Crear Encargo')
@section('back', route('mis_encargos'))
@section('css')
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.common.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.default.mobile.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.bootstrap.min.css" />
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous">-->
<style>

    span.k-widget.k-tooltip-validation {
        display; inline-block;
        text-align: left;
        border: 0;
        padding: 0;
        margin: 0;
        background: none;
        box-shadow: none;
        color: red;
    }

    .k-tooltip-validation .k-warning {
        display: none;
    }
</style>
@endsection

@section('js')
<script src="http://kendo.cdn.telerik.com/2017.3.1026/js/kendo.all.min.js"></script>
<script>
$( document ).ready(function() {
    // create ComboBox from select HTML element
    $("#responsable").kendoComboBox({
        suggest: true,
        clearButton: false,
        filter: "contains",
        required: true,
    }); 
    
    $("#responsable").data("kendoComboBox").text('');
    $("#responsable").data("kendoComboBox").input.attr("placeholder", "Selecciona un responsable");
    var widget = $("#responsable").getKendoComboBox();
    widget.input.on("focus", function() {
        widget.open();
        $("#responsable").data("kendoComboBox").text('');
    });

    var validator = $("form").kendoValidator().data("kendoValidator");
});
</script>
<!--<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>-->
@endsection

@section('content')
    <div class="card p-3 my-3">
        <label class="sr-only">'formulario para la creacion de encargos'</label>   
        <form method="POST" action="{{ route('nuevo_encargo') }}" id='encargoForm'>
            {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-12 col-sm-6 mb-sm-0">
                    <label for="responsable" aria-hidden='true'>Responsable</label>
                    <select class="form-control" id='responsable' validationMessage="Selecciona un responsable" name="responsable" role='combobox' style="width: 100%" required>
                        @foreach ($contactos as $contacto)
                            <option value="{{$contacto->id}}" @php if($contacto->id == old('responsable')){echo 'selected';} @endphp role='option'>
                                {{ $contacto->nombre }} {{ $contacto->apellido }}
                            </option>
                        @endforeach                        
                    </select>
                </div>

                <div class="form-group col-12 col-sm-6 mb-sm-0">
                    <label for="fecha_limite">Fecha limite</label>
                    <input type="date" class="form-control" id='fecha_limite' name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Selecciona la fecha para el encargo" required validationMessage="Selecciona un fecha" >
                </div>
            </div>
            <div class="form-group">
                <label for="encargo">Encargo</label>
                <textarea class="form-control" id='encargo' name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required validationMessage="Describa su encargo" >{{old('encargo')}}</textarea>
            </div>           
            
            <button type="reset" class="btn btn-danger">Limpiar</button>
            <button type="submit" class="btn btn-primary">Crear encargo</button>
        </form>
    </div>
@endsection