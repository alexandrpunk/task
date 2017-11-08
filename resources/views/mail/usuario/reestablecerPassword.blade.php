@extends('mail.layouts.message')

@section('body')
<h1 style='text-align:center;font-weight:300;font-size:2.8rem;margin:10px'>
    Reestablece tu contraseña
</h1>
<p style='font-size:1.2rem;text-align:center;'>
    Estas recibiendo este correo ya que solicitaste el reestablecimiento de tu contraseña, solo haz click en el siguiente enlace y podras elegir una nueva contraseña.
</p>
<div style='text-align:center;'>
    <a href="{{route('reset_pass', ['token' => $token])}}" target='_blank' style='display:inline-block;;font-size:1.2rem;color:#fff;background-color:#007bff;margin:15px 0 0;padding:10px 15px;border-radius:4px;text-decoration:none;'>
        Reestablecer contraseña
    </a>
</div>
<p style='font-size:1.2rem;text-align:center;'>
    Si tu no haz solicitado el restablecimiento solo ingora este correo.
</p>
<p style='font-size:1rem;text-align:center;margin-bottom:15px;margin-left:10%;margin-right:10%;color:#545454;line-height:2rem;'>
    Si tienes problemas para abrir el enlace copia y pega la siguiente direccion en tu navegador web: <span style='background-color:#E8E8E8;color:#DF255E;padding:2px 5px;text-align:center;'>{{route('reset_pass', ['token' => $token])}}</span>
</p>
@endsection