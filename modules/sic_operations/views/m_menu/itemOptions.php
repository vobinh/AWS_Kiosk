<table>
	<tbody>
		<?php if(!empty($OptionsMenu)): ?>
			<?php foreach ($OptionsMenu as $key => $value): ?>
				<tr>
					<td><input type="checkbox" name="txt_chk_menu[]" value="<?php echo !empty($value['menu_id'])?$value['menu_id']:'' ?>"><?php echo !empty($value['m_item'])?$value['m_item']:'' ?></td>
					<td style="width: 60%;"><input type="text" name="txt_price_menu[]" value="" class="form-control input-sm decimal" placeholder="Price"></td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>