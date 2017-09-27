$(document).ready(function () {

    if ($('.example').length) {
        $('.example').barrating('show', {
            theme: 'css-stars',
            onSelect: function (value, text, event) {
                if (typeof(event) !== 'undefined') {
                    // rating was selected by a user
                    $token = $('input[name=_token]').val();
                    $rating = value;
                    $userCount = 1;
                    $courierid = $('input[name=courier]').val();

                    $.ajax({
                        type: 'POST',
                        url: '/user/rating',
                        data: {
                            '_token': $token,
                            'rating': $rating,
                            'userCount': $userCount,
                            'courierId': $courierid
                        },
                        success: function () {
                            $('.example').barrating('destroy');
                        }
                    });
                } else {
                    // rating was selected programmatically
                    // by calling `set` method
                }
            }
        });
    }

    $('.removeBtn').click(function () {
        $token = $('input[name=_token]').val();
        $orderId = this.dataset.id;

        $.ajax({
            type: 'POST',
            url: '/order/remove',
            data: {
                '_token': $token,
                'order_id': $orderId
            },
            success: function () {
                location.reload();
            }
        });

    });

    // Deny Order for courier

    $('.denyBtn').click(function () {
        $token = $('input[name=_token]').val();
        $id = this.dataset.id;
        $.ajax({
            type: 'POST',
            url: '/order/deny',
            data: {
                '_token': $token,
                'order_id': $id
            },
            success: function (d) {
                location.reload();
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    // Accepted orders AJAX

    $('.acceptedBtn').click(function () {
        $token = $('input[name=_token]').val();
        $courierId = $('#courier_id').text();
        $orderId = this.dataset.id;
        $userId = this.dataset.user_id;

        $.ajax({
            type: 'POST',
            url: '/order/accept',
            data: {
                '_token': $token,
                'courier_id': $courierId,
                'order_id': $orderId,
                'user_id': $userId
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    // Notification if order status delivered
    // $.ajax({
    //     type: 'GET',
    //     url: '/delivered',
    //     data: {},
    //     success: function (res) {
    //         if (res) {
    //             console.log('asdasd');
    //         }
    //     }
    // });

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