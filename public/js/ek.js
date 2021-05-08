$(document).ready(function() {
    //Back top
    var windowH = $(window).height()/2;
    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css('display','flex');
        } else {
            $("#myBtn").css('display','none');
        }
    });
    $('#myBtn').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 300);
    });


    //Rating
    $('.wrap-rating').each(function(){
        var item = $(this).find('.item-rating');
        var rated = -1;
        var input = $(this).find('input');
        $(input).val(0);

        $(item).on('mouseenter', function(){
            var index = item.index(this);
            var i = 0;
            for(i=0; i<=index; i++) {
                $(item[i]).removeClass('fa-star-outline');
                $(item[i]).addClass('fa-star');
            }

            for(var j=i; j<item.length; j++) {
                $(item[j]).addClass('fa-star-outline');
                $(item[j]).removeClass('fa-star');
            }
        });
        $(item).on('click', function(){
            var index = item.index(this);
            rated = index;
            $(input).val(index+1);
        });
        $(this).on('mouseleave', function(){
            var i = 0;
            for(i=0; i<=rated; i++) {
                $(item[i]).removeClass('fa-star-outline');
                $(item[i]).addClass('fa-star');
            }
            for(var j=i; j<item.length; j++) {
                $(item[j]).addClass('fa-star-outline');
                $(item[j]).removeClass('fa-star');
            }
        });
    });
    
    $(".js-range-slider").ionRangeSlider({
        skin: "flat",
        grid: true,
        min: 0,
    });

    //address
    function make_same_single(type) {
        if ($('.checkbox-same-address').prop('checked')) {
            var control_shipping = $('#shipping_' + type);
            var control_billing = $('#billing_' + type);
            if (control_shipping.hasClass('select2')) {
                control_billing.select2('destroy');
                control_billing.html(control_shipping.html());
                control_billing.val(control_shipping.val());
                control_billing.select2();
            } else {
                control_billing.val(control_shipping.val());
            }
        }
    }
    function make_same() {
        make_same_single('name');
        make_same_single('email');
        make_same_single('phone');
        make_same_single('address');
        make_same_single('province_id');
        make_same_single('city_id');
        make_same_single('districts_id');
        make_same_single('zipcode');
        $('#billing_courier').trigger('change');
    }
    function toggle_readonly(control) {
        if (typeof control.attr('readonly') !== 'undefined' && control.attr('readonly') !== false) {
            control.removeAttr('readonly');
            if (control.hasClass('select2')) {
                control.select2({disabled: false});
            }
        } else {
            control.attr('readonly', 'readonly');
            if (control.hasClass('select2')) {
                control.select2({disabled: true});
            }
        }
    }
    function attach_copy_single(type) {
        var control_shipping = $('#shipping_' + type);
        var control_billing = $('#billing_' + type);
        var event_type = 'keyup';
        if (control_shipping.hasClass('select2')) {
            event_type = 'change';
        }

        control_shipping.on(event_type, function () {
            if ($('.checkbox-same-address').prop('checked')) {
                make_same_single(type);
                $('#billing_courier').trigger('change');
            }
        });
    }
    function attach_copy() {
        attach_copy_single('name');
        attach_copy_single('email');
        attach_copy_single('phone');
        attach_copy_single('address');
        attach_copy_single('province_id');
        attach_copy_single('city_id');
        attach_copy_single('districts_id');
        attach_copy_single('zipcode');
    }
    attach_copy();
    function toggle_billing_readonly() {
        toggle_readonly($('#billing_name'));
        toggle_readonly($('#billing_email'));
        toggle_readonly($('#billing_phone'));
        toggle_readonly($('#billing_address'));
        toggle_readonly($('#billing_zipcode'));
        toggle_readonly($('#billing_province_id'));
        toggle_readonly($('#billing_city_id'));
        toggle_readonly($('#billing_districts_id'));
        toggle_readonly($('#billing_lat'));
        toggle_readonly($('#billing_long'));
    }
    function apply_same_billing_address() {
        if ($('.checkbox-same-address').prop('checked')) {
            make_same();
        }
        toggle_billing_readonly();
    }
    $('.checkbox-same-address').click(function (evt) {
        apply_same_billing_address();
        $('.checkbox-same-address').focus();
    });
    if ($('.checkbox-same-address').prop('checked')) {
        apply_same_billing_address();
    }
    //end


});
