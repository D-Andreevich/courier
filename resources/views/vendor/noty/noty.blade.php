@if(session()->has('previous-route') && session('previous-route') === 'create_order')
    <script>
        var noty = new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: 'Ваш заказ успешно добавлен',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('taken_order'))
    <script>
        var noty = new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: 'Ваш заказ найден',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('deny_courier'))
    <script>
        new Noty({
            type: 'warning',
            layout: 'bottomLeft',
            text: 'Заказ не найден по вашему профилю',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('deny_order'))
    <script>
        var noty = new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: 'Заказ отменен',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('rate_courier'))
    <div class="rate-user">
        <p>Оценить курьера:</p>
        <input name="courier" value="{{ session('courier_id') }}" type="hidden">
        {{ csrf_field() }}
        <div class="modal-body">
            <select class="hidden example">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>
    <script>
        new Noty({
            type: 'alert',
            layout: 'center',
            text: $('.rate-user').html(),
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('accepted_order'))
    <script>
        new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: 'Заказ успешно принят. Добавлен в Ваш кабинет',
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('remove_order'))
    <script>
        var noty = new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: 'Ваш заказ отменен',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('deny_remove_order'))
    <script>
        var noty = new Noty({
            type: 'warning',
            layout: 'bottomLeft',
            text: 'Удаление невозможно. Этот заказ уже принял курьер',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('empty_receive_token') || session()->has('empty_taken_token'))
    <script>
        var noty = new Noty({
            type: 'warning',
            layout: 'bottomLeft',
            text: 'Заказ по токену не найден',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                        this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('not_auth_courier'))
    <script>
        var noty = new Noty({
            type: 'warning',
            layout: 'bottomLeft',
            text: 'Авторизуйтесь для подтверждения получения заказа',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif

@if(session()->has('not_this_courier'))
    <script>
        var noty = new Noty({
            type: 'warning',
            layout: 'bottomLeft',
            text: 'Заказ не найден по вашему профилю',
            timeout: 3500,
            animation: {
                open: 'animated fadeInUp',
                close: 'animated fadeOutDown'
            },
            closeWith: ['click', 'button'],
            callbacks: {
                onTemplate: function () {
                    this.barDom.innerHTML = '<div class="my-custom-template noty_body">' + this.options.text + '<div>';
                    // Important: .noty_body class is required for setText API method.
                }
            }
        }).show();
    </script>
@endif