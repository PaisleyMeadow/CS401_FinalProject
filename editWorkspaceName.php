<?php
    session_start();

    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $logger = new Logger();

    $dao = new Dao();

    //get user id from saved user session variable
    $user = unserialize($_SESSION["user"]);

    $newName = htmlspecialchars($_POST["wname"]);

    $dao->updateWorkspaceName($newName, $_SESSION["currspace"], $user->id);

    $_SESSION["change"] = true;
    $_SESSION["reloadMe"] = $_POST["wname"];
    $_SESSION["currspace"] = $_POST["wname"];

    exit();
?>