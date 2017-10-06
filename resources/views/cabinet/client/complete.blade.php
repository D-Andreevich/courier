@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked" style="margin-top: 30px">
                    <li><a href="{{ route('client_active') }}">Активные</a></li>
                    <li class="active"><a href="">Завершенные</a></li>
                </ul>
            </div>
            <div class="col-md-7">
                <h2 style="font-weight: 900">Завершенные заказы</h2>
                <br>
                <br>
                @if (isset($entries))
                    @foreach($entries as $orders)
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
                                <th>{{ $orders[0]->weight . ' x ' . $orders[0]->height . ' x ' . $orders[0]->depth }}</th>
                            </tr>
                            <tr>
                                <th>Кол-во</th>
                                <th>{{ $orders[0]->quantity }}</th>
                            </tr>
                            <tr>
                                <th>Время доставки</th>
                                <th>{{ $orders[0]->time_of_receipt }}</th>
                            </tr>
                            <tr>
                                <th>Имя получателя</th>
                                <th>{{ $orders[0]->name_receiver }}</th>
                            </tr>
                            <tr>
                                <th>Номер получателя</th>
                                <th>{{ $orders[0]->phone_receiver }}</th>
                            </tr>
                            <tr>
                                <th>Почта получателя</th>
                                <th>{{ $orders[0]->email_receiver}}</th>
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
                            </tbody>
                        </table>
                        <br>
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
                                <th data-courier_id="{{ $orders[1]->id }}" class="hidden"></th>
                                <th data-client="{{ $orders[0]-> user_id }}" class="hidden"></th>
                            </tr>
                            <tr>
                                <th>Имя курьера</th>
                                <th>{{ $orders[1]->name }}</th>
                            </tr>
                            <tr>
                                <th>Телефон курьера</th>
                                <th>{{ $orders[1]->phone }}</th>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                    @endforeach
                    <div class="text-center">
                        {!! $entries->appends(Input::except('page'))->render() !!}
                    </div>
                @endif
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
@endsection
