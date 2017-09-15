@extends('layouts.app')

@section('content')
    @if (isset($result))
        @foreach($result as $orders)
            @if($orders[0]->status !== 'published')
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
                                    <th>Имя заказчика</th>
                                    <th>{{ $orders[1]->name }}</th>
                                </tr>
                                <tr>
                                    <th>Телефон заказчика</th>
                                    <th>{{ $orders[1]->phone }}</th>
                                </tr>
                                </tbody>
                            </table>
                            @if($orders[0]->status === 'accepted')
                                {{ csrf_field() }}
                                <button type="submit" data-id="{{ $orders[0]->id }}" class="denyBtn btn btn-danger">
                                    Отказаться от заказа
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <br>
            @endif
        @endforeach
    @endif
@endsection