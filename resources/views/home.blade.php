@extends('layouts.app')
@section('content')
    @if(session()->has('previous-route') && session('previous-route') === 'create_order')
        <div class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Ваш заказ успешно добавлен</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="text-center">Найти курьера</div>
                <br>
                <br>
            </div>
        </div>
        <div>
            @include('map')
        </div>
        <div class="row">
            @if (isset($orders))
                @foreach($orders as $order)
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
                                        <th>{{ '#' . $order->id }}</th>
                                    </tr>
                                    <tr>
                                        <th>Габариты</th>
                                        <th>{{ $order->weight . ' x ' . $order->height . ' x ' . $order->depth }}</th>
                                    </tr>
                                    <tr>
                                        <th>Кол-во</th>
                                        <th>{{ $order->quantity }}</th>
                                    </tr>
                                    <tr>
                                        <th>Время доставки</th>
                                        <th>{{ $order->time_of_receipt }}</th>
                                    </tr>
                                    <tr>
                                        <th>Имя получателя</th>
                                        <th>{{ $order->name_receiver }}</th>
                                    </tr>
                                    <tr>
                                        <th>Номер получателя</th>
                                        <th>{{ $order->phone_receiver }}</th>
                                    </tr>
                                    <tr>
                                        <th>Почта получателя</th>
                                        <th>{{ $order->email_receiver}}</th>
                                    </tr>
                                    <tr>
                                        <th>Адрес А</th>
                                        <th>{{ $order->address_a }}</th>
                                    </tr>
                                    <tr>
                                        <th>Адрес Б</th>
                                        <th>{{ $order->address_b }}</th>
                                    </tr>
                                    <tr>
                                        <th>Цена</th>
                                        <th>{{ $order->price . ' грн.' }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                                {{ csrf_field() }}
                                @if (!Auth::guest())
                                    <div id="courierId" class="hidden">{{ Auth::User()->id }}</div>
                                    @if (Auth::User()->id !== $order->user_id)
                                        <button data-id="{{$order->id}}"
                                                class="acceptedBtn changeStatusBtn btn btn-success"
                                                type="submit">
                                            Принять заказ
                                        </button>
                                    @else
                                        <p>Вы не можете принят свой заказ</p>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                @endforeach
            @endif
        </div>
    </div>

@endsection


