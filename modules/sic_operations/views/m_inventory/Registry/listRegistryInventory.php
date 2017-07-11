<?php $role = $this->mPrivileges;  ?>
<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Inventory Registry'; ?>
				<span style="display: inherit;font-size: 14px;">Manage your list of registered inventory items. The registry is synchronized across all associated stores and the warehouse.</span>
			</div>
		</div>
		<div class="portlet-body form wap-registry">
			<div class="table-responsive table-datatable filter-hidden" style="height: 408px;position: relative;">
				<table class="table table-striped" id="tb-registry-inventory" width="100%" style="margin: auto auto auto 0;">
					<thead>
							<tr>
								<th>
									<input type="checkbox" class="chk-all">
								</th>
								<th>
									Icon
								</th>
								<th>
									Category
								</th>
								<th>
									Item Name
								</th>
								<th>
									SKU#
								</th>
								<th>
									Cost of Purchase
								</th>
								<th>
									Unit of Measurement
								</th>
								<th>
									itemDescriptiom
								</th>
								<th>
									Sheft Life
								</th>
								<th>
									
								</th>
							</tr>
						</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<?php if($role == 'FullAccess' || (is_array($role) && substr($role['operation_inventory_registry'], -1) == '1')){ ?>
				<div style="padding-bottom: 5px;">
					<button type="button" class="btn green btn-add-registry">Register New Inventory Item</button>
				</div>
			<?php } ?>
			<div class="form-actions right">
				<button style="min-width: 150px;" type="button" class="btn default toggle-page-quick">Close</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="total_pro" value="<?php echo !empty($total_pro)?$total_pro:0; ?>">
<script type="text/javascript">
	$(document).ready(function() {
		registryInventory.init();
	});
</script>