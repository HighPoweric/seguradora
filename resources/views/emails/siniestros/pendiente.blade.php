@component('mail::message')
# 📋 LIQUIDACIÓN SINIESTRO {{ $nro }} — {{ $aseguradora }}

Hola **{{ $destinatario }}**,

Representamos a **{{ $aseguradora }}** para continuar con el proceso de liquidación de su siniestro.

@if(!empty($peritoEmail))
> **En copia (CC):** {{ $peritoNombre ? $peritoNombre . ' — ' : '' }}<{{ $peritoEmail }}>
@endif

## Documentos requeridos
@forelse ($documentos as $doc)
- **{{ mb_strtoupper($doc->nombre) }}**
  @if(!empty($doc->pivot?->observacion))
  - *{{ $doc->pivot->observacion }}*
  @endif
@empty
- *No hay documentos asociados a este peritaje.*
@endforelse

## 📅 Entrevista requerida
Necesitamos realizar una **entrevista** con los involucrados.
Por favor indique **día y horario** disponible dentro de los próximos **3 días**.

**Modalidades disponibles:** Llamada, Videollamada o WhatsApp.


Gracias por su colaboración,
**Equipo de Liquidaciones**

---

@slot('subcopy')
Si tiene dudas, puede responder directamente a este correo.
@if(!empty($peritoEmail))
Las respuestas llegarán a **{{ $peritoNombre ?? 'el perito a cargo' }}** (<{{ $peritoEmail }}>).
@endif
@endslot
@endcomponent
