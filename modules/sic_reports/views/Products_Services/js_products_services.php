<script>
	var ProductServices = function() {
		var tbproductservice;

		var loadProduct = function (){
			$("#tb-product-service").DataTable({
				'info' : false,
				"ordering": false,
				"scrollX": true,
				"scrollY": '320px',
				"paging": false
			});
		}
				
		return {
	        init: function () {
	            loadProduct();
	            ProductServices.initAmChartsPie();
	        },
	        get: function(){
				return tbproductservice;
			},
			initAmChartsPie: function(){
                $('#site_activities_loading_pie').show();
                var data = <?php echo $productChart ?>;
                AmCharts.addInitHandler(function(chart) {
  
                    // check if data is mepty
                    if (chart.dataProvider === undefined || chart.dataProvider.length === 0) {
                        // add some bogus data
                        var dp = {};
                        dp[chart.titleField] = "No data";
                        dp[chart.valueField] = 1;
                        chart.dataProvider.push(dp)
                        // disable slice labels
                        chart.labelsEnabled = false;
                        // add label to let users know the chart is empty
                        chart.addLabel("50%", "50%", "The chart contains no data", "middle", 15);
                        // dim the whole chart
                        chart.alpha = 0.3;
                    }
              
                }, ["pie"]);
                var chart = AmCharts.makeChart("pie_chart", {
                    "type": "pie",
                    "startDuration": 0,
                    "theme": "light",
                    "addClassNames": true,
                    "legend":{
                        "position":"bottom",
                        "marginRight":0,
                        "autoMargins":true
                    },
                    "innerRadius": "30%",
                    "defs": {
                        "filter": [{
                            "id": "shadow",
                            "width": "200%",
                            "height": "200%",
                            "feOffset": {
                                "result": "offOut",
                                "in": "SourceAlpha",
                                "dx": 0,
                                "dy": 0
                            },
                            "feGaussianBlur": {
                                "result": "blurOut",
                                "in": "offOut",
                                "stdDeviation": 5
                            },
                            "feBlend": {
                                "in": "SourceGraphic",
                                "in2": "blurOut",
                                "mode": "normal"
                            }
                        }]
                    },
                    "dataProvider": data,
                    "valueField": "data",
                    "titleField": "label",
                });

                chart.addListener("init", handleInit);

                chart.addListener("rollOverSlice", function(e) {
                  handleRollOver(e);
                });

                function handleInit(){
                  chart.legend.addListener("rollOverItem", handleRollOver);
                }

                function handleRollOver(e){
                  var wedge = e.dataItem.wedge.node;
                  wedge.parentNode.appendChild(wedge);
                }
                $('#site_activities_loading_pie').hide();
            },
	    };
	}();
	
	$(document).ready(function() {		
		ProductServices.init();

		$('#slt_store_active').change(function(event) {
            Kiosk.blockUI();
            var storeId = $(this).val();
            window.location.href = '<?php echo url::base() ?>reports/setStore/'+storeId+'/3';
        });
	});

</script>