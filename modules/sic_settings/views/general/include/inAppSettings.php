<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Application Settings
				</div>
			</div>
			<div class="portlet-body">
				<form action="<?php echo url::base() ?>settings/updateOptions" method="post" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-4 control-label lb-left">Default Export Format</label>
							<div class="col-md-5 in-group">
								<select name="txt_export" class="form-control input-sm slt-select2">
									<option <?php echo (!empty($this->sess_cus['default_format']) && $this->sess_cus['default_format'] == 'CSV')?'selected':''; ?>  value="CSV">CSV</option>
									<option <?php echo (!empty($this->sess_cus['default_format']) && $this->sess_cus['default_format'] == 'XLS')?'selected':''; ?> value="XLS">XLS</option>
									<option <?php echo (!empty($this->sess_cus['default_format']) && $this->sess_cus['default_format'] == 'HTML')?'selected':''; ?> value="HTML">HTML</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label lb-left">Close idle session after</label>
							<div class="col-md-5 in-group">
								<select name="txt_session" class="form-control input-sm slt-select2">
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '48h')?'selected':''; ?> value="48h">48 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '24h')?'selected':''; ?> value="24h">24 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '12h')?'selected':''; ?> value="12h">12 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '6h')?'selected':''; ?> value="6h">6 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '2h')?'selected':''; ?> value="2h">2 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '1h')?'selected':''; ?> value="1h">1 hours</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '30i')?'selected':''; ?> value="30i">30 minutes</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '15i')?'selected':''; ?> value="15i">15 minutes</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == '5i')?'selected':''; ?> value="5i">5 minutes</option>
									<option <?php echo (!empty($this->sess_cus['close_session']) && $this->sess_cus['close_session'] == 'never')?'selected':''; ?> value="never">Never</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label lb-left">Language</label>
							<div class="col-md-5 in-group">
								<select name="txt_language" class="form-control input-sm slt-select2">
									<option <?php echo (!empty($this->sess_cus['language']) && $this->sess_cus['language'] == 'en_US')?'selected':''; ?> value="en_US">English</option>
									<!-- <option <?php echo (!empty($this->sess_cus['language']) && $this->sess_cus['language'] == 'ko_KR')?'selected':''; ?> value="ko_KR">Korean</option> -->
								</select>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12" style="text-align: right;">
									<button type="submit" class="btn green" style="min-width: 150px;">Save</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>