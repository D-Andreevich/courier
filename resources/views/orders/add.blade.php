@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="orderForm">
                <div class="stepwizard col-md-offset-3 col-xs-offset-3">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                            <p>Шаг 1</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p>Шаг 2</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                            <p>Шаг 3</p>
                        </div>
                    </div>
                </div>
            </div>
                <form role="form" enctype="multipart/form-data" action="{{ route('create_order') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row setup-content" id="step-1">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 1</h3>
                                <label class="control-label">Габариты (см)*</label>
                                <div class="form-inline weight-input text-center">
                                    <div class="form-group">
                                        <input type="number" name="width" required="required" class="form-control"
                                               placeholder="Ширина" value="{{ old('width') }}"/>
                                        @if ($errors->has("width"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("width") }}</div>
                                        @endif

                                        <input type="number" name="height" required="required" class="form-control"
                                               placeholder="Высота" value="{{ old('height') }}"/>
                                        @if ($errors->has("height"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("height") }}</div>
                                        @endif

                                        <input type="number" name="depth" required="required" class="form-control" 
                                               placeholder="Глубина" value="{{ old('depth') }}"/>
                                        @if ($errors->has("depth"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("depth") }}</div>
                                        @endif

                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Вес (кг)*</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input type="number" name="weight" required="required" class="form-control" value="{{ old('weight') }}"/>
                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Количество*</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input type="number" name="quantity" required="required" class="form-control" value="{{old('quantity')}}"/>
                                        @if ($errors->has("quantity"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("quantity") }}</div>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Объявленная стоимость*</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="cost" name="cost" step="any" type="number"
                                                   required="required"
                                                   class="form-control" value="{{old('cost')}}"/>
                                            <div class="input-group-addon">.00</div>
                                            <div class="input-group-addon">грн.</div>
                                        </div>
                                        @if ($errors->has("cost"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("cost") }}</div>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Дата*</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input type="text" name="time_of_receipt" required="required"
                                               class="datepicker-here form-control" data-position='top left' value="{{old('time_of_receipt')}}"/>
                                        @if ($errors->has("time_of_receipt"))
                                            <div class="alert alert-danger" role="alert">{{ $errors->first("time_of_receipt") }}</div>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label">Комметарий</label>
                                    <textarea name="description" class="form-control"
                                              placeholder="Напишите, пожалуйста, нужен ли Вам подъем на этаж, если нужен, то на сколько этажей, есть ли в доме лифт, а также краткое описание"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Фото для идентификации</label>
                                    <input type="file" name="photo"  accept="image/*">
                                </div>
                                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Дальше</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 2</h3>
                                <div class="form-group">
                                    <label class="control-label">Имя получателя*</label>
                                    <input name="name_receiver" type="text" required="required"
                                           class="form-control" value="{{ old('name_receiver') }}"/>
                                    @if ($errors->has("name_receiver"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("name_receiver") }}</div>@endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Телефон получателя*</label>
                                    <input name="phone_receiver" type="tel" required="required"
                                           class="phone form-control" value="{{ old('phone_receiver') }}"/>
                                    @if ($errors->has("phone_receiver"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("phone_receiver") }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Почта получателя*</label>
                                    <input name="email_receiver" type="email" required="required"
                                           class="form-control" value="{{ old('email_receiver') }}"/>
                                    @if ($errors->has("email_receiver"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("email_receiver") }}</div>
                                    @endif
                                </div>
                                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button"
                                        onclick="addMap()">Дальше
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 3</h3>
                                <div class="form-group">
                                    <label class="control-label">Адрес А*</label>
                                    <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button"
                                            onclick="myPosition('address_a')"><i
                                                class="glyphicon glyphicon-map-marker"></i></button>
                                </span>
                                        <input name="address_a" id="address_a" type="text" required="required"
                                               class="form-control" onfocus="initAutocomplete(this.id)"/>
                                        <input type="hidden" name="coordinate_a" readonly id="coordinate_a"
                                               value=""/>
                                    </div>
                                    @if ($errors->has("address_a"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("address_a") }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Адрес Б*</label>
                                    <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button"
                                            onclick="myPosition('address_b')"><i
                                                class="glyphicon glyphicon-map-marker"></i></button>
                                </span>
                                        <input name="address_b" id="address_b" type="text" required="required"
                                               class="form-control" onfocus="initAutocomplete(this.id)"/>
                                        <input type="hidden" name="coordinate_b" readonly id="coordinate_b"
                                               value=""/>

                                    </div>
                                    @if ($errors->has("address_b"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("address_b") }}</div>
                                    @endif

                                    <input type="hidden" name="distance" id="distance" value="">
                                </div>
                                <label><h3>Введите адрес или выбирете место на карте</h3></label>
                                <div id="addMap"></div>

                                <label class="control-label">Цена*</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="price" name="price" min="1" step="any" type="number"
                                                   required="required"
                                                   class="form-control"/>
                                            <div class="input-group-addon">.00</div>
                                            <div class="input-group-addon">грн.</div>
                                        </div>
                                    </div>
                                    @if ($errors->has("price"))
                                        <div class="alert alert-danger" role="alert">{{ $errors->first("price") }}</div>
                                    @endif
                                </div>
                                <br>
                                <button class="btn btn-default btn-lg pull-left" type="button"
                                        onclick="calculatePrice()">Рассчитать стоимость
                                </button>
                                <br>
                                <br>
                                <button class="btn btn-success btn-lg pull-right" type="submit">Подтвердить</button>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfe_GhU5m1WWaZFqTwaqKsjs1r_Kt06_k&libraries=places,geometry{{--&callback=addMap--}}"
            async defer></script>
@endsection