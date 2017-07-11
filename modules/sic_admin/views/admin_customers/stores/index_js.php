<script>
function addStore(){
	Kiosk.blockUI();
	$.ajax({
		url: '<?php echo url::base() ?>store/getStore/',
		type: 'GET'
	})
	.done(function(data) {
		$('.page-quick-wap').html(data);
		toogleQuick();
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
		url: '<?php echo url::base() ?>store/getEditStore',
		type: 'POST',
		data: { 'store_id': id }
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
					          	$.bootstrapGrowl("Error.", { 
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
var Store = function() {
	var tbStore;

	var loadStore = function (){

		tbStore = new Datatable();

		tbStore.init({
			src: $("#tb-store"),
			dataTable: {
				"serverSide": true,
				"ordering": false,
				"scrollX": true,
				"scrollY": '320px',
				"ajax":{
					"type": "POST",
					"url" : "<?php echo url::base()?>store/jsStore",
					data: function( d ){
	                    d._main_count = '<?php echo $total_store ?>'
	                }
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
        },
        get: function(){
			return tbStore;
		}
    };
}();

$(document).ready(function() {
	Store.init();
});

// delete admin
$(document).ready(function() {
	$(document).on( "click", ".btn-delete-admin", function(e) {
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
					    		url: '<?php echo url::base() ?>store/del_admin',
					    		type: 'POST',
					    		dataType: 'json',
					    		data: {'txt_admin_id': txt_admin_id},
					    	})
					    	.done(function(data) {
					    		Kiosk.unblockUI('.page-quick-wap');
					    		if(data['msg'] == 'true'){
					    			$t.parent('div').parent('div').parent('div').parent('div').parent('div').remove();
						          	$.bootstrapGrowl("Delete Success.", { 
						                type: 'success' 
						            });
						        }else{
						          	$.bootstrapGrowl("Error.", { 
						                type: 'danger' 
						            });
						        }
					    	})
					    	.fail(function() {
					    		Kiosk.unblockUI('.page-quick-wap');
					    		console.log("error");
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
});

function checkCode(input_code, form){
	Kiosk.blockUI({
        target: '.page-quick-wap',
        boxed: true
    });
	$.ajax({
		url: '<?php echo url::base() ?>store/checkCode',
		type: 'POST',
		dataType: 'json',
		data: {'txt_code': input_code},
	})
	.done(function(data) {
		Kiosk.unblockUI('.page-quick-wap');
		if(data['msg'] == 'true'){
			$('.customers-error').hide();
			form.submit();
		}else{
			$('.customers-error').parent('.in-group').addClass('has-error');
			$('.data-code').text(input_code);
			$('.customers-error').show();
		}
	})
	.fail(function() {
		Kiosk.unblockUI('.page-quick-wap');
		console.log("error");
	});
}
function frmAdd_admin(){
	Kiosk.blockUI();
	$.ajax({
		url: '<?php echo url::base() ?>store/frmAdd_admin',
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
        target: '.page-quick-wap',
        boxed: true
    });
	$.ajax({
		url: '<?php echo url::base() ?>store/nextCode',
		type: 'POST',
		dataType: 'json',
	})
	.done(function(data) {
		Kiosk.unblockUI('.page-quick-wap');
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
		Kiosk.unblockUI('.page-quick-wap');
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
	            },
	            txt_store_website: {
	                required: true
	            },
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
	        	alert(123);
	        	return false;
				var _input       = $('input[name="txt_store_no"]').val();
				var txt_no_store = $('input[id="txt_no_store"]').val();
				var txt_id_store = $('input[name="txt_id_store"]').val();
	        	if(txt_id_store == '')
	        		checkCode(_input, form);
	        	else{
	        		if(_input != txt_no_store){
	        			checkCode(_input, form);
	        		}else{
	        			Kiosk.blockUI({
					        target: '.page-quick-wap',
					        boxed: true
					    });
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
function _init_Login_Credentials(){
	$(document).ready(function() {
		$('.chk_allow_user').change(function() {
			if(this.checked){
				$(this).parent().parent().prev().val(1);
			}else{
				$(this).parent().parent().prev().val(0);
			}
		}); 

		$('.chk_freeze_user').change(function() {
			if($(this).is(':checked')){
				$(this).parent().parent().prev().val(3);
			}else{
				$(this).parent().parent().prev().val(0);
			}
		}); 

		var frm = $('#frm-add-admin');
		frm.validate({
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
	        	$("input[name='txt_add_first[]']", frm).each(function() {
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
		        $("input[name='txt_add_last[]']", frm).each(function() {
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
		        $("input[name='txt_add_email[]']", frm).each(function() {
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
		       	$("input.pass_addAdmin", frm).each(function() {
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
						url: '<?php echo url::base() ?>store/save_add_admin',
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
						if(data != ''){
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
				        
				        $('.close-kioskDialog').click();
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
	});
}
function _init_Login_Credentials_Add(){
	$(document).ready(function() {
		$('.chk_allow_user').change(function() {
			if(this.checked){
				$(this).parent().parent().prev().val(1);
			}else{
				$(this).parent().parent().prev().val(0);
			}
		}); 

		$('.chk_freeze_user').change(function() {
			if($(this).is(':checked')){
				$(this).parent().parent().prev().val(3);
			}else{
				$(this).parent().parent().prev().val(0);
			}
		}); 
	});
}
function addItem_admin(){
	$.ajax({
		url: '<?php echo url::base() ?>store/addItem_admin',
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