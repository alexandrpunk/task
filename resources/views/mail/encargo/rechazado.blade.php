@extends('mail.layouts.message')

@section('body')
<h1 style='text-align:center;font-weight:300;font-size:2.8rem;margin:10px'>
    Encargo Rechazado
</h1>
<p style='font-size:1.4rem;color:#545454;font-weight:bolder;text-align:center;'>
    Hola {{$encargo->asignador->nombre.' '.$encargo->asignador->apellido}}
</p>
<p style='font-size:1.2rem;text-align:center;'>
    El usuario <b>{{$encargo->responsable->nombre.' '.$encargo->responsable->apellido}}</b> ha rechazado el siguiente encargo:
</p>
<div style='font-size:1.5rem;background-color:#E8E8E8;border-radius:4px;padding:10px;text-align:center;margin:0 10%;'>
    <p>"{{$encargo->encargo}}"</p>
    <p style='font-size:1rem;font-weight:bolder;color:#545454;'>
        Con plazo de cumplimineto para: {{strftime('%A %d de %B %Y',strtotime($encargo->fecha_plazo->getTimestamp()))}}
    </p>
</div>
<div style='text-align:center;'>
    <a href="{{route('ver_encargo', ['id' => $encargo->id])}}" target='_blank' style='display:inline-block;;font-size:1.2rem;color:#fff;background-color:#007bff;margin:15px 0 0;padding:10px 15px;border-radius:4px;text-decoration:none;'>
        Ver encargo
    </a>
</div>
<p style='font-size:1rem;text-align:center;margin-bottom:15px;margin-left:10%;margin-right:10%;color:#545454;line-height:2rem;'>
    Si tienes problemas para abrir el enlace para ver el encargo copia y pega la siguiente direccion en tu navegador web: <span style='background-color:#E8E8E8;color:#DF255E;padding:2px 5px;text-align:center;'>{{route('ver_encargo', ['id' => $encargo->id])}}</span>
</p>
@endsection