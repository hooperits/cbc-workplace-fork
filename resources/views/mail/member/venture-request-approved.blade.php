<x-mail::message>
# Aprobación de Solicitud de Emprendimiento

Su emprendimiento fue aprobado.

{{ $venture->approval_reason }}

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
