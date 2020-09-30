<?php echo $thisPage?>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="icon" type="image/png" href="images/favicon.png">

		<!-- fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">

	</head>
	<body>
		<div id="page-header">
			<a href="index.php"><img id="muse-logo" src="images/muse.png" alt="Muse"></a>
			<div id=header-options-container>
				<a href="about.php" class=<?php 
					if($thisPage == "about") echo "\"header-option header-option-active ubuntu-font\""; 
					else echo "\"header-option ubuntu-font\"";?> >About</a>
				<a href="contact.php" class=<?php
				if($thisPage == "contact") echo "\"header-option header-option-active ubuntu-font\""; 
					else echo "\"header-option ubuntu-font\"";?>>Contact</a>
			</div>
		</div>
