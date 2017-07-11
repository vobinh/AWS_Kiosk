<script type="text/javascript">
	var adminCustomers = function(){
		var wapList, tbList;

		var loadList = function (){

			tbList = new Datatable();

			tbList.init({
				src: $("#tb-customers"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"url" : "<?php echo url::base()?>admin_customers/jsDataCustomers",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_customer[]' value='"+full.tdID+"'>";
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdCust",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdAddress",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdPhone",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdEmail",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdDate",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdNote",
		                "orderable": false
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdLevel == 1){
		                		return "Enterprise";
		                	}else{
		                		return "Basic";
		                	}
		                }
		            },{
		                "data": null,
		                "class": "cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdStore == 0){
		                		return "<span title='View Stores' style='font-weight: bold;cursor: pointer;' class='badge badge-danger btn-view-store'>"+full.tdStore+"</span>"; //<button class='btn btn-sm green btn-view-store'><i class='fa fa-edit'></i></button>
		                	}else{
		                		return "<span title='View Stores' style='font-weight: bold;cursor: pointer;' class='badge badge-success btn-view-store'>"+full.tdStore+"</span>"; //<button class='btn btn-sm green btn-view-store'><i class='fa fa-edit'></i></button>
		                	}
		                    
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdStatus",
		                "orderable": false
		            }],
		            scroller: {
			            loadingIndicator: false
			        },
				}
			});

			tbList.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbList.getDataTable().row( tr );
				var trId = row.data().DT_RowId;

				adminCustomers.edit(trId);
			});

			tbList.getTable().on('click', '.btn-view-store', function(e) {
				e.preventDefault();
				var tr     = $(this).closest('tr');
				var row    = tbList.getDataTable().row( tr );
				var trId   = row.data().DT_RowId;
				var trType = row.data().tdLevel;

				adminCustomers.viewStore(trId, trType);
			});
			

			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbList.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			} );
		};

		return{
			init: function(){
				loadList();
			},
			add: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>admin_customers/getAdd',
					type: 'GET'
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				});
			},
			edit: function(id){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>admin_customers/getEdit',
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
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				});
			},
			delete: function(){
				var selected = tbList.getSelectedID();
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
									url: '<?php echo url::base() ?>admin_customers/delete',
									type: 'POST',
									dataType: 'json',
									data: {'id_empl': selected},
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
									adminCustomers.reloadCustomer();

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
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			},
			action: function(type){
				/*
				* type 1: active 2: inactive
				 */
				var selected = tbList.getSelectedID();
				if(selected.length > 0){
					$.ajax({
						url: '<?php echo url::base() ?>admin_customers/setStatusCustomer',
						type: 'POST',
						dataType: 'json',
						data: {
							'idAdmin': selected,
							'action': type
						},
					})
					.done(function(data) {
						adminCustomers.reloadCustomer();
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
			reloadCustomer: function(){
				var datatable    = tbList.getDataTable();
				var tablewrapper = tbList.getTableWrapper();
				var table        = tbList.getTable();

				tbList.clearSelectedID();

				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			},
			viewStore: function(id, type){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>admin_customers/viewStore',
					type: 'POST',
					data: {
						'admin_id': id,
						'admin_type': type
					}
				})
				.done(function(data) {
					var dialogStore = new kioskDialog();
				    dialogStore.init({
				     	"data": data
				    });
					/*$('.page-quick-wap').html(data);
					toogleQuick();*/
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				});
			}
		};
	}();

	$(document).ready(function() {
		adminCustomers.init();
	});
</script>