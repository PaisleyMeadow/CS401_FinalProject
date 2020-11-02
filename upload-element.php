<?php
    session_start();
    require_once("authenticated.php");

    require_once("User.php");
    $user = unserialize($_SESSION["user"]);

    require_once("Dao.php");
    $dao = new Dao();

    require_once("Logger.php");
    $logger = new Logger();

    if($_POST["type"] == "image"){
        require_once("upload-image.php");
    }
    else{
        require_once("upload-note.php");
    }

    header("Location: workspace.php?name=".$_SESSION["current-space"]);
    unset($_SESSION["current-space"]);
    exit();


?>