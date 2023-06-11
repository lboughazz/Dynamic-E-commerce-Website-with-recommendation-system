<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
  if (!empty( $_POST['username']) && !empty( $_POST['email']) && !empty( $_POST['password']) && !empty( $_POST['cpassword']) 
             && !empty( $_POST['tel'])  && !empty( $_POST['adresse'])    ) {
				$username = $_POST['username'];
				$email = $_POST['email'];
    
				$password = mysqli_real_escape_string($conn, $_POST["password"]);  
				$pass = md5($password);  
				$cpassword = mysqli_real_escape_string($conn, $_POST["cpassword"]);  
				$cpass = md5($cpassword); 

				 
				$adresse = $_POST['adresse'];
				$tel = $_POST['tel'] ;
				if ($pass == $cpass) {
					$sql = "SELECT * FROM users WHERE email='$email' OR  username='$username' ";
					$result = mysqli_query($conn, $sql);
					if ($result->num_rows == 0) {
						$sql = "INSERT INTO users (username, email, password ,user_tel ,user_adr )
								VALUES ('$username', '$email', '$pass' , '$tel' , '$adresse')";
						$result = mysqli_query($conn, $sql);
						if ($result) {
							echo "<script>alert('Wow! User Registration Completed.')</script>";
							$_SESSION['username'] = $username ;
							$username = "";
							$email = "";
							$_POST['password'] = "";
							$_POST['cpassword'] = "";
							$_POST['tel'] = "";
							$_POST['adresse'] = "";
							header("Location: index.php");
						} else {
							echo "<script>alert('Woops! Something Wrong Went.')</script>";
						}
					} else {
						echo "<script>alert('Woops! Email Or Username Already Exists.')</script>";
					}
					
				} else {
					echo "<script>alert('Password Not Matched.')</script>";
				}
			 }else {
				echo "<script>alert(' some champs is Empty ! ')</script>";
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

	<title>Register Form - Pure Coding</title>
</head>
<body style ="background-image:url(wp3537555-e-commerce-wallpapers.jpg);">
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 3rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">	 
	            <input type="tel" placeholder="Phone Number" name="tel" value="<?php echo $_POST['tel'];  ?>" required>
            </div>
			<div class="input-group">	 
	            <input type="text" placeholder="Your Adresse" name="adresse" value="<?php echo $_POST['adresse'];  ?>" required>
            </div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
    </div>
	
 
			
		</form>
	</div>
</body>
</html>