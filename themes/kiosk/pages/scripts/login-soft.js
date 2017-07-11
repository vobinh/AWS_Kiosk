var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: false,
	            rules: {
	                txt_email: {
	                    required: true,
	                    email: true
	                },
	                txt_pass: {
	                    required: true
	                }
	            },

	            messages: {
	                txt_email: {
	                    required: "Email is required."
	                },
	                txt_pass: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                // form.submit();
	                Kiosk.blockUI({
		                target: '#wap-login',
		                boxed: true,
                		message: ''
		            });
					var url  = form.action;
					var type = form.method;
					var data = $(form).serialize();
	                $.ajax({
	                    url: url,
	                    type: type,
	                    dataType: 'json',
	                    data: data,
	                })
	                .done(function(data) {
	                	
	                	if(data.msc === 'account_inactive'){
	                		Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl("Your account inactive.", { 
	                        	type: 'danger' 
	                        });
	                	}else if(data.msc === 'account_freeze'){
	                    	Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl("Your account freeze.", { 
	                        	type: 'danger' 
	                        });
	                    }else if(data.msc === 'lv3_no_store'){
	                    	Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl("Your store is not set up.", { 
	                        	type: 'danger' 
	                        });
	                    }else if(data.msc === 'ac_in_store'){
	                    	Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl("Your store is inactive.", { 
	                        	type: 'danger' 
	                        });
	                    }else if(data.msc === true){
	                    	window.location.href = data.url;
	                    	Kiosk.unblockUI('#wap-login');
	                    }else{
	                    	Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl("Please check your e-mail and password.", { 
	                        	type: 'danger' 
	                        });
	                    }
	                })
	                .fail(function() {
	                	Kiosk.unblockUI('#wap-login');
	                	$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
                        	type: 'danger' 
                        });
	                });
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	            	Kiosk.blockUI({
		                target: '#wap-login',
		                boxed: true,
                		message: ''
		            });
					var url  = form.action;
					var type = form.method;
					var data = $(form).serialize();
	                $.ajax({
	                    url: url,
	                    type: type,
	                    dataType: 'json',
	                    data: data,
	                })
	                .done(function(data) {
	                	if(data['status'] == false){
	                		Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl(data['msg'], { 
	                        	type: 'danger' 
	                        });
	                	}else{
	                		$('.forget-form #back-btn').trigger('click');
	                		Kiosk.unblockUI('#wap-login');
	                        $.bootstrapGrowl('Send email success.', { 
	                        	type: 'success' 
	                        });
	                	}
	                  
	                })
	                .fail(function() {
	                	Kiosk.unblockUI('#wap-login');
	                	$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
                        	type: 'danger' 
                        });
	                });
	                //form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });
	}

	var handleRegister = function () {

		function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }


		$("#select2_sample4").select2({
		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


			$('#select2_sample4').change(function () {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });



         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                fullname: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                address: {
	                    required: true
	                },
	                city: {
	                    required: true
	                },
	                country: {
	                    required: true
	                },

	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}
    
    var handleSupport = function(){
    	$('#btn-support').click(function(event) {
    		Kiosk.blockUI();
			$.ajax({
				url: 'login/getSupport',
				type: 'GET'
			})
			.done(function(data) {
				$('.page-quick-wap').width('70%').html(data);
				toogleQuick();
				Kiosk.unblockUI();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
    	});
    }
    return {
        //main function to initiate the module
        init: function () {
            handleLogin();
            handleForgetPassword();
            handleSupport();
            //handleRegister();    
        }

    };

}();

var Frm_Support = function () {
	var Support = function () {
		$('.frm-support').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                txtContent: {
                	required: function() {
                    	CKEDITOR.instances.txtContent.updateElement();
                    }
                },

                messages: {
	                txtContent: "Required"
                },
            },

           	highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                if (element.attr("name") == "txtContent") {
                    error.insertAfter("div#cke_txtContent");
               	} else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function (form) {
            	Kiosk.blockUI();
				var url  = form.action;
				var type = form.method;
				var data = $(form).serialize();
                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                })
                .done(function(data) {
                	if(data['status'] == false){
                		Kiosk.unblockUI();
                        $.bootstrapGrowl(data['msg'], { 
                        	type: 'danger' 
                        });
                	}else{
                		$('.frm-support .toggle-page-quick').trigger('click');
                		Kiosk.unblockUI();
                        $.bootstrapGrowl(data['msg'], { 
                        	type: 'success' 
                        });
                	}
                  
                })
                .fail(function() {
                	Kiosk.unblockUI('#wap-login');
                	$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
                    	type: 'danger' 
                    });
                });
            }
        });
	}
	var ValideCkSupport = function () {
		CKEDITOR.instances["txtContent"].on('change', function() { 
	        if(this.getData() != ''){
	        	$('.txtContent').removeClass('has-error');
	        	$('#txtContent-error').hide();
	        }else{
	        	$('.txtContent').addClass('has-error');
	        	$('#txtContent-error').show();
	        }
	    });
	}
    return {
        //main function to initiate the module
        init: function () {
            Support();   
            ValideCkSupport();
        }

    };

}();