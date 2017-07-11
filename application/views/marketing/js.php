<script>
var ChartMarketing = function() {
    var InitChart = function() {
        var chart = AmCharts.makeChart("chartmarketing", {
            "type": "serial",
            "theme": "light",
            "pathToImages": Kiosk.getGlobalPluginsPath() + "amcharts/amcharts/images/",
            "autoMargins": false,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "background-color":    '#000',
            "fontFamily": 'Open Sans',            
            "color":    '#000',
            "dataLoader": {
                "url": "<?php echo url::base() ?>marketing/LoadChartMarketing",
                "format": "json"
            },
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left"
            }],
            "startDuration": 1,
            "graphs": [{
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[name]] in [[category]]:<b>[[value]]</b> [[additional]]</span>",
                "dashLengthField": "dashLengthColumn",
                "fillAlphas": 1,
                "title": "Income",
                "type": "column",
                "valueField": "value"
            }],
            "categoryField": "date",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0
            }
        });
    }
    return {
        init: function() {
            InitChart();
        }
    };
}();
$(document).ready(function() {
	ChartMarketing.init();
});
</script>