<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], 0, 1) == '1')): ?>
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption col-md-6">
					Store Information
				</div>
				<div class="col-md-6 caption" style="font-size: 12px;color: red;text-align:right">
					<label style="font-size: 12px;color: red;text-align:right" class="control-label" style="">
						<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
					</label>
				</div>
			</div>
			<div class="portlet-body">
				<form id="frm-store" action="<?php echo url::base() ?>settings/updateStore" method="post" class="form-horizontal">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">Store Name</label>
							<div class="col-md-10 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off"  name="txt_store_name" type="text" class="form-control input-sm input-one" value="<?php echo !empty($data['store'])?$data['store']:''; ?>" placeholder="Store Name">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Contact</label>
							<div class="col-md-5 in-group">
								<input autocomplete="off" type="hidden" name="txt_store_no"  class="form-control input-sm intOnly" value="<?php echo !empty($data['s_no'])?$data['s_no']:''; ?>" placeholder="">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_first" class="form-control input-sm input-one" value="<?php echo !empty($data['s_first'])?$data['s_first']:''; ?>" placeholder="First">
								</div>
							</div>
							<div class="col-md-5 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_last" class="form-control input-sm" value="<?php echo !empty($data['s_last'])?$data['s_last']:''; ?>" placeholder="Last">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Phone #</label>
							<div class="col-md-10 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off"  name="txt_store_phone" type="text" class="form-control input-sm input-one intOnly" value="<?php echo !empty($data['s_phone'])?$data['s_phone']:''; ?>" placeholder="Phone Number">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Email</label>
							<div class="col-md-10 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_email" class="form-control input-sm" value="<?php echo !empty($data['s_email'])?$data['s_email']:''; ?>" placeholder="E-mail address">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Address</label>
							<div class="col-md-10 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_address" class="form-control input-sm" value="<?php echo !empty($data['s_address'])?$data['s_address']:''; ?>" placeholder="Street Address">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-10">
								<input autocomplete="off" type="text" name="txt_store_address2" class="form-control input-sm" value="<?php echo !empty($data['s_address_2'])?$data['s_address_2']:''; ?>" placeholder="Street Address 2">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-5 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_city" class="form-control input-sm input-one" value="<?php echo !empty($data['s_city'])?$data['s_city']:''; ?>" placeholder="City">
								</div>
							</div>
							<div class="col-md-5 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_state" class="form-control input-sm" value="<?php echo !empty($data['s_state'])?$data['s_state']:''; ?>" placeholder="* State / Province">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-5 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<input autocomplete="off" type="text" name="txt_store_zip" class="form-control input-sm input-one intOnly" value="<?php echo !empty($data['s_zip'])?$data['s_zip']:''; ?>" placeholder="* Postal / Zip Code">
								</div>
							</div>
							<div class="col-md-5 in-group">
								<select name="txt_store_country" class="form-control input-sm slt-select2">
									<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
									<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'UK')?'selected':''; ?> value="UK">UK</option>
									<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'France')?'selected':''; ?> value="France">France</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Sales tax</label>
							<div class="col-md-5 in-group">
								<div class="input-icon input-icon-sm right">
									<i class="fa fa-percent" aria-hidden="true" style="color: #000;font-size: 14px;margin-right: 25px;">%</i>
									<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
									<?php 
										$s_tax = !empty($data['s_tax'])?($data['s_tax']*100):'';
									 ?>
									<input autocomplete="off" style="padding-right: 55px;" type="text" name="txt_store_tax" value="<?php echo !empty($s_tax)?$s_tax:''; ?>" class="form-control input-sm input-one decimal" placeholder="">
								</div>
							</div>
							<div class="col-md-5 in-group">
								<select name="txt_store_tax_country" class="form-control input-sm slt-select2">
									<option <?php echo (!empty($data['s_tax_country']) && $data['s_tax_country'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
									<option <?php echo (!empty($data['s_tax_country']) && $data['s_tax_country'] == 'UK')?'selected':''; ?> value="UK">UK</option>
									<option <?php echo (!empty($data['s_tax_country']) && $data['s_tax_country'] == 'France')?'selected':''; ?> value="France">France</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Website</label>
							<div class="col-md-10">
								<input autocomplete="off"  name="txt_store_website" type="text" class="form-control input-sm input-one" value="<?php echo !empty($data['s_website'])?$data['s_website']:''; ?>" placeholder="Website">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Time zone</label>
							<div class="col-md-10">
								<?php include_once Kohana::find_file('views/include','inTimeZone'); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Note</label>
							<div class="col-md-10">
								<textarea class="form-control" name="txt_store_notes" rows="3" placeholder="Notes"><?php echo !empty($data['s_notes'])?$data['s_notes']:''; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Store Logo</label>
							<div class="col-md-10">
								<div class="thumbnail" style="width: 125px;position: relative;margin-bottom: 10px;">
									<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($data['s_logo'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
									<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($data['s_logo'])?$this->hostGetImg .'?files_id='.$data['s_logo']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
								</div>
								<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
								<input autocomplete="off" type="hidden" id="uploadfilehd" name="uploadfilehd" value="<?php echo !empty($data['s_logo'])?$data['s_logo']:'' ?>">
							</div>
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
				</form>
			</div>
		</div>
	</div>
<?php endif ?>