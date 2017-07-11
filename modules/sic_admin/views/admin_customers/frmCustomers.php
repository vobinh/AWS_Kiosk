<style type="text/css" media="screen">
	.radio{ padding-top: 0 !important }
	.has-error .radio-list{ color: red !important }
</style>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Customer'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-customers" action="<?php echo url::base() ?>admin_customers/save" method="post" class="form-horizontal">
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
								<label class="control-label col-lg-4 col-md-5" style="text-align: left;">Unique Customer No.</label>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_no" class="form-control input-sm intOnly" value="<?php echo !empty($data['admin_no'])?$data['admin_no']:(!empty($codeNew)?$codeNew:''); ?>" autocomplete="off" placeholder="">
									</div>
									<div class="customers-error">
										<span style='' class="cus-help-block">Customer number must be unique. <span class="data-code">123</span> already exists. </span>
										<button type="button" class="btn btn-sm green" onclick="nextCode()">Fix Invalid Values</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4 col-md-4" style="text-align: left;">Primary Contact</label>
								<div class="col-lg-3 col-md-3 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_first_name" value="<?php echo !empty($data['admin_first_name'])?$data['admin_first_name']:''; ?>" class="form-control input-sm input-one" autocomplete="off" placeholder="First">
									</div>
								</div>
								<div class="col-lg-5 col-md-5 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_last_name" value="<?php echo !empty($data['admin_name'])?$data['admin_name']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="Last">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_address" value="<?php echo !empty($data['admin_address'])?$data['admin_address']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="Street Address">
									</div>	
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="text" name="txt_cus_address2" value="<?php echo !empty($data['admin_address_2'])?$data['admin_address_2']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="Street Address 2">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_city" value="<?php echo !empty($data['admin_city'])?$data['admin_city']:''; ?>" class="form-control input-sm input-one" autocomplete="off" placeholder="City">
									</div>	
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_state" value="<?php echo !empty($data['admin_state'])?$data['admin_state']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="State / Province">
									</div>	
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_zip" value="<?php echo !empty($data['admin_zip'])?$data['admin_zip']:''; ?>" class="form-control input-sm input-one intOnly" autocomplete="off" placeholder="Postal / Zip Code">
									</div>	
								</div>
								<div class="col-md-6">
									<select name="txt_cus_country" class="form-control input-sm">
										<option <?php echo (!empty($data['admin_country']) && $data['admin_country'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
										<option <?php echo (!empty($data['admin_country']) && $data['admin_country'] == 'UK')?'selected':''; ?> value="UK">UK</option>
										<option <?php echo (!empty($data['admin_country']) && $data['admin_country'] == 'France')?'selected':''; ?> value="France">France</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input  name="txt_cus_phone" type="text" value="<?php echo !empty($data['admin_phone'])?$data['admin_phone']:''; ?>" class="form-control input-sm input-one" autocomplete="off" placeholder="Phone Number">
									</div>	
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" name="txt_cus_email" value="<?php echo !empty($data['admin_email'])?$data['admin_email']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="E-mail address">
									</div>	
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="text" name="txt_cus_site" value="<?php echo !empty($data['admin_website'])?$data['admin_website']:''; ?>" class="form-control input-sm" autocomplete="off" placeholder="Website">
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="txt_cus_note" rows="3" placeholder="Notes"><?php echo !empty($data['admin_notes'])?$data['admin_notes']:''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<h4 class="title-form">Master Account Credentials</h4>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 in-group">
									<input type="text" name="txt_cus_login_email" value="<?php echo !empty($data['admin_email_login'])?$data['admin_email_login']:''; ?>" class="form-control input-sm input-one" autocomplete="off" placeholder="Login Email">
									<span style='display: none;' class="cus-help-block cls-email-exist"><span class="data-email">123</span> already exists. </span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 in-group">
									<input type="password" name="txt_cus_login_pass" value="" class="form-control input-sm" autocomplete="off" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<input type="checkbox" <?php echo !empty($data['admin_change_pass'])?"checked":"" ?><?php echo !isset($data['admin_change_pass'])?"checked":"" ?> class="txt_change_pass" name="txt_change_pass" value="1">&nbsp;Require user to change password at first login
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<label class="radio-list"><input type="radio" <?php echo (!empty($data['admin_level']) && $data['admin_level'] == 3)?'checked':'' ?> <?php echo empty($data['admin_level'])?'checked':'' ?> class="txt_cus_type" name="txt_cus_type" value="3">&nbsp;Single Location (Basic)</label>
									<div class="cls-edit-store" style="padding-left: 25px;<?php echo (!empty($data['admin_level']) && $data['admin_level'] == 3)?'':'display: none;' ?> <?php echo empty($data['admin_level'])?'display: block;':'' ?>">
										<button type="button" class="btn btn-sm green btn-edit-store" data-val="3">Edit Stores</button>
									</div>
								</div>
								<div class="col-md-12 in-group">
									<label class="radio-list"><input type="radio" <?php echo (!empty($data['admin_level']) && $data['admin_level'] == 1)?'checked':'' ?>  class="txt_cus_type" name="txt_cus_type" value="1">&nbsp;Multiple Location (Enterprise)</label>
									<div class="cls-edit-store" style="padding-left: 25px;<?php echo (!empty($data['admin_level']) && $data['admin_level'] == 1)?'':'display: none;' ?>">
										<button type="button" class="btn btn-sm green btn-edit-store" data-val="1">Edit Stores</button>
									</div>
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['admin_id'])?$data['admin_id']:''; ?>">
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
		Kiosk.initUniform('.txt_cus_type');

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
	            txt_cus_no: {
	                required: true
	            },
	            txt_cus_login_email: {
	                required: true
	            },
	            <?php if(empty($data['admin_id'])): ?>
	            txt_cus_login_pass: {
	                required: true
	            },
	            <?php endif ?>
	            txt_cus_first_name: {
	                required: true
	            },
	            txt_cus_last_name: {
	                required: true
	            },
	            txt_cus_address: {
	                required: true
	            },
	            txt_cus_city: {
	                required: true
	            },
	            txt_cus_state: {
	                required: true
	            },
	            txt_cus_zip: {
	                required: true
	            },
	            txt_cus_phone: {
	                required: true
	            },
	            txt_cus_email: {
	                required: true,
	                email: true
	            },
	            txt_cus_type: {
	                required: true
	            }
	        },

	        messages: {
	            txt_cus_no: {
	                required: "Customer No is required."
	            }
	        },

	        invalidHandler: function (event, validator) {
	            
	        },
	        highlight: function (element) {
		        $(element).closest('.in-group').addClass('has-error');
	        },
	        success: function (label, element) {
	            $(element).closest('.in-group').removeClass('has-error');
	        },
	        errorPlacement: function (error, element) {

	        },
	        submitHandler: function (form) {
				var _input       = $('input[name="txt_cus_no"]').val();
				var _txt_ecus_no = $('input[id="txt_ecus_no"]').val();
				var txt_hd_id    = $('input[name="txt_hd_id"]').val();
	        	checkCode(_input, form);
	        }
	    });
		
		$('.txt_cus_type').change(function(event) {
			$('.cls-edit-store').hide();
			$(this).parents('.in-group').find('.cls-edit-store').show();
		});

		$('.btn-edit-store').click(function(event) {
			var user = '<?php echo !empty($data['admin_id'])?$data['admin_id']:'' ?>';
			if(user == ''){
				$.bootstrapGrowl("You need to create user before create stores.", { 
		        	type: 'warning' 
		        });
			}else{
				var type = $(this).attr('data-val');
				adminCustomers.viewStore(user, type);
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
			var type  = $(form).find("#txt_type").val();
			var email = $('input[name="txt_cus_login_email"]').val();
	    	Kiosk.blockUI({
                target: '.page-quick-wap',
                boxed: true
            });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>admin_customers/checkCode',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {
	    			'txt_code': input_code,
	    			'code_old': '<?php echo !empty($data['admin_no'])?$data['admin_no']:''; ?>',
	    			'txt_email': email,
	    			'email_old': '<?php echo !empty($data['admin_email_login'])?$data['admin_email_login']:''; ?>',
	    		},
	    	})
	    	.done(function(data) {
	    		
	    		if(data['msg'] == 'true'){
	    			$('.customers-error').hide();
	    			$('.cls-email-exist').hide();
	    			form.submit();
	    		}else{
	    			Kiosk.unblockUI('.page-quick-wap');
	    			if(data['code'] == 'true'){
	    				$('.customers-error').parent('.in-group').addClass('has-error');
	    				$('.data-code').text(input_code);
	    				$('.customers-error').show();
	    			}
	    			if(data['email'] == 'true'){
	    				$('.data-email').text(email);
	    				$('.cls-email-exist').show();
	    			}
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
		var id_access = '<?php echo !empty($data['admin_no'])?$data['admin_no']:'' ?>';
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
	    		url: '<?php echo url::base() ?>admin_customers/nextCode/ajax',
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
	    		Kiosk.unblockUI('.page-quick-wap');
	    	})
	    	.fail(function() {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		console.log("error");
	    	});
		}
    }
</script>