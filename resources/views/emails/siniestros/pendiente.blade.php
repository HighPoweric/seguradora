@component('mail::layout')

{{-- BODY --}}
# LIQUIDACIÓN SINIESTRO {{ $nro }} {{ $aseguradora }}

Hola {{ $destinatario }},

Estamos representando a **{{ $aseguradora }}**, para realizar diligencias propias del proceso de liquidación.
Para poder continuar requerimos que nos aporte los siguientes documentos *(aunque los haya enviado previamente a la compañía)*:

@forelse ($documentos as $doc)
- **{{ mb_strtoupper($doc->nombre) }}**@if(!empty($doc->pivot?->observacion)) — {{ $doc->pivot->observacion }} @endif
@empty
- *(No hay documentos asociados a este peritaje)*
@endforelse

Adicionalmente, debemos realizar una **entrevista** con los involucrados y el asegurado para obtener antecedentes de la liquidación.
Por favor indíquenos **día y horario** disponible dentro de los próximos **3 días**. Puede ser **llamada, videollamada o por escrito** (WhatsApp).

@component('mail::button', ['url' => $urlDetalle])
Ver detalle del siniestro
@endcomponent

{{-- FOOTER opcional --}}
@slot('footer')
@endslot

@endcomponent
