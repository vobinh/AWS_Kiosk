<?php $role = $this->mPrivileges; ?>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Manage Shifts'; ?>
				<span style="display: block;font-size: 16px;padding-top: 5px;">
					<?php echo !empty($dataEmpl['first_name'])?$dataEmpl['first_name']:'' ?>&nbsp;<?php echo !empty($dataEmpl['name'])?$dataEmpl['name']:'' ?>&nbsp;-&nbsp;<?php echo !empty($dataTime)?date('l, F d, Y',strtotime($dataTime)):'' ?>
				</span>
			</div>
		</div>
		<div class="portlet-body form wap-scheduling-timecard">
			<!-- BEGIN FORM-->
			<form id="frm-scheduling-timecard" action="<?php echo url::base() ?>employees/saveTimeCard" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;" class="control-label col-lg-12" style="text-align: right;">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="wap-item-add-category">
							<?php if(!empty($TimeCard)): ?>
								<?php foreach ($TimeCard as $key => $value): ?>
									<div class="item-add-category">
										<div class="col-xs-9 col-md-1 in-group">
											<span class="control-label cls-shift" style="font-weight: bold">Shift <?php echo ($key + 1) ?></span>
										</div>
										<div class="col-xs-9 col-md-2 in-group">
											<div class="input-icon input-icon-sm right">
												<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
												<input type="text" name="txt_date_start[]" value="<?php echo !empty($value['start_time'])?date('H:i', strtotime($value['start_time'])):'' ?>" class="form-control input-sm input-one timepicker timepicker-24" placeholder="Start Time">
											</div>
										</div>
										<div class="col-xs-9 col-md-2 in-group">
											<div class="input-icon input-icon-sm right">
												<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
												<input type="text" name="txt_date_end[]" value="<?php echo !empty($value['end_time'])?date('H:i', strtotime($value['end_time'])):'' ?>" class="form-control input-sm timepicker timepicker-24" placeholder="End Time">
											</div>
											<textarea style="display:none" name="txt_hd_id[]" cols="30" rows="10"><?php echo !empty($value['start_time'])?$value['start_time']:'' ?></textarea>	
										</div>
										<div style="display:none" class="col-xs-9 col-md-2 in-group">
											<select style="display:none" name="txt_mechine_id[]" class="form-control input-sm">
												<?php if(!empty($machine)): ?>
													<?php foreach ($machine as $key => $value_mechine):?>
														<option <?php if(!empty($value['machine_id']) && $value['machine_id'] == $value_mechine['machine_id']){ echo 'selected="selected"'; } ?> value="<?php echo $value_mechine['machine_id']; ?>"><?php echo $value_mechine['m_name']; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											</select>
										</div>
										<div class="col-xs-3 col-md-7" style="text-align: right;">
										<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
											<a href="javascript:;"class="btn btn-sm red btn-delete">
												<i class="fa fa-times"></i>
											</a>
										<?php endif ?>
										</div>
									</div>
								<?php endforeach ?>
							<?php else: ?>
								<div class="item-add-category">
									<div class="col-xs-9 col-md-1 in-group">
										<span class="control-label cls-shift" style="font-weight: bold">Shift 1</span>
									</div>
									<div class="col-xs-9 col-md-2 in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input type="text" name="txt_date_start[]" value="08:00" class="form-control input-sm input-one timepicker timepicker-24" placeholder="Start Time">
										</div>
									</div>
									<div class="col-xs-9 col-md-2 in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input type="text" name="txt_date_end[]" value="11:00" class="form-control input-sm timepicker timepicker-24" placeholder="End Time">
										</div>
										<textarea style="display:none" name="txt_hd_id[]" cols="30" rows="10"></textarea>	
									</div>
									<div class="col-xs-9 col-md-2 in-group">
										<select name="txt_mechine_id[]" class="form-control input-sm">
											<?php if(!empty($machine)): ?>
												<?php foreach ($machine as $key => $value):?>
													<option value="<?php echo $value['machine_id']; ?>"><?php echo $value['m_name']; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="col-xs-3 col-md-5" style="text-align: right;">
									<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
										<a href="javascript:;"class="btn btn-sm red btn-delete">
											<i class="fa fa-times"></i>
										</a>
									<?php endif ?>
									</div>
								</div>
							<?php endif ?>
							</div>
						</div>
					</div>
				</div>
				<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
					<div style="padding-bottom: 5px;">
						<button type="button" class="btn green btn-add"><i class="fa fa-plus"></i> Add Row</button>
					</div>
				<?php endif ?>
				<div class="form-actions right">
					<div class="cls-input-del" style="display: none;">
						
					</div>
					<input type="hidden" name="txt_hd_sl" value="1">
					<input type="hidden" name="txt_hd_empl" value="<?php echo !empty($dataEmpl['access_id'])?$dataEmpl['access_id']:''; ?>">
					<input type="hidden" name="txt_hd_day" value="<?php echo !empty($dataTime)?$dataTime:''; ?>">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
						<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<?php else: ?>
						<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
					<?php endif ?>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<div class="item-add-category scheduling-item-template" style="display: none;">
	<div class="col-xs-9 col-md-1 in-group">
		<span class="control-label cls-shift" style="font-weight: bold">Shift *</span>
	</div>
	<div class="col-xs-9 col-md-2 in-group">
		<div class="input-icon input-icon-sm right">
			<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
			<input type="text" name="txt_date_start[]" value="" class="form-control input-sm input-one" placeholder="Start Time">
		</div>
	</div>
	<div class="col-xs-9 col-md-2 in-group">
		<div class="input-icon input-icon-sm right">
			<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
			<input type="text" name="txt_date_end[]" value="" class="form-control input-sm" placeholder="End Time">
		</div>
		<textarea style="display:none" name="txt_hd_id[]" cols="30" rows="10"></textarea>	
	</div>
	<div class="col-xs-9 col-md-2 in-group">
		<select name="txt_mechine_id[]" class="form-control input-sm">
			<?php if(!empty($machine)): ?>
				<?php foreach ($machine as $key => $value):?>
					<option value="<?php echo $value['machine_id']; ?>"><?php echo $value['m_name']; ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
	</div>
	<div class="col-xs-3 col-md-5" style="text-align: right;">
		<a href="javascript:;"class="btn btn-sm red btn-delete">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		frmTimeCard.init();
		<?php if($role == 'NoAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '0')){ ?>
			$('#frm-scheduling-timecard').attr('action', 'javascript:void(0);');
		<?php } ?>
	});
</script>