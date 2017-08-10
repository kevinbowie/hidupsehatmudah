<?php 
if (isset($_GET['month']) && isset($_GET['year'])){
    $bln = $_GET['month'];
    $thn = $_GET['year'];
}
else{
    $bln = date("m");
    $thn = date("Y");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/highcharts.js"></script>
	<script src="bootstrap/js/exporting.js"></script>
    <style type="text/css">
        body{
          background: url("images/bg green.jpg") no-repeat center;
          background-size: cover;
        }
    </style>
</head>
@include ('navbar/navbar_2')
<body>
<div class="container">
	<div class="row">
        <div class="col-lg-12">
            <form method="get" onSubmit="return validateForm()" action="<?php route('goals'); ?>">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <label>Tahun</label>
                            <div class="form-group">
                                <input type="text" name="year" value="<?php echo $thn; ?>" class="form-control input-small">
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>Bulan</label>
                            <div class="form-group">
                                <input type="text" name="month" value="<?php echo $bln; ?>" class="form-control input-small">
                            </div>
                        </div>  
                        <div style="margin-top: 25px;"><button class="btn btn-primary" id="submit" type="submit">Refresh</button></div>
                    </div>  
                </div>
            </form>
        </div>
		<div class="col-lg-6">
			<div id="calories"></div><br>
			<div id="protein"></div><br>
            <div id="fat"></div><br>
            <div id="carbo"></div><br>
		</div>
		<div class="col-lg-6">
			<div id="exercise"></div><br>
			<div id="drink"></div><br>
			<div id="sleep"></div><br>
            <div id="bb"></div><br>
		</div>
	</div>
</div>

</body>
</html>
<script type="text/javascript">
var month = "<?php echo $bulan; ?>";
function validateForm(){
    flag = false;
    if ($('input[name="year"]').val().length != 4)
        alert('Format Tahun Tidak Tepat !');
    else if (! ($('input[name="month"]').val() > 0 && $('input[name="month"]').val() < 13))
        alert('Format Bulan Tidak Tepat !');
    else 
        flag = true;
    return flag;
};

$(document).ready(function() {
    var title = {
        text: 'Konsumsi Air Minum ' + month + ' 2017'
    };

    var subtitle = {
        //text: 'Source: WorldClimate.com'
    };

    var xAxis = {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
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
        valueSuffix: 'Liter'
    };

    var legend = {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    };

    var series =  [
        {
            name: 'Minum',
            data:   [<?php 
                foreach($data as $values){
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
        text: 'Jam Tidur ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Jam'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Jam'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Tidur',
            data:   [<?php 
                foreach($data as $values){
                    echo $values->sleep; ?> , <?php
                }        
            ?>]
        }
    ]
});

Highcharts.chart('exercise', {
    title : {
        text: 'Durasi Olahraga ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Jam'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Jam'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Olahraga',
            data:   [<?php 
                foreach($data as $values){
                    echo $values->exercise; ?> , <?php
                }        
            ?>]
        }
    ]
});

Highcharts.chart('calories', {
    title : {
        text: 'Konsumsi Kalori ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Kalori'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Kalori'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Konsumsi',
            data: [<?php 
                foreach($data as $values){
                    echo $values->calories; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            data: [<?php 
                foreach($data as $values){
                    echo $values->calories_goal; ?>, <?php
                }
            ?>]
        }
    ]
});

Highcharts.chart('protein', {
    title : {
        text: 'Konsumsi Protein ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Kalori'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Kalori'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Konsumsi',
            data: [<?php 
                foreach($data as $values){
                    echo $values->protein; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            data: [<?php 
                foreach($data as $values){
                    echo $values->protein_goal; ?>, <?php
                }
            ?>]
        }
    ]
});

Highcharts.chart('fat', {
    title : {
        text: 'Konsumsi Lemak ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Kalori'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Kalori'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Konsumsi',
            data: [<?php 
                foreach($data as $values){
                    echo $values->fat; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            data: [<?php 
                foreach($data as $values){
                    echo $values->fat_goal; ?>, <?php
                }
            ?>]
        }
    ]
});

Highcharts.chart('carbo', {
    title : {
        text: 'Konsumsi Karbohidrat ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'Kalori'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'Kalori'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Konsumsi',
            data: [<?php 
                foreach($data as $values){
                    echo $values->carbohydrate; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            data: [<?php 
                foreach($data as $values){
                    echo $values->carbohydrate_goal; ?>, <?php
                }
            ?>]
        }
    ]
});

Highcharts.chart('bb', {
    title : {
        text: 'Berat Badan ' + month + ' 2017'   
    },

    subtitle : {
        //text: 'Source: WorldClimate.com'
    },

    xAxis : {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    },

    yAxis : {
        title: {
            text: 'KG'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip : {
        valueSuffix: 'KG'
    },

    legend : {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },

    series :  [
        {
            name: 'Berat Badan',
            data: [<?php 
                foreach($data as $values){
                    echo $values->weight; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            data: [<?php 
                foreach($data as $values){
                    echo $values->weight_goal; ?>, <?php
                }
            ?>]
        }
    ]
});
</script>