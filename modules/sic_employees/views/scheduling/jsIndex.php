<script type="text/javascript">
	var scheduling = function(){
		var tbData, wapContent;
		var handleEvent = function(){
			$('.cls-btnPreDay', wapContent).click(function(event) {
				tbData.setAjaxParam("date", $(this).attr('data-day'));
				scheduling.reloadData();
			});

        	$('.cls-btnToDay', wapContent).click(function(event) {
				tbData.setAjaxParam("date", $(this).attr('data-day'));
				scheduling.reloadData();
			});

        	$('.cls-btnNextDay', wapContent).click(function(event) {
				tbData.setAjaxParam("date", $(this).attr('data-day'));
				scheduling.reloadData();
			});

			$('.cls-btnDuplicate', wapContent).click(function(event) {
				var selected = tbData.getSelectedID();
				var day      = $(this).attr('data-day');
				if(selected.length > 0){
					bootbox.confirm({
			            message: "Are you sure you want to Duplicate Previous Week's?",
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
			            		Kiosk.blockUI();
		            			$.ajax({
									url: '<?php echo url::base() ?>employees/setDuplicate',
									type: 'POST',
									dataType: 'json',
									data: {
										'idEmpl': selected,
										'date': day
									}
								})
								.done(function(data) {
									if(data['msg'] == true){
										$.bootstrapGrowl("Changes saved.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl("Error.", { 
							            	type: 'danger' 
							            });
									}
									Kiosk.unblockUI();
									scheduling.reloadData();
								})
								.fail(function() {
									Kiosk.unblockUI();
									$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
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

			$('.scheduling-delete', wapContent).click(function(event) {
				var selected = tbData.getSelectedID();
				var day      = $('.txt_hd_actionday', wapContent).val();
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
			            		Kiosk.blockUI();
		            			$.ajax({
									url: '<?php echo url::base() ?>employees/deleteScheduling',
									type: 'POST',
									dataType: 'json',
									data: {
										'idEmpl': selected,
										'date': day
									}
								})
								.done(function(data) {
									if(data['msg'] == true){
										$.bootstrapGrowl("Changes saved.", { 
							            	type: 'success' 
							            });
									}else{
										$.bootstrapGrowl("Error.", { 
							            	type: 'danger' 
							            });
									}
									Kiosk.unblockUI();
									scheduling.reloadData();
								})
								.fail(function() {
									Kiosk.unblockUI();
									$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
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

			/*$('#slt_store_active', wapContent).select2({ 
				minimumResultsForSearch: -1,
				dropdownAutoWidth : true,
				width: 'resolve'
			});*/

			$('#slt_store_active', wapContent).change(function(event) {
				tbData.setAjaxParam('store_id', $(this).val());
				scheduling.reloadData();

			});
		};
		var handleData = function(storeId){
			tbData = new Datatable();
			tbData.setAjaxParam('store_id', storeId);
			tbData.init({
				src: $("#tb-scheduling"),
				wapHeight: "389px",
				dataTable: {
					paging: false,
					ordering: false,
					bInfo : false,
					serverSide: true,
					ordering: false,
					scrollX: true,
					scrollY: '345px',
					"ajax":{
						"url" : "<?php echo url::base()?>employees/getDataScheduling",
					},
					"columns": [{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	return "<input type='checkbox' class='item-select' name='chk_item[]' value='"+full.emplId+"'>";
		                }
		            },{
		                "data": null,
		                "class": "slt-row",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	return full.employees;
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Sunday){
		                		clsToday = 'today';
		                	}
		                	if(full.Sundaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Sunday+'\')" class="scheduling '+clsToday+'">'+full.Sundaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Sunday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Monday){
		                		clsToday = 'today';
		                	}
		                	if(full.Mondaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Monday+'\')" class="scheduling '+clsToday+'">'+full.Mondaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Monday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
							var today    = full.today;
							var clsToday = '';
		                	if(today == full.Tuesday){
		                		clsToday = 'today';
		                	}
		                	if(full.Tuesdaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Tuesday+'\')" class="scheduling '+clsToday+'">'+full.Tuesdaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Tuesday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Wednesday){
		                		clsToday = 'today';
		                	}
		                	if(full.Wednesdaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Wednesday+'\')" class="scheduling '+clsToday+'">'+full.Wednesdaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Wednesday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Thursday){
		                		clsToday = 'today';
		                	}
		                	if(full.Thursdaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Thursday+'\')" class="scheduling '+clsToday+'">'+full.Thursdaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Thursday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Friday){
		                		clsToday = 'today';
		                	}
		                	if(full.Fridaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Friday+'\')" class="scheduling '+clsToday+'">'+full.Fridaytime+'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Friday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-center",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	var today = full.today;
		                	var clsToday = '';
		                	if(today == full.Saturday){
		                		clsToday = 'today';
		                	}
		                	if(full.Saturdaytime != ""){
		                		return '<div onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Saturday+'\')" class="scheduling '+clsToday+'">'+full.Saturdaytime +'</div>';
		                	}else{
		                		return '<button onclick="scheduling.openDay(\''+full.emplId+'\',\''+full.Saturday+'\')" class="btn btn-sm green '+clsToday+'"><i class="fa fa-plus"></i></button>';
		                	}
		                }
		            },{
		                "data": null,
		                "class": "slt-row cls-right",
		                "orderable": false,
		                "render": function ( data, type, full, meta ) {
		                	return full.total;
		                }
		            }],
		            "rowCallback": function( row, data, index ) {
		            	$(row).find('.today').parents('.slt-row').addClass('cls-today');
		            },
		            headerCallback: function( thead, data, start, end, display ) {
		            	var response = this.api().ajax.json();
		            	$(thead).find('th').eq(2).html(response['calendar']['listFormat'][0]);
		            	$(thead).find('th').eq(3).html(response['calendar']['listFormat'][1]);
		            	$(thead).find('th').eq(4).html(response['calendar']['listFormat'][2]);
		            	$(thead).find('th').eq(5).html(response['calendar']['listFormat'][3]);
		            	$(thead).find('th').eq(6).html(response['calendar']['listFormat'][4]);
		            	$(thead).find('th').eq(7).html(response['calendar']['listFormat'][5]);
		            	$(thead).find('th').eq(8).html(response['calendar']['listFormat'][6]);

		            	$('.cls-strFormat', wapContent).html(response['calendar']['strFormat']);
		            	$('.cls-btnPreDay', wapContent).attr('data-day', response['calendar']['preDay']);
		            	$('.cls-btnToDay', wapContent).attr('data-day', response['calendar']['toDay']);
		            	$('.cls-btnNextDay', wapContent).attr('data-day', response['calendar']['nextDay']);
		            	$('.cls-btnDuplicate', wapContent).attr('data-day', response['calendar']['preDay']);
		            	$('.txt_hd_actionday', wapContent).val(response['calendar']['actionDay']);
		            },
		           	footerCallback: function ( row, data, start, end, display ) {
		            }
				}
			});
		};
		return {
			init: function(){
				wapContent = $('.wap-list-scheduling');
				var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapContent).val();
				}
				
				handleData(storeId);
				handleEvent();
			},
			reloadData: function(){
				var datatable    = tbData.getDataTable();
				var tablewrapper = tbData.getTableWrapper();
				
				tbData.clearSelectedID();
				$('.chk-all', tablewrapper).prop('checked',false);
				Kiosk.updateUniform('.chk-all', tablewrapper);
				datatable.ajax.reload();
			},
			openDay: function(idEmpl, day){
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>employees/getAddScheduling',
					type: 'POST',
					data: {
						'idEmpl': idEmpl,
						'day': day
					}
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
					Kiosk.unblockUI();
				})
				.fail(function() {
					Kiosk.unblockUI();
					$.bootstrapGrowl("Could not complete request. Please check your internet connection.", { 
			        	type: 'danger' 
			        });
				});
			}
		}
	}();

	var frmScheduling = function(){
		var frm,
    		wapContent;

    	var lbShift = function(){
    		$('.cls-shift', wapContent).each(function(index, el) {
    			$(this).text('Shift '+(index+1));
    		});
    	};

    	var handleEvent = function(){
    		wapContent.on('click', '.btn-add', function(event) {
    			event.preventDefault();
    			var dataEnd = $("input[name='txt_date_end[]']", frm).last().val();
    			var _item = $('.scheduling-item-template').clone();
				_item.removeClass('scheduling-item-template').show();
				_item.find("input[name='txt_date_start[]']").val(dataEnd);
				_item.find('input[type="text"]').addClass('timepicker').addClass('timepicker-24');
				$(wapContent).find('.wap-item-add-category').append(_item);
				handleTimePickers();
				lbShift();
				_item.find('input[type="text"]').first().focus();
    		});

    		wapContent.on('click', '.btn-delete', function(event) {
    			event.preventDefault();
    			$(this).parents('.item-add-category').remove();
    			lbShift();
    		});

    	};

    	var handleTimePickers = function(){
    		var timeout;
    		$('.timepicker-24').timepicker({
    			timeFormat: 'HH:mm',
	            autoclose: true,
	            minuteStep: 5,
	            showSeconds: false,
	            showMeridian: false
	        }).on('changeTime.timepicker', function(e) {
	        	var _this = $(this);
			 	if(_this.attr('name') == 'txt_date_start[]'){
					var _s     = e.time.value;
					var _stime = moment(_s,'HH:mm');

					var _inEnd = _this.parents('.item-add-category').find('input[name="txt_date_end[]"]');
					var _e     = _inEnd.val();
					var _etime = moment(_e,'HH:mm');
					if(_etime <= _stime){
						var _strTime = _stime.add(30, 'minute').format('HH:mm');
						_inEnd.timepicker('setTime', _strTime);

					}
				}
				if(_this.attr('name') == 'txt_date_end[]'){
					window.clearTimeout(timeout);
					var _inStart = _this.parents('.item-add-category').find('input[name="txt_date_start[]"]');
					var _s       = _inStart.val();
					var _stime   = moment(_s,'HH:mm');
					
					var _e       = e.time.value;
					var _etime   = moment(_e,'HH:mm');
					if(_etime <= _stime){
						$(_this).closest('.in-group').addClass('has-error');
						_this.focus();
					    timeout = window.setTimeout(function(){
					       $.bootstrapGrowl("End time cannot be less than start time.", { 
					        	type: 'danger' 
					        });
					    },1000);
					}else{
						$(_this).closest('.in-group').removeClass('has-error');
					}
			 	}
			 });

	        $('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
	            e.preventDefault();
	            $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
	        });
    	};

		var handleValidate = function(){
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
			        $("input[name='txt_date_start[]']", frm).each(function() {
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
			        $("input[name='txt_date_end[]']", frm).each(function() {
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
			        	var start = $("input[name='txt_date_start[]']", frm).map(function(index, elem) {
			        		return $(this).val();
			        	}).get();

			        	var end = $("input[name='txt_date_end[]']", frm).map(function(index, elem) {
			        		return $(this).val();
			        	}).get();

			        	var format = 'HH:mm';
			        	for (var i = 0; i <= start.length - 1; i++) {
							var _s     = start[i];
							var _stime = moment(_s,format);
							
							var _e     = end[i];
							var _etime = moment(_e,format);
			        		
			        		if(_etime <= _stime){
			        			var _this = $("input[name='txt_date_end[]']", frm).eq(i);
			        			$(_this).closest('.in-group').addClass('has-error');
			        			_this.focus();
						       $.bootstrapGrowl("End time cannot be less than start time.", { 
						        	type: 'danger' 
						        });
						       isFocus = false;
						       return false;
			        		}else{
			        			$(_this).closest('.in-group').removeClass('has-error');
			        		}

			        		for (var j = (i+1); j <= start.length - 1; j++) {
								var _ss     = start[j];
								var _sstime = moment(_ss,format);
			        			var _this = $("input[name='txt_date_start[]']", frm).eq(j);
			        			if(_sstime < _etime){
			        				$(_this).closest('.in-group').addClass('has-error');
			        				if(isFocus){
					                	$(_this).focus();
					                	isFocus = false;
					                }
			        				isValid = false;
			        			}
			        		}
			        	};
			        }
			        if(!isValid){
						$.bootstrapGrowl("The schedule cannot be duplicated.", { 
				        	type: 'danger' 
				        });
			        }else{
			        	Kiosk.blockUI();
						form.submit();
			        }
		        }
		    });
    	};
		return {
			init: function(){
				frm        = $('#frm-scheduling');
				wapContent = $('.wap-scheduling');
				handleTimePickers();
				handleValidate();
				handleEvent();
			}	
		}
	}();
	$(document).ready(function() {
		scheduling.init();
	});
</script>