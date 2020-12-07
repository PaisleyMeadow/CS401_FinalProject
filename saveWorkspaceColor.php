<?php
    session_start();
    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $logger = new Logger();

    $dao = new Dao();

    //get user id from saved user session variable
    $user = unserialize($_SESSION["user"]);

    //remove # from color string
    $color = str_replace("#", "", $_POST["color"]);
    $logger->addLog("color: ".$color);
    //update table
    $dao->saveWorkspaceColor($color, $_SESSION["currspace"], $user->id);

    $_SESSION["change"] = true;
    $_SESSION["reloadMe"] = $_SESSION["currspace"];

    exit();
    
?>