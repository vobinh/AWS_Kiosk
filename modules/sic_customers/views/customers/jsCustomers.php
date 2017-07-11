<script type="text/javascript">
	var Customers = function() {
		var tbCustomers;
		var wapCustomers;
		var myModal;
		var loadCustomers = function (){
			var _main_count = '<?php echo $total_user ?>';
			tbCustomers = new Datatable();
			tbCustomers.setAjaxParam('_main_count', _main_count);
			tbCustomers.init({
				src: $("#tb-customers"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"url" : "<?php echo url::base()?>customers/jsCustomer"
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
		                "data": "tdStoreName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdAccID",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdPoint",
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
		                "data": "tdDate",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdNote",
		                "orderable": false
		            }],
		            scroller: {
			            loadingIndicator: false
			        },
				}
			});

			tbCustomers.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbCustomers.getDataTable().row( tr );
				var trId = row.data().DT_RowId;

				editCustomers(1, trId);
			});

			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbCustomers.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			} );
		};
		
		var handleEvent = function(){
			var delayMilli;
			var cus_nondisplay = <?php echo $cus_nondisplay ?>;
			tbCustomers.getDataTable().columns(cus_nondisplay).visible(false,false);
			$('.cls-columns', wapCustomers).click(function(event) {
				var nonSelected = [];
				$('.cls-columns').each(function() {
					if(!$(this).is(':checked')){
						nonSelected.push($(this).val());
					}
				});
				var column = tbCustomers.getDataTable().column($(this).val());
				column.visible(!column.visible());
				window.clearTimeout(delayMilli);
				delayMilli = window.setTimeout(function(){
			       handleAutosave(nonSelected);
			    },1000);
			});

			wapCustomers.on('click', '.cus-store', function(event) {
				event.preventDefault();
				var selected = Customers.get().getSelectedID();
				if(selected.length > 0){
					$('#slt_change_store').val(-1).trigger('change');
					$('.cls-count').text(selected.length);
					$('input[name="txt_id_change"]').val(selected);			
					myModal.modal('show');
					
				}else{
					notification('danger', 'No record selected.');
				}
			});

			myModal.on('click', '.bnt-change-store', function(event) {
				event.preventDefault();
				$('.cls-error-change-store').hide();
				var slt = $('#slt_change_store').val();
				if(slt == null || slt == -1){
					$('.cls-error-change-store').show();
					return false;
				}
				Kiosk.blockUI();
				$('#frm-change-store').submit();
			});
		};

		var handleAutosave = function(item){
			$.ajax({
				url: '<?php echo url::base() ?>customers/autoSave/nonDisplay',
				type: 'POST',
				dataType: 'json',
				data: { txt_non_display: item },
			})
			.done(function(data) {
			})
			.fail(function() {})
			.always(function() {});
			
		}
		return {
	        init: function () {
				wapCustomers = $('.wap-list-customer');
				myModal      = $('#myModal');
	            loadCustomers();
	            handleEvent();
	            $('.slt-select2').select2({ minimumResultsForSearch: -1 });

	        },
	        get: function(){
				return tbCustomers;
			}
	    };
	}();

	function delCustomers(type){
		var selected = Customers.get().getSelectedID();
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
								url: '<?php echo url::base() ?>customers/delete/customers',
								type: 'POST',
								dataType: 'json',
								data: {'chk_customer': selected},
							})
							.done(function(data) {
								Kiosk.unblockTableUI('.table-datatable');
								var datatable    = Customers.get().getDataTable();
								var tablewrapper = Customers.get().getTableWrapper();
								var table        = Customers.get().getTable();
								Customers.get().clearSelectedID();
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

	function editCustomers(type, id){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>customers/getEditCustomers/'+type,
			type: 'POST',
			data: { 'idCustomer': id }
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
	}

	function addCustomers(type){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>customers/getAddCustomers/'+type,
			type: 'GET'
		})
		.done(function(data) {
			$('.page-quick-wap').html(data);
			toogleQuick();
			Kiosk.unblockUI();
			//if(_store_id_scription != 0)
			nextCode(type);
		})
		.fail(function() {
			Kiosk.unblockUI();
			$.bootstrapGrowl("Could not complete request.", { 
	        	type: 'danger' 
	        });
		});
	}

	$(document).ready(function() {		
		Customers.init();
	});

	function checkCode(input_code, form){
		if ($(".txt_cus_store")[0]){
		    if($(".txt_cus_store").val() == ''){
		    	$.bootstrapGrowl("Please select store.", { 
		        	type: 'danger' 
		        });
		        return false;
		    }else{
		    	var store_id = $(".txt_cus_store").val();	
		    }
		}else{
		    var store_id  = '';
		}

		var type = $(form).find("#txt_type").val();
    	Kiosk.blockUI({
            target: '.page-quick-wap'
        });
    	$.ajax({
    		url: '<?php echo url::base() ?>customers/checkCode/'+type,
    		type: 'POST',
    		dataType: 'json',
    		data: {'txt_code': input_code, 'store_id':store_id},
    	})
    	.done(function(data) {
    		Kiosk.unblockUI('.page-quick-wap');
    		if(data['result'] == true){
    			$('.customers-error').hide();
    			form.submit();
    		}else{
    			$('.customers-error').parent('.in-group').addClass('has-error');
    			$('.cus-help-block').text(data['msg']);
    			$('.customers-error').show();
    		}
    	})
    	.fail(function() {
    		Kiosk.unblockUI('.page-quick-wap');
    	});
    }

	function nextCode(type){
		var txt_hd_id        = $('input[name="txt_hd_id"]').val();
		var txt_cus_store_id = $('input[id="txt_cus_store_id"]').val();
		var txt_cus_store    = $('select[name="txt_cus_store"]').val();

		if(_store_id_scription == 0 && txt_hd_id != ''){
			if(txt_cus_store_id == txt_cus_store){
	        	var _txt_ecus_no = $('input[id="txt_ecus_no"]').val();
        		$('input[name="txt_cus_no"]').val(_txt_ecus_no);
	        	$('.customers-error').parent('.in-group').removeClass('has-error');
	    		$('.customers-error').hide();
	        	return false;
	        }
		}else if(_store_id_scription != 0 && txt_hd_id != ''){
			var _txt_ecus_no = $('input[id="txt_ecus_no"]').val();
        	$('input[name="txt_cus_no"]').val(_txt_ecus_no);
        	$('.customers-error').parent('.in-group').removeClass('has-error');
    		$('.customers-error').hide();
        	return false;
		}

		Kiosk.blockUI({
            target: '.page-quick-wap'
        });

    	$.ajax({
    		url: '<?php echo url::base() ?>customers/nextCode/'+type,
    		type: 'get',
    		dataType: 'json',
    		//data: {'store_id': store_id},
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
    	});
    }

    function _init_Add_Customers(){
    	$(document).ready(function() {	
    		$('select[name="txt_cus_store"]').change(function(event) {
				nextCode();
			});
			Kiosk.intOnly('.intOnly');
			if (jQuery().datepicker) {
		        $('.date-picker').datepicker({
		            rtl: Kiosk.isRTL(),
		            orientation: "auto",
		            autoclose: true
		        });
		    }
			$('input[name="txt_cus_no"]').focus();
			$('#frm-customers').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
		            txt_cus_no: {
		                required: true
		            },
		            txt_cus_first_name: {
		                required: true
		            },
		            txt_cus_last_name: {
		                required: true
		            },
		            txt_cus_address: {
		                required: true
		            },
		            txt_cus_city: {
		                required: true
		            },
		            txt_cus_state: {
		                required: true
		            },
		            txt_cus_zip: {
		                required: true
		            },
		            txt_cus_phone: {
		                required: true
		            },
		            txt_cus_email: {
		                required: true,
		                email: true
		            },
		        },

		        messages: {
		            txt_cus_no: {
		                required: "Customer No is required."
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
					var _input           = $('input[name="txt_cus_no"]').val();
					var _txt_ecus_no     = $('input[id="txt_ecus_no"]').val();
					var txt_hd_id        = $('input[name="txt_hd_id"]').val();
					var txt_cus_store_id = $('input[id="txt_cus_store_id"]').val();
					var txt_cus_store    = $('select[name="txt_cus_store"]').val();
		        	if(txt_hd_id == '')
		        		checkCode(_input, form);
		        	else{
		        		if(_input != _txt_ecus_no || (txt_cus_store_id != txt_cus_store && _store_id_scription == 0)){
		        			checkCode(_input, form);
		        		}else{
		        			Kiosk.blockUI();
		        			form.submit();
		        		}
		        	}
		        }
		    });

		    $('#frm-customers input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-customers').validate().form()) {
		                $('#frm-customers').submit();
		            }
		            return false;
		        }
		    });
		    
		});
    }
</script>