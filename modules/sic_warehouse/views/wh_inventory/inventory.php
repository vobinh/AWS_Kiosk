<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse'">Registry</button>
		<button type="button" class="btn btn-primary btn-lg" disabled style="position: relative;">Inventory</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/category'">Category</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/distribution'" style="position: relative;">Distribution <span class="badge badge-danger" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countOrder)?$this->countOrder:0 ?> </span></button>
		<!-- <button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/analysis'">Analysis</button> -->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-content-inventory">
			<div class="portlet-title">
				<div class="caption">
					Warehouse Inventory Management
					<span style="display: block;padding-top: 5px;font-size: 14px;">Manage the inventory level of the items in your item registry.</span>
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<button type="button" class="btn green btn-add-order" onclick="inventoryWarehouse.placeOrder()">
							Place Order
						</button>
						<button type="button" class="btn green btn-view-order" onclick="inventoryWarehouse.reviewOrder()" style="position: relative;">
							Review Order <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countWHOrder)?$this->countWHOrder:0 ?> </span>
						</button>
						<button type="button" class="btn green btn-add-inventory" onclick="inventoryWarehouse.addInventory()">
							Manually Add Inventory
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" class="inventory-delete"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="javascript:void(0)" class="inventory-csv" ><i class="fa fa-file-excel-o"></i>&nbsp;Export to CSV</a>
								</li>
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
			<div class="portlet-body rgba_white" style="position: relative;">
				<div class="col-md-12" style="padding: 10px;padding: 10px;border-bottom: 1px solid #cecece;">
					<div class="row">
						<div class="in-sm-11 in-sm-push-1">
							<button type="button" disabled class="btn green btn-filter btn-show-all">
								Show All
							</button>
							<button type="button" class="btn default btn-filter btn-show-category">
								By Category
							</button>
							<button type="button" class="btn default btn-filter btn-show-date">
								By Date
							</button>
							<button type="button" class="btn default btn-filter btn-show-status">
								By Status
							</button>
							<div class="btn-group" style="float: right;">
								<span class="btn">Display</span>
								<button style="min-width: 70px;margin-right: 0px;" class="btn green btn-display cls-grid" data-val="grid"><i class="fa fa-th"></i>&nbsp;Title</button>
								<button style="min-width: 70px;margin-right: 0px;" class="btn default btn-display cls-list" data-val="list"><i class="fa fa-list"></i>&nbsp;List</button>
							</div>
							<div class="filter-inventory filter-date" style="display: none;">
								<div style="padding: 10px;color: #FFFFFF;background-color: #72c5bd;">
									<span style="white-space: nowrap;display: inline-block;">
										<div class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
											<input type="text" readonly class="form-control input-sm" name="txt_date_from" placeholder="Start">
											<span class="input-group-addon" style="line-height: 1;"> to </span>
											<input type="text" readonly class="form-control input-sm" name="txt_date_to" placeholder="End">
										</div>
									</span>
								</div>
							</div>
							<div class="filter-inventory filter-category" style="display: none;">
								<div style="padding: 10px;color: #FFFFFF;background-color: #72c5bd;">
								<?php if(!empty($dataCategory)): ?>
									<?php foreach ($dataCategory as $key => $value): ?>
										<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_category[]" checked value="<?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?>"> <span class="item-size-15"><?php echo !empty($value['sub_category_name'])?ucwords(strtolower($value['sub_category_name'])):'' ?></span></span>
									<?php endforeach ?>
								<?php endif ?>
								</div>
							</div>
							<div class="filter-inventory filter-status" style="display: none;">
								<div style="padding: 10px;color: #FFFFFF;background-color: #72c5bd;">
									<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_status[]" checked value="Available"> <span class="item-size-15">Available</span></span>
									<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_status[]" checked value="Not available"> <span class="item-size-15">Not available</span></span>
									<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_status[]" checked value="Expired"> <span class="item-size-15">Expired</span></span>
									<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_status[]" checked value="Expires soon"> <span class="item-size-15">Expires soon</span></span>
									<span style="white-space: nowrap;display: inline-block;"><input type="checkbox" name="ckb_status[]" checked value="Low Inventory"> <span class="item-size-15">Low Inventory</span></span>
									
								</div>
							</div>
						</div>
						<div class="in-sm-1 in-sm-pull-11">
							<input type="checkbox" name="" class="chk-all" value="">
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
				<div class="body-data-in" style="min-height: 231px;max-height: 501px;position: relative;padding-top: 10px;border-bottom: 1px solid #cecece; overflow-x: hidden;overflow-y: auto;">
					
				</div>
				
			</div>
			<div class="clearfix"></div>
			<div class="row" style="padding-top: 5px;">
				<div class="col-md-12">
					<span style="white-space: nowrap;display: block;"><input type="checkbox" class="ckb_auto_delete" name="ckb_auto_delete" value="1"> <span class="item-size-15">Automatically delete entries marked "Not available" or "Expired" after 7 days</span></span>
					<span class="cls-chk-group" style="white-space: nowrap;display: block;"><input type="checkbox" class="ckb_group_inventory" name="ckb_group_inventory" value="1"> <span class="item-size-15">Consolidate multiple tiles of the same inventory item</span></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-2 col-md-3 col-sm-6 clone-me" style="display: none;">
	<div class="border add-catalog item-inventory">
		<p class="in-catalog"></p>
		<p class="item-size-15 img-inventory">
			<img class="in-img" width="32px" height="32px" src="" alt="">&nbsp;
			<span class="in-name" style="font-weight: 600;"></span>
		</p>
		<p class="item-size-15 text-inventory in-sku"></p>
		<p class="item-size-15 text-inventory in-lot"></p>
		<p class="item-size-15 text-inventory in-date-add"></p>
		<p class="item-size-15 text-inventory in-date-expires"></p>
		<p class="item-size-15 text-inventory in-status"></p>
		<div class="total-item in-total"></div>
	</div>
</div>

<div class="table-clone filter-hidden" style="position: relative;display: none;">
	<table class="table table-striped" width="100%" style="margin: auto auto auto 0;">
		<thead>
			<tr>
				<th>
					
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Item Name
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Category
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					SKU#
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Lot#
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Added Date
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Expiry Date
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Status 
				</th>
				<th style="white-space: nowrap;vertical-align: middle;">
					Stock
				</th>
			</tr>
		</thead>
		<tbody>
			<tr class="clone" style="display: none;">
				<td class="in-catalog"></td>
				<td class="slt-row in-name"></td>
				<td class="slt-row in-category"></td>
				<td class="slt-row in-sku"></td>
				<td class="slt-row in-lot"></td>
				<td class="slt-row in-date-add"></td>
				<td class="slt-row in-date-expires"></td>
				<td class="slt-row in-status"></td>
				<td class="slt-row in-total"></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- include jsInventory.php  controller jsKiosk -->