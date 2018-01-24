@php ($menu = 2)
@section('title', 'Prueba de lista de seleccion')
@section('back', route('mis_encargos'))
@extends('layouts.base')
@section('css')
<style>
.contact-list {
    border:solid 1px rgb(206, 212, 218);
    margin-top:5px;
    max-height: 300px;
    overflow-y: scroll;
}
.contact-list > .contact-item {
    border-bottom:solid 1px rgb(206, 212, 218);
    padding: 5px;
}
.contact-list > .contact-item:last-of-type {
    border-bottom:none;
}


</style>
@endsection
@section('content')
<div class="card my-3">
   <div class="card-body">
    <div class="form-group">
        <input type="text" class="form-control" id="filtrarContactos" placeholder="Buscar contacto...">
        <div class="contact-list">
            <div class="contact-item">
                <span>Juan perez</span>
                <small>email@mail.com</small>
            </div>
            <div class="contact-item">Pacho Lopez</div>
            <div class="contact-item">Manuel Humberto</div>
            <div class="contact-item">Cecilia Torre</div>
            <div class="contact-item">Luz Meza</div>
            <div class="contact-item">Jesus Sandoval</div>
        </div>
      </div>
   </div>
</div>
@endsection