@component('mail::message')
# Introduction

Sofra Reset Password
@component('mail::button', ['url' => (route("newPassword"))])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
