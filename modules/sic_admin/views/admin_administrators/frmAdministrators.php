<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Customer'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-customers" action="<?php echo url::base() ?>admin_administrators/save" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-12">
									<h4 class="title-form">Admin Credentials</h4>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_login_name" value="<?php echo !empty($data['super_name'])?$data['super_name']:''; ?>" class="form-control input-sm input-one" placeholder="Admin Name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_login_email" value="<?php echo !empty($data['super_email'])?$data['super_email']:''; ?>" class="form-control input-sm input-one" placeholder="Login Email">
									</div>
									<div class="customers-error">
										<span style='' class="cus-help-block">Email must be unique. <span class="data-code">123</span> already exists. </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="password" name="txt_login_pass" value="" class="form-control input-sm" placeholder="Password">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input autocomplete="off" type="checkbox" <?php echo !empty($data['super_change_passwd'])?"checked":"" ?> <?php echo !isset($data['super_change_passwd'])?"checked":"" ?> class="txt_change_pass" name="txt_change_pass" value="1">&nbsp;Require user to change password at first login
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div class="form-actions right">
					<input type="hidden" id="txt_email_old" name="txt_email_old" value="<?php echo !empty($data['super_email'])?$data['super_email']:''; ?>">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['super_id'])?$data['super_id']:''; ?>">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function() {

	Kiosk.initUniform('.txt_change_pass');

	Kiosk.intOnly('.intOnly');
	if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            rtl: Kiosk.isRTL(),
            orientation: "auto",
            autoclose: true
        });
    }
	$('input[name="txt_cus_no"]').focus();
	$('#frm-customers').validate({
        errorElement: 'span',
        errorClass: 'help-block',
        focusInvalid: false,
        rules: {
            txt_login_name: {
                required: true
            },
            txt_login_email: {
                required: true
            },
            <?php if(empty($data['super_id'])){ ?>
            txt_login_pass: {
                required: true
            }
            <?php } ?>
        },

        messages: {
            
        },

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
			var _input    = $('input[name="txt_login_email"]').val();
			var txt_hd_id = $('input[name="txt_hd_id"]').val();
			var txt_email = $('input[name="txt_email_old"]').val();
        	if(txt_hd_id == '')
        		checkCode(_input, form);
        	else{
        		if(_input != txt_email){
        			checkCode(_input, form);
        		}else{
        			Kiosk.blockUI();
        			form.submit();
        		}
        	}
        }
    });

	    $('#frm-customers input').keypress(function (e) {
	        if (e.which == 13) {
	            if ($('#frm-customers').validate().form()) {
	                $('#frm-customers').submit();
	            }
	            return false;
	        }
	    });

	    function checkCode(input_code, form){
			var url   = form.action;
			var email = $('input[name="txt_cus_login_email"]').val();
	    	Kiosk.blockUI({
                target: '.page-quick-wap',
                boxed: true
            });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>admin_administrators/checkCode',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {
	    			'txt_code': input_code,
	    			'id_super': '<?php echo !empty($data["super_id"])?$data["super_id"]:''; ?>'
	    		},
	    	})
	    	.done(function(data) {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		if(data['msg'] == 'true'){
	    			Kiosk.blockUI();
	    			$('.customers-error').hide();
	    			form.submit();
	    		}else{
	    			$('.customers-error').parent('.in-group').addClass('has-error');
	    			$('.data-code').text(input_code);
	    			$('.customers-error').show();
	    		}
	    	})
	    	.fail(function() {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		console.log("error");
	    	});
	    }
	});

	function nextCode(type){
		Kiosk.unblockUI('.page-quick-wap');
		var id_access = '<?php echo !empty($data['access_no'])?$data['access_no']:'' ?>';
		if(id_access != ''){
			$('input[name="txt_cus_no"]').val(id_access);
			$('.customers-error').parent('.in-group').removeClass('has-error');
			$('.customers-error').hide();
		}else{
			Kiosk.blockUI({
	            target: '.page-quick-wap',
	            boxed: true
	        });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>customers/nextCode/ajax',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {'txt_code': 'code'},
	    	})
	    	.done(function(data) {
	    		if(data['msg'] == 'true'){
	    			$('input[name="txt_cus_no"]').val(data['code']);
	    			$('.customers-error').parent('.in-group').removeClass('has-error');
	    			$('.customers-error').hide();
	    		}else{
	    			$('.customers-error').parent('.in-group').addClass('has-error');
	    			$('.customers-error').show();
	    		}
	    	})
	    	.fail(function() {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		console.log("error");
	    	});
		}
    }
</script>