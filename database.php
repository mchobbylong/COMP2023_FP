<?php
	// Here are all the operations using database


	// Set global variables
	$db_server = 'localhost';
	$db_username = '';
	$db_pwd = '';
	$db_name = '';

	function db_getconn(){
		$conn = new mysqli($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_pwd'], $GLOBALS['db_name']);
		if ($conn->connect_error)
			die('Database - Connection failed: ' . $conn->connect_error);
		return $conn;
	}

	function db_query($sql, $errorAct){
		$conn = db_getconn();
		$result = $conn->query($sql);
		if ($result == FALSE){
			$errorMsg = 'Database - Query failed: ' . $conn->error;
			switch ($errorAct){
				case 0:
					die($errorMsg);
				case 1:
					console($errorMsg);
					break;
				case 2:
					echo $errorMsg;
					break;
			}
			return NULL;
		}
		return $result;
	}
?>