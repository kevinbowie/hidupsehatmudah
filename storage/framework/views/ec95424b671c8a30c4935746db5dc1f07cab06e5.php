<?php 
if (isset($_GET['month']) && isset($_GET['year'])){
    $bln = $_GET['month'];
    $thn = $_GET['year'];
}
else{
    $bln = date("m");
    $thn = date("Y");
}
$lastDate = date('t');
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
        .border{
             border-style: solid; 
             border-color: blue;
        }
    </style>
</head>
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
            <div class="border">
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
                if ($i == 0)
                    $i = 1;

                $get = $get/$i;
                $goal = $goal/$i;
                if ($goal != 0)
                    $persen = $get/$goal * 100;
                else
                    $persen = 100;
                $get = number_format((float)$get, 2, '.', '');
                $goal = number_format((float)$goal, 2, '.', '');
                $persen = number_format((float)$persen, 2, '.', '');
                if ($goal - $get >= 300)
                    $msg = "<div class='alert alert-warning text-center'>Kebutuhan Kalori Anda Rata-Rata Kurang Terpenuhi";
                else if ($goal - $get >= -300)
                    $msg = "<div class='alert alert-danger text-center'>Kebutuhan Kalori Anda Rata-Rata Berlebihan";
                else
                    $msg = "<div class='alert alert-success text-center'>Kebutuhan Kalori Anda Rata-Rata Terpenuhi";
                $msg .= " ($persen %) <br>
                        Konsumsi Kalori Anda Rata-Rata $get Kal
                        <br>
                        Kebutuhan Kalori Harian Anda Rata-Rata $goal Kal</div>";
                echo $msg;
                ?>
            </div>
            <br>
            <div class="border">
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
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $goal = $goal/$i;
                    if ($goal != 0)
                        $persen = $get/$goal * 100;
                    else
                        $persen = 100;
                    $get = number_format((float)$get, 2, '.', '');
                    $goal = number_format((float)$goal, 2, '.', '');
                    $persen = number_format((float)$persen, 2, '.', '');
                    if ($goal - $get >= 150)
                        $msg = "<div class='alert alert-warning text-center'>Kebutuhan Protein Anda Rata-Rata Kurang Terpenuhi";
                    else if ($goal - $get >= -200)
                        $msg = "<div class='alert alert-danger text-center'>Kebutuhan Protein Anda Rata-Rata Berlebihan";
                    else
                        $msg = "<div class='alert alert-success text-center'>Kebutuhan Protein Anda Rata-Rata Terpenuhi";
                    $msg .= " ($persen %) <br>
                            Konsumsi Protein Anda Rata-Rata $get Kal
                            <br>
                            Kebutuhan Protein Harian Anda Rata-Rata $goal Kal</div>";
                    echo $msg;
                    ?>
            </div>
            <br>
            <div class="border">
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
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $goal = $goal/$i;
                    if ($goal != 0)
                        $persen = $get/$goal * 100;
                    else
                        $persen = 100;
                    $get = number_format((float)$get, 2, '.', '');
                    $goal = number_format((float)$goal, 2, '.', '');
                    $persen = number_format((float)$persen, 2, '.', '');
                    if ($goal - $get >= 150)
                        $msg = "<div class='alert alert-warning text-center'>Kebutuhan Lemak Anda Rata-Rata Kurang Terpenuhi";
                    else if ($goal - $get >= -100)
                        $msg = "<div class='alert alert-danger text-center'>Kebutuhan Lemak Anda Rata-Rata Berlebihan";
                    else
                        $msg = "<div class='alert alert-success text-center'>Kebutuhan Lemak Anda Rata-Rata Terpenuhi";
                    $msg .= " ($persen %) <br>
                            Konsumsi Lemak Anda Rata-Rata $get Kal
                            <br>
                            Kebutuhan Lemak Harian Anda Rata-Rata $goal Kal</div>";
                    echo $msg;
                    ?>
            </div>
            <br>
            <div class="border">
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
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $goal = $goal/$i;
                    if ($goal != 0)
                        $persen = $get/$goal * 100;
                    else
                        $persen = 100;
                    $get = number_format((float)$get, 2, '.', '');
                    $goal = number_format((float)$goal, 2, '.', '');
                    $persen = number_format((float)$persen, 2, '.', '');
                    if ($goal - $get >= 150)
                        $msg = "<div class='alert alert-warning text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Kurang Terpenuhi";
                    else if ($goal - $get >= -100)
                        $msg = "<div class='alert alert-danger text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Berlebihan";
                    else
                        $msg = "<div class='alert alert-success text-center'>Kebutuhan Karbohidrat Anda Rata-Rata Terpenuhi";
                    $msg .= " ($persen %) <br>
                            Konsumsi Karbohidrat Anda Rata-Rata $get Kal
                            <br>
                            Kebutuhan Karbohidrat Harian Anda Rata-Rata $goal Kal</div>";
                    echo $msg;
                    ?>
            </div>
            <br>
		</div>
		<div class="col-lg-6">
            <div class="border">
    			<div id="exercise"></div><br>
                    <?php 
                    $i = 0;
                    $get = 0;
                    $goal = 0;
                    foreach($data as $values){
                        $i++;
                        $get += $values->exercise;
                    }
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $get = number_format((float)$get, 2, '.', '');
                    if ($get < 0.5)
                        $msg = "<div class='alert alert-warning text-center'>Kegiatan Olahraga Anda Rata-Rata Kurang Terpenuhi dari 0.5 Jam";
                    else
                        $msg = "<div class='alert alert-success text-center'>Kegiatan Olahraga Anda Rata-Rata Terpenuhi dari 0.5 Jam";
                    $msg .= " <br>Anda perlu berolahraga setidaknya 0.5 jam setiap hari<br><br></div>";
                    echo $msg;
                    ?>
            </div>
            <br>
            <div class="border">
    			<div id="drink"></div><br>
                    <?php 
                    $i = 0;
                    $get = 0;
                    $goal = 0;
                    foreach($data as $values){
                        $i++;
                        $get += $values->drink;
                    }
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $get = number_format((float)$get, 2, '.', '');
                    if ($get < 2)
                        $msg = "<div class='alert alert-warning text-center'>Konsumsi Minum Anda Rata-Rata Kurang Terpenuhi dari 2 Liter";
                    else
                        $msg = "<div class='alert alert-success text-center'>Konsumsi Minum Anda Rata-Rata Terpenuhi dari 2 Liter";
                    $msg .= " <br>Anda Perlu Konsumsi Air Minum Setidaknya 2 Liter Setiap Hari<br><br></div>";
                    echo $msg;
                    ?>
            </div>
            <br>
            <div class="border">
    			<div id="sleep"></div><br>
                    <?php 
                    $i = 0;
                    $get = 0;
                    $goal = 0;
                    foreach($data as $values){
                        $i++;
                        $get += $values->sleep;
                    }
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $get = number_format((float)$get, 2, '.', '');
                    if ($get < 6)
                        $msg = "<div class='alert alert-warning text-center'>Kebutuhan Tidur Anda Rata-Rata Kurang Terpenuhi dari 6 Jam";
                    else if ($get > 9)
                        $msg = "<div class='alert alert-danger text-center'>Kebutuhan Tidur Anda Rata-Rata Berlebihan dari 9 Jam";
                    else
                        $msg = "<div class='alert alert-success text-center'>Kebutuhan Tidur Anda Rata-Rata Terpenuhi";
                    $msg .= " <br>Anda Perlu Beristirahat Setidaknya 6 - 9 Jam Setiap Hari<br><br></div>";
                    echo $msg;
                    ?>
            </div>
            <br>
            <div class="border">
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
                    if ($i == 0)
                        $i = 1;
                    $get = $get/$i;
                    $goal = $goal/$i;
                    if ($goal != 0)
                        $persen = $get/$goal * 100;
                    else
                        $persen = 100;
                    $get = number_format((float)$get, 2, '.', '');
                    $goal = number_format((float)$goal, 2, '.', '');
                    if ($goal - $get >= 5)
                        $msg = "<div class='alert alert-warning text-center'>Berat Badan Anda Rata-Rata Kurang Terpenuhi Dibawah 5 Kg";
                    else if ($goal - $get <= -5)
                        $msg = "<div class='alert alert-danger text-center'>Berat Badan Anda Rata-Rata Berlebihan Diatas 5 Kg";
                    else
                        $msg = "<div class='alert alert-success text-center'>Berat Badan Anda Masih Ideal";
                    $msg .= "<br>
                            Berat Badan Anda Saat Ini " . $bb->weight . 
                            " Kg <br>
                            Berat Badan Ideal Anda " . $bb->bb_ideal . " Kg</div>";
                    echo $msg;
                    ?>
            </div>
            <br>
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->drink;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->sleep;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->exercise;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->exercise_cal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->calories;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->calories_goal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->protein;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->protein_goal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->fat;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->fat_goal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->carbohydrate;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->carbohydrate_goal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
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
            for($i=1;$i<=$lastDate;$i++){
                if ($i != $lastDate){
                    echo $i . ', ';
                }
                else{
                    echo $i;
                }
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
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->weight;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        },
        {
            name: 'Target',
            pointPlacement: 0,
            data: [<?php 
                $datas = array();
                $j = 0;
                foreach($data as $values){
                    $datas[$j]['date'] = $values->date;
                    $datas[$j]['value'] = $values->weight_goal;
                    $j++;
                }
                if (count($data) == 0){
                    $datas[0]['date'] = 1;
                    $datas[0]['value'] = 0;
                }
                $j = 0;
        
                for($i=1;$i<=$lastDate;$i++){
                    if ($i == $datas[$j]['date']){
                        echo $datas[$j]['value'];
                        if ($j != count($datas)-1)
                            $j++;
                    }
                    else
                        echo "0";
                    if ($i != $lastDate)
                        echo ", ";
                }   
            ?>]
        }
    ]
});
</script>