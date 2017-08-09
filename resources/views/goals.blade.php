<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/highcharts.js"></script>
	<script src="bootstrap/js/exporting.js"></script>

</head>
@include ('navbar/navbar_2')
<body>
<div id="container">
	<div class="row">
		<!-- <div class="col-lg-6">
			<div id="breakfast"></div>
			<div id="lunch"></div>
			<div id="dinner"></div>
		</div> -->
		<div class="col-lg-6">
			<div id="exercise"></div>
			<div id="drink"></div>
			<div id="sleep"></div>	
		</div>
	</div>
</div>

</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
    var title = {
        text: 'Konsumsi Air Minum Agustus 2017'   
    };

    var subtitle = {
        //text: 'Source: WorldClimate.com'
    };

    var xAxis = {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($drink as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    };

    var yAxis = {
        title: {
            text: 'Liter'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    };   

    var tooltip = {
        valueSuffix: '\xB0C'
    };

    var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    };

    var series =  [
        {
            name: 'Liter',
            data:   [<?php 
                foreach($drink as $values){
                    echo $values->drink; ?> , <?php
                }        
            ?>]
        }
    ];

    var json = {};

    json.title = title;
    json.subtitle = subtitle;
    json.xAxis = xAxis;
    json.yAxis = yAxis;
    json.tooltip = tooltip;
    json.legend = legend;
    json.series = series;

    $('#drink').highcharts(json);
});

Highcharts.chart('sleep', {
    title : {
        text: 'Jam Tidur Agustus 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($drink as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Liter'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: '\xB0C'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Jam',
            data:   [<?php 
                foreach($drink as $values){
                    echo $values->sleep; ?> , <?php
                }        
            ?>]
        }
    ]
});


Highcharts.chart('breakfast', {

    title: {
        text: 'Kesehatan Berdasarkan Sarapan, 2010-2017'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            pointStart: 2010
        }
    },

    series: [{
        name: 'Realisasi',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: 'Target',
        data: [100000, 100000, 100000, 100000, 100000, 100000, 100000, 100000]
    }]

});

Highcharts.chart('lunch', {

    title: {
        text: 'Kesehatan Berdasarkan Sarapan, 2010-2017'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            pointStart: 2010
        }
    },

    series: [{
        name: 'Realisasi',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: 'Target',
        data: [100000, 100000, 100000, 100000, 100000, 100000, 100000, 100000]
    }]

});

Highcharts.chart('dinner', {

    title: {
        text: 'Kesehatan Berdasarkan Sarapan, 2010-2017'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            pointStart: 2010
        }
    },

    series: [{
        name: 'Realisasi',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: 'Target',
        data: [100000, 100000, 100000, 100000, 100000, 100000, 100000, 100000]
    }]

});

Highcharts.chart('exercise', {

    title: {
        text: 'Kesehatan Berdasarkan Sarapan, 2010-2017'
    },

    subtitle: {
        text: 'Source: thesolarfoundation.com'
    },

    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            pointStart: 2010
        }
    },

    series: [{
        name: 'Realisasi',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: 'Target',
        data: [100000, 100000, 100000, 100000, 100000, 100000, 100000, 100000]
    }]

});
</script>