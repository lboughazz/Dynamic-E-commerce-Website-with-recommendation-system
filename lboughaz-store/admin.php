<?php

include 'config.php';

session_start();
 
error_reporting(0);

 

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['admin'] = $row['username'];
		header("Location: indexAdmin.php");
	} else {
		echo "<script>alert('Woops Admin ! Email or Password is Wrong.')</script>";
	}
}
?>

<!DOCTYPE html>
<html>
	
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

	<link rel="stylesheet" type="text/css" href="styleLogin.css">

	<title>Login Form </title>
</head>
<body style ="background-image:url(wp3537555-e-commerce-wallpapers.jpg);">
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 3rem; font-weight: 800;">Admin Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
		 
			<p class="login-register-text">login as user ? <a href="login.php">click Here</a>.</p>
		</form>
	</div>
</body>
</html>