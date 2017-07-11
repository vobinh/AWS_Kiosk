<style>
	#frm-myprofile{
		overflow: hidden;
	}
	#frm-myprofile .form-actions{
		float: right
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					My Profile
				</div>
			</div>
			<form id="frm-myprofile" action="<?php echo url::base() ?>myprofile/save" method="post" enctype="multipart/form-data" class="form-horizontal">
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
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Name</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div style="float:left;width:49%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_first" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_first_name'])?$mdata['admin_first_name']:''; ?>" placeholder="First">
										</div>	
									</div>
									<div style="float:right;width:50%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_last" class="form-control input-sm" value="<?php echo !empty($mdata['admin_name'])?$mdata['admin_name']:''; ?>" placeholder="Last">
										</div>	
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Address</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_address" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_address'])?$mdata['admin_address']:''; ?>" placeholder="Address">
										</div>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Address 2</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="text" name="txt_address_2" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_address_2'])?$mdata['admin_address_2']:''; ?>" placeholder="Address 2">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;"></label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div style="float:left;width:49%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_city" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_city'])?$mdata['admin_city']:''; ?>" placeholder="City">
										</div>	
									</div>
									<div style="float:right;width:50%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_state" class="form-control input-sm" value="<?php echo !empty($mdata['admin_state'])?$mdata['admin_state']:''; ?>" placeholder="State">
										</div>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;"></label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div style="float:left;width:49%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_zip" class="form-control input-sm input-one intOnly" value="<?php echo !empty($mdata['admin_zip'])?$mdata['admin_zip']:''; ?>" placeholder="Zip">
										</div>	
										
									</div>
									<div style="float:right;width:50%" class="in-group">
										<select name="txt_country" class="form-control input-sm valid" aria-invalid="false">
											<option <?php if(!empty($mdata['admin_country']) && $mdata['admin_country'] == 'USA'){ echo 'selected="selected"'; } ?> value="USA">USA</option>
											<option <?php if(!empty($mdata['admin_country']) && $mdata['admin_country'] == 'UK'){ echo 'selected="selected"'; } ?> value="UK">UK</option>
											<option <?php if(!empty($mdata['admin_country']) && $mdata['admin_country'] == 'France'){ echo 'selected="selected"'; } ?> value="France">France</option>
										</select>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;"></label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div style="float:left;width:49%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_phone" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_phone'])?$mdata['admin_phone']:''; ?>" placeholder="Phone">
										</div>
									</div>
									<div style="float:right;width:50%" class="in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input autocomplete="off" type="text" name="txt_email" class="form-control input-sm" value="<?php echo !empty($mdata['admin_email'])?$mdata['admin_email']:''; ?>" placeholder="Email">
										</div>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12 control-label">Logo</label>
								<div class="col-lg-10 col-md-10 col-sm-12">
									<div class="thumbnail" style="width: 125px;position: relative;margin-bottom: 10px;">
										<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($mdata['file_id'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
										<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($mdata['file_id'])?$this->hostGetImg .'?files_id='.$mdata['file_id']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
									</div>
									<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
									<input type="hidden" id="uploadfilehd" name="txt_icon" value="<?php echo !empty($mdata['file_id'])?$mdata['file_id']:'' ?>">
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Email Login</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="text" readonly="readonly" name="txt_email_login" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_email_login'])?$mdata['admin_email_login']:''; ?>" placeholder="Email Login">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Password</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="password" name="txt_password" class="form-control input-sm input-one" placeholder="Password">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Website</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="text" name="txt_website" class="form-control input-sm input-one" value="<?php echo !empty($mdata['admin_website'])?$mdata['admin_website']:''; ?>" placeholder="Website">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Notes</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<textarea name="txt_notes" id="" style="height: 7em;" cols="30" rows="10" class="form-control input-sm input-one"><?php echo !empty($mdata['admin_notes'])?$mdata['admin_notes']:''; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Store</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group" style="text-align:left">
										<?php if(!empty($mstore)){ foreach ($mstore as $key => $value) { ?>
											<p>- <?php echo $value['store']; ?></p>
										<?php }} ?>
									</div>
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<div class="form-actions">
					<input autocomplete="off" name="txt_admin_id" type="hidden" value="<?php echo !empty($mdata['admin_id'])?$mdata['admin_id']:''; ?>">
					<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
