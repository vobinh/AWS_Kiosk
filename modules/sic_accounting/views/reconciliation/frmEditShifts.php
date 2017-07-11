<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Edit Shifts'; ?>
				<p style="font-size: 14px;margin-bottom: 0px;">
					Ensure that time ranges do not overlap to avoid double-counting.
				</p>
			</div>

		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-editShifts" action="<?php echo url::base() ?>accounting/saveShifts" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<?php if(!empty($dataShifts)): $sl = 0?>
							<?php foreach ($dataShifts as $key => $value): $sl++; ?>
								<?php $arrTime = explode('|', $value) ?>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<div class="border add-catalog" style="height: 220px;">
										<h4>Shifts <?php echo $sl ?></h4>
										<div class="catalog-middle" style="top: 50px;">
											<div class="in-group">
												<label>Shift Title</label>
												<div class="input-icon input-icon-sm right">
													<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
													<input style="margin-bottom: 10px;" type="text" class="form-control input-sm timestamp" name="txt_item_name[]" value="<?php echo $key ?>" placeholder="Name">
												</div>
											</div>
											<div class="in-group">
												<label>Shift Time Window</label>
												<div style="float: left;" class="input-group in-group">
													<input value="<?php echo $arrTime[0] ?>" type="text" class="form-control input-sm timepicker-24" name="txt_time_from[]" placeholder="Start">
													<span class="input-group-addon" style="line-height: 1;"> to </span>
													<input value="<?php echo $arrTime[1] ?>" type="text" class="form-control input-sm timepicker-24" name="txt_time_to[]" placeholder="End">
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo $shiftId; ?>">
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
		frmValidate();
		$('.timepicker-24', $('#frm-editShifts')).timepicker({
			timeFormat: 'HH:mm',
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false
        });
        $('.timepicker-24', $('#frm-editShifts')).click(function(event) {
			$('.timepicker-24', $('#frm-editShifts')).timepicker('hideWidget');
			$(this).timepicker('showWidget');
		});
	});
	
	function frmValidate(){
		$('#frm-editShifts').validate({
	        errorElement: 'span',
	        errorClass: 'help-block',
	        focusInvalid: false,
	        rules: {
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
	        	var isValid = true;
	        	var isFocus = true;
	        	$("input[name='txt_item_name[]']", $('#frm-editShifts')).each(function() {
		            if($(this).val() == "" && $(this).val().length < 1) {
		                $(this).closest('.in-group').addClass('has-error');
		                isValid = false;
		                if(isFocus){
		                	$(this).focus();
		                	isFocus = false;
		                }
		            } else {
		                $(this).closest('.in-group').removeClass('has-error');
		            }
		        });
		        $("input[name='txt_time_from[]']", $('#frm-editShifts')).each(function() {
		            if($(this).val() == "" && $(this).val().length < 1) {
		                $(this).closest('.in-group').addClass('has-error');
		                isValid = false;
		                if(isFocus){
		                	$(this).focus();
		                	isFocus = false;
		                }
		            } else {
		                $(this).closest('.in-group').removeClass('has-error');
		            }
		        });
		        $("input[name='txt_time_to[]']", $('#frm-editShifts')).each(function() {
		            if($(this).val() == "" && $(this).val().length < 1) {
		                $(this).closest('.in-group').addClass('has-error');
		                isValid = false;
		                if(isFocus){
		                	$(this).focus();
		                	isFocus = false;
		                }
		            } else {
		                $(this).closest('.in-group').removeClass('has-error');
		            }
		        });

		        if(isValid){
		        	Kiosk.blockUI();
					form.submit();
		        } 
	        }
	    });
	}
</script>