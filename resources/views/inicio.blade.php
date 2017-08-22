@section('title', 'Inicio')
@extends('layouts.base')

@section('content')
    <div class="container containervc zro">
      <div class="vcenter">
          <div class="center-cont"><a href="{{route('nuevo_encargo')}}" class="btn btn-success tsk-btn"><span>Crear<br>Encargo</span></a></div>
          <div class="center-cont"><a href="{{route('mis_encargos')}}" class="btn btn-info tsk-btn"><span>Administrar</span></a></div>
      </div>

    </div><!-- /.container -->
@endsection