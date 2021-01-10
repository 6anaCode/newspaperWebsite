<?php session_start();

//includes everything needed for home page
include 'index_html.php';
include 'check_session.php';
include 'news/connection.php';


//checks if admin is logged to add necessary things for admin options
if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
	include 'news/admin_add_news.php';
	
}


include 'news/pagination.php';

?>

