<?php /* ?>
<div class="row">
	<div class="col-md-12 div-btn-top">
		<button type="button" class="btn btn-primary btn-lg">Customers</button>
		<button type="button" class="btn default btn-lg" onclick="window.location.href='<?php echo url::base() ?>customers/organizations'">Organizations</button>
	</div>
</div>
<?php */ ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered wap-list-customer">
			<div class="portlet-title">
				<div class="caption">
					Customer Management
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<div class="btn-group">
							<a class="btn green" href="javascript:;" data-toggle="dropdown" data-close-others="true">
								<i class="fa fa-bars"></i>
							</a>
							<div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
								<div style="max-height: 350px;overflow: auto;">
									<label><input class="cls-columns" <?php echo (!in_array(1, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="1">Associated Store</label>
									<label><input class="cls-columns" <?php echo (!in_array(2, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="2">Account ID</label>
									<label><input class="cls-columns" <?php echo (!in_array(3, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="3">Name</label>
									<label><input class="cls-columns" <?php echo (!in_array(4, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="4">Point</label>
									<label><input class="cls-columns" <?php echo (!in_array(5, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="5">Address</label>
									<label><input class="cls-columns" <?php echo (!in_array(6, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="6">Phone</label>
									<label><input class="cls-columns" <?php echo (!in_array(7, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="7">Added Date</label>
									<label><input class="cls-columns" <?php echo (!in_array(8, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="8">Notes</label>
								</div>
							</div>
						</div>
					<?php 
						$role = $this->mPrivileges;
						if($role == 'FullAccess' || (is_array($role) && substr($role['customers'], -1) == '1')): ?>
							<!-- <button type="button" class="btn green btn-add-customers" onclick="addCustomers(1)">
								<i class="fa fa-plus"></i> Add New Customer
							</button> -->
							<div class="btn-group">
								<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
								Action On Selected <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<?php if((int)$this->sess_cus['admin_level'] != 2): ?>
									<li>
										<a href="javascript:void(0)" class="cus-store"><i class="fa fa-exchange"></i> Change associated store</a>
									</li>
									<?php endif ?>
									<li>
										<a href="javascript:void(0)" class="cus-delete" onclick="delCustomers(1)"><i class="fa fa-trash-o"></i> Delete</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0)" class="cus-csv" onclick="csvCustomers(1)"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
									</li>
									<!-- <li>
										<a href="javascript:void(0)" class="cus-html" onclick="htmlCustomers(1)"><i class="fa fa-file-code-o"></i> Export to HTML</a>
									</li> -->
								</ul>
							</div>
						<?php endif ?>
					</div>
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
					<table class="table table-striped table-hover table-advance-th" id="tb-customers" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th>
									<input type="checkbox" class="chk-all">
								</th>
								<th>
									Associated Store
								</th>
								<th>
									Account ID
								</th>
								<th>
									Name
								</th>
								<th>
									Point
								</th>
								<th>
									Address
								</th>
								<th>
									Phone
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
		$actionChange = 'customers/changeStore';
		include_once Kohana::find_file('views/include','inModalChangeStore');
	}
	
?>
<!-- include jsCustomers.php  controller jsKiosk -->