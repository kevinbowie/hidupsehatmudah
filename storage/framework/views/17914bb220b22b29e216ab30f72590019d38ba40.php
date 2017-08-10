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
		    background: url("images/bg green.jpg") no-repeat center;
		    background-size: cover;
		}
	</style>
	<script type="text/javascript">
	$(function(ready){
		/*$('#btnCategory').click(function(){
			var value = $('#category').val();
			$('form').attr('action', '../scoreboard/' + value.toLowerCase());
		});*/
	});
	</script>
</head>
<body>
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
	<div class="row">
		<!-- <div class="col-md-7"> -->
			<form method="GET" action="<?php route('scoreboard'); ?>">
				<label for="category">Kategori</label>
				<select class="form-control" name="category" id="category">
					<option value="All" selected>Semua</option>
					<option value="Breakfast">Sarapan</option>
					<option value="Lunch">Makan Siang</option>
					<option value="Dinner">Makan Malam</option>
					<option value="Exercise">Olahraga</option>
					<option value="Sleep">Tidur</option>
					<option value="Drink">Minum</option>
				</select>
				<br>
				<button class="btn btn-primary" type="submit" id="btnCategory">Tampilkan</button>
			</form>
		<?php 
		$i = 1; $lastCategory = ""; $nowCategory = ""; $len = count($data); $exists = false; $reload = true; 
		?>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php
			$nowCategory = $datas->cat_id;
			if ($lastCategory != $nowCategory){
				if ($i > 1)
					echo "</tbody></table>";
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
      			echo "</tbody></table><br>";
      		} ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<!-- </div> -->
		<!-- <div class="col-lg-5">
			<div class="page-header">
				<div class="pull-right form-inline">
					<div class="btn-group">
						<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
						<button class="btn" data-calendar-nav="today">Today</button>
						<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
					</div>
					<div class="btn-group">
						<button class="btn btn-warning" data-calendar-view="year">Year</button>
						<button class="btn btn-warning active" data-calendar-view="month">Month</button>
					</div>
				</div>
				<h3></h3>
			</div>
			<div class="span6"><div id="calendar"></div></div>
		</div> -->
		<!-- </div> -->
		</div>
	</div>
	<script type="text/javascript" src="../bootstrap/js/underscore-min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/calendar.js"></script>
	<script type="text/javascript" src="../bootstrap/js/app.js"></script>
</div>
</body>
</html>
