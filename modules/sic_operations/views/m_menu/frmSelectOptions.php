<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Option Connection'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-select-option" action="<?php echo url::base() ?>catalogs/saveSelectOption" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<div class="wap-item-add-inventory">
								<?php if(!empty($dataMenuOptions)): ?>
									<?php $arrParent = array(); ?>
									<?php foreach ($dataMenuOptions as $keyParent => $dataParent): ?>
										
											<div class="item-add">
												<div class="col-lg-4 in-group" style="overflow hidden;">
													<select name="slt_menu_option[]" class="form-control input-sm slt-sub-option" onchange="StandarItem.getItemOption(this)">
														<option value="0">Select Menu Options</option>
														<?php if(!empty($menuOptions)): ?>
															<?php foreach ($menuOptions as $key => $value): ?>
																<option <?php echo (!empty($value['sub_category_id']) && $value['sub_category_id'] == $keyParent)?"selected":'' ?> value="<?php echo !empty($value['sub_category_id'])?$value['sub_category_id']:'' ?>">
																	<?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?>
																</option>
															<?php endforeach ?>
														<?php endif ?>

													</select>
												</div>
												<div class="col-lg-5 in-group wap-item-options">
													<?php 
														$store_id    = base64_decode($this->sess_cus['storeId']);
														$idSubMenu   = $keyParent;
														$this->db->where('sub_category_id',$idSubMenu);
														$this->db->where('store_id',$store_id);
														$OptionsMenu = $this->db->get('menu')->result_array(false);
													?>
													<table>
														<tbody>
															<?php if(!empty($OptionsMenu)): ?>
																<?php foreach ($OptionsMenu as $key => $value): ?>
																	<tr>
																		<td>
																			<?php 
																				$vt = array_keys($dataParent['idMenu'], $value['menu_id']);
																				$vt = !empty($vt)?$vt[0]:-1;
																			?>
																			<input type="checkbox" <?php echo ($vt >= 0)?"checked":'' ?> name="txt_chk_menu[]" value="<?php echo !empty($value['menu_id'])?$value['menu_id']:'' ?>">
																			<?php echo !empty($value['m_item'])?$value['m_item']:'' ?>
																		</td>
																		<td style="width: 60%;"><input type="text" name="txt_price_menu[]" value="<?php echo ($vt >= 0)?number_format($dataParent['priceMenu'][$vt],2,'.',''):''  ?>" class="form-control input-sm decimal" placeholder="Price"></td>
																	</tr>
																<?php endforeach ?>
															<?php endif ?>
														</tbody>
													</table>
												</div>
												<div class="col-lg-2 in-group">
													<select name="slt_menu_option_type[]" class="form-control input-sm slt-sub-type">
														<option <?php echo (!empty($dataParent['typeMenu']) && $dataParent['typeMenu'] == 1)?'selected':'' ?> value="1">Single/Required</option>
														<option <?php echo (!empty($dataParent['typeMenu']) && $dataParent['typeMenu'] == 2)?'selected':'' ?> value="2">Single/Optional</option>
														<option <?php echo (!empty($dataParent['typeMenu']) && $dataParent['typeMenu'] == 3)?'selected':'' ?> value="3">Multiple/Required</option>
														<option <?php echo (!empty($dataParent['typeMenu']) && $dataParent['typeMenu'] == 4)?'selected':'' ?> value="4">Multiple/Optional</option>
													</select>
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
											<select name="slt_menu_option[]" class="form-control input-sm variable_priority slt-sub-option" onchange="StandarItem.getItemOption(this)">
												<option value="0">Select Menu Options</option>
												<?php if(!empty($menuOptions)): ?>
													<?php foreach ($menuOptions as $key => $value): ?>
														<option value="<?php echo !empty($value['sub_category_id'])?$value['sub_category_id']:'' ?>"><?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?></option>
													<?php endforeach ?>
												<?php endif ?>

											</select>
										</div>
										<div class="col-lg-5 in-group wap-item-options">
											
										</div>
										<div class="col-lg-2 in-group">
											<select name="slt_menu_option_type[]" class="form-control input-sm slt-sub-type">
												<option value="1">Single/Required</option>
												<option value="2">Single/Optional</option>
												<option value="3">Multiple/Required</option>
												<option value="4">Multiple/Optional</option>
											</select>
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
					<button onclick="StandarItem.addItemOption()" type="button" class="btn green"><i class="fa fa-plus"></i> Add Row</button>
				</div>
				<?php endif ?>
				<div class="form-actions right">
					<button onclick="StandarItem.saveItemOption()" style="min-width: 150px;" type="button" class="btn green btn-submit">Save</button>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<div class="item-add inventory-template">
	<div class="col-lg-4 in-group" style="overflow: hidden;">
		<select name="slt_menu_option[]" class="form-control input-sm slt_catalog" onchange="StandarItem.getItemOption(this)">
			<option value="0">Select Menu Options</option>
			<?php if(!empty($menuOptions)): ?>
				<?php foreach ($menuOptions as $key => $value): ?>
					<option value="<?php echo !empty($value['sub_category_id'])?$value['sub_category_id']:'' ?>"><?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?></option>
				<?php endforeach ?>
			<?php endif ?>

		</select>
	</div>
	<div class="col-lg-5 in-group wap-item-options">
		
	</div>
	<div class="col-lg-2 in-group">
		<select name="slt_menu_option_type[]" class="form-control input-sm slt_type">
			<option value="1">Single/Required</option>
			<option value="2">Single/Optional</option>
			<option value="3">Multiple/Required</option>
			<option value="4">Multiple/Optional</option>
		</select>
	</div>
	<div class="col-lg-1 in-group" style="text-align: right;">
		<a onclick="ComboSet.DeleteConnectItem(this)" href="javascript:;" class="btn btn-sm red">
			<i class="fa fa-times"></i>
		</a>
	</div>
</div>
