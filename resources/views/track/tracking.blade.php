<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Courier') }} Отслеживание посылки</title>

    <script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.4.1.min.js" ></script>

    @if(Request::secure())
        <link href="{{ secure_asset('css/tracking.css') }}" rel="stylesheet">
        <script src="{{ secure_asset('js/tracking.js') }}"></script>

    @else
        <link href="{{ asset('css/tracking.css') }}" rel="stylesheet">
        <script src="{{ asset('js/tracking.js') }}"></script>

    @endif


</head>
<body>

    <div class="container">
        <div id="map-canvas"></div>
    </div>

    <script src = "https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCQGiP-8aFcyPivJHoP1NIi2VKYd4I8BLQ&callback=initialize" > </script>

</body>
</html>