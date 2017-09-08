@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="stepwizard col-md-offset-3">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                    <p>Step 1</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Step 2</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Step 3</p>
                </div>
            </div>
        </div>

        <form role="form" action="{{ route('create_order') }}" method="post">
            {{ csrf_field() }}
            <div class="row setup-content" id="step-1">
                <div class="col-xs-6 col-md-offset-3">
                    <div class="col-md-12">
                        <h3> Step 1</h3>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <label class="control-label">Габариты</label>
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
                        <label class="control-label">Вес</label>
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="number" name="weight" required="required" class="form-control"/>
                                <span>кг</span>
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
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-2">
                <div class="col-xs-6 col-md-offset-3">
                    <div class="col-md-12">
                        <h3> Step 2</h3>
                        <div class="form-group">
                            <label class="control-label">Имя получателя</label>
                            <input name="name_receiver" type="text" required="required" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Телефон получателя</label>
                            <input name="phone_receiver" type="tel" required="required" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Почта получателя</label>
                            <input name="email_receiver" type="email" required="required" class="form-control"/>
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-3">
                <div class="col-xs-6 col-md-offset-3">
                    <div class="col-md-12">
                        <h3> Step 3</h3>
                        <div class="form-group">
                            <label class="control-label">Адрес А</label>
                            <input name="address_a" id="address_a" type="text" required="required" class="form-control"
                                   onfocus="initAutocomplete(this.id)"/>
                            <input type="hidden" name="coordinate_a" id="coordinate_a" value=""/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Адрес Б</label>
                            <input name="address_b" id="address_b" type="text" required="required" class="form-control"
                                   onfocus="initAutocomplete(this.id)"/>
                            <input type="hidden" name="coordinate_b" id="coordinate_b" value=""/>
                            <input type="hidden" name="distance" id="distance" value="">
                        </div>
                        <label class="control-label">Цена</label>
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="price" min="1" step="any" type="number" required="required" class="form-control"/>
                                    <div class="input-group-addon">.00</div>
                                    <div class="input-group-addon">грн.</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="csrf_field()">
                        <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfe_GhU5m1WWaZFqTwaqKsjs1r_Kt06_k&libraries=places"
            async defer></script>
@endsection