@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked" style="margin-top: 30px">
                    <li class="active"><a href="">Активные</a></li>
                    <li><a href="{{ route('client_complete') }}">Завершенные</a></li>
                </ul>
            </div>
            <div class="col-md-7">
                <h2 style="font-weight: 900">Активные заказы</h2>
                <br>
                <br>
                @if (isset($entries))
                    @foreach($entries as $orders)
                        <h4 style="font-weight: 700">Статус заказа:
                            @if ($orders[0]->status === 'accepted')
                                принят
                            @elseif ($orders[0]->status === 'taken')
                                забран
                            @endif
                        </h4>
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Номер заказа</th>
                                <th data-id="{{ $orders[0]->id  }}">{{ '#' . $orders[0]->id }}</th>
                            </tr>
                            <tr>
                                <th>Габариты</th>
                                <th>{{ $orders[0]->weight . ' x ' . $orders[0]->height . ' x ' . $orders[0]->depth . ' см'}}</th>
                            </tr>
                            <tr>
                                <th>Кол-во</th>
                                <th>{{ $orders[0]->quantity . ' кг'}}</th>
                            </tr>
                            <tr>
                                <th>Доставить до</th>
                                <th>{{ $orders[0]->time_of_receipt }}</th>
                            </tr>
                            <tr>
                                <th>Имя получателя</th>
                                <th>{{ $orders[0]->name_receiver }}</th>
                            </tr>
                            <tr>
                                <th>Номер получателя</th>
                                <th><a href="tel:{{ $orders[0]->phone_receiver }}">{{ $orders[0]->phone_receiver }}</a>
                                </th>
                            </tr>
                            <tr>
                                <th>Адрес А</th>
                                <th>{{ $orders[0]->address_a }}</th>
                            </tr>
                            <tr>
                                <th>Адрес Б</th>
                                <th>{{ $orders[0]->address_b }}</th>
                            </tr>
                            <tr>
                                <th>Цена</th>
                                <th>{{ $orders[0]->price . ' грн.' }}</th>
                            </tr>
                            <tr>
                                <th>Описание</th>
                                <th>{{ $orders[0]->description }}</th>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <div class="text-center">
                            <h4>Курьер</h4>
                            <br>
                            <img src="{{ $orders[1]->avatar }}" style="width:100px; height:100px; border-radius:50%">
                            <br>
                            <br>
                            <div>
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                @if($orders[1]->total_rates !== 0)
                                    {{ $orders[1]->rating }}
                                @else
                                    {{ '0.00' }}
                                @endif
                            </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th data-courier_id="{{ $orders[1]->id }}" class="hidden"></th>
                                        <th data-client="{{ $orders[0]-> user_id }}" class="hidden"></th>
                                    </tr>
                                    <tr>
                                        <th>Имя курьера</th>
                                        <th>{{ $orders[1]->name }}</th>
                                    </tr>
                                    <tr>
                                        <th>Телефон курьера</th>
                                        <th><a href="tel:{{ $orders[1]->phone }}">{{ $orders[1]->phone }}</a></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <br>
                        @if ($orders[0]->status === 'accepted')
                            <div class="qr-block text-center">
                                <p class="qr-info">Предъявите этот qr код Вашему курьеру для подтверждения</p>
                                <br>
                                {!! QrCode::generate(url('order/taken/' . auth()->user()->id . '/' . md5(auth()->user()->id . $orders[0]->id . $orders[1]->id))) !!}
                                <a href="{{ url('order/taken/' . auth()->user()->id  . '/' . md5(auth()->user()->id . $orders[0]->id . $orders[1]->id)) }}">
                                    {{ $orders[0]->id }}
                                </a>
                            </div>
                        @endif
                        @if ($orders[0]->status === 'taken')
                            <div class="text-center">
                                <a class="btn btn-success" href="{{ url('order/' . $orders[0]->id .  '/tracking/' . md5($orders[1]->id)) }}" style="color: #fff">
                                    Отследить заказ
                                </a>
                            </div>
                            <br>
                            <br>
                        @endif
                    @endforeach
                    <div class="text-center">
                        {!! $entries->appends(Input::except('page'))->render() !!}
                    </div>
                @endif
                @if($entries->isEmpty())
                    <p class="text-center">Нет активных заказов</p>
                @endif
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
@endsection
