<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Courier') }}</title>

@if(Request::secure())
    <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/css/bootstrap-slider.min.css">
        <link href="{{ secure_asset('vendor/bar-rating/themes/css-stars.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('vendor/noty/noty.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/map.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('vendor/air_datepicker/css/datepicker.min.css') }}" rel="stylesheet">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
              integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Scripts -->
        <script src="{{ secure_asset('js/app.js') }}"></script>
        <script src="{{ secure_asset('js/main.js') }}"></script>
        <script src="{{ secure_asset('js/map.js') }}"></script>
        <script src="{{ secure_asset('js/placeAutocomplete.js') }}"></script>
	<script src="{{ secure_asset('vendor/noty/noty.min.js') }}"></script>        
        <script src="{{ secure_asset('vendor/pace/pace.min.js') }}" data-pace-options='{ "ajax": false }'></script>

    @else
    <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/css/bootstrap-slider.min.css">
        <link href="{{ asset('vendor/noty/noty.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bar-rating/themes/css-stars.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/map.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/air_datepicker/css/datepicker.min.css') }}" rel="stylesheet">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
              integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        {{--определение города пользователя--}}

        <!-- Scripts -->
        <script src="{{ asset('vendor/noty/noty.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/map.js') }}"></script>
        <script src="{{ asset('js/placeAutocomplete.js') }}"></script>
        <script src="{{ asset('vendor/pace/pace.min.js') }}" data-pace-options='{ "ajax": false }' ></script>
    @endif
</head>
<body>
<div id="app">
    @include('vendor.noty.noty')
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Kurier+
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Мой кабинет
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('client_active') }}">Заказчик</a></li>
                                <li><a href="{{ route('courier_active') }}">Курьер</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            Ваш город: <span id="geocity"></span>
                        </a>
                        <ul class="dropdown-menu cityMenu" role="menu" style="padding: 40px">
                            <li>
                                {{--<form>--}}
                                {{--{{ csrf_field() }}--}}
                                <label for="city">Ваш город: </label>
                                <input id="myPositionZ" name="city" type="text" placeholder="Введите ваш город"
                                       autofocus onfocus="startAutocomplete(this.id)">
                                {{--</form>--}}
                            </li>
                        </ul>
                    <li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Войти</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                    @else
                        <li class="dropdown" id="markAsRead">
                            <a href="#" class="dropdown-toggle notification" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <i class="notyIcon glyphicon glyphicon-bell"></i>
                                <span class="newNotyIcon">
                                    @if(auth()->user()->unreadNotifications()->count())
                                        {{'•'}}
                                    @endif
                                </span>
                            </a>
                            <ul data-count="{{auth()->user()->unreadNotifications()->count()}}"
                                class="dropdown-menu notification-menu" role="menu" id="showNotification">
                                @if(auth()->user()->unreadNotifications()->count())
                                    @foreach(auth()->user()->unreadNotifications as $note)
                                        <li>
                                            <a class="{{ $note->read_at == null ? 'unread' : '' }}">
                                                {!! $note->data['data'] !!}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="noNoty">
                                        <a style="padding-right: 15px">
                                            <b>Нет новых уведомлений</b>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle userBtn" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <img src="{{ Auth::user()->avatar }}"
                                     style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        @if(Auth::user()->total_rates !== 0)
                                            {{ Auth::user()->rating }}
                                        @else
                                            {{ '0.00' }}
                                        @endif
                                    </a></li>
                                <li>
                                <li>
                                    <a href="{{ route('profile') }}">Профиль</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('add_order') }}" class="btn btn-sm btn-default btnOrder">Добавить
                                заказ</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>
@if(Request::secure())
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/bootstrap-slider.min.js"></script>
    <script src="{{ secure_asset('vendor/masketinput.js') }}"></script>
    <script src="{{ secure_asset('vendor/bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ secure_asset('vendor/air_datepicker/js/datepicker.min.js') }}"></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/bootstrap-slider.min.js"></script>
    <script src="{{ asset('vendor/masketinput.js') }}"></script>
    <script src="{{ asset('vendor/bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('vendor/air_datepicker/js/datepicker.min.js') }}"></script>
@endif
</body>
</html>
