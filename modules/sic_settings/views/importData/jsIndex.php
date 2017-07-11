<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script>
	$(document).ready(function() {
		var wapContent = $('.cls-wapcontent');
		$('#uploadfile').on('change.bs.fileinput', function(event, files) {
		    //console.log(event);
		});

		wapContent.on('click', '.btn-upload', function(event) {
			event.preventDefault();
			var store_id = '<?php echo base64_decode($this->sess_cus["storeId"]) ?>';
			if($('#slt_store_active').length > 0){
				store_id = $('#slt_store_active').val();
			}
			if(typeof store_id == "undefined" || store_id == '0' || store_id == null){
				$.bootstrapGrowl("Please select a store to which the data can be imported.", { 
	            	type: 'danger' 
	            });
	            return false;
			}
			Kiosk.blockUI();
			$("#frm-import-menu").submit();
		});
	});
</script>