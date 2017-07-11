<script src="https://deuxhuithuit.github.io/quicksearch/r/src/jquery.quicksearch.js"></script>

<script type="text/javascript">
    var frmCategory = function(){
    	var frm,
    		wapContent;

    	var handleEvent = function(){
    		/*wapContent.on('click', '.btn-upload', function(event) {
    			event.preventDefault();
    			Kiosk.blockUI();
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
				    		$('#uploadfilehd', wapContent).val(response.data[0]['file_id']);
				    		$('.btn-upload', wapContent).hide();
				    	}else{
				    		$('#uploadfilehd', wapContent).val('');
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
    		});*/

    		/*$('#uploadfile').on('change.bs.fileinput', function(event, files) {
			    $('.btn-upload').removeAttr('style');
			});*/
    	};

    	var addItem = function(){
    		/* Using template */
			var _item = $('.category-item-template').clone();
			_item.removeClass('category-item-template');
			_item.appendTo(wapContent).show();
    	};

    	var addCategory = function(){

			frm.on('click', '.btn-add', function() {
				addItem();
			});
			
		};

    	var deleteItem = function(){

    		wapContent.on('click', '.btn-delete', function() {
    			if($('.wap-item-add-category').children().length > 1)
    				$(this).parents(".item-add-category").remove();
    		});

			wapContent.on('click', '.btn-delete-sub', function() {
    			$(this).parents(".item-sub").remove();
    		});
    	};

		var frmSubmit = function(){
			$(frm).validate({
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
			        $("input[name='txt_name[]']", frm).each(function() {
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
			        	var data = $("form#frm-category").serializeArray();
						$.ajax({
							url: '<?php echo url::base() ?>catalogs/chk_category_name',
							type: 'POST',
							dataType: 'json',
							data: data,
						})
						.done(function(data) {
							Kiosk.unblockUI();
							if(data == ''){
								$.bootstrapGrowl("Category name must be unique.", { 
						        	type: 'danger' 
						        });
								return false;
							}else{
								Kiosk.blockUI();
								form.submit();
							}
						})
						.fail(function() {
							Kiosk.unblockUI();
							$.bootstrapGrowl("Could not complete request.", { 
					        	type: 'danger' 
					        });
						});
			        	
			        }
		        	
		        }
		    });
		};

		/* Main Page */
		var loadDataCategory = function(){
			Kiosk.blockUI({
                target: $(bodyData)
            });
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getDataCategory',
				type: 'POST',
				dataType: 'json',
				data: ajaxParams,
			})
			.done(function(data) {
				dataRow = data;
				addColumn(dataRow);
				Kiosk.unblockUI($(bodyData));
			})
			.fail(function() {
				Kiosk.unblockUI($(bodyData));
			});
			
		};

    	return {
    		init: function(taget){
    			wapContent = taget;
				frm        = taget.parents('#frm-category');
				$('input', frm).keypress(function (e) {
			        if (e.which == 13) {
			            if ($(frm).validate().form()) {
			                $(frm).submit();
			            }
			            return false;
			        }
			    });
    			addCategory();
    			deleteItem();
    			frmSubmit();
    			handleEvent();
    		}
    	};
    }();

    function editCategory(id){
    	Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>catalogs/getEditCategory',
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
    }

	function addCategory(){
		Kiosk.blockUI();
		$.ajax({
			url: '<?php echo url::base() ?>catalogs/getAddCategory',
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
	}

	var pageCategory = function(){
		var wapContentCategory;
		var ajaxParams = {};
		var qSearch;

		var loadData = function(){
			Kiosk.blockUI({
                target: $(bodyData)
            });
			$.ajax({
				url: '<?php echo url::base() ?>catalogs/getDataCategory',
				type: 'POST',
				dataType: 'json',
				data: ajaxParams,
			})
			.done(function(data) {
				/*dataRow = data;*/
				$('.body-data-category', wapContentCategory).html('');
				addItemPage(data);
				Kiosk.unblockUI($(bodyData));
				//$('.tooltips').tooltip();
				qSearch.cache();
			})
			.fail(function() {
				Kiosk.unblockUI($(bodyData));
			});
			
		};
		var addItemPage = function(data){
			var defaultRow  = $('.category-template');
			if(data.length > 0){
				data.forEach(function(item, index){
					var row = defaultRow.clone();
					row.removeClass('category-template').addClass('wap-item-category');
					row.find('.data-sub-id').val(item['sub_category_id']);
					if(item['file_id'] != '' && item['file_id'] != null){
						row.find('.in-img').attr('src','<?php echo $this->hostGetImg ?>?files_id='+item['file_id']);
					}else{
						row.find('.in-img').attr('src','<?php echo url::base() ?>themes/kiosk/pages/img/1487153375_catalog.png');
					}

					row.find('.data-name')
						.addClass(item['color'])
						.attr({
							'data-original-title': item['catalog_name'],
							'title': item['catalog_name']
						})
						.html(item['catalog_name']);

					row.find('.data-sub-name')
						.addClass('tooltips')
						.attr({
							'data-original-title': item['sub_category_name'],
							'title': item['sub_category_name']
						})
						.html(item['sub_category_name']);

					row.find('.data-sub-date').html(item['sub_category_date']);
					row.find('.data-total').html(item['total'] + ' Items');
					row.appendTo(bodyData).show();
				});
				var checkbox = $('.item-select', bodyData);
				Kiosk.initUniform(checkbox);
			}
			
		};
		return{
			init: function(taget){

    			wapContentCategory = taget;
    			bodyData = taget.find('.body-data-category');

    			qSearch = $('input#search', wapContentCategory).quicksearch('.wap-item-category');

    			pageCategory.loadData('all');

    			wapContentCategory.on('click', '.chk-all', function(e){
	                var c = this.checked;
	                $('.item-select:checkbox:visible', wapContentCategory).prop('checked',c);
	                Kiosk.updateUniform('.item-select', wapContentCategory);
	            });

    			wapContentCategory.on('click', '.item-category', function(e) {
    				if(e.target.classList[0] !== 'item-select'){
    					var id = $('.item-select', this).val();
    					editCategory(id);
    				}
    			});

    			wapContentCategory.on('click', '.category-delete', function(event) {
    				var selected = $.map($('.item-select:checked', wapContentCategory), function(c){
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
											url: '<?php echo url::base() ?>customers/delete/customers',
											type: 'POST',
											dataType: 'json',
											data: {'chk_customer': selected},
										})
										.done(function(data) {
											Kiosk.unblockTableUI('.portlet-body');
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
					}
    			});
				
				wapContentCategory.on('click', '.btn-show-category', function(event) {
					event.preventDefault();
					$('.btn-show-category').removeClass('green').addClass('default').prop('disabled', false);
					$(this).removeClass('default').addClass('green').prop('disabled', true);
					
					$('.chk-all:checkbox', wapContentCategory).prop('checked', false);
	            	Kiosk.updateUniform('.chk-all', wapContentCategory);

					var category_type = $(this).attr('data-value');
					if(category_type){
						pageCategory.loadData(category_type);
					}
				});
    		},
    		loadData: function(filter){
    			if(filter){
    				pageCategory.setAjaxParam('category_type', filter);
    			}
    			loadData();
    			pageCategory.clearAjaxParams();
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
	        }
		};
	}();

	$(function() {

	});

	$(document).ready(function() {
		pageCategory.init($('.wap-content-category'));
	});

</script>