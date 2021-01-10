<?php $dbhost = "localhost";
	$dbuser = "root";
	$dbpassword = "";
	$database = "newspaper";

	//Database connection
	

	try {
		$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $database);
	}
	catch(mysqli_sql_exception $ex) {
		echo 'Error';
	}

?>