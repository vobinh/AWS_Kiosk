	var btnSlt = '';
    var userId = '';
    // Button click
    $('.setPin').click(function(event) {
        var btnclick = $(this);
        var _id      = btnclick.attr('data-value');
        var _key     = btnclick.attr('data-key');
        btnSlt       = _key;
        userId       = _id;
        var width    = $(window).width();
        if(width >= 700){
            if($('.td-pin').is(':visible')){
                $('#wap-credentials').removeClass('content-700');
            }else{
                $('#wap-credentials').addClass('content-700');
            }
        }
        var content = btnclick.siblings('.wap-pin');
        if(content.find('.only-xs').length > 0){
            content.html('');
            $('.setPin').not(this).prop('disabled', false);
            btnclick.siblings('.input-icon').hide();
        }else{
            var wapPin = $('.pin-main').clone().html();
            content.append(wapPin);
            $('.setPin').not(this).prop('disabled', true);
            btnclick.siblings('.input-icon').show();
        }
        
        $('.txt-pin-'+btnSlt).val('');
    });

    $(document).on('click', '.btn-pin', function(event) {
        event.preventDefault();
        var _num = $(this).text();
        if(_num == 'Confirm'){
            checkpin();
        }else{
            var inputPin = $('.txt-pin-'+btnSlt);
            var pin      = inputPin.val();
            inputPin.val(pin+''+_num);
        }
    });
    $( window ).resize(function() {
        if($('.td-pin').is(':visible') || $('.txt-pin-'+btnSlt).is(':visible')){
            if($(this).width() >= 700){
                $('#wap-credentials').addClass('content-700');
            }else{
                $('#wap-credentials').removeClass('content-700');
            }
        }
    });

    $('#frmCredentials input').keypress(function (e) {
        if (e.which == 13) {
            checkpin();
            return false;
        }
    });

    function checkpin(){
        var pin       = $('.txt-pin-'+btnSlt).val();
        var typeLogin = $('.cls-type').val();
        if(pin == '' || typeof pin === 'undefined'){
            $.bootstrapGrowl("Pin is required.", { 
                type: 'danger' 
            });
        }else{
            Kiosk.blockUI({
                target: '#wap-credentials',
                boxed: true,
                message: ''
            });
            $.ajax({
                url: '<?php echo url::base() ?>login/checkPin',
                type: 'POST',
                dataType: 'json',
                data: {
                    '_id': userId,
                    'typeLogin': typeLogin,
                    '_pin': pin
                 },
            })
            .done(function(data) {
                Kiosk.unblockUI('#wap-credentials');
                if(data.msc){
                    window.location.href = data.url;
                }else{
                    $.bootstrapGrowl("Please check your PIN.", { 
                        type: 'danger' 
                    });  
                }   
            })
            .fail(function() {
                Kiosk.unblockUI('#wap-credentials');
                $.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
                    type: 'danger' 
                });
            });
            
        }
    }

    $("input").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });