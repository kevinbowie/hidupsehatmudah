
<style type="text/css">
.alignleft{
	float: left;
}

.alignright{
	float: right;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('.form_date').datetimepicker({
	    weekStart: 1,
	    todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
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

<div id="edit-menu-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="#">
	  	<div class="modal-body">
			<div class="container">
	  			<div class="modal-dialog modal-sm">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						  		<input type="hidden" name="userId" value="">
								<input type="hidden" name="menuId" value="">
								<label for="Menu">Menu</label>
								<input type="text" name="menuName" value="" class="form-control input-small">
								<div class="checkbox"><label>
									<input type="checkbox" name="share" value="">Bagikan</label></div>
							</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
							<button class="btn btn-primary" id="edit-menu" type="submit">Simpan</button></div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>

<div id="add-menu-list-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="">
	  	<div class="modal-body">
			<div class="container">
		    	<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
							<input type="hidden" name="menuIds" value="">
							<label for="Menu">Menu</label>
							<input type="text" name="menuNames" value="" class="form-control input-small" readonly="readonly">
							<h2 align="center" style="margin-top: 50px;">Daftar Makanan</h2>
							<table id="addLists" class="table table-hover">
							   	<thead>
							    	<tr>
							        	<th class='col-sm-1'>#</th>
							        	<th class='col-sm-1'>No</th>
							        	<th>Judul</th>
							        	<th class='col-md-1'>Protein</th>
							        	<th class='col-md-1'>Lemak</th>
							        	<th class='col-md-1'>Karbohidrat</th>
							        	<th class='col-md-1'>Kalori</th>

							      	</tr>
							    </thead>
							    <tbody>
							    	<?php calories_list(); ?>
							    </tbody>
							</table>
						</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button class="btn btn-primary" menu="addlist-menu" id="addlist-menu" type="submit">Simpan</button></div>
		    	</div>
			</div>
	  	</div>
	</form>
</div>

<div id="new-menu-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="#">
	  	<div class="modal-body">
			<div class="container">
		    	<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
						<label for="Menu">Judul Menu</label>
						<input type="text" name="menuNamess" value="" class="form-control input-small">
						<div class="form-group">
					  		<label for="comment">Deskripsi:</label>
						  	<textarea class="form-control" rows="3" name="description"></textarea>
						</div> 
						<div class="checkbox"><label><input type="checkbox" name="shared" value="1">Bagikan</label></div>
						<h2 align="center" style="margin-top: 50px;">Daftar Makanan</h2>
						<table id="addLists" class="table table-hover">
						   	<thead>
						    	<tr>
						        	<th class='col-sm-1'>#</th>
						        	<th class='col-md-3 text-center'>Judul</th>
						        	<th class='col-md-1 text-right'>Protein</th>
						        	<th class='col-md-1 text-right'>Lemak</th>
						        	<th class='col-md-1 text-right'>Karbohidrat</th>
						        	<th class='col-md-1 text-right'>Kalori</th>
						        	<th class='col-sm-1'>Porsi</th>
						        	<th class='col-md-1 text-center'>Satuan</th>
						        	<th class='col-md-1 text-right'>Gram</th>
						      	</tr>
						    </thead>
						    <tbody>
						    	<?php calories_list(); ?>
						    </tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button class="btn btn-primary" id="new-menu" type="submit">Simpan</button></div>
		    	</div>
			</div>
	  	</div>
	</form>
</div>

<div id="add-plan-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" action="<?php echo e(url('menu/add-plan')); ?>">
	  	<div class="modal-body">
	  		<div class="container">
	  			<div class="modal-dialog modal-sm">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<input type="hidden" name="menuId" value="">
							<div class="form-group">
								<label for="Menu">Menu</label>
								<input type="text" name="menuName" value="" class="form-control input-small" readonly="readonly">
							</div>
							<div class="form-group">
							    <label for="dtp_input2" class="control-label">Tanggal</label>
							    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							        <input class="form-control input-small" name="date" id="date" size="16" type="text" value="" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							    </div>
								<input type="hidden" id="dtp_input2" value="" /><br/>
							</div>
							<div class="form-group">
								<label for="Category">Kategori</label>
								<select class="form-control" name="catId">
									<option value="0" selected>Kategori</option>
									<option value="1">Sarapan</option>
									<option value="2">Makan Siang</option>
									<option value="3">Makan Malam</option>
								</select>
							</div>
						</div>
						<div class="modal-footer"><input type="submit" class="btn btn-primary" name="submit" value="Simpan"></div>
			    	</div>
			    </div>
		    </div>
	  	</div>
	</form>
</div>

<?php
function calories_list(){
	$ssql = "SELECT category_list FROM calories_list
			where category = 'Makanan'
			group by category_list";
  	$connection = new createConn();
	$connection->connect();
   	$result = mysqli_query($connection->myconn, $ssql);
   	if ($result->num_rows > 0){
        while ($hdr=mysqli_fetch_array($result)){
        	echo "<tr class='header'>
				<th colspan='9'><a class='btn btn-default btn-xs toggle-header-modal'><i class='glyphicon glyphicon-plus'></i></a> " . 
				$hdr['category_list'] . "</th>
				</tr>";
			$ssql = "select b.id, b.title, b.protein, b.fat, b.carbohydrate, 0 as calorie, b.bdd
					from calories_list a inner join calories_list_dtl b on a.id = b.cal_id 
					where a.category = 'makanan' and a.category_list = '" . $hdr['category_list'] . "' 
					order by a.category_list, b.title";
			getDetailModal($ssql);
		}
   		echo "</table>";
   	}
	else{
		echo "<tr><td><h2>Tidak Ada Data</h2></td></tr>";
	}
	mysqli_close($connection->myconn);
}

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
				<td class='text-right'>" . $cal . "</td>
				<td class='text-right'>" . $lip . "</td>
				<td class='text-right'>" . $pro . "</td>
				<td class='text-right'>" . $carb . "</td>
				<td>
					<div class='form-group' id='portion' style='width: 50px;'>
						<input type='text' name='portion' value='1' class='form-control input-small' autocomplete='off'>
					</div>
				</td>
				<td><select class='form-control' name='urt' style='width:100px;' autocomplete='off'>" . $htmlPortion . "</select></td>
				<td class='text-right'>" . $gram . "</td>
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
	$('tr.details').hide();
	$('a.toggle-header-modal').click(function(){
		$(this).parents('tr.header').nextUntil('tr.header').slideToggle("100");	
	    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
	});
});

$('select[name="urt"]').on('change', function(){
	var elem = $(this);
	var id = $(this).val();
	$.ajax({ 
		type: "GET",
		url: "../../getPortion.php",
		data: {idUnit : id},
        context: this,
        success: function(json){
        	var json = $.parseJSON(json);
	        var unitId = elem.val();
	        var tr = elem.parent().parent();

	        //update value checkbox untuk dikirim ke controller
	        var prevData = tr.children("td:eq(0)").find('input').val();
	        var obj = prevData.split(":");
	        var currData = tr.children("td:eq(0)").find('input').val(obj[0] + ':' + unitId + ':' + obj[2] + ':' + json.carb + ':' + json.pro + 
	        ':' + json.fat + ':' + json.cal + ':1:' + json.gram);
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
</script>