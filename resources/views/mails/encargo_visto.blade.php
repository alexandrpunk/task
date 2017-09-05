<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$data['nombre_responsable']}} ha visto tu encargo</title>
</head>
<body>
    <p>El usuario <b>{{$data['nombre_responsable']}}</b> ha visto el nuevo encargo que le has hecho:</p>
    <p>{{$data['encargo']}}</p>
    <p>el cual tiene fecha limite para completarse el: <b>{{$data['fecha_limite']}}</b></p>
    <p>para ver los detalles del encargo da click <a href="{{url('/encargos/ver')}}/{{$data['id']}}">en este enlace</a></p>
</body>
</html>