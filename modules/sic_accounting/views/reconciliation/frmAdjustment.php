<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add Adjustment'; ?>
				<p style="font-size: 14px;">
					Enter a manual adjustment entry if the number does not add up as expected.
				</p>
			</div>

		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-adjustment" action="<?php echo url::base() ?>accounting/saveAdjustment" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Date</h4>
								<div class="catalog-middle in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" class="form-control input-sm timestamp" name="txt_item_date" value="<?php echo date('m/d/Y H:i:s') ?>" placeholder="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Reference#</h4>
								<div class="catalog-middle in-group" style="text-align: center;">
								<?php 
									$item_num = $this->udate('ymdHisu');
								?>
									<span class="control-label"><?php echo $item_num ?></span>
									<input style="display: none;" type="text" class="form-control input-sm" name="txt_item_num" value="<?php echo $item_num ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Note</h4>
								<div class="catalog-middle in-group" style="top: 40px;">
									<textarea class="form-control" rows="6" name="txt_item_note"></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Amount</h4>
								<div class="catalog-middle in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" style="text-align: right;" class="form-control input-sm decimal" name="txt_item_amount" value="" placeholder="">
									</div>
									<span class="control-label">
										Enter the adjustment amount (currency). Negative and positive values allowed.
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-actions right">
					<input type="hidden" name="txt_data_type" value="<?php echo !empty($dataType)?$dataType:'' ?>">
					<input type="hidden" name="txt_data_using" value="">
					<button style="min-width: 150px;" type="submit" class="btn green">Register Item</button>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var show = $('#slt_store_active').val();
		$('input[name="txt_data_using"]').val(show);

		$('.timestamp').datetimepicker({
		    format: 'mm/dd/yyyy hh:ii:ss'
		});
		$(".decimal").inputmask('decimal',{rightAlign: true});
		frmValidate();
	});
	function frmValidate(){
		$('#frm-adjustment').validate({
	        errorElement: 'span',
	        errorClass: 'help-block',
	        focusInvalid: false,
	        rules: {
	            txt_item_date: {
	                required: true
	            },
	            txt_item_amount: {
	                required: true
	            }
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
	        	var data = $(form).serialize();
	        	Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>accounting/saveAdjustment',
					type: 'post',
					data: data,
					dataType: 'json'
				})
				.done(function(data) {
					if(data['result']){
						notification('success', data['msg']);
						setTimeout(function() {
							Kiosk.blockUI();
							$('#frm-accounting').submit();
						}, 1000);
					}else{
						notification('danger', data['msg']);
					}
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					notification('danger', 'Could not complete request.');
				});
	        }
	    });
	}
</script>