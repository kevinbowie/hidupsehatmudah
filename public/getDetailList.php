<?php
$id = $_GET['id'];
$html = "";
include '../resources/views/dbconfig.php';
$connection = new createConn();
$connection->connect();
$ssql3 = "select id, category_id from to_do_list where id = '".$id."'";
$result3 = mysqli_query($connection->myconn, $ssql3);
$cat = mysqli_fetch_array($result3);
if ($cat['category_id'] != 4){
	$ssql = "select id, list_id, cal_id, cal_title, protein, fat, carbohydrate, calories, portion, gram, unit_id
			from to_do_list_dtl where list_id = '" . $id . "';";
	$result = mysqli_query($connection->myconn, $ssql);
	$html = "<table class='table table-hover'>
		<tr>
			<th>Judul</th>
			<th class='text-right'>Kalori</th>
			<th class='text-right'>Lemak</th>
			<th class='text-right'>Protein</th>
			<th class='text-center'>Karbohidrat</th>
			<th class='text-right'>Porsi</th>
			<th class='text-center'>Satuan</th>
			<th class='text-right'>Gram</th>
		</tr>";
	if ($result->num_rows > 0){
		while($dtl=mysqli_fetch_array($result)){

			$ssql2 = "select b.id, b.unit_id, b.cal_id, a.satuan, b.gram, b.portion 
					from satuan a inner join satuan_dtl b on a.id = b.unit_id where b.cal_id = " . $dtl['cal_id'] . ";";
			$htmlPortion = "";
			$porsiId = "";
			$result2 = mysqli_query($connection->myconn, $ssql2);
			while ($porsi=mysqli_fetch_array($result2)){
				if ($dtl['unit_id'] == $porsi['unit_id']){
					$porsiId = $porsi['id'];
					$htmlPortion = $htmlPortion . "<option name='unitId[]' selected value='" . $porsi['id'] . "'>" . $porsi['satuan'] . "</option>";
				}
				else
					$htmlPortion = $htmlPortion . "<option name='unitId[]' value='" . $porsi['id'] . "'>" . $porsi['satuan'] . "</option>";
			}
			$htmlPortion = "<select class='form-control' name='satuan[]' style='width:100px;' autocomplete='off'>" . $htmlPortion . "</select>";

			$html = $html . "<tr>
				<td><input type='hidden' name=dtlId[] value='".$dtl['id'].":".$porsiId.":".$dtl['calories'].":".$dtl['fat'].":".$dtl['protein'].":".$dtl['carbohydrate'].":".$dtl['portion'].":".$dtl['gram']."'>".$dtl['cal_title']."</td>
				<td class='text-right'>".$dtl['calories']."</td>
				<td class='text-right'>".$dtl['fat']."</td>
				<td class='text-right'>".$dtl['protein']."</td>
				<td class='text-right'>".$dtl['carbohydrate']."</td>
				<td class='text-right'>
					<div class='form-group' id='porsi' style='width: 50px;'>
						<input type='text' name='porsi[]' value='".$dtl['portion']."' class='form-control input-small' autocomplete='off'>
					</div>
				</td>
				<td class='text-center'>".$htmlPortion."</td>
				<td class='text-right'>".$dtl['gram']."</td>
			</tr>";
		}
	}
	else{
		$html = $html . "<tr><td colspan='8'>Tidak Ada Data</td></tr>";
	}
	$html = $html . "</table>";
}
else{	
	$ssql = "select id, list_id, cal_id, cal_title, calories, portion
			from to_do_list_dtl where list_id = '" . $id . "';";
	echo "<table class='table table-hover'>
		<tr>
			<th>Judul</th>
			<th>Kalori</th>
			<th>Jam</th>
		</tr>";
	$result = mysqli_query($connection->myconn, $ssql);
	if ($result->num_rows > 0){
		while ($dtl=mysqli_fetch_array($result)){
			$id = $dtl['id'];
			$title = $dtl['cal_title']; 
			$cal = $dtl['calories'];
			$portion = $dtl['portion'];
			echo "<tr class='details'>
					<td><input type='hidden' name='dtlId[]' value='".$id.":".$cal.":".$portion."'>" . $title . "</td>
					<td class='col-sm-2'>" . $cal . "</td>
					<td class='col-sm-2'>
						<div class='form-group' style='width: 50px;'>
							<input type='text' name='porsiEx[]' value='".$portion."' class='form-control input-small' autocomplete='off'>
						</div>
					</td>
			</tr>";
		}
	}
	else{
		echo "<tr><td colspan='3'>Tidak Ada Data</td></tr>";
	}
	echo "</table>";
}
mysqli_close($connection->myconn); 
echo $html;
?>