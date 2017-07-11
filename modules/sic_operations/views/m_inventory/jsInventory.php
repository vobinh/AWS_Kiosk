<script src="<?php echo $this->site['base_url'] ?>plugins/global/plugins/quicksearch.js"></script>
<?php $role = $this->mPrivileges; ?>
<script type="text/javascript">

	var inventoryWarehouse = function(){
		var wapInventory, tbInventory, qSearch, tbCatalog, tbData, contentBody, tDisplay, tFilter, dataFilter;
		var ajaxParams = {};
		var dataRow    = {};
		var initSelect2 = function(selectElementObj, frmUsing){

			var idFrm = $(frmUsing).attr('id');
			if(idFrm == 'frm-order'){
				funName = 'getCatalory';
			}else{
				funName = 'getCatalory';
			}

			selectElementObj.select2({
		        placeholder: "",
		        minimumInputLength: 1,
		        ajax: {
		            url: "<?php echo url::base()?>catalogs/getProduct",
		            dataType: 'json',
		            type: 'POST',
		            data: function (term, page) {
		                return {
		                    q: term,
		                    page_limit: 10
		                };
		            },
		            results: function (data, page) {
		                return {
		                    results: data
		                };
		            }
		        },
		        initSelection: function (element, callback) {
					var valName = $(element).attr('data-name');
					var valId   = $(element).val();
	                if (valId !== "") {
	                   callback({ 
	                   	"id": valId, "text": valName 
	                   });
	                }
	            },
		        createSearchChoice:function(term, data) {
			        /*if ( $(data).filter( function() {
			            return this.text.localeCompare(term) === 0 ;
			        }).length === 0) {
			            return {id:term, text:term};
			        }*/
			    },
			    dropdownCssClass: "bigdrop",
		        escapeMarkup: function (m) {
		            return m;
		        },
		        formatInputTooShort: function () {
	                return "Item Name or SKU#";
	            }
		    })
			.on("select2-highlight", function(e) {
	        })
	        .on('select2-selecting', function (e) {
				var slt = $(this);
				var wapParent = slt.parents('.item-add');
				Kiosk.blockUI({
	                target: $(wapParent)
	            });
              	
				var cost = parseFloat(e.object.pro_cost_store);
				var per  = parseFloat(e.object.pro_per_store);

				wapParent.find('input[name="txt_qty[]"]').attr({
					'data-cost': cost,
					'data-per': per
				});

				wapParent.find('.lb_unit').html('&nbsp;'+e.object.pro_unit);
				wapParent.find('input[name="txt_sub_category[]"]').val(e.object.sub_category_id);
				wapParent.find('input[name="txt_name[]"]').val(e.object.pro_name);
				wapParent.find('input[name="txt_file_id[]"]').val(e.object.file_id);

				if(e.object.pro_shelf_life_store != '0'){
					wapParent.find('input[name="txt_date[]"]').datepicker('setDate', moment().add(e.object.pro_shelf_life_store, 'days').format('MM/DD/YYYY'));
				}else{
					wapParent.find('input[name="txt_date[]"]').val('');
				}

				var catelog = '<span style="display: block;">SKU# '+e.object.pro_no+'</span>';
					catelog += '<span style="display: block;">Item: '+e.object.pro_name+'</span>';
					catelog += '<span style="display: block;">Category: '+e.object.sub_category_name+'</span>';
				wapParent.find('.info-catalog').html(catelog);
				Kiosk.unblockUI($(wapParent));
			})
			.on("select2-focus", function(e) {
          		/*var _data = $(this).select2('data');
          		console.log(_data);*/
        	});
		};

		var initDatePickers = function(selectElementObj){
			selectElementObj.datepicker({
                rtl: Kiosk.isRTL(),
                orientation: "auto",
                autoclose: true
            });
		};

		var addItems = function(defaultRow, index, item){
			if(tDisplay == 'grid')
				addIn(defaultRow, index, item);
			else
				addItemList(defaultRow, index, item);
		};

		var addColumn = function(data){
			var filter = dataFilter;
			var type   = tFilter;
			if(tDisplay == 'grid')
				var defaultRow  = $('.clone-me');
			else
				var defaultRow  = $('.clone');

			data.forEach(function(item, index){
				if(type == 'byCategory'){
					if(filter.length > 0){
						var _strFilter  = filter.join(' ').toLowerCase();
						var categoryVal = item['category'].toLowerCase();
						if (_strFilter.indexOf(categoryVal) >= 0) {
							addItems(defaultRow, index, item);
						}
					}
				}else if(type == 'byDate'){
					if(filter.length > 1){
						if(dateWithin(filter[0],filter[1],item['dateAdd'])){
							addItems(defaultRow, index, item);
						}
					}
				}else if(type == 'byStatus'){
					if(filter.length > 0){
						var _strFilter  = filter;
						var categoryVal = item['status'];
						if (_strFilter.indexOf(categoryVal) >= 0) {
							addItems(defaultRow, index, item);
						}
					}
				}else{
					addItems(defaultRow, index, item);
				}
			});
			Kiosk.initUniform('.item-select', tbInventory);
			qSearch.cache();
		};

		var addItemList = function(defaultRow, index, item){
			var row = defaultRow.clone();
			row.removeClass('clone').addClass('wap-item-inventory');
			row.attr('id', index);

			row.find('.in-catalog').html('<input type="checkbox" class="item-select" name="" value="'+item['id']+'">');
			row.find('.in-name').html(item['name']);
			row.find('.in-category').html(item['category']);
			row.find('.in-lot').html(item['lot'].replace('Lot# ',''));
			row.find('.in-date-add').html(item['dateStrAdd'].replace('Added ',''));
			row.find('.in-date-expires').html(item['dateStrExp'].replace('Expires ',''));
			row.find('.in-sku').html(item['sku'].replace('SKU# ',''));
			var rowStatus = row.find('.in-status');
			rowStatus.html(item['status']);

			var _check = false;
			var clsColor = "";
			if(item['status'] == 'Expired' || item['status'] == 'Not available'){
				_check = true;
				clsColor = "level-red";
			}
			else if(item['status'] == 'Available')
				clsColor = "level-green";
			else if(item['status'] == 'Low Inventory' || item['status'] == 'Expires soon'){
				clsColor = "level-orange";
			}

			if(clsColor != '')
				rowStatus.addClass(clsColor);

			var rowTotal = row.find('.in-total');
			rowTotal.html(item['totalStr']);
			if(_check)
				rowTotal.addClass(clsColor);


			row.appendTo(contentBody).show();
		}

		var addIn = function(defaultRow, index, item){
			var row = defaultRow.clone();
			row.removeClass('clone-me').addClass('wap-item-inventory');
			row.attr('id', index);

			row.find('.in-catalog').html('<input type="checkbox" class="item-select" name="" value="'+item['id']+'"> <span class="item-size-15" title="'+item['name']+'">'+item['name']+'</span>');
			if(item['file_id'] != ''){
				row.find('.in-img').attr('src','<?php echo $this->hostGetImg ?>?files_id='+item['file_id']);
			}else{
				row.find('.in-img').attr('src','<?php echo url::base() ?>themes/kiosk/pages/img/1487153375_catalog.png');
			}
			
			row.find('.in-name')
				.attr({
					'data-original-title': item['category'],
					'title': item['category']
				})
				.html(item['category']);

			row.find('.in-sku').html(item['sku']);
			if(item['sl'] > 1){
				row.find('.in-lot').html(item['sl']+' batches stacked');
				row.find('.in-date-add').html('&nbsp;');
				row.find('.in-date-expires').html('&nbsp;');
				row.find('.item-inventory').addClass('shadow');
			}else{
				row.find('.in-date-add').html(item['dateStrAdd']);
				row.find('.in-date-expires').html(item['dateStrExp']);
				row.find('.in-lot').html(item['lot']);
			}

			var rowStatus = row.find('.in-status');
			rowStatus.html(item['status']);

			var _check = false;
			var clsColor = "";
			if(item['status'] == 'Expired' || item['status'] == 'Not available'){
				_check = true;
				clsColor = "level-red";
			}
			else if(item['status'] == 'Available')
				clsColor = "level-green";
			else if(item['status'] == 'Low Inventory' || item['status'] == 'Expires soon'){
				clsColor = "level-orange";
			}

			if(clsColor != '')
				rowStatus.addClass(clsColor);

			var rowTotal = row.find('.in-total');
			rowTotal.html('<h3>'+item['totalStr']+'</h3>');
			if(_check)
				rowTotal.addClass(clsColor);

			row.appendTo(tbInventory).show();
		};

		var inintList = function(){
			tbData = $('.table-clone').clone();
			tbData.removeClass('table-clone').addClass('table-responsive').appendTo(tbInventory).show();
			contentBody = tbData.find('tbody');
			contentBody.empty();

			contentBody.on('click', 'tr td.slt-row', function(event) {
				event.preventDefault();
				var tr = $(this).closest('tr');
				var id = $('.item-select', tr).val();
				inventoryWarehouse.editInventory(id);
			});
		}

		var loadDataInventory = function(){
			Kiosk.blockUI({
                target: $(tbInventory)
            });
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getDataInventory',
				type: 'POST',
				dataType: 'json',
				data: ajaxParams,
			})
			.done(function(data) {
				$(tbInventory).empty();

				if(tDisplay != 'grid'){
					inintList();
					$('.cls-chk-group').hide();
				}else{
					$('.cls-chk-group').show();
				}

				dataRow = data['data'];
				addColumn(dataRow);
				Kiosk.unblockUI($(tbInventory));
				if(data['countDelete'] > 0){
					$.bootstrapGrowl(data['countDelete']+" items deleted.", { 
		            	type: 'success' 
		            });
				}
			})
			.fail(function() {
				Kiosk.unblockUI($(tbInventory));
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
			
		};

		var dateWithin = function(StartDate,EndDate,CheckDate) {
			var b,e,c;
			s = Date.parse(StartDate);
			e = Date.parse(EndDate);
			c = Date.parse(CheckDate);
			if((c <= e && c >= s)) {
				return true;
			}
			return false;
		};

		return {
			init: function(){
				wapInventory = $('.wap-content-inventory');
				tbInventory  = wapInventory.find('.body-data-in');
				qSearch      = $('input#myInput').quicksearch('.wap-item-inventory');
				tDisplay     = 'grid';

				if(checkCookie('tDisplay')){
					tDisplay = getCookie('tDisplay');
				}else{
					setCookie('tDisplay', tDisplay, 1);
				}

				$('.btn-display').removeClass('green').addClass('default').prop('disabled', false);
				$('.cls-'+tDisplay).addClass('green').prop('disabled', true);
				loadDataInventory();
				
				/* Display */
				wapInventory.on('click', '.btn-display', function(event) {
					event.preventDefault();
					var type = $(this).attr('data-val');
					$('.btn-display').removeClass('green').addClass('default').prop('disabled', false);
					$(this).addClass('green').prop('disabled', true);
					tDisplay = type;
					setCookie('tDisplay', tDisplay, 1);
					if($('input[name="ckb_group_inventory"]').is(':checked')){
						inventoryWarehouse.setAjaxParam('type', 0);
						$('input[name="ckb_group_inventory"]', wapInventory).prop('checked',false);
	                	Kiosk.updateUniform('input[name="ckb_group_inventory"]', wapInventory);
						inventoryWarehouse.reloadData();
					}else{
						inventoryWarehouse.filter(tFilter, dataFilter);
					}
				});

				wapInventory.on('click', '.chk-all', function(e){
	                var c = this.checked;
	                $('.item-select:checkbox', wapInventory).prop('checked',c);
	                Kiosk.updateUniform('.item-select', wapInventory);
	            });

    			wapInventory.on('click', '.item-inventory', function(e) {
    				if(e.target.classList[0] !== 'item-select'){
    					var id = $('.item-select', this).val();
    					inventoryWarehouse.editInventory(id);
    				}
    			});

    			/* EXPORT */
    			wapInventory.on('click', '.inventory-csv', function(event) {
    				var selected = $.map($('.item-select:checked', wapInventory), function(c){
    					return c.value; 
    				});
    				if(selected.length > 0){
						$('<form>', {
						    "id": "exportMenu",
						    "html": '<input type="hidden" id="txt_id_selected" name="txt_id_selected" value="' + selected + '" />',
						    "action": '<?php echo url::base() ?>catalogs/exportInventory',
						    "method": 'post'
						}).appendTo(document.body).submit();
					}else{
						$.bootstrapGrowl("No record selected.", { 
				           	type: 'danger' 
				        });
					}
    			});

    			/* DELETE */
    			wapInventory.on('click', '.inventory-delete', function(event) {
    				var selected = $.map($('.item-select:checked', wapInventory), function(c){
    					return c.value; 
    				});
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
			            			Kiosk.blockTableUI('.portlet-body', '391px');
			                      	$.ajax({
										url: '<?php echo url::base() ?>catalogs/deleteInventory',
										type: 'POST',
										dataType: 'json',
										data: {'chk_inventory': selected},
									})
									.done(function(data) {
										Kiosk.unblockTableUI('.portlet-body');
										if(data.msg = true){
											$.bootstrapGrowl(data.total+" items deleted.", { 
								            	type: 'success' 
								            });
										}else{
											$.bootstrapGrowl(data.total+" items deleted.", { 
								            	type: 'danger' 
								            });
										}
										$('.chk-all:checkbox', wapInventory).prop('checked', false);
					            		Kiosk.updateUniform('.chk-all', wapInventory);
										loadDataInventory();
									})
									.fail(function() {
										Kiosk.unblockTableUI('.portlet-body');
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
    			});

    			/* BY SHOW ALL */
    			wapInventory.on('click', '.btn-show-all', function(event) {
					$('.btn-filter').removeClass('green').addClass('default').prop('disabled', false);
					$(this).removeClass('default').addClass('green').prop('disabled', true);
					$('.filter-inventory').hide();
					inventoryWarehouse.filter('all');
				});
    			/* BY SHOW ALL */

    			/* BY CATEGOTY */
				wapInventory.on('click', '.btn-show-category', function(event) {
					$('.btn-filter').removeClass('green').addClass('default').prop('disabled', false);
					$(this).removeClass('default').addClass('green').prop('disabled', true);
					
					$('input[name="ckb_category[]"]', wapInventory).prop('checked', true);
	            	Kiosk.updateUniform('input[name="ckb_category[]"]', wapInventory);

					$('.filter-inventory').hide();
					$('.filter-category').show();

					var _filter = $('input[name="ckb_category[]"]:checked').map(function(){
				      return $(this).val();
				    }).get();
					inventoryWarehouse.filter('byCategory' ,_filter);
				});

				wapInventory.on('click', 'input[name="ckb_category[]"]', function(event) {
					var _filter = $('input[name="ckb_category[]"]:checked').map(function(){
				      return $(this).val();
				    }).get();
					inventoryWarehouse.filter('byCategory' ,_filter);
				});
				/* END BY CATEGOTY */

				/* BY DATE*/
				wapInventory.on('click', '.btn-show-date', function(event) {
					$('.btn-filter').removeClass('green').addClass('default').prop('disabled', false);
					$(this).removeClass('default').addClass('green').prop('disabled', true);
					$('.filter-inventory').hide();
					$('.filter-date').show();
					$('input[name="txt_date_from"]').val('');
					$('input[name="txt_date_to"]').val('');
					inventoryWarehouse.filter('all');
				});

				var timeout;
				wapInventory.on('changeDate', '.date-picker', function(event) {
					var dateFrom = $('input[name="txt_date_from"]').datepicker('getFormattedDate');
					var dateTo   = $('input[name="txt_date_to"]').datepicker('getFormattedDate');
					window.clearTimeout(timeout);
					timeout = window.setTimeout(function(){
						var _filter = [dateFrom, dateTo];
						inventoryWarehouse.filter('byDate' ,_filter);
					}, 500);
				});
				/* END BY DATE*/

				/* END BY STATUS*/
				wapInventory.on('click', '.btn-show-status', function(event) {
					$('.btn-filter').removeClass('green').addClass('default').prop('disabled', false);
					$(this).removeClass('default').addClass('green').prop('disabled', true);
					$('.filter-inventory').hide();
					$('.filter-status').show();

					$('input[name="ckb_status[]"]', wapInventory).prop('checked', true);
	            	Kiosk.updateUniform('input[name="ckb_status[]"]', wapInventory);

					var _filter = $('input[name="ckb_status[]"]:checked').map(function(){
				      return $(this).val();
				    }).get();
					inventoryWarehouse.filter('byStatus' ,_filter);
				});

				wapInventory.on('click', 'input[name="ckb_status[]"]', function(event) {
					var _filter = $('input[name="ckb_status[]"]:checked').map(function(){
				      return $(this).val();
				    }).get();
					inventoryWarehouse.filter('byStatus' ,_filter);
				});
				/* END BY STATUS*/

				wapInventory.on('change', '.ckb_group_inventory', function(event) {
					event.preventDefault();
					
					if($(this).is(':checked')){
						inventoryWarehouse.setAjaxParam('type', 1);
						loadDataInventory();
						$('.chk-all:checkbox', wapInventory).prop('checked', false);
	            		Kiosk.updateUniform('.chk-all', wapInventory);
					}else{
						inventoryWarehouse.setAjaxParam('type', 0);
						loadDataInventory();
						$('.chk-all:checkbox', wapInventory).prop('checked', false);
	            		Kiosk.updateUniform('.chk-all', wapInventory);
					}
				});

				wapInventory.on('change', '.ckb_auto_delete', function(event) {
					event.preventDefault();

					if($(this).is(':checked')){
						inventoryWarehouse.setAjaxParam("auto-delete", 1);
						loadDataInventory();
						$('.chk-all:checkbox', wapInventory).prop('checked', false);
						Kiosk.updateUniform('.chk-all', wapInventory);
					}else{
						inventoryWarehouse.setAjaxParam("auto-delete", 0);
						loadDataInventory();
						$('.chk-all:checkbox', wapInventory).prop('checked', false);
						Kiosk.updateUniform('.chk-all', wapInventory);
					}
				});
			},
			placeOrder: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getAddOrder',
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
			reviewOrder: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/viewOrder',
					type: 'GET'
				})
				.done(function(data) {
					Kiosk.unblockUI();
					$('.page-quick-wap').html(data);
					toogleQuick();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				});
			},
			inventoryRegistry: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getAddRegistry',
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
			addInventory: function(){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getAddInventory',
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
			editInventory: function(id){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>catalogs/getEditInventory',
					type: 'POST',
					data:{ 'id': id },
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
			setAjaxParam: function(name, value) {
	            ajaxParams[name] = value;
	        },
	        addAjaxParam: function(name, value) {
	            if (!ajaxParams[name]) {
	                ajaxParams[name] = [];
	            }

	            skip = false;
	            for (var i = 0; i < (ajaxParams[name]).length; i++) {
	                if (ajaxParams[name][i] === value) {
	                    skip = true;
	                }
	            }

	            if (skip === false) {
	                ajaxParams[name].push(value);
	            }
	        },
	        clearAjaxParams: function(name, value) {
	            ajaxParams = {};
	        },
	        initSelect2: function(selectElementObj, frmUsing){
	        	initSelect2(selectElementObj, frmUsing);
	        },
	        initDatePickers: function(selectElementObj){
	        	initDatePickers(selectElementObj);
	        },
	        filter: function(type, filter){
				tFilter    = type;
				dataFilter = filter;
	        	$('.chk-all:checkbox', wapInventory).prop('checked', false);
	            Kiosk.updateUniform('.chk-all', wapInventory);

	        	$(tbInventory).empty();

	        	if(tDisplay != 'grid'){
					inintList();
					$('.cls-chk-group').hide();
				}else{
					$('.cls-chk-group').show();
				}
	        	Kiosk.blockUI({
	                target: $(tbInventory)
	            });
	        	addColumn(dataRow);
	        	Kiosk.unblockUI($(tbInventory));
	        },
	       	priceRevieworder: function(){
	       		var total_price = 0;
				$('.price_store_order').each(function( index ) {
				  	total_price += parseFloat($(this).val());
				});
				total_price = total_price.toFixed(2);
				$('.lb-total').text(total_price);
	       	},
	       	reloadData: function(){
	       		loadDataInventory();
	       		$('.chk-all:checkbox', wapInventory).prop('checked', false);
				Kiosk.updateUniform('.chk-all', wapInventory);
	       	}
		};
	}();

	var frmInventory = function(){
		var wapContentIn;
		var frmIn;

		var frmSubmitInventory = function(){
			$(frmIn).validate({
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
			        $(".slt_product_item", frmIn).each(function() {
			        	var _data = $(this).select2('data');
			            if(!_data) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			            } else {
			                 $(this).closest('.in-group').removeClass('has-error');
			            }
			        });

			        $(".cls_qty", frmIn).each(function() {
			            if($(this).val() == "" && $(this).val().length < 1) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			            } else {
			                 $(this).closest('.in-group').removeClass('has-error');
			            }
			        });   

			        if(isValid) {
			        	Kiosk.blockUI();
		        		form.submit();
			        }
		        }
		    });
		};
		return {
			init: function(){
				wapContentIn = $('.wap-item-add-inventory');
				frmIn        = wapContentIn.parents('#frm-inventory');

				inventoryWarehouse.initSelect2($(".slt_product_item", frmIn), frmIn);
				inventoryWarehouse.initDatePickers($('.date-picker', frmIn));
				$(".decimal", frmIn).inputmask('decimal',{rightAlign: true});

				frmSubmitInventory();

				frmIn.on('click', '.btn-add', function() {
					frmInventory.addItemInventory();
				});

				frmIn.on('click', '.btn-delete', function() {
	    			$(this).parents(".item-add").remove();
	    		});

	    		wapContentIn.on('keyup', 'input[name="txt_qty[]"]', function(event) {
					event.preventDefault();
					var _unit   = $(this);
					var _parent = _unit.parents('.wap-item-add-inventory');
					var _slt = _parent.find('input[name="txt_product[]"]').val();
					if(_slt != ''){
						var valUnit = parseFloat(_unit.val());
						var valCost = parseFloat(_unit.attr('data-cost'));
						var valPer  = parseFloat(_unit.attr('data-per'));

						var valPrice = ((valUnit * valCost) / valPer).toFixed(2);

						var _price = _parent.find('input[name="txt_price[]"]');
						_price.val(valPrice);
					}
				});
			},
			addItemInventory: function(){
				/* Using template */
				var _item = $('.inventory-template').clone();
				_item.removeClass('inventory-template');

				var slt     = _item.find('.slt_catalog').removeClass('slt_catalog').addClass('slt_product_item');
				var date    = _item.find('.date-picker');
				var decimal = _item.find('.decimal');
				var d       = new Date();
				var n       = d.getTime();
				var vallot  = parseInt(n) + (Math.floor(Math.random() * 99));
				_item.find('.lb-lot').text(vallot);
				_item.find('input[name="txt_lot[]"]').val(vallot);
				$(wapContentIn).append(_item);

				/* inint select2, datapicker */
				inventoryWarehouse.initSelect2(slt, frmIn);
				inventoryWarehouse.initDatePickers(date);
				decimal.inputmask('decimal',{rightAlign: true});
				slt.focus();
			}
		};
	}();

	var registryInventory = function() {
		var wapReistry;
		var tbRegistry;
		var dialogAdd; 
		var loadRegistry = function (){
			tbRegistry = new Datatable();

			tbRegistry.init({
				src: $("#tb-registry-inventory"),
				dataTable: {
					"serverSide": true,
					"ordering": false,
					"scrollX": true,
					"scrollY": '320px',
					"ajax":{
						"type": "POST",
						"url" : "<?php echo url::base()?>catalogs/jsRegistry",
						data: function( d ){
		                    d._main_count = document.getElementById('total_pro').value;
		                },
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
		                		return "<div class='icon-catalog'><img style='width:28px;' src='<?php echo $this->hostGetImg ?>?files_id="+full.tdIcon+"' alt=''></div>";
		                	}else{
		                		return "<div class='icon-catalog'></div>";
		                	}
		                }
		            },{
		            	"class": "slt-row",
		                "data": "tdSubCategoryName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdProName",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdSKU",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdCost",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		            	"data": "tdUnit",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdNote",
		                "orderable": false
		            },{
		            	"class": "slt-row",
		                "data": "tdShelflifestore",
		                "orderable": false
		            },{
		            	"data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
							var btnEdit   = '';
							var btnDelete = '';
		                	<?php if($role == 'FullAccess' || (is_array($role) && substr($role['operation_inventory_registry'], -1) == '1')): ?>
								btnEdit = '<a href="javascript:;" class="btn btn-sm green btn-update"><i class="fa fa-edit"></i></a>';
								btnDelete = '<a href="javascript:;" class="btn btn-sm red btn-delete"><i class="fa fa-times"></i></a>';
		                	<?php else: ?>
		                		<?php if(is_array($role) && substr($role['operation_inventory_registry'], 0, 1) == '1'): ?>
		                			btnEdit = '<a href="javascript:;" class="btn btn-sm green btn-update"><i class="fa fa-edit"></i></a>';
		                		<?php else: ?>
		                			btnEdit = '<a href="javascript:;" class="btn btn-sm green" disabled ><i class="fa fa-edit"></i></a>';
		                		<?php endif ?>
		                		btnDelete = '<a href="javascript:;" class="btn btn-sm red" disabled ><i class="fa fa-times"></i></a>';
		                	<?php endif ?>
		                	return btnEdit+btnDelete;
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
				frmEditItemRegistry(trId);
			});
			/*
			var timeout;
			$('#myInput').on( 'keyup', function () {
				var datatable   = tbRegistry.getDataTable();
				Kiosk.blockTableUI('.table-datatable');
				var _textSearch = this.value;
				window.clearTimeout(timeout);
			    timeout = window.setTimeout(function(){
			       datatable.search(_textSearch).draw();
			    },1000);
			} );*/
		}
		
		var frmAddItemRegistry = function(){
			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getAddItemRegistry',
				type: 'GET'
			})
			.done(function(data) {
				dialogAdd = new kioskDialog();
				dialogAdd.init({
					"data": data
				});
				Kiosk.unblockUI();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
		}

		var frmEditItemRegistry = function(id){
			Kiosk.blockUI();
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getEditRegistry',
				type: 'POST',
				data: { 'id': id }
			})
			.done(function(data) {
				dialogAdd = new kioskDialog();
				dialogAdd.init({
					"data": data
				});
				Kiosk.unblockUI();
			})
			.fail(function() {
				Kiosk.unblockUI();
				$.bootstrapGrowl("Could not complete request.", { 
		        	type: 'danger' 
		        });
			});
		}

		return {
	        init: function () {
	        	wapReistry = $('.wap-registry');
	        	Kiosk.initUniform($('.chk-all', wapReistry));
	            loadRegistry();
	        },
	        get: function(){
				return tbRegistry;
			}
	    };
	}();

	$(document).ready(function() {
		inventoryWarehouse.init();
	});

	function setCookie(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	    var expires = "expires="+d.toUTCString();
	    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i = 0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) == ' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return c.substring(name.length, c.length);
	        }
	    }
	    return "";
	}

	function checkCookie(cname) {
	    var user = getCookie(cname);
	    if (user != "") {
	    	return true;
	    } else {
	        return false;
	    }
	}
</script>