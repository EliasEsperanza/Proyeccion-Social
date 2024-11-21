<x-mail::message>
# Asunto: Restablecimiento de tu contraseña.

Hola {{ $user->name }},<br><br>

Recibimos una solicitud para restablecer la contraseña de tu cuenta.
Para proceder utiliza el sigueinte codigo de verificación:<br><br>

[Código]
{{ $codigo }}<br><br>

<x-mail::button :url="$urlpassword">
Restablecer contraseña
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
