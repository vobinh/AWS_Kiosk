$('#frm-change-pass').validate({
    errorElement: 'span',
    errorClass: 'help-block',
    focusInvalid: false,
    rules: {
        txt_pass: {
            required: true,
        },
        txt_pass_confirm: {
            required: true,
            equalTo: "#txt_pass"
        }
    },

    messages: {
        txt_pass: {
            required: "Password is required."
        },
        txt_pass_confirm: {
            required: "Confirm password is required.",
            equalTo: "Your password / confirm password must match."
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
        form.submit();
    }
});