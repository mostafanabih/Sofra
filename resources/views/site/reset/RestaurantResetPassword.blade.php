@component('mail::message')
# Introduction

Sofra Reset Password

@component('mail::button', ['url' => route("resNewPassword")])
Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
