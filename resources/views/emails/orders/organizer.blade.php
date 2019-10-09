@component('mail::message')
# New order

У вас новая заявка!

@component('mail::button', ['url' => ''])
go to the site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
