<div class="col-md-12">
	<div class="portlet solid grey-cararra bordered">
		<div class="portlet-title">
			<div class="caption col-md-12">
				Time Zone Preferences
				<label>Determine application behavior when performing actions which require time / date input. Time and date are recorded using UTC, but user may display and input time and date data according to a preferred UTC offset.</label>
			</div>
		</div>
		<div class="portlet-body">
			<form id="frm-time-zone" action="<?php echo url::base() ?>settings/updateOptions/1" method="post" class="">
				<div class="form-group">
					<div class="radio-list">
						<label>
							<input type="radio" name="txt_timezone" id="optionsRadios1" <?php echo (!empty($this->sess_cus['time_zone']) && $this->sess_cus['time_zone'] == 'store')?'checked':''; ?> value="store"> Use the time zone associated with the store
						</label>
						<label>
							<input type="radio" name="txt_timezone" id="optionsRadios2" <?php echo (!empty($this->sess_cus['time_zone']) && $this->sess_cus['time_zone'] == 'client')?'checked':''; ?> value="client"> Use my local time zone regardless of the store’s set time zone
						</label>
						<label>
							<input type="radio" name="txt_timezone" id="optionsRadios3" <?php echo (!empty($this->sess_cus['time_zone']) && $this->sess_cus['time_zone'] == 'utc')?'checked':''; ?><?php echo empty($this->sess_cus['time_zone'])?'checked':''; ?> value="utc"> Use UTC 
						</label>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<button type="submit" class="btn green" style="min-width: 150px;">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>