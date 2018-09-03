<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';

	$returnTo = "homepage.php";
	if (isset($_GET['returnTo']))
		setcookie('returnTo', $_GET['returnTo']);
	if (isset($_COOKIE['returnTo'])) $returnTo = $_COOKIE['returnTo'];

	// Set global variables
	$username = $password = $usernameErr = $passwordErr = $notcorrectErr = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
//		check if the username is empty
		if (empty($_POST["username"])) {
			$usernameErr = "Username is required!<br>";
			$flag = 1;	
		}
		else {
			$username = test_input($_POST["username"]);
		}
		//check if the password is empty 
			if (empty($_POST["password"])) {
			$passwordErr = "Password is required!<br>";
			$flag = 1;	
		}
		else {
			$password = test_input($_POST["password"]);
		}
		//connect to the server and check if it is correct 
		$sql = "SELECT * FROM usertable WHERE username = '$username' AND password = '$password'";
		$result = db_query($sql, 1);
		if ($result->num_rows > 0){
			//login success
			$_SESSION['uid'] = $result->fetch_assoc()['uid'];
			setcookie('returnTo', '', time() - 3600);	//remove cookie
			header("Location: $returnTo");
		}
		else 
//			if it is not correct, output the error
			$notcorrectErr = "Username does not exist<br> or password error!<br>";
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	console();
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Login your account</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
	/*	set the specific body style*/
		body {
			font-family: "Segoe UI","Segoe UI Web","Segoe UI Symbol","Helvetica Neue","BBAlpha Sans","S60 Sans",Arial,sans-serif;
			color: #000;
			margin: auto;
			font-size: 20px;
			background-image: url(reg.png);
		}
	</style>
</head>
<body>
<!--This is for the navigation bar-->
	<nav>
		<div class="nav">
			<a href="homepage.php"><img src="logo.png" class="logo"></a>
			<a class="nav_text_left" href="buy.php"><span>Place An Order</span></a>
			<a class="nav_text_left" href="homepage.php#extra_link"><span>Extra Link</span></a>
			<a class="nav_text_left" href="contact.php"><span>Contact Us</span></a>

			<?php
				if ($session_uid > -1){
					echo '<a class="nav_text_right" href="session.php?action=logout&returnTo=' . $_SERVER['PHP_SELF'] . '"><span>Logout</span></a>';
					if ($session_isadmin)
						echo '<a class="nav_text_right" href="admin.php"><span>Admin</span></a>';
					echo '<span class="nav_text_right">Welcome, ' . $session_username . '!</span>';
				}
				else {
					echo '<a class="nav_text_right" href="login.php"><span>Login</span></a>';
					echo '<a class="nav_text_right" href="registration.php"><span>Register</span></a>';
				}
			?>
		</div>
	</nav>
<!--This is for the check login box-->
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="login_box">
			<h1 class="headtext">Login</h1>
				<hr>
				<p>Username:<span class="login_error">&nbsp;&nbsp;<?php echo $usernameErr;?></span></p>
				<input type="text" name="username" class="input" value="<?php echo $username; ?>">
				<p>Password:<span class="login_error">&nbsp;&nbsp;<?php echo $passwordErr;?></span></p>
				<input type="password" name="password" class="input"> 
				<br>
				<input type="submit" value="Login" class="login_button">
				<p class="justify_1">Don't have an account?<br> Click <a href="registration.php" class="here_text">here</a> to register!</p>
				<p class="login_error"><?php echo $notcorrectErr;?></p>
		</div>
	</form>

</body>
</html>