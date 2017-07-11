<?php $role = $this->mPrivileges;  ?>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add Devices';?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-machine" action="<?php echo url::base() ?>settings/saveMachine" method="post" class="horizontal-form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align: right;" class="control-label col-lg-12">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group in-group">
								<label class="control-label">Name</label>
								<select name="txt_name" id="txt_name" class="form-control input-sm">
									<option <?php echo (!empty($data['m_name']) && $data['m_name'] == 'store-kds')?'selected':''; ?> value="store-kds">store-kds</option>
									<option <?php echo (!empty($data['m_name']) && $data['m_name'] == 'store-expedite')?'selected':''; ?> value="store-expedite">store-expedite</option>
									<option <?php echo (!empty($data['m_name']) && $data['m_name'] == 'store-server')?'selected':''; ?> value="store-server">store-server</option>
									<option <?php echo (!empty($data['m_name']) && $data['m_name'] == 'store-kiosk')?'selected':''; ?> value="store-kiosk">store-kiosk</option>
								</select>
								<!-- <input type="text" id="txt_name" name="txt_name" value="<?php //echo !empty($data['m_name'])?$data['m_name']:'' ?>" class="form-control input-sm" placeholder="Name"> -->
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group in-group">
								<label class="control-label">Serial No</label>
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input type="text" id="txt_serial" name="txt_serial" value="<?php echo !empty($data['m_serial_no'])?$data['m_serial_no']:'' ?>" class="form-control input-sm" placeholder="Serial No">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group in-group">
								<label class="control-label">IP Address</label>
								<input type="text" id="txt_ip" name="txt_ip" value="<?php echo !empty($data['m_ip'])?$data['m_ip']:'' ?>" class="form-control input-sm" placeholder="IP Address">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group in-group">
								<label class="control-label">PC Address</label>
								<input type="text" id="txt_mac" name="txt_mac" value="<?php echo !empty($data['pc_id'])?$data['pc_id']:'' ?>" class="form-control input-sm" placeholder="Mac Address">
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['machine_id'])?$data['machine_id']:'' ?>">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], -1) == '1')): ?>
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

<script type="text/javascript">
	frmGeneral.frmInvalidate();
	<?php if($role == 'NoAccess' || (is_array($role) && substr($role['settings_general'], -1) == '0')){ ?>
		$(document).ready(function() {
			$('#frm-machine').attr('action', 'javascript:void(0);');
		});
	<?php } ?>
</script>