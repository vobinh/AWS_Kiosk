<style type="text/css">
	.wap-customers .dataTables_scroll{
		margin-bottom: 0px;
	}
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
?>
<div class="row">
	<form action="<?php echo url::base() ?>reports/customers/select_range" method="POST">
		<div class="col-md-12 div-btn-top">
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
			<button type="button" class="btn default  btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports/today'">Sales Reports</button>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
			<button type="button" class="btn btn-primary btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
			<?php /* ?>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/employees/today'">Employees</button>
			<?php */ ?>
		</div>
		<div class="col-md-12 div-btn-top">
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'today'): ?> green disables <?php endif; ?>">Today</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/customers/week'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'week'): ?> green disables <?php endif; ?>">This Week</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/customers/month'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'month'): ?> green disables <?php endif; ?>">This Month</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/customers/select_range'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'select_range'): ?> green disables <?php endif; ?>">Select Range</button>
		</div>
		<?php if($this->uri->segment(3) == 'select_range'): ?>
			<div class="col-md-12" style="padding-bottom: 10px;overflow: hidden;">
				<div style="float: left;" class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
					<input value="<?php echo !empty($txt_date_from)?$txt_date_from:''; ?>" type="text" class="form-control input-sm" name="txt_date_from" placeholder="Start">
					<span class="input-group-addon" style="line-height: 1;"> to </span>
					<input value="<?php echo !empty($txt_date_to)?$txt_date_to:''; ?>" type="text" class="form-control input-sm" name="txt_date_to" placeholder="End">
				</div>
				<div style="float: left;">
					<button type="submit" class="btn green btn-sm">Apply</button>
				</div>
			</div>
		<?php endif; ?>
	</form>
</div>

<div class="row wap-customers">
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Customers
						</div>
						<?php if((string)$_storeId == '0'): ?>
							<div class="actions">
								<div class="caption">
									<span>Store</span>
									<div class="btn-group">
										<select name="slt_store_active" id="slt_store_active" class="form-control input-sm" style="width:100%">
										<?php if(!empty($listStore)): ?>
											<?php foreach ($listStore as $key => $value): ?>
												<option <?php if(!empty($storeUsing) && $storeUsing == $value['store_id']){ echo 'selected'; }  ?> value="<?php echo !empty($value['store_id'])?$value['store_id']:'' ?>"><?php echo !empty($value['s_first'])?$value['s_first'].' ':'' ?><?php echo !empty($value['s_last'])?$value['s_last']:'' ?></option>
											<?php endforeach ?>
										<?php else: ?>
											<option  value="">Please select store</option>
										<?php endif ?>
										</select>
									</div>
								</div>
							</div>
						<?php endif ?>
					</div>
					<div class="portlet-body rgba_white">
						<div class="table-responsive table-datatable filter-hidden" style="height: 406px;position: relative;">
							<table class="table table-striped table-hover table-advance-th" id="tb-customers" width="100%" style="margin: auto auto auto 0;">
								<thead>
									<tr>
										<th>
											Name
										</th>
										<th>
											Total Orders
										</th>
										<th>
											Total Prices
										</th>
										<th>
											
										</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($listData)){ 
										foreach ($listData as $key => $value) { ?>
											<tr>
												<td class="slt-row cls-cus-name" data-value="<?php echo !empty($value['account_first_name'])?$value['account_first_name'].' ':''; ?><?php echo !empty($value['name'])?$value['name']:''; ?>">
													<?php echo !empty($value['account_first_name'])?$value['account_first_name'].' ':''; ?><?php echo !empty($value['name'])?$value['name']:''; ?>
												</td>
												<td class="slt-row">
													<?php echo !empty($value['sl'])?$value['sl']:0; ?>
												</td>
												<td class="slt-row">
													$<?php echo !empty($value['amount'])?number_format($value['amount'],2,'.',''):'0.00'; ?>
												</td>
												<td style="text-align: right;">
													<button type="button" class="btn default btn-sm green" onclick="listCustomers.detail('<?php echo $value['user_id'] ?>',$(this))">Detail</button>
												</td>
											</tr>
									<?php }} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN CHARTS-->
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Sales Customers
						</div>
					</div>
					<div class="portlet-body rgba_white">
						<div id="chartCustomers" style="min-height: 405px;padding: 5px;">
							
						</div>
					</div>
				</div>
				<!-- END CHARTS-->
			</div>
		</div>
	</div>
</div>