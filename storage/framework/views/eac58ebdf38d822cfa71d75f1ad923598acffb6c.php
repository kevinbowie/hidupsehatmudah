<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/jquery.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
	<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-datetimepicker.css">
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
    <style type="text/css">
		tr.plan, tr.suggest{
			font-weight: bold;
		}
		tr.plan:hover, tr.suggest:hover{
			font-size: 125%;
		}
		.glyphicon{
			font-size: 15px;
		}
		.hide-border{
			border-style: hidden;
		}
		.input-sm{
			width: 120px;
		}
		.add, .edit{
			width: 50px;
			height: 25px;
		}
		.suggest{
			height: 25px;
		}
		.detail{
			display: none;
		}
		.information{
			width: 500px;
		    height: auto;
		    border: 1px solid blue; 
		    padding-left: 20px;
		}
		body{
			background: url("images/bg1.jpg") no-repeat center;
		    background-size: cover;
		}
		.well{
			background: #ddd;
		}
		table{
			background-color: #eee;
		}
		.sgthdr{
			border-top: 2px solid black;
			border-bottom: 2px solid black;
		}
		.totalsgt{
			border-bottom: 2px solid black;
		}
	</style>
</head>
<body>
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('dbconfig', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('addlist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
	<?php if(Session::has('success')): ?>
		<div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
	<?php endif; ?>
	<div class='page-header'><h2 class='text-center'>AGENDA KEGIATAN</h2></div>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
			    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
			        <input class="form-control" id="date" size="16" type="text" value="" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			    </div>
				<input type="hidden" id="dtp_input2" value="" /><br/>
			</div>
		</div>
	</div> 
</div>

<input type="hidden" name="idKategori" id="idKategori">
<div id="table">
	
</div>
</body>
</html>
<script type="text/javascript">
	var url = "<?php echo route('item-ajax.index')?>";
</script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajax({ 
		type: "POST",
		url: "date_picker.php",
		data: {date : $('#date').val(), 
				userId : <?php echo Auth::user()->id; ?>, 
				userCalories : <?php echo Auth::user()->calories; ?>},
        context: document.body,
        success: function(response){
        	var monthNames = ["January", "February", "March", "April", "May", "June",
			  "July", "August", "September", "October", "November", "December"
			];
        	var d = new Date();
			var month = d.getMonth()+1;
			var day = d.getDate();
			var output = 
			    (day<10 ? '0' : '') + day + ' ' + monthNames[month-1] + ' ' + d.getFullYear();
			$('#date').val(output);
        	$('#table').html(response);
    	}
    });

	$('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });

    $('.date').change(function(){
    	$.post('/date_picker.php',{date : $('#date').val(), userId : <?php echo Auth::user()->id; ?>, userCalories : <?php echo Auth::user()->calories; ?>}, function(response){
        	$('#table').html(response);
    	});
    });
}); 

</script>
<!-- <script src="/js/item-ajax.js"></script>  -->