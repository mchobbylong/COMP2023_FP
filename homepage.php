<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie
?>

<html>
<head>
<meta charset="utf-8">
<title>WM Cake shop</title>
<link rel="stylesheet" type="text/css" href="main.css">
<style>
/*set the specific style*/
	body{
		background: url("back_1.jpg");
		margin: 0px 0px 0px 0px;
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
<!--This is for the login functions-->
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

<div class="content_box" align="center">
<!--This is for the first section-->
	<section>
		<img src="photo1.png" class="head_img">
		<p class="img_text">Welcome to WM cake shop!</p>
		<hr>
		<p class="img_subtext">Choose whatever you like, enjoy yourself!</p>
	</section>
<!--	This is for the photos sections-->
	<section>
		<div class="cake_menu">
			<ul>
				<li>
					<a href="buy.php">
						<img src="homepage1.png" class="homepage_img1">
					</a>
				</li>
				<li>
					<a href="buy.php">
						<img src="homepage2.png" class="homepage_img2">
					</a>
				</li>
				<li>
					<a href="buy.php">
						<img src="homepage3.png" class="homepage_img3">
					</a>
				</li>
			</ul>
		</div>
	</section>
<!--	here for the text hints-->
	<hr>
	<p class="img_text_down">Click the cake if you want to buy it.</p>
	<hr>
</div>
<!-- set the footer-->
<footer>
	<div class="footer_box">
		<div class="footer_detail_1">
			<p class="footer_headtext">Link to extra links</p>
			<a class="footer_address" href="http://www.hua.com" target="_blank" name="extra_link">China Flower Net</a><br>
			<a class="footer_address" href="http://1date1cake.com" target="_blank">OneCakePerDay</a><br>
			<a class="footer_address" href="http://www.holiland.com" target="_blank">Holiland</a>

		</div>
		
		<div class="footer_detail_2">
			<p class="footer_text"><a href="contact.php">About Us</a></p>
			<p class="footer_text">UIC CST</p>
			<p class="footer_text">Software Development Workshop I</p>
		</div>
	</div>
</footer>
</body>
</html>
