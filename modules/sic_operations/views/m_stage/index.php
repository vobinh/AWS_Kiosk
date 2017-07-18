<style type="text/css" media="screen">
	    #tb-stage td {vertical-align: middle;}
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
	$role       = $this->mPrivileges;

?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/catalog'">Menu</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/inventory'" style="position: relative;">Inventory <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countStoreOrder)?$this->countStoreOrder:0 ?> </span></button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/category'">Category</button>
		<button type="button" class="btn btn-primary btn-lg">Pick Up Stations</button>
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_stage'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-stage">
			<div class="portlet-title">
				<div class="caption">
					Pick Up Stations Management
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
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_stage'], -1) == '1')): ?>
						<div class="table-action">
							<button type="button" class="btn green" onclick="stageManagement.add()">
								<i class="fa fa-plus"></i> Add Pickup Station
							</button>
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="javascript:void(0)" onclick="stageManagement.action('OPEN')"><i class="fa fa-check-circle"></i> Set as Open</a>
									</li>
									<li>
										<a href="javascript:void(0)" onclick="stageManagement.action('CLOSE')"><i class="fa  fa-minus-circle"></i> Set as Close</a>
									</li>
									<li>
										<a href="javascript:void(0)" class="cus-delete" onclick="stageManagement.delete()"><i class="fa fa-trash-o"></i> Delete</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0)" class="stage-csv" ><i class="fa fa-file-excel-o"></i> Export to CSV</a>
									</li>
								</ul>
							</div>
						</div>
					<?php endif ?>
				</div>
				<div class="col-sm-4 col-sm-pull-8">
					<div class="portlet-input">
						<div class="input-icon">
							<i class="icon-magnifier "></i>
							<input id="myInput" type="text" class="form-control" placeholder="search...">
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="height: 420px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-stage" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th style="vertical-align: middle;">
									<input type="checkbox" class="chk-all">
								</th>
								<th style="vertical-align: middle;">
									Icon
								</th>
								<th style="vertical-align: middle;">
									Store
								</th>
								<th style="vertical-align: middle;">
									Pick Up Stations
								</th>
								<th>
									Added Date
								</th>
								<th>
									Update Date
								</th>
								<th>
									Status
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<p style="padding: 0px 0px 5px 5px;"><b id="lb_sl">0</b> items selected</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>