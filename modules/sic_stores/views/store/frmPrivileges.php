<?php $role = $this->mPrivileges; ?>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php if(!empty($userName)): ?>
					Set User Privileges
					<p style="padding-top: 5px;font-size: 15px;margin-bottom: 0;">User: <b><?php echo $userName ?></b></p>
				<?php else: ?>
					Set User Privileges Default
				<?php endif ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-privileges" action="<?php echo url::base() ?>store/saveDefaultPrivileges" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row">
						<div class="col-md-3">
							<table>
								<tbody>
									<tr>
										<td></td>
										<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;">Read</td>
										<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;">Write</td>
									</tr>
									<tr>
										<td class="cls-weight">Customers</td>
										<td class="cls-center"><input class="cls-privileges" type="checkbox" <?php echo (!empty($data['customers']) && substr($data['customers'], 0, 1) == '1')?'checked':'' ?> name="txt_customers_r" value="1"></td>
										<td class="cls-center"><input class="cls-privileges" type="checkbox" <?php echo (!empty($data['customers']) && substr($data['customers'], -1) == '1')?'checked':'' ?> name="txt_customers_w" value="1"></td>
									</tr>
									<tr>
										<td class="cls-weight">Accounting</td>
										<td class="cls-center"><input type="checkbox" name="txt_acc_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_acc_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Overview</td>
										<td class="cls-center"><input class="cls-acc-r cls-privileges" <?php echo (!empty($data['acc_overview']) && substr($data['acc_overview'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_overview_r" value="1"></td>
										<td class="cls-center"><input class="cls-acc-w cls-privileges" <?php echo (!empty($data['acc_overview']) && substr($data['acc_overview'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_overview_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Reconciliations</td>
										<td class="cls-center"><input class="cls-acc-r cls-privileges" <?php echo (!empty($data['acc_recon']) && substr($data['acc_recon'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_recon_r" value="1"></td>
										<td class="cls-center"><input class="cls-acc-w cls-privileges" <?php echo (!empty($data['acc_recon']) && substr($data['acc_recon'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_recon_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Reimbursements</td>
										<td class="cls-center"><input class="cls-acc-r cls-privileges" <?php echo (!empty($data['acc_reimbursements']) && substr($data['acc_reimbursements'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_reimbursements_r" value="1"></td>
										<td class="cls-center"><input class="cls-acc-w cls-privileges" <?php echo (!empty($data['acc_reimbursements']) && substr($data['acc_reimbursements'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_reimbursements_w" value="1"></td>
									</tr>
									<tr>
										<td class="cls-weight">Operations</td>
										<td class="cls-center"><input type="checkbox" name="txt_operations_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_operations_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Menu</td>
										<td class="cls-center"><input class="cls-operations-r cls-privileges" <?php echo (!empty($data['operations_menu']) && substr($data['operations_menu'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_menu_r" value="1"></td>
										<td class="cls-center"><input class="cls-operations-w cls-privileges" <?php echo (!empty($data['operations_menu']) && substr($data['operations_menu'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_menu_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Inventory</td>
										<td class="cls-center"><input class="cls-operations-r cls-privileges" <?php echo (!empty($data['operations_inventory']) && substr($data['operations_inventory'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_inventory_r" value="1"></td>
										<td class="cls-center"><input class="cls-operations-w cls-privileges" <?php echo (!empty($data['operations_inventory']) && substr($data['operations_inventory'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_inventory_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Inventory Registry</td>
										<td class="cls-center"><input class="cls-operations-r cls-privileges" <?php echo (!empty($data['operation_inventory_registry']) && substr($data['operation_inventory_registry'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operation_inventory_registry_r" value="1"></td>
										<td class="cls-center"><input class="cls-operations-w cls-privileges" <?php echo (!empty($data['operation_inventory_registry']) && substr($data['operation_inventory_registry'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operation_inventory_registry_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Category</td>
										<td class="cls-center"><input class="cls-operations-r cls-privileges" <?php echo (!empty($data['operations_category']) && substr($data['operations_category'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_category_r" value="1"></td>
										<td class="cls-center"><input class="cls-operations-w cls-privileges" <?php echo (!empty($data['operations_category']) && substr($data['operations_category'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_category_w" value="1"></td>
									</tr>
									<tr>
										<td class="cls-weight">Marketing</td>
										<td class="cls-center"><input type="checkbox" name="txt_marketing_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_marketing_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Dashboard</td>
										<td class="cls-center"><input class="cls-marketing-r cls-privileges" <?php echo (!empty($data['marketing_dashboard']) && substr($data['marketing_dashboard'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_dashboard_r" value="1"></td>
										<td class="cls-center"><input class="cls-marketing-w cls-privileges" <?php echo (!empty($data['marketing_dashboard']) && substr($data['marketing_dashboard'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_dashboard_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Loyalty Program</td>
										<td class="cls-center"><input class="cls-marketing-r cls-privileges" <?php echo (!empty($data['marketing_loyalty']) && substr($data['marketing_loyalty'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_loyalty_r" value="1"></td>
										<td class="cls-center"><input class="cls-marketing-w cls-privileges" <?php echo (!empty($data['marketing_loyalty']) && substr($data['marketing_loyalty'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_loyalty_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Online Marketing</td>
										<td class="cls-center"><input class="cls-marketing-r cls-privileges" <?php echo (!empty($data['marketing_online']) && substr($data['marketing_online'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_online_r" value="1"></td>
										<td class="cls-center"><input class="cls-marketing-w cls-privileges" <?php echo (!empty($data['marketing_online']) && substr($data['marketing_online'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_online_w" value="1"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-3">
							<table>
								<tbody>
									<tr>
										<td></td>
										<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;">Read</td>
										<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;">Write</td>
									</tr>
									<tr>
										<td class="cls-weight">Reports</td>
										<td class="cls-center"><input type="checkbox" name="txt_reports_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_reports_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Summary</td>
										<td class="cls-center"><input class="cls-reports-r cls-privileges" <?php echo (!empty($data['reports_summary']) && substr($data['reports_summary'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_summary_r" value="1"></td>
										<td class="cls-center"><input class="cls-reports-w cls-privileges" <?php echo (!empty($data['reports_summary']) && substr($data['reports_summary'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_summary_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Sales Reports</td>
										<td class="cls-center"><input class="cls-reports-r cls-privileges" <?php echo (!empty($data['reports_sales']) && substr($data['reports_sales'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_sales_r" value="1"></td>
										<td class="cls-center"><input class="cls-reports-w cls-privileges" <?php echo (!empty($data['reports_sales']) && substr($data['reports_sales'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_sales_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Products & Services</td>
										<td class="cls-center"><input class="cls-reports-r cls-privileges" <?php echo (!empty($data['reports_products']) && substr($data['reports_products'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_products_r" value="1"></td>
										<td class="cls-center"><input class="cls-reports-w cls-privileges" <?php echo (!empty($data['reports_products']) && substr($data['reports_products'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_products_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Customers</td>
										<td class="cls-center"><input class="cls-reports-r cls-privileges" <?php echo (!empty($data['reports_customers']) && substr($data['reports_customers'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_customers_r" value="1"></td>
										<td class="cls-center"><input class="cls-reports-w cls-privileges" <?php echo (!empty($data['reports_customers']) && substr($data['reports_customers'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_customers_w" value="1"></td>
									</tr>
									<tr>
										<td class="cls-weight">Employees</td>
										<td class="cls-center"><input type="checkbox" name="txt_employees_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_employees_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Employees</td>
										<td class="cls-center"><input class="cls-employees-r cls-privileges" <?php echo (!empty($data['employees_employees']) && substr($data['employees_employees'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_employees_r" value="1"></td>
										<td class="cls-center"><input class="cls-employees-w cls-privileges" <?php echo (!empty($data['employees_employees']) && substr($data['employees_employees'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_employees_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Scheduling</td>
										<td class="cls-center"><input class="cls-employees-r cls-privileges" <?php echo (!empty($data['employees_scheduling']) && substr($data['employees_scheduling'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_scheduling_r" value="1"></td>
										<td class="cls-center"><input class="cls-employees-w cls-privileges" <?php echo (!empty($data['employees_scheduling']) && substr($data['employees_scheduling'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_scheduling_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Time Card</td>
										<td class="cls-center"><input class="cls-employees-r cls-privileges" <?php echo (!empty($data['employees_timecard']) && substr($data['employees_timecard'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_timecard_r" value="1"></td>
										<td class="cls-center"><input class="cls-employees-w cls-privileges" <?php echo (!empty($data['employees_timecard']) && substr($data['employees_timecard'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_timecard_w" value="1"></td>
									</tr>
									<tr>
										<td class="cls-weight">Settings</td>
										<td class="cls-center"><input type="checkbox" name="txt_settings_r" value="1"></td>
										<td class="cls-center"><input type="checkbox" name="txt_settings_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- General Settings</td>
										<td class="cls-center"><input class="cls-settings-r cls-privileges" <?php echo (!empty($data['settings_general']) && substr($data['settings_general'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_general_r" value="1"></td>
										<td class="cls-center"><input class="cls-settings-w cls-privileges" <?php echo (!empty($data['settings_general']) && substr($data['settings_general'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_general_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- User Privileges</td>
										<td class="cls-center"><input class="cls-settings-r cls-privileges" <?php echo (!empty($data['settings_privileges']) && substr($data['settings_privileges'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_privileges_r" value="1"></td>
										<td class="cls-center"><input class="cls-settings-w cls-privileges" <?php echo (!empty($data['settings_privileges']) && substr($data['settings_privileges'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_privileges_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Stage</td>
										<td class="cls-center"><input class="cls-settings-r cls-privileges" <?php echo (!empty($data['settings_stage']) && substr($data['settings_stage'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_stage_r" value="1"></td>
										<td class="cls-center"><input class="cls-settings-w cls-privileges" <?php echo (!empty($data['settings_stage']) && substr($data['settings_stage'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_stage_w" value="1"></td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;&nbsp;- Receipt Design</td>
										<td class="cls-center"><input class="cls-settings-r cls-privileges" <?php echo (!empty($data['settings_receipt']) && substr($data['settings_receipt'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_receipt_r" value="1"></td>
										<td class="cls-center"><input class="cls-settings-w cls-privileges" <?php echo (!empty($data['settings_receipt']) && substr($data['settings_receipt'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_receipt_w" value="1"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div style="padding-bottom: 5px;">
					<button style="min-width: 150px;" type="button" class="btn green btn-sm btn-set-default">Set to Default</button>
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_user_id" value="<?php echo !empty($userId)?$userId:''; ?>">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_privileges'], -1) == '1')): ?>
						<button style="min-width: 150px;" type="submit" class="btn green">Save</button>
					<?php else: ?>
						<button style="min-width: 150px;" type="button" class="btn green" disabled>Save (Read only)</button>
					<?php endif ?>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog btn-close-privileges">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		Kiosk.initUniform('input[type="checkbox"]');
		handleFrmEvent();
		handleSubmit();

	});

	function handleSubmit() {
		$('#frm-privileges').submit(function(event) {
			event.preventDefault();
			var url  = $(this).attr('action');
			var data = $(this).serialize();
			Kiosk.blockUI();
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(data) {
				var getParent = _init_Login_Credentials.getParent();
				getParent.find('input[name="txt_add_priveileges[]"]').val(JSON.stringify(data));
				$('.btn-close-privileges').trigger('click');
				$.bootstrapGrowl("Action complete.", { 
	                type: 'success' 
	            });
			})
			.fail(function() {
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			})
			.always(function() {
				Kiosk.unblockUI();
			});
		});
	}


	function handleFrmEvent(){
		$('input[name="txt_acc_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-acc-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-acc-r');
		});
		$('input[name="txt_acc_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-acc-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-acc-w');
		});

		$('input[name="txt_operations_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-operations-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-operations-r');
		});
		$('input[name="txt_operations_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-operations-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-operations-w');
		});

		$('input[name="txt_marketing_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-marketing-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-marketing-r');
		});
		$('input[name="txt_marketing_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-marketing-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-marketing-w');
		});

		$('input[name="txt_reports_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-reports-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-reports-r');
		});
		$('input[name="txt_reports_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-reports-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-reports-w');
		});

		$('input[name="txt_employees_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-employees-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-employees-r');
		});
		$('input[name="txt_employees_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-employees-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-employees-w');
		});

		$('input[name="txt_settings_r"]').click(function(event) {
			var c = this.checked;
			$('.cls-settings-r:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-settings-r');
		});
		$('input[name="txt_settings_w"]').click(function(event) {
			var c = this.checked;
			$('.cls-settings-w:checkbox').prop('checked',c);
			Kiosk.updateUniform('.cls-settings-w');
		});

		$('.btn-set-default').click(function(event) {
			var adminId = $('input[name="txt_admin_id"]').val();
			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>store/getPrivileges',
				type: 'POST',
				dataType: 'json',
				data: { 'adminId': adminId },
			})
			.done(function(data) {
				if(data['status'] = true){
					var cus = data['data']['customers'].split('|');
					$('input[name="txt_customers_r"]').prop('checked',JSON.parse(cus[0]));
					$('input[name="txt_customers_w"]').prop('checked',JSON.parse(cus[1]));

					var acc_overview = data['data']['acc_overview'].split('|');
					$('input[name="txt_acc_overview_r"]').prop('checked',JSON.parse(acc_overview[0]));
					$('input[name="txt_acc_overview_w"]').prop('checked',JSON.parse(acc_overview[1]));

					var acc_recon = data['data']['acc_recon'].split('|');
					$('input[name="txt_acc_recon_r"]').prop('checked',JSON.parse(acc_recon[0]));
					$('input[name="txt_acc_recon_w"]').prop('checked',JSON.parse(acc_recon[1]));

					var acc_reimbursements = data['data']['acc_reimbursements'].split('|');
					$('input[name="txt_acc_reimbursements_r"]').prop('checked',JSON.parse(acc_reimbursements[0]));
					$('input[name="txt_acc_reimbursements_w"]').prop('checked',JSON.parse(acc_reimbursements[1]));

					var operations_menu = data['data']['operations_menu'].split('|');
					$('input[name="txt_operations_menu_r"]').prop('checked',JSON.parse(operations_menu[0]));
					$('input[name="txt_operations_menu_w"]').prop('checked',JSON.parse(operations_menu[1]));

					var operations_inventory = data['data']['operations_inventory'].split('|');
					$('input[name="txt_operations_inventory_r"]').prop('checked',JSON.parse(operations_inventory[0]));
					$('input[name="txt_operations_inventory_w"]').prop('checked',JSON.parse(operations_inventory[1]));

					var operation_inventory_registry = data['data']['operation_inventory_registry'].split('|');
					$('input[name="txt_operation_inventory_registry_r"]').prop('checked',JSON.parse(operation_inventory_registry[0]));
					$('input[name="txt_operation_inventory_registry_w"]').prop('checked',JSON.parse(operation_inventory_registry[1]));

					var operations_category = data['data']['operations_category'].split('|');
					$('input[name="txt_operations_category_r"]').prop('checked',JSON.parse(operations_category[0]));
					$('input[name="txt_operations_category_w"]').prop('checked',JSON.parse(operations_category[1]));

					var marketing_dashboard = data['data']['marketing_dashboard'].split('|');
					$('input[name="txt_marketing_dashboard_r"]').prop('checked',JSON.parse(marketing_dashboard[0]));
					$('input[name="txt_marketing_dashboard_w"]').prop('checked',JSON.parse(marketing_dashboard[1]));

					var marketing_loyalty = data['data']['marketing_loyalty'].split('|');
					$('input[name="txt_marketing_loyalty_r"]').prop('checked',JSON.parse(marketing_loyalty[0]));
					$('input[name="txt_marketing_loyalty_w"]').prop('checked',JSON.parse(marketing_loyalty[1]));

					var marketing_online = data['data']['marketing_online'].split('|');
					$('input[name="txt_marketing_online_r"]').prop('checked',JSON.parse(marketing_online[0]));
					$('input[name="txt_marketing_online_w"]').prop('checked',JSON.parse(marketing_online[1]));

					var reports_summary = data['data']['reports_summary'].split('|');
					$('input[name="txt_reports_summary_r"]').prop('checked',JSON.parse(reports_summary[0]));
					$('input[name="txt_reports_summary_w"]').prop('checked',JSON.parse(reports_summary[1]));

					var reports_sales = data['data']['reports_sales'].split('|');
					$('input[name="txt_reports_sales_r"]').prop('checked',JSON.parse(reports_sales[0]));
					$('input[name="txt_reports_sales_w"]').prop('checked',JSON.parse(reports_sales[1]));

					var reports_products = data['data']['reports_products'].split('|');
					$('input[name="txt_reports_products_r"]').prop('checked',JSON.parse(reports_products[0]));
					$('input[name="txt_reports_products_w"]').prop('checked',JSON.parse(reports_products[1]));

					var reports_customers = data['data']['reports_customers'].split('|');
					$('input[name="txt_reports_customers_r"]').prop('checked',JSON.parse(reports_customers[0]));
					$('input[name="txt_reports_customers_w"]').prop('checked',JSON.parse(reports_customers[1]));

					var employees_employees = data['data']['employees_employees'].split('|');
					$('input[name="txt_employees_employees_r"]').prop('checked',JSON.parse(employees_employees[0]));
					$('input[name="txt_employees_employees_w"]').prop('checked',JSON.parse(employees_employees[1]));

					var employees_scheduling = data['data']['employees_scheduling'].split('|');
					$('input[name="txt_employees_scheduling_r"]').prop('checked',JSON.parse(employees_scheduling[0]));
					$('input[name="txt_employees_scheduling_w"]').prop('checked',JSON.parse(employees_scheduling[1]));

					var employees_timecard = data['data']['employees_timecard'].split('|');
					$('input[name="txt_employees_timecard_r"]').prop('checked',JSON.parse(employees_timecard[0]));
					$('input[name="txt_employees_timecard_w"]').prop('checked',JSON.parse(employees_timecard[1]));

					var settings_general = data['data']['settings_general'].split('|');
					$('input[name="txt_settings_general_r"]').prop('checked',JSON.parse(settings_general[0]));
					$('input[name="txt_settings_general_w"]').prop('checked',JSON.parse(settings_general[1]));

					var settings_privileges = data['data']['settings_privileges'].split('|');
					$('input[name="txt_settings_privileges_r"]').prop('checked',JSON.parse(settings_privileges[0]));
					$('input[name="txt_settings_privileges_w"]').prop('checked',JSON.parse(settings_privileges[1]));

					var settings_stage = data['data']['settings_stage'].split('|');
					$('input[name="txt_settings_stage_r"]').prop('checked',JSON.parse(settings_stage[0]));
					$('input[name="txt_settings_stage_w"]').prop('checked',JSON.parse(settings_stage[1]));

					var settings_receipt = data['data']['settings_receipt'].split('|');
					$('input[name="txt_settings_receipt_r"]').prop('checked',JSON.parse(settings_receipt[0]));
					$('input[name="txt_settings_receipt_w"]').prop('checked',JSON.parse(settings_receipt[1]));

					Kiosk.updateUniform('.cls-privileges');
				}
			})
			.fail(function() {
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			})
			.always(function() {
				Kiosk.unblockUI();
			});
		});
	};
	<?php if($role == 'NoAccess' || (is_array($role) && substr($role['settings_privileges'], -1) == '0')){ ?>
		$(document).ready(function() {
			$('#frm-privileges').attr('action', 'javascript:void(0);');
		});
	<?php } ?>
</script>