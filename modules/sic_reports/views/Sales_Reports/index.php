<style type="text/css">
	.div-group-filter{
	    padding: 5px 0;
	    border: 1px solid #9E9E9E;
	    border-radius: 6px !important;
	    overflow: auto;
	    height: 103px;
	    margin-bottom: 10px;
	}
	.div-group-filter tr:nth-child(even) {background-color: #f2f2f2}
	.cls-datatable .table-nobordered{ border: none; margin-top: 0px !important; }
	.cls-datatable .table-scrollable{ border-bottom: none; }
	.cls-datatable .dataTables_scroll{ margin-bottom: 0px; }
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
		<button type="button" class="btn btn-primary  btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports'">Sales Reports</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
	 	<!--
	 	<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
		
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php //echo url::base() ?>reports/employees/today'">Employees</button> -->
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_sales'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<form id="frm-saler-report" action="<?php echo url::base() ?>reports/sales_reports" method="POST">
		<div class="col-md-12">
			<div class="portlet solid grey-cararra bordered">
				<div class="portlet-title">
					<div class="caption">
						Sales Reports
					</div>
					<?php if((string)$_storeId == '0'): ?>
						<div class="actions">
							<div class="caption">
								<span>Store</span>
								<div class="btn-group">
									<?php 
										include_once Kohana::find_file('views/include','inSelectStore');
									 ?>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12 div-btn-top">
							<?php 
								$_flag1 = $_flag2 = $_flag3 = $_flag4= $_flag5 = $_flag6 = $_flag7 = false;
								$usingDateSelect = !empty($listDataFilter['usingDateSelect'])?$listDataFilter['usingDateSelect']:'7-days';
								switch ($usingDateSelect) {
									case '14-days':
										$_flag2 = true;
										break;
									case '30-days':
										$_flag3 = true;
										break;
									case '6-months':
										$_flag4 = true;
										break;
									case 'week-to-date':
										$_flag5 = true;
										break;
									case 'month-to-date':
										$_flag6 = true;
										break;
									case 'year-to-date':
										$_flag7 = true;
										break;
									default:
										$_flag1 = true;
										break;
								}
							 ?>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag1)?'green disables':'' ?>" data-date="7-days">7 days</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag2)?'green disables':'' ?>" data-date="14-days">14 days</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag3)?'green disables':'' ?>" data-date="30-days">30 days</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag4)?'green disables':'' ?>" data-date="6-months">6 months</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag5)?'green disables':'' ?>" data-date="week-to-date">Week-to-date</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag6)?'green disables':'' ?>" data-date="month-to-date">Month-to-date</button>
							<button type="button" class="btn default btn-sm btn-day <?php echo ($_flag7)?'green disables':'' ?>" data-date="year-to-date">Year-to-date</button>
						</div>
						<div class="col-md-12" style="padding-bottom: 10px;overflow: hidden;">
							<div style="float: left;" class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
								<input value="<?php echo !empty($listDataFilter['dateFrom'])?$listDataFilter['dateFrom']:''; ?>" type="text" class="form-control input-sm" name="txt_date_from" placeholder="Start">
								<span class="input-group-addon" style="line-height: 1;"> to </span>
								<input value="<?php echo !empty($listDataFilter['dateTo'])?$listDataFilter['dateTo']:''; ?>" type="text" class="form-control input-sm" name="txt_date_to" placeholder="End">
							</div>
							<div style="float: left;">
								<button type="button" class="btn green btn-sm btn-submit">Apply</button>
							</div>
						</div>
						<div class="col-md-12">
							<div class="portlet solid rgba_white">
								<div class="portlet-title">
									<div class="caption caption-16">
										Filters
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<!-- ft employees -->
										<?php 
											//include_once('includeFilter/include_ftEmployees.php');
										 ?>
										
										<!-- ft customers -->
										<?php 
											//include_once('includeFilter/include_ftCustomers.php');
										 ?>

										<div class="col-lg-3 col-md-6"> 
											<input type="checkbox" name="txt_filter_payment" id="txt_filter_payment" value=""> By Payment Method
											<div class="div-group-filter">
												<table width="100%">
													<tr>
														<td>
															<input type="checkbox" <?php echo (!empty($listData['usingPayment']) && in_array('cash', $listData['usingPayment']))?'checked':'' ?> class="txt_payment" name="txt_payment[]" value="cash"> Cash
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" <?php echo (!empty($listData['usingPayment']) && in_array('card', $listData['usingPayment']))?'checked':'' ?> class="txt_payment" name="txt_payment[]" value="card"> Credit / Debit
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" <?php echo (!empty($listData['usingPayment']) && in_array('points', $listData['usingPayment']))?'checked':'' ?> class="txt_payment" name="txt_payment[]" value="points"> Point/ Store Credit
														</td>
													</tr>
													<!-- <tr>
														<td>
															<input type="checkbox" <?php //echo (!empty($listData['usingPayment']) && in_array('other', $listData['usingPayment']))?'checked':'' ?> class="txt_payment" name="txt_payment[]" value="other"> Other
														</td>
													</tr> -->
												</table>
											</div>
										</div>
										<div class="col-lg-3 col-md-6">
											List items by
											<div class="div-group-filter">
												<table width="100%">
													<tr>
														<td>
															<input style="margin-left: -10px;" type="radio" class="txt_list_inventory" <?php echo (!empty($listData['usingType']) && $listData['usingType'] == 1)?'checked':'' ?> name="txt_name_type" value="1"> Categories
														</td>
													</tr>
													<tr>
														<td>
															<input style="margin-left: -10px;" type="radio" class="txt_list_menu" <?php echo (!empty($listData['usingType']) && $listData['usingType'] == 2)?'checked':'' ?> name="txt_name_type" value="2"> Individual item
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<div class="clo-md-12" style="text-align: right;">
										<input type="hidden" name="txt_hd_type" value="<?php echo !empty($listDataFilter['usingDateType'])?$listDataFilter['usingDateType']:'day'; ?>">
										<input type="hidden" name="txt_hd_date" value="<?php echo !empty($listDataFilter['usingDateSelect'])?$listDataFilter['usingDateSelect']:'7-days'; ?>">
										<button type="button" style="width: 120px;" class="btn green btn-sm btn-submit">Apply</button>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="portlet solid rgba_white">
								<div class="portlet-title">
									<div class="caption caption-16">
										Sales Reports
									</div>
									<div class="actions">
										<div class="caption">
											<div class="btn-group">
												<button type="button" id="btnShowData" class="btn btn-sm green">Table</button>
												<button type="button" id="btnShowChart" class="btn btn-sm default">Graph</button>
											</div>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<!-- Revenue -->
										<?php 
											include_once('includeTable/include_tbRevenue.php');
										 ?>

										<!-- Cost -->
										<?php 
											//include_once('includeTable/include_tbCost.php');
										 ?>

										<!-- Discounts / Compensations -->
										<?php 
											//include_once('includeTable/include_tbDiscounts.php');
										 ?>

										<!-- Net Profit -->
										<?php 
											//include_once('includeTable/include_tbNetProfit.php');
										 ?>

										<!-- Net Profit -->
										<?php 
											include_once('includeTable/include_tbTax.php');
										 ?>		
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="portlet solid rgba_white">
								<div class="portlet-title">
									<div class="caption caption-16">
										Transaction History
									</div>
								</div>
								<div class="portlet-body">
									<div class="row">
										<!-- Transations -->
										<div class="col-md-12 cls-datatable">
											<!-- <div class="table-responsive"> -->
												<table id="tb-transations" class="table table-striped table-bordered table-nobordered table-hover" width="100%" style="margin: auto auto auto 0;">
													<thead>
														<tr>
															<th class="cls-center">Date</th>
															<th class="cls-center">Time</th>
															<th class="cls-center">Transaction ID</th>
															<th class="cls-center">Sold by</th>
															<th class="cls-center">Tax</th>
															<!-- <th class="cls-center">Tip</th> -->
															<th class="cls-center">Transaction Amount</th>
															<th class="cls-center">Detail</th>
														</tr>
													</thead>
													<tbody>
													<?php if(!empty($listData['usingOrder'])): ?>
														<?php foreach ($listData['usingOrder'] as $key => $value): ?>
															<tr id="<?php echo $value['order_id'] ?>">
																<td class="cls-center">
																	<?php echo date('m/d/Y', strtotime($value['regidate'])) ?>
																</td>
																<td class="cls-center">
																	<?php echo date('H:i', strtotime($value['regidate'])) ?>
																</td>
																<td class="cls-center">
																	<?php echo $value['order_id'] ?>
																</td>
																<td class="cls-center">
																	<?php echo $value['nameAccount'] ?>
																</td>
																<td class="cls-center">
																	$<?php echo number_format($value['tax'], 2, '.', '') ?>
																</td>
																<!-- <td class="cls-center"></td> -->
																<td class="cls-center">
																	$<?php echo number_format($value['amount'], 2, '.', '') ?>
																</td>
																<td class="details-control cls-center">
																	<button type="button" type="button" class="btn default btn-sm green">Detail</button>
																</td>
															</tr>
														<?php endforeach ?>
													<?php endif ?>
													</tbody>
												</table>
											<!-- </div> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php } ?>