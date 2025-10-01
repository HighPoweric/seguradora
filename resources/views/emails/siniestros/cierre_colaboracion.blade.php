@component('mail::message')
# ✅ Cierre por colaboración – Siniestro {{ $nro }} ({{ $aseguradora }})

Hemos dado **cierre por colaboración** a este caso debido a la **falta de respuesta** dentro de los plazos informados.

Si requiere reactivar el proceso, por favor contáctenos respondiendo este correo.

@component('mail::button', ['url' => $urlDetalle])
Ver Detalle del Siniestro
@endcomponent

Saludos,
**Equipo de Liquidaciones**
@endcomponent
