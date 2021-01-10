<?php

//function that returns news based on the given category parameter

function Add_news_in_categories($cat) {
include 'index_html.php';
include 'check_session.php';
require 'connection.php';

//getting page number from url
	if (isset($_GET['pagenoc'])) {

		$pageno = $_GET['pagenoc'];
	}
	else {
		$pageno = 1;
	}

	$num_of_news = 4;
	$offset = ($pageno - 1) * $num_of_news;
	
//selecting news from database based on given category to get total rows affected
	$select = "SELECT COUNT(*) FROM news WHERE category='$cat'";
	$result = mysqli_query($connection, $select);
	$total_rows = mysqli_fetch_array($result) [0];

	$total_pages = ceil($total_rows / $num_of_news);

//selecting news by 4 from each category and sorting them by descending in order to see the last added news first
	$select_query = "SELECT * FROM (
                      SELECT *
                      FROM news WHERE category='$cat' ORDER BY id_news 
                      DESC LIMIT $offset, $num_of_news ) result 
                      ORDER BY id_news DESC   
                    ";

	$result = mysqli_query($connection, $select_query);
	if (!$result) {
		echo 'Could not run query: ' . mysqli_error();
		exit;
	}
//fetching result in array in order to get every coulmn 	
	while ($row = mysqli_fetch_assoc($result)) {
		$title = $row['title'];
		$content = $row["content"];
		$category = $row["category"];
		$image = $row['image'];
		$date = $row['date'];

//slecting id number of news for the link that opens a separate page of selected news
		$select_query1 = "SELECT id_news FROM `news` WHERE title='$title'";
		$result1 = mysqli_query($connection, $select_query1);
		$id = mysqli_fetch_array($result1);
		
//echoing news
		echo " <link href='bootstrap.css' rel='stylesheet'>
          <div  style='width:800px; margin:0 auto;' class='card mb-4'>
 <hr><img class='card-img-top' src='".$row['image']."'>
            <div class='card-body'>
              <h2 class='card-title'>".$title."</h2>
                 <p><b>Category : </b> <a href='".$row['category'].".php'>".$row['category']."</a> </p>
       
              <a href='news_details.php?id=".$id[0]."'>Read More &rarr;</a>
            </div>
            <div class='card-footer text-muted'>
              Posted on ".$date."
           
            </div><hr>
          </div>
	";
	}
	
//bottom navigation 	
	$num_to_add = 1;
	if ($pageno <= 1 && $pageno >= $total_pages) {

		echo "<div class ='bnav'>
<ul id='menu'>
    <li><a href='?pagenoc=1'>First</a></li>
<li><a href='?pagenoc=$total_pages'>Last</a></li>
</ul>
</div>";
	}
	else if ($pageno <= 1) {
		echo "<div class ='bnav'>
<ul  id='menu'>
    <li><a href='?pagenoc=1'>First</a></li>
	<li><a href='?pagenoc=" . ($pageno + 1) . "'>Next</a></li>
<li><a href='?pagenoc=$total_pages'>Last</a></li>
</ul>
</div>";

	}
	else if ($pageno >= $total_pages) {

		echo "<div class ='bnav'>
<ul  id='menu'>
    <li><a href='?pagenoc=1'>First</a></li>
	<li><a href='?pagenoc=" . ($pageno - 1) . "'>Prev</a></li>
<li><a href='?pagenoc=$total_pages'>Last</a></li>
</ul>
</div>";

	}
	else {
		echo "<div class ='bnav'>
<ul  id='menu'>
    <li><a href='?pagenoc=1'>First</a></li>
	<li><a href='?pagenoc=" . ($pageno - 1) . "'>Prev</a></li>
	<li><a href='?pagenoc=" . ($pageno + 1) . "'>Next</a></li>
<li><a href='?pagenoc=$total_pages'>Last</a></li>
</ul>
</div>";

	}

}

?>
	<html>

 <!-- bottom navigation style-->
<style>

.bnav {
	margin-top: 20px;
			margin-bottom: 50px;
			margin-right: 250px;
			margin-left: 250px;
			text-align: center;
  
  overflow: hidden;
 
}
ul#menu li {
  display:inline;
   border: 1px solid navy;
   background-color: black;
  
}

.bnav ul {
	
  float: center;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 20px;  
}


.bnav li:hover {
  background-color: red;
  color: black;
}
.bnav li:not(:last-child) {
    margin-bottom: 5px;
}

.bnav li.active {
  background-color: maroon;
  color: white;
}</style>



</html>
