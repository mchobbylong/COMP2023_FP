<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie
?>
<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Order Succeed!</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	<style>
	/*	Set some specific css*/
		body{
			background: url(back_1.jpg);
			margin:0;
		}
		p{
			text-align: center;
			font-weight: 200;
			font-size: 4em;
			color:#444;
			text-shadow:0px 0px 1px #DC97FF;
		}
		hr{
			border:inset white 4px;
			margin:20px;
		}
		.success_box{
			margin:250px auto;
			border-radius: 3px;
			background-color:#FFF;
			padding:20px 20px;
			box-shadow: 0 14px 20px rgba(0,0,0,.12);
			max-width: 500px;
			min-width: 500px;
	}
	</style>
</head>

<body>
<!--this is for the navigation bar-->
	<nav>
		<div class="nav">
			<a href="homepage.php"><img src="logo.png" class="logo"></a>
			<a class="nav_text_left" href="buy.php"><span>Place An Order</span></a>
			<a class="nav_text_left" href="homepage.php#extra_link"><span>Extra Link</span></a>
			<a class="nav_text_left" href="contact.php"><span>Contact Us</span></a>

			<?php
				if ($session_uid > -1){
					echo '<a class="nav_text_right" href="session.php?action=logout&returnTo=homepage.php"><span>Logout</span></a>';
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

<!--output the success message-->
<div class="success_box">
<hr>
	<p>Order succeed!</p>
<hr>
</div>
</body>
</html>