<?php session_start();

	
	//technology category
	require 'add_news_cat.php';
	function Add_technology(){
	
	Add_news_in_categories('technology');
	}
	
	Add_technology();
?>

<html><style>
div.outset {margin-top: 0px;
			margin-bottom: 0px;
			padding: 2px;
			margin-right: 250px;
			margin-left: 250px;
			border-style: outset;
			border-color: navy;
			background: white;
			color: black;
}
</style></html>