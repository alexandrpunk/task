@php ($menu = 2)
@section('title', 'Crear Encargo')
@section('back', route('mis_encargos'))
@extends('layouts.base')

@section('css')
@endsection

@section('js')
<script>


    var errorAudio = new Audio('/sound/error_1.wav');
    var successAudio = new Audio('/sound/send_1.wav');


    $("#encargoForm").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $.ajax({
            type: "POST",
            url: $("#encargoForm").data("url"),
            dataType: 'json',
            data: $("#encargoForm").serialize(), // serializes the form's elements.
            success: function(data) {
                $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
                $( "#alert-field" ).empty();
                $( "#alerta" ).addClass('alert-success show');
                $( "#alert-field" ).append('<p>'+data.message+'</p>');
                successAudio.play();
            },
            error: function(error) {
                $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
                $( "#alert-field" ).empty();

                var data = error.responseJSON;
                $( "#alert-field" ).append('<p>'+data.message+'</p>');
                var list = '<ul>';
                $.each(data.errors, function(i, item) {
                    if (item.constructor === Array) {
                        $.each(item, function(f, foo) {
                           list += "<li>" + foo + "</li>"
                        });
                    }
                });
                list += '</ul>';
                $( "#alert-field" ).append(list);
                errorAudio.play();
                $( "#alerta" ).addClass('alert-danger show');
            }
        });
    });

    $("#closeAlert").click(function(){ 
        $( "#alerta" ).removeClass('alert-success alert-danger alert-warning alert-info show');
        $( "#alert-field" ).empty();
    });
</script>
@endsection

@section('content')
    <div class="card p-3 my-3">
        <form data-url='{{Request::url()}}' id='encargoForm' aria-label='Formulario de creacion de encargos'>
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="encargo" aria-hidden='true'>Encargo</label>
                <textarea class="form-control form-control-sm" id='encargo' name="encargo" placeholder="Describe tu encargo aqui"  rows="8" required>{{old('encargo')}}</textarea>
            </div>
            <div class="row">
                <div class="form-group col-12 col-sm-2 mb-sm-0">
                    <label for="fecha_limite" aria-hidden='true'>Fecha limite</label>
                    <input type="date" class="form-control form-control-sm" id='fecha_limite' name="fecha_limite" value="{{old('fecha_limite')}}" placeholder="Selecciona la fecha para el encargo" required >
                </div>
            </div>        
            <hr aria-hidden='true'>
            <button type="reset" class="btn btn-sm btn-danger">Limpiar</button>
            <button type="submit" class="btn btn-sm btn-success">Enviar encargo</button>
        </form>
    </div>
@endsection