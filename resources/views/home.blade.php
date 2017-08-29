@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#courier" aria-controls="courier" role="tab" data-toggle="tab">Найти курьера</a></li>
                    <li><a href="#order" aria-controls="order" role="tab" data-toggle="tab">Найти заказ</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="courier">@include('find-courier')</div>
                    <div class="tab-pane" id="order">@include('find-order')</div>
                </div>

        </div>
    </div>
</div>
@endsection
