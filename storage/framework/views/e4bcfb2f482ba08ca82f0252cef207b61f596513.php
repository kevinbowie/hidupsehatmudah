<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<?php echo $__env->make('navbar/navbar_adm', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<h2 class="text-center">NOTIFICATIONS</h2> 
<div class="container"> 
	<table class='table table-bordered' class='someid'>
		<thead>
			<tr>
	        	<th width='5%' style='text-align:center;'>No</th>
	        	<th width='20%' style='text-align:center;'>Name</th>
	        	<th width='35%' style='text-align:center;'>Status</th>
	      	</tr>
		</thead>
		<tbody>; <?php
    $i = 1;
    foreach($notif as $values){
      echo "<td>" . $i . "</td>
          <td>" . $values->first_name . " " . $values->last_name . "</td>
          <td>" . $values->information . ", " . $values->time . "</td>
        </tr>"; 
        $i++;
    } ?>
    </tbody>
  </table>
</div>
</body>
</html>