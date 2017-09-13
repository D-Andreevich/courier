@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($qrcodes as $qrcode)
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-md-offset-4">
                            <div class="thumbnail">
                                <h3 class="text-center">Заказ #{{$qrcode[0]}} </h3>
                                <div class="text-center">
                                    {!! QrCode::generate('google.com/maps/search/' . $qrcode[2]->getLat() . ',' . $qrcode[2]->getLng()) !!}
                                </div>
                                <div class="caption">
                                    <p>Доставить до:</p>
                                    <p>{{$qrcode[1] = date("d-m-y H:i:s")}}</p>
                                    <p>Забрать товар по адресу:</p>
                                    <p>{{$qrcode[4]}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        {{--{!! QrCode::https($qrcode[2]->getLat(), $qrcode[2]->getLng()) !!}--}}
                @endforeach
            </div>
        </div>
    </div>
@endsection