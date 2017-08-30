<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Te recordamos que tienes un encargo pendiente por concluir</title>
</head>
<body>
    <p>Te recordamos que tienes un encargo pendiente por concluir</p>
    <p><b>Encargo:</b> {{$data['encargo']}}</p>
    <p><b>Asignado por:</b> {{$data['asignador']}}</p>
    <p><b>Estado:</b> {{$data['estado']}}</p>
    <p>Debe ser cumplido para el: <b>{{$data['fecha_limite']}}</b></p>
     <p>para ver tu encargo y concluirlo da click <a href="{{url('/encargos/ver')}}/{{$data['id']}}">en este enlace</a></p>
</body>
</html>