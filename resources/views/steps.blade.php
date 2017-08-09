<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="bootstrap/js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <style>
  body {
      font: 400 15px/1.8 Lato, sans-serif;
      color: #777;
  }
  h3{
      margin: 10px 0 30px 0;
      letter-spacing: 10px;      
      font-size: 20px;
      color: #111;
  }
  .container {
      width: 1100px;
  }
  .person {
      border: 10px solid transparent;
      margin-bottom: 25px;
      width: 80%;
      height: 80%;
      opacity: 0.7;
  }
  .person:hover {
      border-color: #f1f1f1;
  }
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
    }
  }
  .bg-1 {
      background: #2d2d30;
      color: #bdbdbd;
  }
  .bg-1 h3 {color: #fff;}
  .bg-1 p {font-style: italic;}
  .list-group-item:first-child {
      border-top-right-radius: 0;
      border-top-left-radius: 0;
  }
  .list-group-item:last-child {
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
  }
  .btn{
	  margin-top:5px;
  }
  .navbar-btn {
	  margin-right: 8px;
  }
  .form-control{
	  margin-top:8px;
	  margin-bottom:8px;
	  margin-right: 8px; 
  }

  .form-group1{
	  margin-top:-12px;
  }
  .form-group2{
	 float:right;
	 margin-right:1px;
  }
  .input-group{
	  width:300px;
  }
  .input-group1{
	  width:900px;
	  height: 400px;
  }  
  textarea {
      resize: none;
  }
  p{
	  margin-top:15px;
  }
  .table td.fit, .table th.fit {
	    white-space: nowrap;
	    width: 10%;
	}
	.table td.big{
	}
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
@include('navbar/navbar_2')
<h2 class="text-center">STEP RECORDS</h2>  
<div class="container"> 
	<form method="post" onSubmit="return validateForm()">
		<div class="col-sm-6">
			<div class="row">
			  	<div class="col-sm-3 form-group">
					<label>Year</label>
					<div class="form-group">
			        	<input type="text" name="year" value="" class="form-control input-small">
				    </div>
				</div>
				<div class="col-sm-3 form-group">
					<label>Month</label>
					<div class="form-group">
			        	<input type="text" name="month" value="" class="form-control input-small">
				    </div>
				</div>	
				<div style="margin-top: 33px;"><button class="btn btn-primary" id="submit" type="submit">Refresh</button></div>
			</div>	
		</div>
	</form>
  	<table class="table table-hover">
    <tbody>
    	<?php $i = 1; $k = 0;
    	for($j=0;$j<count($date);$j++){
		$time1 = new DateTime($userDtl[$j]->start);
		$time2 = new DateTime($userDtl[$j]->end);
		$timediff = $time1->diff($time2)->format("%h:%i:%s");
    	echo "<tr>
	        <td class='fit'><img src='#'><p>" . Auth::user()->first_name . " " . Auth::user()->last_name . "</p>
	        	<a href='" . route('steps', ['date'=>$userDtl[$j]->date]) . "' class='more'>See More...</a>
	        </td>
	        <td class='fit'>
				<ul class='list-unstyled'>
					<li>Ditance : " . $userDtl[$j]->distance . "</li>
					<li>Start : " . $userDtl[$j]->start . "</li>
					<li>End : " . $userDtl[$j]->end . "</li>
				</ul>  
	        </td>
	        <td class='fit'>
	        	<ul class='list-unstyled'>
	        		<li>Goal : " . $userDtl[$j]->goal . "</li>
	        		<li>Time : " . $timediff . "</li>
	        		<li>Date : " . $userDtl[$j]->date . "</li>
	        	</ul>
	        </td>
	        <td class='col-sm-1'></td>
        	<td class='big'>
        		<table class='table table-bordered' class='someid'>
        			<thead>
			    		<tr>
				        	<th width='10%' style='text-align:center;'>No</th>
				        	<th width='20%' style='text-align:center;'>Name</th>
				        	<th width='15%' style='word-wrap: break-word; text-align:center;'>Distance (km)</th>
				        	<th width='15%' style='text-align:center;'>Time</th>
				      	</tr>
			    	</thead>
			    	<tbody>";
		foreach($data as $values){
			$date1 = date_create($date[$j]->date);
			$date2 = date_create($values->date);
			$compare = date_diff($date1, $date2)->format("%a");
			$time1 = new DateTime($values->start);
			$time2 = new DateTime($values->end);
			$timediff = $time1->diff($time2)->format("%h:%i:%s");
			if ($compare == 0){
					if ($values->id == Auth::user()->id)	
						echo "<tr class='info'>";
					else
				   		echo "<tr>";
		    		echo "<td>" . $i . "</td>
		    			<td>" . $values->first_name . " " . $values->last_name . "</td>
		    			<td>" . $values->distance . "</td>
		    			<td>" . $timediff . "</td>
		    		</tr>"; 
		    		unset($data[$k]);
		    		$i++;
		    		$k++;
			 }
			 else{
			 	$i = 1;
			 	echo "</tbody></table></td></tr>"; 
			 	break;
			 }
		} 
		} ?>
    </tbody>
  </table>
</div>
</body>
</html>

<?php 
function get_time_difference($time1, $time2){
	$time1 = strtotime("1/1/1980 $time1");
	$time2 = strtotime("1/1/1980 $time2");
	if ($time2 < $time1)
		$time2 = $time2 + 86400;
	return ($time2 - $time1) / 3600;

}
?>

<script type="text/javascript">
function validateForm(){
	flag = false;
	if ($('input[name="year"]').val().length != 4)
		alert('Format Tahun Tidak Tepat !');
	else if (! ($('input[name="month"]').val() > 0 && $('input[name="month"]').val() < 13))
		alert('Format Bulan Tidak Tepat !');
	else 
		flag = true;
	$('form').attr('action', {{ action('CRUDController@readSteps') }});
	return flag;
}
</script>