<?php $role = $this->mPrivileges; ?>
<script type="text/javascript">
	var pagePrivileges = function(){
		var wapData = $('.wap-list-admin');
		var tbData;
		var handleInput = function(){

		};

		var handleEvent = function(){
			$('#slt_store_active').change(function(event) {
				Kiosk.blockUI();
				var storeId = $(this).val();
				window.location.href = '<?php echo url::base() ?>settings/setStore/'+storeId+'/privileges';
			});

			tbData.getTable().on('click', '.btn-set-user-default', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbData.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				bootbox.confirm({
		            message: "Are you sure you want to use the default setting ?",
		            title: "Warning",
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
	            			Kiosk.blockTableUI();
	                      	$.ajax({
								url: '<?php echo url::base() ?>settings/setPrivilegesDefault',
								type: 'POST',
								dataType: 'json',
								data: { 'userId': trId }
							})
							.done(function(data) {
								Kiosk.unblockTableUI();
								if(data['status']){
									$.bootstrapGrowl(data['msg'], { 
						            	type: 'success' 
						            });
								}else{
									$.bootstrapGrowl(data['msg'], { 
						            	type: 'error' 
						            });
								}
								
							})
							.fail(function() {
								Kiosk.unblockTableUI();
								$.bootstrapGrowl("Could not complete request.", { 
					            	type: 'danger' 
					            });
							});
	                    }
	                }
		        });
			});

			tbData.getTable().on('click', '.btn-view', function(e) {
				e.preventDefault();
				var tr     = $(this).closest('tr');
				var row    = tbData.getDataTable().row( tr );
				var trId   = row.data().DT_RowId;
				var tdName = row.data().tdName;
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>settings/getFrmDefault',
					type: 'post',
					data:{ 'userId': trId , 'userName': tdName }
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				}).always(function() {
					Kiosk.unblockUI();
				});
				//frmGeneral.edit(trId);
			});

			wapData.on('click', '.btn-set-dafault', function(event) {
				event.preventDefault();
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>settings/getFrmDefault',
					type: 'get'
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				}).always(function() {
					Kiosk.unblockUI();
				});
			});
		};

		var handleValidate = function(){

		};

		var loadDataUser = function(){
			tbData = new Datatable();
			tbData.init({
				src: $("#tb-privileges"),
				wapHeight: "395px",
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '350px',
					"ajax":{
						"url" : "<?php echo url::base()?>settings/getDataAdmin",
					},
					"columns": [{
		            	"class": "slt-row",
		                "data": "tdName",
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
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdFreeze == '3'){
		                		return 'YES';
		                	}else{
		                		return 'NO';
		                	}
		                    
		                }
		            },{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	<?php if($role == 'NoAccess' || (is_array($role) && substr($role['settings_privileges'], -1) == '0')): ?>
		                    	return '<button type="button" class="btn btn-sm green btn-view">View</button>';
		                	<?php else: ?>
		                		return '<button type="button" class="btn btn-sm green btn-set-user-default">Set to Default</button><button type="button" class="btn btn-sm green btn-view">View</button>';
		                	<?php endif ?>
		                }
		            }],
		            scroller: {
			            loadingIndicator: false,
			            //rowHeight: 45
			        },
				}
			});
		};

		var handleFrmEvent = function(){
			$('input[name="txt_acc_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-acc-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-acc-r');
			});
			$('input[name="txt_acc_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-acc-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-acc-w');
				/*if(c){
					$('.cls-acc-r:checkbox').prop('checked',c);
					Kiosk.updateUniform('.cls-acc-r');
				}*/
			});

			$('.cls-acc-w:checkbox').click(function(event) {
				/*var c = this.checked;
				if(c){
					var _item = $(this).parents('td').prev('td').find('.cls-acc-r:checkbox');
					_item.prop('checked',c);
					Kiosk.updateUniform(_item);
				}*/
			});

			$('input[name="txt_operations_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-operations-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-operations-r');
			});
			$('input[name="txt_operations_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-operations-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-operations-w');
			});

			$('input[name="txt_marketing_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-marketing-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-marketing-r');
			});
			$('input[name="txt_marketing_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-marketing-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-marketing-w');
			});

			$('input[name="txt_reports_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-reports-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-reports-r');
			});
			$('input[name="txt_reports_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-reports-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-reports-w');
			});

			$('input[name="txt_employees_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-employees-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-employees-r');
			});
			$('input[name="txt_employees_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-employees-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-employees-w');
			});

			$('input[name="txt_settings_r"]').click(function(event) {
				var c = this.checked;
				$('.cls-settings-r:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-settings-r');
			});
			$('input[name="txt_settings_w"]').click(function(event) {
				var c = this.checked;
				$('.cls-settings-w:checkbox').prop('checked',c);
				Kiosk.updateUniform('.cls-settings-w');
			});
		};

		return {
			init: function(){
				loadDataUser();
				handleEvent();
			},
			frmSetDefault: function(){
				Kiosk.initUniform('input[type="checkbox"]');
				handleFrmEvent();
			}
		}
	}();

	$(document).ready(function() {
		pagePrivileges.init();
	});
</script>