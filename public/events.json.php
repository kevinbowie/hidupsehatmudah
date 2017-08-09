<?php
$db    = new PDO('mysql:host=localhost;dbname=hidup_sehat_mudah;charset=utf8', 'root', '');
$sql   = "SELECT a.id, a.user_id, a.category_id, sum(b.portion) AS portion, a.date 
		  FROM to_do_list a left join to_do_list_dtl b on a.id = b.list_id 
		  WHERE a.user_id = 10 group by a.date, a.category_id;";
$res = $db->query($sql);
$res->setFetchMode(PDO::FETCH_OBJ);
$out = array();
foreach($res as $row) {
	if ($row->category_id == 5 && is_null($row->portion))
		$class = 'event-warning';
	else
		$class = 'event-success';
  	$out[] = array(
	    'id' => $row->user_id,
	    'title' => $row->user_id,
	    'url' => '',
	    'class' => $class,
	    'start' => strtotime($row->date) . '000',
	    'end' => strtotime($row->date) .'000'
   );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;

?>