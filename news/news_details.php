<?php

 session_start();

 require 'index_html.php';
  require 'check_session.php';
  require 'delete_news.php';
	include 'connection.php';
	



		
//show news	details	
$id = mysqli_real_escape_string($connection,$_GET['id']);
$select_query = "SELECT * FROM `news` WHERE id_news='$id'";
$result = mysqli_query($connection, $select_query);
$num_rows = mysqli_num_rows($result);



echo "<link href='bootstrap.css' rel='stylesheet'>

<style>
.comment{



			padding: 5px;
			margin-right: 250px;
			margin-left: 250px;
		
			text-align: left;
			backgorund: white;
			color: black;
			
}

</style>
";





if ($num_rows == 1 ){
while ($row = mysqli_fetch_assoc($result)) {
		  $title = $row['title'];
		  $content = $row['content'];
		  $category = $row['category'];
		  $image = $row['image'];
		  $date = $row['date'];
			
	
    echo " 

<div class='col-md-8'>

          

          <div class='card mb-4'>
      
            <div class='card-body'>
              <h2 class='card-title'>".$title."</h2>
              <p><b>Category : </b> <a href='".$category."'>".$category."</a> |
                <b> Posted on </b>".$date."</p>
                <hr>

 <img class='img-fluid rounded' src='".$image."'>
   <p class='card-text'></p>
   <p>".$content."</p><hr>
   		
            </div>
          
          </div><h1>Comments:</h1>";
       
   
}}
else { header('Location:../index.php');
}










//show comments
$get_id = mysqli_real_escape_string($connection, $_GET['id']);
$comment_query = "SELECT * FROM comments WHERE id_commented='$get_id'";
$comment_result = mysqli_query($connection,$comment_query);

	if (!$comment_result) {
    echo 'Could not run query: ' . mysqli_error();
    exit;
}

	while ($row = mysqli_fetch_assoc($comment_result)) {
		  $id_comments = $row['id_comments'];
		  $id_commented = $row['id_commented'];
		  $content_of_comment = $row['content_of_comment'];
		  $admin_commented = $row['admin_commented'];
		  $who_commented = $row['who_commented'];
		$date_commented = $row['date_commented'];


//checks if admin is logged to further show admin options for comments
if(isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true){
	echo "

</br><hr><div class='comment'>
	<form method='post'>
	<a>".$admin_commented.$who_commented."</a></br>
	<input type='hidden' name='comm' value='".$id_comments."'></input></br>
	
	 <p>".$content_of_comment."</p><hr>
	 <p>".$date_commented."
	<input type='submit' name='delete' value='Delete'></input></p><br>
	 
	 </form>
	  
	 </div>

";
	
	
}
//checks if user is logged to further show user options for comments
else if(isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true && $who_commented===$_SESSION['username']){
	
	echo "

</br><hr><div class='comment'>
	<form method='post'>
	<a>".$admin_commented.$who_commented."</a></br>
	<input type='hidden' name='comm' value='".$id_comments."'></input></br>
	
	 <p>".$content_of_comment."</p><hr>
	 <p>".$date_commented."</p></br>
	<input type='submit' name='delete' value='Delete'></input><br>
	 
	 </form>
	 </div>

";
	
	
}

//shows comment for someone who isn't logged in
else{
echo "

</br><hr><div class='comment'>
	<form method='post'>
	<a>".$admin_commented.$who_commented."</a></br>
	<input type='hidden' name='comm' value='".$id_comments."'></input></br>
	 <p>".$content_of_comment."</p><hr>
	 <p>".$date_commented."</p></br>
	
	 
	 </form>
	 </div>

";}




}  



///insert comment logic for admin

$id_commented1=  mysqli_real_escape_string($connection,$_GET['id']);
if(isset($_POST['commentbtn']) && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true){

		
		 $content_of_comment1 = mysqli_real_escape_string($connection, $_POST['comment1']);
		  $admin_commented1 = $_SESSION['username'];
		
		  $date_commented1 =  date('Y-m-d H:i:s');


$comment_query = "INSERT INTO `comments` (`id_comments`, `content_of_comment`, `who_commented`, `admin_commented`, `id_commented`, `date_commented`) VALUES (NULL, '$content_of_comment1', NULL, '$admin_commented1', '$id_commented1', '$date_commented1')"; 
$comment_result = mysqli_query($connection,$comment_query);
 echo "<meta http-equiv='refresh' content='0'>";

}
	
	

//insert comment logic for user
if(isset($_POST['commentbtn']) && isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true){

			
		
		  $content_of_comment1 = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['comment1']));
		
		  $who_commented1 = $_SESSION['username'];
		   
		  $date_commented1 = date('Y-m-d H:i:s');


$comment_query = "INSERT INTO `comments` (`id_comments`, `content_of_comment`, `who_commented`, `admin_commented`, `id_commented`, `date_commented`) VALUES (NULL, '$content_of_comment1', '$who_commented1', NULL, '$id_commented1', '$date_commented1')"; 
$comment_result = mysqli_query($connection,$comment_query);

 echo "<meta http-equiv='refresh' content='0'>";

}





 //add comment style
	  if((isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true)){
		    echo "<form method='post'><input type='submit' name='delete1' value='Delete News'></input></form>";
		  require 'comment.html';
		
	  }else if((isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true)){
		  require 'comment.html';
		  
	  }
	  
	  
	  if(isset($_POST['delete'])){
		$comm = htmlspecialchars(mysqli_real_escape_string($connection,$_POST['comm']));	
		
		$delete = "DELETE FROM `comments` WHERE `id_comments` = '$comm'";
		$result = mysqli_query($connection, $delete);
		echo "<meta http-equiv='refresh' content='0'>";
		
}
?>
