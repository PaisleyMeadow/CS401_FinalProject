<?php
    if(!isset($_POST["login-uname"]))
        $_POST["login-uname"] = "TempUsername";
?>
<html>
    <head>
        <title>Muse</title>
		<link rel="stylesheet" type="text/css" href="app.css">
        <link rel="icon" type="image/png" href="images/favicon.png">

		<!-- fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app-header">
            <a href="index.php"><img src="images/muse-icon.png"></a>
            <div id="app-header-options-container">
                <p id="username" class="ubuntu-font">
                    <?php echo $_POST["login-uname"]; ?>
                </p>
                <img src="images/hamburger.png"> 
            </div>
        </div>