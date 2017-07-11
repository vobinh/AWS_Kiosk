<select name="slt_store_active" id="slt_store_active" class="form-control input-sm" style="width:100%">
<?php if(!empty($listStore)): ?>
	<?php foreach ($listStore as $key => $value): ?>
		<?php if(!empty($value['store'])): ?>
			<option <?php if(!empty($storeUsing) && $storeUsing == $value['store_id']){ echo 'selected'; }  ?> value="<?php echo !empty($value['store_id'])?$value['store_id']:'' ?>"><?php echo !empty($value['store'])?$value['store'].' ':'' ?></option>
		<?php else: ?>
		    <option <?php if(!empty($storeUsing) && $storeUsing == $value['store_id']){ echo 'selected'; }  ?> value="<?php echo !empty($value['store_id'])?$value['store_id']:'' ?>"><?php echo !empty($value['s_first'])?$value['s_first'].' ':'' ?><?php echo !empty($value['s_last'])?$value['s_last']:'' ?></option>
		<?php endif ?>
	<?php endforeach ?>
<?php else: ?>
	<option  value="">Please select store</option>
<?php endif ?>
</select>