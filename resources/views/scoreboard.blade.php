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
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="../bootstrap/css/calendar.css">
	<script src="../bootstrap/js/jquery.js"></script>
	<style type="text/css">
		.table{
			background: #eee;
		}
		.table th{
			text-align: center;
		}
		body{
		    background: url("images/bg green.jpg") no-repeat center;
		    background-size: cover;
		}
	</style>
</head>
<body>
@include('navbar/navbar_2')
<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<form method="GET" action="<?php route('scoreboard'); ?>">
                <!-- <div class="col-lg-6"> -->
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
							<option value="2">Grafik Terpisah</option>
							<option value="3">Satu Grafik</option>
						</select>
					</div>
				<!-- </div> --><!-- 
				<div class="col-lg-6">
                    <div class="row"> -->
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
                        </div>  <!-- 
                    </div>  
                </div> -->
				<br>
				<div class="col-sm-3"><button class="btn btn-primary" type="submit" id="btnCategory">Tampilkan</button></div><br><br>
			</form>
		</div>
		<div class="col-lg-12">
			<br>
			<div class='alert alert-info text-center'>Streak digunakan untuk menghitung kedisiplinan pengguna dalam memenuhi hidup sehat secara berturut-turut tanpa henti</div>
		<?php 
		$i = 1; $lastCategory = ""; $nowCategory = ""; $len = count($data); $exists = false; $reload = true; $j = 1;
		?>
		@foreach ($data as $datas) <?php
			$nowCategory = $datas->cat_id;
			if ($lastCategory != $nowCategory){
				if ($i > 1){
					echo "</tbody></table>";
					switch ($j){
						case 1:
						case 2:
						case 3:
							echo "<div class='alert alert-info'>Streak terpenuhi berdasarkan pencapaian kebutuhan energi kalori per porsi tergatung kebutuhan masing-masing</div>";
							break;
						case 4:
							echo "<div class='alert alert-info'>Streak terpenuhi jika olahraga dilakukan minimal 1/2 jam</div>";
							break;
						default:
							echo "<div class='alert alert-info'>Streak terpenuhi jika konsumsi air minum minimal 2 liter</div>";
							break;
					}
					$j++;
				}
				$i = 1;
				$exists = false;
				$reload = true;
			echo "<div class='page-header'><h2>";
				if ($datas->category == 'breakfast')
					echo "Sarapan";
				else if ($datas->category == 'lunch')
					echo "Makan Siang";
				else if ($datas->category == 'dinner')
					echo "Makan Malam";
				else if ($datas->category == 'exercise')
					echo "Olahraga";
				else if ($datas->category == 'drink')
					echo "Minum";
				else
					echo "Tidur";
			echo "</h2></div>
				<table class='table table-bordered' class='someid'>
			   		<thead>
			    		<tr>
				        	<th width='10%'>Nomor</th>
				        	<th width='50%'>Nama</th>
				        	<th width='17%' style='word-wrap: break-word;'>Streak Tertinggi</th>
				        	<th width='17%'>Streak Sekarang</th>
				      	</tr>
			    	</thead>
			    	<tbody>";
		    }
	    	if (! $all){
	    		if ($i > 6 && Auth::user()->id != $datas->user_id && $exists == false){
	    			echo "<tr><td class='text-center'>.....</td>
			      		<td>.....</td>
			      		<td class='text-right'>.....</td>
			      		<td class='text-right'>.....</td>
			      	</tr>";
			      	$exists = true;
			      	$reload = false;
	    		}
	    		else if (Auth::user()->id == $datas->user_id){
			    	echo "<tr class='info'>";
			    	echo "<td class='text-center'>" . $i . "</td>
			      		<td>" . $datas->user_fullname . "</td>
			      		<td class='text-right'>" . $datas->best_streak . "</td>
			      		<td class='text-right'>" . $datas->now_streak . "</td>
			      	</tr>";
			      	$exists = true;
			      	if ($i > 5)
			      		$reload = false;
			    }
			    else if ($reload){
			    	echo "<tr>";
			    	echo "<td class='text-center'>" . $i . "</td>
			      		<td>" . $datas->user_fullname . "</td>
			      		<td class='text-right'>" . $datas->best_streak . "</td>
			      		<td class='text-right'>" . $datas->now_streak . "</td>
			      	</tr>";
			    }
			}
			else{
				if (Auth::user()->id == $datas->user_id)
			    	echo "<tr class='info'>";				   
			    else 
			    	echo "<tr>";

			    	echo "<td class='text-center'>" . $i . "</td>
			      		<td>" . $datas->user_fullname . "</td>
			      		<td class='text-right'>" . $datas->best_streak . "</td>
			      		<td class='text-right'>" . $datas->now_streak . "</td>
			      	</tr>";
			}
		    	
      		$i++;
      		$len -= 1;
      		$lastCategory = $nowCategory; 
      		if ($len == 0){
      			echo "</tbody></table><br><div class='alert alert-info'>Streak terpenuhi jika durasi jam tidur sekitar 6 - 9 jam</div>";
      		} ?>
		@endforeach
		</div>
	</div>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
</div>
</body>
</html>

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