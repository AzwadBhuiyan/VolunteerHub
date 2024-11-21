<x-mail::message>
# Two Factor Authentication Code

Your authentication code is: **{{ $code }}**

This code will expire in 10 minutes.

If you did not request this code, please secure your account immediately.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>