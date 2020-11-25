<?php
    session_start();

    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $logger = new Logger();

    $dao = new Dao();

    //get user id from saved user session variable
    $user = unserialize($_SESSION["user"]);

    $dao->deleteWorkspace($_SESSION["currspace"], $user->id);

    $_SESSION["change"] = true;

    exit();
?>