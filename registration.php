<?php
	require_once 'debug.php';
	require_once 'database.php';
	require_once 'session.php';
	setcookie('returnTo', '', time() - 3600);	//remove cookie

	//check connection
	$sql = "SELECT * FROM usertable";
	$result = db_query($sql, 0);
	
	//set all the global variables
	$username = $password = $checkpassword = $familyname = $firstname = $phone = $city = $address = $email = $usernameErr = $passwordErr = $checkpasswordErr = $familynameErr = $firstnameErr = $phoneErr = $cityErr = $addressErr = $emailErr = $success = "";
	$flag = 0;
	//flag is the judgement for correct form
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//The area for check if it is can be input at the correct form
		//check the username
		if(empty($_POST["username"]))
		{
			$usernameErr = "Username is required!<br>";
			$flag = 1;
		}
		else
		{
			$username = test_input($_POST["username"]);
			//This is the area for check if the username is existed
			while($row = $result -> fetch_assoc())
			{
				if($row["username"] == $username)
				{
					$usernameErr = "Username exists!<br>";
					$flag = 1;
				}
			}
		}
		//check the password
		if(empty($_POST["password"]))
		{
			$passwordErr = "Password is required!<br>";
			$flag = 1;
		}
		else
		{	//check the password is in the correct form
			$password = test_input($_POST["password"]);
			if (!preg_match("/^.{6,}$/",$password)) 
			{
				$passwordErr = "Your password should over 6 characters!<br>"; 
				 $flag = 1;
			}
		}
		//check the confirmpassword
		if(empty($_POST["checkpassword"]))
		{
			$checkpasswordErr = "You should input the confirm password!<br>";
			$flag = 1;
		}
		else
		{
			$checkpassword = test_input($_POST["checkpassword"]);
			if($checkpassword != $password)
			{
				$checkpasswordErr = "Confirm password is inconsistent with your password!<br>";
				$flag = 1;
			}
		}	
		//check the familyname
		if(empty($_POST["familyname"]))
		{
			$familynameErr = "Your family name is required!<br>";
			$flag = 1;
		}
		else
		{
			$familyname = test_input($_POST["familyname"]);
		}		
		//check the firstname
		if(empty($_POST["firstname"]))
		{
			$firstnameErr = "Your first name is required!<br>";
			$flag = 1;
		}
		else
		{
			$firstname = test_input($_POST["firstname"]);
		}	
		//check the phone
		if(empty($_POST["phone"]))
		{
			$phoneErr = "Your phone is required!<br>";
			$flag = 1;
		}
		else
		{
			$phone = test_input($_POST["phone"]);
		}	
		//check the city
		if(empty($_POST["city"]))
		{
			$cityErr = "Your city is required!<br>";
			$flag = 1;
		}
		else
		{
			$city = test_input($_POST["city"]);
		}	
		//check the address
		if(empty($_POST["address"]))
		{
			$addressErr = "Your address is required!<br>";
			$flag = 1;
		}
		else
		{
			$address = test_input($_POST["address"]);
		}
		//check the email

		if(empty($_POST["email"]))
		{
			$emailErr = "Email is required!<br>";
			$flag = 1;
		}
		else
		{	//check the email is in the correct form
			$email = test_input($_POST["email"]);
			if (!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/",$email)) 
			{
				$emailErr = "This is not an email form!<br>"; 
				 $flag = 1;
			}
		}
		
		if($flag == 0)	//if there is no error, insert the data to SQL
		{
			//insert into SQL
			$sql = "INSERT INTO usertable (username, password, firstname, familyname, phonenumber, email, city, address, isadmin) VALUES ('$username', '$password', '$firstname' , '$familyname', '$phone', '$email', '$city', '$address', 0)";
			$result = db_query($sql, 1);
			if($result == TRUE)
			{
				$success = "Submit succeed!";
				// header("Refresh:2; location:login.php");
				$success .= "<script>
					var t = 5;
					setInterval(function(){
						if (t == 0)
							window.location.href = 'login.php';
						document.getElementById('timer').innerHTML = 'You will go to login page in ' + t + ' second(s).';
						t--;
					}, 1000);</script>";
			}
		}
	}

	// Output debug logs to console
	console();

	//use the test_input to protect the date 
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Registration</title>
<!--	link to the main css-->
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
/*		set the specific style*/
		body{
			background: url(reg.jpg) no-repeat;
			background-size: cover;
			margin:0;
		}
		.input_text_box{
		text-align: right;
		margin-right: 200px;
		}
		h1{
			font-weight: 400;
			letter-spacing: 1.2px;
		}
		p{
			margin:30px 0px;
		}
	</style>
</head>

<body>

	<nav>
<!--	Here is for the navigation-->
		<div class="nav">
			<a href="homepage.php"><img src="logo.png" class="logo"></a>
			<a class="nav_text_left" href="buy.php"><span>Place An Order</span></a>
			<a class="nav_text_left" href="homepage.php#extra_link"><span>Extra Link</span></a>
			<a class="nav_text_left" href="contact.php"><span>Contact Us</span></a>
<!--	This is set for the login functions-->
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
<!--This is for the registration box-->
	<div class="reg_box">
		<h1 class="headtext">Registration</h1>
		<hr>
		<form method="post">
		<!-- This is the input text box -->
		<div class="input_text_box">
			<p>Username:
				<input type="text" name="username" class="input" value="<?php echo $username?>">
			</p>
			<p>Password:
				<input type="password" name="password" class="input" value="<?php echo $password?>">
			</p>
			<p>Confirm Password:
				<input type="password" name="checkpassword" class="input" value="<?php echo $checkpassword?>">
			</p>
			<p>Family Name:
				<input type="text" name="familyname" class="input" value="<?php echo $familyname?>">
			</p>
			<p>First Name:
				<input type="text" name="firstname" class="input" value="<?php echo $firstname?>">
			</p>
			<p>Phone number:
				<input type="number" name="phone" class="input" value="<?php echo $phone?>">
			</p>
			<p>City:
				<input type="text" name="city" class="input" value="<?php echo $city?>">
			</p>
			<p>Detailed Address:
				<input type="text" name="address" class="input" value="<?php echo $address?>">
			</p>
			<p>Email:
				<input type="text" name="email" class="input" value="<?php echo $email?>">
			</p>		

			<br>
				<input type="submit" value="Submit" class="reg_button">
			<p class="reg_error">
				<!-- output the error message here -->
				<?php echo $usernameErr.$passwordErr.$checkpasswordErr.$familynameErr.$firstnameErr.$phoneErr.$cityErr.$addressErr.$emailErr.$success;?><br/>
			</p>
			<span id="timer"></span>
			<p class="justify_2">Have an account? Click <a href="login.php" class="here_text">here</a> to login!</p>
			</form>
		</div>
	</div>


</body>
</html>
