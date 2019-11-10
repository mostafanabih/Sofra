@component('mail::message')
# Introduction

Sofra Reset Password

@component('mail::button', ['url' => route("clNewPassword")])
Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
