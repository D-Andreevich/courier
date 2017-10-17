@component('mail::message')
# Подтверждение получения заказа

Пожалуйста, подтвердите получение заказа по нижеуказанной ссылке.

@component('mail::button', ['url' => $url])
Подтвердить
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
