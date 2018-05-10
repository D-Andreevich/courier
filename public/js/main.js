var token = $('#_token').attr('content');
var socket = io(':6001');
var AllNotification = {};
$(document).ready(function () {
    // Notification AJAX

    var old_count = +$('.notification-menu').attr('data-count');

    (function () {
        $.ajax({
            type: "POST",
            url: "/profile/notification",
            headers: {
                'X-CSRF-Token': token
            },
            success: function (data) {
                setNotification(data)
            }
        });
    })();

    socket.on('new-notification:newNotification', function (data) {
        setNotification(data.notification)
    });

    // Init Slider
    $("#slider").slider({});

    // MarkAsRead Notifications

    $('.notification').on('click', function () {
        $('.newNotyIcon').html('');
        $('.unread').on('mouseover', function () {
            $('.unread').each(function () {
                old_count = old_count - 1;
                $(this).removeClass('unread');
            });
        });
        $.get('/order/markAllSeen', function () {
            AllNotification = {};
        });
    });


    $('.rateBtn').click(function () {
        $('.rate-user input[name=data]').attr('data-id', this.dataset.id).attr('data-courier_id', this.dataset.courier_id);
    });

    if ($('.example').length) {
        $('.example').barrating('show', {
            theme: 'css-stars',
            onSelect: function (value, text, event) {
                if (typeof(event) !== 'undefined') {
                    // rating was selected by a user
                    $rating = value;
                    $userCount = 1;
                    $courierid = $('input[name=data]').attr('data-courier_id');
                    $orderId = $('input[name=data]').attr('data-id');

                    $.ajax({
                        type: 'POST',
                        url: '/profile/rating',
                        headers: {
                            'X-CSRF-Token': token
                        },
                        data: {
                            'rating': $rating,
                            'userCount': $userCount,
                            'courierId': $courierid,
                            'orderId': $orderId
                        },
                        success: function () {
                            location.reload();
                        }
                    });

                    // $('#noty_layout__center').hide();
                    // $('.rate-user').hide();

                } else {
                    // rating was selected programmatically
                    // by calling `set` method
                }
            }
        });
    }

    $('.removeBtn').click(function () {
        $orderId = this.dataset.id;

        $.ajax({
            type: 'POST',
            url: '/order/remove',
            headers: {
                'X-CSRF-Token': token
            },
            data: {
                'order_id': $orderId
            },
            success: function () {
                location.reload();
            }
        });
    });

    $('.restoreBtn').click(function () {
        $orderId = this.dataset.id;

        $.ajax({
            type: 'POST',
            url: '/order/restore',
            headers: {
                'X-CSRF-Token': token
            },
            data: {
                'order_id': $orderId
            },
            success: function () {
                location.reload();
            }
        });
    });

    // Deny Order for courier

    $('.denyBtn').click(function () {
        $id = this.dataset.id;
        $userId = this.dataset.user_id;
        $courierId = this.dataset.courier_id;

        $.ajax({
            type: 'POST',
            url: '/order/deny',
            headers: {
                'X-CSRF-Token': token
            },
            data: {
                'order_id': $id,
                'user_id': $userId,
                'courier_id': $courierId
            },
            success: function () {
                location.reload();
            }
        });
    });

    // Accepted orders AJAX

    $('.acceptedBtn').click(function () {
        $courierId = $('#courier_id').text();
        $orderId = this.dataset.id;
        $userId = this.dataset.user_id;

        $.ajax({
            type: 'POST',
            url: '/order/accept',
            headers: {
                'X-CSRF-Token': token
            },
            data: {
                'courier_id': $courierId,
                'order_id': $orderId,
                'user_id': $userId
            },
            success: function (data) {
                location.reload();
            }
        });
    });

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

    if ($('.phone').length) {
        // Phone Mask
        $(".phone").mask("+38 (999) 999-9999");
    }

    if ($('.datepicker-here').length) {
        // Initialization
        $('.datepicker-here').datepicker({
            minDate: new Date(),
            timepicker: true
        });
        // Access instance of plugin
        $('.datepicker-here').data('datepicker');
    }
    function setNotification(data) {
        $.each(data, function (i, v) {
            if(!AllNotification[v.id_num]) {
                AllNotification[v.id_num] = v.id_num;
                old_count = Object.keys(data).length;
                $('.noNoty').remove();
                $a = $('<a>').html(v.data.data + '<br/><span class="text-info text-right">' + calculateDate(v.created_at) + '</span>');
                $li = $('<li>').addClass('unread').prepend($a);
                $('.notification-menu').prepend($li);
                $('.newNotyIcon').html('•');
            }
        });
    }

    function calculateDate(date, format) {
        let halloween = moment(date);
        if (format) {
            halloween.format(format);
        } else {
            halloween.format('YYYY-DD-MM HH:mm:ss');
        }

        return halloween.fromNow();
    }
});
