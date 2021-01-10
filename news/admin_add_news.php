<?php



if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {

	include 'connection.php';
	

	extract($_POST);

	if (isset($_POST['add'])) {
		if (!empty($_POST['title']) && !empty($_POST['content'])) {
			if (isset($_POST['add'])) {
				$_POST['title'] = filter_var(mysqli_real_escape_string($connection, $_POST['title']),FILTER_SANITIZE_STRING);
				$_POST['content'] = filter_var(mysqli_real_escape_string($connection, $_POST['content']),FILTER_SANITIZE_STRING);
				switch ($category) {
					case 'Technology':
						$add_category = 'technology';
					break;

					case 'Economy':
						$add_category = 'economy';
					break;

					case 'Politics':
						$add_category = 'politics';
					break;

				}

				$add_title = $_POST['title'];
				$add_content = $_POST['content'];
				
				$add_date = date('Y-m-d H:i:s');

				
if ($_FILES['image']['size']<=0){
					die("Invalid file size.");
				}
				else if($_FILES['image']['type']!="image/jpeg" && $_FILES['image']['type']!="image/png" ){
					die("Invalid file format, JPG or PNG required.");
					
				}
				else { 
				 
						 $image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
							$add_image = 'data:'.$_FILES['image']['tmp_name'].';base64,'.$image_base64;
						
						
				}

				$insert = "INSERT INTO `news` (`id_news`, `title`, `content`, `category`, `image`, `date`) VALUES (NULL, '$add_title', '$add_content', '$category', '$add_image', '$add_date')";
				$result = mysqli_query($connection, $insert);

			}
		}
		else {
			echo "<div>Adding failed. Don't leave empty fields. Try again.</div>";
		}

	}
}

?>
<html>


<head>

<style>
div.outset1 {margin-top: 0px;
			margin-bottom: 0px;
			padding: 2px;
			margin-right: 450px;
			margin-left: 450px;
			border-style: outset;
			border-color: navy;
			
			color: black;
}
div.outset2{
	
	
	text-align: center;
}
.pc1{
	
	margin-top: 0px;
			margin-bottom: 0px;
			padding: 2px;
			margin-right: 150px;
			margin-left: 150px;
}
<link href="bootstrap.css" rel="stylesheet">
 <link href="login.css" rel="stylesheet">
</style>
</head>


<body>

<div class='outset1'>
<form method="post" enctype="multipart/form-data">
  <h1>ADD NEWS</h1><hr>
  <br>
   Title:
    <input type="text" name="title" size="10"><br><br>
  Content: 
    <input type="text" name="content" size="40">
  
   <br><br>
  
	Select category: 
	
		<select name="category">
		<option>Technology</option>
		<option>Economy</option>
		<option>Politics</option>
		
		</select>
		<br><br>
	
  
  Add image: <input type="file" name="image" /><br><br><hr>
  <div class="outset2"><input class='btn btn-primary' type="submit" name="add" value="Add"></div>
 
  <p class="pc1"></p>
</form>
			
</div>
</body>
</html>
