<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie
?>

<html>
<head>
<meta charset="utf-8">
<title>Contact</title>
<link rel="stylesheet" type="text/css" href="main.css">
<style>
	body{
		background: url(contact_back.jpg);
		background-size: cover;
		margin:0px;
	}

	h1{
		text-align: center;
		margin-top: 40px;
		font-size: 60px;
		color:#A0C985;
		text-shadow: 0 1px hsl(0,0%,85%),
				0 2px hsl(0,0%,80%),
				0 3px hsl(0,0%,75%),
				0 4px hsl(0,0%,70%),
				0 5px hsl(0,0%,65%),
				0 5px 10px black;
	}

	hr{
		box-shadow: 0 1px hsl(0,0%,85%),
				0 2px hsl(0,0%,80%),
				0 3px hsl(0,0%,75%),
				0 4px hsl(0,0%,70%),
				0 5px hsl(0,0%,65%),
				0 5px 10px black;
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
					echo '<a class="nav_text_right" href="login.php?returnTo=' . $_SERVER['PHP_SELF'] . '"><span>Login</span></a>';
					echo '<a class="nav_text_right" href="registration.php"><span>Register</span></a>';
				}
			?>
		</div>
	</nav>

<!--This is for the contact-->
<h1>Developers</h1>
<hr>
<div class="contact_box">
	<div class="contact_detail_box_1">
		<img src="Tian.jpg" class="contact_picture">
		<p class="contact_detail">Tel: 18000000000</p>
		<p class="contact_detail"><a href="mailto:m730000000@mail.uic.edu.hk" class="colorchange_a">Email: m730000000@mail.uic.edu.hk</a></p>
		<p class="contact_detail"><a href="http://hixiaotian.com" class="colorchange_a">Website: hixiaotian.com</a></p>
	</div>
	
	<div class="contact_detail_box_2">
		<img src="Long.jpg" class="contact_picture">
		<p class="contact_detail">Tel: 18000000000</p>
		<p class="contact_detail"><a href="mailto:m730000000@mail.uic.edu.hk" class="colorchange_a">Email: m730000000@mail.uic.edu.hk</a></p>
		<p class="contact_detail"><a href="http://mchobbylong.com" class="colorchange_a">Website: mchobbylong.com</a></p>
	</div>
</div>

</body>
</html>
