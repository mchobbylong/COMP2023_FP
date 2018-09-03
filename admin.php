<?php
	// Include other php codes as header
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	require_once 'cake.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie
	date_default_timezone_set("Asia/Shanghai");

	// Get the sort/filter parameters
	$sortBy = 'id';
	$filter = $action = $action_value = '';
	if (isset($_GET['sortBy'])) $sortBy = $_GET['sortBy'];
	if (isset($_GET['filter'])) $filter = $_GET['filter'];
	if (isset($_GET['action'])) $action = $_GET['action'];
	if (isset($_GET['action_value'])) $action_value = $_GET['action_value'];

	// If there is an action then execute it
	if (!empty($action)){
		switch ($action){
			case 'status': order_change_status($action_value); break;
			case 'delete': order_delete($action_value); break;
		}
		header('Location: admin.php?sortBy=' . $sortBy . '&filter=' . $filter);
		die(0);
	}

	// Get all orders and sort/filter them
	$sql = "SELECT id, booking.uid, caketype, cakesize, topping, giftcard, message, cost, time, status FROM booking, usertable WHERE booking.uid = usertable.uid";
	if (substr($sortBy, 0, 1) == '.'){
		$class = substr($sortBy, 1);
		$text = $filter;
		if ($class == 'city') $text = "'$filter'";
		switch ($class){
			case 'uid':
			case 'city':
				$sql .= " AND usertable.$class = $text";
				break;
			case 'status':
				$sql .= " AND booking.$class = $text";
				break;
		}
	}
	else {
		$orderby = 'ASC';
		$class = $sortBy;
		if (substr($sortBy, 0, 1) == '-'){
			$orderby = 'DESC';
			$class = substr($sortBy, 1);
		}
		$sql .= " ORDER BY $class $orderby";
	}
	$orders = db_query($sql, 0);	// 0 means die() if an error occurs



	function order_change_status($id){	// Change the status of an order
		$sql = "SELECT * FROM booking WHERE id = $id";
		$result = db_query($sql, 0);
		if ($result->num_rows){
			$row = $result->fetch_assoc();
			$sql = "UPDATE booking SET status = " . (($row['status'] + 1) % 3) . " WHERE id = $id";
			db_query($sql, 0);
		}
	}

	function order_delete($id){	// Delete an order
		$sql = "DELETE FROM booking WHERE id = $id";
		db_query($sql, 0);
	}

	function get_user_by_uid($uid){	// Get the row of specific user in database
		$sql = "SELECT * FROM usertable WHERE uid = $uid";
		$result = db_query($sql, 0);
		if ($result)
			return $result->fetch_assoc();
		return NULL;
	}

	function get_status($status){	// Return the string of status
		$arr = array('Pending', 'Delievering', 'Completed');
		return $arr[$status];
	}

	function placeSortIcon($positive, $inverted){	//Place an icon that sort data by clicking
		$sortBy = $GLOBALS['sortBy'];

		$new_sortBy = $positive;
		if ($sortBy == $positive) $new_sortBy = $inverted;
		echo '<span onclick="window.location.href = \'admin.php?sortBy=' . $new_sortBy . '\'" class="label label_icon ';
		
		if ($sortBy == $positive) echo 'label-primary"><span class="glyphicon glyphicon-arrow-up">';
		else if ($sortBy == $inverted) echo 'label-primary"><span class="glyphicon glyphicon-arrow-down">';
		else echo 'label-default"><span class="glyphicon glyphicon-resize-vertical">';
		
		echo "</span></span>\n";
	}

	function placeFilter(){	//Place a normal filter to be clicked
		echo '<span onclick="window.location.href = \'admin.php\'" class="label label_text label-primary">' . $GLOBALS['filter'] . ' <span class="glyphicon glyphicon-remove"></span></span>';
	}
	
	function placeUid($uid, $text){	//Place an uid label to filter the data
		echo '<span onclick="window.location.href = \'admin.php?sortBy=.uid&filter=' . $uid . '\'" class="label label_text label_info label-default">' . $text . '</span>';
	}

	function placeCity($city){	//Place a city label to filter the data
		echo '<span onclick="window.location.href = \'admin.php?sortBy=.city&filter=' . $city . '\'" class="label label_text label_info label-default">' . $city . '</span>';
	}

	function placeStatus($id, $value){	//Place a status label that could change the status in database
		echo '<span onclick="window.location.href = \'admin.php?sortBy=' . $GLOBALS['sortBy'] . '&filter=' . $GLOBALS['filter'] . '&action=status&action_value=' . $id . '\'" class="label label_text label_status ';
		switch ($value){
			case 0:
				echo 'label-warning">Pending</span>';
				break;
			case 1:
				echo 'label-info">Delivering</span>';
				break;
			case 2:
				echo 'label-success">Completed</span>';
				break;
		}
	}

	function placeViewLabel($row){
		//Unfinished
	}

	function placeDelete($id){	// Place a delete label to delete an order
		echo '<span onclick="window.location.href = \'admin.php?sortBy=' . $GLOBALS['sortBy'] . '&filter=' . $GLOBALS['filter'] . '&action=delete&action_value=' . $id . '\'" class="label label_icon label_bigfont label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
	}
?>

<html>
<head>
	<link rel="stylesheet" href="main.css" >
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" >	<!-- Bootstrap -->
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta charset="utf-8">
	<title>WMCake Administration</title>

	<!-- rewrite bootstrap style -->
	<style>
		body{
			background: url(back_1.jpg);
			margin: 0;
		}

		a{
			color: blue;
		}

		.nav{
			height: 60px;
		}

		.container{
			min-width: 1000px;
		}

		.label_text{
			display: inline-block;
			font-size: 85%;
		}
		
		.label_icon{
			padding: .3em .4em .3em .3em;
			line-height: inherit;
			font-size: 65%;
		}

		.label_info, .label_status{
			font-size: 95%;
			font-weight: inherit;
		}

		.label_info{
			color: black;
		}

		.label-default{
			background-color: lightgrey;
		}

		.label_bigfont{
			font-size: 75%;
		}

		.glyphicon{
			line-height: inherit;
		}
	</style>
</head>
<body>

<!--set for the navigation bar-->
	<nav>
		<div class="nav">
			<a href="homepage.php"><img src="logo.png" class="logo"></a>
			<a class="nav_text_left" href="buy.php"><span>Place An Order</span></a>
			<a class="nav_text_left" href="homepage.php#extra_link"><span>Extra Link</span></a>
			<a class="nav_text_left" href="contact.php"><span>Contact Us</span></a>
<!--check for the login-->
			<?php
				if ($session_uid > -1){
					echo '<a class="nav_text_right" href="session.php?action=logout&returnTo=' . $_SERVER['PHP_SELF'] . '"><span>Logout</span></a>';
					if ($session_isadmin)
						echo '<a class="nav_text_right" href="admin.php"><span>Admin</span></a>';
					echo '<span class="nav_text_right">Welcome, ' . $session_username . '!</span>';
				}
				else {
					echo '<a class="nav_text_right" href="login.php?returnTo=' . $_SERVER['PHP_SELF'] . '"><span>Login</span></a>';
					echo '<a class="nav_text_right" href="registration.php"><span>Register</span></a>';
				}
			?>
		</div>
	</nav>

	<div class="container">
		<center><h1 class="center-box" style="padding-top: 20px; padding-bottom: 20px;">WMCake Administration</h1></center>
		<?php
			if (!$session_isadmin){
				echo '<div class="alert alert-danger" role="alert"><strong>You are not administrators!</strong> Please <a href="login.php?returnTo=admin.php">login</a> as administrators to continue.</div></div></body>';
				die();
			}
		?>
		<table class="table table-striped">
			<tr>
				<th># <?php placeSortIcon('id', '-id'); ?></th>
				<th>Order Time <?php placeSortIcon('time','-time'); ?></th>
				<th>User # <?php
					if ($sortBy == '.uid') placeFilter();
					else placeSortIcon('uid', '-uid');
				?></th>
				<th>Customer Name</th>
				<th>City <?php
					if ($sortBy == '.city') placeFilter();
				?></th>
				<th>Cake Type</th>
				<th>Cake Size</th>
				<th>Cost</th>
				<th>Status <?php	// Here place a status label to filter the data
					$new_filter = 0;
					if ($sortBy != '.status') $new_filter = 0;
					else $new_filter = ($filter + 1) % 3;
					
					echo '<span onclick="window.location.href = \'admin.php?sortBy=.status&filter=' . $new_filter . '\'" class="label label_text ';
					if ($sortBy != '.status') echo 'label-default">Filter</span>';
					else echo 'label-primary">' . get_status($filter) . '</span>';
				?></th>
				<th>Action</th>
			</tr>
			<?php
				while ($row = $orders->fetch_assoc()){	// Output the data
					$userinfo = get_user_by_uid($row['uid']);
					if ($userinfo == NULL)
						$userinfo = array('uid'=>'', 'firstname'=>'(Not found)', 'familyname'=>'', 'city'=>'(Not found)');

					echo '<tr>';
					echo '<td>' . $row['id'] . '</td>';
					echo '<td>' . date("Y-m-d H:i:s", $row['time']) . '</td>';
					echo '<td>';  placeUid($userinfo['uid'], $userinfo['uid']); echo '</td>';
					echo '<td>';  placeUid($userinfo['uid'], $userinfo['firstname'] . ' ' . $userinfo['familyname']); echo '</td>';
					echo '<td>';  placeCity($userinfo['city']); echo '</td>';
					echo '<td>' . get_cake_type($row['caketype']) . '</td>';
					echo '<td>' . get_cake_size($row['cakesize']) . '</td>';
					echo '<td>' . '¥' . $row['cost'] . '</td>';
					echo '<td>';  placeStatus($row['id'], $row['status']); echo '</td>';
					echo '<td>';  placeViewLabel($row); placeDelete($row['id']); echo '</td>';
					echo "</tr>\n";
				}
			?>
		</table>
	</div>
</body>