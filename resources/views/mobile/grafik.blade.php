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
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
	<script src="../bootstrap/js/jquery.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/highcharts.js"></script>
	<script src="../bootstrap/js/exporting.js"></script>
    <style type="text/css">
        body{
          background: url("images/bg green.jpg") no-repeat center;
          background-size: cover;
        }
    </style>
</head>
<body>
<div class="container">
	<div class="row">
        <div class="col-lg-12">
            <form method="get" onSubmit="return validateForm()" action="<?php route('grafik'); ?>">
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
                        <div class="col-sm-3"><button class="btn btn-primary" id="submit" type="submit">Refresh</button></div>
                    </div>  
                </div>
            </form>
        </div>
		<div class="col-lg-6">
            <div>
			    <div id="calories"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->calories;
                    $goal += $values->calories_goal;
                }
                if ($i == 0){
                    $get = 0;
                    $goal = 0;
                }
                else{
                    $get = $get/$i;
                    $goal = $goal/$i;
                }
                if ($goal - $get >= 300)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Kalori Anda Rata-Rata Kurang Terpenuhi</div>";
                else if ($goal - $get >= -300)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Kalori Anda Rata-Rata Berlebihan</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Kalori Anda Rata-Rata Terpenuhi</div>";
                echo $msg;
                ?>
            </div>
			<div id="protein"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->protein;
                    $goal += $values->protein_goal;
                }
                if ($i == 0){
                    $get = 0;
                    $goal = 0;
                }
                else{
                    $get = $get/$i;
                    $goal = $goal/$i;
                }
                if ($goal - $get >= 150)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Protein Anda Rata-Rata Kurang Terpenuhi</div>";
                else if ($goal - $get >= -200)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Protein Anda Rata-Rata Berlebihan</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Protein Anda Rata-Rata Terpenuhi</div>";
                echo $msg;
                ?>
            <div id="fat"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->fat;
                    $goal += $values->fat_goal;
                }
                if ($i == 0){
                    $get = 0;
                    $goal = 0;
                }
                else{
                    $get = $get/$i;
                    $goal = $goal/$i;
                }
                if ($goal - $get >= 150)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Lemak Anda Rata-Rata Kurang Terpenuhi</div>";
                else if ($goal - $get >= -100)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Lemak Anda Rata-Rata Berlebihan</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Lemak Anda Rata-Rata Terpenuhi</div>";
                echo $msg;
                ?>
            <div id="carbo"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->fat;
                    $goal += $values->fat_goal;
                }
                if ($i == 0){
                    $get = 0;
                    $goal = 0;
                }
                else{
                    $get = $get/$i;
                    $goal = $goal/$i;
                }
                if ($goal - $get >= 150)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Kurang Terpenuhi</div>";
                else if ($goal - $get >= -100)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Berlebihan</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Terpenuhi</div>";
                echo $msg;
                ?>
		</div>
		<div class="col-lg-6">
			<div id="exercise"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->exercise;
                }
                if ($i == 0){
                    $get = 0;
                }
                else{
                    $get = $get/$i;
                }
                if ($get < 0.5)
                    $msg = "<div class='alert alert-warning text-center'>Kegiatan Olahraga Anda Rata-Rata Kurang Terpenuhi dari 0.5 Jam</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kegiatan Olahraga Anda Rata-Rata Terpenuhi dari 0.5 Jam</div>";
                echo $msg;
                ?>
			<div id="drink"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->drink;
                }
                if ($i == 0){
                    $get = 0;
                }
                else{
                    $get = $get/$i;
                }
                if ($get < 2)
                    $msg = "<div class='alert alert-warning text-center'>Konsumsi Minum Anda Rata-Rata Kurang Terpenuhi dari 2 Liter</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Konsumsi Minum Anda Rata-Rata Terpenuhi dari 2 Liter</div>";
                echo $msg;
                ?>
			<div id="sleep"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->sleep;
                }
                if ($i == 0){
                    $get = 0;
                }
                else{
                    $get = $get/$i;
                }
                if ($get < 6)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Tidur Anda Rata-Rata Kurang Terpenuhi dari 6 Jam</div>";
                else if ($get > 9)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Tidur Anda Rata-Rata Berlebihan dari 9 Jam</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Tidur Anda Rata-Rata Terpenuhi</div>";
                echo $msg;
                ?>
            <div id="bb"></div><br>
                <?php 
                $i = 0;
                $get = 0;
                $goal = 0;
                foreach($data as $values){
                    $i++;
                    $get += $values->weight;
                    $goal += $values->weight_goal;
                }
                if ($i == 0){
                    $get = 0;
                    $goal = 0;
                }
                else{
                    $get = $get/$i;
                    $goal = $goal/$i;
                }
                if ($goal - $get >= 5)
                    $msg = "<div class='alert alert-warning text-center'>Berat Badan Anda Rata-Rata Kurang Terpenuhi Dibawah 5 Kg</div>";
                else if ($goal - $get >= -5)
                    $msg = "<div class='alert alert-danger text-center'>Berat Badan Anda Rata-Rata Berlebihan Diatas 5 Kg</div>";
                else
                    $msg = "<div class='alert alert-success text-center'>Berat Badan Anda Masih Ideal</div>";
                echo $msg;
                ?>
		</div>
	</div>
</div>

</body>
</html>
<script type="text/javascript">
var month = "<?php echo $bulan; ?>";
var year = "<?php echo $thn; ?>";
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
        text: 'Konsumsi Air Minum ' + month + ' ' + year
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
        text: 'Jam Tidur ' + month + ' ' + year
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
   
    title: {
        text: 'Olahraga ' + month + ' ' + year
    },
    subtitle: {
        <!-- text: 'Source: WorldClimate.com' -->
    },
    xAxis: [{
        categories: [<?php 
            foreach($data as $values){
                echo $values->date; ?> , <?php
            }        
        ?>]
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}Jam',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        title: {
            text: '',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        opposite: true

    }, { // Secondary yAxis
        gridLineWidth: 0,
        title: {
            text: 'Waktu',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} Jam',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        }

    }, { // Tertiary yAxis
        gridLineWidth: 0,
        title: {
            text: 'Kalori',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        labels: {
            format: '{value} kal',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        align: 'left',
        x: 80,
        verticalAlign: 'top',
        y: 55
    },
    series: [{
        name: 'Waktu',
        type: 'spline',
        yAxis: 1,
        pointPlacement: -0.1,
        data: [<?php
            foreach($data as $values){
                echo $values->exercise; ?>, <?php
            }
        ?>],
        tooltip: {
            valueSuffix: ' Jam'
        }

    }, {
        name: 'Kalori',
        type: 'spline',
        yAxis: 2,
        pointPlacement: 0,
        data: [<?php
            foreach($data as $values){
                echo $values->exercise_cal; ?>, <?php
            }
        ?>],
        tooltip: {
            valueSuffix: ' Kal'
        }
    }]
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
            pointPlacement: -0.1,
            data: [<?php 
                foreach($data as $values){
                    echo $values->calories; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
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
            pointPlacement: -0.1,
            data: [<?php 
                foreach($data as $values){
                    echo $values->protein; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
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
            pointPlacement: -0.1,
            data: [<?php 
                foreach($data as $values){
                    echo $values->fat; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
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
            pointPlacement: -0.1,
            data: [<?php 
                foreach($data as $values){
                    echo $values->carbohydrate; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
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
            pointPlacement: -0.1,
            data: [<?php 
                foreach($data as $values){
                    echo $values->weight; ?> , <?php
                }        
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                foreach($data as $values){
                    echo $values->weight_goal; ?>, <?php
                }
            ?>]
        }
    ]
});
</script>