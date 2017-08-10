<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
    <script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
    <style>
		table, th, td {
		    border: 1px solid black;
		    border-collapse: collapse;
		}
		th, td {
		    padding: 15px;
		}
	</style>
</head>
<body>
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('dbconfig', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('add_list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php
$i = 0;
$connection = new createConn();
$connection->connect();
$ssql = "select a.id, c.id as listId, a.category, c.cal_title, c.portion, d.protein, d.fat, d.carbohydrate, d.calorie ";
$ssql = $ssql . "from category a left join to_do_list b on a.id = b.category_id ";
$ssql = $ssql . "left join to_do_list_dtl c on b.id = c.list_id ";
$ssql = $ssql . "left join calories_list_dtl d on c.cal_id = d.id ";
$ssql = $ssql . "order by a.id;";

$result = mysqli_query($connection->myconn, $ssql); ?>
<input type="hidden" name="idKategori" id="idKategori">
<table> 
	<tr>
		<th>Category</th>
		<th>Item</th>
		<th>Protein</th>
		<th>Lipid</th>
		<th>Carbohydrate</th>
		<th>Calories</th>
		<th>Action</th>
	</tr> <?php
	if ($result->num_rows > 0){
		$i = 0;
		$kategori = array();
		while ($data=mysqli_fetch_array($result)){
			if (!in_array($data['category'], $kategori))
				array_push($kategori, $data['category']);
			if  (!is_null($data['cal_title'])){
				$catId[$i] = $data['id']-1;
				$listId[$i] = $data['listId'];
				$title[$i] = $data['cal_title'];
				$protein[$i] = $data['protein'];
				$lipid[$i] = $data['fat'];
				$carbo[$i] = $data['carbohydrate'];
				$calorie[$i] = $data['calorie'];
				$portion[$i] = $data['portion'];
			}
			else{
				$title[$i] = "";
				$catId[$i] = -1;
				$listId[$i] = 0;
				$protein[$i] = 0;
				$lipid[$i] = 0;
				$carbo[$i] = 0;
				$calorie[$i] = 0;	 
				$portion[$i] = 0;
			}
			$i++;
		} ?>

		<script type="text/javascript">
			var j;
			var i = <?php echo $i; ?>;
			var index = 0;
			var id = [<?php echo '"'.implode('","', $catId).'"' ?>];
			var listId = [<?php echo '"'.implode('","', $listId).'"' ?>];
			var kategori = [<?php echo '"'.implode('","', $kategori).'"' ?>];
			var title = [<?php echo '"'.implode('","', $title).'"' ?>];
			var protein = [<?php echo '"' . implode('","', $protein) . '"' ?>];
			var lipid = [<?php echo '"' . implode('","', $protein) . '"' ?>];
			var carbo = [<?php echo '"' . implode('","', $carbo) . '"' ?>];
			var calorie = [<?php echo '"' . implode('","', $calorie) . '"' ?>];
			var portion = [<?php echo '"' . implode('","', $portion) . '"' ?>];
			kategori.forEach(function(entry){
				if(index < 4){
					$("table").append("<tr id='kat" + index + "'><th valign='top'>" + entry + "</th><td><ul style='list-style-type:none'><input type='hidden' name='idList[]'></ul></td><td><ul style='list-style-type:none'></ul></td><td><ul style='list-style-type:none'></ul></td><td><ul style='list-style-type:none'></ul></td><td><ul style='list-style-type:none'></ul></td><td><button class='btn btn-primary add' data-toggle='modal' data-target='#add-list-modal' data-kategori='" + index + "'><i class='glyphicon glyphicon-plus'></i></button> | <button class='btn btn-primary edit' data-toggle='modal' data-target='#edit-list-modal' data-kategori='" + listId[index] + "'><i class='glyphicon glyphicon-edit'></i></button></td></tr>");
					index++;
				}
				else{
					$("table").append("<tr id='kat" + index + "'><th valign='top'>" + entry + "</th><td colspan='3'><input type='text' value='' class='form-control' id='drink'><button class='btn btn-primary edit' data-kategori='0'><i class='glyphicon glyphicon-edit'></i></button></td>");
					index++;
				}
			});

			for(j=0;j<i;j++){
				if (id[j] >= 0 && id[j] < 4){	
					$("table tr#kat" + id[j] + " td:eq(0) ul").append("<li>" + title[j] + "<button class='btn btn-primary edit' data-kategori='" + listId[j] + "'><i class='glyphicon glyphicon-edit'></i></button></li>");
					$("table tr#kat" + id[j] + " td:eq(1) ul").append("<li>" + protein[j] + "</li>");
					$("table tr#kat" + id[j] + " td:eq(2) ul").append("<li>" + lipid[j] + "</li>");
					$("table tr#kat" + id[j] + " td:eq(3) ul").append("<li>" + carbo[j] + "</li>");
					$("table tr#kat" + id[j] + " td:eq(4) ul").append("<li>" + calorie[j] + "</li>");
				}
				else if (id[j] >= 4){
					$("#drink").val(portion[j]);
				}
			}
		</script> <?php
	}
	else{
		echo "data tidak ditemukan";
	} ?>
</table> <?php

mysqli_close($connection->myconn);
?>
</body>
</html>
<script type="text/javascript">
	var url = "<?php echo route('item-ajax.index')?>";
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("button.add").click(function(){
		//alert ($(this).attr('id'));
		$("#add-list-modal").on('show.bs.modal', function(e) {
			var kategori = $(e.relatedTarget).data('kategori');
			$(e.currentTarget).find('input[name="katId"]').val(kategori);
		});
	});

	$("button.edit").click(function(){
	    if (confirm('Are you sure ?')) {
	        var id = $(this).data('kategori');
		    $.ajax({
		        dataType: 'json',
		        type:'delete',
		        url: url + '/' + id,
		    }).done(function(data){
		        alert('berhasil');
		        location.reload();
		    }); 
	    }
	});

	$("button.edit-drink").click(function(){
		$("#drink-modal").on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('kategori');
			var portion = $("#drink").val();
			$(e.currentTarget).find('input[name="katId"]').val(id);
			$(e.currentTarget).find('input[name="portion"]').val(portion);
		});
	});
}); 
</script>
<!-- <script src="/js/item-ajax.js"></script>  -->