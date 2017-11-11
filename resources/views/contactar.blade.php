@section('title', 'Contacto y reporte de errores')
@section('back', route('mis_encargos'))
@extends('layouts.base')

@section('content')
    <div class="jumbotron alert alert-dark text-center p-5 my-3">
        <h1 class='display-4'>¿Tienes alguna sugerencia?</h1>
        <p class='lead'>Si has encontrado algun error o tienes una sugerencia hacerca de como mejorar la aplicacion haznoslo saber enviando un correo a la siguiente direccion.</p>
        <p><a class="btn btn-info" href="mailto:reportar@encargapp.mx" role="button">reportar@encargapp.mx</a></p>
    </div
@endsection