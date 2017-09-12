@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($qrcodes as $qrcode)
                        {!! QrCode::geo($qrcode[2]->getLat(), $qrcode[2]->getLng()) !!}
                @endforeach
            </div>
        </div>
    </div>
@endsection