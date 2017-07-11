<script type="text/javascript">
	var Index = function () {
		var tbTransations;
		var handleEvent = function(){
			$('#txt_filter_customers').click(function(event) {
				var c = this.checked;
				$('.txt_customer:checkbox').prop('checked',c);
				Kiosk.updateUniform('.txt_customer');
			});

			$('#txt_filter_payment').click(function(event) {
				var c = this.checked;
				$('.txt_payment:checkbox').prop('checked',c);
				Kiosk.updateUniform('.txt_payment');
			});

			$('#btnShowData').click(function(event) {
				$('.cls-chart').slideUp();
				$('.cls-table').slideDown();
				$(this).removeClass('default').addClass('green');
				$('#btnShowChart').removeClass('green').addClass('default');
			});

			$('#btnShowChart').click(function(event) {
				$('.cls-table').slideUp();
				$('.cls-chart').slideDown();
				$(this).removeClass('default').addClass('green');
				$('#btnShowData').removeClass('green').addClass('default');
			});

			$('.btn-day').click(function(event) {
				var date = $(this).attr('data-date');
				$('input[name="txt_hd_date"]').val(date);
				$('input[name="txt_hd_type"]').val('day');
				Kiosk.blockUI();
				$('#frm-saler-report').submit();
			});

			$('.btn-submit').click(function(event) {
				$('input[name="txt_hd_type"]').val('range');
				Kiosk.blockUI();
				$('#frm-saler-report').submit();
			});
		};

		var handleReport = function () {
			
		};

		function getDetail (callback) {
			var tlId = callback.data().DT_RowId;
			$.ajax({
	            url: '<?php echo url::base() ?>reports/getDetailOrder',
	            type: 'post',
	            data:{
	            	'idOrder': tlId,
	            	'mainTax': callback.data()[2],
	            	'mainTotal': callback.data()[3],
	            	'type': 'transations',
	            },
	            beforeSend: function () {
	                Kiosk.blockUI({
	                    overlayColor: 'none',
	                    cenrerY: true,
	                });
	            }
	        })
            .done(function (data) {
                callback.child(data).show();
                Kiosk.unblockUI();
            })
            .fail(function () {
                callback('Error').show();
                Kiosk.unblockUI();
            });
		};

		var handleTransations = function (){
			tbTransations = $("#tb-transations").DataTable({
				"searching": false,
				"ordering": false,
				"scrollX": true,
				"bLengthChange": false,
				"pageLength": 10
			});
			var detailRows = [];
			$('#tb-transations tbody').on( 'click', 'tr td.details-control button', function () {
				var btn = $(this);
				var tr  = btn.closest('tr');
				var row = tbTransations.row( tr );
	           	if(row.child.isShown()){
		           	btn.removeClass('red').addClass('green').text('Detail');
		            row.child.hide();
		        }else{
		           btn.removeClass('green').addClass('red').text('Close');
		           getDetail(row);
		        }
			});
		};

	    return {
	    	init: function(){
	    		handleEvent();
	    		handleTransations();
	    	},
	        initAmCharts: function(){
				var typeData                  = '<?php echo $typeDate ?>';
				var dataDateFormat            = 'HH:NN';
				var categoryBalloonDateFormat = 'JJ:NN';
				var minPeriod                 = 'mm';

				if(typeData != 'today'){
					dataDateFormat            = 'MM/DD/YYYY';
					categoryBalloonDateFormat = 'MM/DD/YYYY';
					minPeriod                 = 'DD';
				}

				AmCharts.checkEmptyData = function(chart) {
					if (0 == chart.dataProvider.length) {
						// set min/max on the value axis
						chart.valueAxes[0].minimum = 0;
						chart.valueAxes[0].maximum = 100;

						// add dummy data point
						var dataPoint = {
						  dummyValue: 0
						};
						dataPoint[chart.categoryField] = '';
						chart.dataProvider = [dataPoint];

						// add label
						chart.addLabel(0, '50%', 'The chart contains no data', 'center');

						// set opacity of the chart div
						chart.chartDiv.style.opacity = 0.5;

						// redraw it
						chart.validateNow();
					}
				}

				var dataTax = [];
				var data1   = <?php echo !empty($taxChart)?$taxChart:'[]' ?>;
	        	$.each(data1, function(index, val) {
					var _temp      = [];
					_temp['value'] = val;
					_temp['date']  = index;
	        		dataTax.push(_temp);
	        	});

	        	if ($('#site_activities').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	                $('#site_activities_loading').hide();
	                $('#site_activities_content').show();
		        	var salesChart = AmCharts.makeChart("site_activities",{
						"type": "serial",
						"precision": 2,
						"pathToImages": "<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/images/",
						"categoryField": "date",
						"dataDateFormat": "MM/DD/YYYY",
						"categoryAxis": {
							//"minPeriod": minPeriod,
							"parseDates": true,
							//"labelFunction": function(valueText, date, categoryAxis) {
						      	//return moment(date).format('MM/DD/YYYY');
						    //}
						},
						"chartScrollbar": {
							//"enabled": true
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": "MM/DD/YYYY"
						},
						"trendLines": [],
						"graphs": [
							{
								"bullet": "round",
								"title": "Tax",
								"valueField": "value"
							}
						],
						"guides": [],
						"valueAxes": [
							{
								"id": "ValueAxis-1",
								"title": ""
							}
						],
						"allLabels": [],
						"balloon": {},
						"legend": {
							"enabled": false,
							"useGraphSettings": true
						},
						"dataProvider": dataTax
					});
					AmCharts.checkEmptyData(salesChart);
		        }

				var revenueChart       = <?php echo $revenueChart ?>;
				var revenueChartGraphs = <?php echo $revenueChartGraphs ?>;
	        	if ($('#site_activities_2').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	                $('#site_activities_loading_2').hide();
	                $('#site_activities_content_2').show();
		        	var salesChart = AmCharts.makeChart("site_activities_2",{
						"type": "serial",
						"precision": 2,
						"pathToImages": "<?php echo $this->site['base_url'] ?>plugins/global/plugins/amcharts/amcharts/images/",
						"categoryField": "category",
						"dataDateFormat": "MM/DD/YYYY",
						"categoryAxis": {
							//"minPeriod": minPeriod,
							"parseDates": true,
							//"labelFunction": function(valueText, date, categoryAxis) {
						      	//return moment(date).format('MM/DD/YYYY');
						    //}
						},
						"chartScrollbar": {
							"enabled": true
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": 'MM/DD/YYYY'
						},
						"trendLines": [],
						"graphs": revenueChartGraphs,
						"guides": [],
						"valueAxes": [
							{
								"id": "ValueAxis-1",
								"title": ""
							}
						],
						"allLabels": [],
						"balloon": {},
						"legend": {
							"enabled": true,
							"useGraphSettings": true
						},
						"dataProvider": revenueChart
					});
					AmCharts.checkEmptyData(salesChart);
		        }
	        }
	    };
	}();

	$(document).ready(function() {
		Index.init();
		Index.initAmCharts();

		$('.cls-filter').click(function(event) {
			var type = $(this).attr('data-value');
			if(type == 'range'){
				$('.cls-range').show();
				$('.cls-filter').removeClass('btn-primary').addClass('default').prop('disabled', false);
				$(this).removeClass('default').addClass('btn-primary').prop('disabled', true);
				$('#txt_hd_type').val(type);
			}else{
				$('.cls-range').hide();
				$('.cls-filter').removeClass('btn-primary').addClass('default').prop('disabled', false);
				$(this).removeClass('default').addClass('btn-primary').prop('disabled', true);
				$('#txt_hd_type').val(type);
				$('#frm-home').submit();
			}
		});

		$('#frm-home').submit(function(event) {
			Kiosk.blockUI();
		});

		$('#slt_store_active').change(function(event) {
            Kiosk.blockUI();
            var storeId = $(this).val();
            window.location.href = '<?php echo url::base() ?>reports/setStore/'+storeId+'/2';
        });
	});
</script>