<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$data['nombre_comentarista']}} ha comentado en uno de tus encargos</title>
</head>
<body>
    <p>El usuario <b>{{$data['nombre_comentarista']}}</b>  ha comentado lo siguiente:</p>
    <p>{{$data['comentario']}}</p>
    <p>en tu encargo:</p>
    <p>{{$data['encargo']}}</p>
    <p>puedes ver el comentario y responderlo en tu encargo haciendo clik <a href="{{url('/encargos/ver')}}/{{$data['id']}}">en este enlace</a></p>
</body>
</html>