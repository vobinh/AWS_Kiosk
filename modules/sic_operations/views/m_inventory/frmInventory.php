<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Add Order'; ?>
				<span style="display: block; font-size: 14px;padding-top: 5px;">
					If you would prefer to manually add inventory stocks instead of going through the order procedure, you may do so by adding them here. Lot number will be automatically generated.
				</span>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-inventory" action="<?php echo url::base() ?>catalogs/saveInventory" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
						<div class="col-md-12">
						<?php if(!empty($data)): ?>
							<?php foreach ($data as $key => $data): ?>
								<div class="wap-item-add-inventory">
									<div class="item-add">
										<div class="col-md-12" style="font-weight: 600;padding-left: 10px;padding-right: 10px;">
											Lot# <?php echo !empty($data['lot'])?$data['lot']:''; ?>
											<input type="hidden" name="txt_lot[]" value="<?php echo !empty($data['lot'])?$data['lot']:''; ?>">
										</div>
										<div class="col-lg-7 in-group" style="overflow: hidden;">
											<div class="order-30 in-group">
												<input type="text" name="txt_product[]" data-name="<?php echo !empty($data['pro_no'])?$data['pro_no']:''; ?> / <?php echo !empty($data['item'])?$data['item']:''; ?>" value="<?php echo !empty($data['pro_id'])?$data['pro_id']:''; ?>" class="form-control input-sm slt_product_item" placeholder="Item Name or SKU#">
												<input type="hidden" name="txt_sub_category[]" value="<?php echo !empty($data['sub_category_id'])?$data['sub_category_id']:''; ?>">
												<input type="hidden" name="txt_name[]" value="<?php echo !empty($data['item'])?$data['item']:''; ?>">
												<input type="hidden" name="txt_file_id[]" value="<?php echo !empty($data['file_id'])?$data['file_id']:''; ?>">
											</div>
											<div class="order-25 in-group">
												<div style="float: left; width: 65%;">
													<div class="input-icon input-icon-sm right">
														<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
														<input type="text" name="txt_qty[]" data-cost="<?php echo !empty($data['pro_cost_store'])?$data['pro_cost_store']:0; ?>" data-per="<?php echo !empty($data['pro_per_store'])?$data['pro_per_store']:''; ?>" value="<?php echo !empty($data['i_quatity'])?$data['i_quatity']:''; ?>" class="form-control input-sm cls_qty decimal tooltips" data-container=".page-quick-wap" data-original-title="Qty" placeholder="Qty">
													</div>
												</div>
												<span style="display: inline-block;line-height: 28px;" class="lb_unit">&nbsp;<?php echo !empty($data['pro_unit'])?$data['pro_unit']:''; ?></span>
											</div>
											<div class="order-20 in-group">
												<input type="text" name="txt_date[]" value="<?php echo (!empty($data['expire_day']) && (int)strtotime($data['expire_day']) > 0)?date_format(date_create($data['expire_day']), 'm/d/Y'):''; ?>" class="form-control input-sm date-picker tooltips" data-container=".page-quick-wap" data-original-title="Expiration Date" placeholder="Expiration Date">
											</div>
											<div class="order-25 in-group">
												<input type="text" name="txt_price[]" value="<?php echo !empty($data['price'])?number_format($data['price'],2,'.',''):''; ?>" class="form-control input-sm decimal tooltips" data-container=".page-quick-wap" data-original-title="Payment" placeholder="Payment">
											</div>
										</div>
										<div class="col-lg-4 in-group info-catalog">
											<?php if(!empty($data['inventory_id'])): ?>
												<span style="display: block;">SKU# <?php echo !empty($data['pro_no'])?$data['pro_no']:''; ?></span>
												<span style="display: block;">Item: <?php echo !empty($data['item'])?$data['item']:''; ?></span>
												<span style="display: block;">Category: <?php echo !empty($data['sub_category_name'])?$data['sub_category_name']:''; ?></span>
											<?php endif ?>
										</div>
										<div class="col-lg-1 in-group" style="text-align: right;">
											<?php if(empty($data['inventory_id'])): ?>
												<a href="javascript:;"class="btn btn-sm red btn-delete">
													<i class="fa fa-times"></i>
												</a>
											<?php endif ?>
											<input type="hidden" name="txt_hd_id[]" value="<?php echo !empty($data['inventory_id'])?$data['inventory_id']:''; ?>">
										</div>
									</div>
								</div>
							<?php endforeach ?>
						<?php else: ?>
							<div class="wap-item-add-inventory">
								<div class="item-add">
									<?php $lot = round(microtime(true) * 1000) ?>
									<div class="col-md-12" style="font-weight: 600;padding-left: 10px;padding-right: 10px;">
										Lot# <?php echo $lot ?>
										<input type="hidden" name="txt_lot[]" value="<?php echo $lot ?>">
									</div>
									<div class="col-lg-7 in-group" style="overflow: hidden;">
										<div class="order-30 in-group">
											<input type="text" name="txt_product[]" data-name="" value="" class="form-control input-sm slt_product_item" placeholder="Item Name or SKU#">
											<input type="hidden" name="txt_sub_category[]" value="">
											<input type="hidden" name="txt_name[]" value="">
											<input type="hidden" name="txt_file_id[]" value="">
										</div>
										<div class="order-25 in-group">
											<div style="float: left; width: 65%;">
												<div class="input-icon input-icon-sm right">
													<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
													<input type="text" name="txt_qty[]" value="" class="form-control input-sm cls_qty decimal tooltips" data-container=".page-quick-wap" data-original-title="Qty" placeholder="Qty">
												</div>
											</div>
											<span style="display: inline-block;line-height: 28px;" class="lb_unit">&nbsp;</span>
										</div>
										<div class="order-20 in-group">
											<input type="text" name="txt_date[]" value="" class="form-control input-sm date-picker tooltips" data-container=".page-quick-wap" data-original-title="Expiration Date" placeholder="Expiration Date">
										</div>
										<div class="order-25 in-group">
											<input type="text" name="txt_price[]" value="" class="form-control input-sm decimal tooltips" data-container=".page-quick-wap" data-original-title="Payment" placeholder="Payment">
										</div>
									</div>
									<div class="col-lg-4 in-group info-catalog">
									</div>
									<div class="col-lg-1 in-group" style="text-align: right;">
										<a href="javascript:;"class="btn btn-sm red btn-delete">
											<i class="fa fa-times"></i>
										</a>
										<input type="hidden" name="txt_hd_id[]" value="">
									</div>
								</div>
							</div>
						<?php endif ?>
						</div>
					</div>
				</div>
				<?php if(empty($data)): ?>
				<div style="padding-bottom: 5px;">
					<button type="button" class="btn green btn-add"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<?php endif ?>
				<div class="form-actions right">
					<?php 
					$role = $this->mPrivileges; 
					if($role == 'FullAccess' || (is_array($role) && substr($role['operations_inventory'], -1) == '1')): ?>
						<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<?php else: ?>
						<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
					<?php endif ?>
					<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<div class="item-add inventory-template">
	<div class="col-md-12" style="font-weight: 600;padding-left: 10px;padding-right: 10px;">
		Lot# <span class="lb-lot"></span>
		<input type="hidden" name="txt_lot[]" value="">
	</div>
	<div class="col-lg-7 in-group" style="overflow: hidden;">
		<div class="order-30 in-group">
			<input type="text" name="txt_product[]" value="" class="form-control input-sm slt_catalog slt_product_item" placeholder="Item Name or SKU#">
			<input type="hidden" name="txt_sub_category[]" value="">
			<input type="hidden" name="txt_name[]" value="">
			<input type="hidden" name="txt_file_id[]" value="">
		</div>
		<div class="order-25 in-group">
			<div style="float: left; width: 65%;">
				<div class="input-icon input-icon-sm right">
					<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
					<input type="text" name="txt_qty[]" value="" class="form-control input-sm cls_qty decimal" placeholder="Qty">
				</div>
			</div>
			<span style="display: inline-block;line-height: 28px;" class="lb_unit"></span>
		</div>
		<div class="order-20 in-group">
			<input type="text" name="txt_date[]" value="" class="form-control input-sm date-picker" placeholder="Expiration Date">
		</div>
		<div class="order-25 in-group">
			<input type="text" name="txt_price[]" value="" class="form-control input-sm decimal" placeholder="Payment">
		</div>
	</div>
	<div class="col-lg-4 in-group info-catalog">
	</div>
	<div class="col-lg-1 in-group" style="text-align: right;">
		<a href="javascript:;"class="btn btn-sm red btn-delete">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		frmInventory.init();
		$('.tooltips').tooltip();
		<?php if($role == 'NoAccess' || (is_array($role) && substr($role['operations_inventory'], -1) == '0')){ ?>
			$('#frm-inventory').attr('action', 'javascript:void(0);');
		<?php } ?>
	});
</script>