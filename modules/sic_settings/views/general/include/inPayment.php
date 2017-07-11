<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Payment Processing Settings - Mobile Payments (ClearNet)
				</div>
			</div>
			<div class="portlet-body">
				<form id="frm-store-1" action="<?php echo url::base() ?>settings/updateStore/1" method="post" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-8 control-label lb-left" style="padding-top: 0px;line-height: 14px;">
								ClearNet Private Key (SP Key):
								<span style="display: inline-block;font-size: 12px;">Key issued by ClearNet to merchants for mobile payment processing</span>
							</label>
							<div class="col-md-4 in-group">
								<input autocomplete="off" type="text" name="txt_store_s_pk" class="form-control input-sm" value="<?php echo !empty($data['s_pk'])?$data['s_pk']:''; ?>" placeholder="Key">
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12" style="text-align: right;">
									<input type="hidden" name="txt_id_store" value="<?php if(isset($data['store_id']) && !empty($data['store_id'])) echo $data['store_id']; ?>">
									<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], -1) == '1')): ?>
										<button type="submit" <?php if(empty($data['store_id'])): ?> disabled <?php endif ?> class="btn green" style="min-width: 150px;">Save</button>
									<?php else: ?>
										<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Payment Processing Settings - Kiosk Payments (USATech)
				</div>
			</div>
			<div class="portlet-body">
				<form id="frm-store-2" action="<?php echo url::base() ?>settings/updateStore/2" method="post" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-8 control-label lb-left" style="padding-top: 0px;line-height: 14px;">
								USATech Serial Number:
								<span style="display: inline-block;font-size: 12px;">
									Serial number issued by USATech for credit card payment processing on Kiosk platform
								</span>
							</label>
							<div class="col-md-4 in-group">
								<input autocomplete="off" type="text" name="txt_store_e_serial_number" class="form-control input-sm cls-check" value="<?php echo !empty($data['e_serial_number'])?$data['e_serial_number']:''; ?>" placeholder="Serial Number">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label lb-left" style="padding-top: 0px;line-height: 14px;">
								USATech Merchant API User ID:
								<span style="display: inline-block;font-size: 12px;">
									User ID issued by USATech for credit card payment processing on Kiosk platform
								</span>
							</label>
							<div class="col-md-4 in-group">
								<input autocomplete="off" type="text" name="txt_store_e_user_name" class="form-control input-sm cls-check" value="<?php echo !empty($data['e_user_name'])?$data['e_user_name']:''; ?>" placeholder="User Name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-8 control-label lb-left" style="padding-top: 0px;line-height: 14px;">
								USATech Merchant API Password:
								<span style="display: inline-block;font-size: 12px;">
									Password issued by USATech for credit card payment processing on Kiosk platform
								</span>
							</label>
							<div class="col-md-4 in-group">
								<input autocomplete="off" type="password" name="txt_store_e_password" class="form-control input-sm cls-check" value="<?php echo !empty($data['e_password'])?$data['e_password']:''; ?>" placeholder="Password">
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12" style="text-align: right;">
									<input type="hidden" name="txt_id_store" value="<?php if(isset($data['store_id']) && !empty($data['store_id'])) echo $data['store_id']; ?>">
									<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], -1) == '1')): ?>
										<button type="submit" <?php if(empty($data['store_id'])): ?> disabled <?php endif ?> class="btn green" style="min-width: 150px;">Save</button>
									<?php else: ?>
										<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>