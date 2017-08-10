<?php
$id = $_GET['katId'];
    // die('Received: ' .$id); //Just a test: disable this after receiving the correct response

    // //do your query using the $id
    // $out = 'Whatever you create (HTML or plain text) after your query';
    // echo $out;
?>
<script type="text/javascript" src="boostrap/js/jquery.js"></script>
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
<div class="modal-header">
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
              	// calories_list($ssql); 
                ?>
            </div>

            <!-- train section -->
            <div class="bhoechie-tab-content">
              	<h1 class="glyphicon glyphicon-road" style="font-size:12em;color:#55518a"></h1>
                <?php
        				$ssql = "select c.title, c.id, c.protein, c.fat, c.carbohydrate, c.calorie 
                         from to_do_list a inner join to_do_list_dtl b on a.id = b.list_id
                         inner join calories_list_dtl c on b.cal_id = c.id
					               where a.category_id = " . $id . " and datediff(now(), a.date) <= 15 
                				 group by c.id order by a.date desc;";
                echo $ssql;
          		  // calories_list($ssql);
          		  ?>
            </div>
        </div>
    </div>
	</div>
</div>
<div class="modal-footer"><input type="submit" name="submit" value="Save"></div>

<?php
function calories_list($query){
  // include('dbconfig');


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