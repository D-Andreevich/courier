@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="orderForm">
                <div class="stepwizard col-xs-offset-3">
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

                <form role="form" action="{{ route('create_order') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row setup-content" id="step-1">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 1</h3>
                                <label class="control-label">Габариты (см.)</label>
                                <div class="form-inline text-center">
                                    <div class="form-group">
                                        <input type="number" name="width" required="required" class="form-control"
                                               placeholder="Ширина"/>
                                    </div>
                                    <span>x</span>
                                    <div class="form-group">
                                        <input type="number" name="height" required="required" class="form-control"
                                               placeholder="Высота"/>
                                    </div>
                                    <span>x</span>
                                    <div class="form-group">
                                        <input type="number" name="depth" required="required" class="form-control"
                                               placeholder="Глубина"/>
                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Вес (кг)</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input type="number" name="weight" required="required" class="form-control"/>
                                    </div>
                                </div>
                                <br>
                                <label class="control-label">Количество</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input type="number" name="quantity" required="required" class="form-control" min="1"
                                               max="100" value="1"/>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label">Дата</label>
                                    <input type="text" name="time_of_receipt" required="required"
                                           class="datepicker-here form-control" data-position='top left'/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Комметарий к товару</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Дальше</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 2</h3>
                                <div class="form-group">
                                    <label class="control-label">Имя получателя</label>
                                    <input name="name_receiver" type="text" required="required" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Телефон получателя</label>
                                    <input name="phone_receiver" type="tel" required="required" class="phone form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Почта получателя</label>
                                    <input name="email_receiver" type="email" required="required" class="form-control"/>
                                </div>
                                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" onclick="addMap()">Дальше</button>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="col-md-12">
                                <h3>Шаг 3</h3>
                                <div class="form-group">
                                    <label class="control-label">Адрес А</label>
                                    <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button"
                                            onclick="myPosition('address_a')"><i class="glyphicon glyphicon-map-marker"></i></button>
                                </span>
                                        <input name="address_a" id="address_a" type="text" required="required"
                                               class="form-control" onfocus="initAutocomplete(this.id)"/>
                                        <input type="hidden" name="coordinate_a" readonly id="coordinate_a" value=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Адрес Б</label>
                                    <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button"
                                            onclick="myPosition('address_b')"><i class="glyphicon glyphicon-screenshot"></i></button>
                                </span>
                                        <input name="address_b" id="address_b" type="text" required="required"
                                               class="form-control" onfocus="initAutocomplete(this.id)"/>
                                        <input type="hidden" name="coordinate_b" readonly id="coordinate_b" value=""/>
                                    </div>

                                    <input type="hidden" name="distance" id="distance" value="">
                                </div>
                                <label>Введие адрес или переместите маркеры в нужные точки на карте</label>
                                <div id="addMap"></div>

                                <label class="control-label">Цена</label>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input name="price" min="1" step="any" type="number" required="required"
                                                   class="form-control"/>
                                            <div class="input-group-addon">.00</div>
                                            <div class="input-group-addon">грн.</div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-lg pull-right" type="submit">Подтвердить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfe_GhU5m1WWaZFqTwaqKsjs1r_Kt06_k&libraries=places,geometry{{--&callback=addMap--}}" async defer></script>
@endsection