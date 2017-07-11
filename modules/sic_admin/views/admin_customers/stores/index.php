<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				Store Management
				<?php if(!empty($admin_type) && $admin_type == 3){ ?>
					<span style="display: inline-block;font-size: 14px;padding-top: 5px;">
						<span style="color: red;">NOTE:</span> The user is classified as a Single Location (Basic) user. You may add as many stores here as you wish, but the user will be routed to the store set as Default upon login. No warehouse connection for inventory will be available.
					</span>
				<?php } ?>
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			<form id="frm-customers" action="<?php echo url::base() ?>admin_customers/save" method="post" class="form-horizontal">
				<div class="form-body">
					<div class="row" style="margin-bottom: 5px;">
						<div class="col-sm-8 col-sm-push-4">
							<div class="table-action">
								<button type="button" class="btn green btn-add-customers" onclick="addStore()">
									<i class="fa fa-plus"></i> Add New Store
								</button>
								<div class="btn-group">
									<button type="button" class="btn btn-fit-height" data-toggle="dropdown" data-delay="1000" data-close-others="true">
									Action On Selected <i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<li>
											<a href="javascript:void(0)" class="cus-delete" onclick="setStoreDefault()"><i class="fa fa-university"></i> Set as default store</a>
										</li>
										<li>
											<a href="javascript:void(0)" class="cus-delete" onclick="setStoreActive()"><i class="fa fa-check-circle"></i> Set as Active</a>
										</li>
										<li>
											<a href="javascript:void(0)" class="cus-delete" onclick="setStoreInactive()"><i class="fa  fa-minus-circle"></i> Set as Inactive</a>
										</li>
										<li>
											<a href="javascript:void(0)" class="cus-delete" onclick="delStore()"><i class="fa fa-trash-o"></i> Delete</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0)" class="cus-csv" onclick="csvCustomers(1)"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
										</li>
										<!-- <li>
											<a href="javascript:void(0)" class="cus-html" onclick="htmlCustomers(1)"><i class="fa fa-file-code-o"></i> Export to HTML</a>
										</li> -->
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-4 col-sm-pull-8">
							<!-- <div class="portlet-input">
								<div class="input-icon">
									<i class="icon-magnifier "></i>
									<input id="myInput" type="text" class="form-control" placeholder="search...">
								</div>
							</div> -->
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="portlet-body" style="background-color: #ffffff;">
						<div class="table-responsive table-datatable filter-hidden" style="position: relative;">
							<table class="table table-striped table-hover table-advance-th" id="tb-store" width="100%" style="margin: auto auto auto 0;">
								<thead>
									<tr>
										<th>
											<input type="checkbox" class="chk-all">
										</th>
										<th>
											Store #
										</th>
										<th>
											Name
										</th>
										<th>
											Address
										</th>
										<th>
											Phone
										</th>
										<th>
											E-mail
										</th>
										<th>
											Added Date
										</th>
										<th>
											Notes
										</th>
										<th>
											Login Credentials
										</th>
										<th>
											Employees
										</th>
										<th>
											Status
										</th>
										<th>
											Default
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<!--/row-->
				</div>
				<div class="form-actions right">
					<input type="hidden" name="txt_hd_id" value="<?php echo !empty($data['admin_id'])?$data['admin_id']:''; ?>">
					<button style="min-width: 150px;" type="button" class="btn default close-kioskDialog">Cancel</button>
				</div>
			</form>
			<!-- END FORM-->
		</div>
	</div>
</div>

<script>

	function addStore(){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/getStore',
			type: 'post',
			data: {
				'admin_id' : '<?php echo $admin_id ?>'
			}
		})
		.done(function(data) {
			var dialogSelect = Store.getDailog();
			dialogSelect = new kioskDialog();

		    dialogSelect.init({
		    	"data": data
		    });

		    Kiosk.unblockUI();
			nextCode();
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}

	function editStore(id){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/getEditStore',
			type: 'POST',
			data: { 'store_id': id, 'admin_id' : '<?php echo $admin_id ?>' }
		})
		.done(function(data) {
			var dialogSelect = Store.getDailog();
			dialogSelect     = new kioskDialog();

		    dialogSelect.init({
		    	"data": data
		    });

			Kiosk.unblockUI();
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}

	function delStore(){
		var selected = Store.get().getSelectedID();
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
								url: '<?php echo url::base() ?>store/delete',
								type: 'POST',
								dataType: 'json',
								data: {'chk_customer': selected},
							})
							.done(function(data) {
								Kiosk.unblockTableUI('.table-datatable');
								var datatable    = Store.get().getDataTable();
								var tablewrapper = Store.get().getTableWrapper();
								var table        = Store.get().getTable();
								Store.get().clearSelectedID();
								$('.chk-all', tablewrapper).prop('checked',false);
								Kiosk.updateUniform('.chk-all', tablewrapper);
								datatable.ajax.reload();

								if(data['msg'] == true){
						          	$.bootstrapGrowl("Save change.", { 
						                type: 'success' 
						            });
						        }else{
						          	$.bootstrapGrowl("Could not complete request.", { 
						                type: 'danger' 
						            });
						        }
							})
							.fail(function() {
								Kiosk.unblockTableUI('.table-datatable');
								$.bootstrapGrowl("Could not complete request.", { 
					            	type: 'danger' 
					            });
							});
	                    }
	                }
	        });
		}
	}

	function setStoreDefault(){
		var selected = Store.get().getSelectedID();
		if(selected.length > 1){
			$.bootstrapGrowl("You can set only one store as default.", { 
            	type: 'warning' 
            });
		}else if(selected.length > 0){
			$.ajax({
				url: '<?php echo url::base() ?>admin_customers/setStoreDefault',
				type: 'POST',
				dataType: 'json',
				data: {'idStore': selected[0]},
			})
			.done(function(data) {
				Kiosk.unblockTableUI('.table-datatable');
				var datatable    = Store.get().getDataTable();
				var tablewrapper = Store.get().getTableWrapper();
				var table        = Store.get().getTable();
				Store.get().clearSelectedID();
				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();

				if(data['msg'] == true){
		          	$.bootstrapGrowl("Save change.", { 
		                type: 'success' 
		            });
		        }else{
		          	$.bootstrapGrowl("Could not complete request.", { 
		                type: 'danger' 
		            });
		        }
			})
			.fail(function() {
				Kiosk.unblockTableUI('.table-datatable');
				$.bootstrapGrowl("Could not complete request.", { 
	            	type: 'danger' 
	            });
			});
		}else{
			$.bootstrapGrowl("No record selected.", { 
	           	type: 'danger' 
	        });
		}
	}

	function setStoreActive(){
		var selected = Store.get().getSelectedID();
		if(selected.length > 0){
			storeAction(selected, '1');
		}else{
			$.bootstrapGrowl("No record selected.", { 
	           	type: 'danger' 
	        });
		}
	}

	function setStoreInactive(){
		var selected = Store.get().getSelectedID();
		if(selected.length > 0){
			storeAction(selected, '2');
		}else{
			$.bootstrapGrowl("No record selected.", { 
	           	type: 'danger' 
	        });
		}
	}

	var Store = function() {
		var tbStore;
		var dialogAdd;
		var loadStore = function (){
			var _main_count = '<?php echo $total_store ?>';
			var _admin_id   = '<?php echo $admin_id ?>';
			tbStore = new Datatable();
			tbStore.setAjaxParam('_main_count', _main_count);
			tbStore.setAjaxParam('_admin_id', _admin_id);
			tbStore.init({
				src: $("#tb-store"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"type": "POST",
						"url" : "<?php echo url::base()?>admin_customers/jsStore"
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_store[]' value='"+full.tdID+"'>";
		                }
		            },{
		            	"class": "slt-row",
		                "data": "td_No",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Name",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Address",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Phone",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Email",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Date",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "td_Note",
		                "orderable": false
		            },
		            {
		            	"class": "slt-row",
		                "data": "total_admin",
		                "orderable": false
		            },
		            {
		            	"class": "slt-row",
		                "data": "total_Employees",
		                "orderable": false
		            },
		            {
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.td_Status == 1){
		                		return "Active";
		                	}else{
		                		return "Inactive";
		                	}
		                    
		                }
		            },{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.td_Default == 1){
		                		return "<span style='color:red'>Default Store</span>";
		                	}else{
		                		return "";
		                	} 
		                }
		            }],
		            scroller: {
			            loadingIndicator: false
			        },
				}
			});

			tbStore.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbStore.getDataTable().row( tr );
				var trId = row.data().DT_RowId;

				editStore(trId);
			});

			tbStore.getTable().on('click', '.btn-inactive', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbStore.getDataTable().row( tr );
				var trId = row.data().DT_RowId;

				storeAction(trId, '2');
			});

			tbStore.getTable().on('click', '.btn-active', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbStore.getDataTable().row( tr );
				var trId = row.data().DT_RowId;

				storeAction(trId, '1');
			});

			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbStore.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			} );
		}
			
		return {
	        init: function () {
	            loadStore();
	            Kiosk.initUniform('.chk-all',tbStore.getTable());
	        },
	        get: function(){
				return tbStore;
			},
			getDailog: function(){
				return dialogAdd;
			}
	    };
	}();

	$(document).ready(function() {
		Store.init();
	});

	function storeAction(id, action){
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/setStatusStore',
			type: 'POST',
			dataType: 'json',
			data: {
				'idStore': id,
				'action': action
			},
		})
		.done(function(data) {
			var tablewrapper = Store.get().getTableWrapper();
			$('.chk-all', tablewrapper).prop('checked',false);
			Store.get().clearSelectedID();
			Kiosk.updateUniform('.chk-all', tablewrapper);
			Store.get().getDataTable().ajax.reload();
			if(data['msg'] == true){
	          	$.bootstrapGrowl("Save change.", { 
	                type: 'success' 
	            });
	        }else{
	          	$.bootstrapGrowl("Could not complete request.", { 
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
		
	}

	function checkCode(input_code, form){
		Kiosk.blockUI({
	        target: '.page-quick-wap-s',
	        boxed: true
	    });
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/checkCodeStore',
			type: 'POST',
			dataType: 'json',
			data: {
				'txt_code': input_code,
				'admin_id': '<?php echo $admin_id ?>'
			},
		})
		.done(function(data) {
			if(data['msg'] == 'true'){
				$('.customers-error').hide();
				form.submit();
			}else{
				$('.customers-error').parent('.in-group').addClass('has-error');
				$('.data-code').text(input_code);
				$('.customers-error').show();
				Kiosk.unblockUI('.page-quick-wap-s');
			}
		})
		.fail(function() {
			Kiosk.unblockUI('.page-quick-wap-s');
			console.log("error");
		});
	}

	function frmAdd_admin(){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/frmAdd_admin',
			type: 'POST',
			data: $('#frm-store').serializeArray(),
		})
		.done(function(data) {
			var dialogSelect = new kioskDialog();
		    dialogSelect.init({
		    	"data": data
		    });
			Kiosk.unblockUI();
			Kiosk.initUniform('.chk_allow_user');
			Kiosk.initUniform('.chk_freeze_user');
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}

	function nextCode(){
		var txt_id_store = $('input[name="txt_id_store"]').val();
	    if(txt_id_store != ''){
			var txt_no_store = $('input[id="txt_no_store"]').val();
	    	$('input[name="txt_store_no"]').val(txt_no_store);
	    	$('.customers-error').parent('.in-group').removeClass('has-error');
			$('.customers-error').hide();
	    	return false;
	    }

		Kiosk.blockUI({
	        target: '.page-quick-wap-s',
	        boxed: true
	    });
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/nextCodeStore',
			type: 'POST',
			data: {
				'admin_id': '<?php echo $admin_id ?>'
			},
			dataType: 'json',
		})
		.done(function(data) {
			Kiosk.unblockUI('.page-quick-wap-s');
			if(data['msg'] == 'true'){
				$('input[name="txt_store_no"]').val(data['code']);
				$('.customers-error').parent('.in-group').removeClass('has-error');
				$('.customers-error').hide();
			}else{
				$('.customers-error').parent('.in-group').addClass('has-error');
				$('.customers-error').show();
			}
		})
		.fail(function() {
			Kiosk.unblockUI('.page-quick-wap-s');
			console.log("error");
		});
	}

	function _init_Add_Store(){
		$(document).ready(function() {
			Kiosk.intOnly('.intOnly');
			$('input[name="txt_store_no"]').focus();
			$('#frm-store').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
		            txt_store_no: {
		                required: true
		            },
		            txt_store_name: {
		                required: true
		            },
		            txt_store_first: {
		                required: true
		            },
		            txt_store_last: {
		                required: true
		            },
		            txt_store_address: {
		                required: true
		            },
		            txt_store_city: {
		                required: true
		            },
		            txt_store_state: {
		                required: true
		            },
		            txt_store_zip: {
		                required: true
		            },
		            txt_store_phone: {
		                required: true
		            },
		            txt_store_email: {
		                required: true,
		                email: true
		            }
		        },

		        messages: {
		            txt_store_no: {
		                required: "Store No is required."
		            }
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
					var _input       = $('input[name="txt_store_no"]').val();
					var txt_no_store = $('input[id="txt_no_store"]').val();
					var txt_id_store = $('input[name="txt_id_store"]').val();

					var _sl = 0;
					$('.cls-check').each(function(index, el) {
						if($(this).val() == "" && $(this).val().length < 1) {
							_sl++;
						}
					});
					if(_sl != 3 && _sl != 0){
						var isFocus = true;
						notification('danger', 'Please enter full information.');
						$(".cls-check").each(function() {
				            if($(this).val() == "" && $(this).val().length < 1) {
				                $(this).closest('.in-group').addClass('has-error');
				                if(isFocus){
				                	$(this).focus();
				                	isFocus = false;
				                }
				            } else {
				                $(this).closest('.in-group').removeClass('has-error');
				            }
				        });
						return false;
					}
					
		        	if(txt_id_store == '')
		        		checkCode(_input, form);
		        	else{
		        		if(_input != txt_no_store){
		        			checkCode(_input, form);
		        		}else{
		        			Kiosk.blockUI();
		        			form.submit();
		        		}
		        	}
		        }
		    });

		    $('#frm-store input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-store').validate().form()) {
		                $('#frm-store').submit();
		            }
		            return false;
		        }
		    });   
		});
	}
	
	var _init_Login_Credentials = function(){
		var wapData;
		var parent;
		var handleEvent = function(){
			wapData.on('change', '.chk_allow_user', function(event) {
				if(this.checked){
					$(this).parent().parent().prev().val(1);
				}else{
					$(this).parent().parent().prev().val(0);
				}
			});

			wapData.on('change', '.chk_freeze_user', function(event) {
				if($(this).is(':checked')){
					$(this).parent().parent().prev().val(3);
				}else{
					$(this).parent().parent().prev().val(0);
				}
			});

			// delete admin
		    wapData.on( "click", ".btn-delete-admin", function(e) {
				var length_user = $('.wp-item-add-admin').children('div').length;
				if(length_user > 1){
					e.preventDefault();
					var $t = $(this);
					var txt_admin_id = $(this).parent('div').parent('div').children('input').val();
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
				        		if(txt_admin_id != ''){
				        			Kiosk.blockUI({
							            target: '.page-quick-wap',
							            boxed: true
							        });
							    	$.ajax({
							    		url: '<?php echo url::base() ?>admin_customers/del_admin',
							    		type: 'POST',
							    		dataType: 'json',
							    		data: {'txt_admin_id': txt_admin_id},
							    	})
							    	.done(function(data) {
							    		Kiosk.unblockUI('.page-quick-wap');
							    		if(data['msg'] == 'true'){
							    			$t.parent('div').parent('div').parent('div').parent('div').parent('div').remove();

							    			$('#wp-admin-containt').empty();
											$("input[name='txt_add_first[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_first[]" value=\''+$(this).val()+'\' />'
									            );
											});

											$("input[name='txt_add_last[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_last[]" value=\''+$(this).val()+'\' />'
									            );
											});
											
											$("input[name='txt_add_adminId[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_adminId[]" value=\''+$(this).val()+'\' />'
									            );
											});
									        
									        $("input[name='txt_add_email[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_email[]" value=\''+$(this).val()+'\' />'
									            );
											});
											
											$("input[name='txt_add_password[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_password[]" value=\''+$(this).val()+'\' />'
									            );
											});
											
									       	$("input[name='txt_add_priveileges[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="txt_add_priveileges[]" value=\''+$(this).val()+'\' />'
									            );
											});

									       	$("input[name='allow_user[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="allow_user[]" value=\''+$(this).val()+'\' />'
									            );
											});
									        
									        $("input[name='freeze_user[]']").each(function() {
												$('#wp-admin-containt').append(
									            	'<input type="text" name="freeze_user[]" value=\''+$(this).val()+'\' />'
									            );
											});
										        
									        if($('#frm-store input[name="txt_add_email[]"]').val){
									        	var number_admin = $('#frm-store input[name="txt_add_email[]"]').length;
									        	$('.number_admin').text(number_admin);
									        }

								          	$.bootstrapGrowl("Delete Success.", { 
								                type: 'success' 
								            });
								        }else{
								          	$.bootstrapGrowl("Could not complete request.", { 
								                type: 'danger' 
								            });
								        }
							    	})
							    	.fail(function() {
							    		Kiosk.unblockUI('.page-quick-wap');
							    		$.bootstrapGrowl("Could not complete request.", { 
								        	type: 'danger' 
								        });
							    	});

				        		}else{
				        			$.bootstrapGrowl("Delete Success.", { 
						                type: 'success' 
						            });
				        			$t.parent('div').parent('div').parent('div').parent('div').parent('div').remove();
				        		}	
				            }
				        }
					});
				}
			});

			// user privileges
			wapData.on('click', '.btn-privileges', function(event) {
				parent             = $(this).closest('.item-add-category');
				var userId         = parent.find('input[name="txt_add_adminId[]"]').val() || 'add';
				var fname          = parent.find('input[name="txt_add_first[]"]').val() || 'New';
				var lname          = parent.find('input[name="txt_add_last[]"]').val() || 'user';
				var userName       = fname +' '+ lname;
				var userPrivileges = parent.find('input[name="txt_add_priveileges[]"]').val();
				var adminId        = $('input[name="txt_admin_id"]').val();
				getPrivileges(userId, userName, userPrivileges, adminId);
			});
		}

		var handleValidate = function(){
			wapData.validate({
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
		        	$("input[name='txt_add_first[]']", wapData).each(function() {
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

			        $("input[name='txt_add_last[]']", wapData).each(function() {
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
			        $("input[name='txt_add_email[]']", wapData).each(function() {
			            if($(this).val() == "" && $(this).val().length < 1) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			                if(isFocus){
			                	$(this).focus();
			                	isFocus = false;
			                }
			            } else {
			                var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		        			var chk_email =  pattern.test($(this).val());
		        			if(!chk_email){
		        				$(this).closest('.in-group').addClass('has-error');
				                isValid = false;
				                if(isFocus){
				                	$.bootstrapGrowl("Email invalid.", { 
							        	type: 'danger' 
							        });
				                	$(this).focus();
				                	isFocus = false;
				                }
		        			}else{
		        				$(this).closest('.in-group').removeClass('has-error');
		        			}
			            }
			        });
			       	$("input.pass_addAdmin", wapData).each(function() {
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
			        	Kiosk.blockUI();
			        	var data = $("form#frm-add-admin").serializeArray();
						$.ajax({
							url: '<?php echo url::base() ?>admin_customers/save_add_admin',
							type: 'POST',
							dataType: 'json',
							data: data,
						})
						.done(function(data) {
							if(data == ''){
								$.bootstrapGrowl("Email must be unique.", { 
						        	type: 'danger' 
						        });
								return false;
							}
							$('#wp-admin-containt').empty();
							if(data != '' && typeof(data['txt_add_first']) != "undefined" && data['txt_add_first'] != ''){
								$.each(data['txt_add_first'], function(index, element) {
						            $('#wp-admin-containt').append(
						            	'<input type="text" name="txt_add_first[]" value="'+element+'" />'
						            );
						        });
						        $.each(data['txt_add_last'], function(index, element) {
						            $('#wp-admin-containt').append(
						            	'<input type="text" name="txt_add_last[]" value="'+element+'" />'
						            );
						        });
								$.each(data['txt_add_adminId'], function(index, element) {
						            $('#wp-admin-containt').append(
						            	'<input type="text" name="txt_add_adminId[]" value="'+element+'" />'
						            );
						        });
								$.each(data['txt_add_email'], function(index, element) {
						            $('#wp-admin-containt').append(
						            	'<input type="text" name="txt_add_email[]" value="'+element+'" />'
						            );
						        });
						        $.each(data['txt_add_password'], function(index, element) {
						           	$('#wp-admin-containt').append(
						            	'<input type="text" name="txt_add_password[]" value="'+element+'" />'
						            );
						        });
						        $.each(data['txt_add_priveileges'], function(index, element) {
						           	$('#wp-admin-containt').append(
						            	'<input type="text" name="txt_privileges[]" value=\''+element+'\' />'
						            );
						        });
						        $.each(data['allow_user'], function(index, element) {
						           	$('#wp-admin-containt').append(
						            	'<input type="text" name="allow_user[]" value="'+element+'" />'
						            );
						        });
						        $.each(data['freeze_user'], function(index, element) {
						           	$('#wp-admin-containt').append(
						            	'<input type="text" name="freeze_user[]" value="'+element+'" />'
						            );
						        });
						    }
					        if($('#frm-store input[name="txt_add_email[]"]').val){
					        	var number_admin = $('#frm-store input[name="txt_add_email[]"]').length;
					        	$('.number_admin').text(number_admin);
					        }
					        $('.close-add-admin').trigger('click');
						})
						.fail(function() {
							$.bootstrapGrowl("Could not complete request.", { 
					        	type: 'danger' 
					        });
						}).always(function() {
			        		Kiosk.unblockUI();
			        	});
			        }
		        }
		    });
		}
		
		var getPrivileges = function (userId, userName, userPrivileges, adminId) {
			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>admin_customers/getFrmDefault',
				type: 'post',
				data:{ 'userId': userId , 'userName': userName, 'userPrivileges': userPrivileges, 'adminId': adminId }
			})
			.done(function(data) {
				var dialogPrivileges = new kioskDialog();
			    dialogPrivileges.init({
			     	"data": data
			    });
			})
			.fail(function() {
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			}).always(function() {
				Kiosk.unblockUI();
			});
		}

		return {
			init: function(frm){
				wapData = frm;
				handleEvent();
				handleValidate();
			},
			getParent: function(){
				return parent;
			}

		}
	}();

	function addItem_admin(){
		$.ajax({
			url: '<?php echo url::base() ?>admin_customers/addItem_admin',
			type: 'GET'
		})
		.done(function(data) {
			$('.wp-item-add-admin').append(data);
			Kiosk.initUniform('.chk_allow_user');
			Kiosk.initUniform('.chk_freeze_user');
		})
		.fail(function() {
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}
</script>