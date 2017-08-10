<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<script src="../../../bootstrap/js/jquery.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">
	.right{
		float: right;
	}
	body{
		background: url("../../../images/bg1.jpg") no-repeat center;
	    background-size: cover;
	}
	</style>

</head>
<body>
@if (Auth::user()->access_id == 1)
	@include('navbar/navbar_adm')
@else
	@include('navbar/navbar_2')
@endif
@include('dbconfig')
<div class="container">
	@if (Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('failed'))
		<div class="alert alert-danger">{{ Session::get('failed') }}</div>
	@endif
	<div class="row">
		<div class="page-header">
		  	<div class="pull-left"><h2>{{ $title }}</h2></div>
			<div class="clearfix"></div>
		</div> <?php
	if (count($data) > 0){ ?>
	<div class="panel-group"> 
	@foreach ($data as $datas) <?php
	echo "<div class='panel panel-default'>
			<div class='panel-heading'>
				<h4 class='panel-title'>"; ?>
					@if (Auth::user()->access_id == 1)
						<h4 style='float:left;'><?php echo $datas->title; ?></h4>
						<div style="float:right;" style="margin-right: 30px;"><a href='#add-unit-modal' data-toggle='modal' data-id='<?php echo $datas->id; ?>' data-title='<?php echo $datas->title; ?>'>Tambah Satuan</a></div>
						<div class="clearfix"></div>
					@else
						<h4><?php echo $datas->title; ?></h4>
					@endif <?php
			echo "</h4>
			</div>
			<div class='panel-collapse collapse in'>
				<div class='panel-body'>" . $datas->information . "</div>
			</div>
			<div class='panel-footer'>
				<div class='row'>";
			if ($jenis == 'food'){
				getDetails($datas->id, $datas->carbohydrate, $datas->protein, $datas->fat, $datas->bdd);
			}
			else{
				echo "<div class='col-sm-3'>
					<ul style='list-style-type:none;'>
						<li>30 Menit</li>
						<li>1 Jam</li>
					</ul></div>
					<div class='col-sm-3'>
					<ul style='list-style-type:none;'>
						<li>" . round($datas->carbohydrate / 2) . " Kalori</li>
						<li>" . $datas->carbohydrate . " Kalori</li>
					</ul></div>";
			}
	echo "</div></div></div><br>"; ?>
	@endforeach <?php
	}
	else{
		echo "<h1>Tidak Ada Data</h1>";
	} ?>
	</div>
</div>

<div id="add-unit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="{{ route('calories/addSatuan', ['jenis'=>$jenis,'title'=>$title, 'id'=>$id]) }}">
	  	<div class="modal-body">
			<div class="container">
				<div class="modal-dialog">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">TAMBAH SATUAN</h2></div>
							<input type="hidden" name="jenis" value="">
							<input type="hidden" name="idJudul" value="">
							<div class="form-group" id="judul" style="width: 200px;">
								<label for="judul">Judul</label>
								<input type="text" name="judul" value="" class="form-control input-small" readonly>
							</div>
							<?php if ($jenis == 'food'){ ?>
							<div class="row">
								<div class="form-group col-sm-3" id="gram">
									<label for="gram">Gram</label>
									<input type="text" name="gram" value="" class="form-control input-small">
								</div>
								<div class="form-group col-sm-3" id="portion">
									<label for="portion">Porsi</label>
									<input type="text" name="portion" value="" class="form-control input-small">
								</div>
								<div class="form-group col-sm-3" id="satuan">
							  		<label for="Satuan">Satuan</label>
							  		<select class="form-control" name="satuan">
									</select>
								</div>
							</div>
							<?php }
							else{ ?>
							<div class="row">
								<div class="form-group col-sm-3" id="portion">
									<label for="portion">Porsi</label>
									<input type="text" name="portion" value="" class="form-control input-small">
								</div>
								<div class="form-group col-sm-3" id="satuan">
							  		<label for="Satuan">Satuan</label>
							  		<select class="form-control" name="satuan">
									</select>
								</div>
							</div>
							<?php } ?>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
							<button class="btn btn-primary" id="add" type="submit">Tambah</button>
						</div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>

</body>
</html>

<script type="text/javascript">
$("#add-unit-modal").on('show.bs.modal', function(e){
	var Id = $(e.relatedTarget).data('id');
	var Title = $(e.relatedTarget).data('title');
	$(e.currentTarget).find('input[name="idJudul"]').val(Id);
	$(e.currentTarget).find('input[name="judul"]').val(Title);
	$(e.relatedTarget).find('form').attr('href', <?php route('calories/addSatuan', ['jenis'=>$jenis,'title'=>$title, 'id'=>$id]); ?>);
	if ($(e.currentTarget).find('select[name="satuan"]').children().length == 0)
		$(e.currentTarget).find('select[name="satuan"]').append("<?php getSatuan($jenis); ?>");
});
</script>

<?php
function getSatuan($jenis){
	if ($jenis == 'food'){
		$jenis = 'Makanan';
	}
	else {
		$jenis = 'Latihan';
	}

	$connection = new createConn();
	$ssql = "select id, satuan from satuan where category = '" . $jenis . "' order by satuan;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($data=mysqli_fetch_array($result)){
			echo "<option value='" . $data['id'] . "'>" . $data['satuan'] . "</option>";
		}
	}
} 

function getDetails($id, $carb, $pro, $fat, $bdd){
	$html1 = "";
	$html2 = "";
	$html3 = "";
	$html4 = "";
	$html5 = "";
	$connection = new createConn();
	$ssql = "select b.portion, a.satuan, b.gram from satuan a inner join satuan_dtl b on a.id = b.unit_id
			where b.cal_id = " . $id . " order by a.id;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($data=mysqli_fetch_array($result)){
            $carbCount = round(($bdd / 100) * ($data['gram'] / 100) * $carb * 4);
            $proCount = round(($bdd / 100) * ($data['gram'] / 100) * $pro * 4);
            $fatCount = round(($bdd / 100) * ($data['gram'] / 100) * $fat * 9);
			$calorie = $carbCount + $proCount + $fatCount;
			$html1 = $html1 . "<li>" . $data['portion'] . " " . $data['satuan'] . " (" . $data['gram'] . " gram)</li>";
			$html2 = $html2 . "<li>Pro : " . $proCount . " Kal</li>";
			$html3 = $html3 . "<li>Karb : " . $carbCount . " Kal</li>";
			$html4 = $html4 . "<li>Lem : " . $fatCount . " Kal</li>";
			$html5 = $html5 . "<li>Total : " . $calorie . " Kal</li>";
		}
		echo "<div class='col-sm-3'><ul style='list-style-type:none;'>" . $html1 . "</ul></div>
			<div class='col-sm-2'><ul style='list-style-type:none;'>" . $html2 . "</ul></div>
			<div class='col-sm-2'><ul style='list-style-type:none;'>" . $html3 . "</ul></div>
			<div class='col-sm-2'><ul style='list-style-type:none;'>" . $html4 . "</ul></div>
			<div class='col-sm-3'><ul style='list-style-type:none;'>" . $html5 . "</ul></div>";
	}
	else{
		echo "<div class='col-sm-3'>Tidak Ada Data Satuan</div>";
	}
}
?>