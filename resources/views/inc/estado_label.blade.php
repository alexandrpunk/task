@php
    $fecha_limite = strtotime($encargo->fecha_plazo);
    $fecha_creacion = strtotime($encargo->created_at);
    $hoy = Time();
    $porcentaje = ($hoy - $fecha_creacion) / ($fecha_limite - $fecha_creacion) * 100;
    $color_label = '';
    $estado = '';
    if ($porcentaje < 50 && $porcentaje > 0 ) {
    $color_label = '#e6c94c';
    $estado = 'en progreso';
    } else if ($porcentaje > 50 && $porcentaje <= 100) {
    $color_label = '#dd7f21';
    $estado = 'cerca de vencer';
    } else if ($porcentaje > 100 || $porcentaje < 0) {
    $color_label = '#f00';
    $estado = 'Vencido';                      
    }
@endphp
<span style="background-color:{{$color_label}};" class="label label-primary">
{{$estado}}
</span>
@if (!$encargo->visto)
<span class="label label-info">Sin ver</span>
@endif