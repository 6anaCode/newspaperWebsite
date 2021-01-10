<?php

session_start();
//checks if there is any started session so it can redirect to idnex.php
if ((isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true)) { //dodaj za admin
	header('Location:../index.php');
}
else {

	
	$username = "";
	$password = "";

	require 'connection.php';

	//checks if login pressed
	if (isset($_POST['login'])) {
		$username = mysqli_real_escape_string($connection,filter_var( $_POST['username'], FILTER_SANITIZE_STRING));
		$password = mysqli_real_escape_string($connection, filter_var(sha1($_POST['password']), FILTER_SANITIZE_STRING));

		//selecting  user details from database for login user/admin
		$select_query = "SELECT * FROM user WHERE username='$username' AND password= '$password' ";
		$select_query1 = "SELECT * FROM admin WHERE a_username='$username' AND a_password= '$password' ";

		//executing queries
		$result = mysqli_query($connection, $select_query);
		$result1 = mysqli_query($connection, $select_query1);

		//fetching objects from quieries
		$user = mysqli_fetch_object($result);
		$admin = mysqli_fetch_object($result1);

		//checking if inputed data matches data from table and starts session for user/admin
		if ($user) {

			session_start();
			$_SESSION['user_logged'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			header('Location:../index.php');

		}
		else if ($admin) {

			session_start();
			$_SESSION['admin_logged'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			header('Location:../index.php');

		}

		else {
			echo "<script>alert('Login failed. Try again.');</script>";
		}

	}

}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Newspaper</title>

  

   
<link href="bootstrap.min.css" rel="stylesheet">

    
    <!-- login style -->
    <link href="login.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="post">
  
  <h1 class="h3 mb-3 font-weight-normal">Please login</h1>
  <label for="username" class="sr-only">Username</label>
  <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
  <label for="password" class="sr-only">Password</label>
  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3">
  </div>
  <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Login</button><br>
  <label><a href="register.php">New user? Register here.</a></label><br><br>
   <label><a href="../index.php">Back to news</a></label>
</form>
</body>
</html>

