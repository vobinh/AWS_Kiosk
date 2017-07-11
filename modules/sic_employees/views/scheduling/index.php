<style type="text/css" media="screen">
	.dataTables_scroll{
		margin-bottom: 0px !important;
	}
</style>
<?php $storeUsing = $this->_getStoreUsing(); ?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees'">Employees</button>
		<?php 
			$_storeId = base64_decode($this->sess_cus['storeId']);
			//if((string)$_storeId != '0'):
		 ?>
		<button type="button" class="btn btn-primary btn-lg" disabled>Scheduling</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees/listTimeCard'">Time Card</button>
		<?php //endif ?>

	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_scheduling'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-scheduling">
			<div class="portlet-title">
				<div class="caption">
					Scheduling Management
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
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-4 col-sm-push-8">
					<?php $role = $this->mPrivileges;
					if($role == 'FullAccess' || (is_array($role) && substr($role['employees_scheduling'], -1) == '1')): ?>
						<div class="table-action">
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="javascript:void(0)" class="scheduling-delete" ><i class="fa fa-trash-o"></i> Delete</a>
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
						<span style="padding: 5px;font-size: 16px;overflow: hidden;white-space: nowrap;" class="cls-strFormat">January 8 - January 14, 2017</span>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="height: 391px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-scheduling" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th>
									<input type="checkbox" class="chk-all">
								</th>
								<th class="cls-employee">
									Employee
								</th>
								<th class="cls-sun cls-day">
									Sun(1/8)
								</th>
								<th class="cls-mon cls-day">
									Mon(1/9)
								</th>
								<th class="cls-tue cls-day">
									Tue(1/10)
								</th>
								<th class="cls-wed cls-day">
									Web(1/11)
								</th>
								<th class="cls-thu cls-day">
									Thu(1/12)
								</th>
								<th class="cls-Fri cls-day">
									Fri(1/13)
								</th>
								<th class="cls-sat cls-day">
									Sat(1/14)
								</th>
								<th>
									Total Hours
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row" style="padding-top: 5px;">
				<div class="col-md-12" style="">
					<div style="text-align: right;">
						<input type="hidden" name="txt_hd_actionday" class="txt_hd_actionday" value="">
						<?php if($role == 'FullAccess' || (is_array($role) && substr($role['employees_scheduling'], -1) == '1')): ?>
							<button type="button" class="btn green cls-btnDuplicate">
								Duplicate Previous Week's
							</button>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- include jsListEmployees.php  controller jsKiosk -->
<?php } ?>