<script src="<?php echo url::base() ?>plugins/global/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- Chart code -->
<script type="text/javascript">
    var Index = function () {
        return {
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
            initTransationChart: function(){
                var dataDateFormat            = 'HH:NN';
                var categoryBalloonDateFormat = 'JJ:NN';
                var minPeriod                 = 'mm';

                AmCharts.checkEmptyData = function(chart) {
                    if (0 == chart.dataProvider.length) {
                        chart.valueAxes[0].minimum = 0;
                        chart.valueAxes[0].maximum = 100;
                        var dataPoint = {
                          dummyValue: 0
                        };
                        dataPoint[chart.categoryField] = '';
                        chart.dataProvider = [dataPoint];
                        chart.addLabel(0, '50%', 'The chart contains no data', 'center');
                        chart.chartDiv.style.opacity = 0.5;
                        chart.validateNow();
                    }
                }

                var dataTransations = [];
                var data2 = <?php echo $transationsChart ?>;
                $.each(data2, function(index, val) {
                    var _temp      = [];
                    _temp['value'] = val[1];
                    _temp['date']  = val[0];
                    dataTransations.push(_temp);
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
                        "dataProvider": dataTransations
                    });
                    AmCharts.checkEmptyData(salesChart);
                }
            }
        };
    }();

    $(document).ready(function() {
        Index.initAmChartsPie();
        Index.initTransationChart();
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
            window.location.href = '<?php echo url::base() ?>reports/setStore/'+storeId+'/1';
        });
    });
</script>