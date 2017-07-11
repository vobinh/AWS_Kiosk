<script type="text/javascript">
	var registryWarehouse = function() {
		var wapReistry;
		var tbRegistry;
		var dialogAdd;
		var loadRegistry = function (){
			
			tbRegistry = new Datatable();

			tbRegistry.init({
				src: $("#tb-registry"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '300px',
					"ajax":{
						"url" : "<?php echo url::base()?>warehouse/getDataRegistry",
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
		                "data": "tdCostStores",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdCostWarehouse",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdUnit",
		                "orderable": false
		            },{
		            	"class": "slt-row cls-center",
		                "data": "tdLifeStore",
		                "orderable": false
		            },{
		            	"class": "slt-row cls-center",
		                "data": "tdLifeWareHouse",
		                "orderable": false
		            },{
		            	"data": null,
		                "class": "slt-row cls-right",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
							return '<a href="javascript:;" class="btn btn-sm green btn-update"><i class="fa fa-edit"></i></a><a href="javascript:;" class="btn btn-sm red btn-delete"><i class="fa fa-times"></i></a>';
		                }
		            }],
		            scroller: {
			            loadingIndicator: false,
			            rowHeight: 45
			        },
				}
			});
			
			wapReistry.on('click', '.btn-add-registry', function(event) {
				event.preventDefault();
				frmAddItemRegistry();
			});

			tbRegistry.getTable().on('click', '.btn-update', function(e) {
				e.preventDefault();

				var tr   = $(this).closest('tr');
				var row  = tbRegistry.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				registryWarehouse.edit(trId);
				//addCatalog();deleteItem
			});

			tbRegistry.getTable().on('click', '.btn-delete', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbRegistry.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				registryWarehouse.deleteItem(trId);
			});

			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbRegistry.getDataTable();
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
	        	wapReistry = $('.wap-list-registry');
	        	Kiosk.initUniform($('.chk-all', tbRegistry));
	            loadRegistry();
	        },
	        add: function(){
	        	Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>warehouse/getAddRegistry',
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
					url: '<?php echo url::base() ?>warehouse/getEditRegistry',
					type: 'POST',
					data: { 'id': id }
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
				var selected = tbRegistry.getSelectedID();
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
									url: '<?php echo url::base() ?>warehouse/deleteRegistry',
									type: 'POST',
									dataType: 'json',
									data: {'id_registry': selected},
								})
								.done(function(data) {
									Kiosk.unblockTableUI('.table-datatable');
									if(data['msg'] == true){
										$.bootstrapGrowl("Save change.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl("Error.", { 
							            	type: 'danger' 
							            });
									}
									var datatable    = tbRegistry.getDataTable();
									var tablewrapper = tbRegistry.getTableWrapper();
									var table        = tbRegistry.getTable();

									tbRegistry.clearSelectedID();

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
			},
			deleteItem: function(id){
				var selected = [];
				selected.push(id); 
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
								url: '<?php echo url::base() ?>warehouse/deleteRegistry',
								type: 'POST',
								dataType: 'json',
								data: {'id_registry': selected},
							})
							.done(function(data) {
								Kiosk.unblockTableUI('.table-datatable');
								if(data['msg'] == true){
									$.bootstrapGrowl("Save change.", { 
						            	type: 'success' 
						            });
								}else{
									$.bootstrapGrowl("Error.", { 
						            	type: 'danger' 
						            });
								}
								var datatable    = tbRegistry.getDataTable();
								var tablewrapper = tbRegistry.getTableWrapper();
								var table        = tbRegistry.getTable();

								tbRegistry.clearSelectedID();

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
		registryWarehouse.init();
	});
</script>