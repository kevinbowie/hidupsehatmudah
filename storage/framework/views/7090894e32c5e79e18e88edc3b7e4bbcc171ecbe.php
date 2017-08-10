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
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('dbconfig', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
	<?php if(Session::has('success')): ?>
		<div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
	<?php elseif(Session::has('fail')): ?>
		<div class="alert alert-danger"><?php echo e(Session::get('fail')); ?></div>
	<?php endif; ?>
	<div class="row">
		<div class="page-header">
		  	<div class="pull-left"><h2>Food Lists</h2></div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-group"> <?php 
		$index = 1; ?>

	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php
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
			echo	"<a href='" . route('calories', ['jenis'=>'food','title'=>$datas->category_list, 'categoryId'=>$datas->id]) . "'>More...</a>
				</div>
			</div>";
			$index++; 
			echo "<br>"; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</div>
</body>
</html>