@component('mail::message')
# 📋 LIQUIDACIÓN SINIESTRO {{ $nro }} - {{ $aseguradora }}

Hola **{{ $destinatario }}**,

Representamos a **{{ $aseguradora }}** para continuar con el proceso de liquidación.

## Documentos Requeridos
@forelse ($documentos as $doc)
- **{{ mb_strtoupper($doc->nombre) }}**
@if(!empty($doc->pivot?->observacion))
  - *{{ $doc->pivot->observacion }}*
@endif
@empty
- *No hay documentos asociados a este peritaje*
@endforelse

## 📅 Entrevista Requerida
Necesitamos realizar una **entrevista** con los involucrados.
Por favor indique **día y horario** disponible dentro de los próximos **3 días**.

**Modalidades disponibles:** Llamada, Videollamada o WhatsApp

@component('mail::button', ['url' => $urlDetalle])
Ver Detalle del Siniestro
@endcomponent

Saludos cordiales,
**Equipo de Liquidaciones**
@endcomponent
