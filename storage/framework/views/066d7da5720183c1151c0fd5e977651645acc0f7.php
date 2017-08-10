<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<script src="../../../bootstrap/js/jquery.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../../../bootstrap/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="../../../bootstrap/css/bootstrap-timepicker.css">
	<script src="../../../bootstrap/js/bootstrap-timepicker.min.js"></script>

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
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('dbconfig', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('menu-modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
	<?php if(Session::has('success')): ?>
		<div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
	<?php elseif(Session::has('fail')): ?>
		<div class="alert alert-danger"><?php echo e(Session::get('fail')); ?></div>
	<?php endif; ?>
	<div class="row">
		<div class="page-header">
		  	<div class="pull-left"><h2>Dibagikan Orang Lain</h2></div>
			<div class="pull-right">
				<button data-toggle='modal' data-target='#new-menu-modal' class="btn text-right">Tambah Menu</button></div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-group" id="othersMenu"> <?php 
		$index = 1; ?>

		<?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php
		$totalCal = 0;
		$totalLip = 0;
		$totalPro = 0;
		$totalCarb = 0; 
	echo "<div class='panel panel-default'>
			<div class='panel-heading'>
				<h4 class='panel-title'>
  					<a data-toggle='collapse' data-parent='#' href='#yours" . $index . "'>" . $menus->title . "</a>
				</h4>
			</div>
			<div id='yours" . $index . "' class='panel-collapse collapse in'>
				<div class='panel-body'>
					<div class='row'>"; ?>
	<?php $__currentLoopData = $menuDtl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__currentLoopData = $key; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php
				if ($value->menu_id == $menus->id){
					echo "
						<div class='col-sm-3'><ul style='list-style-type:none;'><li>" . $value->food_name . "</li></ul></div>
						<div class='col-sm-2'><ul style='list-style-type:none;'><li>Pro : " . $value->protein . " Kal</li></ul></div>
						<div class='col-sm-2'><ul style='list-style-type:none;'><li>Karb : " . $value->carbohydrate . " Kal</li></ul></div>
						<div class='col-sm-2'><ul style='list-style-type:none;'><li>Lem : " . $value->fat . " Kal</li></ul></div>
						<div class='col-sm-2'><ul style='list-style-type:none;'><li>Total : " . $value->calories . " Kal</li></ul></div>";
					$totalCal += $value->fat + $value->protein + $value->carbohydrate;
					$totalLip += $value->fat;
					$totalPro += $value->protein;
					$totalCarb += $value->carbohydrate; 
				} ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
		<?php echo	"</div>
				</div>
			</div>
			<div class='panel-footer text-right'>
				<p>Oleh : " . $menus->user_fullname . "</p>
				<a class='add-plan' href='#add-plan-modal' data-toggle='modal' data-kategori='" . $menus->id . "'>Tambah ke Agenda</a>
			</div>
		</div>";
		setTotal($totalCal, $totalLip, $totalPro, $totalCarb);
		$index++; 
		echo "<br>"; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
		loc.append("<span class='right'>Protein: <?php echo $totalPro; ?> | Karbohidrat: <?php echo $totalCarb; ?> | Lemak: <?php echo $totalLip; ?> | Kalori: <?php echo $totalCal; ?></span>");
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
		$('form').attr('action', '../../menu/add/list/' + menuId + '/' + menuName);
		$('form').submit();
	});

	$('button#edit-menu').on('click', function(event){
		event.preventDefault();
		var menuId = $('input[name="menuId"]').val();
		var menuName = $('input[name="menuName"]').val();
		$('form').attr('action', '../../menu/edit/' + menuId + '/' + menuName);
		$('form').submit();
	});

	$('button#new-menu').on('click', function(event){
		event.preventDefault();
		var menuName = $('input[name="menuNamess"]').val();
		$('form').attr('action', '../../menu/add/' + menuName);
		$('form').submit();
	});
});
</script>