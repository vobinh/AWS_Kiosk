<script type="text/javascript">
	var employees = function(){
		var wapList, tbList, myModal;

		var handleEvent = function(){
			$('#slt_store_active', wapList).change(function(event) {
				tbList.setAjaxParam('store_id', $(this).val());
				employees.reloadData();

			});

			wapList.on('click', '.empl-store', function(event) {
				event.preventDefault();
				var selected = tbList.getSelectedID();
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

		var loadList = function (storeId){

			tbList = new Datatable();
			tbList.setAjaxParam('store_id', storeId);
			tbList.setAjaxParam('_main_count', '<?php echo $total_items ?>');
			tbList.init({
				src: $("#tb-employees"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"type": "POST",
						"url" : "<?php echo url::base()?>employees/jsDataEmployees",
						/*data: function( d ){
		                    d._main_count = '<?php echo $total_items ?>'
		                }*/
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
		                "data": "tdStoreName",
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

				employees.edit(trId);
			});

			if(_store_id_scription == 0){
				var datatable_employees    = tbList.getDataTable();
				datatable_employees.column(2).visible( true );
			}else{ 
				var datatable_employees    = tbList.getDataTable();
				datatable_employees.column(2).visible( false );
			} 

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
				wapList = $('.wap-list-employees');
				myModal = $('#myModal');
				
				var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapList).val();
				}
				loadList(storeId);
				handleEvent();
				$('.slt-select2').select2({ minimumResultsForSearch: -1 });
				
			},
			add: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>employees/getAdd',
					type: 'GET'
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
					Kiosk.unblockUI();
					//if(_store_id_scription != 0)
					nextCode();
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
					url: '<?php echo url::base() ?>employees/getEdit',
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
									url: '<?php echo url::base() ?>employees/delete',
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
									var datatable    = tbList.getDataTable();
									var tablewrapper = tbList.getTableWrapper();
									var table        = tbList.getTable();

									tbList.clearSelectedID();

									$('.chk-all', tablewrapper).prop('checked',false);
									Kiosk.updateUniform('.chk-all', tablewrapper);
									datatable.ajax.reload();

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
			reloadData: function(){
				var datatable    = tbList.getDataTable();
				var tablewrapper = tbList.getTableWrapper();
				
				tbList.clearSelectedID();
				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			},
		};
	}();

	$(document).ready(function() {
		employees.init();
	});

	function checkCode(input_code, form){
		if ($(".txt_empl_store")[0]){
		    if($(".txt_empl_store").val() == ''){
		    	$.bootstrapGrowl("Please select store.", { 
		        	type: 'danger' 
		        });
		        return false;
		    }else{
		    	var store_id = $(".txt_empl_store").val();	
		    }
		}else{
		    var store_id  = '';
		}

		var url  = form.action;
    	Kiosk.blockUI({
            target: '.page-quick-wap'
        });
    	$.ajax({
    		url: '<?php echo url::base() ?>employees/checkCode',
    		type: 'POST',
    		dataType: 'json',
    		data: {
    			'txt_code': input_code,
    			'code_old': '<?php echo !empty($data["access_no"])?$data["access_no"]:''; ?>',
    			'store_id': store_id
    		},
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

	function nextCode(){
		var txt_hd_id        = $('input[name="txt_hd_id"]').val();
		var txt_access_store = $('input[id="txt_access_store"]').val();
		var txt_empl_store   = $('select[name="txt_empl_store"]').val();
		if(_store_id_scription == 0 && txt_hd_id != ''){
			if(txt_access_store == txt_empl_store){
	        	var _txt_ecus_no = $('input[id="txt_access_no"]').val();
	        	$('input[name="txt_empl_no"]').val(_txt_ecus_no);
	        	$('.customers-error').parent('.in-group').removeClass('has-error');
	    		$('.customers-error').hide();
	        	return false;
	        }
		}else if(_store_id_scription != 0 && txt_hd_id != ''){
			var _txt_ecus_no = $('input[id="txt_access_no"]').val();
        	$('input[name="txt_empl_no"]').val(_txt_ecus_no);
        	$('.customers-error').parent('.in-group').removeClass('has-error');
    		$('.customers-error').hide();
        	return false;
		}
		
		Kiosk.blockUI({
            target: '.page-quick-wap'
        });
    	$.ajax({
    		url: '<?php echo url::base() ?>employees/nextCode',
    		type: 'get',
    		dataType: 'json',
    	})
    	.done(function(data) {
    		if(data['msg'] == 'true'){
    			$('input[name="txt_empl_no"]').val(data['code']);
    			$('.customers-error').parent('.in-group').removeClass('has-error');
    			$('.customers-error').hide();
    		}else{
    			$('.customers-error').parent('.in-group').addClass('has-error');
    			$('.customers-error').show();
    		}
    		Kiosk.unblockUI('.page-quick-wap');
    	})
    	.fail(function() {
    		Kiosk.unblockUI('.page-quick-wap');
    	});
    }

    function _init_load_frmemployees () {
    	$(document).ready(function() {
    		$('.btn-generate').click(function(event) {
    			Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getGenerate',
					type: 'get',
					dataType: 'json'
				})
				.done(function(data) {
					$('input[name="txt_empl_barcode"]').val(data);
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				}).always(function() {
					Kiosk.unblockUI();
				});
    		});
    		
			$('input[name="txt_empl_no"]').focus();

			Kiosk.intOnly('.intOnly');

			$('#frm-employees').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
		            txt_empl_no: {
		                required: true
		            },
		            txt_empl_first_name: {
		                required: true
		            },
		            txt_empl_last_name: {
		                required: true
		            },
		            txt_empl_pin: {
		                required: '<?php echo !empty($data['access_id'])?false:true ?>'
		            },
		            txt_empl_email: {
		                required: true,
		                email: true
		            },
		        },

		        messages: {
		            txt_empl_no: {
		                required: "Employee No is required."
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
					var _input           = $('input[name="txt_empl_no"]').val();
					var txt_access_no    = $('input[id="txt_access_no"]').val();
					var txt_hd_id        = $('input[name="txt_hd_id"]').val();
					var txt_access_store = $('input[id="txt_access_store"]').val();
					var txt_empl_store   = $('select[name="txt_empl_store"]').val();

		        	if(txt_hd_id == '')
		        		checkCode(_input, form);
		        	else{
		        		if(_input != txt_access_no || (txt_access_store != txt_empl_store && _store_id_scription == 0)){
		        			checkCode(_input, form);
		        		}else{
		        			Kiosk.blockUI();
		        			form.submit();
		        		}
		        	}
		        }
		    });

		    $('#frm-employees input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-employees').validate().form()) {
		                $('#frm-employees').submit();
		            }
		            return false;
		        }
		    });

		    $('select[name="txt_empl_store"]').change(function(event) {
				nextCode();
			});
		});
    }
</script>