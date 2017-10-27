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
	$('#timepicker').timepicker({
	    minuteStep: 1,
	    template: 'modal',
	    appendWidgetTo: 'body',
	    showSeconds: true,
	    showMeridian: false,
	    defaultTime: false
	});
});
</script>
<?php

if (isset($_POST['submit'])){
	$id = $_POST['listId'];
	$title = $_POST['list'];
	$katId = $_POST['katId'] + 1;
	$connection = new createConn();
	$connection->connect();
	foreach($id as $arr){
		$ssql = "SELECT title FROM calories_list_dtl WHERE id = " . $arr . ";";
		$result = mysqli_query($connection->myconn, $ssql);
		$title = mysqli_fetch_array($result);
		$ssql = "INSERT INTO to_do_list_dtl (list_id, cal_id, cal_title, portion) ";
		$ssql = $ssql . "VALUES (" . $katId . ", " . $arr . ", '" . $title['title'] . "', 1);";
		$result = mysqli_query($connection->myconn, $ssql);
	}
	mysqli_close($connection->myconn);
}
?>

<?php
function calories_list($query){
	$ssql = "SELECT category_list FROM calories_list
			where category = 'Makanan'
			group by category_list";
  	$connection = new createConn();
	$connection->connect();
   	$result = mysqli_query($connection->myconn, $ssql);
   	$queryTemp = $query;
   	if ($result->num_rows > 0){
       	echo "<table class='table table-hover'>
        	<tr>
        		<th>#</th>
        		<th>Judul</th>
        		<th class='text-right'>Kalori</th>
        		<th class='text-right'>Lemak</th>
        		<th class='text-right'>Protein</th>
        		<th class='text-center'>Karbohidrat</th>
        		<th class='text-right'>Porsi</th>
        		<th class='text-center'>Satuan</th>
				<th class='text-right'>Gram</th>
        	</tr>";
        while ($hdr=mysqli_fetch_array($result)){
        	$queryTemp = $query;
        	echo "<tr class='header'>
				<th colspan='9'><a class='btn btn-default btn-xs toggle-header-modal'><i class='glyphicon glyphicon-plus'></i></a> " . 
				$hdr['category_list'] . "</th>
				</tr>";
			$queryTemp = str_replace("(nilai)", $hdr['category_list'], $queryTemp);
			getDetailModal($queryTemp);
		}
   		echo "</table>";
   	}
   	else
   		echo "<h3 class='text-center'>Tidak Ada Data</h3>";
	mysqli_close($connection->myconn);
}

function exercise_list($query){
	$connection = new createConn();
	$connection->connect();
	$sql = "select id, category, category_list from calories_list where category = 'Latihan'";
	echo "<table class='table table-hover'>
		<tr>
			<th>#</th>
			<th>Judul</th>
			<th>Kalori</th>
			<th>Jam</th>
		</tr>";
   	$queryTemp = $query;
	$result2 = mysqli_query($connection->myconn, $sql);
	while ($hdr=mysqli_fetch_array($result2)){
        $queryTemp = $query;
		echo "<tr class='header'>
			<th colspan='9'><a class='btn btn-default btn-xs toggle-header-modal'><i class='glyphicon glyphicon-plus'></i></a> " . $hdr['category_list'] . "</th>
		</tr>";
		$queryTemp = str_replace("(nilai)", $hdr['id'], $queryTemp);
		$result = mysqli_query($connection->myconn, $queryTemp);
		if ($result->num_rows > 0){
			while ($dtl=mysqli_fetch_array($result)){
	   			$id = $dtl['id'];
	   			$title = $dtl['title']; 
	   			$carbo = $dtl['carbohydrate'];
				echo "<tr class='details'>
						<td><input type='checkbox' name='calExId[]' value='".$id.":".$title.":".$carbo.":1'></td>
						<td>" . $title . "</td>
						<td class='col-sm-2'>" . $carbo . "</td>
						<td class='col-sm-2'>
							<div class='form-group' style='width: 50px;'>
								<input type='text' name='portionEx' value='1' class='form-control input-small' autocomplete='off'>
							</div>
						</td>
				</tr>";
			}
		}
		else{
			echo "<tr class='details'><td>Tidak Ada Data</td></tr>";
		}
	}
	echo "</table>";
	mysqli_close($connection->myconn);
}

function menu_list($query){
	$connection = new createConn();
	$connection->connect();
	$result = mysqli_query($connection->myconn, $query);
	$index = 1;

	if ($result->num_rows > 0){
		echo "<div class='panel-group' id='menu'>";
		while ($hdr=mysqli_fetch_array($result)){
			$totalCal = 0;
			$totalLip = 0;
			$totalPro = 0;
			$totalCarb = 0;
			echo "<div class='panel panel-default'>
				<div class='panel-heading'>
					<h4 class='panel-title'>
	  					<a data-toggle='collapse' data-parent='#menu' href='#yours" . $index . "'><span class='glyphicon glyphicon-plus'></span>" . 
	  						$hdr['title'] . "</a>
					</h4>
				</div>
				<div id='yours" . $index . "' class='panel-collapse collapse'>
					<div class='panel-body'>
						";
						$ssql2 = "SELECT list_id, food_name, protein, fat, carbohydrate, calories, portion, gram, unit_id
								 FROM menu_dtl where menu_id = " . $hdr['id'] . ";";
						$result2 = mysqli_query($connection->myconn, $ssql2);
						while ($dtl=mysqli_fetch_array($result2)){
							$cal = $dtl['carbohydrate'] + $dtl['protein'] + $dtl['fat'];
							echo "<div class='row'>
							<div class='col-sm-3'><ul style='list-style-type:none;'><li>
								<input type='checkbox' name='calId[]' value='" . $dtl['list_id'] . ":".$dtl['unit_id'].":".$dtl['food_name'].":".$dtl['carbohydrate'].":".$dtl['protein'].":".$dtl['fat'].":".$dtl['calories'].":".$dtl['portion'].":".$dtl['gram']."'> " . $dtl['food_name'] . "</li></ul></div>
							<div class='col-sm-3'><ul style='list-style-type:none;'><li>Pro : " . $dtl['protein'] . " Kal</li></ul></div>
							<div class='col-sm-3'><ul style='list-style-type:none;'><li>Karb : " . $dtl['carbohydrate'] . " Kal</li></ul></div>
							<div class='col-sm-3'><ul style='list-style-type:none;'><li>Lem : " . $dtl['fat'] . " Kal</li></ul></div>
							</div>";
							$totalCal += $cal;
							$totalLip += $dtl['fat'];
							$totalPro += $dtl['protein'];
							$totalCarb += $dtl['carbohydrate'];
							$index += 1;
						}

					setTotal($totalCal, $totalLip, $totalPro, $totalCarb);
					echo "<div><button class='btn btn-default' type='button' name='checkAll'>Check All</button> <button type='button' class='btn btn-default' name='uncheckAll'>Uncheck All</button></div>
						</div>
				</div>
			</div>";
		}
		echo "</div>";
	} 
   	else
   		echo "<h3 class='text-center'>Tidak Ada Data</h3>";
	mysqli_close($connection->myconn);
}

function setTotal($totalCal, $totalLip, $totalPro, $totalCarb){ ?>
	<script type="text/javascript">
		var loc = $('.panel-heading').last().find('a');
		var kategori = $('.panel-footer').last().siblings('.panel-heading').find('a').data('kategori');
		loc.append("<span style='float:right;'>Kalori: <?php echo $totalCal; ?> | Lemak: <?php echo $totalLip; ?> | Protein: <?php echo $totalPro; ?> | Karbohidrat: <?php echo $totalCarb; ?></span>");
	</script> <?php
}
?>

<div id="add-list-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/activity" id="form1">
		<input type="hidden" name="listId" value="">
		<input type="hidden" name="pro" value="">
		<input type="hidden" name="carb" value="">
		<input type="hidden" name="lip" value="">
		<input type="hidden" name="cal" value="">
	  	<div class="modal-body">
	    	<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				  	<div class="row">
				    	<div class="col-lg-11 bhoechie-tab-container">
					        <div class="col-md-2 bhoechie-tab-menu">
					          	<div class="list-group">
					                <a href="#" class="list-group-item active">
					                	<!-- <h4 class="glyphicon glyphicon-star"></h4><br/> -->
					                	<h4>REKOMENDASI</h4>
					                </a>
					            	<a href="#" class="list-group-item">
					            		<h4>AKHIR-AKHIR INI</h4>
					            	</a>
					            	<a href="#" class="list-group-item">
					            		<h4>SERING</h4>
					            	</a>
					            	<a href="#" class="list-group-item">
					            		<h4>MENU</h4>
					            	</a>
					            	<a href="#" class="list-group-item">
					            		<h4>SEMUA</h4>
					            	</a>
					         	</div>
					        </div>
					        <div class="col-lg-9 bhoechie-tab">
					            <!-- RECOMMENDED -->
					            <div class="bhoechie-tab-content active">
					            	<h1 style="color:#55518a;">PALING SERING DIKONSUMSI DARI SEMUA PENGGUNA</h1>
					                <?php
			        				$ssql = "select b.cal_id as id, d.category_list, b.cal_title as title, c.protein, c.fat, 
											c.carbohydrate, c.bdd
											from to_do_list a inner join to_do_list_dtl b on a.id = b.list_id
											inner join calories_list_dtl c on b.cal_id = c.id
											inner join calories_list d on d.id = c.cal_id
											where a.category_id <= 3 and d.category_list = '(nilai)'
											group by b.cal_title
											having count(b.cal_id) > 1
											order by d.category_list, count(b.cal_id) desc, b.cal_title;";
			              			calories_list($ssql); 
					                ?>
					            </div>

					            <!-- RECENTLY -->
					            <div class="bhoechie-tab-content">
					              	<!-- <h1 class="glyphicon glyphicon-road" style="font-size:12em;color:#55518a"></h1> -->
					              	<h1 style="color:#55518a;">BERDASARKAN 5 HARI TERAKHIR</h1>
					                <?php
					                $ssql = "select b.cal_id as id, d.category_list, b.cal_title as title, c.protein, c.fat,
											c.carbohydrate, c.bdd
											from to_do_list a inner join to_do_list_dtl b on a.id = b.list_id 
											inner join calories_list_dtl c on b.cal_id = c.id
											inner join calories_list d on d.id = c.cal_id 
											where datediff(now(), a.date) <= 5 and a.category_id <= 3 and d.category = 'Makanan' 
											and a.user_id = " . Auth::user()->id . " and d.category_list = '(nilai)'
											group by title
											order by d.category_list, a.date desc, b.cal_title;";
			               			calories_list($ssql);
					          		?>
					            </div>

					            <!-- OFTEN -->
					            <div class="bhoechie-tab-content">
					            	<h1 style="color:#55518a;">BERDASARKAN YANG PALING SERING ANDA KONSUMSI</h1>
					                <?php
			        				$ssql = "select b.cal_id as id, d.category_list, b.cal_title as title, c.protein, c.fat, 
											c.carbohydrate, c.bdd
											from to_do_list a inner join to_do_list_dtl b on a.id = b.list_id
											inner join calories_list_dtl c on b.cal_id = c.id
											inner join calories_list d on d.id = c.cal_id
											where a.category_id <= 3 and a.user_id = " . Auth::user()->id . " and 
											d.category = 'Makanan' and d.category_list = '(nilai)' group by b.cal_title
											having count(b.cal_id) > 1
											order by d.category_list, count(b.cal_id) desc, b.cal_title;";
			               			calories_list($ssql);
					          		?>
					            </div>

					            <!-- MENU -->
					            <div class="bhoechie-tab-content">
					              	<h1 style="color:#55518a;">PILIH MENU ANDA DISINI</h1>
					                <?php
					                $ssql = "SELECT id, title, description FROM `menu` 
					                		WHERE user_id = " . Auth::user()->id . " 
					                		ORDER BY title;";
			               			menu_list($ssql);
					          		?>
					            </div>

					            <!-- ALL -->
					            <div class="bhoechie-tab-content">
					              	<h1 style="color:#55518a;">SEMUA DAFTAR</h1>
					                <?php
			        				$ssql = "select c.id, b.category_list, c.title, c.protein, c.fat, c.carbohydrate, 
											c.bdd from calories_list b 
											inner join calories_list_dtl c on b.id = c.cal_id
											where b.category = 'Makanan' and b.category_list = '(nilai)'
											order by b.category_list, c.title";
			               			calories_list($ssql);
					          		?>
					            </div>
				        	</div>
				    	</div>
					</div>
				</div>
				<div class="modal-footer"><input type="submit" class="btn btn-primary" name="submit" value="Simpan"></div>
	    	</div>
	  	</div>
	</form>
</div>

<div id="act-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/activity/others">
	  	<div class="modal-body">
	  		<div class="container">
	  			<div class="modal-dialog modal-sm">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">Atur Minum</h2></div>	
						  		<input type="hidden" name="catId" value="">
						  		<input type="hidden" name="listId" value="">
								<input type="hidden" name="date" value="">
								<div class="form-group col-sm-8">
									<label for="Category">Kategori</label>
									<input type="text" name="category" value="" class="form-control input-small" readonly="readonly">
								</div>
								<div class="form-group col-sm-6" id="porsi">
									<label for="Porsi">Porsi</label>
									<input type="text" name="portion" value="" class="form-control input-small">
								</div>
						</div>
						<div class="modal-footer"><input type="submit" name="submit" class="btn btn-primary" value="Save"></div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>

<div id="sleep-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/activity/sleep" onSubmit="return validasiForm()">
	  	<div class="modal-body">
	  		<div class="container">
	  			<div class="modal-dialog modal-sm">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">Atur Porsi</h2></div>	
						  		<input type="hidden" name="catId" value="">
						  		<input type="hidden" name="listId" value="">
								<input type="hidden" name="date" value="">
								<div class="form-group col-sm-12">
									<label for="Category">Kategori</label>
									<input type="text" name="category" value="" class="form-control input-small" readonly="readonly">
								</div>
								<div class="form-group col-sm-12">
					                <label for="dtp_input1" class="control-label">Waktu</label>
					                <!-- <div class="input-group date form_datetime" data-date-format="dd/mm/yyyy HH:ii p" data-link-field="dtp_input1"> -->
					                    <input class="form-control" type="text" value="" name="getTime" readonly>
					                    <!-- <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					                </div> -->
									<!-- <input type="hidden" id="dtp_input1" name="hour" value="" /><br/> -->
					            </div>
						</div>
						<div class="modal-footer"><input type="submit" name="submit" class="btn btn-primary" value="Simpan"></div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>

<div id="save-list-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/simpanlist" onSubmit="return validasiForm()">
	  	<div class="modal-body">
	  		<div class="container">
	  			<div class="modal-dialog">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">SIMPAN AGENDA SEBAGAI MENU</h2></div>	
					  		<input type="hidden" name="id" value="">
							<div class="form-group col-sm-12">
								<label for="Menu">Judul Menu</label>
								<input type="text" name="judul" value="" class="form-control input-small" required>
							</div>
							<div class="form-group col-sm-12">
						  		<label for="comment">Deskripsi:</label>
							  	<textarea class="form-control" rows="3" name="deskripsi" required></textarea>
								<div class="checkbox"><label><input type="checkbox" name="shared" value="1">Bagikan</label></div>
							</div> 
						</div>
						<div class="modal-footer"><input type="submit" name="submit" class="btn btn-primary" value="Simpan"></div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>

<div id="reminder-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/reminder">
	  	<div class="modal-body">
	  		<div class="container">
			    <div class="modal-dialog modal-sm">
		    			<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">Atur Pengingat</h2></div>	
					  		<input type="hidden" name="catId" value="">
							<input type="hidden" name="date" value="">
							<div class="input-group bootstrap-timepicker timepicker col-sm-6">
								<label for="Time">Waktu</label>
								<input id="timepicker" name="reminder" type="text" class="form-control input-small">
						        </div>
					        <div class="input-group col-sm-12">
								<label for="Note">Catatan</label><br>
								<input type="text" name="note" value="" class="form-control input-small">
							</div>
							<div class="input-group col-sm-5">
								<label for="Remind">Aktifkan</label><br>
								<select class="form-control" name="remind">
									<option value="0">Tidak</option>
									<option value="1">Ya</option>
								</select>
							</div>
						</div>
						<div class="modal-footer"><input class="btn btn-primary" type="submit" name="submit" value="Simpan"></div>
			    	</div>
			    </div>
		    </div>
	  	</div>
	</form>
</div>

<div id="weight-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/weight">
	  	<div class="modal-body">
	  		<div class="container">
			    <div class="modal-dialog modal-sm">
		    			<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">Berat Badan Baru</h2></div>	
							<input type="hidden" name="date" value="">
							<div class="form-group col-sm-6">
								<label for="BB">Berat Badan (kg)</label>
								<input id="weight" name="weight" type="text" class="form-control input-small">
						    </div>
						</div>
						<div class="modal-footer"><input class="btn btn-primary" type="submit" name="submit" value="Simpan"></div>
			    	</div>
			    </div>
		    </div>
	  	</div>
	</form>
</div>

<div id="edit-list-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/editlist">
	  	<div class="modal-body">
	  		<div class="container">
			    <div class="modal-dialog modal-lg">
		    			<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">UBAH AGENDA ANDA</h2></div>	
					  		<input type="hidden" name="listId" value="">
					        <div class="form-group col-sm-12"> 
					        	<div id="tableEdit">

					        	</div>
							</div>
						</div>
						<div class="modal-footer"><input class="btn btn-primary" type="submit" name="submit" value="Simpan"></div>
			    	</div>
			    </div>
		    </div>
	  	</div>
	</form>
</div>

<div id="exercise-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="todolist/exercise">
	  	<div class="modal-body">
	  		<div class="container">
			    <div class="modal-dialog">
		    			<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">TAMBAH OLAHRAGA</h2></div>	
					  		<input type="hidden" name="listId" value="">
					        <div class="form-group col-sm-12"> <?php
					        	$ssql = "select c.title, c.id, c.carbohydrate
					        			 from calories_list b inner join calories_list_dtl c on b.id = c.cal_id
					        			 where b.category = 'Latihan' and b.id = '(nilai)'
		        						 order by c.title;";
		        				exercise_list($ssql); ?>
							</div>
						</div>
						<div class="modal-footer"><input class="btn btn-primary" type="submit" name="submit" value="Simpan"></div>
			    	</div>
			    </div>
		    </div>
	  	</div>
	</form>
</div>

<?php
function getDetailModal($query){
	$i = 0;
	$gram = 0;
	$portion = 0;
	$htmlPortion = "";
	$portionId = "";
	$connection = new createConn();
	$connection->connect();
	$result2 = mysqli_query($connection->myconn, $query);
	if ($result2->num_rows > 0){
		while ($dtl=mysqli_fetch_array($result2)){
			$ssql = "select b.id, b.unit_id, b.cal_id, a.satuan, b.gram, b.portion 
					from satuan a inner join satuan_dtl b on a.id = b.unit_id where b.cal_id = " . $dtl['id'] . ";";
			$htmlPortion = "";
			$result = mysqli_query($connection->myconn, $ssql);
			while ($porsi=mysqli_fetch_array($result)){
				if ($i == 0){
					$gram = round($porsi['gram'] / $porsi['portion']);
					$portion = 1;
					$portionId = $porsi['id'];
					$i++;
				}
				// $htmlPortion = $htmlPortion . "<option value='1'>".$porsi['portion']."</option>";
				$htmlPortion = $htmlPortion . "<option name='unitId[]' value='" . $porsi['id'] . "'>" . $porsi['satuan'] . "</option>";
			}
			$protein = $dtl['protein'];
			$lipid = $dtl['fat'];
			$carbo = $dtl['carbohydrate'];
			$bdd = $dtl['bdd'];
	        $carb = round(($bdd / 100) * ($gram / 100) * $carbo * 4);
	        $pro = round(($bdd / 100) * ($gram / 100) * $protein * 4);
	        $lip = round(($bdd / 100) * ($gram / 100) * $lipid * 9); 
	        $cal = $carb + $pro + $lip;
			echo "<tr class='details'>
				<td><input type='checkbox' name='calId[]' value='".$dtl['id'].":".$portionId.":".$dtl['title'].":".$carb.":".$pro.":".$lip.":".$cal.":".$portion.":".$gram."'>
				</td>
				<td>" . $dtl['title'] . "</td>
				<td>" . $cal . "</td>
				<td>" . $lip . "</td>
				<td>" . $pro . "</td>
				<td>" . $carb . "</td>
				<td>
					<div class='form-group' id='portion' style='width: 50px;'>
						<input type='text' name='portion' value='1' class='form-control input-small' autocomplete='off'>
					</div>
				</td>
				<td><select class='form-control' name='urt' style='width:100px;' autocomplete='off'>" . $htmlPortion . "</select></td>
				<td>" . $gram . "</td>
			</tr>";
		}
	}
	else{
		echo "<tr class='details'><td>Tidak Ada Data</td></tr>";
	}
	mysqli_close($connection->myconn); 
}
?>

<script type="text/javascript">
$(document).ready(function() {
	$('tr.details').find('td:eq(2)').css("text-align", "right");
	$('tr.details').find('td:eq(3)').css("text-align", "right");
	$('tr.details').find('td:eq(4)').css("text-align", "right");
	$('tr.details').find('td:eq(5)').css("text-align", "right");
	$('tr.details').find('td:eq(8)').css("text-align", "right");
	$('tr.details').hide();
	$('a.toggle-header-modal').click(function(){
		$(this).parents('tr.header').nextUntil('tr.header').slideToggle("100");	
	    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
	});
});

$('select').on('change', function(){
	<!-- var dataLoc = $(this).parent().parent().children("td:eq(0)").find('input').data('value'); -->
	var elem = $(this);
	var id = $(this).val();
	//alert(dataLoc['id'] + " " + dataLoc['pro']);
	$.ajax({ 
		type: "GET",
		url: "getPortion.php",
		data: {idUnit : id},
        context: this,
        success: function(json){
        	var json = $.parseJSON(json);
	        var unitId = elem.val();
	        var tr = elem.parent().parent();

	        //update value checkbox untuk dikirim ke controller
	        var prevData = tr.children("td:eq(0)").find('input').val();
	        var obj = prevData.split(":");
	        var currData = tr.children("td:eq(0)").find('input').val(obj[0] + ':' + unitId + ':' + obj[2] + ':' + json.carb + ':' + json.pro + ':' + json.fat + ':' + json.cal + ':1:' + json.gram);
	        var cal = tr.children("td:eq(2)").text(json.cal);
	        var fat = tr.children("td:eq(3)").text(json.fat);
	        var pro = tr.children("td:eq(4)").text(json.pro);
	        var carb = tr.children("td:eq(5)").text(json.carb);
	        var port = tr.children("td:eq(6)").find('input[name="portion"]').val(1);
	        var gram = tr.children("td:eq(8)").text(json.gram);
    	}
    });
});

$('input[name="portion"]').on('focusin', function(){
		$(this).data('val', $(this).val());
});

$('input[name="portionEx"]').on('focusin', function(){
		$(this).data('valEx', $(this).val());
});

$('input[name="portionEx"]').on('change', function(){
	var prev = $(this).data('valEx');
	var current = $(this).val();
	var tr = $(this).parent().parent().parent();
	var cal = tr.children("td:eq(2)").text();
	if (! isNaN($(this).val())){
		var prevData = tr.children("td:eq(0)").find('input').val();
		var obj = prevData.split(":");
		var cal = Math.round(cal / prev * current); 
		tr.children("td:eq(2)").text(cal);
		var currData = tr.children("td:eq(0)").find('input').val(obj[0] + ':' + obj[1] + ':' + cal + ':' + current);
	}
	else{
		alert('harap diisi dalam format angka !');
		$(this).focus();
	}
});

$('input[name="portion"]').on('change', function(){
	var prev = $(this).data('val');
	var current = $(this).val();
	var loc = $(this).parent().parent().parent();
	var cal = loc.children("td:eq(2)").text();
	var fat = loc.children("td:eq(3)").text();
	var pro = loc.children("td:eq(4)").text();
	var carb = loc.children("td:eq(5)").text();
	var gram = loc.children("td:eq(8)").text();
	if (! isNaN($(this).val())){
		fat = Math.round(fat / prev * current);
		pro = Math.round(pro / prev * current);
		carb = Math.round(carb / prev * current);
		gram = Math.round(gram / prev * current);
		cal = fat + pro + carb;
		loc.children("td:eq(2)").text(cal); //cal
		loc.children("td:eq(3)").text(fat); //fat
		loc.children("td:eq(4)").text(pro); //pro
		loc.children("td:eq(5)").text(carb); //carb
		loc.children("td:eq(8)").text(gram); //gram

        var prevData = loc.children("td:eq(0)").find('input').val();
        var obj = prevData.split(":");
        var currData = loc.children("td:eq(0)").find('input').val(obj[0] + ':' + obj[1] + ':' + obj[2] + ':' + carb + ':' + pro + 
        ':' + fat + ':' + cal + ':' + current + ':' + gram);
	}
	else{
		alert('harap diisi dalam format angka !');
		$(this).focus();
	}
});

$("button[name='checkAll']").click(function() {
	$(this).parent().parent().find('input[name="calId[]"]').prop("checked", true);
});

$("button[name='uncheckAll']").click(function() {
	$(this).parent().parent().find('input[name="calId[]"]').prop("checked", false);
});
</script>