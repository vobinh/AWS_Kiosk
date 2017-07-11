<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
?>
<form id="frm-home" action="<?php echo url::base() ?>home" method="post" accept-charset="utf-8">
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="cls-filter btn <?php echo (!empty($listData['type']) && $listData['type'] == 'today')?'btn-primary':'default' ?> btn-lg cls-filter-today" data-value="today">Today</button>
		<button type="button" class="cls-filter btn <?php echo (!empty($listData['type']) && $listData['type'] == 'week')?'btn-primary':'default' ?> btn-lg cls-filter-week" data-value="week">This Week</button>
		<button type="button" class="cls-filter btn <?php echo (!empty($listData['type']) && $listData['type'] == 'month')?'btn-primary':'default' ?> btn-lg cls-filter-month" data-value="month">This Month</button>
		<button type="button" class="cls-filter btn <?php echo (!empty($listData['type']) && $listData['type'] == 'range')?'btn-primary':'default' ?> btn-lg cls-filter-range" data-value="range">Select Range</button>
	</div>
	<div class="col-md-12 cls-range" style="padding-bottom: 10px;overflow: hidden; <?php echo (!empty($listData['type']) && $listData['type'] != 'range')?'display:none;':'' ?>">
		<div style="float: left;" class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
			<input type="text" class="form-control input-sm" name="txt_date_from" value="<?php echo !empty($listData['dateFrom'])?$listData['dateFrom']:date('m/d/Y') ?>" placeholder="Start">
			<span class="input-group-addon" style="line-height: 1;"> to </span>
			<input type="text" class="form-control input-sm" name="txt_date_to" value="<?php echo !empty($listData['dateTo'])?$listData['dateTo']:date('m/d/Y') ?>" placeholder="End">
		</div>
		<div style="float: left;">
			<input type="hidden" id="txt_hd_type" name="txt_type" value="<?php echo !empty($listData['type'])?$listData['type']:'today' ?>">
			<button type="submit" class="btn green btn-sm">Apply</button>
		</div>
	</div>
</div>
<?php //echo kohana::Debug($this->sess_cus); ?>
<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN CHARTS-->
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Store Summary
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
						<!-- Chart 1 -->
						<div class="portlet solid rgba_white">
							<div class="portlet-title">
								<div class="caption caption-16">
									Gross Volume
								</div>
								<div class="actions">
									<div class="pull-right caption">
										$ <?php echo !empty($listData['totalSales'])?number_format($listData['totalSales'],2,'.',''):'0.00'; ?>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div id="site_activities_loading">
									<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
								</div>
								<div id="site_activities_content" class="display-none">
									<div id="site_activities" class="site_activities" style="height: 228px;">
									</div>
								</div>
							</div>
						</div>
						<!-- End Chart 1 -->
						<!-- Chart 2 -->
						<div class="portlet solid rgba_white">
							<div class="portlet-title">
								<div class="caption caption-16">
									Transactions
								</div>
								<div class="actions">
									<div class="pull-right caption">
										<?php echo !empty($listData['transations'])?$listData['transations']:'0'; ?> Transactions
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div id="site_activities_loading_2">
									<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
								</div>
								<div id="site_activities_content_2" class="display-none">
									<div id="site_activities_2" class="site_activities" style="height: 228px;">
									</div>
								</div>
							</div>
						</div>
						<!-- End Chart 2 -->
						<!-- Chart 3 -->
						<div class="portlet solid rgba_white">
							<div class="portlet-title">
								<div class="caption caption-16">
									Customers Created
								</div>
								<div class="actions">
									<div class="pull-right caption">
										<?php echo !empty($listData['totalUser'])?$listData['totalUser']:'0'; ?> Customres 
									</div> 
								</div>
							</div>
							<div class="portlet-body">
								<div id="site_activities_loading_3">
									<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
								</div>
								<div id="site_activities_content_3" class="display-none">
									<div id="site_activities_3" class="site_activities" style="height: 228px;">
									</div>
								</div>
							</div>
						</div>
						<!-- End Chart 3 -->
					</div>
				</div>
				<!-- END CHARTS-->
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Sales Summary
						</div>
						<?php /* ?>
						<div class="actions" style="padding-bottom: 0px;">
							<div class="pull-right">
								<select class="bs-select btn-group-sm" data-width="150px" id="slt_employees">
									<option>All Employees</option>
									<option>Join Smith</option>
									<option>Dwight Schrute</option>
									<option>Jim Halpert</option>
									<option>Pam Beasley</option>
								</select>
							</div>
						</div>
						<?php */ ?>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											Cash Sales
										</div>
										<div class="number">
											 $ <?php echo !empty($listData['totalCash'])?number_format($listData['totalCash'],2,'.',''):'0.00'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											Card Sales
										</div>
										<div class="number">
											$ <?php echo !empty($listData['totalCard'])?number_format($listData['totalCard'],2,'.',''):'0.00'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											Point Sales
										</div>
										<div class="number">
											 $ <?php echo !empty($listData['totalPoint'])?number_format($listData['totalPoint'],2,'.',''):'0.00'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											 Transactions
										</div>
										<div class="number">
											<?php echo !empty($listData['transations'])?$listData['transations']:'0'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											 Total Sales
										</div>
										<div class="number">
											 $ <?php echo !empty($listData['totalSales'])?number_format($listData['totalSales'],2,'.',''):'0.00'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											 Sales Tax Total
										</div>
										<div class="number">
											 $ <?php echo !empty($listData['totalTax'])?number_format($listData['totalTax'],2,'.',''):'0.00'; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											New Customers
										</div>
										<div class="number">
											<?php echo !empty($listData['totalUser'])?$listData['totalUser']:'0'; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php /* ?>
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Inventory Summary
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											Low Stock Items
										</div>
										<div class="number">
											1
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="dashboard-stat dashboard-stat-white">
									<div class="visual">
										<i class="fa fa-bar-chart-o"></i>
									</div>
									<div class="details">
										<div class="desc">
											Out of Stock Items
										</div>
										<div class="number">
											2
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php */ ?>
		</div>
	</div>
</div>
</form>