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
	</style>

</head>
<body>
@include('dbconfig')
@if (Auth::user()->access_id == 1)
	@include('navbar/navbar_adm')
@else
	@include('navbar/navbar_2')
@endif
<div class="container">
	@if (Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('failed'))
		<div class="alert alert-danger">{{ Session::get('failed') }}</div>
	@endif
	<div class="row">
		<div class="page-header">
		  	<div class="pull-left">
		  	@if ($jenis == 'food')
		  		<h2>Daftar Makanan</h2></div>
		  	@else
		  		<h2>Daftar Olahraga</h2></div>
		  	@endif
			@if (Auth::user()->access_id == 1)
				@include('new_calories')
  				<div class='pull-right' style='margin-top: 30px; margin-right: 15px;'><a href='#new-calories-modal' data-toggle='modal'>
  					@if ($jenis == 'food')
  						Tambah Makanan
  					@else
  						Tambah Olahraga
  					@endif
  				</a> | <a href='#new-unit-modal' data-toggle='modal'>Tambah Satuan</a> | <a href='#new-category-modal' data-toggle='modal'>Tambah Kategori</a></div>
  			@endif
			<div class="clearfix"></div>
	</div>
	<div class="panel-group"> 
	@foreach ($data as $datas) <?php
	echo "<div class='panel panel-default'>
			<div class='panel-heading'>
				<h4 class='panel-title'>
  					<h4>" . $datas->category_list . "</h4>  					
				</h4>
			</div>
			<div class='panel-collapse collapse in'>
				<div class='panel-body'>" . $datas->information . "</div>
			</div>
			<div class='panel-footer text-right'>";
		echo	"<a href='" . route('calories', ['jenis'=>$jenis,'title'=>$datas->category_list, 'categoryId'=>$datas->id]) . "'>Lanjut...</a>
			</div>
		</div>";
		echo "<br>"; ?>
	@endforeach
	</div>
</div>
</body>
</html>

<script type="text/javascript">
function validateForm(){
	var title = $("input[name='title']");
	var category = $("select[name='category']");
	var titledescription = $("input[name='titledescription']");
	var protein = $("input[name='protein']");
	var lipid = $("input[name='lipid']");
	var carbohydrate = $("input[name='carbohydrate']");
	var calorie = $("input[name='calorie']");
	flag = false;
	if (title.val().trim() == "")
		alert('Judul Tidak Boleh Kosong !');
	else if (category.val() == 0)
		alert('Kategori Belum Dipilih !');
	else if (titledescription.val().trim() == "")
		alert('Deskripsi Judul Tidak Boleh Kosong !');
	else if (protein.val().trim() == "")
		alert('Protein Tidak Boleh Kosong !');
	else if (lipid.val().trim() == "")
		alert('Lemak Tidak Boleh Kosong !');
	else if (carbohydrate.val().trim() == "")
		alert('Karbohidrat Tidak Boleh Kosong !');
	else if (calorie.val().trim() == "")
		alert('Kalori Tidak Boleh Kosong !');
	else
		flag = true;
	return flag;
}

function validateForms(){
	var category = $("input[name='category1']");
	var description = $("textarea[name='description']");
	flag = false;
	if (category.val().trim() == "")
		alert('Kategori Tidak Boleh Kosong !');
	else if (description.val().trim() == "")
		alert('Deskripsi Tidak Boleh Kosong !');
	else
		flag = true;
	return flag;
}

function validateFormUnit(){
	var category = $("input[name='categoryList']");
	var satuan = $("input[name='satuan']");
	flag = false;
	if (category.val().trim() == "")
		alert('Kategori Tidak Boleh Kosong !');
	else if (satuan.val().trim() == "")
		alert('Satuan Tidak Boleh Kosong !');
	else
		flag = true;
	return flag;
}

$("#new-calories-modal").on('show.bs.modal', function(e){
	if ($(e.currentTarget).find('select[name="urt"]').children().length == 0)
		$(e.currentTarget).find('select[name="urt"]').append("<?php getSatuan($jenis); ?>");
});

$("#new-category-modal").on('show.bs.modal', function(e){
	var jenis = '<?php echo $jenis; ?>';
	if (jenis == 'food')
		jenis = 'Makanan';
	else
		jenis = 'Latihan';
	$(e.currentTarget).find('input[name="jenis"]').val(jenis);
});

$("#new-unit-modal").on('show.bs.modal', function(e){
	var jenis = '<?php echo $jenis; ?>';
	var kategori = '';
	if (jenis == 'food')
		kategori = 'Makanan';
	else
		kategori = 'Latihan';
	$(e.currentTarget).find('input[name="jenis"]').val(jenis);
	$(e.currentTarget).find('input[name="categoryList"]').val(kategori);
	if ($(e.currentTarget).find('div[id="satuanAda"]').children().length == 2)
		$(e.currentTarget).find('div[id="satuanAda"]').append("<?php satuan($jenis); ?>");
});
</script>

<?php
function satuan($jenis){
	if ($jenis == 'food'){
		$jenis = 'Makanan';
	}
	else {
		$jenis = 'Latihan';
	}

	$connection = new createConn();
	$ssql = "select satuan from satuan where category = '" . $jenis . "' order by satuan;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$record = mysqli_num_rows($result);
		$recordPerCol = ceil($record / 3);
		$i = 1;
		echo "<div class='row'><div class='col-sm-4'><ul style='list-style-type:none;'>";
		while ($data=mysqli_fetch_array($result)){
			echo "<li>-" . $data['satuan'] . "</li>";
			if ($i % $recordPerCol == 0){
				echo "</ul></div><div class='col-sm-4'><ul style='list-style-type:none;'>";
			}
			else if ($i == $record){
				echo "</ul></div></div>";
			}
			$i++;
		}
	}
	else{
		echo "<div>Tidak Ada Data</div>";
	}
	mysqli_close($connection->myconn); 
} 

function getSatuan($jenis){
	if ($jenis == 'food'){
		$jenis = 'Makanan';
	}
	else {
		$jenis = 'Latihan';
	}

	$connection = new createConn();
	$ssql = "select satuan from satuan where category = '" . $jenis . "' order by satuan;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($data=mysqli_fetch_array($result)){
			echo "<option value='" . $data['satuan'] . "'>" . $data['satuan'] . "</option>";
		}
	}
} 
?>