<style type="text/css" media="screen">
	#pie_chart {
  		width: 100%;
  		min-height: 406px;
  		font-size: 11px;
  		padding: 5px;
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
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_products'], 0, 1) == '0')){ ?>
	<div class="row">
		<div class="col-md-12 div-btn-top">
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
			<button type="button" class="btn default  btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports'">Sales Reports</button>
			<button type="button" class="btn btn-primary btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
			<!-- 
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php //echo url::base() ?>reports/employees/today'">Employees</button> -->
		</div>
	</div>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<form action="<?php echo url::base() ?>reports/products_services/selct_range" method="POST">
		<div class="col-md-12 div-btn-top">
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports'">Summary</button>
			<button type="button" class="btn default  btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/sales_reports'">Sales Reports</button>
			<button type="button" class="btn btn-primary btn-lg disables" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'">Products & Services</button>
			<!-- 
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>reports/customers/today'">Customers</button>
			<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php //echo url::base() ?>reports/employees/today'">Employees</button> -->
		</div>
		<div class="col-md-12 div-btn-top">
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/today'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'today'): ?> green disables <?php endif; ?>">Today</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/week'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'week'): ?> green disables <?php endif; ?>">This Week</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/month'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'month'): ?> green disables <?php endif; ?>">This Month</button>
			<button type="button" onclick="window.location.href='<?php echo url::base() ?>reports/products_services/selct_range'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'selct_range'): ?> green disables <?php endif; ?>">Select Range</button>
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
	<div class="col-md-5">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Products & Services Sales
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
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="height: 406px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-product-service" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th>
									Product name
								</th>
								<th>
									Quantity
								</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($listProduct)){ foreach ($listProduct as $key => $value) { ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td><?php echo $value; ?></td>
								</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Products Sold
				</div>
			</div>
			<div class="portlet-body rgba_white">
				<div id="site_activities_loading_pie">
					<img src="<?php echo $this->site['theme_url']?>layout/img/loading.gif" alt="loading"/>
				</div>
				<div id="pie_chart" class="pie_chart"></div>
			</div>
		</div>
	</div>
</div>
<?php } ?>