<style type="text/css" media="screen">
	.dataTables_scroll{
		margin-bottom: 0px !important;
	}
	#tb-timecard tbody td, #tb-timecard_wrapper th{
		text-align: center;
		vertical-align: middle;
	}
</style>
<?php $storeUsing = $this->_getStoreUsing(); ?>
<?php $role = $this->mPrivileges; ?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees'">Employees</button>
		<?php 
			$_storeId = base64_decode($this->sess_cus['storeId']);
		?>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees/listScheduling'">Scheduling</button>
		<button type="button" class="btn btn-primary btn-lg"  disabled>Time Card</button>
		<?php //endif ?>

	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_timecard'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-timecard">
			<form id="frm-timecard" action="<?php echo url::base() ?>employees/listTimeCard/<?php echo $this->uri->segment(3); ?>" method="POST">
				<div class="portlet-title" style="overflow: hidden;padding-top: 15px;">
					<div style="padding-left: 0px;" class="caption col-lg-9 col-md-9 col-xs-12">
						<span style="font-size: 18px;">Time Card</span>
						<div style="font-size:13px;">
							Below is a summary of hours recorded by employees using the mobile / touch interface. The hours can also be manually recorded / modified from this page, by clicking on the time slot or the 'add' button for the corresponding employee.
						</div>
					</div>
					<?php if((string)$_storeId == '0'): ?>
						<div class="actions col-lg-3 col-md-3 col-xs-12" style="text-align:right">
							<div class="caption">
								<span>Store</span>
								<div class="btn-group">
									<?php include_once Kohana::find_file('views/include','inSelectStore'); ?>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
				<div class="row" style="margin-bottom: 5px;">
					<div class="col-md-12 div-btn-top" style="margin-top: 10px;">
						<button type="button" onclick="window.location.href='<?php echo url::base() ?>employees/listTimeCard/week'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'week'): ?> green disables <?php endif; ?>">7 days</button>
						<button type="button" onclick="window.location.href='<?php echo url::base() ?>employees/listTimeCard/half_month'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'half_month'): ?> green disables <?php endif; ?>">14 days</button>
						<button type="button" onclick="window.location.href='<?php echo url::base() ?>employees/listTimeCard/month'" class="btn default btn-sm <?php if($this->uri->segment(3) == 'month'): ?> green disables <?php endif; ?>">30 days</button>
					</div>
					<div class="col-md-12" style="padding-bottom: 10px;overflow: hidden;">
						<div style="float: left;" class="input-group input-large date-picker input-daterange" data-date="" data-date-format="mm/dd/yyyy">
							<input value="<?php echo !empty($date_to)?$date_to:''; ?>" type="text" class="form-control input-sm" name="txt_date_to" placeholder="Start">
							<span class="input-group-addon" style="line-height: 1;"> to </span>
							<input value="<?php echo !empty($date_end)?$date_end:''; ?>" type="text" class="form-control input-sm" name="txt_date_end" placeholder="End">
						</div>
						<div style="float: left;">
							<button type="submit" class="btn green btn-sm">Apply</button>
						</div>
					</div>
				</div>
			</form>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-4 col-sm-push-8">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
						<div class="table-action">
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="javascript:void(0)" class="timecard-delete" ><i class="fa fa-trash-o"></i> Delete</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0)" class="cus-csv" ><i class="fa fa-file-excel-o"></i> Export to CSV</a>
									</li>
									<!-- <li>
										<a href="javascript:void(0)" class="cus-html" ><i class="fa fa-file-code-o"></i> Export to HTML</a>
									</li> -->
								</ul>
							</div>
						</div>
					<?php endif ?>
				</div>
				<div class="col-sm-8 col-sm-pull-4">
					<div class="portlet-input">
						<button type="button" class="btn btn-icon-only green cls-btnPreDay">
							<i class="fa fa-angle-left" style="font-size: 26px;"></i>
						</button>
						<button type="button" class="btn btn-icon-only green cls-btnToDay">
							<i class="fa fa-home" style="font-size: 26px;"></i>
						</button>
						<button type="button" class="btn btn-icon-only green cls-btnNextDay">
							<i class="fa fa-angle-right" style="font-size: 26px;"></i>
						</button>
						<span style="padding: 5px;font-size: 16px;overflow: hidden;white-space: nowrap;" class="cls-strFormat"><?php echo date('F d',strtotime($date_to)); ?> - <?php echo date('F d, Y',strtotime($date_end)); ?></span>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="height: 391px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-timecard" width="100%" style="margin: auto auto auto 0;">
					</table>
				</div>
			</div>
			<div class="row" style="padding-top: 5px;">
				<div class="col-md-12" style="">
					<div style="text-align: right;">
						<input type="hidden" name="txt_hd_actionday" class="txt_hd_actionday" value="">
						<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_timecard'], -1) == '1')): ?>
							<button type="button" class="btn green cls-btnDuplicate">
								Submit Time Card
							</button>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="days" value="<?php echo !empty($days)?$days:''; ?>">
<!-- include jsListEmployees.php  controller jsKiosk -->
<?php } ?>

