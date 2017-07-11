<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'View Order'; ?>
				<span style="display: block; font-size: 14px;">This is your order sheet consisting of your registered inventory items. Enter the quantity of each inventory item you would like to order. Cost is auto-calculated, but you may enter a different value if desired.</span>
			</div>
		</div>
		<form id="frm-place-order" action="<?php echo url::base() ?>warehouse/savePlaceOrder" method="POST" accept-charset="utf-8">
		<div class="portlet-body form wap-place-order">
			<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
				<table class="table table-striped" id="tb-place-order" width="100%" style="margin: auto auto auto 0;">
					<thead>
						<tr>
							<th style="white-space: nowrap;vertical-align: middle;">
								Icon
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Category
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Item Name
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								SKU#
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Cost of Pusrchase
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Item Description
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Quantity to Order
							</th>
							<th style="white-space: nowrap;vertical-align: middle;">
								Payment
							</th>
							<th style="white-space: nowrap;vertical-align: middle;width:20%;">
								Consumption Rate
							</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($data)): ?>
							<?php foreach ($data as $key => $value): ?>
								<?php 
									$tdCostWarehouse = (!empty($value['pro_cost_warehouse'])?'$'.$value['pro_cost_warehouse'].' per':'').(!empty($value['pro_per_warehouse'])?' '.$value['pro_per_warehouse'].' '.$value['pro_unit']:'');
								 ?>
								<tr>
									<td>
										<div class='icon-catalog'>
										<?php if(!empty($value['file_id'])): ?>
											<img style='width:32px;' src='<?php echo $this->hostGetImg ?>?files_id=<?php echo $value['file_id'] ?>' alt=''>
										<?php endif ?>
										</div>
									</td>
									<td>
										<?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?>
									</td>
									<td>
										<?php echo !empty($value['pro_name'])?$value['pro_name']:'' ?>
									</td>
									<td>
										<?php echo !empty($value['pro_no'])?$value['pro_no']:'' ?>
									</td>
									<td>
										<?php echo $tdCostWarehouse ?>
									</td>
									<td>
										<?php echo !empty($value['pro_note'])?$value['pro_note']:'' ?>
									</td>
									<td>
										<input style="width: 85px;display: inline-block;" type="text" name="txt_unit[]" class="form-control input-sm decimal" data-cost="<?php echo !empty($value['pro_cost_warehouse'])?$value['pro_cost_warehouse']:'0' ?>" data-per="<?php echo !empty($value['pro_per_warehouse'])?$value['pro_per_warehouse']:'0' ?>" value="" placeholder="Enter"> <?php echo !empty($value['pro_unit'])?$value['pro_unit']:'Units' ?>
									</td>
									<td>
										<input style="width: 120px;" type="text" name="txt_price[]" class="form-control input-sm decimal" value="" placeholder="Auto-calculated">
										<input style="width: 120px;" type="hidden" name="txt_pro_id[]" class="form-control input-sm" value="<?php echo !empty($value['pro_id'])?$value['pro_id']:'' ?>" placeholder="Auto-calculated">
									</td>
									<td>
										
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
				<div style="text-align: right;padding-bottom: 10px;font-size: 16px;font-weight: 600;">
					Total Cost: $<span class="lb-total">0.00</span>
				</div>
			</div>
			<div class="form-actions right">
				<button style="min-width: 150px;" type="submit" class="btn default green">Place Order</button>
				<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Close</button>
			</div>
		</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var wapPaceOrder = $('.wap-place-order');
		var tbPlaceOrder = $("#tb-place-order");
		$(".decimal").inputmask('decimal',{rightAlign: true});
		tbPlaceOrder.DataTable({
			paging: false,
			ordering: false,
			bInfo : false,
			scrollX: true,
			scrollY: '345px',
			fixedHeader: true
		});
		var timeout;
		wapPaceOrder.on('keyup', 'input[name="txt_unit[]"]', function(event) {
			event.preventDefault();
			var _unit   = $(this);
			var valUnit = parseFloat(_unit.val());
			var valCost = parseFloat(_unit.attr('data-cost'));
			var valPer  = parseFloat(_unit.attr('data-per'));

			var valPrice = ((valUnit * valCost) / valPer).toFixed(2);

			var _price = _unit.parents('tr').find('input[name="txt_price[]"]');
			_price.val(valPrice);
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function(){
				totalPrice(wapPaceOrder);
			}, 500);
			
		});

		wapPaceOrder.on('change', 'input[name="txt_price[]"]', function(event) {
			totalPrice(wapPaceOrder);
		});

		$('#frm-place-order').submit(function(event) {
			/* Act on the event */
			Kiosk.blockUI();
		});
	});

	function totalPrice(wapPaceOrder){
		var sum = 0;
		$('input[name="txt_price[]"]', wapPaceOrder).each(function(){
			var val = this.value;
			if(typeof val === 'undefined' || val === null || val == '')
				val = 0;
		    sum += parseFloat(val);
		});
		$('.lb-total').text(sum.toFixed(2));
	}
</script>