@extends('layouts.app')
@section('content')
    <br>
    <br>
    <br>
    <div class="text-center">
        <h2>Предъявите это курьеру только после того как Ваша посылка будет у Вас</h2>
        {!! QrCode::generate(url('/order/confirm/' . $token) ) !!}
        {{--<a href="/order/confirm/{{$token}}">$token</a>--}}
    </div>
@endsection