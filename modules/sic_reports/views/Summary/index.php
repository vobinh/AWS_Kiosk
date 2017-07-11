<style type="text/css" media="screen">
	#pie_chart {
  		width: 100%;
  		min-height: 333px;
  		font-size: 11px;
	}

	.amcharts-pie-slice {
		transform: scale(1);
		transform-origin: 50% 50%;
		transition-duration: 0.3s;
		transition: all .3s ease-out;
		-webkit-transition: all .3s ease-out;
		-moz-transition: all .3s ease-out;
		-o-transition: all .3s ease-out;
		cursor: pointer;
		box-shadow: 0 0 30px 0 #000;
	}

	.amcharts-pie-slice:hover {
		transform: scale(1.1);
		filter: url(#shadow);
	}	
</style>
<?php 
	$storeUsing = $this->_getStoreUsing();
	$_storeId   = base64_decode($this->sess_cus['storeId']);
?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports'">Sales Reports</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
		<?php /* ?>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
		
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/employees/today'">Employees</button>
		<?php */ ?>
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_summary'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption">
							Daily Summary
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
								<div class="portlet solid rgba_white">
									<div class="portlet-title">
										<div class="caption caption-16">
											Transaction Volume
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
							Popular Products Today
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<?php if(!empty($listProducst)): ?>
								<?php foreach ($listProducst as $key => $value): ?>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="dashboard-stat dashboard-stat-white">
											<div class="visual">
												<i class="fa fa-bar-chart-o"></i>
											</div>
											<div class="details">
												<div class="desc">
													<?php echo $key ?>
												</div>
												<div class="number">
													<?php echo $value ?>
												</div>
											</div>
										</div>
									</div>
									<?php if($key == 5){
										//break;
									} ?>
								<?php endforeach ?>
							<?php endif ?>
							<div class="col-xs-12">
								<div class="portlet solid rgba_white">
									<div class="portlet-title">
										<div class="caption caption-16">
											Products Sold Today
										</div>
									</div>
									<div id="site_activities_loading_pie">
										<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
									</div>
									<div class="portlet-body">
										<div id="pie_chart" class="pie_chart"></div>
									</div>
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
<?php } ?>