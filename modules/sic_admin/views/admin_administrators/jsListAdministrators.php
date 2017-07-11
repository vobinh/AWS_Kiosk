<script type="text/javascript">
	var superAdmin = function(){
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
						"url" : "<?php echo url::base()?>admin_administrators/jsDataAdministrators",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdLevel == 1){
		                		return "";
		                	}else{
		                		return "<input type='checkbox' class='item-select' name='chk_customer[]' value='"+full.tdID+"'>";
		                	}
		                    
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdEmail",
		                "orderable": false
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdLevel == 1){
		                		return "<span style='color:red'>Administration</span>";
		                	}else{
		                		return "<span>Super Admin</span>";
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
				<?php if($this->sess_admin['super_level'] == 1): ?>
					var tr   = $(this).closest('tr');
					var row  = tbList.getDataTable().row( tr );
					var trId = row.data().DT_RowId;

					superAdmin.edit(trId);
				<?php endif ?>
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
					url: '<?php echo url::base() ?>admin_administrators/getAdd',
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
					url: '<?php echo url::base() ?>admin_administrators/getEdit',
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
									superAdmin.reloadData();

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
			},
			action: function(type){
				var arrType = ['1', '2'];
				if(arrType.indexOf(type) >= 0){
					var selected = tbList.getSelectedID();
					if(selected.length > 0){
						$.ajax({
							url: '<?php echo url::base() ?>admin_administrators/setStatus',
							type: 'POST',
							dataType: 'json',
							data: {
								'idAdmin': selected,
								'action': type
							},
						})
						.done(function(data) {

							superAdmin.reloadData();

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
				}else{
					$.bootstrapGrowl("Could not complete request.", { 
		            	type: 'danger' 
		            });
				}
			},
			reloadData: function(){
				var datatable    = tbList.getDataTable();
				var tablewrapper = tbList.getTableWrapper();
				var table        = tbList.getTable();

				tbList.clearSelectedID();

				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			}
		};
	}();

	$(document).ready(function() {
		superAdmin.init();
	});
</script>