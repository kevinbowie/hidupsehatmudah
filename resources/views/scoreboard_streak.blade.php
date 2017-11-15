<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="../../../bootstrap/css/calendar.css">
	<script src="../../../bootstrap/js/jquery.js"></script>
	<style type="text/css">
		.table{
			background: #eee;
		}
		.table th{
			text-align: center;
		}
		.btn-twitter {
			padding-left: 30px;
			background: rgba(0, 0, 0, 0) -20px 6px no-repeat;
			background-position: -20px 11px !important;
		}
		.btn-twitter:hover {
			background-position:  -20px -18px !important;
		}
		.form-control{
			width: 200px;
		}
		body{
		    background: url("../../../images/bg green.jpg") no-repeat center;
		   	background-size: cover;
		}
	</style>
</head>

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
	<script src="../../../bootstrap/js/jquery.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../bootstrap/js/highcharts.js"></script>
	<script src="../../../bootstrap/js/exporting.js"></script>
</head>
@include ('navbar/navbar_2')
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-9">
            <form method="get" action="<?php route('goals'); ?>">
                <!-- <div class="col-sm-6"> -->
                	<div class="col-sm-3 form-group">
						<label for="category">Kategori</label>
						<select class="form-control" name="category" id="category">
							<option value="All">Semua</option>
							<option value="Breakfast">Sarapan</option>
							<option value="Lunch">Makan Siang</option>
							<option value="Dinner">Makan Malam</option>
							<option value="Exercise">Olahraga</option>
							<option value="Sleep">Tidur</option>
							<option value="Drink">Minum</option>
						</select>
					</div>
					<div class="col-sm-3 form-group">
						<label for="mode">Mode</label>
						<select class="form-control" name="mode" id="mode" style="width: 150px;">
							<option value="1">Tabel</option>
							<option value="2">Grafik</option>
						</select>
					</div>
                    <div class="col-sm-3 form-group">
                        <label>Tahun</label>
                        <div class="form-group">
                            <input type="text" name="year" id="year" value="<?php echo $thn; ?>" class="form-control input-small" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label>Bulan</label>
                        <div class="form-group">
                            <input type="text" name="month" id="month" value="<?php echo $bln; ?>" class="form-control input-small" readonly>
                        </div>
                    </div>  
                    <div class="col-sm-3" style="margin-bottom: 10px;">
	                    <button class="btn btn-primary" id="btnCategory" type="submit">Refresh</button>
                    </div>  
                <!-- </div> -->
            </form>
        </div>
        <div id="test"></div><br>
		<h3 style="text-align: center;"><?php echo "Streak $category Bulan $bln Tahun $thn"; ?> </h3>
		<div id="chart"></div>
		<div id="showall"></div>
		<br>
	</div>
</div>
</body>
</html>

<script type="text/javascript">
var title;
var chart = $('#chart');

Highcharts.chart('test', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Streak Terakhir dan Tertinggi'
    },
    xAxis: {
        categories: ['Terakhir', 'Tertinggi']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total streak'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [ <?php
    	$last = count($data);
    	foreach($data as $value){
    		echo "{
    			name: '" . $value->user_fullname . "',
    			data: [" . $value->now_streak . ", " . $value->best_streak . "]
    			}";
    		$last--;
    		if ($last != 0)
    			echo ",";
    	} ?>
    ]
});

<?php
for ($x=0;$x<$countUser;$x++){ ?>
	title = "chart" + <?php echo $x; ?>;
	chart.append("<div id='"+title+"'></div><br>");
	Highcharts.chart(title, {
	    title : {
	        text: '<?php echo $user[$x]->first_name . " " . $user[$x]->last_name; ?>'
	    },

	    subtitle : {
	        //text: 'Source: WorldClimate.com'
	    },

	    xAxis : {
	        title: {
	            text: 'Tanggal'
	        },
	        categories: [ <?php
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
	            text: 'Streak'
	        },
	        plotLines: [{
	            value: 0,
	            width: 1,
	            color: '#808080'
	        }]
	    },

	    tooltip : {
	        valueSuffix: 'Streak'
	    },

	    legend : {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle',
	        borderWidth: 0
	    },

	    series :  [
	        {
	            name: 'Streak',
	            data: [<?php 
	            	$data = array();
	            	$j = 0;
	            	for($j;$j<count($userDtl[$x]);$j++){
	            		$data[$j]['date'] = $userDtl[$x][$j]->date;
	            		$data[$j]['streak'] = $userDtl[$x][$j]->streak;
	            	}
		            if (count($data) == 0){
		            	$data[0]['date'] = 1;
		            	$data[0]['streak'] = 0;
		            }
		            $j = 0;
		            for($i=1;$i<=$lastDate;$i++){
		            	if ($i == $data[$j]['date']){
		            		echo $data[$j]['streak'];
		            		if ($j != count($data)-1)
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
<?php
} ?>
</script>


<script type="text/javascript">
	$('#mode').on('change', function(){
		if($(this).val() != 1){
			$('#year').prop('readonly', false);
			$('#month').prop('readonly', false);
		}
		else{
			$('#year').prop('readonly', true);
			$('#month').prop('readonly', true);	
		}
	});

	$('#btnCategory').on('click', function(){
		if ($('#mode').val() > 1){
			if ($('#category').val() == 'All'){
				alert('Untuk Mode Grafik Hanya Boleh Memilih Salah Satu Kategori');
				return false;
			}
		}
	});
</script>