<?php
require 'connection.php';

//checks if admin is logged in order to perform admin option of delete
if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {


if (isset($_POST['delete1'])) {

	$id = mysqli_real_escape_string($connection, $_GET['id']);
	$delete = "DELETE FROM `news` WHERE `id_news` = '$id'";
	$result = mysqli_query($connection, $delete);
 header("Location:../index.php");
}}

?>