<?php 
include ('dbconfig.php');
date_default_timezone_set("Asia/Jakarta");
$date = isset($_POST['date']) ? date_format(date_create($_POST['date']), "Y-m-d") : date("Y-m-d");
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
$ttlOther[3] = 0;
$sleep = "";
$wakeup = "";
$kategori = array("Sarapan", "Makan Siang", "Makan Malam", "Olahraga", "Minum", "Tidur", "Bangun");
$sukses = "";
$msg = "";
$complete = false;

cekComplete($date, $userId);
sleephistory($date, $userId);
$ssql = "select category_id, category, id, remind, time, sleep_wakeup_time from to_do_list where date = '" . $date . "' 
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
					<th class="col-sm-2 text-center">Satuan</th>
					<th class="col-sm-1 text-center">Aksi</th>
				</tr> <?php

	while ($data=mysqli_fetch_array($result)){
		echo "<tr class='head' data-list='".$data['id']."'>
				<th>";
		if ($index <= 4){
			echo "<a class='btn btn-default btn-xs toggle-head'><i class='glyphicon glyphicon-plus'></i></a> ";
		}
		echo $kategori[$index - 1] . "</th>
		<td>";
		if (! $GLOBALS['complete']){
			echo "<button href='#reminder-modal' data-toggle='modal' data-kategori='" . $data['id'] . "' class='reminder btn btn-default'>";
			if ($data['remind'])
				echo $data['time'];
			else
				echo "Tentukan";
		}
		else{
			echo "Tidak ditentukan";
		}

		echo "</button></td>";
		if ($index <= 3){
			setTotal($data['id']);
			echo "<td class='text-center'>";

			if (! $GLOBALS['complete']){
				echo "<button class='btn btn-default btn-xs edit-detail' data-target='#edit-list-modal' data-toggle='modal' data-list='".$data['id']."'>UBAH</button>
				<button class='btn btn-default btn-xs add' style='width:60px;' data-target='#add-list-modal' data-list='". $data['id'] ."' data-toggle='modal' data-protein='".$totalPro."' data-carb='".$totalCarb."' data-lip='".$totalLip."' data-cal='".$totalCal."'>TAMBAH</button>";
			}

			echo "</td></tr>
			<tr class='plan'>
				<td colspan='7' style='padding-left: 30px;' class='toggle'>
					<a class='btn btn-default btn-xs toggle-plan'><i class='glyphicon glyphicon-plus'></i></a> AGENDA ANDA
				</td>
				<td class='text-center'>
					<button class='btn btn-default btn-xs save-detail' data-target='#save-list-modal' data-toggle ='modal' data-list='".$data['id']."'>SIMPAN</button>
				</td>
			</tr>";
			getDetails($userId, $date, $data['category_id'], 1);
			echo "<tr class='suggest'>
					<td colspan='8' style='padding-left: 30px;'>
						<a class='btn btn-default btn-xs toggle-suggest'><i class='glyphicon glyphicon-plus'></i></a> 
						SARAN
					</td>
				</tr>";
			food_recommended($userCal, $date, $data['category_id'], $data['id'], $userId);
		}
		else if ($index > 3){
			echo "<td></td><td></td><td></td>";
			setTotal1($data['id'], $index);
			switch ($index) {
				case 4:
					echo "<td class='text-center'>";
						if (! $GLOBALS['complete']){
							echo "<button class='btn btn-default btn-xs edit-detail' data-target='#edit-list-modal' data-toggle='modal' data-list='".$data['id']."'>UBAH</button>
							<button class='btn btn-default btn-xs add' style='width:60px;' data-target='#exercise-modal' data-list='". $data['id'] ."' data-toggle='modal'>TAMBAH</button>";
						}
						echo "</td>
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
					<tr class='sgthdr'>
						<td style='padding-left: 50px;'>BERJALAN</td>
						<td></td><td></td><td colspan='2'></td>
						<td>300 Kal</td>
						<td class='text-center'>0.5 Jam</td>
						<td></td>
					</tr>
					<tr class='head'></tr>";
					grandTotal($date, $userId);
					break;
				case 5:
					echo "<td class='text-center'>";			
					if (! $GLOBALS['complete']){
						echo "<button class='btn btn-default btn-xs edit-act' data-toggle='modal' data-target='#act-modal' data-list='" . $data['id'] . "' data-kategori='" . $data['category_id'] . "'>UBAH</button>";
					}
					echo "</td>
					</tr>";
					break;
				case 6:
					echo "<td class='text-center'>";
					if (! $GLOBALS['complete']){
							if ($GLOBALS['sleep'] == ""){ //muncul jika belum set jam tidur
								echo "<button class='btn btn-default btn-xs edit-act' data-toggle='modal' data-jenis='" . $kategori[$index - 1] . "' data-target='#sleep-modal' data-list='" . $data['id'] . "' data-kategori='" . $data['category_id'] . "'>UBAH</button>";
							}
					}
					echo "</td></tr>
					</tr>";
					break;
				default:
					echo "<td class='text-center'>";
					if (! $GLOBALS['complete']){ //muncul jika sudah set jam tidur
						if ($GLOBALS['sleep'] != ""){
							echo "<button class='btn btn-default btn-xs edit-act' data-toggle='modal' data-jenis='" . $kategori[$index - 1] . "' data-target='#sleep-modal' data-list='" . $data['id'] . "' data-kategori='" . $data['category_id'] . "'>UBAH</button>";
						}
					}
					echo "</td></tr>
					</tr>";
					break;
			}
		}
		$index++;
	}
	echo "</table>
	</div><br>";
	cekTercapai($userCal, $userCarb, $userPro, $userLip, $ttlCarb, $ttlLip, $ttlPro, $ttlOther);
} 
else
	echo "<h3 class='text-center'>Tidak Ada Data</h3>
		</table>
	</div>";
mysqli_close($connection->myconn);

function cekTercapai($userCal, $userCarb, $userPro, $userLip, $ttlCarb, $ttlLip, $ttlPro, $ttlOther){
	$msg = "";
	echo "<div class='well'>
		<p>Kalori Masuk : " . $userCal . " Kalori</p>
		<p>Karbohidrat : " . $userCarb . " Kalori"; 
			if (($userCarb - $ttlCarb >= -100) && ($userCarb - $ttlCarb <= 200)){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
				$msg = "Coba lebih perhatikan konsumsi karbohidrat";
			}
	echo "</p>
		<p>Lemak : " . $userLip . " Kalori";
			if (($ttlLip >= 100) && ($userLip - $ttlLip >= -100)){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
				if ($msg != "")
					$msg = $msg . ", Lemak"; 
				else 
					$msg = "Coba lebih perhatikan konsumsi lemak"; 
			}
	echo "</p>
		<p>Protein : " . $userPro . " Kalori"; 
			if (($userPro - $ttlPro >= -100) && ($userPro - $ttlPro <= 100)){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
				if ($msg != "")
					$msg = $msg . ", Protein"; 
				else 
					$msg = "Coba lebih perhatikan konsumsi protein"; 
			}
	echo "</p>
		<p>Olahraga";
			if ($ttlOther[0] >= 0.5){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
				if ($msg != "")
					$msg = $msg . "<br>Berolahragalah setiap hari minimal setengah jam (untuk aktivitas ringan) !"; 
				else 
					$msg = "Berolahragalah setiap hari minimal setengah jam (untuk aktivitas ringan) !"; 
			}
	echo "</p>
		<p>Minum";
			if ($ttlOther[1] >= 2){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
				if ($msg != "")
					$msg = $msg . "<br>Minumlah minimal 2 Liter air setiap hari !"; 
				else 
					$msg = "Minumlah minimal 2 Liter air setiap hari !"; 
			}
	echo "</p>
		<p>Tidur";
			$date1 = date_create($ttlOther[2]);
			$date2 = date_create($ttlOther[3]);
			$diff = date_diff($date1, $date2);
			if ($diff->format("%h") >= 6 && $diff->format("%h") <= 9){
				echo " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
			}
			else {
				echo " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"; 
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
	</div>
	<br>
	</div>";
}
function getDetails($userId, $date, $categoryId, $index){
	$connection = new createConn();
	$connection->connect();
	$ssql2 = "SELECT a.sleep_wakeup_time as rest, b.id, b.list_id, b.cal_title, b.protein, b.fat, b.carbohydrate, b.calories, b.portion, d.satuan,
			  b.gram
			  FROM to_do_list a left join to_do_list_dtl b on a.id = b.list_id
			  inner join satuan d on d.id = b.unit_id
			  where a.user_id = " . $userId . " and a.date = '" . $date . "' and 
			  a.category_id = " . $categoryId . " order by b.cal_title;";
	$result2 = mysqli_query($connection->myconn, $ssql2);
	while ($dtl=mysqli_fetch_array($result2)){
		if ($index == 1){
			echo "<tr class='detail'>
				<td colspan='2' style='padding-left: 50px;'>" . $dtl['cal_title'] . "</td>
				<td>" . round($dtl['carbohydrate']) . "</td>
				<td>" . round($dtl['fat']) . "</td>
				<td>" . round($dtl['protein']) . "</td>
				<td>" . round($dtl['calories']) . "</td>
				<td>" . number_format($dtl['portion'], 1, ".", "") . " " . $dtl['satuan'] . "</td>
				<td class='text-center'>";

				if (! $GLOBALS['complete']){
					echo "<button class='btn btn-default btn-xs delete' data-list='" . $dtl['id'] . "'>
					<i class='glyphicon glyphicon-remove'></i>";
				}
				echo "</td>
			</tr>";
		}
		else{
			echo "<tr class='detail'>
				<td style='padding-left: 50px;'>" . $dtl['cal_title'] . "</td>
				<td></td><td></td><td colspan='2'></td>
				<td>" . $dtl['calories'] . " Kal</td>
				<td class='text-center'>" . $dtl['portion'] . " Jam</td>
				<td class='text-center'>";
				if (! $GLOBALS['complete']){
					echo "<button class='btn btn-default btn-xs delete' data-list='" . $dtl['id'] . "'>
					<i class='glyphicon glyphicon-remove'></i>";
				}
				echo "</td>
			</tr>";
		}
	}
	mysqli_close($connection->myconn); 
}

function food_recommended($UCalories, $date, $index, $listId, $userId){
	$connection = new createConn();
	$caloriePortion = $UCalories / 3;
	$i = 1;
	$count = 1;
	$ssql = "SELECT a.id, a.gram, a.carbohydrate, a.protein, a.fat, a.cal_title as title, a.calories, a.cal_id, a.portion, c.satuan
			 FROM recommended a inner join to_do_list b on a.list_id = b.id inner join satuan c on c.id = a.unit_id
			 where b.date = '" . $date . "' and b.category_id = " . $index . " and user_id = '". $userId . "' order by a.id;";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($dtl=mysqli_fetch_array($result)){
			if ($count == 1){
				echo "<tr class='sgthdr'>
					<td colspan='8' style='padding-left: 30px;' class='toggle'>";
					if (! $GLOBALS['complete']){
						echo "<a class='btn btn-default btn-xs choose' href='todolist/rekom/".$listId."/".$dtl['id']."'>Pilih</a>";
					}
					echo "SARAN KE- " . $i . "</td>
				</tr>";
				$total = array(0, 0, 0, 0);
				$i++;
			}
			echo "<tr class='detailsgt'>
				<td colspan='2' style='padding-left: 50px;'>" . $dtl['title'] . "</td>
				<td class='text-right'>" . round($dtl['carbohydrate']) . "</td>
				<td class='text-right'>" . round($dtl['fat']) . "</td>
				<td class='text-right'>" . round($dtl['protein']) . "</td>
				<td class='text-right'>" . round($dtl['calories']) . "</td>
				<td class='text-center'>" .  number_format($dtl['portion'], 1, ".", "") . " " . $dtl['satuan'] . "</td>
				<td></td>
			</tr>";
			if ($count == 5){
				$total[0] += round($dtl['carbohydrate']);
				$total[1] += round($dtl['fat']);
				$total[2] += round($dtl['protein']);
				$total[3] += round($dtl['calories']);
				echo "<tr class='totalsgt'>
					<td colspan='2' style='padding-left: 50px;'><b>TOTAL</b></td>
					<td class='text-right'><b>".$total[0]."</b></td>
					<td class='text-right'><b>".$total[1]."</b></td>
					<td class='text-right'><b>".$total[2]."</b></td>
					<td class='text-right'><b>".$total[3]."</b></td>
					<td colspan='2'></td>
				</tr>";
				$count = 1;
			}
			else{
				$total[0] += round($dtl['carbohydrate']);
				$total[1] += round($dtl['fat']);
				$total[2] += round($dtl['protein']);
				$total[3] += round($dtl['calories']);
				$count++;
			}
		}
	}
	mysqli_close($connection->myconn); 
} 

function setTotal($listId){ 
	$connection = new createConn();
	$ssql = "SELECT sum(protein) as protein, sum(carbohydrate) as carb, sum(fat) as fat 
			FROM `to_do_list_dtl` WHERE list_id = " . $listId . " order by cal_title;"; 
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	$totalCal = 0;
	$totalCarb = 0;
	$totalLip = 0;
	$totalPro = 0;
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		echo "<td>" . round($dtl['carb']) . "</td>
			<td>" . round($dtl['fat']) . "</td>
			<td>" . round($dtl['protein']) . "</td>
			<td>" . (round($dtl['carb']) + round($dtl['fat']) + round($dtl['protein'])) . "</td>
			<td></td>";
		$totalCal += $dtl['carb'] + $dtl['fat'] + $dtl['protein'];
		$totalCarb += round($dtl['carb']);
		$totalLip += round($dtl['fat']);
		$totalPro += round($dtl['protein']);
	}
	else{
		echo "<td>0</td><td>0</td><td>0</td><td>0</td><td></td>";
	}
	mysqli_close($connection->myconn);
} 

function setTotal1($listId, $index){ 
	$connection = new createConn();
	if ($index <= 5)
		$ssql = "SELECT sum(calories) as calorie, sum(portion) as portion
				FROM `to_do_list_dtl` WHERE list_id = " . $listId . ";"; 
	else
		$ssql = "SELECT sleep_wakeup_time FROM to_do_list WHERE id = " . $listId . ";";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		switch ($index) {
			case 4:
				$GLOBALS['ttlOther'][0] = $dtl['portion'];
				echo "<td>" . round($dtl['calorie']) . "</td>
					<td>" . $dtl['portion'] . " Jam</td>";
				break;
			case 5:
				$GLOBALS['ttlOther'][1] = $dtl['portion'];
				echo "<td></td>
					<td>" . $dtl['portion'] . " Liter</td>";
				break;
			default:
				//$GLOBALS['ttlOther'][2] = $dtl['portion'];
				if ($index == 6)
					$GLOBALS['ttlOther'][2] = $dtl['sleep_wakeup_time'];
				else
					$GLOBALS['ttlOther'][3] = $dtl['sleep_wakeup_time'];
				if (! is_null($dtl['sleep_wakeup_time']))
					$time = date_format(date_create($dtl['sleep_wakeup_time']), "d-m-Y H:i:s");
				else
					$time = "";
				echo "<td></td>
					<td>" . $time . "</td>";
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
		$GLOBALS['ttlCarb'] = round($dtl['carb']);
		$GLOBALS['ttlLip'] = round($dtl['fat']);
		$GLOBALS['ttlPro'] = round($dtl['protein']);
		$GLOBALS['ttlCal'] = round($dtl['cal']);

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

function weight($tanggal, $userId, $userCal, $userPro, $userLip, $userCarb){
	$connection = new createConn();
	$ssql = "SELECT weight, round(protein_goal/3) as pro, round(carbohydrate_goal/3) as carb, round(fat_goal/3) as fat, 
			round(calories_goal/3) as cal, weight_goal
			from history where date = '" . $tanggal . "' and user_id = " . $userId . ";";
	// echo $ssql;
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		$dtl=mysqli_fetch_array($result);
		echo "<div>
			<p>Berat anda adalah : " . $dtl['weight'] . " kg";
			if ($dtl['weight'] < $dtl['weight_goal'])
				echo " (Perlu dinaikkan menjadi " . $dtl['weight_goal'] . " kg)";
			else if ($dtl['weight'] > $dtl['weight_goal'])
				echo " (Perlu diturunkan menjadi " . $dtl['weight_goal'] . " kg)";
		echo "</p>
			<p>Kebutuhan kalori anda dalam satu porsi makan : </p>
			<p>Kalori : " . $dtl['cal'] . " kal</p>
			<p>Protein : " . $dtl['pro'] . " kal</p>
			<p>Karbohidrat : " . $dtl['carb'] . " kal</p>
			<p>Lemak : " . $dtl['fat'] . " kal</p>";
			if (! $GLOBALS['complete']){
				echo "<a href='todolist/reset/".$tanggal."' data-toggle='modal' class='weight'>Reset semua</a><br>
				<a href='todolist/suggest/".$tanggal."'>Buat Daftar Rekomendasi Makanan</a></div>";
			}
			else{
				echo "<h3>AGENDA SUDAH SELESAI</h3>";
			}
	}
	else{
		echo "<div style='margin-bottom: 10px;'><button href='#weight-modal' data-toggle='modal' class='weight btn btn-default'>Tentukan berat badan anda hari ini</button></div>";
	}
	mysqli_close($connection->myconn);	
}

function sleephistory($tanggal, $userId){
	$connection = new createConn();
	$ssql ="select wakeup_time, sleep_time from history where date = '" . $tanggal . "' and user_id = '" . $userId . "'";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	$data = mysqli_fetch_array($result);
	if (! is_null($data['sleep_time']))
		$GLOBALS['sleep'] = $data['sleep_time'];
	if (! is_null($data['wakeup_time']))
		$GLOBALS['wakeup'] = $data['wakeup_time'];
	mysqli_close($connection->myconn);
}

function cekComplete($tanggal, $userId){
	$connection = new createConn();
	$ssql = "select sum(completed) as complete from to_do_list where date = '" . $tanggal . "' and user_id = '" . $userId . "'";
	$connection->connect();
	$result = mysqli_query($connection->myconn, $ssql);
	$data = mysqli_fetch_array($result);
	if ($data['complete'] > 0)
		$GLOBALS['complete'] = true;
	else
		$GLOBALS['complete'] = false;
	mysqli_close($connection->myconn);
}
?>

<script type="text/javascript">
function validasiForm(){
	var kategori = $("#sleep-modal").find('input[name="category"]').val();
	var hour = $("#sleep-modal").find('input[name="hour"]').val();
	hour = new Date(hour);
	if (kategori == "Tidur"){
		var newDate = new Date("<?php echo "20".$date; ?>");
		newDate.setHours(0);
		newDate.setMinutes(0);
		newDate.setSeconds(0);
	}
	else
		var newDate = new Date("<?php echo $sleep; ?>");
	if (hour.getTime() <= newDate.getTime()){
		alert('Waktu yang ditentukan tidak tepat');
		return false;
	}
	else{
		return true;
	}
}

$(document).ready(function() {
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });

	for(i=0;i<4;i++){
		if(! $('tr.head:eq('+i+')').next('tr.plan').next('tr.detail').length > 0){
			$('tr.head:eq('+i+')').next('tr.plan').hide();
			$('tr.head:eq('+i+')').next('tr.plan').next('.detail').hide();
	    	$('tr.head:eq('+i+')').nextUntil('tr.suggest').next('tr.suggest').hide();
		}
		else{
	    	$('tr.head:eq('+i+')').nextUntil('tr.suggest').show();
	    	$('tr.head:eq('+i+')').nextUntil('tr.suggest').next('tr.suggest').show();
			$('tr.head:eq('+i+')').next('tr.plan').find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
			$('tr.head:eq('+i+')').find('i').toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');
		}
	}

	$('.sgthdr').hide();
	$('.detailsgt').hide();
	$('.totalsgt').hide();
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
	    if ($(this).parents('tr.suggest').next('tr.sgthdr').length > 0){
			$(this).parents('tr.suggest').nextUntil('tr.head').slideToggle(100);
		    $(this).parents('tr.suggest').next('tr.head').slideToggle(100);
		}
		else{
			alert("Anda belum membuat daftar rekomendasi makanan !");
		}
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

	$("button.edit-detail").click(function(){
		$("#edit-list-modal").on('show.bs.modal', function(e){
			var elem = $(this);
			var loc = $(e.currentTarget).find('div#tableEdit');
			var id = $(e.relatedTarget).data('list');
			$(e.currentTarget).find('input[name="listId"]').val(id);
			$.ajax({ 
				type: "GET",
				url: "getDetailList.php",
				data: {id : id},
		        context: this,
		        success: function(response){
			        loc.html(response);

					$('input[name="porsiEx[]"]').on('focusin', function(){
							$(this).data('valExDtl', $(this).val());
					});

					$('input[name="porsiEx[]"]').on('change', function(){
						var prev = $(this).data('valExDtl');
						var current = $(this).val();
						var tr = $(this).parent().parent().parent();
						var cal = tr.children("td:eq(1)").text();
						if (! isNaN($(this).val())){
							var prevData = tr.children("td:eq(0)").find('input').val();
							var obj = prevData.split(":");
							var cal = Math.round(cal / prev * current); 
							tr.children("td:eq(1)").text(cal);
							var currData = tr.children("td:eq(0)").find('input').val(obj[0] + ':' + cal + ':' + current);
						}
						else{
							alert('harap diisi dalam format angka !');
							$(this).focus();
						}
					});


					$('input[name="porsi[]"]').on('focusin', function(){
							$(this).data('valDtl', $(this).val());
					});

					$('input[name="porsi[]"]').on('change', function(){
						var prev = $(this).data('valDtl');
						var current = $(this).val();
						var loc = $(this).parent().parent().parent();
						var cal = loc.children("td:eq(1)").text();
						var fat = loc.children("td:eq(2)").text();
						var pro = loc.children("td:eq(3)").text();
						var carb = loc.children("td:eq(4)").text();
						var gram = loc.children("td:eq(7)").text();
						if (! isNaN($(this).val())){
							fat = Math.round(fat / prev * current);
							pro = Math.round(pro / prev * current);
							carb = Math.round(carb / prev * current);
							gram = Math.round(gram / prev * current);
							cal = fat + pro + carb;
							loc.children("td:eq(1)").text(cal); //cal
							loc.children("td:eq(2)").text(fat); //fat
							loc.children("td:eq(3)").text(pro); //pro
							loc.children("td:eq(4)").text(carb); //carb
							loc.children("td:eq(7)").text(gram); //gram

					        var prevData = loc.children("td:eq(0)").find('input').val();
					        var obj = prevData.split(":");
					        var currData = loc.children("td:eq(0)").find('input').val(obj[0] + ':' + obj[1] + ":" + cal + ':' + fat + 
					        ':' + pro + ':' + carb + ':' + current + ':' + gram);
						}
						else{
							alert('harap diisi dalam format angka !');
							$(this).focus();
						}
					});

			        $('select[name="satuan[]"]').on('change', function(){
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
						        //update value untuk dikirim ke controller
						        var prevData = tr.children("td:eq(0)").find('input').val();
						        var obj = prevData.split(":");
						        var currData = tr.children("td:eq(0)").find('input').val(obj[0] + ':' + unitId + ':' + json.cal + ':' + json.fat + ':' + json.pro + ':' + json.carb + ':1:' + json.gram);

						        var cal = tr.children("td:eq(1)").text(json.cal);
						        var fat = tr.children("td:eq(2)").text(json.fat);
						        var pro = tr.children("td:eq(3)").text(json.pro);
						        var carb = tr.children("td:eq(4)").text(json.carb);
						        var port = tr.children("td:eq(5)").find('input[name="porsi"]').val(1);
						        var gram = tr.children("td:eq(7)").text(json.gram);
					    	}
					    });
					});
		    	}
		    });
		});
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
			category = "minum";
			portion = $("#drink").val();
			$(e.currentTarget).find('.page-header').children('h2').text("Liter Minum");
			$(e.currentTarget).find('#porsi').children('label').text("Liter");
			$(e.currentTarget).find('input[name="catId"]').val(id);
			$(e.currentTarget).find('input[name="listId"]').val(listId);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="category"]').val(category);
			$(e.currentTarget).find('input[name="portion"]').val(portion);
		});
		$("#sleep-modal").on('shown.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('kategori');
			var listId = $(e.relatedTarget).data('list');
			var jenis = $(e.relatedTarget).data('jenis');
			var category;
			var portion;
			var date = new Date();
			date = "<?php echo $date; ?>";
			var d = new Date();
			var curr_hour = d.getHours();
			var curr_min = d.getMinutes();
			var curr_sec = d.getSeconds();
			var curr_date = d.getDate();
			var curr_month = d.getMonth()+1;
			var curr_year = d.getFullYear();

			var getTime = curr_date + "-" + curr_month + "-" + curr_year + " " + curr_hour + ":" + curr_min + ":" + curr_sec; 

			$('.form_datetime').each(function() {
			    var minDate = new Date("<?php echo $date; ?>");
			    minDate.setHours(0);
			    minDate.setMinutes(0);
			    minDate.setSeconds(0,0);

			    var $picker = $(this);
			    $picker.datetimepicker();
			    var pickerObject = $picker.data('datetimepicker');

			    $picker.on('changeDate', function(ev){
			        if (ev.date.valueOf() < minDate.valueOf()){
			            // Handle previous date
			            <!-- alert('Nope'); -->
			            pickerObject.setValue(minDate);
			            
			            // And this for later versions (in case)
			            ev.preventDefault();
			            return false;
			        }
			    });
			});

			portion = $("#sleep").val();
			$(e.currentTarget).find('.page-header').children('h2').text("Jam " + jenis);
			$(e.currentTarget).find('input[name="catId"]').val(id);
			$(e.currentTarget).find('input[name="listId"]').val(listId);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="category"]').val(jenis);
			$(e.currentTarget).find('input[name="portion"]').val(portion);
			$(e.currentTarget).find('input[name="getTime"]').val(getTime);
		});
	});

	$("button.save-detail").click(function(){
		$("#save-list-modal").on('show.bs.modal', function(e){
			var id = $(e.relatedTarget).data('list');
			$(e.currentTarget).find('input[name="id"]').val(id);
		});
	});

	$("a.reminder").click(function(){
		$("#reminder-modal").on('show.bs.modal', function(e){
			var id = $(e.relatedTarget).data('kategori');
			var date = new Date();
			var reminder;
			reminder = $(e.relatedTarget).text();
			date = "<?php echo $date; ?>";
			$(e.currentTarget).find('input[name="catId"]').val(id);
			$(e.currentTarget).find('input[name="date"]').val(date);
			$(e.currentTarget).find('input[name="reminder"]').val("00:00:00");
		});
	});

	$("button.weight").click(function(){
		$("#weight-modal").on('show.bs.modal', function(e){
			var date = new Date();
			date = "<?php echo $date; ?>";
			$(e.currentTarget).find('input[name="date"]').val(date);
		});
	});
}); 
</script>