<?php 
	$storeUsing = $this->_getStoreUsing(); 
	$_storeId   = base64_decode($this->sess_cus['storeId']);
	$role       = $this->mPrivileges;
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings'" >General Settings</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/privileges'">User Privileges</button>
		<button type="button" class="btn btn-primary btn-lg"disabled >Receipt Design</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/importdatabase'">Database Import</button>
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_receipt'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered" style="padding-bottom: 5px">
			<div class="portlet-title" style="margin-bottom: 0;">
				<div class="caption">
					Receipt Design Management
				</div>
				<?php if((string)$_storeId == '0'): ?>
					<div class="actions">
						<div class="caption">
							<span>Store</span>
							<div class="btn-group">
								<?php 
									include_once Kohana::find_file('views/include','inSelectStore');
								?>
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Header
						</div>
						<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_receipt'], -1) == '1')): ?>
							<div class="actions">
								<div class="caption">
									<div class="btn-group">
										<button style="min-width: 110px" type="button" class="btn btn-sm green btnGetHeader">
											Get Template
										</button>
									</div>
								</div>
							</div>
						<?php endif ?>
					</div>
					<div class="portlet-body">
						<textarea name="txtHeader" id="txtHeader" rows="8" cols="80"><?php echo !empty($data['header'])?$data['header']:'' ?></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Footer
						</div>
						<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_receipt'], -1) == '1')): ?>
							<div class="actions">
								<div class="caption">
									<div class="btn-group">
										<button style="min-width: 110px" type="button" class="btn btn-sm green btnGetFooter">
											Get Template
										</button>
									</div>
								</div>
							</div>
						<?php endif ?>
					</div>
					<div class="portlet-body">
						<textarea name="txtFooter" id="txtFooter" rows="5" cols="80"><?php echo !empty($data['footer'])?$data['footer']:'' ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Preview Design
						</div>
						<div class="actions">
							<div class="caption">
								<span>Width</span>
								<div class="btn-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa" style='color: #4a4a4a;font-size: 14px;margin-top: 5px; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'>px</i>
										<input type="number" class="form-control input-sm intOnly txtWidth" value="350" max="1000" placeholder="width">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="preContent" style="text-align: center;padding: 5px;width: 350px;background-color: #fff;margin: auto;overflow: hidden;">
							<?php if(!empty($data['s_logo'])): ?>
								<img alt="" src="<?php echo  $this->hostGetImg ?>?files_id=<?php echo $data['s_logo'] ?>" style="height:50px; width:50px" />
							<?php endif ?>
						</div>
						<div class="preHeader" style="text-align: center;padding: 5px;width: 350px;min-height: 5px;background-color: #fff;margin: auto;overflow: hidden;">
							<?php echo !empty($data['header'])?str_replace("\n","<br/>",$data['header']):'<p style="text-align:center"><span style="font-size:14px">Header</span></p>' ?>
						</div>
						<div class="preContent" style="padding: 5px;width: 350px; height: 193px;background-color: rgba(232, 232, 232, 0.8);margin: auto;text-align: center;">
							
						</div>
						<div class="preFooter" style="text-align: center;padding: 5px;width: 350px;min-height: 5px;background-color: #fff;margin: auto;overflow: hidden;">
							<?php echo !empty($data['footer'])?str_replace("\n","<br/>",$data['footer']):'<p style="text-align:center"><span style="font-size:14px">Footer</span></p>' ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div style="text-align: right;padding-top: 10px">
				<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_receipt'], -1) == '1')): ?>
					<button style="min-width: 110px" type="button" class="btn green btnSave">Save</button>
				<?php else: ?>
					<button style="min-width: 110px;" type="button" class="btn green" disabled>Save (Read only)</button>
				<?php endif ?>	
				<button style="min-width: 110px" type="button" class="btn green btnPreview">
					Preview
				</button>
			</div>
		</div>
	</div>
</div>
<?php } ?>