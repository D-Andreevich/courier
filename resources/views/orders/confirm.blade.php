@extends('layouts.app')
@section('content')
    <div class="text-center">
        {!! QrCode::generate(url('/order/confirm/' . $token) ) !!}
        <a href="/order/confirm/{{$token}}">$token</a>
    </div>
@endsection