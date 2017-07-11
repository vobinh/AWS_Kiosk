<script type="text/javascript">
	var Index = function () {
	    return {
	        initCharts: function () {
	            if (!jQuery.plot) {
	                return;
	            }

	            function showChartTooltip(x, y, xValue, yValue) {
	                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
	                    position: 'absolute',
	                    display: 'none',
	                    top: y - 40,
	                    left: x - 40,
	                    border: '0px solid #ccc',
	                    padding: '2px 6px',
	                    'background-color': '#fff'
	                }).appendTo("body").fadeIn(200);
	            }

	            var data = [];

	            if ($('#site_activities').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	               	$('#site_activities_loading').hide();
	                $('#site_activities_content').show();

	                $('#site_activities_loading_2').hide();
	                $('#site_activities_content_2').show();

	                $('#site_activities_loading_3').hide();
	                $('#site_activities_content_3').show();
	                var data1 = <?php echo $salesChart ?>;
	                var data2 = <?php echo $transationsChart ?>;
	                var data3 = <?php echo $custommerChart ?>;
	  
	                var plot_statistics = $.plot($("#site_activities"),

	                    [{
	                        data: data1,
	                        lines: {
	                            fill: 0.2,
	                            lineWidth: 0,
	                        },
	                        color: ['#BAD9F5']
	                    }, {
	                        data: data1,
	                        points: {
	                            show: true,
	                            fill: true,
	                            radius: 4,
	                            fillColor: "#9ACAE6",
	                            lineWidth: 2
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 1
	                    }, {
	                        data: data1,
	                        lines: {
	                            show: true,
	                            fill: false,
	                            lineWidth: 3
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 0
	                    }],

	                    {

	                        xaxis: {
	                            tickLength: 0,
	                            tickDecimals: 0,
	                            mode: "categories",
	                            min: 0,
	                            font: {
	                                lineHeight: 18,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            }
	                        },
	                        yaxis: {
	                            ticks: 5,
	                            tickDecimals: 0,
	                            min: 0,
	                            tickColor: "#eee",
	                            font: {
	                                lineHeight: 14,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            },
	                            tickFormatter: function (v) {
									return "$ " + v.toFixed(2);
								}
	                        },
	                        grid: {
	                            hoverable: true,
	                            clickable: true,
	                            tickColor: "#eee",
	                            borderColor: "#eee",
	                            borderWidth: 1
	                        }
	                    });

	                var plot_statistics_2 = $.plot($("#site_activities_2"),

	                    [{
	                        data: data2,
	                        lines: {
	                            fill: 0.2,
	                            lineWidth: 0,
	                        },
	                        color: ['#BAD9F5']
	                    }, {
	                        data: data2,
	                        points: {
	                            show: true,
	                            fill: true,
	                            radius: 4,
	                            fillColor: "#9ACAE6",
	                            lineWidth: 2
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 1
	                    }, {
	                        data: data2,
	                        lines: {
	                            show: true,
	                            fill: false,
	                            lineWidth: 3
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 0
	                    }],

	                    {

	                        xaxis: {
	                            tickLength: 0,
	                            tickDecimals: 0,
	                            mode: "categories",
	                            min: 0,
	                            font: {
	                                lineHeight: 18,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            }
	                        },
	                        yaxis: {
	                            ticks: 5,
	                            tickDecimals: 0,
	                             min: 0,
	                            tickColor: "#eee",
	                            font: {
	                                lineHeight: 14,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            }
	                        },
	                        grid: {
	                            hoverable: true,
	                            clickable: true,
	                            tickColor: "#eee",
	                            borderColor: "#eee",
	                            borderWidth: 1
	                        }
	                    });
	                
	                var plot_statistics_3 = $.plot($("#site_activities_3"),

	                    [{
	                        data: data3,
	                        lines: {
	                            fill: 0.2,
	                            lineWidth: 0,
	                        },
	                        color: ['#BAD9F5']
	                    }, {
	                        data: data3,
	                        points: {
	                            show: true,
	                            fill: true,
	                            radius: 4,
	                            fillColor: "#9ACAE6",
	                            lineWidth: 2
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 1
	                    }, {
	                        data: data3,
	                        lines: {
	                            show: true,
	                            fill: false,
	                            lineWidth: 3
	                        },
	                        color: '#9ACAE6',
	                        shadowSize: 0
	                    }],

	                    {

	                        xaxis: {
	                           tickLength: 0,
	                           tickDecimals: 0,
	                           mode: "categories",
	                            min: 0,
	                            font: {
	                                lineHeight: 18,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            }
	                        },
	                        yaxis: {
	                            ticks: 5,
	                            tickDecimals: 0,
	                            min: 0,
	                            tickColor: "#eee",
	                            font: {
	                                lineHeight: 14,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: "#6F7B8A"
	                            }
	                        },
	                        grid: {
	                            hoverable: true,
	                            clickable: true,
	                            tickColor: "#eee",
	                            borderColor: "#eee",
	                            borderWidth: 1
	                        }
	                    });

	                $(".site_activities").bind("plothover", function (event, pos, item) {
	                    $("#x").text(pos.x.toFixed(2));
	                    $("#y").text(pos.y.toFixed(2));
	                    if (item) {
	                        if (previousPoint2 != item.dataIndex) {
	                            previousPoint2 = item.dataIndex;
	                            $("#tooltip").remove();
	                            var x = item.datapoint[0].toFixed(2),
	                                y = item.datapoint[1].toFixed(2);
	                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1]);
	                        }
	                    }
	                });

	                $('.site_activities').bind("mouseleave", function () {
	                    $("#tooltip").remove();
	                });
	            }
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

				var dataSales = [];
				var data1     = <?php echo $salesChart ?>;
	        	$.each(data1, function(index, val) {
					var _temp      = [];
					_temp['value'] = val[1];
					_temp['date']  = val[0];
	        		dataSales.push(_temp);
	        	});
	        	if ($('#site_activities').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	                $('#site_activities_loading').hide();
	                $('#site_activities_content').show();
		        	var salesChart = AmCharts.makeChart("site_activities",{
						"type": "serial",
						"categoryField": "date",
						"dataDateFormat": dataDateFormat, //HH:NN
						"categoryAxis": {
							"minPeriod": minPeriod,
							"parseDates": true,
							//"labelFunction": function(valueText, date, categoryAxis) {
						      	//return moment(date).format('MM/DD/YYYY');
						    //}
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": categoryBalloonDateFormat
						},
						"trendLines": [],
						"graphs": [
							{
								"bullet": "round",
								"id": "AmGraph-1",
								"title": "graph 1",
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
						"dataProvider": dataSales
					});
					AmCharts.checkEmptyData(salesChart);
		        }

		        var dataTransations = [];
				var data2 = <?php echo $transationsChart ?>;
	        	$.each(data2, function(index, val) {
					var _temp      = [];
					_temp['value'] = val[1];
					_temp['date']  = val[0];
	        		dataTransations.push(_temp);
	        	});

	        	if ($('#site_activities_2').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	                $('#site_activities_loading_2').hide();
	                $('#site_activities_content_2').show();
		        	var salesChart = AmCharts.makeChart("site_activities_2",{
						"type": "serial",
						"categoryField": "date",
						"dataDateFormat": dataDateFormat, //HH:NN
						"categoryAxis": {
							"minPeriod": minPeriod,
							"parseDates": true,
							//"labelFunction": function(valueText, date, categoryAxis) {
						      	//return moment(date).format('MM/DD/YYYY');
						    //}
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": categoryBalloonDateFormat
						},
						"trendLines": [],
						"graphs": [
							{
								"bullet": "round",
								"id": "AmGraph-1",
								"title": "graph 1",
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
						"dataProvider": dataTransations
					});
					AmCharts.checkEmptyData(salesChart);
		        }

		        var dataCustommer = [];
				var data3 = <?php echo $custommerChart ?>;
	        	$.each(data3, function(index, val) {
					var _temp      = [];
					_temp['value'] = val[1];
					_temp['date']  = val[0];
	        		dataCustommer.push(_temp);
	        	});

	        	if ($('#site_activities_3').size() != 0) {
	                //site activities
	                var previousPoint2 = null;
	                $('#site_activities_loading_3').hide();
	                $('#site_activities_content_3').show();
		        	var salesChart = AmCharts.makeChart("site_activities_3",{
						"type": "serial",
						"categoryField": "date",
						"dataDateFormat": dataDateFormat, //HH:NN
						"categoryAxis": {
							"minPeriod": minPeriod,
							"parseDates": true,
							//"labelFunction": function(valueText, date, categoryAxis) {
						      	//return moment(date).format('MM/DD/YYYY');
						    //}
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": categoryBalloonDateFormat
						},
						"trendLines": [],
						"graphs": [
							{
								"bullet": "round",
								"id": "AmGraph-1",
								"title": "graph 1",
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
						"dataProvider": dataCustommer
					});
					AmCharts.checkEmptyData(salesChart);
		        }
	        }
	    };
	}();
	$(document).ready(function() {
		//Index.initCharts();
		Index.initAmCharts();

		$('.cls-filter').click(function(event) {
			var type = $(this).attr('data-value');
			if(type == 'range'){
				$('.cls-range').show();
				$('.cls-filter').removeClass('btn-primary').addClass('default').prop('disabled', false);
				$(this).removeClass('default').addClass('btn-primary').prop('disabled', true);
				$('#txt_hd_type').val(type);
				$('#frm-home').submit();
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
			$('#frm-home').submit();
		});
	});
</script>