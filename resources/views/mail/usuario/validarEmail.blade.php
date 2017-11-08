@extends('mail.layouts.message')

@section('body')
<p style='font-size:1.4rem;color:#545454;font-weight:bolder;text-align:center;'>
    Hola {{$usuario->nombre.' '.$usuario->apellido}}
</p>
<p style='font-size:1.2rem;text-align:center;'>
    Acabas de registrate en nuestra aplicacion.
</p>
<p style='font-size:1.2rem;text-align:center;'>
    El ultimo paso es validar tu correo, solo haz click en el siguiente boton para hacerlo:
</p>

<div style='text-align:center;'>
    <a href="{{route('validar_email', ['token' => $usuario->email_token])}}" target='_blank' style='display:inline-block;;font-size:1.2rem;color:#fff;background-color:#007bff;margin:15px 0 0;padding:10px 15px;border-radius:4px;text-decoration:none;'>
        Validar email
    </a>
</div>
<p style='font-size:1.2rem;text-align:center;'>
   Gracias por tu interes en usar nuestra aplicacion.
   <br>
    En caso de no haberte registrado y no sabes porque recibes este correo solo ignoralo.
</p>
<p style='font-size:1.2rem;text-align:center;'>
    Saludos de parte del equipo de {{config('app.name')}}.
</p>
<p style='font-size:1rem;text-align:center;margin-bottom:15px;margin-left:10%;margin-right:10%;color:#545454;line-height:2rem;'>
    Si tienes problemas para abrir el enlace copia y pega la siguiente direccion en tu navegador web: <span style='background-color:#E8E8E8;color:#DF255E;padding:2px 5px;text-align:center;'>{{route('validar_email', ['token' => $usuario->email_token])}}</span>
</p>
@endsection