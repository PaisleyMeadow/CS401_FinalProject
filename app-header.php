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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/app-header.js"></script>
        
        <!-- link and script for color picker -->
        <!-- https://github.com/Simonwep/pickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"/> <!-- 'monolith' theme -->
        <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
        <!-- very old jquery ui plugin :) -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <title>Muse</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/app.css">
        <link rel="icon" type="image/png" href="images/favicon.png">

		<!-- fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app-header">
            <img src="images/muse-icon.png">
            <div id="app-header-options-container">
                <p id="username" class="ubuntu-font">
                    <?php echo $user->username; ?>
                </p>
                <img id="hamburger" src="images/hamburger.png"> 
            </div>

            <div id="user-options">
                <a href="about.php" id="app-about" class="ubuntu-font">About</a>
                <a href="contact.php" id="app-contact" class="ubuntu-font">Contact</a>
                <div id="logout" class="ubuntu-font">Logout</div>
                <div id="delete-account" class="ubuntu-font">Delete Account</div>
            </div>
        </div>