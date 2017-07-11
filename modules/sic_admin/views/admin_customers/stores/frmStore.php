<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Store'; ?>
				<p style="margin-top: 10px;margin-bottom: 0px;font-size: 14px;">
					<?php echo !empty($subtitle)?$subtitle:'Add a new sister store or branch location. This will issue a set of login credentials exclusive to employees of the store.'; ?>
				</p>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-store" action="<?php echo url::base() ?>admin_customers/saveStore" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" style="margin-bottom: 7px;">
								<label class="control-label col-lg-4 col-md-5" style="text-align: left;">Unique Store No.</label>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_no"  class="form-control input-sm intOnly" value="<?php echo !empty($data['s_no'])?$data['s_no']:''; ?>" placeholder="Store No.">
									</div>
									<div class="customers-error">
										<span style='' class="cus-help-block">Store number must be unique. <span class="data-code">123</span> already exists. </span>
										<button type="button" class="btn btn-sm green" onclick="nextCode()">Fix Invalid Values</button>
									</div>
								</div>
							</div>
							<div class="form-group" style="margin-bottom: 7px;">
								<label class="control-label col-lg-4 col-md-5" style="text-align: left;">Store Name</label>
								<div class="col-lg-8 col-md-7 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_name"  class="form-control input-sm" value="<?php echo !empty($data['store'])?$data['store']:''; ?>" placeholder="Store Name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4 col-md-5 col-sm-12" style="text-align: left;">Contact</label>
								<div class="control-label col-lg-8 col-md-7 col-sm-12">
									<div style="float:left;width:39%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_store_first" class="form-control input-sm input-one" value="<?php echo !empty($data['s_first'])?$data['s_first']:''; ?>" placeholder="First">
										</div>
									</div>
									<div style="float:right;width:60%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_store_last" class="form-control input-sm" value="<?php echo !empty($data['s_last'])?$data['s_last']:''; ?>" placeholder="Last">
										</div>
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_address" class="form-control input-sm" value="<?php echo !empty($data['s_address'])?$data['s_address']:''; ?>" placeholder="Street Address">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_address2" class="form-control input-sm" value="<?php echo !empty($data['s_address_2'])?$data['s_address_2']:''; ?>" placeholder="Street Address 2">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_city" class="form-control input-sm input-one" value="<?php echo !empty($data['s_city'])?$data['s_city']:''; ?>" placeholder="City">
									</div>
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_state" class="form-control input-sm" value="<?php echo !empty($data['s_state'])?$data['s_state']:''; ?>" placeholder="State / Province">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_zip" class="form-control input-sm input-one intOnly" value="<?php echo !empty($data['s_zip'])?$data['s_zip']:''; ?>" placeholder="Postal / Zip Code">
									</div>
								</div>
								<div class="col-md-6">
									<select name="txt_store_country" class="form-control input-sm">
										<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'USA')?'selected':''; ?>  value="USA">USA</option>
										<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'UK')?'selected':''; ?> value="UK">UK</option>
										<option <?php echo (!empty($data['s_country']) && $data['s_country'] == 'France')?'selected':''; ?> value="France">France</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<div style="width:100%;" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off"  name="txt_store_phone" type="text" class="form-control input-sm input-one intOnly" value="<?php echo !empty($data['s_phone'])?$data['s_phone']:''; ?>" placeholder="Phone Number">
										</div>
									</div>
								</div>
								<div class="col-md-6 in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input autocomplete="off" type="text" name="txt_store_email" class="form-control input-sm" value="<?php echo !empty($data['s_email'])?$data['s_email']:''; ?>" placeholder="E-mail address">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<div style="width:100%;" class="in-group">
										<input autocomplete="off"  name="txt_store_website" type="text" class="form-control input-sm input-one" value="<?php echo !empty($data['s_website'])?$data['s_website']:''; ?>" placeholder="Website">
									</div>
								</div>
								<div class="col-md-6 in-group">
									<?php include_once Kohana::find_file('views/include','inTimeZone'); ?>
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-12 in-group">
									<label class="control-label">SP Key</label>
									<input type="text" name="txt_store_s_pk" class="form-control input-sm input-one" value="<?php echo !empty($data['s_pk'])?$data['s_pk']:''; ?>" placeholder="Key">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4 in-group">
									<label class="control-label">Serial Number</label>
									<input type="text" name="txt_store_e_serial_number" class="form-control input-sm cls-check input-one" value="<?php echo !empty($data['e_serial_number'])?$data['e_serial_number']:''; ?>" placeholder="Serial Number">
								</div>
								<div class="col-md-4 in-group">
									<label class="control-label">User Name</label>
									<input type="text" name="txt_store_e_user_name" class="form-control input-sm cls-check input-one" value="<?php echo !empty($data['e_user_name'])?$data['e_user_name']:''; ?>" placeholder="User Name">
								</div>
								<div class="col-md-4 in-group">
									<label class="control-label">Password</label>
									<input type="password" name="txt_store_e_password" class="form-control input-sm cls-check" value="<?php echo !empty($data['e_password'])?$data['e_password']:''; ?>" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<textarea class="form-control" name="txt_store_notes" rows="3" placeholder="Notes"><?php echo !empty($data['s_notes'])?$data['s_notes']:''; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12" style="line-height: 25px;">
									<div>Store Manager Login Credentials</div>
									<div>Store managers can log in using their own set of login credentials (e-mail / password).</div>
									<div><span class="number_admin" style="font-weight: bold;"><?php echo isset($total_admin)?$total_admin:0; ?></span> registered store manager credentials</div>
									<div style="margin-top: 10px;">
										<button style="min-width: 150px;" type="button" class="btn green" onclick="frmAdd_admin()">Edit Login Credentials</button>
									</div>
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div style="display:none" id="wp-admin-containt">
					<?php if(isset($Admin) && !empty($Admin)){foreach ($Admin as $key => $value) { ?>
						<div style="margin-top: 40px;background-color: red;color: #fff;padding: 10px;">
							admin ID
							<input autocomplete="off" name="txt_add_adminId[]" type="text" class="form-control input-sm input-one" value="<?php echo $value['admin_id']; ?>" >
							<br>
							admin first name
							<input name="txt_add_first[]" type="text" class="form-control input-sm input-one" value="<?php echo $value['admin_first_name']; ?>" >
							<br>
							admin last name
							<input name="txt_add_last[]" type="text" class="form-control input-sm input-one" value="<?php echo $value['admin_name']; ?>" >
							<br>
							admin email
							<input autocomplete="off" name="txt_add_email[]" type="text" class="form-control input-sm input-one" value="<?php echo $value['admin_email']; ?>" >
							<br>
							admin pass
							<input autocomplete="off" name="txt_add_password[]" type="text" class="form-control input-sm input-one">
							<br>
							admin change pass
							<br>
							<input autocomplete="off" type="text" name="allow_user[]" value="<?php echo $value['admin_change_pass']; ?>">
							<br>
							admin freeze
							<br>
							<input autocomplete="off" type="text" name="freeze_user[]" value="<?php echo $value['admin_status']; ?>">
							privileges
							<br>
							<input autocomplete="off" type="text" name="txt_privileges[]" value="<?php echo htmlspecialchars($value['privileges']); ?>">
						</div>
					<?php }} ?>	
				</div>
				<input autocomplete="off" type="hidden" name="txt_id_store" value="<?php if(isset($data['store_id']) && !empty($data['store_id'])) echo $data['store_id']; ?>">
				<input autocomplete="off" type="hidden" id="txt_no_store" value="<?php if(isset($data['s_no']) && !empty($data['s_no'])) echo $data['s_no']; ?>">
				<input autocomplete="off" type="hidden" name="txt_admin_id" value="<?php echo $admin_id ?>" placeholder="">
				<div class="form-actions right">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript">
	_init_Add_Store();
</script>