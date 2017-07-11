<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				Contact Support
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form class="frm-support" action="<?php echo url::base() ?>login/sm_Support" method="post" >
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group in-group">
								<label class="control-label">From</label>
								<input type="text" name="email" value="" class="form-control input-sm" placeholder="Email Address">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group in-group">
								<label class="control-label">Title</label>
								<label class="control-label">[Support] Kiosk.com</label>
								<input type="hidden"  name="txt_serial" value="[Support] TermiteKiosk.com" class="form-control input-sm" placeholder="Title">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group txtContent in-group">
								<textarea name="txtContent" id="txtContent" class="required" rows="8" cols="80"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions right">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<script type="text/javascript">
	CKEDITOR.replace( 'txtContent' );
	Frm_Support.init();
</script>