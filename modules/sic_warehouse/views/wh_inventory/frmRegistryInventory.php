<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<?php echo !empty($title)?$title:'Registry New Inventory Item'; ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-registry" action="<?php echo url::base() ?>catalogs/saveRegistry" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div class="form-body">
					<div class="row">
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Icon</h4>
								<div class="view-icon">
								</div>
								<div style="position: absolute;bottom: 10px;left: 10px;right: 10px;text-align: center;">
									<span class="btn green fileinput-button">
										<span>Select Icon</span>
										<input type="file" name="txt_icon" id="txt_icon" accept=".png, .jpg, .jpeg">
									</span>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Category</h4>
								<div class="catalog-middle in-group">
									<input type="text" class="form-control input-sm" id="slt-category" name="txt_sub_category" value="" placeholder="">
									<input type="hidden" class="txt_category" name="txt_category" value="">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Item Name</h4>
								<div class="catalog-middle in-group">
									<input type="text" class="form-control input-sm" name="txt_item_name" value="" placeholder="">
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>SKU #</h4>
								<div class="catalog-middle in-group">
									<input type="text" class="form-control input-sm" name="txt_sku" readonly value="<?php echo $SKU; ?>" placeholder="">
									<div class="customers-error">
										<span style='' class="cus-help-block">SKU# must be unique.</span>
										<button type="button" class="btn btn-sm green" onclick="nextCode(<?php echo !empty($type)?$type:1; ?>)">Fix Invalid Values</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Note / Description</h4>
								<div class="catalog-middle in-group" style="top: 40px;">
									<textarea class="form-control" rows="6" name="txt_note"></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-2 visible-lg">
							<div class="add-catalog">
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Unit of Measurement</h4>
								<div class="catalog-middle in-group">
									<input type="text" class="form-control input-sm" name="txt_unit" value="" placeholder="(kg, oz, ect.)">
								</div>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Cost of Purchase</h4>
								<div class="catalog-middle" style="top: 70px;">
									<table style="width: 100%;">
										<tbody>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Cost($)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm" name="txt_cost" value="0.00" placeholder="">
												</td>
											</tr>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Per (Units)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm" name="txt_per" value="0.00" placeholder="">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog">
								<h4>Shelf Life</h4>
								<div class="catalog-middle in-group" style="top: 70px;">
									<input type="text" class="form-control input-sm" name="txt_day" value="" placeholder="">
									<span>
										Enter the shelf life in days to automatically set expiration dates when creating inventory items. Leave blank if N/A
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="">
					<button style="min-width: 150px;" type="submit" class="btn green">Registry Item</button>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

		$('input[name="txt_catelory"]').focus();

		$('#frm-registry').validate({
	        errorElement: 'span',
	        errorClass: 'help-block',
	        focusInvalid: false,
	        rules: {
	            txt_catelory: {
	                required: true
	            },
	            txt_item_name: {
	                required: true
	            },
	            txt_sku: {
	                required: true
	            },
	            txt_unit: {
	                required: true
	            },
	            txt_price: {
	                required: true
	            },
	            txt_cost: {
	                required: true
	            },
	            txt_regular: {
	                required: true
	            },
	            txt_small: {
	                required: true
	            },
	            txt_large: {
	                required: true
	            },
	            txt_xlarge: {
	                required: true
	            },
	        },

	        messages: {
	            
	        },

	        invalidHandler: function (event, validator) {
	            
	        },
	        highlight: function (element) {
	            $(element)
	                .closest('.in-group').addClass('has-error');
	        },
	        success: function (label, element) {
	            $(element).closest('.in-group').removeClass('has-error');
	        },
	        errorPlacement: function (error, element) {
	        },
	        submitHandler: function (form) {
	        	var _input = $('input[name="txt_sku"]').val();
	        	checkCode(_input, form);
	        }
	    });

	    $('#frm-registry input').keypress(function (e) {
	        if (e.which == 13) {
	            if ($('#frm-registry').validate().form()) {
	                $('#frm-registry').submit();
	            }
	            return false;
	        }
	    });

	    function checkCode(input_code, form){
	    	form.submit();
			var url  = form.action;
			var type = $(form).find("#txt_type").val();
	    	Kiosk.blockUI({
	            target: '.page-quick-wap',
	            boxed: true
	        });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>catalogs/checkSKU/'+type,
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {'txt_code': input_code},
	    	})
	    	.done(function(data) {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		if(data['msg'] == 'true'){
	    			$('.customers-error').hide();
	    			form.submit();
	    		}else{
	    			$('.customers-error').parent('.in-group').addClass('has-error');
	    			$('.data-code').text(input_code);
	    			$('.customers-error').show();
	    		}
	    	})
	    	.fail(function() {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		console.log("error");
	    	});
	    }

		$("#slt-category").select2({
	        placeholder: "",
	        minimumInputLength: 1,
	        ajax: {
	            url: "<?php echo url::base()?>catalogs/getCatalory",
	            dataType: 'json',
	            type: 'POST',
	            data: function (term, page) {
	                return {
	                    q: term,
	                    page_limit: 10,
	                };
	            },
	            results: function (data, page) {
	            	console.log(data);
	            	console.log(page);

	                return {
	                    results: data
	                };
	            }
	        },
	        initSelection: function (element, callback) {
                var id = $(element).val();
                if (id !== "") {
                   callback({ "id": id, "text": id });
                }
            },
	        createSearchChoice:function(term, data) {
		        /*if ( $(data).filter( function() {
		            return this.text.localeCompare(term) === 0 ;
		        }).length === 0) {
		            return {id:term, text:term};
		        }*/
		    },
		    dropdownCssClass: "bigdrop",
	        escapeMarkup: function (m) {
	            return m;
	        },
	        formatInputTooShort: function () {
                return "Search";
            }, 
	    }).on('select2-selecting', function (e) {
	    	$('.txt_category').val(e.choice.category_id);
	    });
	});

	function nextCode(type){
		Kiosk.blockUI({
            target: '.page-quick-wap',
            boxed: true
        });
    	$.ajax({
    		url: '<?php echo url::base() ?>customers/nextCode/'+type,
    		type: 'POST',
    		dataType: 'json',
    		data: {'txt_code': 'code'},
    	})
    	.done(function(data) {
    		Kiosk.unblockUI('.page-quick-wap');
    		if(data['msg'] == 'true'){
    			$('input[name="txt_cus_no"]').val(data['code']);
    			$('.customers-error').parent('.in-group').removeClass('has-error');
    			$('.customers-error').hide();
    		}else{
    			$('.customers-error').parent('.in-group').addClass('has-error');
    			$('.customers-error').show();
    		}
    	})
    	.fail(function() {
    		Kiosk.unblockUI('.page-quick-wap');
    		console.log("error");
    	});
    }

    $(document).on('change', '#txt_icon', function() {
		
		var input = $(this),
		numFiles  = input.get(0).files ? input.get(0).files.length : 1,
		label     = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    	//input.trigger('fileselect', [numFiles, label]);
    	var ext = getExtension(label);
    	if(ext == 'jpg' || ext == 'png' || ext == 'jpeg'){
    		readURL(this);
    	}else{
    		input.val('');
    		$('.view-icon').html('');
    	}
        //
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.view-icon').html('<img src="'+e.target.result+'" alt="">');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    function getExtension(path) {
	    var basename = path.split(/[\\/]/).pop(),
	        pos = basename.lastIndexOf(".");

	    if (basename === "" || pos < 1)
	        return "";

	    return basename.slice(pos + 1).toLowerCase();
	}
</script>