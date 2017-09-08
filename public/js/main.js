$(document).ready(function () {

    // Accepted orders AJAX

    $('.acceptedBtn').click(function () {
        $token = $('input[name=_token]').val();
        $courierId = $('#courierId').text();
        $orderId = ($(this).data('id'));

        $.post('/accepted_order', {
            '_token': $token,
            'courier_id': $courierId,
            'order_id': $orderId
        }, function (data) {
            console.log(data);
        });
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
});