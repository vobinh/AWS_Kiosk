<script type="text/javascript">
	var TimeCard = function(){
		var oTable, wapContent;
		var handleEvent = function(){
			$('.cls-btnPreDay', wapContent).click(function(event) {
				Kiosk.blockUI();
				var txt_date_end = $('input[name="txt_date_end"]').val();
				var txt_date_to = $('input[name="txt_date_to"]').val();
				$.ajax({
			        type: 'POST',
			        dataType :'json',
			        url: '<?php echo url::base()?>employees/PrevDayTimeCard',
			        data:{txt_date_to:txt_date_to,txt_date_end:txt_date_end},
			        success: function(d) {
			        	$('input[name="txt_date_to"]').val(d.date_to_prev);
			        	$('input[name="txt_date_end"]').val(d.date_end_prev);
			            $('#frm-timecard').submit();
			        }
			    });
			});

        	$('.cls-btnToDay', wapContent).click(function(event) {
        		$('input[name="txt_date_end"]').val('');
        		$('input[name="txt_date_to"]').val('');
        		$('#frm-timecard').submit();
			});

			$('.cls-btnNextDay', wapContent).click(function(event) {
				Kiosk.blockUI();
				var txt_date_end = $('input[name="txt_date_end"]').val();
				var txt_date_to = $('input[name="txt_date_to"]').val();
				$.ajax({
			        type: 'POST',
			        dataType :'json',
			        url: '<?php echo url::base()?>employees/NextDayTimeCard',
			        data:{txt_date_to:txt_date_to,txt_date_end:txt_date_end},
			        success: function(d) {
			        	$('input[name="txt_date_to"]').val(d.date_to_next);
			        	$('input[name="txt_date_end"]').val(d.date_end_next);
			            $('#frm-timecard').submit();
			        }
			    });
			});

			$('.timecard-delete', wapContent).click(function(event) {
				var Ids_Access = [];
			    $.each($("#tb-timecard span.checked"),function(){ 
			        Ids_Access.push($(this).children().val()); 
			    });
			    var txt_date_end = $('input[name="txt_date_end"]').val();
				var txt_date_to = $('input[name="txt_date_to"]').val();

				if(Ids_Access.length > 0){
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
									url: '<?php echo url::base() ?>employees/deleteTimecard',
									type: 'POST',
									dataType: 'json',
									data: {
										'idEmpl': Ids_Access,
										'txt_date_to': txt_date_to,
										'txt_date_end' : txt_date_end
									}
								})
								.done(function(data) {
									$('#frm-timecard').submit();
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

			$('#chk-all-timecard').live("click", function(){
				var cells = oTable.cells( ).nodes();
    			
    			if($(this).is(':checked')){
    				$( cells ).find('span').addClass('checked');
    			}else{
    				$( cells ).find('span').removeClass('checked');
    			}
			});

			$('#slt_store_active', wapContent).change(function(event) {
				var storeId = $(this).val();
				$.ajax({
			        type: 'POST',
			        url: '<?php echo url::base()?>employees/setStoreTimeCard',
			        data: {storeId:storeId},
			        success: function(d) {
			            $('#frm-timecard').submit();
			        }
			    });
			});
		};
		var handleData = function(storeId){
			Kiosk.blockUI();
			var txt_date_end = $('input[name="txt_date_end"]').val();
			var txt_date_to = $('input[name="txt_date_to"]').val();

			$.ajax({
		        type: 'POST',
		        dataType:'json',
		        url: '<?php echo url::base()?>employees/getDataTimeCard',
		        data: {storeId:storeId,txt_date_end:txt_date_end,txt_date_to:txt_date_to},
		        success: function(d) {
		            oTable = $('#tb-timecard').DataTable({
		            	paging: false,
						ordering: false,
						bInfo : false,
						scrollY: '330px',
						scrollX: true,
		                data: d.data,
		                columns: d.columns,
		                rowCallback: function( row, data, index ) {
							$(row).find('.cls-chk').parents('td').addClass('cls-today');
			            }
		            });
		            Kiosk.initUniform($('input[type="checkbox"]'),$('#tb-timecard'));
		            Kiosk.unblockUI();
		        }
		    });
		};
		return {
			init: function(){
				wapContent = $('.wap-list-timecard');
				var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapContent).val();
				}
				handleData(storeId);
				handleEvent();
			},
			openDay: function(idEmpl, day){
				var storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapContent).val();
				}
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>employees/getAddTimeCard',
					type: 'POST',
					data: {
						'idEmpl': idEmpl,
						'day': day,
						'storeId' : storeId
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

	var frmTimeCard = function(){
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
					var isValid   = true;
					var isMessage = true;
					var isFocus   = true;
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
			        $("select[name='txt_mechine_id[]']:visible", frm).each(function() {
			            if(!$(this).val()) {
			                $(this).closest('.in-group').addClass('has-error');
			                isValid = false;
			                if(isFocus){
			                	$(this).focus();
			                	isFocus = false;
			                }
			                isMessage = false;
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
			        	if(isMessage){
			        		$.bootstrapGrowl("The schedule cannot be duplicated.", { 
					        	type: 'danger' 
					        });
			        	}else{
			        		$.bootstrapGrowl("Machine not empty.", { 
					        	type: 'danger' 
					        });
			        	}
			        }else{
			        	Kiosk.blockUI();
						//form.submit();
						$.ajax({
							type: "POST",
							url: '<?php echo url::base() ?>employees/saveTimeCard',
							data: frm.serialize(),
							success: function(response) {
								if(response == true){
									$('#frm-timecard').submit();
								}else{
									$.bootstrapGrowl("Error Save.", { 
							        	type: 'danger' 
							        });
								}
							}
						});
			        }
		        }
		    });
    	};
		return {
			init: function(){
				frm        = $('#frm-scheduling-timecard');
				wapContent = $('.wap-scheduling-timecard');
				handleTimePickers();
				handleValidate();
				handleEvent();
			}	
		}
	}();

	$(document).ready(function() {
		TimeCard.init();
	});
</script>