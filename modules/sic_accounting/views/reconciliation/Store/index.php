<style>
	.div-btn-top-custom button{
		min-width: 90px;
	}
	select[name="tb-store-accounting_length"]{
		margin-left: 5px !important;
	}
</style>
<form id="frm-accounting" action="<?php echo url::base() ?>accounting/reconciliations" method="POST">
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='<?php echo url::base() ?>accounting/reconciliations'">Reconciliation</button>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN CHARTS-->
				<div class="portlet solid grey-cararra bordered wap-warhouse-accounting">
					<div class="portlet-title">
						<div class="caption">
							Reconciliation
						</div>
						<div class="clearfix"></div>
						<div class="col-lg-4 col-sm-6" style="padding-left:0">
							<div>
								Date Filters
							</div>
							<div class="div-btn-top div-btn-top-custom" style="margin-top: 10px;">
								<button type="button" onclick="Store_Accounting.Date_Filter('today')" class="btn default btn-sm <?php if(!empty($dataFilter['typeDate']) && $dataFilter['typeDate'] == 'today'){ ?>green<?php } ?>">Today</button>
								<button type="button" onclick="Store_Accounting.Date_Filter('7day')" class="btn default btn-sm <?php if(!empty($dataFilter['typeDate']) && $dataFilter['typeDate'] == '7day'){ ?>green<?php } ?>">7 days</button>
								<button type="button" onclick="Store_Accounting.Date_Filter('30day')" class="btn default btn-sm <?php if(!empty($dataFilter['typeDate']) && $dataFilter['typeDate'] == '30day'){ ?>green<?php } ?>">30 days</button>
							</div>
							<div style="padding-bottom: 10px;overflow: hidden;">
								<div style="float: left;" class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
									<input  value="<?php echo !empty($dataFilter['dateFrom'])?date('m/d/Y',strtotime($dataFilter['dateFrom'])):''; ?>" type="text" class="form-control input-sm" name="txt_date_from" placeholder="Start">
									<span class="input-group-addon" style="line-height: 1;"> to </span>
									<input  value="<?php echo !empty($dataFilter['dateTo'])?date('m/d/Y',strtotime($dataFilter['dateTo'])):''; ?>" type="text" class="form-control input-sm" name="txt_date_to" placeholder="End">
								</div>
								<div style="float: left;">
									<button type="submit" class="btn green btn-sm">Apply</button>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-sm-6" style="padding-left:0">
							<div>
								Shift Filters
							</div>
							<div class="div-btn-top div-btn-top-custom" style="margin-top: 10px;">
								<button type="button" onclick="Store_Accounting.sFilter(1,'00:00|23:59')" class="btn btn-sm <?php if(!empty($dataFilter['typeFilter']) && $dataFilter['typeFilter'] == '1'){ ?>green<?php } ?>">Do not apply</button>
								<?php if(!empty($dataFilter['dataShifts'])): $slShifts = 1; ?>
									<?php foreach ($dataFilter['dataShifts'] as $shift_title => $shift): $slShifts++; ?>
										<button type="button" onclick="Store_Accounting.sFilter(<?php echo $slShifts ?>,'<?php echo $shift ?>')" class="btn btn-sm <?php if(!empty($dataFilter['typeFilter']) && $dataFilter['typeFilter'] == $slShifts){ ?>green<?php } ?>"><?php echo $shift_title ?></button>
									<?php endforeach ?>
								<?php endif ?>
							</div>
							<div style="padding-bottom: 10px;overflow: hidden;">
								<div style="float: left;" class="input-group input-medium in-group">
									<input value="<?php echo !empty($dataFilter['dateFrom'])?date('H:i',strtotime($dataFilter['dateFrom'])):''; ?>" type="text" class="form-control input-sm timepicker-24" name="txt_time_from" placeholder="Start">
									<span class="input-group-addon" style="line-height: 1;"> to </span>
									<input value="<?php echo !empty($dataFilter['dateTo'])?date('H:i',strtotime($dataFilter['dateTo'])):''; ?>" type="text" class="form-control input-sm timepicker-24" name="txt_time_to" placeholder="End">
								</div>
								<div style="float: left;">
									<button type="submit" class="btn green btn-sm">Apply</button>
									<button style="min-width: 90px;" type="button" class="btn green btn-sm btn-shifts">Edit Shifts</button>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-12" style="padding-left:0">
							<div style="text-align: right;">
								<?php 
								$role = $this->mPrivileges;
								if($role == 'FullAccess' || (is_array($role) && substr($role['acc_recon'], -1) == '1')): ?>
									<div class="btn-group">
										<button type="button" class="btn btn-fit-height btn-sm" data-toggle="dropdown" data-delay="1000" data-close-others="true">
										Export Report <i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right" role="menu">
											<!-- <li>
												<a href="javascript:void(0)" class="category-delete"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a>
											</li> -->
											<li>
												<a href="javascript:void(0)" class="category-csv" ><i class="fa fa-file-excel-o"></i>&nbsp;Export to CSV</a>
											</li>
											<!-- <li>
												<a href="javascript:void(0)" class="category-html" ><i class="fa fa-file-code-o"></i>&nbsp;HTML</a>
											</li> -->
										</ul>
									</div>
									<br>
								<?php endif ?>	
								<span style="display: inline-block;position: relative;top: 5px;">Show: </span>
								<div class="btn-group" style="margin-top: 10px;">
									<select id="slt_store_active" name="slt_store_active" class="form-control input-sm" style="width:100%">
										<?php if(!$dataFilter['storeOnly']){ ?>
											<option value="warehouse" <?php echo (!empty($dataFilter['storeActive']) && $dataFilter['storeActive'] == 'warehouse')?'selected':'' ?> >Warehouse</option>
										<?php } ?>
										<?php if(!empty($listStore)): ?>
											<?php foreach ($listStore as $LStore): ?>
												<option <?php echo (!empty($dataFilter['storeActive']) && $dataFilter['storeActive'] == $LStore['store_id'])?'selected':'' ?>  value="<?php echo $LStore['store_id'] ?>"><?php echo $LStore['store']; ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-sm-12" style="padding-left:0">
							<div class="div-btn-top" style="margin-top: 10px;">
								<button type="button" onclick="Store_Accounting.whType('purchases')" class="btn btn-sm <?php if(!empty($dataFilter['typedetail']) && $dataFilter['typedetail'] == 'purchases'){ ?>green<?php } ?>">Purchases</button>
								<button type="button" onclick="Store_Accounting.whType('item_sold')" class="btn btn-sm <?php if(!empty($dataFilter['typedetail']) && $dataFilter['typedetail'] == 'item_sold'){ ?>green<?php } ?>">Items Sold</button>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="portlet-body" style="background-color: #ffffff;">
						<?php if(!empty($dataFilter['typedetail']) && $dataFilter['typedetail'] != 'item_sold'){ ?>
							<div class="row">
								<div class="col-lg-7">
									<p style="line-height: 28px;font-weight: 600; margin:5px;">
										Inventory items purchased:
									</p>
								</div>
								<?php if($role == 'FullAccess' || (is_array($role) && substr($role['acc_recon'], -1) == '1')): ?>
								<div class="col-lg-5 cls-right">
									<button style="margin:5px;" type="button" data-val="store" class="btn btn-sm green btn-adjustment">Enter Adjustment</button>
								</div>
								<?php endif ?>
							</div>
							<div class="table-datatable filter-hidden" style="position: relative;">
								<table class="table table-striped table-bordered table-nobordered table-hover" id="tb-store-accounting" width="100%" style="margin: auto auto auto 0;">
									<thead>
										<tr>
											<th class="cls-center">Time</th>
											<th class="cls-center">Date</th>
											<th class="cls-center">Category</th>
											<th class="cls-center">Item</th>
											<th class="cls-center">SKU#</th>
											<th class="cls-center">Quantity</th>
											<th class="cls-center">Ordered From</th>
											<th class="cls-center">Payment Made</th>
										</tr>
									</thead>
									<tbody>
										<?php $_total = 0; ?>
										<?php if(!empty($dataAdjustment)): ?>
											<?php foreach ($dataAdjustment as $key => $value): ?>
												<?php $_total += !empty($value['amount'])?($value['amount']):0; ?>
												<tr>
													<td class="cls-center">
														<?php echo !empty($value['regidate'])?date('H:i:s', strtotime($value['regidate'])):'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['regidate'])?date('m/d/Y', strtotime($value['regidate'])):'' ?>
													</td>
													<td class="cls-center">
														Adjustment
													</td>
													<td class="cls-center">
														<?php echo !empty($value['note'])?'Adjustment Notes: '.$value['note'].' / ':'' ?>
														<?php echo !empty($value['num'])?'Adjustment Ref#: '.$value['num']:'' ?>
													</td>
													<td class="cls-center">
														--
													</td>
													<td class="cls-center">
														--
													</td>
													<td class="cls-center">
														--
													</td>
													<td class="cls-center">
														$<?php echo !empty($value['amount'])?number_format($value['amount'],2,'.',''):'0.00' ?>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										<?php if(!empty($dataOrder)): ?>
											<?php foreach ($dataOrder as $key => $value): ?>
												<?php $_total += !empty($value['store_price'])?$value['store_price']:0; ?>
												<tr>
													<td class="cls-center">
														<?php echo !empty($value['date_mark_complete'])?date('H:i:s', strtotime($value['date_mark_complete'])):'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['date_mark_complete'])?date('m/d/Y', strtotime($value['date_mark_complete'])):'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['pro_name'])?$value['pro_name']:'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['pro_no'])?$value['pro_no']:'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['store_unit'])?$value['store_unit']:'' ?><?php echo !empty($value['pro_unit'])?' '.$value['pro_unit']:'' ?>
													</td>
													<td class="cls-center">
														<?php echo !empty($value['store_order_from'])?$value['store_order_from']:'' ?>
													</td>
													<td class="cls-center">
														$<?php echo !empty($value['store_price'])?number_format($value['store_price'],2,'.',''):'0.00' ?>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
									<tfoot>
							            <tr>
							                <th colspan="7" style="text-align:right">Total Payment Made:</th>
							                <th class="cls-center">
							                	$<?php echo !empty($_total)?number_format($_total,2,'.',''):'0.00' ?>
							                </th>
							            </tr>
							        </tfoot>
								</table>
							</div>
						<?php }else{ ?>
							<div class="row">
								<div class="col-lg-6">
									<p style="line-height: 28px;font-weight: 600; margin:5px;display: inline-block;">
										Menu Item sold:
									</p>
									<button type="button" onclick="Store_Accounting.TypeItemSold(1)" class="btn btn-sm <?php if(!empty($dataFilter['typeItemSold']) && $dataFilter['typeItemSold'] == '1'){ ?>green<?php } ?>" >Show categories</button>
									<button type="button" onclick="Store_Accounting.TypeItemSold(2)" class="btn btn-sm <?php if(!empty($dataFilter['typeItemSold']) && $dataFilter['typeItemSold'] == '2'){ ?>green<?php } ?>" >Show item</button>
								</div>
								<?php if($role == 'FullAccess' || (is_array($role) && substr($role['acc_recon'], -1) == '1')): ?>
								<div class="col-lg-6 cls-right">
									<button style="margin:5px;" type="button" data-val="itemsold" class="btn btn-sm green btn-adjustment">Enter Adjustment</button>
								</div>
								<?php endif ?>
							</div>
							<div class="clearfix"></div>
							<div class="table-datatable filter-hidden" style="position: relative;">
								<table class="table table-striped table-bordered table-nobordered table-hover" id="tb-store-accounting" width="100%" style="margin: auto auto auto 0;">
									<thead>
										<tr>
											<th class="cls-center">Menu Category</th>
											<th class="cls-center">Total Sales</th>
										</tr>
									</thead>
									<tbody>
										<?php $_total = 0; ?>
										<?php if(!empty($dataAdjustment)): ?>
											<?php foreach ($dataAdjustment as $key => $value): ?>
												<?php $_total += !empty($value['amount'])?($value['amount']):0; ?>
												<tr>
													<td class="cls-center">
														Adjustment
													</td>
													<td class="cls-center">
														$<?php echo !empty($value['amount'])?number_format($value['amount'],2,'.',''):'0.00' ?>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										<?php if(!empty($dataOrder)): ?>
											<?php foreach ($dataOrder as $key => $value): ?>
												<?php $_total += !empty($value)?$value:0; ?>
												<tr>
													<td class="cls-center">
														<?php echo !empty($key)?$key:'' ?>
													</td>
													<td class="cls-center">
														$<?php echo !empty($value)?number_format($value,2,'.',''):'0.00' ?>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
									<tfoot>
							            <tr>
							                <th style="text-align:right">Total Sales (does not include tax or tip):</th>
							                <th class="cls-center">
							                	$<?php echo !empty($_total)?number_format($_total,2,'.',''):'0.00' ?>
							                </th>
							            </tr>
							        </tfoot>
								</table>
							</div>
						<?php } ?>
					</div>
				</div>
				<!-- END CHARTS-->
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="date_filter" name="date_filter" value="<?php echo !empty($dataFilter['typeDate'])?$dataFilter['typeDate']:'today' ?>">
<input type="hidden" id="shift_filter" name="shift_filter" value="<?php echo !empty($dataFilter['typeFilter'])?$dataFilter['typeFilter']:1 ?>">
<input type="hidden" id="type_warehouse" name="type_warehouse" value="<?php echo !empty($dataFilter['typedetail'])?$dataFilter['typedetail']:'today' ?>">
<input type="hidden" id="type_item_sold" name="type_item_sold" value="<?php echo !empty($dataFilter['typeItemSold'])?$dataFilter['typeItemSold']:'1' ?>">
</form>