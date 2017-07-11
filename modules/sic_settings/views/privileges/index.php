<style type="text/css" media="screen">
	    #tb-stage td {vertical-align: middle;}
	    .cls-weight { font-weight: 600; }
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings'">General Settings</button>
		<button type="button" class="btn btn-lg btn-primary" disabled>User Privileges</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/receiptdesign'">Receipt Design</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>settings/importdatabase'">Database Import</button>
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_privileges'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-admin">
			<div class="portlet-title">
				<div class="caption">
					User Privileges
					<span style="display: block;padding-top: 5px;font-size: 14px;"></span>
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
			<div class="clearfix"></div>
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-privileges" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th style="vertical-align: middle;">
									Name
								</th>
								<th style="vertical-align: middle;">
									Email
								</th>
								<th style="vertical-align: middle;">
									Date
								</th>
								<th style="vertical-align: middle;">
									Freeze User
								</th>
								<th width="10%" style="vertical-align: middle;">
									User Privileges
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<?php if($this->mPrivileges == 'FullAccess'): ?>
				<div style="text-align: right;padding: 5px;">
					<button type="bottom" class="btn btn-default green btn-set-dafault">Configure Default</button>
				</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>