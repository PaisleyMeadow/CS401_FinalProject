<?php
    session_start();
    require_once("authenticated.php");

    require_once("User.php");
    $user = unserialize($_SESSION["user"]);

    require_once("Dao.php");
    $dao = new Dao();

    require_once("Logger.php");
    $logger = new Logger();


    $dao->addNoteInput(htmlspecialchars($_POST["content"]), $_POST["id"]);
  
    $_SESSION["change"] = true;

    exit();
?>