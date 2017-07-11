<style>
	#tb-option td {padding-right: 5px;}
</style>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg">Menu</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/inventory'" style="position: relative;">Inventory <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countStoreOrder)?$this->countStoreOrder:0 ?> </span></button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/category'">Category</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>catalogs/stage'">Pick Up Stations</button>
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['operations_menu'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Menu Item Management
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<?php 
						$role = $this->mPrivileges;
						if($role == 'FullAccess' || (is_array($role) && substr($role['operations_menu'], -1) == '1')): ?>	
						<div class="table-action">
							<button type="button" class="btn green btn-add-catalog" onclick="Catalog.AddOptionsMenu()">
								<i class="fa fa-plus"></i> Add New Options
							</button>
							<button type="button" class="btn green btn-add-catalog" onclick="Catalog.AddCatalog()">
								<i class="fa fa-plus"></i> Add New Item
							</button>
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="javascript:void(0)" onclick="Catalog.action(1)"><i class="fa fa-check-circle"></i> Active</a>
									</li>
									<li>
										<a href="javascript:void(0)" onclick="Catalog.action(2)"><i class="fa  fa-minus-circle"></i> Inactive</a>
									</li>
									<li>
										<a href="javascript:void(0)" onclick="Catalog.action(3)"><i class="fa fa-trash-o"></i> Delete</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0)" class="cls-export"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
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
				<div class="table-responsive table-datatable filter-hidden" style="height: 406px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-catalog" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th>
									<input type="checkbox" class="chk-all">
								</th>
								<th>
									Icon
								</th>
								<th>
									Category
								</th>
								<th>
									Item Name
								</th>
								<th>
									Price
								</th>
								<th>
									Cost
								</th>
								<th>
									Available
								</th>
								<th>
									Menu Item#
								</th>
								<th>
									Type
								</th>
								<th>
									Note / Description
								</th>
								<th>
									Status
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<p style="padding: 0px 0px 5px 5px;"><b id="lb_sl">0</b> items selected</p>
			</div>
		</div>
	</div>
</div>
<?php } ?>
