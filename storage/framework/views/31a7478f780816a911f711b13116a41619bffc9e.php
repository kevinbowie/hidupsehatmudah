<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
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
	</style>
</head>
<body>
<?php echo $__env->make('navbar/navbar_adm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
	<div class="row">
		<table class="table table-hover">
			<tr>
				<th colspan="8"><h2 class="text-center">TO DO LIST</h2></th>
			</tr>
			<tr class="hide-border">
				<td class="col-sm-2"><button class="btn btn-primary btn-sm">Add Menu</button></td>
				<td class="col-sm-2" colspan="5"><input type="" name="" placeholder="Date" class="form-control input-sm"></td>
			</tr>
			<tr class="thead">
				<th class="col-sm-2">Category</th>
				<th class="col-sm-2 text-center">Reminder</th>
				<th class="col-sm-2 text-right">Carbohydrate</th>
				<th class="col-sm-1.5 text-right">Fat</th>
				<th class="col-sm-1.5 text-right">Protein</th>
				<th class="col-sm-1.5 text-right">Calories</th>
				<th class="col-sm-1.5 text-center">Portion</th>
				<th class="col-sm-1 text-center">Action</th>
			</tr>
			<tr class="head">
				<th>Breakfast</th>
				<td><a href="#">(Set Reminder)</a></td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td></td>
				<td class="text-center"><button class="btn btn-default btn-xs add">ADD</button></td>
			</tr>
			<tr class="head">
				<th><a class="btn btn-default btn-xs toggle-head"><i class="glyphicon glyphicon-plus"></i></a> Lunch</th>
				<td><a href="#">(Set Reminder)</a></td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td></td>
				<td class="text-center"><button class="btn btn-default btn-xs add">ADD</button></td>
			</tr>
			<tr class="plan">
				<td colspan="8" style="padding-left: 30px;">
					<a class="btn btn-default btn-xs toggle-plan"><i class="glyphicon glyphicon-plus"></i></a> 
					YOUR PLAN
				</td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="suggest">
				<td colspan="7" style="padding-left: 30px;">
					<a class="btn btn-default btn-xs toggle-suggest"><i class="glyphicon glyphicon-plus"></i></a> 
					SUGGEST
				</td>
				<td class="text-center"><button class="btn btn-default btn-xs suggest">RESUGGEST</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="head">
				<th><a class="btn btn-default btn-xs toggle-head"><i class="glyphicon glyphicon-plus"></i></a> Dinner</th>
				<td><a href="#">19:00</a></td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td></td>
				<td class="text-center"><button class="btn btn-default btn-xs add">ADD</button></td>
			</tr>
			<tr class="plan">
				<td colspan="8" style="padding-left: 30px;" class="toggle">
					<a class="btn btn-default btn-xs toggle-plan"><i class="glyphicon glyphicon-plus"></i></a> 
					YOUR PLAN
				</td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="suggest">
				<td colspan="7" style="padding-left: 30px;">
					<a class="btn btn-default btn-xs toggle-suggest"><i class="glyphicon glyphicon-plus"></i></a> 
					SUGGEST
				</td>
				<td class="text-center"><button class="btn btn-default btn-xs suggest">RESUGGEST</button></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="detail">
				<td colspan="2" style="padding-left: 50px;">Item 1</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Kalori</td>
				<td>x Portion</td>
				<td></td>
			</tr>
			<tr class="total info">
				<th></th>
				<th>Grand Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th colspan="2"></th>
			</tr>
			<tr class="head">
				<th><a class="btn btn-default btn-xs toggle-head"><i class="glyphicon glyphicon-plus"></i></a> Exercise</th>
				<td><a href="#">19:00</a></td>
				<td></td><td></td><td></td>
				<td>x Kalori</td>
				<td>x Hours</td>
				<td class="text-center"><button class="btn btn-default btn-xs add">ADD</button></td>
			</tr>
			<tr class="plan">
				<td colspan="8" style="padding-left: 30px;" class="toggle">
					<a class="btn btn-default btn-xs toggle-plan"><i class="glyphicon glyphicon-plus"></i></a> 
					YOUR PLAN
				</td>
			</tr>
			<tr class="detail">
				<td style="padding-left: 50px;">Item 1</td>
				<td></td><td></td><td colspan="2"></td>
				<td>x Kalori</td>
				<td>x Hours</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="detail">
				<td style="padding-left: 50px;">Item 1</td>
				<td></td><td></td><td colspan="2"></td>
				<td>x Kalori</td>
				<td>x Hours</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="suggest">
				<td colspan="8" style="padding-left: 30px;">
					<a class="btn btn-default btn-xs toggle-suggest"><i class="glyphicon glyphicon-plus"></i></a> 
					SUGGEST
				</td>
			</tr>
			<tr class="detail">
				<td style="padding-left: 50px;">Walking</td>
				<td></td><td></td><td colspan="2"></td>
				<td>x Kalori</td>
				<td>x Hours</td>
				<td></td>
			</tr>
			<tr class="total info">
				<th></th>
				<th>Grand Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th>x Total</th>
				<th colspan="2"></th>
			</tr>
			<tr>
				<td colspan="8"></td>
			</tr>
			<tr class="head">
				<th>Drink</th>
				<td><a href="#">(Set Reminder)</a></td>
				<td></td><td></td><td></td><td></td>
				<td>x Litre</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
			<tr class="head">
				<th>Sleep</th>
				<td><a href="#">(Set Reminder)</a></td>
				<td></td><td></td><td></td><td></td>
				<td>x Hours</td>
				<td class="text-center"><button class="btn btn-default btn-xs edit">EDIT</button></td>
			</tr>
		</table>
	</div>
	<div class="well">
		<p>Calories : x Kalori</p>
		<p>Carbohydrate : x Kalori Failed)</p>
		<p>Fat : x Kalori (On Progress)</p>
		<p>Protein : x Kalori (Achieved)</p>
		<p>Exercise (Achieved)</p>
		<p>Drink (On Progress)</p>
		<p>Sleep (On Progress)</p>
		<div class="text-center">Congrats ! You have achieved your healthy day</div>
	</div>
	<br>
</div>
</body>
</html>

<script type="text/javascript">
$('a.toggle-plan').click(function(){
    $(this).parents('tr.plan').nextUntil('tr.suggest').slideToggle("100");
    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
});

$('a.toggle-suggest').click(function(){
    $(this).parents('tr.suggest').nextUntil('tr.head').slideToggle(100);
    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
});

$('a.toggle-head').click(function(){
	if(! $(this).parents('tr.head').next('tr.plan').is(":visible")){
		$(this).parents('tr.head').next('tr.plan').show();	
		$(this).parents('tr.head').nextUntil('tr.suggest').next('tr.suggest').show();
		if ($(this).parents('tr.head').next('tr.plan').find('i').hasClass('glyphicon-minus'))
			$(this).parents('tr.head').next('tr.plan').find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
		if ($(this).parents('tr.head').nextUntil('tr.suggest').next('tr.suggest').find('i').hasClass('glyphicon-minus'))
			$(this).parents('tr.head').nextUntil('tr.suggest').next('tr.suggest').find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');
	}
	else{
		$(this).parents('tr.head').nextUntil('tr.head').hide();
		$(this).parents('tr.head').nextUntil('tr.suggest').next('tr.suggest').hide();
	}
    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
});

$(document).ready(function(){
	$('.detail').hide();
	$('.plan').hide();
	$('.suggest').hide();
	$('tr.head').find('td:eq(0)').css("text-align", "center");
	$('tr.head').find('td:eq(1)').css("text-align", "right");
	$('tr.head').find('td:eq(2)').css("text-align", "right");
	$('tr.head').find('td:eq(3)').css("text-align", "right");
	$('tr.head').find('td:eq(4)').css("text-align", "right");
	$('tr.head').find('td:eq(5)').css("text-align", "center");
	$('tr.head').find('td:eq(6)').css("text-align", "center");
	$('tr.total').find('th:eq(1)').css("text-align", "right");
	$('tr.total').find('th:eq(2)').css("text-align", "right");
	$('tr.total').find('th:eq(3)').css("text-align", "right");
	$('tr.total').find('th:eq(4)').css("text-align", "right");
	$('tr.total').find('th:eq(5)').css("text-align", "right");
	$('tr.detail').find('td:eq(1)').css("text-align", "right");
	$('tr.detail').find('td:eq(2)').css("text-align", "right");
	$('tr.detail').find('td:eq(3)').css("text-align", "right");
	$('tr.detail').find('td:eq(4)').css("text-align", "right");
	$('tr.detail').find('td:eq(5)').css("text-align", "center");
});
</script>