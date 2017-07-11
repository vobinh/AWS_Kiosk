<script type="text/javascript">
	var listCustomers = function() {
		var tbCustomers;
		var mType    = '<?php echo $mType ?>';
		var dataFrom = '<?php echo $txt_date_from ?>';
		var dataTo   = '<?php echo $txt_date_to ?>';
		var loadCustomers = function (){
			$("#tb-customers").DataTable({
				'info' : false,
				"ordering": false,
				"scrollX": true,
				"scrollY": '360px',
				"paging": false
			});
		}
				
		return {
	        init: function () {
	            loadCustomers();
	        },
	        get: function(){
				return tbCustomers;
			},
			detail: function(userId, btn){
				var name = $(btn).parents('tr').find('.cls-cus-name').attr('data-value').trim();
				Kiosk.blockUI();
				$.ajax({
					url: '<?php echo url::base() ?>reports/getDetail',
					type: 'post',
					data: {
						'userId': userId,
						'type': mType,
						'dataFrom': dataFrom,
						'dataTo': dataTo,
						'userName': name
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
			}
	    };
	}();

	var Index = function(){
		return {
			initCharts: function () {
				var data = <?php echo $dataChart ?>;
				var chart = AmCharts.makeChart("chartCustomers", {
		            "type": "serial",
				    "theme": "light",
					"categoryField": "Name",
					"rotate": true,
					"startDuration": 1,
					"legend": {
		                "useGraphSettings": true,
		                "markerSize": 12,
		                "valueWidth": 0,
		                "verticalGap": 0
		            },
					"categoryAxis": {
						"gridPosition": "start",
						"position": "left"
					},
					"trendLines": [],
					"graphs": [
						{
							"valueAxis": "v1",
							"balloonText": "Total Prices: $[[Price]]",
							"fillAlphas": 0.8,
							"id": "AmGraph-1",
							"lineAlpha": 0.2,
							"title": "Total Prices",
							"type": "column",
							"valueField": "Price"
						},
						{
							"valueAxis": "v2",
							"balloonText": "Total Orders: [[Order]]",
							"fillAlphas": 0.8,
							"id": "AmGraph-2",
							"lineAlpha": 0.2,
							"title": "Total Orders",
							"type": "column",
							"valueField": "Order"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "v1",
							"position": "bottom",
							"axisAlpha": 0,
							"labelFunction" : function(valueText, date, valueAxis){
								return "$" + valueText.toFixed(2);
							}
						},
						{
							"id": "v2",
							"position": "top",
							"axisAlpha": 0
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [],
					"dataProvider": data
		        });

		        $('#chartCustomers').closest('.portlet').find('.fullscreen').click(function() {
		            chart.invalidateSize();
		        });
			}
		}
	}();

    $(document).ready(function() {
    	Index.initCharts();
    	listCustomers.init();

    	$('#slt_store_active').change(function(event) {
            Kiosk.blockUI();
            var storeId = $(this).val();
            window.location.href = '<?php echo url::base() ?>reports/setStore/'+storeId+'/4';
        });
    });
</script>