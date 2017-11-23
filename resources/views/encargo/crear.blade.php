@extends('layouts.base')
@section('title', 'Crear Encargo')
@section('back', route('mis_encargos'))
@section('css')
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.common.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.default.mobile.min.css" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2017.3.1026/styles/kendo.bootstrap.min.css" />
<style>
.k-combobox .k-select {
    display:none;
}
</style>
@endsection

@section('js')
<script src="http://kendo.cdn.telerik.com/2017.3.1026/js/kendo.all.min.js"></script>
<script>
    $("#responsable").kendoComboBox({
        suggest: true,
        clearButton: false,
        filter: "contains"
    });
    var combobox =  $("#responsable").data("kendoComboBox");+

    combobox.input.on("focus", function() {
        combobox.open();
    });
    
    combobox.input.attr("placeholder", "Selecciona un responsable");
    combobox.input.attr("required", true);
    combobox.text('');
    combobox.input.addClass('form-control');

    $("button[type='reset']").on("click", function(event){
        event.preventDefault();
        combobox.text('');
        $('#encargoForm').find("input, textarea").val("");
    });
</script>
@endsection

@section('content')
    <div class="card p-3 my-3">
        <label class="sr-only">'formulario para la creacion de encargos'</label>   
        <form method="POST" action="{{ route('nuevo_encargo') }}" id='encargoForm'>
            {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-12 col-sm-6 mb-sm-0">
                    <label for="responsable" aria-hidden='true'>Responsable</label>
                    <select id='responsable' name="responsable" style="width: 100%" required >
                        @foreach ($contactos as $contacto)
                            <option value="{{$contacto->contacto->id}}">
                                {{ $contacto->contacto->nombre }} {{ $contacto->contacto->apellido }}
                            </option>
                        @endforeach                        
                    </select>
                </div>

                <div class="form-group col-12 col-sm-6 mb-sm-0">
                    <label for="fecha_limite">Fecha limite</label>
                    <input type="date" class="form-control" id='fecha_limite' name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Selecciona la fecha para el encargo" required >
                </div>
            </div>
            <div class="form-group">
                <label for="encargo">Encargo</label>
                <textarea class="form-control" id='encargo' name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required >{{old('encargo')}}</textarea>
            </div>           
            
            <button type="reset" class="btn btn-danger">Limpiar</button>
            <button type="submit" class="btn btn-primary">Crear encargo</button>
        </form>
    </div>
@endsection