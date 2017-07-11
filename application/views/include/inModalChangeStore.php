<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="true" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="frm-change-store" action="<?php echo url::base() ?><?php echo !empty($actionChange)?$actionChange:'' ?>" method="post">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Change Associated Store.</h4>
	      </div>
	      <div class="modal-body">
	        <p>You have selected <span class="cls-count">25</span> entries. Change the entries’ associated store to:</p>
	        <?php 
	        	$this->db->select('store_id', 'store', 'status');
	        	$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
	        	$this->db->orderby('status', 'asc');
	        	$this->db->orderby('store', 'asc');
	        	$storeAll = $this->db->get('store')->result_array(false);
	        ?>
	        <select name="slt_change_store" id="slt_change_store" class="form-control slt-select2">
	        	<?php if(!empty($storeAll)): ?>
	        		<option value="-1">Select Store</option>
	        		<?php foreach ($storeAll as $slStore => $itemStore): ?>
	        			<option value="<?php echo !empty($itemStore['store_id'])?$itemStore['store_id']:'-1' ?>"><?php echo !empty($itemStore['store_id'])?$itemStore['store']:'' ?><?php echo (!empty($itemStore['status']) && $itemStore['status'] == 2)?' (Inactive)':'' ?></option>
	        		<?php endforeach ?>
	        	<?php else: ?>
	        		<option value="-1">Did not find the store.</option>
	        	<?php endif ?>
	        </select>
	        <span style="color: #a94442;margin-top: 5px;margin-bottom: 5px;display: none;" class="cls-error-change-store">Please select store.</span>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="txt_id_change" value="">
	      	<button style="min-width: 72px;" type="button" class="btn green bnt-change-store">Ok</button>
	        <button style="min-width: 72px;" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
	</form>
  </div>
</div>