<?php $storeUsing = $this->_getStoreUsing(); ?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg" disabled>Employees</button>
		<?php 
			$_storeId = base64_decode($this->sess_cus['storeId']);
			//if((string)$_storeId != '0'):
		 ?>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees/listScheduling'">Scheduling</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>employees/listTimeCard'">Time Card</button>
		<?php //endif ?>
		
	</div>
</div>
<?php if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_employees'], 0, 1) == '0')){ ?>
	<?php include_once kohana::find_file('views/templates', 'noAccess'); ?>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-employees">
			<div class="portlet-title">
				<div class="caption">
					Employee Management
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
				<div class="col-sm-8 col-sm-push-4">
					<?php $role = $this->mPrivileges;
					if($role == 'FullAccess' || (is_array($role) && substr($role['employees_employees'], -1) == '1')): ?>
						<div class="table-action">
							<button type="button" class="btn green" onclick="employees.add()">
								<i class="fa fa-plus"></i> Add New Employee
							</button>
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<?php if((int)$this->sess_cus['admin_level'] != 2): ?>
									<li>
										<a href="javascript:void(0)" class="empl-store"><i class="fa fa-exchange"></i> Change associated store</a>
									</li>
									<?php endif ?>
									<li>
										<a href="javascript:void(0)" class="cus-delete" onclick="employees.delete()"><i class="fa fa-trash-o"></i> Delete</a>
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
				<div class="col-sm-4 col-sm-pull-8">
					<div class="portlet-input">
						<div class="input-icon">
							<i class="icon-magnifier "></i>
							<input id="myInput" type="text" class="form-control" placeholder="search...">
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="portlet-body" style="background-color: #ffffff;">
				<div class="table-responsive table-datatable filter-hidden" style="height: 406px;position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-employees" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th>
									<input type="checkbox" class="chk-all">
								</th>
								<th>
									Empl.#
								</th>
								<th>
									Store Name
								</th>
								<th>
									Name
								</th>
								<th>
									Address
								</th>
								<th>
									Phone
								</th>
								<th>
									E-mail
								</th>
								<th>
									Added Date
								</th>
								<th>
									Notes
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	if((int)$this->sess_cus['admin_level'] != 2){
		$actionChange = 'employees/changeStore';
		include_once Kohana::find_file('views/include','inModalChangeStore');
	}
	
?>
<!-- include jsListEmployees.php  controller jsKiosk -->
<?php } ?>