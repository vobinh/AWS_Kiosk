<?php $role = $this->mPrivileges; ?>
<script type="text/javascript" src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript">
	var frmGeneral = function(){
		var wapData;
		var tbData;
		var handleInput = function(){
			$('#frm-store input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-store').validate().form()) {
		                $('#frm-store').submit();
		            }
		            return false;
		        }
		    });
		    Kiosk.intOnly('.intOnly');
			$(".decimal").inputmask('decimal',{rightAlign: true});
			$('.slt-select2').select2({ minimumResultsForSearch: -1 });
		};

		var handleEvent = function(){
			$('#slt_store_active').change(function(event) {
				Kiosk.blockUI();
				var storeId = $(this).val();
				window.location.href = '<?php echo url::base() ?>settings/setStore/'+storeId+'/general';
			});
		};

		var handleValidate = function(){
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
		            txt_store_tax: {
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
		        	Kiosk.blockUI();
					form.submit();
		        }
		    });
		};

		var handleValidatePayment = function(){
			$('#frm-store-2').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
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
		        	Kiosk.blockUI();
					form.submit();
		        }
		    });
		};

		var loadDataMachine = function(){
			var idStore = '<?php echo (string)base64_decode($this->sess_cus["storeId"]) ?>';
			if(idStore == '0')
				idStore = '<?php echo $this->_getStoreUsing() ?>';
			tbData      = new Datatable();
			tbData.setAjaxParam('storeId', idStore);
			tbData.init({
				src: $("#tb-machine"),
				wapHeight: "295px",
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '250px',
					"ajax":{
						"url" : "<?php echo url::base()?>settings/getDataMachine",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_registry[]' value='"+full.tdID+"'>";
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdNo",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdIP",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdMAC",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdDate",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdStatus",
		                "orderable": false
		            }],
		            scroller: {
			            loadingIndicator: false,
			            //rowHeight: 45
			        },
				}
			});
			
			tbData.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbData.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				frmGeneral.edit(trId);
			});

		};
		return {
			init: function(){
				handleInput();
				<?php if($role == 'FullAccess' || (is_array($role) && substr($role['settings_general'],0, 1) == '1')): ?>
					handleValidate();
					handleValidatePayment();
					handleEvent();
					loadDataMachine();
				<?php endif ?>
				<?php if($role == 'NoAccess' || (is_array($role) && substr($role['settings_general'], -1) == '0')): ?>
					$('#frm-store').attr('action', 'javascript:void(0);');
					$('#frm-store-1').attr('action', 'javascript:void(0);');
					$('#frm-store-2').attr('action', 'javascript:void(0);');
				<?php endif ?>
			},
			add: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>settings/getAddMachine',
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
					url: '<?php echo url::base() ?>settings/getEditMachine',
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
			action: function(type){
				/*
				* type : 1-Active : 2-Inactive : 3-Delete
				 */
				var selected = tbData.getSelectedID();
				if(selected.length > 0){
					Kiosk.blockUI();
					$.ajax({
						url: '<?php echo url::base() ?>settings/setStatusMachine',
						type: 'POST',
						dataType: 'json',
						data: {
							'id': selected,
							'action': type
						},
					})
					.done(function(data) {
						Kiosk.unblockUI();
						if(data['msg'] == true){
				          	$.bootstrapGrowl(data.total+" items save change.", { 
				                type: 'success' 
				            });
				        }else{
				          	$.bootstrapGrowl("Could not complete request.", { 
				                type: 'danger' 
				            });
				        }
						frmGeneral.reloadData();
					})
					.fail(function() {
						Kiosk.unblockUI();
						$.bootstrapGrowl("Could not complete request.", { 
				        	type: 'danger' 
				        });
					});
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			},
			frmInvalidate: function(){
				$('#txt_name').select2({ minimumResultsForSearch: -1 });
				$('#frm-machine').validate({
			        errorElement: 'span',
			        errorClass: 'help-block',
			        focusInvalid: false,
			        rules: {
			            txt_name: {
			                required: true
			            },
			            txt_serial: {
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
			        	form.submit();
			        }
			    });
			},
			reloadData: function(){
				var datatable    = tbData.getDataTable();
				var tablewrapper = tbData.getTableWrapper();
				var table        = tbData.getTable();

				tbData.clearSelectedID();

				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			}
		}
	}();

	$(document).ready(function() {
		frmGeneral.init();  
	});
</script>