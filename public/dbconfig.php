<?php
class createConn{
	var $host = 'localhost';
	var $username = 'root';
	var $password = '';
	var $db = 'hidup_sehat_mudah';
	var $myconn;

	function connect(){
		$conn = mysqli_connect($this->host, $this->username, $this->password, $this->db);
		if (!$conn)
			die("Cannot connect to database!");
		else 
			$this->myconn = $conn;
		return $this->myconn;
	}

	function close(){
		mysqli_close($myconn);
	}
}
?>