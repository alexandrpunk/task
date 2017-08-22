<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$data['nombre_asignador']}} te ha hecho un encargo nuevo</title>
</head>
<body>
    <p>El usuario <b>{{$data['nombre_asignador']}}</b> te ha asignado un nuevo encargo:</p>
    <p>{{$data['encargo']}}</p>
    <p>y debe ser cumplido para el: <b>{{$data['fecha_limite']}}</b></p>
    <p>para ver tu encargo y concluirlo da click <a href="{{url('/encargos/ver')}}/{{$data['id']}}">en este enlace</a></p>
</body>
</html>