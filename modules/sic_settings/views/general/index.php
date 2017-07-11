<style type="text/css" media="screen">
	.lb-left{ text-align: left !important; }
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$role       = $this->mPrivileges;
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg" disabled>General Settings</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/privileges'">User Privileges</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/receiptdesign'">Receipt Design</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/importdatabase'">Database Import</button>
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
					General Settings Management
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
			<?php include_once Kohana::find_file('views/general/include','inStoreInfo'); ?>
			<?php include_once Kohana::find_file('views/general/include','inTimeZoneSettings'); ?>
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6">
		<?php include_once Kohana::find_file('views/general/include','inAppSettings'); ?>
		<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], 0, 1) == '1')): ?>
			<?php include_once Kohana::find_file('views/general/include','inPayment'); ?>
			<?php include_once Kohana::find_file('views/general/include','inAuthDevices'); ?>
		<?php endif ?>
	</div>
</div>