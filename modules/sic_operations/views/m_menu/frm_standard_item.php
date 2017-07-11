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
			<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="border add-catalog" style="height: 220px; text-align: center;">
					<h4 style="text-align: left;">Icon</h4>
					<div class="thumbnail" style="width: 125px;position: relative; margin: auto; margin-bottom: 10px;">
						<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($data['file_id'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
						<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($data['file_id'])?$this->hostGetImg .'?files_id='.$data['file_id']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
					</div>
					<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
					<input type="hidden" id="uploadfilehd" name="uploadfilehd" value="<?php echo !empty($data['file_id'])?$data['file_id']:'' ?>">
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
					<h4>Location</h4>
					<div class="catalog-middle in-group">
						<select name="txt_stage" id="txt_stage" class="form-control input-sm">
							<option value="">Select item stage</option>
							<?php if(!empty($listStage)): ?>
								<?php foreach ($listStage as $key => $value): ?>
									<option <?php echo (!empty($data_menu['menu']['stage_id']) && $data_menu['menu']['stage_id'] == $value['id'])?'selected':'' ?> value="<?php echo !empty($value['id'])?$value['id']:'' ?>"><?php echo !empty($value['name'])?$value['name']:'' ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
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
					<h4>Option</h4>
					<div class="catalog-middle" style="top: 35px;text-align: center;">
						<div style="height:120px;overflow: auto;" class="wrap-tb-option">

						</div>
						<!-- Catalog.AddOptions() -->
					</div>
					<div style="position: absolute;bottom: 10px;left: 10px;right: 10px;text-align: center;">
						<button onclick="StandarItem.OpenOptions()" style="position:relative" type="button" class="btn green">
							<span class="badge badge-danger total-options" style="position: absolute;top: -12px;right: -10px;background-color: #ea111b;color: #fff;font-weight: bold;font-size: 17px !important;padding: 4px 8px;height: 26px;border-radius: 50px !important;"></span>
							Add Option
						</button>
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
					<h4>Calories</h4>
					<div class="catalog-middle in-group">
						<input type="text" style="text-align: right;" class="form-control input-sm intOnly" name="txt_calory" value="<?php echo !empty($data_menu['menu']['calory'])?$data_menu['menu']['calory']:'' ?>" placeholder="">
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
			<div class="col-lg-2 col-md-4 col-sm-6">
				<div class="border add-catalog" style="height: 220px;">
					<h4>Barcode</h4>
					<div class="catalog-middle in-group">
						<input type="text" class="form-control input-sm intOnly" name="txt_barcode" value="<?php echo !empty($data_menu['menu']['barcode'])?$data_menu['menu']['barcode']:'' ?>" placeholder="">
					</div>
					<div style="position: absolute;bottom: 10px;left: 10px;right: 10px;text-align: center;">
						<span onclick="StandarItem.Generate()" class="btn green" style="position:relative">
							<span>Generate</span>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-actions right">
		<input type="hidden" name="txt_m_type" value="standar_item">
		<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data_menu['menu']['menu_id'])?$data_menu['menu']['menu_id']:'' ?>">
		<input type="hidden" id="_txt_menu_no" value="<?php echo !empty($data_menu['menu']['menu_item_number'])?$data_menu['menu']['menu_item_number']:'' ?>">
		<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
		<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
	</div>
</form>
<!-- END FORM-->
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>


