<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Customer Management
				</div>
			</div>
			<div class="row" style="margin-bottom: 5px;">
				<div class="col-sm-8 col-sm-push-4">
					<div class="table-action">
						<button type="button" class="btn green btn-add-customers" onclick="adminCustomers.add()">
							<i class="fa fa-plus"></i> Add New Customer
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" onclick="adminCustomers.action('1')"><i class="fa fa-check-circle"></i> Set as Active</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="adminCustomers.action('2')"><i class="fa  fa-minus-circle"></i> Set as Inactive</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="adminCustomers.delete()"><i class="fa fa-trash-o"></i> Delete</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="javascript:void(0)" class="cus-csv" onclick=""><i class="fa fa-file-excel-o"></i> Export to CSV</a>
								</li>
								<!-- <li>
									<a href="javascript:void(0)" class="cus-html" onclick=""><i class="fa fa-file-code-o"></i> Export to HTML</a>
								</li> -->
							</ul>
						</div>
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
									Cust. #
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
								<th>
									Type
								</th>
								<th>
									Store
								</th>
								<th>
									Stasus
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
<!-- include jsCustomers.php  controller jsKiosk -->