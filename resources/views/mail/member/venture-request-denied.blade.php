<x-mail::message>
# Aprobación de Solicitud de Emprendimiento

Su emprendimiento fue declinado.

{{ $venture->approval_reason }}

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
