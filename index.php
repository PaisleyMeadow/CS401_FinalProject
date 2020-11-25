<?php
	$thisPage = "index";
	
	require_once("header.php");

	if(isset($_SESSION["authenticated"])){
		header("Location: app.php");
	}

	require_once("welcome.php");
	require_once("footer.php");
?>