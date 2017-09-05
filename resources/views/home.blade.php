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
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#courier" aria-controls="courier" role="tab"
                                              data-toggle="tab">Найти курьера</a></li>
                        <li><a href="#order" aria-controls="order" role="tab" data-toggle="tab">Найти заказ</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="courier" >
                        </div>
                        <div class="tab-pane" id="order" >
                        </div>
                    </div>

                    @include('map')
                </div>
            </div>
        </div>

@endsection


