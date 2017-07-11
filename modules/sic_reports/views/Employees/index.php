<div class="row">
	<?php echo $flag; ?>
	<form action="<?php echo url::base() ?>reports/employees/selct_range" method="POST">
		<div class="col-md-12 div-btn-top">
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
			<button type="button" class="btn default  btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports/today'">Sales Reports</button>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
			<button type="button" class="btn btn-primary btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports/employees/today'">Employees</button>
		</div>
		<div class="col-md-12 div-btn-top">
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/employees/today'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'today'): ?> green disables <?php endif; ?>">Today</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/employees/week'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'week'): ?> green disables <?php endif; ?>">This Week</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/employees/month'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'month'): ?> green disables <?php endif; ?>">This Month</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/employees/selct_range'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'selct_range'): ?> green disables <?php endif; ?>">Select Range</button>
		</div>
		<?php if($this->uri->segment(3) == 'selct_range'): ?>
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

<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							<strong>Daily Summary</strong>
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
											 Transations
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
							<div class="col-xs-12">
								<div class="caption_chart_report"><strong>Transaction Volume</strong></div>
								<div id="chart_transaction" class="chart" style="height: 500px;">
									
								</div>
							</div>
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
							<strong>Popular Products Today</strong>
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
							<div class="col-xs-12">
								<div class="caption_chart_report"><strong>Products Sold Today</strong></div>
								<div id="chart_product_sold" class="chart" style="height: 500px;">
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END CHARTS-->
			</div>
		</div>
	</div>
</div>