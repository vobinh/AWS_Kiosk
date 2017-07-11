<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse'">Registry</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/inventory'" style="position: relative;">Inventory <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -5px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countWHOrder)?$this->countWHOrder:0 ?> </span></button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/category'">Category</button>

		<button type="button" class="btn btn-primary btn-lg" disabled style="position: relative;">Distribution <span class="badge badge-danger lb-count-order" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo !empty($this->countOrder)?$this->countOrder:0 ?> </span></button>
		<!-- <button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>warehouse/analysis'">Analysis</button> -->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-distribution">
			<div class="portlet-title">
				<div class="caption">
					Distribution Management
					<span style="display: block;padding-top: 5px;font-size: 14px;">
						Below is the list of orders that have been placed by associated stores. Approving orders will make corresponding adjustments in your inventory level and accounting.
					 </span>
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-md-12" style="margin-bottom: 5px;">
					<button type="button" disabled="" data-name="all" class="btn green btn-filter">
						Show All
					</button>
					<button type="button" data-name="approved" class="btn default btn-filter">
						Approved
					</button>
					<button type="button" data-name="rejected" class="btn default btn-filter">
						Rejected
					</button>
				</div>
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<!-- <button type="button" class="btn green" onclick="registryWarehouse.add()">
							<i class="fa fa-plus"></i> Register New Item
						</button> -->
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" onclick="distributionWarehouse.action('approve')"><i class="fa fa-check-circle"></i> Approve</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="distributionWarehouse.action('reject')"><i class="fa fa-thumbs-o-down"></i> Reject</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="distributionWarehouse.delete()"><i class="fa fa-trash-o"></i> Delete</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="javascript:void(0)"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
								</li>
								<!-- <li>
									<a href="javascript:void(0)"><i class="fa fa-file-code-o"></i> Export to HTML</a>
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
					<table class="table table-striped table-hover table-advance-th" id="tb-distribution" width="100%" style="margin: auto auto auto 0;">
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
								<th style="vertical-align: middle;">
									Ordered By
								</th>
								<th style="vertical-align: middle;">
									Preset Cost of
									<span style="display: block;font-size: 12px;">
										Purchase for Stores
									</span>
								</th>
								<th style="vertical-align: middle;">
									Actual Payment 
									<span style="display: block;font-size: 12px;">
										Committed by Store
									</span>
								</th>
								<th style="vertical-align: middle;">
									Quantity
								</th>
								<th style="vertical-align: middle;">
									Total Payment
								</th>
								<th style="text-align: center;">
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-md-12">
						<input type="checkbox" class="chk_auto_delete" name="chk_auto_delete" value="1"> Automatically delete approved and rejected orders after 10 days
					</div>
					<div class="col-md-12">
						<span style="display: block;font-weight: bold;padding: 5px">
							<span class="lb-count-order"><?php echo !empty($this->countOrder)?$this->countOrder:0 ?></span> orders require your attention
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- include jsListDistribution.php  controller jsKiosk -->