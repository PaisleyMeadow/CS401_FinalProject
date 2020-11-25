<?php
    session_start();

    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $logger = new Logger();

    $dao = new Dao();

    //get user id from saved user session variable
    $user = unserialize($_SESSION["user"]);

    //first delete user in db
    $dao->deleteUser($user->id);

    //then destroy session
    session_unset();
    session_destroy();
    
    exit();
?>