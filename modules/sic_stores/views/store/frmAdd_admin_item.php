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
								<input name="txt_add_first[]" type="text" class="form-control input-sm input-one" value="" placeholder="First Name">
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
								<input name="txt_add_email[]" type="text" class="form-control input-sm input-one"  placeholder="Login E-mail">
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