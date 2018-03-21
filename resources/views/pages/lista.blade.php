@extends('layouts.base')
@php ( \Carbon\Carbon::setLocale('es_MX.utf8') )
@php ( setlocale(LC_TIME, 'es_MX.utf8') )
@section('title', 'encargapp')
@if (Route::currentRouteName() == 'encargos_contacto')
    @php ($menu = 2)
    @section('back', Route('listar_contactos'))
@else
    @php ($menu = 1)
@endif

@section('css')
@endsection

@section('js')
{{--<script src="{{ URL::asset('js/listar_encargos.js')}}"></script>--}}
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script>
$('.nav-link').click(function(e){
    e.preventDefault();
    $(this).addClass('active');
    $('.nav-link').not(this).removeClass('active');
    $.ajax({
          type: "GET",
          url: $(this).data('url'),
          success: function(result){
              $("#encargos").empty();
              $("#encargos").html(result);
              console.log(result);
          }
      });
});

</script>
@endsection

@section('content')
    <section class="py-3">

    </section>
@endsection