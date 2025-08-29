<!DOCTYPE html>
<html>
<head>
    <title>Recordatorio Documentos</title>
</head>
<body>
    <p>Estimado(a) {{ $participante->nombre }} {{ $participante->apellido }},</p>

    <p>Este es un recordatorio para que envíe los documentos pendientes relacionados con el siniestro N° {{ $siniestro->id_interno }}.</p>

    <p>Por favor, envíe los documentos lo antes posible. De no recibir respuesta en 4 días, se considerará como no colaborador.</p>

    <p>Saludos cordiales,<br>Equipo de Liquidación</p>
</body>
</html>
