<?php 

function CheckSession(){
	
	
	 //checks if there is started session to put details on page about user and logout link
	  if(isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true || isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true){
		 if($_SESSION['userAgent'] == $_SERVER['HTTP_USER_AGENT']){
		echo "<a>".$_SESSION['username']."</a>";
		 echo "<div><a href='news/logout.php'>Logout</a></div>";}}
	
	
}
CheckSession();

?>