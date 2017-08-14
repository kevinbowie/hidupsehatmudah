<?php 
$date = isset($_POST['date']) ? $_POST['date'] : NULL;
$userId = $_POST['userId'];
$ssql = "select a.id, c.id as listId, a.category, c.cal_title, c.portion, d.protein, d.fat, d.carbohydrate, d.calorie ";
$ssql = $ssql . "from category a left join to_do_list b on a.id = b.category_id ";
$ssql = $ssql . "left join to_do_list_dtl c on b.id = c.list_id ";
$ssql = $ssql . "left join calories_list_dtl d on c.cal_id = d.id ";
$ssql = $ssql . "where b.date = " . $date . " and b.user_id = " . $userId . " ";
$ssql = $ssql . "order by a.id;";
dataBangun($date);
$result = mysqli_query($connection->myconn, $ssql);

if ($result->num_rows > 0){
	$i = 0;
	$kategori = array();
	while ($data=mysqli_fetch_array($result)){
		if (!in_array($data['category'], $kategori)){
			array_push($kategori, $data['category']);
			if($data['id'] > 4){ 
				echo "<tr id='kat" . $data['id'] . "'>
						<th valign='top'>" . $data['category'] . "</th>
						<td colspan='3'>
							<input type='text' value='' class='form-control' id='" . $data['category'] . "'>
							<button class='btn btn-primary edit-act' data-toggle='modal' data-target='#act-modal' data-kategori='" . $data['id'] . "'><i class='glyphicon glyphicon-edit'></i>
							</button>
						</td>
					</tr>");
			}
			else{
				echo "<tr id='kat" . $data['id'] . "'>
						<th valign='top'>" . $data['category'] . "</th>
						<td>
							<ul style='list-style-type:none'><input type='hidden' name='idList[]'></ul>
						</td>
						<td>
							<ul style='list-style-type:none'></ul>
						</td>
						<td>
							<ul style='list-style-type:none'></ul>
						</td>
						<td>
							<ul style='list-style-type:none'></ul>
						</td>
						<td>
							<ul style='list-style-type:none'></ul>
						</td>
						<td>";
					if ($data['id'] == 4){
						echo "<button class='btn btn-primary add' data-toggle='modal' data-target='#exercise-modal' data-kategori='" . $data['id'] . "'><i class='glyphicon glyphicon-plus'></i>";
					}
					else{
						echo "<button class='btn btn-primary add' data-toggle='modal' data-target='#add-list-modal' data-kategori='" . $data['id'] . "'><i class='glyphicon glyphicon-plus'></i>";
					}
						echo "</button>
						</td>
					</tr>";
			}
		}

		if ($data['id'] >= 0 && $data['id'] < 4){ ?>
			<script type="text/javascript">
				$("table tr#kat" + <? echo $data['id']; ?> + " td:eq(0) ul").append("<li>" + <? echo $data['cal_title']; ?> + "<button class='btn btn-primary edit' data-kategori='" + <? echo $data['listId']; ?> + "'><i class='glyphicon glyphicon-remove'></i></button></li>");
				$("table tr#kat" + <? echo $data['id']; ?> + " td:eq(1) ul").append("<li>" + <? echo $data['protein']; ?> + "</li>");
				$("table tr#kat" + <? echo $data['id']; ?> + " td:eq(2) ul").append("<li>" + <? echo $data['fat']; ?> + "</li>");
				$("table tr#kat" + <? echo $data['id']; ?> + " td:eq(3) ul").append("<li>" + <? echo $data['carbohydrate']; ?> + "</li>");
				$("table tr#kat" + <? echo $data['id']; ?> + " td:eq(4) ul").append("<li>" + <? echo $data['calorie']; ?> + "</li>");
			</script> <?php
		}
		else{ ?>
			<script type="text/javascript">
				$("input#" + <? echo $data['category']; ?>).val(<? echo $data['portion']; ?>);
			</script> <?php
		}
	}
}
else{
	echo "data tidak ditemukan";
}
?>