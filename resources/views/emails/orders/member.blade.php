@component('mail::message')
# Hello!

Спасибо, что зарегистрировались на наше мероприятие.

@component('mail::button', ['url' => config('app.url')])
go to the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
