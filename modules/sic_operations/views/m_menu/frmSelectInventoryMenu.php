<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Inventory Connection'; ?>
				<span style="display: block; font-size: 14px;">Select which inventory items are depleted when this item is ordered.</span>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-select-inventory" action="<?php echo url::base() ?>catalogs/saveSelectInventory" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="wap-item-add-inventory">
								<?php if(!empty($data_ingredient)): ?>
									<?php foreach ($data_ingredient as $key => $value): ?>
										<div class="item-add">
											<div class="col-lg-4 in-group" style="overflow: hidden;">
												<div class="order-70 in-group">
													<input type="text" name="txt_catalog[]" data-name="<?php echo !empty($value['item'])?$value['item']:''; ?>" value="<?php echo !empty($value['pro_id'])?$value['pro_id']:''; ?>" class="form-control input-sm slt_catalog_item" placeholder="Inventory Name or SKU#">
												</div>
												<div class="order-30 in-group">
													<div style="float: left; width: 65%;">
														<input type="text" name="txt_qty[]" value="<?php echo !empty($value['qty'])?$value['qty']:''; ?>" class="form-control input-sm cls_qty decimal" placeholder="Qty">
													</div>
													<span style="display: inline-block;line-height: 28px;" class="lb_unit">&nbsp;<?php echo !empty($value['pro_unit'])?$value['pro_unit']:''; ?></span>
												</div>
											</div>
											<div class="col-lg-7 in-group info-catalog">
												<span style="display: block;">SKU# <?php echo !empty($value['pro_no'])?$value['pro_no']:''; ?></span>
												<span style="display: block;">Item: <?php echo !empty($value['pro_name'])?$value['pro_name']:''; ?></span>
												<span style="display: block;">Category: <?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:''; ?></span>
											</div>
											<div class="col-lg-1 in-group" style="text-align: right;">
												<a onclick="ComboSet.DeleteConnectItem(this)" href="javascript:;" class="btn btn-sm red">
													<i class="fa fa-times"></i>
												</a>
											</div>
										</div>
									<?php endforeach ?>
								<?php else: ?>
									<div class="item-add">
										<div class="col-lg-4 in-group" style="overflow: hidden;">
											<div class="order-70 in-group">
												<input type="text" name="txt_catalog[]" value="" class="form-control input-sm slt_catalog_item" placeholder="Inventory Name or SKU#">
											</div>
											<div class="order-30 in-group">
												<div style="float: left; width: 65%;">
													<input type="text" name="txt_qty[]" value="" class="form-control input-sm cls_qty decimal" placeholder="Qty">
												</div>
												<span style="display: inline-block;line-height: 28px;" class="lb_unit">&nbsp;</span>
											</div>
										</div>
										<div class="col-lg-7 in-group info-catalog">
										</div>
										<div class="col-lg-1 in-group" style="text-align: right;">
											<a onclick="ComboSet.DeleteConnectItem(this)" href="javascript:;" class="btn btn-sm red">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</div>
				<?php if(empty($data['id'])): ?>
				<div style="padding-bottom: 5px;">
					<button onclick="StandarItem.Additem()" type="button" class="btn green"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<?php endif ?>
				<div class="form-actions right">
					<button onclick="StandarItem.SaveConnectItem()" style="min-width: 150px;" type="button" class="btn green btn-submit">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<div class="item-add inventory-template">
	<div class="col-lg-4 in-group" style="overflow: hidden;">
		<div class="order-70 in-group">
			<input type="text" name="txt_catalog[]" value="" class="form-control input-sm slt_catalog" placeholder="Inventory Name or SKU#">
		</div>
		<div class="order-30 in-group">
			<div style="float: left; width: 65%;">
				<input type="text" name="txt_qty[]" value="" class="form-control input-sm cls_qty decimal" placeholder="Qty">
			</div>
			<span style="display: inline-block;line-height: 28px;" class="lb_unit">&nbsp;</span>
		</div>
	</div>
	<div class="col-lg-7 in-group info-catalog">
	</div>
	<div class="col-lg-1 in-group" style="text-align: right;">
		<a onclick="ComboSet.DeleteConnectItem(this)" href="javascript:;" class="btn btn-sm red">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
