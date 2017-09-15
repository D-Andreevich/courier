$(document).ready(function () {

    $('.example').barrating('show', {
        theme: 'css-stars',
        onSelect: function (value, text, event) {
            if (typeof(event) !== 'undefined') {
                // rating was selected by a user
                $token = $('input[name=_token]').val();
                $rating = value;
                $userCount = 1;

                $.ajax({
                    type: 'POST',
                    url: '/user/rating',
                    data: {
                        '_token': $token,
                        'rating': $rating,
                        'userCount': $userCount
                    },
                    success: function (res) {
                        $('.example').barrating('destroy');
                    }
                });
            } else {
                // rating was selected programmatically
                // by calling `set` method
            }
        }
    });

    $('.denyBtn').click(function () {
        $token = $('input[name=_token]').val();
        $id = this.dataset.id;
        $.ajax({
            type: 'POST',
            url: '/deny/' + $id,
            data: {
                '_token': $token
            },
            success: function (res) {
                console.log(res);
                //location.reload();
            }
        });
    });

    // Accepted orders AJAX

    $('.acceptedBtn').click(function () {

        $token = $('input[name=_token]').val();
        $courierId = $('#courierId').text();
        $orderId = this.dataset.id;
        $userId = this.dataset.userid;

        if ($userId != $courierId) {
            var urls = ['/accepted_order', '/change_status'];
            $.each(urls, function (i, u) {
                $.ajax(u,
                    {
                        type: 'POST',
                        data: {
                            '_token': $token,
                            'user_id': $courierId,
                            'order_id': $orderId,
                            'role': 'courier'
                        },
                        success: function (data) {
                            location.reload();
                        }
                    }
                );
            });
        } else {
            alert('Вы не можете принять свой заказ');
        }
    });

    // Notification if order status delivered
    $.ajax({
        type: 'GET',
        url: '/delivered',
        data: {},
        success: function (res) {
            if (res) {
                alert(res);
            }
        }
    });

    $('.modal').modal('show');

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');

    // Initialization
    $('.datepicker-here').datepicker({
        minDate: new Date(),
        timepicker: true
    });
    // Access instance of plugin
    $('.datepicker-here').data('datepicker');

    // Phone Mask

    $(".phone").mask("+38 (999) 999-9999");

});