<?php

 session_start();

//checks if if someone is logged in to redirect 
   if((isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true)){
	  
	  header('Location:../index.php');
  }
else{

require 'connection.php';

$username = "";
$email = "";
$password = "";
$checkpassword= "";
$username = "";
$password    = "";
$email = "";
$checkpassword = "";




//logic for registration
if(isset($_POST['register']))
{
$username = mysqli_real_escape_string($connection,filter_var( $_POST['username'], FILTER_SANITIZE_STRING));
$password = mysqli_real_escape_string($connection, filter_var(sha1($_POST['password']), FILTER_SANITIZE_STRING));
$email = mysqli_real_escape_string($connection,filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL));
$checkpassword = mysqli_real_escape_string($connection, filter_var(sha1($_POST['checkpassword']), FILTER_SANITIZE_STRING));




if(!empty($username) && $password!='da39a3ee5e6b4b0d3255bfef95601890afd80709' && !empty($email) && $checkpassword!="da39a3ee5e6b4b0d3255bfef95601890afd80709" && sha1($password)===sha1($checkpassword)){
		$select_query = "SELECT * FROM user WHERE username='$username' OR email='$email'";
		$result = mysqli_query($connection,$select_query);
		$row = mysqli_num_rows($result);
		
		if($row === 0){
		$insert_query = "INSERT INTO `user`(`username`, `email`, `password`) VALUES('$username', '$email', '$password')";
		$inserted = mysqli_query($connection, $insert_query);
		
		echo "<script>alert('You registrated sucessfully! Login to continue.');</script>";
	}
	else {
		
		 echo "<script>alert('Username or email already exists');</script>";
		
	}
} else { echo "<script>alert('Fill all the fields and check if passwords match!');</script>";}}


}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Newspaper</title>

   

   
<link href="bootstrap.min.css" rel="stylesheet">

    
    <!-- register style -->
    <link href="login.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="post">
  
  <h1 class="h3 mb-3 font-weight-normal">Register</h1>
  <label for="username" class="sr-only">Username</label>
  <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
  <label for="email" class="sr-only">Email address</label>
  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
  <label for="password" class="sr-only">Password</label>
  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
  <label for="checkpassword" class="sr-only">Check Password</label>
  <input type="password" id="checkpassword" name="checkpassword" class="form-control" placeholder="Check Password" required>
  <div class="checkbox mb-3">
  
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button><br>
  <label><a href="login.php">Already a user? Login here.</a></label><br><br>
   <label><a href="../index.php">Back to news</a></label>
</form>
</body>
</html>
