<?php
    session_start();
    require_once("authenticated.php");

    require_once("User.php");
    $user = unserialize($_SESSION["user"]);

    require_once("Dao.php");
    $dao = new Dao();

    require_once("Logger.php");
    $logger = new Logger();

    

    if($_POST["isImage"] == "true"){
        $dao->deleteImage($_POST["id"]);
    }
    else{
        $dao->deleteNote($_POST["id"]);
    }

    $_SESSION["change"] = true;

    exit();
?>