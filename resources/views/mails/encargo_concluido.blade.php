<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$data['nombre_responsable']}} ha concluido un enargo que le has asignado</title>
</head>
<body>
    <p>El usuario <b>{{$data['nombre_responsable']}}</b> ha concluido tu encargo:</p>
    <p>{{$data['encargo']}}</p>
    <p>el estado de conclusion fue: <b>{{$data['estado']}}</b></p>
    <p>puedes ver los detalles completos del encargo <a href="{{url('/encargos/ver')}}/{{$data['id']}}">en este enlace</a></p>
</body>
</html>