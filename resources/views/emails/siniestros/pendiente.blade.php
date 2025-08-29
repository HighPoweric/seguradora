@component('mail::layout')

{{-- BODY --}}
# LIQUIDACIÓN SINIESTRO {{ $nro }} BCI SEGUROS O ZENIT SEGUROS

Hola {{ $destinatario }},

Estamos representando a **BCI SEGUROS** o **ZENIT SEGUROS**, para realizar diligencias propias del proceso de liquidación.
Para poder continuar con esto requerimos que nos aporte los siguientes documentos *(aunque los haya enviado previamente a la compañía)*:

- **FOTO CÉDULA** (ambos lados).
- **LICENCIA** del conductor (ambos lados). Si conductor y asegurado son distintos, adjuntar de ambos.
- **PADRÓN V1** del vehículo.
- **CERTIFICADO DE REVISIÓN TÉCNICA** vigente.
- **CONTRATO DE COMPRAVENTA** del vehículo.
- **REGISTRO TAG** (si aplica).
- **REGISTRO DE LLAMADAS DEL DÍA DEL SINIESTRO**.
- **REGISTRO DE GRÚA** (si hubo).
- **CARTA DE AUTORIZACIÓN PARA APLICACIONES DE TRANSPORTE**, firmada por **conductor y asegurado** si son distintos.
- **HOJA DE VIDA DEL CONDUCTOR** *(se obtiene en Registro Civil en línea con Clave Única)*.

Adicionalmente, debemos realizar una **entrevista** con los involucrados y el asegurado para obtener antecedentes de la liquidación.
Por favor indíquenos **día y horario** disponible dentro de los próximos **3 días**. Puede ser **llamada, videollamada o por escrito** (WhatsApp).

@component('mail::button', ['url' => config('app.url').'/admin/siniestros/'.$nro.'/edit'])
Ver detalle del siniestro
@endcomponent

{{-- FOOTER opcional (déjalo vacío para no mostrar nada) --}}
@slot('footer')
@endslot

@endcomponent
