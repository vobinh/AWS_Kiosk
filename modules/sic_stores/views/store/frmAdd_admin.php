<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Manage User Credentials'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-add-admin" action="<?php echo url::base() ?>store/save_add_admin" method="post" class="form-horizontal">
				<div class="form-body wp-item-add-admin">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;" class="control-label col-lg-12" style="text-align: right;">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
					</div>
					<?php if(isset($data['txt_add_email']) && !empty($data['txt_add_email'])){ foreach ($data['txt_add_email'] as $key => $email) { ?>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="wap-item-add-category">
									<div class="item-add-category" style="padding-top: 5px;">
										<?php if(empty($data['txt_add_adminId'][$key]) && $data['txt_add_adminId'][$key] == ''){ ?>
											<p style="padding-left: 15px;padding-bottom: 0px;margin-bottom: 0;font-weight: bold;color: #000;">Add User</p>
										<?php }else{ ?>
											<p style="padding-left: 15px;padding-bottom: 0px;margin-bottom: 0;font-weight: bold;color: #000;">Edit User</p>
										<?php } ?>
										<input name="txt_add_adminId[]" type="hidden" class="form-control input-sm" value="<?php echo !empty($data['txt_add_adminId'][$key])?$data['txt_add_adminId'][$key]:''; ?>">
										<input name="txt_add_priveileges[]" type="hidden" class="form-control input-sm" value="<?php echo !empty($data['txt_privileges'][$key])?htmlspecialchars($data['txt_privileges'][$key]):''; ?>">
										<div class="col-lg-6 in-group">
											<div class="form-group">
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_first[]" type="text" class="form-control input-sm input-one" value="<?php echo !empty($data['txt_add_first'][$key])?$data['txt_add_first'][$key]:''; ?>" placeholder="First Name">
													</div>
												</div>
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_last[]" type="text" class="form-control input-sm" value="<?php echo !empty($data['txt_add_last'][$key])?$data['txt_add_last'][$key]:''; ?>" placeholder="Last Name">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_email[]" type="text" class="form-control input-sm input-one" value="<?php echo $email; ?>" placeholder="Login E-mail">
													</div>
												</div>
												<div class="col-md-6 in-group">
													<?php if(empty($data['txt_add_adminId'][$key]) && $data['txt_add_adminId'][$key] == ''){ ?>
														<div class="input-icon input-icon-sm right">
															<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
															<input name="txt_add_password[]" type="password" class="form-control input-sm pass_addAdmin" value="<?php echo !empty($data['txt_add_password'][$key])?$data['txt_add_password'][$key]:''; ?>"  placeholder="Password">
														</div>
													<?php }else{ ?>
														<input name="txt_add_password[]" type="password" class="form-control input-sm" placeholder="Password (Input text to change password)">
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-lg-5 in-group">
											<div class="form-group">
												<div style="min-height: 28px;" class="col-lg-8 in-group allow_user">
													<input type="hidden" name="allow_user[]" value="<?php echo (isset($data['allow_user'][$key]) && $data['allow_user'][$key] == 1)?$data['allow_user'][$key]:0; ?>">
													<input class="chk_allow_user" type="checkbox" <?php if(isset($data['allow_user']) && $data['allow_user'][$key] == 1){ ?> checked="checked" <?php } ?> name="allow_user_admin[]">
													<span> User must change password at login</span>
												</div>

												<div class="col-lg-4 in-group freeze_user">
													<input type="hidden" name="freeze_user[]" value="<?php echo (isset($data['freeze_user'][$key]) && $data['freeze_user'][$key] == 3)?$data['freeze_user'][$key]:0; ?>">
													<input type="checkbox" class="chk_freeze_user" <?php if(isset($data['freeze_user']) && $data['freeze_user'][$key] == 3){ ?> checked="checked" <?php } ?> name="freeze_user_admin[]">
													<span> Freeze User</span>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 in-group">
													<button type="button" class="btn green btn-sm btn-privileges">User Privileges</button>
												</div>
											</div>
										</div>
										<div class="col-lg-1" style="text-align: right;">
											<a href="javascript:;"class="btn btn-sm red btn-delete-admin">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
								</div>
							</div>	
						</div>
					<?php  }}else{ ?>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="wap-item-add-category">
									<div class="item-add-category" style="padding-top: 5px;">
										<p style="padding-left: 15px;padding-bottom: 0px;margin-bottom: 0;font-weight: bold;color: #000;">Add User</p>
										<input name="txt_add_adminId[]" type="hidden" class="form-control input-sm input-one">
										<input name="txt_add_priveileges[]" type="hidden" class="form-control input-sm">
										<div class="col-lg-6 in-group">
											<div class="form-group">
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_first[]" type="text" class="form-control input-sm" value="" placeholder="First Name">
													</div>
												</div>
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_last[]" type="text" class="form-control input-sm" value="" placeholder="Last Name">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_email[]" type="text" class="form-control input-sm"  placeholder="Login E-mail">
													</div>
												</div>
												<div class="col-md-6 in-group">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input name="txt_add_password[]" type="password" class="form-control input-sm pass_addAdmin" placeholder="Password">
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-lg-5 in-group">
											<div class="form-group">
												<div style="min-height: 28px;" class="col-lg-8 in-group allow_user">
													<input type="hidden" name="allow_user[]" value="1">
													<input class="chk_allow_user" type="checkbox" checked="checked"  name="allow_user_admin[]">
													<span> User must change password at login</span>
												</div>
												<div class="col-lg-4 in-group freeze_user">
													<input type="hidden" name="freeze_user[]" value="0">
													<input type="checkbox" class="chk_freeze_user" name="freeze_user_admin[]">
													<span> Freeze User</span>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 in-group">
													<button type="button" class="btn green btn-sm btn-privileges">User Privileges</button>
												</div>
											</div>
										</div>
										<div class="col-lg-1" style="text-align: right;">
											<a href="javascript:;"class="btn btn-sm red btn-delete-admin">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
								</div>
							</div>	
						</div>
					<?php } ?>
				</div>
				<div style="padding-bottom: 5px;">
					<button type="button" class="btn green btn-add" onclick="addItem_admin()"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_id_store" value="<?php echo !empty($data['txt_id_store'])?$data['txt_id_store']:'' ?>">
					<input type="hidden" name="txt_admin_id" value="<?php echo !empty($data['txt_admin_id'])?$data['txt_admin_id']:'' ?>">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default close-add-admin close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var frm = $('#frm-add-admin');
		_init_Login_Credentials.init(frm);
	});
</script>