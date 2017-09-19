@component('mail::message')
# Подтверждение получения заказа

Пожалуйста, подтвердите получение заказа по нижеуказанной ссылке.

@component('mail::button', ['url' => $url])
Подтвердить
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
