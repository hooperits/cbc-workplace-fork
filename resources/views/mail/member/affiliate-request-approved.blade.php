<x-mail::message>
# Solicitud de afiliación

Su solicitud fue aprobada.

{{ $member->membership_approval_reason }}

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
