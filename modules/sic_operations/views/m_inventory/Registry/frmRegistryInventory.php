<?php $role = $this->mPrivileges;  ?>
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
						<div class="col-lg-4 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px; text-align: center;">
								<h4 style="text-align: left;">Icon</h4>
								<div class="thumbnail" style="width: 125px;position: relative; margin: auto; margin-bottom: 10px;">
									<a href="javascript:;" class="btn-remove btn btn-sm btn-circle red" style="position: absolute;top: 2px;right: 2px;margin: auto;height: 30px;width: 30px;line-height: 21px;<?php echo empty($data['file_id'])?' display:none;':'' ?>"><i class="fa fa-times"></i></a>
									<img width="120px" height="110px" class="img-preAPI" src="<?php echo !empty($data['file_id'])?$this->hostGetImg .'?files_id='.$data['file_id']:'http://www.placehold.it/120x110/EFEFEF/AAAAAA&amp;text=no+image' ?>" alt=""/>
								</div>
								<button class="btn btn-sm green btn-upload-img" type="button">Upload</button>
								<input type="hidden" id="uploadfilehd" name="uploadfilehd" value="<?php echo !empty($data['file_id'])?$data['file_id']:'' ?>">
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Category</h4>
								<div class="catalog-middle in-group">
									<select name="txt_sub_category" id="slt-sub-category" class="form-control input-sm">
										<?php if(!empty($sub_category)): ?>
											<?php foreach ($sub_category as $key => $value): ?>
												<option <?php echo (!empty($data['sub_category_id']) && $data['sub_category_id'] == $value['sub_category_id'])?'selected':'' ?> value="<?php echo !empty($value['sub_category_id'])?$value['sub_category_id']:'' ?>"><?php echo !empty($value['sub_category_name'])?$value['sub_category_name']:'' ?></option>
											<?php endforeach ?>
										<?php endif ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Item Name</h4>
								<div class="catalog-middle in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" class="form-control input-sm" name="txt_item_name" value="<?php echo !empty($data['pro_name'])?$data['pro_name']:'' ?>" placeholder="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>SKU #</h4>
								<div class="catalog-middle in-group">
									<input type="text" class="form-control input-sm" name="txt_sku" readonly value="<?php echo !empty($data['pro_no'])?$data['pro_no']:$SKU ?>" placeholder="">
									<div class="customers-error">
										<span style='' class="cus-help-block">SKU# must be unique.</span>
										<button type="button" class="btn btn-sm green" onclick="nextCode(<?php echo !empty($type)?$type:1; ?>)">Fix Invalid Values</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Note / Description</h4>
								<div class="catalog-middle in-group" style="top: 40px;">
									<textarea class="form-control" rows="6" name="txt_note"><?php echo !empty($data['pro_note'])?$data['pro_note']:'' ?></textarea>
								</div>
							</div>
						</div>
						<?php /* ?>
						<div class="col-lg-2 visible-lg">
							<div class="add-catalog" style="height: 220px;">
							</div>
						</div>
						<?php */ ?>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Unit of Measurement</h4>
								<div class="catalog-middle in-group">
									<div class="input-icon input-icon-sm right">
										<i class="fa fa-asterisk" style="font-size: 10px;" aria-hidden="true"></i>
										<input type="text" class="form-control input-sm" name="txt_unit" value="<?php echo !empty($data['pro_unit'])?$data['pro_unit']:'' ?>" placeholder="Units">
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Cost of Purchase<br>Store</h4>
								<div class="catalog-middle" style="top: 50px;">
									<table style="width: 100%;">
										<tbody>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Cost($)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm decimal" name="txt_store_cost" value="<?php echo !empty($data['pro_cost_store'])?$data['pro_cost_store']:'' ?>" placeholder="">
												</td>
											</tr>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Per (Units)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm decimal" name="txt_store_per" value="<?php echo !empty($data['pro_per_store'])?$data['pro_per_store']:'' ?>" placeholder="">
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-size: 10px;text-align: justify;">
													This is the suggested price for stores to purchase orders from the warehouse. They may enter an alternative value at purchase, but the auto-calculated value will be based on the suggested cost.
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-4 col-sm-6" <?php if($this->sess_cus['_parent_level'] == 3){ ?>style="display:none"<?php } ?>>
							<div class="border add-catalog" style="height: 220px;">
								<h4>Cost of Purchase<br>Warehouse</h4>
								<div class="catalog-middle" style="top: 50px;">
									<table style="width: 100%;">
										<tbody>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Cost($)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm decimal" name="txt_warehouse_cost" value="<?php echo !empty($data['pro_cost_warehouse'])?$data['pro_cost_warehouse']:'' ?>" placeholder="">
												</td>
											</tr>
											<tr>
												<td>
													<span style="white-space: nowrap;">
														Per (Units)
													</span>
												</td>
												<td class="in-group">
													<input type="text" style="margin-bottom: 5px;text-align: right;" class="form-control input-sm decimal" name="txt_warehouse_per" value="<?php echo !empty($data['pro_per_warehouse'])?$data['pro_per_warehouse']:'' ?>" placeholder="">
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-size: 10px;text-align: justify;">
													This is the price the warehouse pays to suppliers / purveyors to keep its stock in its warehouse.
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-4 col-sm-6">
							<div class="border add-catalog" style="height: 220px;">
								<h4>Shelf Life<br>Store</h4>
								<div class="catalog-middle in-group" style="top: 50px;">
									<input type="text" class="form-control input-sm integer" name="txt_store_day" value="<?php echo !empty($data['pro_shelf_life_store'])?$data['pro_shelf_life_store']:'' ?>" placeholder="">
									<span style="font-size: 10px;text-align: justify;display: block;">
										This is the suggested shelf life for items when stores receive their items. The auto-set shelf life is calculated by adding the value in this field to the date on which the order arrives at the store. Individual stores may change the shelf life on their inventory stock. Leave blank if N/A
									</span>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6" <?php if($this->sess_cus['_parent_level'] == 3){ ?>style="display:none"<?php } ?>>
							<div class="border add-catalog" style="height: 220px;">
								<h4>Shelf Life<br>Warehouse</h4>
								<div class="catalog-middle in-group" style="top: 50px;">
									<input type="text" class="form-control input-sm integer" name="txt_warehouse_day" value="<?php echo !empty($data['pro_shelf_life_warehouse'])?$data['pro_shelf_life_warehouse']:'' ?>" placeholder="">
									<span style="font-size: 10px;text-align: justify;display: block;">
										This is the shelf life for items when the warehouse receives them from suppliers / purveyors. Leave blank if N/A
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label style="font-size: 12px;color: red;text-align:right" class="control-label col-lg-12" style="">
									<i style="font-size: 10px;" class="fa fa-asterisk" aria-hidden="true"></i> Required field
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['pro_id'])?$data['pro_id']:'' ?>">
					<?php if($role == 'FullAccess' || (is_array($role) && substr($role['operation_inventory_registry'], -1) == '1')): ?>
						<button style="min-width: 150px;" type="submit" class="btn green">Registry Item</button>
					<?php else: ?>
						<button style="min-width: 150px;" type="button" class="btn green" disabled>Registry Item (Read only)</button>
					<?php endif ?>
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".decimal").inputmask('decimal',{rightAlign: true});
		$(".integer").inputmask('integer',{rightAlign: true});
		$('input[name="txt_catelory"]').focus();
		
		$('#frm-registry').validate({
	        errorElement: 'span',
	        errorClass: 'help-block',
	        focusInvalid: false,
	        rules: {
	            txt_sub_category: {
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
	            }
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

	     $('#frm-registry').on('click', '.btn-upload', function(event) {
			event.preventDefault();
			Kiosk.blockUI();
			var store_id = '<?php echo base64_decode($this->sess_cus["storeId"]) ?>';
			var data     = new FormData();
			data.append('uploadfile', $('#uploadfile').prop('files')[0]);
			data.append('store_id', store_id);
			$.ajax({
			    type: 'POST',
			    url: "<?php echo url::base() ?>catalogs/sendImg",
			    data: data,
			    crossDomain: true,
			    processData: false,
			    contentType: false,
			    dataType : 'json',
			    success: function(response) {
			    	if(response.responseMsg == 'Success'){
			    		$.bootstrapGrowl("Upload Success.", { 
			            	type: 'success' 
			            });
			    		$('#uploadfilehd', $('#frm-registry')).val(response.data[0]['file_id']);
			    		$('.btn-upload', $('#frm-registry')).hide();
			    	}else{
			    		$('#uploadfilehd', $('#frm-registry')).val('');
			    		$.bootstrapGrowl("Could not complete request.", { 
			            	type: 'danger' 
			            });
			    	}
			    	Kiosk.unblockUI();
			    }
		   	}).fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
	            	type: 'danger' 
	            });
			});
		});

	    $('#frm-registry').on('click', '.btn-remove', function(event) {
			event.preventDefault();
			$('#uploadfilehd', $('#frm-registry')).val('');
		});

		$('#uploadfile').on('change.bs.fileinput', function(event, files) {
		    $('.btn-upload').removeAttr('style');
		});

	    function checkCode(input_code, form){
	    	Kiosk.blockUI();
	    	form.submit();
	    	return false;
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
	    $('#slt-sub-category').select2();

		$("#slt-category").select2({
	        placeholder: "",
	        minimumInputLength: 1,
	        ajax: {
	            url: "<?php echo url::base()?>warehouse/getCatalory",
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
</script>