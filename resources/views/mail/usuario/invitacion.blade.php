@extends('mail.layouts.message')

@section('body')
<h1 style='text-align:center;font-weight:300;font-size:2.8rem;margin:10px'>
    Tienes una invitacion.
</h1>
<p style='font-size:1.1rem;text-align:center;'>
    Hola, es un gusto conocerte, tal parece que uno de nuestros usuarios cree que te podría interesar utilizar {{config('app.name')}}
</p>
<h2 style='text-align:center;font-weight:300;font-size:2rem;margin:10px'>
    ¿Qué es {{config('app.name')}}?
</h2>
<p style='font-size:1.1rem;text-align:center;'>
    {{config('app.name')}} es una herramienta de administracion de tareas (nosotros los llamamos encargos), con un enfoque a administrar los encargos que tu le hagas a tus contactos,
</p>
<h2 style='text-align:center;font-weight:300;font-size:2rem;margin:10px'>
    ¿Cómo funciona?
</h2>
<p style='font-size:1.1rem;text-align:center;'>
    Tu le haces un encargo a uno de tus contactos, y {{config('app.name')}} se da a la tarea de que este se cumpla, le enviamos recordatorios, le damos seguimiento al tiempo restante que le quede al encargo para cumplirse y te avisamos si tu contacto ya ha tu encargo, si lo ha concluido o si tiene algun comentario.
</p>
<p style='font-size:1.1rem;text-align:center;'>
    Ademas puedes utilizar  {{config('app.name')}} para gestionar tus propios encargos.
</p>
<h2 style='text-align:center;font-weight:300;font-size:2rem;margin:10px'>
    ¿Quién me invito?
</h2>
<div style='font-size:1.5rem;background-color:#E8E8E8;border-radius:4px;padding:10px;text-align:center;margin:0 10%;'>
    <p>"{{$remitente->nombre}} {{$remitente->apellido}}"</p>
    <p style='font-size:1rem;font-weight:bolder;color:#545454;'>
        su correo es: {{$remitente->email}}
    </p>
</div>
<p style='font-size:1.1rem;text-align:center;'>
    Si la aplicacion te ha interesado registrate y comienza a administrar tus encargos.
</p>
<div style='text-align:center;'>
    <a href="{{route('registrar')}}" target='_blank' style='display:inline-block;;font-size:1.1rem;color:#fff;background-color:#007bff;margin:15px 0 0;padding:10px 15px;border-radius:4px;text-decoration:none;'>
        ¡registrate es gratis!
    </a>
</div>

<p style='font-size:1rem;text-align:center;margin-bottom:15px;margin-left:10%;margin-right:10%;color:#545454;line-height:2rem;'>
    Si tienes problemas para abrir el enlace para el registro copia y pega la siguiente direccion en tu navegador web: <span style='background-color:#E8E8E8;color:#DF255E;padding:2px 5px;text-align:center;'>{{route('registrar')}}</span>
</p>
@endsection