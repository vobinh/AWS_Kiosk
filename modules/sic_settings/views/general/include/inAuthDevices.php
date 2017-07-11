<div class="row">
	<div class="col-md-12">
		<div class="portlet solid grey-cararra bordered">
			<div class="portlet-title">
				<div class="caption">
					Authorized Devices for Data Access
				</div>
				<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], -1) == '1')): ?>
					<div class="actions">
						<div class="btn-group">
							<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
							Action On Selected <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="javascript:void(0)" class="" onclick="frmGeneral.action(1)"><i class="fa fa-check-circle"></i> Active</a>
								</li>
								<li>
									<a href="javascript:void(0)" class="" onclick="frmGeneral.action(2)"><i class="fa fa-minus-circle"></i> Deactivate</a>
								</li>
								<li>
									<a href="javascript:void(0)" class="" onclick="frmGeneral.action(3)"><i class="fa fa-minus-circle"></i> Trouble</a>
								</li>
								<li>
									<a href="javascript:void(0)" class="" onclick="frmGeneral.action(4)"><i class="fa fa-minus-circle"></i> Discard</a>
								</li>
								<!-- <li>
									<a href="javascript:void(0)" class="cus-html" ><i class="fa fa-trash-o"></i> Delete</a>
								</li> -->
							</ul>
						</div>
					</div>
				<?php endif ?>
			</div>
			<div class="portlet-body rgba_white">
				<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
					<table class="table table-striped table-hover table-advance-th" id="tb-machine" width="100%" style="margin: auto auto auto 0;">
						<thead>
							<tr>
								<th style="vertical-align: middle;">
									<input type="checkbox" class="chk-all">
								</th>
								<th style="vertical-align: middle;">
									Name
								</th>
								<th style="vertical-align: middle;">
									Serial No
								</th>
								<th style="vertical-align: middle;">
									IP Address
								</th>
								<th style="vertical-align: middle;">
									PC Address
								</th>
								<th style="vertical-align: middle;">
									Data
								</th>
								<th style="vertical-align: middle;">
									Status
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'], -1) == '1')): ?>
					<div style="text-align: right;padding: 5px;">
						<button type="bottom" class="btn btn-default green" onclick="frmGeneral.add()">Add Device</button>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>