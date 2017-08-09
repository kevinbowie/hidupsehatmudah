<?php 
include ('dbconfig.php');
$date = isset($_POST['date']) ? date_format(date_create($_POST['date']), "y-m-d") : date("Y-m-d");
$userId = $_POST['userId'];
$userCal = round($_POST['userCalories']);
$userPro = round($userCal * 0.15);
$userLip = round($userCal * 0.25);
$userCarb = round($userCal * 0.6);
$ttlCal = 0;
$ttlPro = 0;
$ttlCarb = 0;
$ttlLip = 0;
$ttlOther = array();
$ttlOther[0] = 0;
$ttlOther[1] = 0;
$ttlOther[2] = 0;
$kategori = array("Sarapan", "Makan Siang", "Makan Malam", "Olahraga", "Minum", "Tidur");
$sukses = "";
$msg = "";

$ssql = "select category_id, category, id, remind, time from to_do_list where date = '" . $date . "' 
		and user_id = " . $userId . " order by category_id;";
$connection = new createConn();
$connection->connect();
$result = mysqli_query($connection->myconn, $ssql);
$totalCal = 0;
$totalCarb = 0;
$totalLip = 0;
$totalPro = 0;

if ($result->num_rows > 0){
	$index = 1; ?>
	<div class="container">
		<?php weight($date, $userId, $userCal, $userPro, $userLip, $userCarb); ?>
		<div class="row">
			<table class="table table-hover">
				<tr class="thead">
					<th class="col-sm-2">Kategori</th>
					<th class="col-sm-2 text-center">Pengingat</th>
					<th class="col-sm-2 text-right">Karbohidrat</th>
					<th class="col-sm-1.5 text-right">Lemak</th>
					<th class="col-sm-1.5 text-right">Protein</th>
					<th class="col-sm-1.5 text-right">Kalori</th>
					<th class="col-sm-1.5 text-center">Porsi</th>
					<th class="col-sm-1 text-center">Aksi</th>
				</tr> <?php

	while ($data=mysqli_fetch_array($result)){
		echo "<tr class='head' data-list='".$data['id']."'>
				<th>";
		if ($data['category_id'] <= 4){
			echo "<a class='btn btn-default btn-xs toggle-head'><i class='glyphicon glyphicon-plus'></i></a> ";
		}
			echo $kategori[$data['category_id'] - 1] . "</th>
			<td>
			<a href='#reminder-modal' data-toggle='modal' data-kategori='" . $data['id'] . "' class='reminder'>";

			if ($data['remind'])
				echo $data['time'];
			else
				echo "(Atur Pengingat)";
		echo "</a></td>";
		if ($data['category_id'] <= 3){
			setTotal($data['id']);
			echo "<td class='text-center'><button class='btn btn-default btn-xs add' style='width:60px;' data-target='#add-list-modal' data-list='". $data['id'] ."' data-toggle='modal' data-protein='".$totalPro."' data-carb='".$totalCarb."' data-lip='".$totalLip."' data-cal='".$totalCal."'>TAMBAH</button></td>
			</tr>
			<tr class='plan'>
				<td colspan='8' style='padding-left: 30px;' class='toggle'>
					<a class='btn btn-default btn-xs toggle-plan'><i class='glyphicon glyphicon-plus'></i></a> AGENDA ANDA
				</td>
			</tr>";
			getDetails($userId, $date, $data['category_id'], 1);
			$index += 1;
			echo "<tr class='suggest'>
					<td colspan='8' style='padding-left: 30px;'>
						<a class='btn btn-default btn-xs toggle-suggest'><i class='glyphicon glyphicon-plus'></i></a> 
						SARAN
					</td>
				</tr>";
			food_recommended($userCal, $date, $index-1, $data['id']);
		}
		else if ($data['category_id'] > 3){
			echo "<td></td><td></td><td></td>";
			setTotal1($data['id'], $data['category_id']);
			switch ($data['category_id']) {
				case 4:
					echo "<td class='text-center'>
							<button class='btn btn-default btn-xs add' style='width:60px;' data-target='#exercise-modal' data-list='". $data['id'] ."' data-toggle='modal'>TAMBAH</button>
						</td>
					</tr>
					<tr class='plan'>
						<td colspan='8' style='padding-left: 30px;' class='toggle'>
							<a class='btn btn-default btn-xs toggle-plan'><i class='glyphicon glyphicon-plus'></i></a> AGENDA ANDA
						</td>
					</tr>";
					getDetails($userId, $date, $data['category_id'], 2);
					echo "<tr class='suggest'>
						<td colspan='8' style='padding-left: 30px;'>
							<a class='btn btn-default btn-xs toggle-suggest'><i class='glyphicon glyphicon-plus'></i></a> 
							SARAN
						</td>
					</tr>
					<tr class='detail'>
						<td style='padding-left: 50px;'>BERJALAN</td>
						<td></td><td></td><td colspan='2'></td>
						<td>300 Kal</td>
						<td class='text-center'>0.5 Jam</td>
						<td></td>
					</tr>
					<tr class='head'></tr>";
					grandTotal($date, $userId);
					break;
				default:
					echo "<td class='text-center'><button class='btn btn-default btn-xs edit-act' data-toggle='modal' data-target='#act-modal' data-list='" . $data['id'] . "' data-kategori='" . $data['category_id'] . "'>UBAH</button></td>
					</tr>";
					break;
			}
		}
	}
} 
else
	echo "<h3 class='text-center'>Tidak Ada Data</h3>";
mysqli_close($connection->myconn); ?>
			</table>
		</div>
		<?php
		cekCompleted($date, $userId);
		echo "<div class='well'>
			<p>Kalori : " . $userCal . " Kalori</p>
			<p>Karbohidrat : " . $userCarb . " Kalori"; 
				if (($userCarb - $ttlCarb >= -100) && ($userCarb - $ttlCarb <= 200)){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					$msg = "Coba lebih perhatikan konsumsi karbohidrat";
				}
		echo "</p>
			<p>Lemak : " . $userLip . " Kalori";
				if (($ttlLip >= 100) && ($userLip - $ttlLip >= -100)){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					if ($msg != "")
						$msg = $msg . ", Lemak"; 
					else 
						$msg = "Coba lebih perhatikan konsumsi lemak"; 
				}
		echo "</p>
			<p>Protein : " . $userPro . " Kalori"; 
				if (($userPro - $ttlPro >= -100) && ($userPro - $ttlPro <= 100)){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					if ($msg != "")
						$msg = $msg . ", Protein"; 
					else 
						$msg = "Coba lebih perhatikan konsumsi lemak protein"; 
				}
		echo "</p>
			<p>Olahraga";
				if ($ttlOther[0] >= 0.5){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					if ($msg != "")
						$msg = $msg . "<br>Berolahragalah setiap hari minimal setengah jam (untuk aktivitas ringan) !"; 
					else 
						$msg = "Berolahragalah setiap hari minimal setengah jam (untuk aktivitas ringan) !"; 
				}
		echo "</p>
			<p>Drink";
				if ($ttlOther[1] >= 2){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					if ($msg != "")
						$msg = $msg . "<br>Minumlah minimal 2 Liter air setiap hari !"; 
					else 
						$msg = "Minumlah minimal 2 Liter air setiap hari !"; 
				}
		echo "</p>
			<p>Sleep";
				if ($ttlOther[2] >= 6 && $ttlOther[2] <= 9){
					echo " (Tercapai)";
				}
				else {
					echo " (Belum Tercapai)"; 
					if ($msg != "")
						$msg = $msg . "<br>Beristirahatlah minimal 6 - 9 jam setiap hari !"; 
					else 
						$msg = "Beristirahatlah minimal 6 - 9 jam setiap hari !"; 
				}
		echo "</p>
			<div class='text-center'>";
				if ($msg != "")
					echo $msg;
				else
					echo "Selamat! Anda berhasil mencapai gaya hidup sehat hari ini !";
		echo "</div>
		</div>"; ?>
		<br>
	</div> 

<?php
function getDetails($userId, $date, $categoryId, $id){
	$connection = new createConn();
	$connection->connect();
	$ssql2 = "SELECT b.id, b.list_id, b.cal_title, b.protein, b.fat, b.carbohydrate, b.calories, b.portion, d.satuan
			  FROM to_do_list a left join to_do_list_dtl b on a.id = b.list_id
			  inner join satuan d on d.id = b.unit_id
			  where a.user_id = " . $userId . " and a.date = '" . $date . "' and 
			  a.category_id = " . $categoryId . " order by b.cal_title;";
	$result2 = mysqli_query($connection->myconn, $ssql2);
	while ($dtl=mysqli_fetch_array($result2)){
		if ($id == 1){
			echo "<tr class='detail'>
				<td colspan='2' style='padding-left: 50px;'>" . $dtl['cal_title'] . "</td>
				<td>" . $dtl['carbohydrate'] . "</td>
				<td>" . $dtl['fat'] . "</td>
				<td>" . $dtl['protein'] . "</td>
				<td>" . $dtl['calories'] . "</td>
				<td>" . $dtl['portion'] . " " . $dtl['satuan'] . "</td>
				<td class='text-center'>
					<button class='btn btn-default btn-xs delete' data-list='" . $dtl['id'] . "'>
					<i class='glyphicon glyphicon-remove'></i>
				</td>
			</tr>";
		}
		else{
			echo "<tr class='detail'>
				<td style='padding-left: 50px;'>" . $dtl['cal_title'] . "</td>
				<td></td><td></td><td colspan='2'></td>
				<td>" . $dtl['calories'] . " Kal</td>
				<td class='text-center'>" . $dtl['portion'] . " Jam</td>
				<td class='text-center'>
					<button class='btn btn-default btn-xs delete' data-list='" . $dtl['id'] . "'>
					<i class='glyphicon glyphicon-remove'></i>
				</td>
			</tr>";
		}
	}
	mysqli_close($connection->myconn); 
}

function food_recommended($UCalories, $date, $index, $listId){
	$connection = new createConn();
	$caloriePortion = $UCalories / 3;
	$i = 1;
	$count = 1;
	$ssql = "SELECT a.id, a.gram, a.carbohydrate, a.protein, a.fat, a.cal_title as title, a.calories, a.cal_id, a.portion, c.satuan
			 FROM recommended a inner join to_do_list b on a.list_id = b.id inner join satuan c on c.id = a.unit_id
			 where b.date = '" . $date . "' and b.category_id = " . $index . " order by a.id;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($dtl=mysqli_fetch_array($result)){
			if ($count == 1){
				echo "<tr class='sgthdr'>
					<td colspan='8' style='padding-left: 30px;' class='toggle'>
						<a class='btn btn-default btn-xs choose' href='todolist/rekom/".$listId."/".$dtl['id']."'>Pilih</a>
						 SARAN KE- " . $i . "</td>
				</tr>";
				$i++;
			}
			echo "<tr class='detailsgt'>
				<td colspan='2' style='padding-left: 50px;'>" . $dtl['title'] . "</td>
				<td class='text-right'>" . $dtl['carbohydrate'] . "</td>
				<td class='text-right'>" . $dtl['fat'] . "</td>
				<td class='text-right'>" . $dtl['protein'] . "</td>
				<td class='text-right'>" . $dtl['calories'] . "</td>
				<td class='text-center'>" . $dtl['portion'] . " " . $dtl['satuan'] . "</td>
				<td></td>
			</tr>";
			if ($count == 5)
				$count = 1;
			else
				$count++;
		}
	}
	mysqli_close($connection->myconn); 
} 

function setTotal($listId){ 
	$connection = new createConn();
	$ssql = "SELECT sum(protein) as protein, sum(carbohydrate) as carb, sum(fat) as fat 
			FROM `to_do_list_dtl` WHERE list_id = " . $listId . ";"; 
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	$totalCal = 0;
	$totalCarb = 0;
	$totalLip = 0;
	$totalPro = 0;
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		echo "<td>" . $dtl['carb'] . "</td>
			<td>" . $dtl['fat'] . "</td>
			<td>" . $dtl['protein'] . "</td>
			<td>" . ($dtl['carb'] + $dtl['fat'] + $dtl['protein']) . "</td>
			<td></td>";
		$totalCal += $dtl['carb'] + $dtl['fat'] + $dtl['protein'];
		$totalCarb += $dtl['carb'];
		$totalLip += $dtl['fat'];
		$totalPro += $dtl['protein'];
	}
	else{
		echo "<td>0</td><td>0</td><td>0</td><td>0</td><td></td>";
	}
	mysqli_close($connection->myconn);
} 

function setTotal1($listId, $catId){ 
	$connection = new createConn();
	$ssql = "SELECT sum(calories) as calorie, sum(portion) as portion
			FROM `to_do_list_dtl` WHERE list_id = " . $listId . ";"; 
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		switch ($catId) {
			case 4:
				$GLOBALS['ttlOther'][0] = $dtl['portion'];
				echo "<td>" . $dtl['calorie'] . "</td>
					<td>" . $dtl['portion'] . " Jam</td>";
				break;
			case 5:
				$GLOBALS['ttlOther'][1] = $dtl['portion'];
				echo "<td></td>
					<td>" . $dtl['portion'] . " Liter</td>";
				break;
			default:
				$GLOBALS['ttlOther'][2] = $dtl['portion'];
				echo "<td></td>
					<td>" . $dtl['portion'] . " Jam</td>";
				break;
		}
	}
	else{
		$GLOBALS['ttlOther'][0] = 0;
		$GLOBALS['ttlOther'][1] = 0;
		$GLOBALS['ttlOther'][2] = 0;
		echo "<td>0</td><td>0</td>";
	}
	mysqli_close($connection->myconn);
} 

function grandTotal($date, $userId){ 
	$connection = new createConn();
	$ssql = "SELECT sum(b.protein) as protein, sum(b.fat) as fat, sum(b.carbohydrate) as carb, 
			sum(case when a.category_id <> 4 then b.calories else -b.calories end) as cal
			FROM to_do_list a inner join to_do_list_dtl b on a.id = b.list_id 
			WHERE a.date = '" . $date . "' and a.user_id = " . $userId . ";"; 
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		$GLOBALS['ttlCarb'] = $dtl['carb'];
		$GLOBALS['ttlLip'] = $dtl['fat'];
		$GLOBALS['ttlPro'] = $dtl['protein'];
		$GLOBALS['ttlCal'] = $dtl['cal'];

		echo "<tr class='total info'>
			<th></th>
			<th>Grand Total</th>
			<th>" . $GLOBALS['ttlCarb'] . " Kalori</th>
			<th>" . $GLOBALS['ttlLip'] . " Kalori</th>
			<th>" . $GLOBALS['ttlPro'] . " Kalori</th>
			<th>" . $GLOBALS['ttlCal'] . " Kalori</th>
			<th colspan='2'></th>
		</tr>";
	}
	else{
		echo "<r class='total info'>
			<th></th>
			<th>Grand Total</th>
			<th>0 Kalori</th><th>0 Kalori</th><th>0 Calorie</th><th>0 Kalori</th>
			<th colspan='2'></th>
		</tr>";
	}
	mysqli_close($connection->myconn);
} 

function cekCompleted($tanggal, $userId){
	$connection = new createConn();
	$ssql = "SELECT sum(completed) as completed from to_do_list
			WHERE date = '" . $tanggal . "' and user_id = " . $userId . "
			GROUP BY user_id, date;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		if ($dtl['completed'] == 0)
			echo "<div>
			<form method='post' action='todolist/finish/".$tanggal."'>
				<input type='hidden' name='protein' value='".$GLOBALS['ttlPro']."'>
				<input type='hidden' name='carbohydrate' value='".$GLOBALS['ttlCarb']."'>
				<input type='hidden' name='lipid' value='".$GLOBALS['ttlLip']."'>
				<input type='hidden' name='calories' value='".$GLOBALS['ttlCal']."'>
				<input type='hidden' name='exercise' value='".$GLOBALS['ttlOther'][0]."'>
				<input type='hidden' name='drink' value='".$GLOBALS['ttlOther'][1]."'>
				<input type='hidden' name='sleep' value='".$GLOBALS['ttlOther'][2]."'>
				<button type='submit' id='finish'>Klik jika agenda kegiatan sudah selesai dilaksanakan</button>
			</form></div>";
		else{
			echo "<p>Sudah Selesai</p>";
		}
	}
	else{
		echo "<div>
			<form method='post' action='todolist/finish/".$tanggal."'>
				<input type='hidden' name='protein' value='".$GLOBALS['ttlPro']."'>
				<input type='hidden' name='carbohydrate' value='".$GLOBALS['ttlCarb']."'>
				<input type='hidden' name='lipid' value='".$GLOBALS['ttlLip']."'>
				<input type='hidden' name='calories' value='".$GLOBALS['ttlCal']."'>
				<input type='hidden' name='exercise' value='".$GLOBALS['ttlOther'][0]."'>
				<input type='hidden' name='drink' value='".$GLOBALS['ttlOther'][1]."'>
				<input type='hidden' name='sleep' value='".$GLOBALS['ttlOther'][2]."'>
				<button type='submit' id='finish' value='Klik jika agenda kegiatan sudah selesai dilaksanakan'
			</form></div>";
	}
	mysqli_close($connection->myconn);
}

function weight($tanggal, $userId, $userCal, $userPro, $userLip, $userCarb){
	$connection = new createConn();
	$ssql = "SELECT weight, round(protein_goal/3) as pro, round(carbohydrate_goal/3) as carb, round(fat_goal/3) as fat, 
			round(calories_goal/3) as cal, weight_goal
			from history where date = '" . $tanggal . "' and user_id = " . $userId . ";";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		echo "<div>
			<p>Berat anda adalah : " . $dtl['weight'] . " kg";
			if ($dtl['weight'] < $dtl['weight_goal'])
				echo " (Perlu diidealkan/dinaikkan menjadi " . $dtl['weight_goal'] . " kg)";
			else if ($dtl['weight'] > $dtl['weight_goal'])
				echo " Perlu diidealkan/diturunkan menjadi " . $dtl['weight_goal'] . " kg)";
		echo "</p>
			<p>Kebutuhan kalori anda dalam satu porsi makan : </p>
			<p>Kalori : " . $dtl['cal'] . " kal</p>
			<p>Protein : " . $dtl['pro'] . " kal</p>
			<p>Karbohidrat : " . $dtl['carb'] . " kal</p>
			<p>Lemak : " . $dtl['fat'] . " kal</p>
			<a href='todolist/reset/".$tanggal."' data-toggle='modal' class='weight'>Klik untuk reset semua</a><br>
			<a href='todolist/suggest/".$tanggal."'>Buat Daftar Rekomendasi Makanan</a></div>";
	}
	else{
		echo "<div><a href='#weight-modal' data-toggle='modal' class='weight'>Klik untuk tentukan berat badan anda hari ini</a></div>";
	}
	mysqli_close($connection->myconn);	
}

?>

<script type="text/javascript">
$(document).ready(function() {
	$('.detail').hide();
	$('.suggest').hide();
	$('.plan').hide();
	$('.sgthdr').hide();
	$('.detailsgt').hide();
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

	$('a.toggle-plan').click(function(){
	    $(this).parents('tr.plan').nextUntil('tr.suggest').slideToggle("100");
	    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
	});

	$('a.toggle-suggest').click(function(){
		$(this).parents('tr.suggest').nextUntil('tr.head').slideToggle(100);
	    $(this).parents('tr.suggest').next('tr.head').slideToggle(100);
	    $(this).find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
	    if ($(this).parents('tr.suggest').nextUntil('tr.sgthdr').find('i').hasClass('glyphicon-minus'))
				$(this).parents('tr.suggest').nextUntil('tr.sgthdr').find('i').toggleClass('glyphicon-minus').toggleClass('glyphicon-plus');	
	});

	$('a.choose').click(function(){
        if (confirm('Daftar akan Diganti dengan Saran yang Dipilih, Lanjutkan ?')) {
        	return true;
        }
        else{
        	return false;
        }
	});

    $("button.add").click(function(){
		//alert ($(this).attr('id'));
		$("#add-list-modal").on('show.bs.modal', function(e) {
			var listId = $(e.relatedTarget).data('list');
			var pro = $(e.relatedTarget).data('protein');
			var carb = $(e.relatedTarget).data('carb');
			var cal = $(e.relatedTarget).data('cal');
			var lip = $(e.relatedTarget).data('lip');
			$(e.currentTarget).find('input[name="listId"]').val(listId);
			$(e.currentTarget).find('input[name="pro"]').val(pro);
			$(e.currentTarget).find('input[name="carb"]').val(carb);
			$(e.currentTarget).find('input[name="cal"]').val(cal);
			$(e.currentTarget).find('input[name="lip"]').val(lip);
		});
		$("#exercise-modal").on('show.bs.modal', function(e) {
			var listId = $(e.relatedTarget).data('list');
			$(e.currentTarget).find('input[name="listId"]').val(listId);
		});
	});

	$("button.delete").click(function(){
	    if (confirm('Are you sure ?')) {
	        var listId = $(this).data('list');
		    $.ajax({
		        dataType: 'json',
		        type:'delete',
		        url: url + '/' + listId,
		    }).done(function(data){
		        alert('berhasil');
		        location.reload();
		    }); 
	    }
	});

	$("button.edit-act").click(function(){
		$("#act-modal").on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('kategori');
			var listId = $(e.relatedTarget).data('list');
			var category;
			var portion;
			var date = new Date();
			date = "<?php echo $date; ?>";
			if (id == 5){
				category = "minum";
				portion = $("#drink").val();
			}
			else{
				category = "tidur";
				portion = $("#sleep").val();
			}
			$(e.currentTarget).find('input[name="catId"]').val(id);
			$(e.currentTarget).find('input[name="listId"]').val(listId);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="category"]').val(category);
			$(e.currentTarget).find('input[name="portion"]').val(portion);
		});
	});

	$("a.reminder").click(function(){
		$("#reminder-modal").on('show.bs.modal', function(e){
			var id = $(e.relatedTarget).data('kategori');
			var date = new Date();
			var reminder;
			reminder = $(e.relatedTarget).text();
			if (reminder == "(Set Reminder)")
				reminder = "7:00:00";
			else if (reminder.length == 8)
				reminder = reminder.substr(1, 8);
			date = "<?php echo $date; ?>";
			$(e.currentTarget).find('input[name="catId"]').val(id);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="reminder"]').val(reminder);
		});
	});

	$("a.weight").click(function(){
		$("#weight-modal").on('show.bs.modal', function(e){
			var date = new Date();
			date = "<?php echo $date; ?>";
			$(e.currentTarget).find('input[name="date"]').val(date);
		});
	});
}); 
</script>