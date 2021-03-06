<?php $role = $this->mPrivileges; ?>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add Pickup Station'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-category" action="<?php echo url::base() ?>catalogs/saveStage" method="post" class="form-horizontal">
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
								<div class="item-add-category">
									<div class="col-xs-9 col-md-3 in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input type="text" name="txt_name[]" value="<?php echo !empty($data['name'])?$data['name']:''; ?>" class="form-control input-sm input-one" placeholder="Pick Up Stations">
											<input type="hidden" name="txt_category[]" value="<?php echo !empty($idStore)?$idStore:'' ?>">
										</div>
									</div>
									<?php /* ?>
									<div class="col-xs-9 col-md-3 in-group">
										<select name="txt_category[]" class="form-control input-sm">
											<?php if(!empty($listStore)): ?>
												<?php foreach ($listStore as $key => $item): ?>
													<option <?php echo (!empty($data['store_id']) && $data['store_id'] == $item['store_id'])?'selected':'' ?> <?php echo (!empty($data['store_id']) && $data['store_id'] != $item['store_id'])?'disabled':'' ?> value="<?php echo !empty($item['store_id'])?$item['store_id']:'' ?>"><?php echo !empty($item['store'])?$item['store']:'' ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
									<?php */ ?>
									<div class="col-xs-9 col-md-3 in-group frm-img">
										<div class="thumbnail" style="width: 125px;position: relative;margin-bottom: 10px;">
											<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($data['file_id'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
											<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($data['file_id'])?$this->hostGetImg .'?files_id='.$data['file_id']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
										</div>
										<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
										<input type="hidden" id="uploadfilehd" name="uploadfilehd" value="<?php echo !empty($data['file_id'])?$data['file_id']:'' ?>">
									</div>
									<div class="col-xs-3 col-md-3" style="text-align: right;">
										<?php if(empty($data['id']) && !empty($data['id'])): ?>
											<a href="javascript:;"class="btn btn-sm red btn-delete">
												<i class="fa fa-times"></i>
											</a>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if(empty($data['id']) && !empty($data['id'])): ?>
				<div style="padding-bottom: 5px;">
					<button type="button" class="btn green btn-add"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<?php endif ?>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['id'])?$data['id']:''; ?>">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_stage'], -1) == '1')): ?>
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
<div class="item-add-category category-item-template" style="display: none;">
	<div class="col-xs-9 col-md-5 in-group">
		<div class="input-icon input-icon-sm right">
			<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
			<input type="text" name="txt_name[]" value="" class="form-control input-sm input-one" placeholder="Stage Name">
			<input type="hidden" name="txt_category[]" value="<?php echo !empty($idStore)?$idStore:'' ?>">
		</div>
	</div>
	<?php /* ?>
	<div class="col-xs-9 col-md-3 in-group">
		<select name="txt_category[]" class="form-control input-sm">
			<?php if(!empty($listStore)): ?>
				<?php foreach ($listStore as $key => $item): ?>
					<option <?php echo (!empty($data['category_id']) && $data['category_id'] == $item['category_id'])?'selected':'' ?> <?php echo (!empty($data['category_id']) && $data['category_id'] != $item['category_id'])?'disabled':'' ?> value="<?php echo !empty($item['store_id'])?$item['store_id']:'' ?>"><?php echo !empty($item['s_first'])?$item['s_first']:'' ?><?php echo !empty($item['s_last'])?' '.$item['s_last']:'' ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
	<?php */ ?>
	<div class="col-xs-3 col-md-4" style="text-align: right;">
		<a href="javascript:;"class="btn btn-sm red btn-delete">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		frmStage.init();
		<?php if($role == 'NoAccess' || (is_array($role) && substr($role['settings_stage'], -1) == '0')){ ?>
			$('#frm-category').attr('action', 'javascript:void(0);');
		<?php } ?>
	});
</script>