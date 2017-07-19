<script type="text/javascript">
	var distributionWarehouse = function() {
		var wapDistribution;
		var tbDistribution;
		var dialogAdd;
		var handleEvent = function(){
			wapDistribution.on('click', '.btn-add-distribution', function(event) {
				event.preventDefault();
				frmAddItemDistribution();
			});

			tbDistribution.getTable().on('click', '.btn-approve', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbDistribution.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				distributionWarehouse.approve(trId);
			});

			tbDistribution.getTable().on('click', '.btn-reject', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbDistribution.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				distributionWarehouse.reject(trId);
			});

			tbDistribution.getTable().on('click', '.btn-delete', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbDistribution.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				distributionWarehouse.deleteItem(trId);
			});

			wapDistribution.on('click', '.btn-filter', function(e) {
				e.preventDefault();
				var val = $(this).attr('data-name');
				$('.btn-filter', wapDistribution).removeClass('green').addClass('default').prop('disabled', false);
				$(this).addClass('green').prop('disabled', true);
				
				var datatable    = tbDistribution.getDataTable();
				var tablewrapper = tbDistribution.getTableWrapper();
				var table        = tbDistribution.getTable();

				tbDistribution.clearSelectedID();
				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				tbDistribution.setAjaxParam("show-filter", val);
				datatable.ajax.reload();
			});

			wapDistribution.on('change', '.chk_auto_delete', function(event) {
				event.preventDefault();
				if($(this).is(':checked')){
					var datatable    = tbDistribution.getDataTable();
					var tablewrapper = tbDistribution.getTableWrapper();
					var table        = tbDistribution.getTable();

					tbDistribution.clearSelectedID();
					$('.chk-all', tablewrapper).prop('checked',false);
					Kiosk.updateUniform('.chk-all', tablewrapper);
					tbDistribution.setAjaxParam("auto-delete", 1);
					datatable.ajax.reload();
				}else{
					var datatable    = tbDistribution.getDataTable();
					var tablewrapper = tbDistribution.getTableWrapper();
					var table        = tbDistribution.getTable();

					tbDistribution.clearSelectedID();
					$('.chk-all', tablewrapper).prop('checked',false);
					Kiosk.updateUniform('.chk-all', tablewrapper);
					tbDistribution.setAjaxParam("auto-delete", 0);
					datatable.ajax.reload();
				}
			});
			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbDistribution.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			});

			/* EXPORT */
			wapDistribution.on('click', '.distribution-csv', function(event) {
				event.preventDefault();
				var selected = tbDistribution.getSelectedID();
	        	if(selected.length > 0){
	        		$('<form>', {
					    "id": "exportMenu",
					    "html": '<input type="hidden" id="txt_id_selected" name="txt_id_selected" value="' + selected + '" />',
					    "action": '<?php echo url::base() ?>warehouse/exportDistribution',
					    "method": 'post'
					}).appendTo(document.body).submit();
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			});
		};

		var loadDistribution = function (){
			tbDistribution = new Datatable();
			tbDistribution.init({
				src: $("#tb-distribution"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '300px',
					"ajax":{
						"url" : "<?php echo url::base()?>warehouse/getDataDistribution",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_Distribution[]' value='"+full.tdID+"'>";
		                }
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdIcon){
		                		return "<div class='icon-catalog'><img style='width:28px;' src='<?php echo $this->hostGetImg ?>?files_id="+full.tdIcon+"' alt=''></div>";
		                	}else{
		                		return "<div class='icon-catalog'></div>";
		                	}
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdSubCategory",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdSKU",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdStore",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdCostStores",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdCostWarehouse",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdQty",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdTotal",
		                "orderable": false
		            },{
		            	"data": null,
		                "class": "cls-right",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdComplete == 1 || full.tdComplete == 0){
		                		var _btnApprove = '<button disabled class="btn btn-sm grey-cascade"><i class="fa fa-check-circle"></i></button>';
		                		var _btnReject  = '<button disabled class="btn btn-sm btn-warning"><i class="fa fa-thumbs-o-down"></i></button>';
		                	}else if(full.tdComplete == 3){
		                		var _btnReject  = '<button disabled class="btn btn-sm grey-cascade"><i class="fa fa-thumbs-o-down"></i></button>';
		                		var _btnApprove = '<button disabled class="btn btn-sm green"><i class="fa fa-check-circle"></i></button>';
		                	}else{
		                		if(full.tdStatus == true){
			                		var _btnApprove = '<button disabled class="btn btn-sm green"><i class="fa fa-check-circle"></i></button>';
			                	}else{
			                		var _btnApprove = '<button class="btn btn-sm green btn-approve"><i class="fa fa-check-circle"></i></button>';
			                	}
			                	var _btnReject  = '<button class="btn btn-sm btn-warning btn-reject"><i class="fa fa-thumbs-o-down"></i></button>';
		                	}
		                	
		                	
		                	var _btnDelete  = '<button class="btn btn-sm red btn-delete"><i class="fa fa-times"></i></button>';
							return _btnApprove+_btnReject+_btnDelete;
		                }
		            }],
		            scroller: {
			            loadingIndicator: false,
			            rowHeight: 45
			        },
			        footerCallback: function ( row, data, start, end, display ) {
			        	var response = this.api().ajax.json();
			        	$('.lb-count-order').text(response['totalOrder']);
			        	if(response['countDelete'] > 0){
							$.bootstrapGrowl(response['countDelete']+" items deleted.", { 
				            	type: 'success' 
				            });
						}
			        }
				}
			});
		}
		
		return {
	        init: function () {
	        	wapDistribution = $('.wap-list-distribution');
	        	Kiosk.initUniform($('.chk-all', tbDistribution));
	            loadDistribution();
	            handleEvent();
	        },
	        approve: function(id){
	        	$.ajax({
					url: '<?php echo url::base() ?>warehouse/approveDistribution',
					type: 'POST',
					dataType: 'json',
					data: {'id_store_order': id},
				})
				.done(function(data) {
					Kiosk.unblockTableUI('.table-datatable');
					if(parseInt(data['msg']) > 0){
						$.bootstrapGrowl(data['msg']+" item approved.", { 
			            	type: 'success' 
			            });
					}else{
						$.bootstrapGrowl(data['msg']+" item approved.", { 
			            	type: 'danger' 
			            });
					}
					var datatable    = tbDistribution.getDataTable();
					var tablewrapper = tbDistribution.getTableWrapper();
					var table        = tbDistribution.getTable();

					tbDistribution.clearSelectedID();

					$('.chk-all', tablewrapper).prop('checked',false);
					Kiosk.updateUniform('.chk-all', tablewrapper);
					datatable.ajax.reload();

				})
				.fail(function() {
					Kiosk.unblockTableUI('.table-datatable');
					$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
		            	type: 'danger' 
		            });
				});
	        },
	        reject: function(id){
	        	$.ajax({
					url: '<?php echo url::base() ?>warehouse/rejectDistribution',
					type: 'POST',
					dataType: 'json',
					data: {'id_store_order': id},
				})
				.done(function(data) {
					Kiosk.unblockTableUI('.table-datatable');
					if(parseInt(data['msg']) > 0){
						$.bootstrapGrowl(data['msg']+" item rejected.", { 
			            	type: 'success' 
			            });
					}else{
						$.bootstrapGrowl(data['msg']+" item rejected.", { 
			            	type: 'danger' 
			            });
					}
					var datatable    = tbDistribution.getDataTable();
					var tablewrapper = tbDistribution.getTableWrapper();
					var table        = tbDistribution.getTable();

					tbDistribution.clearSelectedID();

					$('.chk-all', tablewrapper).prop('checked',false);
					Kiosk.updateUniform('.chk-all', tablewrapper);
					datatable.ajax.reload();

				})
				.fail(function() {
					Kiosk.unblockTableUI('.table-datatable');
					$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
		            	type: 'danger' 
		            });
				});
	        },
	        action: function(type){
	        	var actions = ['approve', 'reject'];
	        	if( actions.indexOf(type) < 0 ){
	        		type = 'approve';
	        	}
				var selected = tbDistribution.getSelectedID();
				var msg      = 'Are you sure you want to '+type+' this record ?';
				if(selected.length > 0){
					bootbox.confirm({
			            message: msg,
			            title: type.toUpperCase(),
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
			            		if(type == 'approve'){
			            			distributionWarehouse.approve(selected);
			            		}else{
			            			distributionWarehouse.reject(selected);
			            		}
		                    }
		                }
			        });
				}else{
					$.bootstrapGrowl("No record selected.", { 
		            	type: 'danger' 
		            });
				}

	        },
	        delete: function(){
				var selected = tbDistribution.getSelectedID();
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
									url: '<?php echo url::base() ?>warehouse/deleteDistribution',
									type: 'POST',
									dataType: 'json',
									data: {'id_store_order': selected},
								})
								.done(function(data) {
									Kiosk.unblockTableUI('.table-datatable');
									if(parseInt(data['msg']) > 0){
										$.bootstrapGrowl(data['msg']+" item deleted.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl(data['msg']+" item deleted.", { 
							            	type: 'danger' 
							            });
									}
									var datatable    = tbDistribution.getDataTable();
									var tablewrapper = tbDistribution.getTableWrapper();
									var table        = tbDistribution.getTable();

									tbDistribution.clearSelectedID();

									$('.chk-all', tablewrapper).prop('checked',false);
									Kiosk.updateUniform('.chk-all', tablewrapper);
									datatable.ajax.reload();

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
			deleteItem: function(id){ 
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
								url: '<?php echo url::base() ?>warehouse/deleteDistribution',
								type: 'POST',
								dataType: 'json',
								data: {'id_store_order': id},
							})
							.done(function(data) {
								Kiosk.unblockTableUI('.table-datatable');
								if(parseInt(data['msg']) > 0){
									$.bootstrapGrowl(data['msg']+" item rejected.", { 
						            	type: 'success' 
						            });
								}else{
									$.bootstrapGrowl(data['msg']+" item rejected.", { 
						            	type: 'danger' 
						            });
								}
								var datatable    = tbDistribution.getDataTable();
								var tablewrapper = tbDistribution.getTableWrapper();
								var table        = tbDistribution.getTable();

								tbDistribution.clearSelectedID();

								$('.chk-all', tablewrapper).prop('checked',false);
								Kiosk.updateUniform('.chk-all', tablewrapper);
								datatable.ajax.reload();

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
			}
	    };
	}();

	$(document).ready(function() {
		distributionWarehouse.init();
	});
</script>