<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script>
$(document).ready(function() {	
	$('#frm-myprofile').validate({
	    errorElement: 'span',
	    errorClass: 'help-block',
	    focusInvalid: false,
	    rules: {
	        txt_first: {
	            required: true
	        },
	        txt_last: {
	            required: true
	        },
	        txt_address: {
	            required: true
	        },
	        txt_city: {
	            required: true
	        },
	        txt_state: {
	            required: true
	        },
	        txt_zip: {
	            required: true
	        },
	        txt_phone: {
	            required: true
	        },
	        txt_email: {
	            required: true
	        },
	    },

	    messages: {},

	    invalidHandler: function (event, validator) {
	        
	    },
	    highlight: function (element) {
	        $(element)
	            .closest('.in-group').addClass('has-error');
	    },
	    success: function (label, element) {
	        $(element).closest('.in-group').removeClass('has-error');
	    },
	    errorPlacement: function (error, element) {
	    },
	    submitHandler: function (form) {
	    	Kiosk.blockUI();
	    	form.submit();
	    }
	});
	Kiosk.intOnly('.intOnly');
});
</script>