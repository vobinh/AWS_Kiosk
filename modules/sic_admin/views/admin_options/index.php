<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption col-md-12">
							Options: User Privileges
						</div>
					</div>
					<div class="portlet-body">
						<form id="frm-store" action="<?php echo url::base() ?>admin_options/savePrivileges" method="post" class="form-horizontal">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<table>
											<tbody>
												<tr>
													<td></td>
													<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;width: 5%;">Read</td>
													<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;width: 5%;">Write</td>
												</tr>
												<tr>
													<td class="cls-weight">Customers</td>
													<td class="cls-center"><input type="checkbox" <?php echo (!empty($data['customers']) && substr($data['customers'], 0, 1) == '1')?'checked':'' ?> name="txt_customers_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" <?php echo (!empty($data['customers']) && substr($data['customers'], -1) == '1')?'checked':'' ?> name="txt_customers_w" value="1"></td>
												</tr>
												<tr>
													<td class="cls-weight">Accounting</td>
													<td class="cls-center"><input type="checkbox" name="txt_acc_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_acc_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Overview</td>
													<td class="cls-center"><input class="cls-acc-r" <?php echo (!empty($data['acc_overview']) && substr($data['acc_overview'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_overview_r" value="1"></td>
													<td class="cls-center"><input class="cls-acc-w" <?php echo (!empty($data['acc_overview']) && substr($data['acc_overview'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_overview_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Reconciliations</td>
													<td class="cls-center"><input class="cls-acc-r" <?php echo (!empty($data['acc_recon']) && substr($data['acc_recon'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_recon_r" value="1"></td>
													<td class="cls-center"><input class="cls-acc-w" <?php echo (!empty($data['acc_recon']) && substr($data['acc_recon'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_recon_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Reimbursements</td>
													<td class="cls-center"><input class="cls-acc-r" <?php echo (!empty($data['acc_reimbursements']) && substr($data['acc_reimbursements'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_reimbursements_r" value="1"></td>
													<td class="cls-center"><input class="cls-acc-w" <?php echo (!empty($data['acc_reimbursements']) && substr($data['acc_reimbursements'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_acc_reimbursements_w" value="1"></td>
												</tr>
												<tr>
													<td class="cls-weight">Operations</td>
													<td class="cls-center"><input type="checkbox" name="txt_operations_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_operations_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Menu</td>
													<td class="cls-center"><input class="cls-operations-r" <?php echo (!empty($data['operations_menu']) && substr($data['operations_menu'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_menu_r" value="1"></td>
													<td class="cls-center"><input class="cls-operations-w" <?php echo (!empty($data['operations_menu']) && substr($data['operations_menu'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_menu_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Inventory</td>
													<td class="cls-center"><input class="cls-operations-r" <?php echo (!empty($data['operations_inventory']) && substr($data['operations_inventory'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_inventory_r" value="1"></td>
													<td class="cls-center"><input class="cls-operations-w" <?php echo (!empty($data['operations_inventory']) && substr($data['operations_inventory'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_inventory_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Inventory Registry</td>
													<td class="cls-center"><input class="cls-operations-r" <?php echo (!empty($data['operation_inventory_registry']) && substr($data['operation_inventory_registry'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operation_inventory_registry_r" value="1"></td>
													<td class="cls-center"><input class="cls-operations-w" <?php echo (!empty($data['operation_inventory_registry']) && substr($data['operation_inventory_registry'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operation_inventory_registry_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Category</td>
													<td class="cls-center"><input class="cls-operations-r" <?php echo (!empty($data['operations_category']) && substr($data['operations_category'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_category_r" value="1"></td>
													<td class="cls-center"><input class="cls-operations-w" <?php echo (!empty($data['operations_category']) && substr($data['operations_category'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_operations_category_w" value="1"></td>
												</tr>
												<tr>
													<td class="cls-weight">Marketing</td>
													<td class="cls-center"><input type="checkbox" name="txt_marketing_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_marketing_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Dashboard</td>
													<td class="cls-center"><input class="cls-marketing-r" <?php echo (!empty($data['marketing_dashboard']) && substr($data['marketing_dashboard'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_dashboard_r" value="1"></td>
													<td class="cls-center"><input class="cls-marketing-w" <?php echo (!empty($data['marketing_dashboard']) && substr($data['marketing_dashboard'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_dashboard_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Loyalty Program</td>
													<td class="cls-center"><input class="cls-marketing-r" <?php echo (!empty($data['marketing_loyalty']) && substr($data['marketing_loyalty'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_loyalty_r" value="1"></td>
													<td class="cls-center"><input class="cls-marketing-w" <?php echo (!empty($data['marketing_loyalty']) && substr($data['marketing_loyalty'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_loyalty_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Online Marketing</td>
													<td class="cls-center"><input class="cls-marketing-r" <?php echo (!empty($data['marketing_online']) && substr($data['marketing_online'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_online_r" value="1"></td>
													<td class="cls-center"><input class="cls-marketing-w" <?php echo (!empty($data['marketing_online']) && substr($data['marketing_online'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_marketing_online_w" value="1"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-md-6">
										<table>
											<tbody>
												<tr>
													<td></td>
													<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;width: 5%;">Read</td>
													<td class="cls-center" style="padding-left: 5px;padding-right: 5px;font-weight: 600;width: 5%;">Write</td>
												</tr>
												<tr>
													<td class="cls-weight">Reports</td>
													<td class="cls-center"><input type="checkbox" name="txt_reports_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_reports_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Summary</td>
													<td class="cls-center"><input class="cls-reports-r" <?php echo (!empty($data['reports_summary']) && substr($data['reports_summary'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_summary_r" value="1"></td>
													<td class="cls-center"><input class="cls-reports-w" <?php echo (!empty($data['reports_summary']) && substr($data['reports_summary'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_summary_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Sales Reports</td>
													<td class="cls-center"><input class="cls-reports-r" <?php echo (!empty($data['reports_sales']) && substr($data['reports_sales'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_sales_r" value="1"></td>
													<td class="cls-center"><input class="cls-reports-w" <?php echo (!empty($data['reports_sales']) && substr($data['reports_sales'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_sales_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Products & Services</td>
													<td class="cls-center"><input class="cls-reports-r" <?php echo (!empty($data['reports_products']) && substr($data['reports_products'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_products_r" value="1"></td>
													<td class="cls-center"><input class="cls-reports-w" <?php echo (!empty($data['reports_products']) && substr($data['reports_products'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_products_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Customers</td>
													<td class="cls-center"><input class="cls-reports-r" <?php echo (!empty($data['reports_customers']) && substr($data['reports_customers'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_customers_r" value="1"></td>
													<td class="cls-center"><input class="cls-reports-w" <?php echo (!empty($data['reports_customers']) && substr($data['reports_customers'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_reports_customers_w" value="1"></td>
												</tr>
												<tr>
													<td class="cls-weight">Employees</td>
													<td class="cls-center"><input type="checkbox" name="txt_employees_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_employees_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Employees</td>
													<td class="cls-center"><input class="cls-employees-r" <?php echo (!empty($data['employees_employees']) && substr($data['employees_employees'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_employees_r" value="1"></td>
													<td class="cls-center"><input class="cls-employees-w" <?php echo (!empty($data['employees_employees']) && substr($data['employees_employees'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_employees_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Scheduling</td>
													<td class="cls-center"><input class="cls-employees-r" <?php echo (!empty($data['employees_scheduling']) && substr($data['employees_scheduling'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_scheduling_r" value="1"></td>
													<td class="cls-center"><input class="cls-employees-w" <?php echo (!empty($data['employees_scheduling']) && substr($data['employees_scheduling'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_scheduling_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Time Card</td>
													<td class="cls-center"><input class="cls-employees-r" <?php echo (!empty($data['employees_timecard']) && substr($data['employees_timecard'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_timecard_r" value="1"></td>
													<td class="cls-center"><input class="cls-employees-w" <?php echo (!empty($data['employees_timecard']) && substr($data['employees_timecard'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_employees_timecard_w" value="1"></td>
												</tr>
												<tr>
													<td class="cls-weight">Settings</td>
													<td class="cls-center"><input type="checkbox" name="txt_settings_r" value="1"></td>
													<td class="cls-center"><input type="checkbox" name="txt_settings_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- General Settings</td>
													<td class="cls-center"><input class="cls-settings-r" <?php echo (!empty($data['settings_general']) && substr($data['settings_general'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_general_r" value="1"></td>
													<td class="cls-center"><input class="cls-settings-w" <?php echo (!empty($data['settings_general']) && substr($data['settings_general'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_general_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- User Privileges</td>
													<td class="cls-center"><input class="cls-settings-r" <?php echo (!empty($data['settings_privileges']) && substr($data['settings_privileges'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_privileges_r" value="1"></td>
													<td class="cls-center"><input class="cls-settings-w" <?php echo (!empty($data['settings_privileges']) && substr($data['settings_privileges'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_privileges_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Stage</td>
													<td class="cls-center"><input class="cls-settings-r" <?php echo (!empty($data['settings_stage']) && substr($data['settings_stage'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_stage_r" value="1"></td>
													<td class="cls-center"><input class="cls-settings-w" <?php echo (!empty($data['settings_stage']) && substr($data['settings_stage'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_stage_w" value="1"></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;&nbsp;- Receipt Design</td>
													<td class="cls-center"><input class="cls-settings-r" <?php echo (!empty($data['settings_receipt']) && substr($data['settings_receipt'], 0, 1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_receipt_r" value="1"></td>
													<td class="cls-center"><input class="cls-settings-w" <?php echo (!empty($data['settings_receipt']) && substr($data['settings_receipt'], -1) == '1')?'checked':'' ?> type="checkbox" name="txt_settings_receipt_w" value="1"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="form-actions" style="margin-top: 10px;">
								<div class="row">
									<div class="col-md-12" style="text-align: right;">
										<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['id'])?$data['id']:''; ?>">
										<button type="submit" class="btn green" style="min-width: 150px;">Save</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet solid grey-cararra bordered">
					<div class="portlet-title">
						<div class="caption col-md-12">
							Customers: Default columns visible
						</div>
					</div>
					<div class="portlet-body">
						<form id="frm-store" action="<?php echo url::base() ?>admin_options/saveCusNoDisplay" method="post" class="form-horizontal">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<table>
											<tbody>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(1, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="1">Associated Store</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(2, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="2">Account ID</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(3, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="3">Name</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(4, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="4">Point</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(5, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="5">Address</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(6, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="6">Phone</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(7, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="7">Added Date</label>
													</td>
												</tr>
												<tr>
													<td>
														<label><input class="cls-columns" name="txt_cus_nondisplay[]" <?php echo (!in_array(8, $cus_nondisplay))?'checked':'' ?> type="checkbox" value="8">Notes</label>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="form-actions" style="margin-top: 10px;">
								<div class="row">
									<div class="col-md-12" style="text-align: right;">
										<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['id'])?$data['id']:''; ?>">
										<button type="submit" class="btn green" style="min-width: 150px;">Save</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>