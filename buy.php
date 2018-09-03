<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	require_once 'cake.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie

	//Ask for login
	if ($session_uid < 0){
		header('Location: login.php?returnTo=' . $_SERVER['PHP_SELF']);
		die();
	}

	$caketype = $cakesize = $num_topping = $giftcard = 0;
	$topping = array();
	$message = $cost = '';
	$flag = 1;

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$caketype = $_POST['caketype'];
		$cakesize = $_POST['cakesize'];
		if (isset($_POST['topping'])) $topping = $_POST['topping'];
		if (isset($_POST['giftcard'])) $giftcard = $_POST['giftcard'];
		$message = $_POST['message'];
		$cost = $_POST['cost'];
		
		$flag = 0;

		$num_topping = arr_to_num($topping);

		$sql = "INSERT INTO booking (uid, caketype, cakesize, topping, giftcard, message, cost, time, status) VALUES ($session_uid, $caketype, $cakesize, $num_topping, $giftcard, '$message', $cost, unix_timestamp(now()), 0)";
		$result = db_query($sql, 1);
		if($result){
			header('location:order_success.php');
			die(0);
		}
	}

	console();

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Buy your cake</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
		body{
			background: url(back_1.jpg);
			margin:0px;
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

	<p class="head_text">Now, buy your cake!</p>
	<hr>

	<form method="post" onsubmit="return verify_form()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<!--box for choose the cake-->
		<div class="cake_box">
			<p class="box_headtext">Choose your cake</p>
			<hr class="box_hr">
			<div class="cake_choose_box">
				<ul>
					<li>
<!--					Different cake types and layouts-->
						<img src="a.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Mango Mousse (¥185)</p>
							<p class="sub_text">Three tastes of mango</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="1" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="b.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Passion Mousse (¥240)</p>
							<p class="sub_text">Remix of passion fruit & cheese</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="2" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="c.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Sweet Wine (¥210)</p>
							<p class="sub_text">Romance from France</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="3" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="d.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Durian Crazy (¥260)</p>
							<p class="sub_text">Durian love</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="4" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
				</ul>
				<ul>
					<li>
						<img src="e.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Rum Cheese (¥200)</p>
							<p class="sub_text">Do you like cheese</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="5" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="f.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Black & White (¥220)</p>
							<p class="sub_text">Date with chocolate</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="6" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="g.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Teatime (¥220)</p>
							<p class="sub_text">Green tea house</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="7" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
					<li>
						<img src="h.png" class="cake_img">
						<div class="sub_choose_box">
							<p>Chestnut Cream (¥235)</p>
							<p class="sub_text">An old memory</p>
							<hr class="sub_hr">
							<input type="radio" name="caketype" value="8" class="choose_input_type" onclick="update_cake_type(this.value)"> Choose this one
						</div>
					</li>
				</ul>
			</div>
		</div>
<!--This is the box for the cake setting type box-->
		<div class="type_box">
			<p class="box_headtext">Set your cake type</p>
			<hr class="box_hr">
			<div class="set_box_1">
<!--			This is for the cake size setting -->
				<p class="cake_size_text">Cake Size:</p>
				<hr class="sub_hr_1"><br>
					<input type="radio" name="cakesize" class="radio_text" value="1" onclick="update_cake_size(this.value)">Small (1.0)<br>
					<input type="radio" name="cakesize" class="radio_text" value="2" onclick="update_cake_size(this.value)">Medium (1.5)<br>
					<input type="radio" name="cakesize" class="radio_text" value="3" onclick="update_cake_size(this.value)">Large (2.0)
			</div>
<!--		This is for the cake extra toppings setting-->
			<div class="set_box_2">
				<p class="cake_size_text">Extra Toppings:</p>
				<hr class="sub_hr_1"><br>
					<input type="checkbox" name="topping[]" class="radio_text" value="1" onchange="update_topping()">Chocolate (¥25)<br>
					<input type="checkbox" name="topping[]" class="radio_text" value="2" onchange="update_topping()">Cheese cream (¥40)<br>
					<input type="checkbox" name="topping[]" class="radio_text" value="3" onchange="update_topping()">Oreo biscuit (¥30)<br>
					<input type="checkbox" name="topping[]" class="radio_text" value="4" onchange="update_topping()">Strawberry (¥45)
			</div>
<!--			This is for the choosing of gift card-->
			<div class="set_box_3">
				<p class="cake_size_text">Gift Card:</p>
				<hr class="sub_hr_1"><br>
					<input type="checkbox" name="giftcard" class="radio_text" value="1" onchange="update_giftcard(this.checked)">Yes, add a gift card
			</div>
<!--			This is for the leaving message-->
			<div class="set_box_4">
				<p class="cake_size_text">Leave your message:</p>
				<hr class="sub_hr_1"><br>
					<input name="message" class="message_input" rows="5" placeholder="Please leave your message here." onfocusout="update_message(this.value)"></input><br>
			</div>
		</div>
<!--		This is for the checking box-->
		<div class="check_box">
			<p class="box_headtext">Check Your Order</p>
			<hr class="box_hr">
			<br>
			<div class="check_inner_box">
				<p class="box_headtext">Your cake: <span id="check_cake_type" class="grey_text"></span></p>
				<p class="box_headtext">Your cake size: <span id="check_cake_size" class="grey_text"></span></p>
				<p  class="box_headtext">Your extra toppings: <span class="grey_text" id="check_topping"></span></p>
				<p class="box_headtext">Gift card: <span id="check_giftcard" class="grey_text"></span></p>
				<p class="box_headtext">Your message: <span id="check_message" class="grey_text"></span></p>
				<p class="box_headtext">Total cost: <span class="grey_text" id="check_price"></span></p>
			</div>
		</div>
<!--hiddenly update the data-->
		<input type="hidden" id="cost" name="cost" value="0">
<!--submit button-->
		<input type="submit" class="buy_button" value="Confirm">
		<span id="msg"><?php if ($flag == 0) echo 'Order succeed!'; ?></span>

	</form>
	<script src="buy.js"></script>
</body>
</html>