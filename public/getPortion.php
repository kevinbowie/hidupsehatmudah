<?php
$idUnit = $_GET['idUnit'];
include '../resources/views/dbconfig.php';
$ssql = "select b.id, b.unit_id, b.cal_id, a.satuan, b.gram, b.portion, c.protein, c.fat, c.carbohydrate, c.bdd 
		from satuan a inner join satuan_dtl b on a.id = b.unit_id 
		inner join calories_list_dtl c on c.id = b.cal_id where b.id = " . $idUnit . ";";
$connection = new createConn();
$connection->connect();
$result = mysqli_query($connection->myconn, $ssql);
$porsi=mysqli_fetch_array($result);
$gram = round($porsi['gram'] / $porsi['portion']);
$protein = $porsi['protein'];
$lipid = $porsi['fat'];
$carbo = $porsi['carbohydrate'];
$bdd = $porsi['bdd'];
$carb = round(($bdd / 100) * ($gram / 100) * $carbo * 4);
$pro = round(($bdd / 100) * ($gram / 100) * $protein * 4);
$lip = round(($bdd / 100) * ($gram / 100) * $lipid * 9); 
$cal = $carb + $pro + $lip;
$data = array(
	"carb"=>$carb,
	"pro"=>$pro,
	"fat"=>$lip,
	"cal"=>$cal,
	"gram"=>$gram
);
mysqli_close($connection->myconn); 
echo (json_encode($data));
flush();
?>