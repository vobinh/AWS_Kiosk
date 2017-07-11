<link rel="stylesheet" type="text/css" href="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<style type="text/css" media="screen">
	.lb-left{ text-align: left !important; }
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$role       = $this->mPrivileges;
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings'">General Settings</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/privileges'">User Privileges</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/receiptdesign'">Receipt Design</button>
		<button type="button" class="btn btn-primary btn-lg" disabled>Database Import</button>
	</div>
</div>
<?php 
	$_storeId = base64_decode($this->sess_cus['storeId']);
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered" style="padding-bottom: 5px">
			<div class="portlet-title" style="margin-bottom: 0;">
				<div class="caption">
					Database Import
				</div>
			</div>
			<div class="portlet-body">
				<p>Import data exported from other applications. Currently, only exports from the following applications are supported:</p>
				<p><b>365Market, 3square market, iConnect</b></p>

				<div class="row">
					<div class="col-md-6">
						<div style="padding: 5px;background-color: rgb(240, 240, 240);">
							<form id="frm-import-menu" action="<?php echo url::base() ?>settings/importAPI" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered cls-wapcontent">
								<div class="form-body">
									<?php if((int)$this->sess_cus['admin_level'] != 2 && (string)$_storeId == '0'): ?>
									<div class="form-group">
										<label class="control-label col-md-3">Import Menu Items</label>
										<div class="col-md-6">
											<?php 
												include_once Kohana::find_file('views/include','inSelectStore');
											?>
										</div>
									</div>	
									<?php endif ?>
									<div class="form-group">
										<label class="control-label col-md-3">Import Menu Items</label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput" style="width: 100%;">
												<span class="btn green btn-file" style="min-width: 120px;">
													<span class="fileinput-new">Browse... </span>
													<span class="fileinput-exists">Change </span>
													<input type="file" id="uploadfile" name="uploadfile" accept=".csv">
												</span>
												<span class="fileinput-filename">
												</span>
												&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
												</a>
												<div style="padding-top: 10px;text-align: right;">
													<button style="min-width: 120px;" type="button" class="btn-upload btn green fileinput-exists">Import Data</button>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>