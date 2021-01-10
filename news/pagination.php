<?php

require 'connection.php';



if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
}
else {
	$pageno = 1;
}

$num_of_news = 4;
$offset = ($pageno - 1) * $num_of_news;

//logic for sorting news on page
$select = "SELECT COUNT(*) FROM news";
$result = mysqli_query($connection, $select);
$total_rows = mysqli_fetch_array($result) [0];
$total_pages = ceil($total_rows / $num_of_news);

$select_query = 
"SELECT * FROM (
                      SELECT *
                      FROM news ORDER BY id_news 
                      DESC LIMIT $offset, $num_of_news ) result 
                      ORDER BY id_news DESC   
                    ";

$result = mysqli_query($connection, $select_query);
if (!$result) {
	echo 'Could not run query: ' . mysqli_error();
	exit;
}

//logic for showing news 
while ($row = mysqli_fetch_assoc($result)) {
	 
	
	$title = $row['title'];
	$content = $row["content"];
	$category = $row["category"];
	$image = $row['image'];
	$date = $row['date'];

	$select_query1 = "SELECT id_news FROM `news` WHERE title='$title'";
	$result1 = mysqli_query($connection, $select_query1);
	$id = mysqli_fetch_array($result1);

	echo " <link href='bootstrap.css' rel='stylesheet'>
          <div  style='width:800px; margin:0 auto;' class='card mb-4'>
 <hr><img class='card-img-top' src='".$row['image']."'>
            <div class='card-body'>
              <h2 class='card-title'>".$title."</h2>
                 <p><b>Category : </b> <a href='news/".$row['category'].".php'>".$row['category']."</a> </p>
       
              <a href='news/news_details.php?id=".$id[0]."'>Read More &rarr;</a>
            </div>
            <div class='card-footer text-muted'>
              Posted on ".$date."
           
            </div><hr>
          </div>
	";

}

?>


<html>


 <style>

.bottomnav {
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

.bottomnav ul {
	
  float: center;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 20px;  
}


.bottomnav li:hover {
  background-color: red;
  color: black;
}
.bottomnav li:not(:last-child) {
    margin-bottom: 5px;
}

.bottomnav li.active {
  background-color: maroon;
  color: white;
}</style>

<!-- bottom page navigation -->
<div class ="bottomnav">
<ul id='menu'>
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if ($pageno <= 1) {
	echo 'disabled';
} ?>">
        <a href="<?php if ($pageno <= 1) {
	echo '#';
}
else {
	echo "?pageno=" . ($pageno - 1);
} ?>">Prev</a>
    </li>
    <li class="<?php if ($pageno >= $total_pages) {
	echo 'disabled';
} ?>">
        <a href="<?php if ($pageno >= $total_pages) {
	echo '#';
}
else {
	echo "?pageno=" . ($pageno + 1);
} ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>
</div>


</html>
