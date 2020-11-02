<?php
    session_start();
    require_once("authenticated.php");
    require_once("Logger.php");
    require_once("User.php");

    $logger = new Logger();

    if(isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true){
        header("Location: login.php");
        exit();
    }
    if(isset($_SESSION["user"])){
        $user = unserialize($_SESSION["user"]);

    }
    else{
        $logger->addLog("Error getting user variable.");
        $_SESSION["login-errors"] = "Error accessing data. Please try again.";
        header("Location: login.php");
        exit();
    }
?>
<html>
    <head>
        <title>Muse</title>
        <link rel="stylesheet" type="text/css" href="style.css">
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
                    <?php echo $user->username; ?>
                </p>
                <img src="images/hamburger.png"> 
            </div>
        </div>