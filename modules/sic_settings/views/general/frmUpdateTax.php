<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				Update Store
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-update-tax" action="<?php echo url::base() ?>settings/updateTaxStore" method="post" class="horizontal-form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group in-group">
								<label class="control-label">Sales tax</label>
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-percent" style="color: #000;font-size: 14px;">%</i>
									<input type="text" name="txt_store_tax" value="" class="form-control input-sm decimal" placeholder="" style="text-align: right;">
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="form-actions right">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".decimal").inputmask('decimal',{rightAlign: true});
		$('#frm-update-tax').validate({
	        errorElement: 'span',
	        errorClass: 'help-block',
	        focusInvalid: false,
	        rules: {
	            txt_store_tax: {
	                required: true
	            }
	        },
	        messages: {
	            txt_store_tax: {
	                required: "Sales tax is required."
	            }
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
	        	Kiosk.blockUI();
				form.submit();
	        }
	    });
	});
</script>