<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Inventory Connection'; ?>
				<span style="display: block; font-size: 14px;">Select the constituent items for this combo set. Inventory connection is configured from the individual constituent items. Cost is likewise calculated from the constituent items.</span>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-select-inventory" action="<?php echo url::base() ?>catalogs/saveSelectInventory" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="wap-item-add-inventory">
								<?php if(!empty($data)): ?>
									<?php foreach ($data as $key => $value): ?>
										<div class="item-add">
											<div class="col-lg-4 in-group" style="overflow: hidden;">
												<span style="float: left;width: 10%;" class="icon-catalog file_id_menu"><img src="<?php echo $this->hostGetImg ?>?files_id=<?php echo !empty($value[0]['image'])?$value[0]['image']:''; ?>" alt=""></span>
												<div style="float: left;width: 90%;" class="in-group">
													<input type="text" name="txt_catalog[]" data-name="<?php echo !empty($value[0]['text'])?$value[0]['text']:''; ?>" value="<?php echo !empty($value[0]['id'])?$value[0]['id']:''; ?>" class="form-control input-sm slt_catalog_item_combo" placeholder="Menu Item Name">
												</div>
											</div>
											<div class="col-lg-7 in-group info-catalog">
												<span style="display: block;">Menu Item #: <?php echo !empty($value[0]['item_no'])?$value[0]['item_no']:''; ?></span>
												<span style="display: block;">Item: <?php echo !empty($value[0]['item_name'])?$value[0]['item_name']:''; ?></span>
												<span style="display: block;">Category: <?php echo !empty($value[0]['category_name'])?$value[0]['category_name']:''; ?></span>
											</div>
											<div class="col-lg-1 in-group" style="text-align: right;">
												<a href="javascript:;" onclick="ComboSet.DeleteConnectItem(this)" class="btn btn-sm red">
													<i class="fa fa-times"></i>
												</a>
											</div>
										</div>
									<?php endforeach ?>
								<?php else: ?>
									<div class="item-add">
										<div class="col-lg-4 in-group" style="overflow: hidden;">
											<span style="float: left;width: 10%;display:none" class="icon-catalog file_id_menu"></span>
											<div style="float: left;width: 90%;" class="in-group">
												<input type="text" name="txt_catalog[]" value="" class="form-control input-sm slt_catalog_item_combo" placeholder="Menu Item Name">
											</div>
										</div>
										<div class="col-lg-7 in-group info-catalog">
										</div>
										<div class="col-lg-1 in-group" style="text-align: right;">
											<a href="javascript:;" onclick="ComboSet.DeleteConnectItem(this)" class="btn btn-sm red">
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
					<button type="button" class="btn green" onclick="ComboSet.Additem()"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<?php endif ?>
				<div class="form-actions right">
					<button onclick="ComboSet.SaveComboSet()" style="min-width: 150px;" type="button" class="btn green">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<div class="item-add inventory-template">
	<div class="col-lg-4 in-group" style="overflow: hidden;">
		<span style="float: left;width: 10%;display:none" class="icon-catalog file_id_menu"></span>
		<div style="float: left;width: 90%;" class="in-group">
			<input type="text" name="txt_catalog[]" value="" class="form-control input-sm slt_catalog" placeholder="Menu Item Name">
		</div>
	</div>
	<div class="col-lg-7 in-group info-catalog">
	</div>
	<div class="col-lg-1 in-group" style="text-align: right;">
		<a href="javascript:;" onclick="ComboSet.DeleteConnectItem(this)" class="btn btn-sm red">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
