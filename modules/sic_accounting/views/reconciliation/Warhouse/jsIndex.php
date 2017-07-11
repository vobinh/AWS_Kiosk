<script type="text/javascript">
	var Warhouse_Accounting = function(){
		var tbData, wapContent, storeId;
		var handleEvent = function(){
			$('#slt_store_active', wapContent).change(function(event) {
				$('#frm-accounting').submit();
			});
			$('select[name="tb-warhouse-accounting_length"]').addClass('input-sm');

			$('.btn-adjustment', wapContent).click(function(event) {
				var type = $(this).attr('data-val');
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>accounting/addAdjustment',
					type: 'post',
					data: {
						dataType: type
					}
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
			});

			$('.btn-shifts', wapContent).click(function(event) {
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>accounting/setShifts',
					type: 'GET',
				})
				.done(function(data) {
					$('.page-quick-wap').html(data);
					toogleQuick();
				})
				.fail(function() {
					$.bootstrapGrowl("Could not complete request.", { 
			        	type: 'danger' 
			        });
				})
				.always(function() {
					Kiosk.unblockUI();
				});
				
			});
		};
		var handleData = function(storeId){
			var type_warhouse = $('#type_warehouse').val();
			tbData = $("#tb-warhouse-accounting").DataTable({
				"searching": false,
				"ordering": false,
				"scrollX": true,
				"bLengthChange": true,
				"pageLength": 10
			});
		};
		var handleTimePickers = function(){
    		$('.timepicker-24').timepicker({
    			timeFormat: 'HH:mm',
	            autoclose: true,
	            minuteStep: 5,
	            showSeconds: false,
	            showMeridian: false,
	            showInputs: false
	        });

    		$('.timepicker-24').click(function(event) {
    			$('.timepicker-24').timepicker('hideWidget');
    			$(this).timepicker('showWidget');
    		});
	        /*$('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
	            e.preventDefault();
	            $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
	            alert(123);
	        });*/
    	};
		return {
			init: function(){
				wapContent = $('.wap-warhouse-accounting');
				storeId = '<?php echo (string)base64_decode($this->sess_cus["storeId"]); ?>';
				if(storeId == '0'){
					storeId = $('#slt_store_active', wapContent).val();
				}
				handleData(storeId);
				handleEvent();
				handleTimePickers();
			},
			Date_Filter: function(day){
				$('#date_filter').val(day);
				$.ajax({
			        type: 'POST',
			        dataType :'json',
			        url: '<?php echo url::base()?>accounting/DateFilter',
			        data:{day:day},
			        success: function(d) {
			        	$('input[name="txt_date_from"]').val(d.date_to);
			        	$('input[name="txt_date_to"]').val(d.date_end);
			        	Kiosk.blockUI();
			        	$('#frm-accounting').submit();
			        }
			    });
			},
			whType: function(type){
				$('#type_warehouse').val(type);
				Kiosk.blockUI();
				$('#frm-accounting').submit();
			},
			sFilter: function(type, mval){
				$('#shift_filter').val(type);
				var timeFrom = '00:00';
				var timeTo   = '23:59';
				var mTime    = mval.split('|');
				if(mTime.length > 1){
					timeFrom     = mTime[0];
					timeTo       = mTime[1];
				}else{
					$('#shift_filter').val(1);
				}
				
				$('input[name="txt_time_from"]').val(timeFrom);
			    $('input[name="txt_time_to"]').val(timeTo);
			    Kiosk.blockUI();
			    $('#frm-accounting').submit();
			}
		}
	}();



	$(document).ready(function() {
		Warhouse_Accounting.init();
	});
</script>