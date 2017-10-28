@section('title', 'Inicio')
@extends('layouts.base')

@section('content')
    <div class="containervc zro">
        <div class="vcenter">
            <div class="center-cont">
                <a href="{{route('nuevo_encargo')}}" class="btn btn-success tsk-btn" aria-label='crear o asignar un encargo' role='button'>
                    <span>Crear<br>Encargo</span>
                </a>
            </div>
            <div class="center-cont">
                <a href="{{route('mis_encargos')}}" class="btn btn-info tsk-btn" aria-label='Administrar encargos y contactos' role='button'>
                    <span>Administrar</span>
                </a>
            </div>
        </div>
    </div><!-- /.container -->
@endsection