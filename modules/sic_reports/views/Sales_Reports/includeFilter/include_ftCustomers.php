<div class="col-lg-3 col-md-6">
	<input type="checkbox" name="txt_filter_customers" id="txt_filter_customers" value=""> Sold by (customers)
	<div class="div-group-filter">
		<table width="100%">
		<?php if(!empty($listData['listCustomers'])): ?>

			<?php foreach ($listData['listCustomers'] as $key => $itemCus): ?>
				<tr>
					<td>
						<input type="checkbox" <?php echo (!empty($listData['usingCustomers']) && in_array($itemCus['user_id'], $listData['usingCustomers']))?'checked':'' ?> class="txt_customer" name="txt_customer[]" value="<?php echo $itemCus['user_id'] ?>"> <?php echo trim($itemCus['account_first_name'].' '.$itemCus['name']) ?>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
		</table>
	</div>
</div>