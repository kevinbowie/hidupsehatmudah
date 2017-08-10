<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <script src="../bootstrap/js/jquery.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
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
<?php echo $__env->make('navbar/navbar_2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<h2 class="text-center">STEP RECORDS</h2> 
<div class="container"> 
	<table class='table table-bordered' class='someid'>
		<thead>
			<tr>
	        	<th width='10%' style='text-align:center;'>No</th>
	        	<th width='20%' style='text-align:center;'>Nama</th>
	        	<th width='15%' style='word-wrap: break-word; text-align:center;'>Jarak (km)</th>
	        	<th width='15%' style='text-align:center;'>Waktu</th>
	      	</tr>
		</thead>
		<tbody>; <?php
    $i = 1;
		foreach($data as $values){
      $time1 = new DateTime($values->start);
      $time2 = new DateTime($values->end);
      $timediff = $time1->diff($time2)->format("%h:%i:%s");
      if ($values->id == Auth::user()->id)
        echo "<tr class='info'>";
      else
  			echo "<tr>";
      echo "<td>" . $i . "</td>
    			<td>" . $values->first_name . " " . $values->last_name . "</td>
    			<td>" . $values->distance . "</td>
    			<td>" . $timediff . "</td>
    		</tr>"; 
    		$i++;
		} ?>
    </tbody>
  </table>
</div>
</body>
</html>