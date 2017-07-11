<script type="text/javascript">
	var stageManagement = function(){
		var wapStage;
		var tbStage;
		var dialogAdd;

		var handleEvent = function(){
			tbStage.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbStage.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				stageManagement.edit(trId);
			});

			$('#slt_store_active', wapStage).change(function(event) {
				tbStage.setAjaxParam('store_id', $(this).val());
				stageManagement.reloadData();

			});
		};

		var handleSearch = function(){
			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbStage.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			} );
		};

		var handleLoadData = function(storeId){
			tbStage = new Datatable();
			tbStage.setAjaxParam('store_id', storeId);
			tbStage.init({
				src: $("#tb-stage"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '300px',
					"ajax":{
						"url" : "<?php echo url::base()?>catalogs/getDataStage",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_registry[]' value='"+full.tdID+"'>";
		                }
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdIcon){
		                		return "<div class='icon-catalog'><img style='width:32px;height:32px' src='<?php echo $this->hostGetImg ?>?files_id="+full.tdIcon+"' alt=''></div>";
		                	}else{
		                		return "<div class='icon-catalog'></div>";
		                	}
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdStore",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdDate",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdDateUpdate",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdStatus",
		                "orderable": false
		            }],
		            scroller: {
			            loadingIndicator: false,
			            rowHeight: 49
			        },
				}
			});
			
		};
		return {
			init: function(){
				wapStage = $('.wap-list-stage');
				var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapStage).val();
				}
				handleLoadData(storeId);
				handleSearch();
				handleEvent();
			},
			add: function(){
	        	Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getAddStage',
					type: 'GET'
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
			        	type: 'danger' 
			        });
				});
	        },
	        edit: function(id){
	        	Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getEditStage',
					type: 'POST',
					data:{ 'id': id },
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
			        	type: 'danger' 
			        });
				});
	        },
	        delete: function(){
				var selected = tbStage.getSelectedID();
				if(selected.length > 0){
					bootbox.confirm({
			            message: "Are you sure you want to delete this record ?",
			            title: "Delete",
			            buttons: {
			              	cancel: {
			                	label: "No",
			                	className: "default btn-no"
			              	},confirm: {
			                	label: "Yes",
			                	className: "green btn-yes"
			              	}
			            },callback: function(result) {
			            	if(result){
		            			Kiosk.blockTableUI('.table-datatable', '406px');
		                      	$.ajax({
									url: '<?php echo url::base() ?>catalogs/setStatusStage',
									type: 'POST',
									dataType: 'json',
									data: {
										'id': selected,
										'action': 'DELETE'
									},
								})
								.done(function(data) {
									Kiosk.unblockTableUI('.table-datatable');
									if(data['msg'] == true){
										$.bootstrapGrowl(data['total']+" items deleted.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl("Error.", { 
							            	type: 'danger' 
							            });
									}
									stageManagement.reloadData();

								})
								.fail(function() {
									Kiosk.unblockTableUI('.table-datatable');
									$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
						            	type: 'danger' 
						            });
								});
		                    }
		                }
			        });
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			},
	        action: function(type){
				/*
				* type : OPEN : CLOSE
				 */
				var selected = tbStage.getSelectedID();
				if(selected.length > 0){
					$.ajax({
						url: '<?php echo url::base() ?>catalogs/setStatusStage',
						type: 'POST',
						dataType: 'json',
						data: {
							'id': selected,
							'action': type
						},
					})
					.done(function(data) {
						stageManagement.reloadData();
						if(data['msg'] == true){
				          	$.bootstrapGrowl("Save change.", { 
				                type: 'success' 
				            });
				        }else{
				          	$.bootstrapGrowl("Error.", { 
				                type: 'danger' 
				            });
				        }
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			},
			reloadData: function(){
				var datatable    = tbStage.getDataTable();
				var tablewrapper = tbStage.getTableWrapper();
				var table        = tbStage.getTable();

				tbStage.clearSelectedID();

				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			},
		}
	}();

	var frmStage = function(){
		var frm,
    		wapContent;

    	var handleEvent = function(){
    		frm.on('click', '.btn-upload', function(event) {
    			Kiosk.blockUI();
				var _btnUpload  = $(this);
				var _fileUpload = _btnUpload.parents('.frm-img').find('input[name="uploadfile"]');
				var _sltStore   = _btnUpload.parents('.item-add-category').find('select[name="txt_category[]"]');
				var store_id    = _sltStore.val();
				var data        = new FormData();
				data.append('uploadfile', $('#uploadfile').prop('files')[0]);
				data.append('store_id', store_id);
				$.ajax({
				    type: 'POST',
				    //url: "<?php echo $this->hostUploadImg ?>",
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
				    		$('#uploadfilehd', wapContent).val(response.data[0]['file_id']);
				    		$('.btn-upload', wapContent).hide();
				    	}else{
				    		$('#uploadfilehd', wapContent).val('');
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

			frm.on('click', '.btn-remove', function(event) {
    			event.preventDefault();
    			$('#uploadfilehd', frm).val('');
    		});

    		$('#uploadfile').on('change.bs.fileinput', function(event, files) {
			    $('.btn-upload').removeAttr('style');
			});
    		/* Add */
    		frm.on('click', '.btn-add', function() {
				var _item = $('.category-item-template').clone();
				var _name = _item.find('input[name="txt_name[]"]');
				var _slt  = _item.find('select[name="txt_category[]"]');

				_item.removeClass('category-item-template');
				_item.appendTo(wapContent).show();
				frmStage.initSelect2(_slt);
				_name.focus();
			});

    		/* Delete */
    		wapContent.on('click', '.btn-delete', function() {
    			if($('.wap-item-add-category', frm).children().length > 1)
    				$(this).parents(".item-add-category").remove();
    		});
    	};

    	var handleValidate = function(){
    		$(frm).validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
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
		        	var isValid = true;
		        	var isFocus = true;
			        $("input[name='txt_name[]']", frm).each(function() {
			            if($(this).val() == "" && $(this).val().length < 1) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			                if(isFocus){
			                	$(this).focus();
			                	isFocus = false;
			                }
			            } else {
			                $(this).closest('.in-group').removeClass('has-error');
			            }
			        });
			        $("select[name='txt_category[]']", frm).each(function() {
			            if($(this).val() == "" && $(this).val().length < 1) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			                if(isFocus){
			                	$(this).focus();
			                	isFocus = false;
			                }
			            } else {
			                $(this).closest('.in-group').removeClass('has-error');
			            }
			        });
			        if(isValid){
						var name  = $('input[name="txt_name[]"]').val();
						var id    = $('input[name="txt_hd_id"]').val();
						var store = $('select[name="txt_category[]"]').val();
						if(id == ''){
							Kiosk.blockUI();
							form.submit();
						}else{
							frmStage.checkName(store, id, name, form);
						}
		        		
			        }
		        }
		    });
    	};

    	return {
    		init: function(){
    			wapContent = $('.wap-item-add-category');
				frm        = wapContent.parents('#frm-category');
				frmStage.initSelect2($('select[name="txt_category[]"]', wapContent));
				handleValidate();
				handleEvent();
    		},
    		checkName: function(store, id, name, form){
    			Kiosk.blockUI();
    			$.ajax({
		    		url: '<?php echo url::base() ?>catalogs/checkName',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {
		    			'store': store,
		    			'name': name,
		    			'id': id
		    		},
		    	})
		    	.done(function(data) {
		    		Kiosk.unblockUI('.page-quick-wap');
		    		if(data['msg'] == true){
		    			Kiosk.blockUI();
		    			form.submit();
		    		}else{
		    			Kiosk.unblockUI();
		    			$.bootstrapGrowl("Item name exists.", { 
				        	type: 'danger' 
				        });
		    		}
		    	})
		    	.fail(function() {
		    		Kiosk.unblockUI('.page-quick-wap');
		    		console.log("error");
		    	});
    		},
    		initSelect2: function(el){
    			el.select2({
        			minimumResultsForSearch: -1
        		});
    		}
    	}	
	}();

	$(document).ready(function() {
		stageManagement.init();
	});
</script>