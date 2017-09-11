@extends('layouts.app')

@section('content')
    @if (isset($result))
        @foreach($result as $orders)
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
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
                                <th>{{ '#' . $orders[0]->id }}</th>
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
                                <th>Имя курьера</th>
                                <th>{{ $orders[1]->name }}</th>
                            </tr>
                            <tr>
                                <th>Телефон курьера</th>
                                <th>{{ $orders[1]->phone }}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <br>
        @endforeach
        {{--@foreach($orders as $order)--}}
        {{--<div class="container">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
        {{--<table class="table table-striped">--}}
        {{--<thead>--}}
        {{--<tr>--}}
        {{--<th></th>--}}
        {{--<th></th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--<tr>--}}
        {{--<th>Номер заказа</th>--}}
        {{--<th>{{ '#' . $order->id }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Габариты</th>--}}
        {{--<th>{{ $order->weight . ' x ' . $order->height . ' x ' . $order->depth }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Кол-во</th>--}}
        {{--<th>{{ $order->quantity }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Время доставки</th>--}}
        {{--<th>{{ $order->time_of_receipt }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Имя получателя</th>--}}
        {{--<th>{{ $order->name_receiver }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Номер получателя</th>--}}
        {{--<th>{{ $order->phone_receiver }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Почта получателя</th>--}}
        {{--<th>{{ $order->email_receiver}}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Адрес А</th>--}}
        {{--<th>{{ $order->address_a }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Адрес Б</th>--}}
        {{--<th>{{ $order->address_b }}</th>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th>Цена</th>--}}
        {{--<th>{{ $order->price . ' грн.' }}</th>--}}
        {{--</tr>--}}
        {{--</tbody>--}}
        {{--</table>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<br>--}}
        {{--<br>--}}
        {{--@endforeach--}}
    @endif
@endsection