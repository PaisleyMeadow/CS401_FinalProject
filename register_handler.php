<?php
    session_start();
    require_once("Dao.php");
    require_once("Logger.php");

    $_SESSION["reg-errors"] = array();

    //logger
    $logger = new Logger();

    //database 
	$dao = new Dao();
    $dao->getConnection();

    //check email validity using PHP email filter 
    //(because email regex are funky)
    if(!filter_var($_POST["register-email"], FILTER_VALIDATE_EMAIL)){

        $_SESSION["reg-errors"][] = "email";

        $logger->addLog("NOT validated.");
        
        //backToReg(); 
    }
    else{
        $logger->addLog("Validated");
    }


    function backToReg(){

        header("Location: /register.php");
    }
    
?>