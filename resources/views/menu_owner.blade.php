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
		<div class="page-header">
		  	<div class="pull-left"><h2>Menu Anda</h2></div>
			<div class="pull-right">
				<button data-toggle='modal' data-target='#new-menu-modal' class="btn text-right">Menu Baru</button></div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-group" id="yourMenu"> <?php 
		$index = 1; ?>

		@foreach ($menu as $menus) <?php
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
	@foreach($menuDtl as $key)
		@foreach($key as $value)<?php
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
		@endforeach
	@endforeach	
		<?php echo	"</div>
				</div>
			</div>
			<div class='panel-footer text-right'>";
			if ($menus->share == 0)
				echo "<p>Tidak Dibagikan</p>";
			else 
				echo "<p>Dibagikan</p>";
		echo	"<a class='edit' href='#add-menu-list-modal' data-kategori='" . $menus->id . "' data-toggle='modal'>TAMBAH</a> | 
				<a class='edit' href='#edit-menu-modal' data-share='" . $menus->share . "' data-kategori='" . $menus->id . "' 
					data-toggle='modal'>UBAH</a> | 
				<a class='delete' href='" . route('menu/delete', ['jenis'=>$jenis, 'menuId'=>$menus->id]) . "'>HAPUS</a>
			</div>
		</div>";
		setTotal($totalCal, $totalLip, $totalPro, $totalCarb);
		$index++; 
		echo "<br>"; ?>
		@endforeach
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
		loc.append("<span class='right'>Protein: <?php echo $totalPro; ?> | Karbohidrat: <?php echo $totalCarb; ?> | Lemak: <?php echo $totalLip; ?> | Kalori: <?php echo $totalCal; ?> </span>");
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
		var jenis = "<?php echo $jenis; ?>";
		$('form').attr('action', '../../menu/add/' + jenis + '/' + menuName);
		$('form').submit();
	});
});
</script>