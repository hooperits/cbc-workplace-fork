<x-mail::message>
# Cambio en su emprendimiento

Su emprendimiento fue {{ ($venture->is_active ? "activado" : "inactivado") }}

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
