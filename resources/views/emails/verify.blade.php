@component('mail::message')
# Introduction

<form action="register/{{ $token }}"><button type="submit">batata</button></form>
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
