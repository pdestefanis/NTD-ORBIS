<?php

//for expansion this should perhaps be a singleton with a database factory and connection pooling
class dataBase {
	
	private $host = 'localhost';
	private $user = 'orbis_user';
	private $password = '7SvIfl';
	private $database = 'orbis';
	private $db;
	
	function __construct() {
		@ $this->db = new mysqli($this->host, $this->user, $this->password, $this->database);

		if (mysqli_connect_errno())
		{
			echo "Error: Could not connect to database. Please try again";
			exit;
		}
	}    

	function __destruct() {
		$this->db->close();
	}
	
	function query($sql) {
		$result = $this->db->query($sql);
		if (!$result)
			die ("DB_ERROR: " . $this->db->error . "\n" . $sql);
		return $result;
	}

}
?>