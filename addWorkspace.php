<?php
    session_start();
    require_once("User.php");
    require_once("Dao.php");
    require_once("Logger.php");
    $logger = new Logger;

    $dao = new Dao();

    //get user id from saved user session variable
    $user = unserialize($_SESSION["user"]);

    //remove # from color
    $color = str_replace("#", "", $_POST["workspace-color"]);

    $check = $dao->addWorkspace($_POST["workspace-name"], $color, $user->id);

    if(!$check){    //if the workspace already exists, informs user and goes back to new workspace form
        $logger->addLog("Duplicate name");
        echo 1;
        exit();
    }
    else{
        if(!isset($_SESSION["newSpaces"])){
            $_SESSION["newSpaces"] = array();
        }
        $_SESSION["newSpaces"][] = $_POST["workspace-name"];
        $_SESSION["change"] = true;

        echo 0;
        exit();
    }

?>