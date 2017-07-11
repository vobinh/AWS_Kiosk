<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg" disabled>Registry</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/inventory'" style="position: relative;">Inventory <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countWHOrder)?$this->countWHOrder:0 ?> </span></button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/category'">Category</button>

		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/distribution'" style="position: relative;">Distribution <span class="badge badge-danger" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countOrder)?$this->countOrder:0 ?> </span></button>
		<!-- <button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/analysis'">Analysis</button> -->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-registry">
			<div class="portlet-title">
				<div class="caption">
					Warehouse Registry
					<span style="display: block;padding-top: 5px;font-size: 14px;">Manage the registry of items from which associated stores can fill in order requests. </span>
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<button type="button" class="btn green" onclick="registryWarehouse.add()">
							<i class="fa fa-plus"></i> Register New Item
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" class="cus-delete" onclick="registryWarehouse.delete()"><i class="fa fa-trash-o"></i> Delete</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="javascript:void(0)" class="cus-csv" ><i class="fa fa-file-excel-o"></i> Export to CSV</a>
								</li>
								<!-- <li>
									<a href="javascript:void(0)" class="cus-html" ><i class="fa fa-file-code-o"></i> Export to HTML</a>
								</li> -->
							</ul>
						</div>
					</div>
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
					<table class="table table-striped table-hover table-advance-th" id="tb-registry" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th style="vertical-align: middle;">
									<input type="checkbox" class="chk-all">
								</th>
								<th style="vertical-align: middle;">
									Icon
								</th>
								<th style="vertical-align: middle;">
									Category
								</th>
								<th style="vertical-align: middle;">
									Item Name
								</th>
								<th style="vertical-align: middle;">
									SKU#
								</th>
								<th style="vertical-align: middle;" data-container="body" class="tooltips" data-original-title="This is the suggested price for stores to purchase orders from the warehouse. They may enter an alternative value at purchase, but the auto-calculated value will be based on the suggested cost.">
									Cost of Purchase
									<span style="display: block;font-size: 12px;">
										Store
									</span>
								</th>
								<th style="vertical-align: middle;" data-container="body" class="tooltips" data-original-title="This is the price the warehouse pays to suppliers / purveyors to keep its stock in its warehouse.">
									Cost of Purchase
									<span style="display: block;font-size: 12px;">
										Warehouse
									</span>
								</th>
								<th style="vertical-align: middle;">
									Unit
								</th>
								<th style="text-align: center;" data-container="body" class="tooltips" data-original-title="This is the suggested price for stores to purchase orders from the warehouse. They may enter an alternative value at purchase, but the auto-calculated value will be based on the suggested cost.">
									Shelf Life
									<span style="display: block;font-size: 12px;">
										Store
									</span>
								</th>
								<th style="text-align: center;" data-container="body" class="tooltips" data-original-title="This is the shelf life for items when the warehouse receives them from suppliers / purveyors.">
									Shelf Life
									<span style="display: block;font-size: 12px;">
										Warehouse
									</span>
								</th>
								<th style="text-align: center;">
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- include jsListWarehouse.php  controller jsKiosk -->