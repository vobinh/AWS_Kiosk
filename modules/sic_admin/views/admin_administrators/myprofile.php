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
			<form id="frm-myprofile" action="<?php echo url::base() ?>admin_administrators/save_myprofile" method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Name</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="text" name="txt_name" class="form-control input-sm input-one" value="<?php echo !empty($data['super_name'])?$data['super_name']:''; ?>" placeholder="Name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Email</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="text" readonly="readonly" name="txt_email" class="form-control input-sm input-one" value="<?php echo !empty($data['super_email'])?$data['super_email']:''; ?>" placeholder="Email">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12" style="text-align: left;">Password</label>
								<div class="control-label col-lg-10 col-md-10 col-sm-12">
									<div class="in-group">
										<input autocomplete="off" type="password" name="txt_pass" class="form-control input-sm input-one" placeholder="Password">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2 col-md-2 col-sm-12 control-label" style="text-align: left;">Logo</label>
								<div class="col-lg-10 col-md-10 col-sm-12">
									<div class="thumbnail" style="width: 125px;position: relative;margin-bottom: 10px;">
										<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($data['file_id'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
										<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($data['file_id'])?$this->hostGetImg .'?files_id='.$data['file_id']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
									</div>
									<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
									<input type="hidden" id="uploadfilehd" name="txt_icon" value="<?php echo !empty($data['file_id'])?$data['file_id']:'' ?>">
								</div>
							</div>
							<div class="form-actions">
								<input autocomplete="off" name="txt_super_id" type="hidden" value="<?php echo !empty($data['super_id'])?$data['super_id']:''; ?>">
								<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
							</div>
						</div>
					</div>
					<!--/row-->
				</div>
			</form>
		</div>
	</div>
</div>
