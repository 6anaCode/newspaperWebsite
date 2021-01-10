<?php session_start();

	//economy category
	
	include 'add_news_cat.php';
	function Add_economy(){
	
	Add_news_in_categories('economy');
	
	
	}
	
	Add_economy();
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