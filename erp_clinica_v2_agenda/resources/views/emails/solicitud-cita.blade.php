<!DOCTYPE html>
<html>
<head>
    <title>Nueva Solicitud de Cita</title>
</head>
<body>
    <h1>Nueva Solicitud de Cita</h1>
    <p><strong>Nombre:</strong> {{ $data['nombre'] }} {{ $data['apellido'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Especialidad:</strong> {{ \App\Models\Especialidad::find($data['especialidad_id'])->nombre }}</p>
    <p><strong>Fecha Preferida:</strong> {{ $data['fecha_preferida'] }}</p>
</body>
</html>
