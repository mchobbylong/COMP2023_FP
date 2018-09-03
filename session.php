<?php
	// All about SESSION


	require_once 'debug.php';
	require_once 'database.php';

	session_start();
	$session_uid = -1;
	$session_username = 'undefined';
	$session_isadmin = 0;
	if (isset($_SESSION['uid'])){
		$sql = "SELECT * FROM usertable WHERE uid = " . $_SESSION['uid'];
		$result = db_query($sql, 1);
		if ($result)
			if ($result->num_rows){
				$row = $result->fetch_assoc();
				$session_uid = $row['uid'];
				$session_username = $row['username'];
				$session_isadmin = $row['isadmin'];
			}
			else
				logout();
	}

	if (isset($_GET['action'])){
		switch ($_GET['action']){
			case 'logout':
				logout();
				break;
		}
	}

	function logout(){
		//logout and destroy this session
		$_SESSION = array();
		if (isset($_COOKIE[session_name()]))
			setcookie(session_name(), '', time() - 3600, '/');
		session_destroy();

		//return to the previous page
		$returnTo = "homepage.php";
		if (isset($_GET['returnTo'])) $returnTo = $_GET['returnTo'];
		header("Location: $returnTo");
	}
?>