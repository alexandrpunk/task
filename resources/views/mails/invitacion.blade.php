<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienes una invitacion para usar {{ config('app.name') }}</title>
</head>
<body>
    <p>El usuario <b>{{$data['nombre_invitador']}}</b> te a invitado a usar la aplicacion de tareas {{ config('app.name') }}</p>
    <p>Si estas interezado en usarla haz click en el siguiente <a href="{{url('/registro')}}">enlace</a>.</p>
</body>
</html>