<script type="text/javascript">
	var DOM, 
    Catalog = {
        settings: {
            TableCatalogs: $("#tb-catalog"),
            WrapOverlay: $('.page-quick-wap'),
            TypeMenu: $('.type_btn_menu'),
        },
        LoadMenuDefault: function(type, url) {
            tbCatalog = new Datatable();
			tbCatalog.init({
				src: DOM.TableCatalogs,
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"url" : "<?php echo url::base()?>catalogs/jsCatalog",
					},
					"columns": [{
		                "data": null,
		                "class": "",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                    return "<input type='checkbox' class='item-select' name='chk_catalog[]' value='"+full.tdID+"'>";
		                }
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	if(full.tdIcon){
		                		return "<div class='icon-catalog'><img style='width:32px;height:32px' src='<?php echo $this->hostGetImg ?>?files_id="+full.tdIcon+"' alt=''></div>";
		                	}else{
		                		return "<div class='icon-catalog'></div>";
		                	}
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdCategory",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdPrice",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdCost",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": null,
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	return "<div class='"+full.tdAvailableColor+"'>"+full.tdAvailable+"</div>";
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdSKU",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdType",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdNote",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdStatus",
		                "orderable": false
		            }],
		            scroller: {
			            loadingIndicator: false,
			            rowHeight: 49
			        },
				}
			});

			tbCatalog.getTable().on('click', 'tr td.slt-row', function(e) {
				e.preventDefault();
				var tr   = $(this).closest('tr');
				var row  = tbCatalog.getDataTable().row( tr );
				var trId = row.data().DT_RowId;
				Catalog.EditCatalog(trId);
			});

			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbCatalog.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			});

			/* Export */
			$('.cls-export').click(function(event) {
				var selected = tbCatalog.getSelectedID();
	        	if(selected.length > 0){
	        		$('<form>', {
					    "id": "exportMenu",
					    "html": '<input type="hidden" id="txt_id_selected" name="txt_id_selected" value="' + selected + '" />',
					    "action": '<?php echo url::base() ?>catalogs/exportMenu',
					    "method": 'post'
					}).appendTo(document.body).submit();
				}else{
					$.bootstrapGrowl("No record selected.", { 
			           	type: 'danger' 
			        });
				}
			});
        	
        },
        action: function(type){
			/*
			* type : 1-Active : 2-Inactive : 3-Delete
			 */
			var selected = tbCatalog.getSelectedID();
			if(selected.length > 0){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/setStatusMenu',
					type: 'POST',
					dataType: 'json',
					data: {
						'id': selected,
						'action': type
					},
				})
				.done(function(data) {
					Kiosk.unblockUI();
					if(type == '3'){
						if(data.msg = true){
							$.bootstrapGrowl(data.total+" items deleted.", { 
				            	type: 'success' 
				            });
						}else{
							$.bootstrapGrowl(data.total+" items deleted.", { 
				            	type: 'danger' 
				            });
						}
					}else{
						if(data['msg'] == true){
				          	$.bootstrapGrowl(data.total+" items save change.", { 
				                type: 'success' 
				            });
				        }else{
				          	$.bootstrapGrowl("Could not complete request.", { 
				                type: 'danger' 
				            });
				        }
					}
					Catalog.reloadData();
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
		reloadData: function(){
			var datatable    = tbCatalog.getDataTable();
			var tablewrapper = tbCatalog.getTableWrapper();
			var table        = tbCatalog.getTable();

			tbCatalog.clearSelectedID();

			$('.chk-all', tablewrapper).prop('checked',false);
			Kiosk.updateUniform('.chk-all', tablewrapper);
			datatable.ajax.reload();
		},
        AddOptionsMenu: function() {
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/frm_add_options',
				type: 'GET',
			})
			.done(function(data) {
				DOM.WrapOverlay.html(data);
				toogleQuick();
				Kiosk.unblockUI();
				StandarItem.init();
				StandarItem.NextCode();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        AddCatalog: function() {
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getAddCatalog',
				type: 'GET'
			})
			.done(function(data) {
				DOM.WrapOverlay.html(data);
				toogleQuick();
				Kiosk.unblockUI();
				Catalog.StandarItemMenu($('.type_btn_menu')[0]);
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        EditCatalog: function(id) {
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getEditCatalog',
				type: 'POST',
				data: { 'idMenu': id }
			})
			.done(function(data) {
				DOM.WrapOverlay.html(data);
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
        deleteCatalog: function() {
        	var selected = tbCatalog.getSelectedID();
        	console.log(selected);
        	return false;
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
									url: '<?php echo url::base() ?>catalogs/deleteMenu',
									type: 'POST',
									dataType: 'json',
									data: {'idMenu': selected},
								})
								.done(function(data) {
									Catalog.reloadData();
									if(data.msg = true){
										$.bootstrapGrowl(data.total+" items deleted.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl(data.total+" items deleted.", { 
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
        },
        StandarItemMenu: function(t_this) {
        	$(t_this).prop('disabled', true);
        	$(t_this).next().prop('disabled', false);
        	$('.type_btn_menu').removeClass('btn-primary');
        	$(t_this).addClass('btn-primary');
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/frm_standard_item',
				type: 'GET',
			})
			.done(function(data) {
				$('#frm_multiple_menu').html(data);
				Kiosk.unblockUI();
				StandarItem.NextCode();
				StandarItem.init();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        ComboSetMenu: function(t_this) {
        	$(t_this).prop('disabled', true);
        	$(t_this).prev().prop('disabled', false);
        	$('.type_btn_menu').removeClass('btn-primary');
        	$(t_this).addClass('btn-primary');
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/frm_combo_set',
				type: 'GET',
			})
			.done(function(data) {
				$('#frm_multiple_menu').html(data);
				Kiosk.unblockUI();
				ComboSet.NextCode();
				ComboSet.init();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        AddOptions: function() {
        	var _str = '<tr>';
			_str += '<td ><input type="text"  style="margin-bottom: 5px;" class="form-control input-sm" name="txt_name_option[]" value="" placeholder=""></td>;'
			_str += '<td class="in-group" style="width:25%;"><input type="text"  style="margin-bottom: 5px;text-align: right" class="form-control input-sm decimal" name="txt_price_option[]" value="" placeholder=""></td>';
			_str += '<td ><a href="javascript:;" class="btn btn-sm red" onclick="Catalog.RemoveOptions(this)"><i class="fa fa-times"></i></a></td></tr>';
			$('#tb-option tbody').append(_str);
			//$('table.tb-option').floatThead('reflow');
			$(".decimal").inputmask('decimal',{rightAlign: true});
        },
        RemoveOptions: function(t_this) {
        	$(t_this).parents('tr').remove();
			//$('table.tb_option').floatThead('reflow');
        },
        readURL: function(input) {
        	if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (e) {
	                $('.view-icon').html('<img src="'+e.target.result+'" alt="">');
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
        },
        getExtension: function(path) {
        	var basename = path.split(/[\\/]/).pop(),
	        pos = basename.lastIndexOf(".");

		    if (basename === "" || pos < 1)
		        return "";

		    return basename.slice(pos + 1).toLowerCase();
	    },
        ChangeIcon: function(t_this) {
        	Kiosk.blockUI();
        	var input = $(t_this),
			numFiles  = input.get(0).files ? input.get(0).files.length : 1,
			label     = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    	//input.trigger('fileselect', [numFiles, label]);
	    	var ext = Catalog.getExtension(label);
	    	if(ext == 'jpg' || ext == 'png' || ext == 'jpeg'){
	    		Catalog.readURL(t_this);
	    	}else{
	    		input.val('');
	    		$('.view-icon').html('');
	    	}
	    	Kiosk.unblockUI();
        },
        Ready: function() {
        	Catalog.LoadMenuDefault();
        },
        init: function() {
        	var tbCatalog;
            DOM = this.settings;
            DOM.TableCatalogs, DOM.WrapOverlay, DOM.TypeMenu;
            this.Ready();

            var slt = $('#txt_sub_category', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);

	      	var slt = $('#txt_stage', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);
        }
    };
    
    var DOM_ComboSet,
    ComboSet = {
        settings: {
        	
        },
        SelectItemMenu: function() {
			var id = $(".txt_catalog").map(function() {
			    return $( this ).val();
			}).get();

			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getSelectMenu',
				type: 'POST',
				data:{ 'idProduct' : id}
			})
			.done(function(data) {
				var dialogSelect = new kioskDialog();
				dialogSelect.init({
					"data": data
				});
				Kiosk.unblockUI();
	      		ComboSet.InitSelect($('.wap-item-add-inventory').find('.slt_catalog_item_combo'));
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        Validate: function() {
        	$('#frm-catalog').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
		            txt_item_name: {
		                required: true
		            },
		            txt_sku: {
		                required: true
		            },
		            txt_sub_category: {
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
					var _input       = $('input[name="txt_sku"]').val();
					var txt_hd_id    = $('input[name="txt_hd_id"]').val();
					var _txt_menu_no = $('input[id="_txt_menu_no"]').val();

		        	if(txt_hd_id == '')
		        		ComboSet.CheckItemNo(_input, form);
		        	else{
		        		if(_input != _txt_menu_no){
		        			ComboSet.CheckItemNo(_input, form);
		        		}else{
		        			Kiosk.blockUI();
		        			form.submit();
		        		}
		        	}

		        }
		    });
        },
        InitSelect: function(dom_slt) {
        	$(dom_slt).select2({
		        placeholder: "",
		        minimumInputLength: 1,
		        ajax: {
		            url: "<?php echo url::base()?>catalogs/getMenuItem",
		            dataType: 'json',
		            type: 'POST',
		            data: function (term, page) {
		                return {
		                    q: term,
		                };
		            },
		            results: function (data, page) {
		                return {
		                    results: data
		                };
		            }
		        },
		        initSelection: function (element, callback) {
	                var id = $(element).val();
	                var name = $(element).attr('data-name');
	                if (id !== "") {
	                   callback({ "id": id, "text": name });
	                }
	            },
			    dropdownCssClass: "bigdrop",
		        escapeMarkup: function (m) {
		            return m;
		        },
		        formatInputTooShort: function () {
	                return "Search";
	            }, 
		    })
	        .on('select2-selecting', function (e) {
	        	var slt = $(this);
				var wapParent = slt.parents('.item-add');
				var catelog = '<span style="display: block;">Menu Item #: '+e.choice.item_no+'</span>';
					catelog += '<span style="display: block;">Item: '+e.choice.item_name+'</span>';
					catelog += '<span style="display: block;">Category: '+e.choice.category_name+'</span>';
				wapParent.find('.info-catalog').html(catelog);
				var image = '<img src="<?php echo $this->hostGetImg ?>?files_id='+e.choice.image+'" alt="">';
				wapParent.find('.file_id_menu').show().html(image);			
			});
        },
        CheckItemNo: function(input_code, form) {
        	var isValid = true;
			$('input[name="txt_price_option[]"]:visible').each(function() {
				var option_name = $(this).parent('td').prev('td').children('input').val();
				var option_price = $(this).val();
				if(option_price != '' && option_name == ''){
					isValid = false;
				}else if(option_price == '' && option_name == ''){
					isValid = false;
				}

			});
			
			if(isValid){
		    	Kiosk.blockUI({
		            target: '.page-quick-wap',
		        });
		    	$.ajax({
		    		url: '<?php echo url::base() ?>catalogs/checkitem_no',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {'txt_code': input_code},
		    	})
		    	.done(function(data) {
		    		Kiosk.unblockUI('.page-quick-wap');
		    		if(data['msg'] == 'true'){
		    			$('.customers-error').hide();
		    			Kiosk.blockUI();
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
			}else{
				$.bootstrapGrowl("Please check again option.", { 
        			type: 'danger' 
        		});
				return false;
			}
        },
        NextCode: function(){
        	var txt_hd_id    = $('input[name="txt_hd_id"]').val();
			var _txt_menu_no = $('input[id="_txt_menu_no"]').val();
			if(txt_hd_id != ''){
				$('input[name="txt_sku"]').val(_txt_menu_no);
				return false;
			}

			Kiosk.blockUI({
	            target: '.page-quick-wap'
	        });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>catalogs/nextCode',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {'txt_code': 'code'},
	    	})
	    	.done(function(data) {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		if(data['msg'] == 'true'){
	    			$('input[name="txt_sku"]').val(data['code']);
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
        },
        Additem: function() {
        	var _item = $('.inventory-template').clone();
			_item.removeClass('inventory-template');
			var slt  = _item.find('.slt_catalog').removeClass('slt_catalog').addClass('slt_catalog_item_combo');
			$('.wap-item-add-inventory').append(_item);
			ComboSet.InitSelect(slt);
			slt.focus();
        },
        SaveComboSet: function() {
        	var isValid = true;
			$('input[name="txt_catalog[]"]:visible').each(function() {
				if($(this).val() == '')
					isValid = false;
			});
			if(isValid){
				var id = $('input[name="txt_catalog[]"]:visible', $('#frm-select-inventory')).map(function() {
				    return $( this ).val();
				}).get();

				if(id.length > 0){
					var _strMain = '';
					$.each(id, function(index, val) {
						var _str = '<input class="txt_catalog" type="hidden" name="txt_catalog[]" value="'+val+'">';
						_strMain += _str;
					});
					$('.item-add-inventory').html(_strMain);
					$('.total-item').html(id.length);
				}else{
					$('.item-add-inventory').html('');
					$('.total-item').html('');
				}
				$('.close-kioskDialog').click();
			}else{
				$.bootstrapGrowl("Menu Item Name or Menu Item.", { 
		        	type: 'danger' 
		        });
		        return false;
			}
        },
        DeleteConnectItem: function(t_this){
        	$(t_this).parents(".item-add").remove();
        },
        FormatNumber: function() {
        	$(".decimal").inputmask('decimal',{rightAlign: true});
        },
        OnlyNumber: function() {
        	Kiosk.intOnly('.intOnly');
        },
        InitCheckBox: function() {
        	Kiosk.initUniform($('input[type="checkbox"]'));
        },
        SrollFixHeader: function() {
        	var $tb_option = $('table.tb-option');
	      	// $tb_option.floatThead({
		      //   scrollContainer: function($table){
		      //     return $table.closest('.wrap-tb-option');
		      //   }
	      	// });
        },
        PressEnter: function() {
        	$('#frm-catalog input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-customers').validate().form()) {
		                $('#frm-customers').submit();
		            }
		            return false;
		        }
		    });
        },
        Generate: function(){
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getGenerate',
				type: 'get',
				dataType: 'json'
			})
			.done(function(data) {
				$('input[name="txt_barcode"]').val(data);
			})
			.fail(function() {
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			}).always(function() {
				Kiosk.unblockUI();
			});
			
			
        },
        Ready: function() {
	      	ComboSet.Validate();
	      	ComboSet.FormatNumber();
	      	ComboSet.OnlyNumber();
	      	ComboSet.InitCheckBox();
	      	ComboSet.SrollFixHeader();
	      	ComboSet.PressEnter();
        },
        init: function() {
            DOM_ComboSet = this.settings;
            this.Ready();

            var slt = $('#txt_sub_category', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);

	      	var slt = $('#txt_stage', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);

	      	$('#frm-catalog').on('click', '.btn-upload', function(event) {
				event.preventDefault();
				Kiosk.blockUI();
				/*var btn    = $(this);
				var parent   = btn.parents('.frm-img');*/
				var store_id = '<?php echo base64_decode($this->sess_cus["storeId"]) ?>';
				var data     = new FormData();
				data.append('uploadfile', $('#uploadfile').prop('files')[0]);
				data.append('store_id', store_id);
				$.ajax({
				    type: 'POST',
				    url: "<?php echo url::base() ?>catalogs/sendImg",
				    data: data,
				    crossDomain: true,
				    processData: false,
				    contentType: false,
				    dataType : 'json',
				    success: function(response) {
				    	if(response.responseMsg == 'Success'){
				    		$.bootstrapGrowl("Upload Success.", { 
				            	type: 'success' 
				            });
				    		$('#uploadfilehd', $('#frm-catalog')).val(response.data[0]['file_id']);
				    		$('.btn-upload', $('#frm-catalog')).hide();
				    	}else{
				    		$('#uploadfilehd', $('#frm-catalog')).val('');
				    		$.bootstrapGrowl("Could not complete request.", { 
				            	type: 'danger' 
				            });
				    	}
				    	Kiosk.unblockUI();
				    }
			   	}).fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
		            	type: 'danger' 
		            });
				});
			});

		    $('#frm-catalog').on('click', '.btn-remove', function(event) {
				event.preventDefault();
				$('#uploadfilehd', $('#frm-catalog')).val('');
			});

			$('#uploadfile').on('change.bs.fileinput', function(event, files) {
			    $('.btn-upload').removeAttr('style');
			});
        }
    };
	
    var DOM_Standar,
    previous,
    StandarItem = {
        settings: {
        	
        },
        saveItemOption: function(){
        	$('.wrap-tb-option').empty();
			var sltOption = $('select[name="slt_menu_option[]"]', $('#frm-select-option'));
			var valTotal  = 0;
			if(sltOption.length > 0){
	        	sltOption.each(function(index, el) {
					var _flag = false;
					var _slt  = $(this);
	        		var _wapParent = _slt.parents('.item-add');

	        		var data = $('input[name="txt_chk_menu[]"]', _wapParent);
	        		var type = $('select[name="slt_menu_option_type[]"]', _wapParent).val();

		        	data.each(function(index, el) {
		        		if($(this).is(":checked")){
		        			_flag = true;
		        			var chk      = $(this);
							var valMenu  = chk.val();
							var valPrice = chk.parents('tr').find($('input[name="txt_price_menu[]"]')).val();

		        			var _str = '<input type="hidden" name="txt_menu_parent[]" value="'+_slt.val()+'">';
		        			_str += '<input type="hidden" name="txt_menu_option[]" value="'+valMenu+'">';
		        			_str += '<input type="hidden" name="txt_menu_option_price[]" value="'+valPrice+'">';
		        			_str += '<input type="hidden" name="txt_menu_option_type[]" value="'+type+'">';
		        			$('.wrap-tb-option').append(_str);
							
		        			//console.log(valMenu + '-' + type + '- '+ valPrice);
		        		}
		        	});
		        	if(_flag){
		        		valTotal++;
		        	}

		        	$('.total-options').html(valTotal);
		        	$('.close-kioskDialog').click();
	        	});
			}else{
				$('.total-options').html(0);
		        $('.close-kioskDialog').click();
			}
        },
        checkSelected: function(val){
        	var ret = false;
	        $(".variable_priority").each(function() {
	            if ($(this).val() === val) {
	                ret = true;
	            }
	        });
	        return ret;
        },
        getItemOption: function(slt){
        	Kiosk.blockUI();
        	var slt = $(slt);
			var wapOptions = slt.parents('.item-add').find('.wap-item-options');
			var valIdMenu  = slt.val();
			var idSelected = $('select[name="slt_menu_option[]"]', $('#frm-select-option')).not(slt).map(function() {
			    return $( this ).val();
			}).get();
			if(valIdMenu != '0'){
				if(idSelected.indexOf(valIdMenu) >= 0){
					slt.select2('val', previous);
					$.bootstrapGrowl("The list was selected.", { 
			        	type: 'danger' 
			        });
					Kiosk.unblockUI();
					return false;
				}
			}
			
			previous = valIdMenu;
        	$.ajax({
				url: '<?php echo url::base() ?>catalogs/getItemOption',
				type: 'POST',
				data:{ 
					'idSubMenu' : valIdMenu 
				}
			})
			.done(function(data) {
				wapOptions.html(data);
				StandarItem.InitCheckBox();
				StandarItem.FormatNumber();
				Kiosk.unblockUI();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
       	OpenOptions: function(){
       		Kiosk.blockUI();
       		var idParent = $("input[name='txt_menu_parent[]']").map(function() {
			    return $( this ).val();
			}).get();

       		var idMenu = $("input[name='txt_menu_option[]']").map(function() {
			    return $( this ).val();
			}).get();

			var priceMenu = $("input[name='txt_menu_option_price[]']").map(function() {
			    return $( this ).val();
			}).get();

			var typeMenu = $("input[name='txt_menu_option_type[]']").map(function() {
			    return $( this ).val();
			}).get();

			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getSelectOption',
				type: 'POST',
				data:{ 
					'idParent': idParent,
					'idMenu' : idMenu ,
					'priceMenu': priceMenu,
					'typeMenu' : typeMenu
				}
			})
			.done(function(data) {
				var dialogSelect = new kioskDialog();
				dialogSelect.init({
					"data": data
				});
				StandarItem.InitCheckBox();
				StandarItem.FormatNumber();
				Kiosk.unblockUI();
				StandarItem.InitSelect2($('.slt-sub-option', $('#frm-select-option')));
				StandarItem.InitSelect2($('.slt-sub-type', $('#frm-select-option')), 1);

				$('#frm-select-option').on('focus', 'select', function(event) {
					event.preventDefault();
					previous = $(this).val();
				});
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
       	},
       	addItemOption: function() {
        	var _item = $('.inventory-template').clone();
			_item.removeClass('inventory-template');
			var slt     = _item.find('.slt_catalog').removeClass('slt_catalog').addClass('slt-sub-option');
			var sltType = _item.find('.slt_type').removeClass('slt_type').addClass('slt-sub-type');
			$('.wap-item-add-inventory').append(_item);

	      	StandarItem.InitSelect2(slt);
	      	StandarItem.InitSelect2(sltType, 1);
			StandarItem.FormatNumber();
			slt.focus();
        },
        OpenConnectItem: function() {
			var id = $(".txt_catalog").map(function() {
			    return $( this ).val();
			}).get();

			var qty = $(".txt_qty").map(function() {
			    return $( this ).val();
			}).get();

			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getSelectInventory',
				type: 'POST',
				data:{ 'idProduct' : id , 'qty': qty }
			})
			.done(function(data) {
				var dialogSelect = new kioskDialog();
				dialogSelect.init({
					"data": data
				});
				Kiosk.unblockUI();
				StandarItem.InitSelect($('.wap-item-add-inventory').find('.slt_catalog_item'));
				StandarItem.FormatNumber();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
        },
        SaveConnectItem: function() {
        	var isValid = true;
			$('input[name="txt_catalog[]"]:visible').each(function() {
				if($(this).val() == '')
					isValid = false;
			});
			if(isValid){
				var id = $('input[name="txt_catalog[]"]:visible', $('#frm-select-inventory')).map(function() {
				    return $( this ).val();
				}).get();

				var qty = $('input[name="txt_qty[]"]:visible', $('#frm-select-inventory')).map(function() {
				    return $( this ).val();
				}).get();

				if(id.length > 0){
					var _strMain = '';
					$.each(id, function(index, val) {
						var _str = '<input class="txt_catalog" type="hidden" name="txt_catalog[]" value="'+val+'">';
							_str+= '<input class="txt_qty" type="hidden" name="txt_qty[]" value="'+qty[index]+'">';
						_strMain += _str;
					});
					$('.item-add-inventory').html(_strMain);
					$('.total-item').html(id.length);
				}else{
					$('.item-add-inventory').html('');
					$('.total-item').html('');
				}
				$('.close-kioskDialog').click();
			}else{
				$.bootstrapGrowl("Inventory Name or SKU# are required.", { 
		        	type: 'danger' 
		        });
		        return false;
			}
        },
        DeleteConnectItem: function(t_this){
        	$(t_this).parents(".item-add").remove();
        },
        Validate: function() {
        	$('#frm-catalog').validate({
		        errorElement: 'span',
		        errorClass: 'help-block',
		        focusInvalid: false,
		        rules: {
		            txt_item_name: {
		                required: true
		            },
		            txt_sku: {
		                required: true
		            },
		            txt_sub_category: {
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
					var _input       = $('input[name="txt_sku"]').val();
					var txt_hd_id    = $('input[name="txt_hd_id"]').val();
					var _txt_menu_no = $('input[id="_txt_menu_no"]').val();

		        	if(txt_hd_id == '')
		        		StandarItem.CheckItemNo(_input, form);
		        	else{
		        		if(_input != _txt_menu_no){
		        			StandarItem.CheckItemNo(_input, form);
		        		}else{
		        			Kiosk.blockUI();
		        			form.submit();
		        		}
		        	}

		        }
		    });
        },
        InitSelect: function(dom_slt) {
        	$(dom_slt).select2({
		        placeholder: "",
		        minimumInputLength: 1,
		        ajax: {
		            url: "<?php echo url::base()?>catalogs/getInventory",
		            dataType: 'json',
		            type: 'POST',
		            data: function (term, page) {
		                return {
		                    q: term,
		                };
		            },
		            results: function (data, page) {
		                return {
		                    results: data
		                };
		            }
		        },
		        initSelection: function (element, callback) {
	                var id = $(element).val();
	                var name = $(element).attr('data-name');
	                if (id !== "") {
	                   callback({ "id": id, "text": name });
	                }
	            },
			    dropdownCssClass: "bigdrop",
		        escapeMarkup: function (m) {
		            return m;
		        },
		        formatInputTooShort: function () {
	                return "Search";
	            }, 
		    })
	        .on('select2-selecting', function (e) {
	        	var slt = $(this);
				var wapParent = slt.parents('.item-add');
	        	if(funName = 'getInventory'){
	        		wapParent.find('.lb_unit').html('&nbsp;'+e.choice.pro_unit);
					var catelog = '<span style="display: block;">SKU# '+e.choice.pro_no+'</span>';
						catelog += '<span style="display: block;">Item: '+e.choice.pro_name+'</span>';
						catelog += '<span style="display: block;">Category: '+e.choice.sub_category_name+'</span>';
					wapParent.find('.info-catalog').html(catelog);
	        	}
				
			});
        },
        CheckItemNo: function(input_code, form) {
        	var isValid = true;
			$('input[name="txt_price_option[]"]:visible').each(function() {
				var option_name = $(this).parent('td').prev('td').children('input').val();
				var option_price = $(this).val();
				if(option_price != '' && option_name == ''){
					isValid = false;
				}else if(option_price == '' && option_name == ''){
					isValid = false;
				}

			});
			
			if(isValid){
		    	Kiosk.blockUI({
		            target: '.page-quick-wap',
		        });
		    	$.ajax({
		    		url: '<?php echo url::base() ?>catalogs/checkitem_no',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {'txt_code': input_code},
		    	})
		    	.done(function(data) {
		    		Kiosk.unblockUI('.page-quick-wap');
		    		if(data['msg'] == 'true'){
		    			$('.customers-error').hide();
		    			Kiosk.blockUI();
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
			}else{
				$.bootstrapGrowl("Please check again option.", { 
        			type: 'danger' 
        		});
				return false;
			}
        },
        NextCode: function(){
        	var txt_hd_id    = $('input[name="txt_hd_id"]').val();
			var _txt_menu_no = $('input[id="_txt_menu_no"]').val();
			if(txt_hd_id != ''){
				$('input[name="txt_sku"]').val(_txt_menu_no);
				return false;
			}

			Kiosk.blockUI({
	            target: '.page-quick-wap'
	        });
	    	$.ajax({
	    		url: '<?php echo url::base() ?>catalogs/nextCode',
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {'txt_code': 'code'},
	    	})
	    	.done(function(data) {
	    		Kiosk.unblockUI('.page-quick-wap');
	    		if(data['msg'] == 'true'){
	    			$('input[name="txt_sku"]').val(data['code']);
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
        },
        Additem: function() {
        	var _item = $('.inventory-template').clone();
			_item.removeClass('inventory-template');
			var slt     = _item.find('.slt_catalog').removeClass('slt_catalog').addClass('slt-sub-option');
			$('.wap-item-add-inventory').append(_item);

	      	StandarItem.InitSelect(slt);
			StandarItem.FormatNumber();
			slt.focus();
        },
        FormatNumber: function() {
        	$(".decimal").inputmask('decimal',{rightAlign: true});
        },
        OnlyNumber: function() {
        	Kiosk.intOnly('.intOnly');
        },
        InitCheckBox: function() {
        	Kiosk.initUniform($('input[type="checkbox"]'));
        },
        InitSelect2: function(el, type){
        	if(type){
        		el.select2({
        			minimumResultsForSearch: -1
        		}).on("select2-opening", function(e) {
	        		previous = $(this).val();
	        	});
        	}else{
        		el.select2().on("select2-opening", function(e) {
	        		previous = $(this).val();
	        	});
        	}
        	
        },
        SrollFixHeader: function() {
        	var $tb_option = $('table.tb-option');
	      	// $tb_option.floatThead({
		      //   scrollContainer: function($table){
		      //     return $table.closest('.wrap-tb-option');
		      //   }
	      	// });
        },
        PressEnter: function() {
        	$('#frm-catalog input').keypress(function (e) {
		        if (e.which == 13) {
		            if ($('#frm-customers').validate().form()) {
		                $('#frm-customers').submit();
		            }
		            return false;
		        }
		    });
        },
        Ready: function() {
	      	StandarItem.Validate();
	      	StandarItem.FormatNumber();
	      	StandarItem.OnlyNumber();
	      	StandarItem.InitCheckBox();
	      	StandarItem.SrollFixHeader();
	      	StandarItem.PressEnter();
	      	var slt = $('#txt_sub_category', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);

	      	var slt = $('#txt_stage', $('#frm-catalog'));
	      	StandarItem.InitSelect2(slt);

	      	$('#frm-catalog').on('click', '.btn-upload', function(event) {
				event.preventDefault();
				Kiosk.blockUI();
				/*var btn    = $(this);
				var parent   = btn.parents('.frm-img');*/
				var store_id = '<?php echo base64_decode($this->sess_cus["storeId"]) ?>';
				var data     = new FormData();
				data.append('uploadfile', $('#uploadfile').prop('files')[0]);
				data.append('store_id', store_id);
				$.ajax({
				    type: 'POST',
				    url: "<?php echo url::base() ?>catalogs/sendImg",
				    data: data,
				    crossDomain: true,
				    processData: false,
				    contentType: false,
				    dataType : 'json',
				    success: function(response) {
				    	if(response.responseMsg == 'Success'){
				    		$.bootstrapGrowl("Upload Success.", { 
				            	type: 'success' 
				            });
				    		$('#uploadfilehd', $('#frm-catalog')).val(response.data[0]['file_id']);
				    		$('.btn-upload', $('#frm-catalog')).hide();
				    	}else{
				    		$('#uploadfilehd', $('#frm-catalog')).val('');
				    		$.bootstrapGrowl("Could not complete request.", { 
				            	type: 'danger' 
				            });
				    	}
				    	Kiosk.unblockUI();
				    }
			   	}).fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
		            	type: 'danger' 
		            });
				});
			});

		    $('#frm-catalog').on('click', '.btn-remove', function(event) {
				event.preventDefault();
				$('#uploadfilehd', $('#frm-catalog')).val('');
			});

			$('#uploadfile').on('change.bs.fileinput', function(event, files) {
			    $('.btn-upload').removeAttr('style');
			});
        },
        Generate: function(){
        	Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getGenerate',
				type: 'get',
				dataType: 'json'
			})
			.done(function(data) {
				$('input[name="txt_barcode"]').val(data);
			})
			.fail(function() {
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			}).always(function() {
				Kiosk.unblockUI();
			});
			
			
        },
        init: function() {
            DOM_Standar = this.settings;
            this.Ready();
        }
    };

	$(document).ready(function() {
		Catalog.init();
	});
</script>