@component('mail::message')

Your verification code is: <strong>{{ $otpCode }}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
