<?php 

//logout button
session_start();

if(isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true || isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true){//dodaj za admin

session_unset();
session_destroy();

header('Location:../index.php');
}
?>