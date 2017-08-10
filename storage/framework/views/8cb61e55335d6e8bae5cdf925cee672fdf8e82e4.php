<?php echo $__env->make('dbconfig', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php
if (isset($_GET['katId'])){
		$id = $_GET['katId'];
		echo $id; die();
}
else{
	$id = 'hai';
}
    // die('Received: ' .$id); //Just a test: disable this after receiving the correct response

    // //do your query using the $id
    // $out = 'Whatever you create (HTML or plain text) after your query';
    // echo $out;
?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="jquery-ui-1.12.1/jquery-ui.css">
<script type="text/javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>
<style type="text/css">
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  margin-left: 20px;
  border:1px solid #ddd;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

.alignleft{
	float: left;
}

.alignright{
	float: right;
}
</style>

<?php
if (isset($_POST['submit'])){
	$id = $_POST['listId'];
	$title = $_POST['list'];
	$i = 0;
	$connection = new createConn();
	$connection->connect();
	foreach($id as $arr){
		$ssql = "INSERT INTO to_do_list_dtl (list_id, cal_id, cal_title, portion) ";
		$ssql = $ssql . "VALUES (" . ($_POST['katId'] + 1) . ", " . $arr . ", '-', 1);";
		$result = mysqli_query($connection->myconn, $ssql);
		$i++;
	}
	mysqli_close($connection->myconn);
}

?>
<h1 style="text-align: center;">TAMBAH TO DO LIST</h1>
<div id="add-list-modal">
<form method="post" action="/todolist">
<input type="hidden" name="katId" value="" id="katId">
  	<div class="modal-body">
    	<div class="modal-content">
			<div class="modal-header">
				<div class="col-sm-3 form-group">
					<label for="gender">Gender</label>
					<select class="form-control" name="gender" id="gender">
						<option value="1" selected>Male</option>
						<option value="2">Female</option>
					</select>
				</div>	
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
			  	<div class="row">
			    	<div class="col-lg-11 bhoechie-tab-container">
				        <div class="col-lg-1 bhoechie-tab-menu">
				          	<div class="list-group">
				                <a href="#" class="list-group-item active text-center">
				                	<h4 class="glyphicon glyphicon-star"></h4><br/>Recommended
				                </a>
				            	<a href="#" class="list-group-item text-center">
				              		<h4 class="glyphicon glyphicon-road"></h4><br/>Recently
				            	</a>
				         	</div>
				        </div>
				        <div class="col-lg-9 bhoechie-tab">
				            <!-- flight section -->
				            <div class="bhoechie-tab-content active">
				             	<h2 style="margin-top: 0;color:#55518a">Cooming Soon</h2> 
				                <?php
				        				$ssql = "select a.cal_id, b.id, b.title, count(*) as total, b.protein, b.fat, 
				                         b.carbohydrate, b.calorie from to_do_list_dtl a inner join
				        					       calories_list_dtl b on a.cal_id = b.id group by a.cal_id having
				        					       count(*) > 5 order by count(*) desc limit 15;";
				              	calories_list($ssql); 
				                ?>
				            </div>

				            <!-- train section -->
				            <div class="bhoechie-tab-content">
				              	<h1 class="glyphicon glyphicon-road" style="font-size:12em;color:#55518a"></h1>
				                <?php
				        				$ssql = "select c.title, c.id, c.protein, c.fat, c.carbohydrate, c.calorie 
				                         from to_do_list a inner join to_do_list_dtl b on a.id = b.list_id
				                         inner join calories_list_dtl c on b.cal_id = c.id
									               where a.category_id = " . 1 . " and datediff(now(), a.date) <= 15 
				                				 group by c.id order by a.date desc;";
				          		  		calories_list($ssql);
				          		  ?>
				            </div>
			        	</div>
			    	</div>
				</div>
			</div>
			<div class="modal-footer"><input type="submit" name="submit" value="Save"></div>
    	</div>
  	</div>
</form>
</div>


<?php
function calories_list($query){
  $connection = new createConn();
	$connection->connect();
   	$result = mysqli_query($connection->myconn, $query);
   	if ($result->num_rows > 0){
   		while ($data=mysqli_fetch_array($result)){
   		echo "<div style='clear: both;'>";
   			echo "<div class='checkbox alignleft'>
						<label><input type='hidden' name='listId[]' value='" . $data['id'] . "'><input type='checkbox' name='list[]' value='" . $data['title'] . "'>" . $data['title'] . "</label>
				</div>";
   			echo "<p class='alignright'>" . $data['protein'] . " " . $data['fat'] . " " . $data['carbohydrate'] . " " . $data['calorie'] . "</p>";
   		echo "</div>";
   		}
   	}
   	else
   		echo "<h3 class='text-center'>No Data Found</h3>";
	mysqli_close($connection->myconn);
}
?>

<script type="text/javascript">
$('select').on('change', function() {
  alert( this.value );
});
</script>