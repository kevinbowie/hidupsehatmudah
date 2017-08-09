<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-timepicker.css">
	<script src="bootstrap/js/bootstrap-timepicker.min.js"></script>

	<style type="text/css">
	.right{
		float: right;
	}
	</style>
</head>
<body>
@include('navbar/navbar_2')
@include('dbconfig')
@include('menu-modal')
<div class="container">
	@if (Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@elseif (Session::has('fail'))
		<div class="alert alert-danger">{{ Session::get('fail') }}</div>
	@endif
	<div class="row">
		<div class="col-lg-6">
			<div class="page-header">
			  	<div class="pull-left"><h2>Your Menu</h2></div>
				<div class="pull-right">
					<button data-toggle='modal' data-target='#new-menu-modal' class="btn text-right">New Menu</button></div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-group" id="yourMenu"> <?php
				$userId = Auth::user()->id;
				$ssql = "select id, user_id, user_fullname, title, description, share from menu 
						where user_id = " . $userId . ";";
				$index = 1;
				$totalCal = 0;
				$totalLip = 0;
				$totalPro = 0;
				$totalCarb = 0;
				$connection = new createConn();
				$connection->connect();
				$result = mysqli_query($connection->myconn, $ssql);
				if ($result->num_rows > 0){
					$total = $result->num_rows;
					while (($data=mysqli_fetch_array($result)) && ($index < 12)){
						if ($index < 11) {
							echo "<div class='panel panel-default'>
									<div class='panel-heading'>
										<h4 class='panel-title'>
						  					<a data-toggle='collapse' data-parent='#yourMenu' href='#yours" . $index . "'><span class='glyphicon glyphicon-plus'></span>" . $data['title'] . "</a>
										</h4>
									</div>
									<div id='yours" . $index . "' class='panel-collapse collapse'>
										<div class='panel-body'>
											<ul>";

											$ssql = "select b.id, b.title, b.information, b.protein, b.fat, b.carbohydrate, 
													b.calorie from menu_dtl a inner join calories_list_dtl b 
													on a.list_id = b.id where a.menu_id = " . $data['id'] . ";";
											$connection->connect();
											$result2 = mysqli_query($connection->myconn, $ssql);
											if ($result2->num_rows > 0){
												while ($data2=mysqli_fetch_array($result2)){
													echo "<li>
														<input name='listId[]' value='" . $data2['id'] . "' type='hidden'>
														<input name='listTit[]' value='" . $data2['title'] . "' type='hidden'>
														<input name='listPro[]' value='" . $data2['protein'] . "' type='hidden'>
														<input name='listLip[]' value='" . $data2['fat'] . "' type='hidden'>
														<input name='listCarb[]' value='" . $data2['carbohydrate'] . "' type='hidden'>
														<input name='listCal[]' value='" . $data2['calorie'] . "' type='hidden'>" . $data2['title'] . "<span style='float:right;'>" . $data2['calorie'] . " | " . $data2['fat'] . " | " . $data2['protein'] . " | " . $data2['carbohydrate'] . "</span></li>";
													$totalCal += $data2['calorie'];
													$totalLip += $data2['fat'];
													$totalPro += $data2['protein'];
													$totalCarb += $data2['carbohydrate'];
												}
											}
										echo "</ul>
										</div>
									</div>
									<div class='panel-footer text-right'>";
										if ($data['share'] == 0)
											echo "<p>Not Shared</p>";
										else 
											echo "<p>Shared</p>";
								echo	"<a class='edit' href='#add-menu-list-modal' data-kategori='" . $data['id'] . "' data-toggle='modal'>ADD</a> | 
										<a class='edit' href='#edit-menu-modal' data-share='" . $data['share'] . "' data-kategori='" . $data['id'] . "' data-toggle='modal'>EDIT</a> | <a class='delete' href='" . route('menu/delete', ['menuId'=>$data['id']]) . "'>DELETE</a>
									</div>
								</div>";
							setTotal($totalCal, $totalLip, $totalPro, $totalCarb);
							$index++;
						}
						else{
							echo "<a href='menu/food/owner'>Read More</a>";
							$index++;
						}
					}
				}
				else{
					echo "<div class='alert alert-danger'>Data Tidak Ada</div>";
				}
				mysqli_close($connection->myconn);
			?>
			</div> 
		</div>
		<div class="col-lg-6">
			<div class="page-header">
				<h2>Menu By Others</h2>
			  	<div class="clearfix"></div>
		  	</div>
			<div class="panel-group" id="othersMenu"> <?php
				$userId = Auth::user()->id;
				$ssql = "select id, user_id, user_fullname, title, description, share from menu 
						where share = 1 and user_id <> " . $userId . ";";
				$index = 1;
				$totalCal = 0;
				$totalLip = 0;
				$totalPro = 0;
				$totalCarb = 0;
				$connection = new createConn();
				$connection->connect();
				$result = mysqli_query($connection->myconn, $ssql);
				if ($result->num_rows > 0){
					while (($data=mysqli_fetch_array($result)) && ($index < 12)){
						if ($index < 11){
							echo "<div class='panel panel-default'>
									<div class='panel-heading'>
										<h4 class='panel-title'>
						  					<a data-toggle='collapse' data-parent='#othersMenu' href='#others" . $index . "'><span class='glyphicon glyphicon-plus'></span>" . $data['title'] . "</a>
										</h4>
									</div>
									<div id='others" . $index . "' class='panel-collapse collapse'>
										<div class='panel-body'>
											<ul>";

											$ssql = "select c.user_fullname, b.id, b.title, b.information, b.protein, b.fat, 
													b.carbohydrate, b.calorie
													from menu_dtl a inner join calories_list_dtl b on a.list_id = b.id 
													inner join menu c on c.id = a.menu_id
													where a.menu_id = " . $data['id'] . ";";
											$connection->connect();
											$result2 = mysqli_query($connection->myconn, $ssql);
											if ($result2->num_rows > 0){
												while ($data2=mysqli_fetch_array($result2)){
													echo "<li>" . 
														$data2['title'] . "<span style='float:right;'>" . $data2['calorie'] . 
														" | " . $data2['fat'] . " | " . $data2['protein'] . " | " . 
														$data2['carbohydrate'] . "</span></li>";
													$totalCal += $data2['calorie'];
													$totalLip += $data2['fat'];
													$totalPro += $data2['protein'];
													$totalCarb += $data2['carbohydrate'];
												}
											}
										echo "</ul>
										</div>
									</div>
									<div class='panel-footer' style='text-align: right;'>
										<p>By : " . $data['user_fullname'] . "</p>
										<a class='add-plan' href='#add-plan-modal' data-toggle='modal' 
											data-kategori='" . $data['id'] . "'>ADD TO PLAN</a>
									</div>
								</div>";
							setTotal($totalCal, $totalLip, $totalPro, $totalCarb);
							$index++;
						}
						else{
							echo "<a href='menu/food/share'>Read More</a>";
							$index++;
						}
					}
				}
				else{
					echo "<div class='alert alert-danger'>Data Tidak Ada</div>";
				}
				mysqli_close($connection->myconn);
			?>
			</div>
		</div>
	</div>
</div>
</body>
</html>

<?php 
function setTotal($totalCal, $totalLip, $totalPro, $totalCarb){ ?>
	<script type="text/javascript">
		var loc = $('.panel-heading').last().find('a');
		var kategori = $('.panel-footer').last().siblings('.panel-heading').find('a').data('kategori');
		loc.append("<span class='right'>Calorie: <?php echo $totalCal; ?> | Lipid: <?php echo $totalLip; ?> | Protein: <?php echo $totalPro; ?> | Carbohydrate: <?php echo $totalCarb; ?></span>");
	</script> <?php
}
?>

<script type="text/javascript">	
$(document).ready(function() {
	$("a.edit").click(function(){
		$("#edit-menu-modal").on('show.bs.modal', function(e){
			$("table#lists tbody").siblings("tr").remove();
			var menuId = $(e.relatedTarget).data('kategori');
			var share = $(e.relatedTarget).data('share');
			var menuName = $(e.relatedTarget).parents('.panel-footer').siblings('.panel-heading').find('a');
			var title, protein, lipid, carbohydrate, calorie;
			var loct = $(e.relatedTarget).parents('.panel-footer').siblings('.panel-collapse').find('li');
			for(i=0;i<loct.length;i++){
				id = loct.eq(i).find('input:eq(0)').val();
				title = loct.eq(i).find('input:eq(1)').val();
				protein = loct.eq(i).find('input:eq(2)').val();
				lipid = loct.eq(i).find('input:eq(3)').val();
				carbohydrate = loct.eq(i).find('input:eq(4)').val();
				calorie = loct.eq(i).find('input:eq(5)').val();
				$("table#lists tbody").after("<tr><td><input type='checkbox' name='calId[]' value='"+id+"' checked></td><td>"+(loct.length-i)+"</td><td>"+title+"</td><td>"+protein+"</td><td>"+lipid+"</td><td>"+carbohydrate+"</td><td>"+calorie+"</td></tr>");
			}
			menuName = menuName.clone().children().remove().end().text();
			$(e.currentTarget).find('input[name="share"]').val(share);
			if (share == 1)
				$(e.currentTarget).find('input[name="share"]').prop('checked', true);
			else
				$(e.currentTarget).find('input[name="share"]').prop('checked', false);
			$(e.currentTarget).find('input[name="menuId"]').val(menuId);
			$(e.currentTarget).find('input[name="menuName"]').val(menuName);
		});

		$("#add-menu-list-modal").on('show.bs.modal', function(e){
			$("table#lists tbody").siblings("tr").remove();
			var menuId = $(e.relatedTarget).data('kategori');
			var menuName = $(e.relatedTarget).parents('.panel-footer').siblings('.panel-heading').find('a');
			var title, protein, lipid, carbohydrate, calorie;
			var loct = $(e.relatedTarget).parents('.panel-footer').siblings('.panel-collapse').find('li');
			for(i=0;i<loct.length;i++){
				title = loct.eq(i).find('input:eq(1)').val();
				protein = loct.eq(i).find('input:eq(2)').val();
				lipid = loct.eq(i).find('input:eq(3)').val();
				carbohydrate = loct.eq(i).find('input:eq(4)').val();
				calorie = loct.eq(i).find('input:eq(5)').val();
				$("table#lists tbody").after("<tr><td>"+(loct.length-i)+"</td><td>"+title+"</td><td>"+protein+"</td><td>"+lipid+"</td><td>"+carbohydrate+"</td><td>"+calorie+"</td></tr>");
			}
			menuName = menuName.clone().children().remove().end().text();
			$(e.currentTarget).find('input[name="menuIds"]').val(menuId);
			$(e.currentTarget).find('input[name="menuNames"]').val(menuName);
		});
	});

	$("a.delete").click(function(){
		var menuName = $(this).parents('.panel-footer').siblings('.panel-heading').find('a');
		menuName = menuName.clone().children().remove().end().text();
		if (confirm("are you sure want to delete '" + menuName + "' ?"))
			return true;
		return false;
	});

	$("a.add-plan").click(function(){
		$("#add-plan-modal").on('show.bs.modal', function(e){
			var menuId = $(e.relatedTarget).data('kategori');
			var menuName = $(e.relatedTarget).parents('.panel-footer').siblings('.panel-heading').find('a');
			menuName = menuName.clone().children().remove().end().text();
			$(e.currentTarget).find('input[name="menuId"]').val(menuId);
			$(e.currentTarget).find('input[name="menuName"]').val(menuName);
		});
	});

	$('button#addlist-menu').on('click', function(event){
		event.preventDefault();
		var menuId = $('input[name="menuIds"]').val();
		var menuName = $('input[name="menuNames"]').val();
		$('form').attr('action', 'menu/add/list/' + menuId + '/' + menuName);
		$('form').submit();
	});

	$('button#edit-menu').on('click', function(event){
		event.preventDefault();
		var menuId = $('input[name="menuId"]').val();
		var menuName = $('input[name="menuName"]').val();
		$('form').attr('action', 'menu/edit/' + menuId + '/' + menuName);
		$('form').submit();
	});

	$('button#new-menu').on('click', function(event){
		event.preventDefault();
		var menuName = $('input[name="menuNamess"]').val();
		$('form').attr('action', 'menu/add/' + menuName);
		$('form').submit();
	});
});
</script>