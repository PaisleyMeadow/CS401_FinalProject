<?php
	$thisPage = "index";
	require_once("Dao.php");

	//database testing
	$dao = new Dao();
	$dao->getConnection();

	
	require_once("header.php");
	require_once("welcome.php");
	require_once("footer.php");
?>