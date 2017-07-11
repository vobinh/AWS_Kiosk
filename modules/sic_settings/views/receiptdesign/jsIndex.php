<!--script type="text/javascript" src="<?php //echo $this->site['base_url'] ?>plugins/global/plugins/ckeditor.4.6/ckeditor.js"></script-->
<script type="text/javascript">
	Kiosk.intOnly('.intOnly');
	//CKEDITOR.replace( 'txtHeader' );
	//CKEDITOR.replace( 'txtFooter' );

	$('.txtWidth').keyup(function(event) {
		setSize($(this).val());
	}).change(function(event) {
		setSize($(this).val());
	});

	function setSize(width){
		var width = width;
		if(width == ''){
			width = 250;
			$('.txtWidth').val(width);
		}
		$('.preHeader').width(width);
		$('.preContent').width(width);
		$('.preFooter').width(width);
	}

	$('.btnPreview').click(function(event) {
		var dataHeader = $('#txtHeader').val();//CKEDITOR.instances.txtHeader.getData();
		var dataFooter = $('#txtFooter').val();//CKEDITOR.instances.txtFooter.getData();
		$('.preHeader').html(dataHeader.replace(/\n/g, "<br/>"));
		$('.preFooter').html(dataFooter.replace(/\n/g, "<br/>"));
	});

	$('.btnSave').click(function(event) {
		// var dataHeader = CKEDITOR.instances.txtHeader.getData();
		// var dataFooter = CKEDITOR.instances.txtFooter.getData();
		var dataHeader = $('#txtHeader').val();
		var dataFooter = $('#txtFooter').val();
		var storeId    = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
		if(storeId == '0'){
			storeId = $('#slt_store_active').val();
		}
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>settings/saveReceiptDesign',
			type: 'POST',
			data:{
				'txtHeader': dataHeader,
				'txtFooter': dataFooter,
				'txtStore': storeId
			},
			dataType: 'json'
		})
		.done(function(data) {
			if(data['msg'] == false){
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			}else{
				$.bootstrapGrowl("Complete request.", { 
	            	type: 'success' 
	            });
	            $('.preHeader').html(dataHeader.replace(/\n/g, "<br/>"));
				$('.preFooter').html(dataFooter.replace(/\n/g, "<br/>"));
			}
			Kiosk.unblockUI();
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	});

	$('#slt_store_active').change(function(event) {
		Kiosk.blockUI();
		var storeId = $(this).val();
		window.location.href = '<?php echo url::base() ?>settings/setStore/'+storeId+'/receiptdesign';
	});
	
	$('.btnGetHeader').click(function(event) {
		var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
		if(storeId == '0'){
			storeId = $('#slt_store_active').val();
		}
		getTemplate(storeId, 'header');
	});

	$('.btnGetFooter').click(function(event) {
		var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
		if(storeId == '0'){
			storeId = $('#slt_store_active').val();
		}
		getTemplate(storeId, 'footer');
	});

	function getTemplate(storeId, type){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>settings/getTemplate',
			type: 'POST',
			data:{
				'txtType': type,
				'txtStore': storeId
			},
			dataType: 'json'
		})
		.done(function(data) {
			if(data == false){
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			}else{
				$.bootstrapGrowl("Complete request.", { 
	            	type: 'success' 
	            });
				if(type == 'header'){
					//CKEDITOR.instances.txtHeader.setData(data['header']);
					$('#txtHeader').val(data['header'].replace(/<br\/>/g,"\n"));
					$('.preHeader').html(data['header']);
				}else{
					//CKEDITOR.instances.txtFooter.setData(data['footer']);
					$('#txtFooter').val(data['footer'].replace(/<br\/>/g,"\n"));
					$('.preFooter').html(data['footer']);
				}
			}
			Kiosk.unblockUI();
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}
</script>