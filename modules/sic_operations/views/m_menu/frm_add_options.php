<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add New Menu Item'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
				<form id="frm-catalog" action="<?php echo url::base() ?>catalogs/saveCatalog" method="post" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
										<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
									</label>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Category</h4>
									<div class="catalog-middle in-group">
										<select name="txt_sub_category" id="txt_sub_category" class="form-control input-sm">
											<?php if(!empty($sub_category)): ?>
												<?php foreach ($sub_category as $key => $value): ?>
													<option <?php echo (!empty($data_menu['menu']['sub_category_id']) && $data_menu['menu']['sub_category_id'] == $value['sub_category_id'])?'selected':'' ?> value="<?php echo !empty($value['sub_category_id'])?$value['sub_category_id']:'' ?>"><?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Item Name</h4>
									<div class="catalog-middle in-group">
										<div class="input-icon input-icon-sm right">
											<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
											<input type="text" class="form-control input-sm" name="txt_item_name" value="<?php echo !empty($data_menu['menu']['m_item'])?$data_menu['menu']['m_item']:'' ?>" placeholder="">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Menu Item #</h4>
									<div class="catalog-middle in-group">
										<input readonly="readonly" type="text" class="form-control input-sm intOnly" name="txt_sku" value="<?php echo !empty($data_menu['menu']['menu_item_number'])?$data_menu['menu']['menu_item_number']:'' ?>" placeholder="">
										<div class="customers-error">
											<span style='' class="cus-help-block">Menu Item # must be unique.</span>
											<button type="button" class="btn btn-sm green" onclick="nextCode(<?php echo !empty($type)?$type:1; ?>)">Fix Invalid Values</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Menu Price</h4>
									<div class="catalog-middle in-group">
										<input type="text" style="text-align: right;" class="form-control input-sm decimal" name="txt_price" value="<?php echo !empty($data_menu['menu']['price'])?number_format($data_menu['menu']['price'],2,'.',''):'0.00' ?>" placeholder="">
									</div>
								</div>
							</div>
							<div style="display:none" class="col-lg-4 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Option</h4>
									<div class="catalog-middle" style="top: 35px;">
										<div style="height:120px;overflow: auto;" class="wrap-tb-option">
											<table style="width: 100%;" id="tb-option" class="tb-option">
												<thead style="background-color: #fff;">
													<tr>
														<th>Name</th>
														<th>Price (+/-)</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php if(!empty($data_menu['menu_option'])): ?>
														<?php foreach ($data_menu['menu_option'] as $key => $value): ?>
															<tr>
																<td >
																	<input type="text"  style="margin-bottom: 5px;" class="form-control input-sm" name="txt_name_option[]" value="<?php echo !empty($value['op_name'])?$value['op_name']:'' ?>" placeholder="">
																</td>
																<td class="in-group" style="width:25%;">
																	<input type="text"  style="margin-bottom: 5px;text-align: right" class="form-control input-sm decimal" name="txt_price_option[]" value="<?php echo !empty($value['add_price'])?number_format($value['add_price'],2,'.',''):"0.00" ?>" placeholder="">
																</td>
																<td >
																	<a onclick="Catalog.RemoveOptions(this)" href="javascript:;" class="btn btn-sm red">
																		<i class="fa fa-times"></i>
																	</a>
																</td>
															</tr>
														<?php endforeach ?>
													<?php endif ?>
												</tbody>
											</table>
										</div>
										<button onclick="Catalog.AddOptions()" style="" type="button" class="btn green">Add Option</button>
									</div>
								</div>
							</div>
							<?php /* ?>
							<div class="col-lg-2 visible-lg">
								<div class="add-catalog" style="height: 220px;">
								</div>
							</div>
							<?php */ ?>
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Inventory Connection</h4>
									<div class="in-group" style="position: relative;">
										Select which inventory items are depleted when this item is ordered.
									</div>
									
									<div style="position: absolute;bottom: 10px;left: 10px;right: 10px;text-align: center;">
										<div class="item-add-inventory">
											<?php if(!empty($data_menu['ingredient'])): ?>
												<?php foreach ($data_menu['ingredient'] as $key => $value): ?>
													<input class="txt_catalog" type="hidden" name="txt_catalog[]" value="<?php echo $value['item_id'] ?>">
													<input class="txt_qty" type="hidden" name="txt_qty[]" value="<?php echo $value['ig_quantity'] ?>">
												<?php endforeach ?>
											<?php endif ?>
										</div>
										<span onclick="StandarItem.OpenConnectItem()" class="btn green" style="position:relative">
											<span class="badge badge-danger total-item" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"><?php echo (!empty($data_menu['ingredient']))?count($data_menu['ingredient']):'' ?></span>
											<span>Select Items</span>
										</span>
									</div>
								</div>
							</div> 
							<div class="col-lg-2 col-md-4 col-sm-6">
								<div class="border add-catalog" style="height: 220px;">
									<h4>Note / Description</h4>
									<div class="catalog-middle in-group" style="top: 40px;">
										<textarea class="form-control" rows="6" name="txt_note"><?php echo !empty($data_menu['menu']['description'])?$data_menu['menu']['description']:"" ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions right">
						<input type="hidden" name="txt_m_type" value="options_menu">
						<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data_menu['menu']['menu_id'])?$data_menu['menu']['menu_id']:'' ?>">
						<input type="hidden" id="_txt_menu_no" value="<?php echo !empty($data_menu['menu']['menu_item_number'])?$data_menu['menu']['menu_item_number']:'' ?>">
						<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
						<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
					</div>
				</form>
				<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>