<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>
				Name
			</th>
			<th>
				Quantity
			</th>
			<th>
				Prices
			</th>
		</tr>
	</thead>
<tbody>
		<?php
			if(!empty($listData)){ 
				foreach ($listData as $key => $value) { ?>
				<tr>
					<td>
						<?php echo $key ?>
					</td>
					<td>
						<?php echo !empty($value['quantity'])?$value['quantity']:0 ?>
					</td>
					<td>
						$<?php echo !empty($value['price'])?number_format($value['price'],2,'.',''):'0.00' ?>
					</td>
				</tr>
			<?php }} ?>
			<?php if(empty($type)): ?>
			<tr>
				<td colspan="2" >Tax:</td>
				<td ><?php echo !empty($mainTax)?$mainTax:'$0.00' ?></td>
			</tr>
			<tr>
				<td colspan="2" >Total:</td>
				<td ><?php echo !empty($mainTotal)?$mainTotal:'$0.00' ?></td>
			</tr>
			<?php endif ?>
	</tbody>
</table>