<?php
    session_start();

    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $_SESSION["reg-errors"] = array();

    //logger
    $logger = new Logger();

    //database 
	$dao = new Dao();

    //check email validity using PHP email filter 
    //(because email regex are funky)
    if(!filter_var($_POST["register-email"], FILTER_VALIDATE_EMAIL)){

        $_SESSION["reg-errors"]["email"] = "Invalid email.";
    }

    //check passwords match
    if(strcmp($_POST["register-password"], $_POST["register-password-confirm"]) != 0){

        $_SESSION["reg-errors"]["nomatch"] = "Passwords do not match.";
    }

    //check if password fulfils requirements (aat least capital letter and digit. length between 6-64)
    $pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,64}$/';
    if(!preg_match($pattern, $_POST["register-password"])){

        $_SESSION["reg-errors"]["badpass"] = "Password does not fulfill requirements: at least 6 characters, including 1 capital letter and 1 digit.";
    }

    //now check if email and username are not in use    
    if($dao->validateEmail($_POST["register-email"])){
        $_SESSION["reg-errors"]["sameemail"] = "Email already in use.";
    }
    
    if($dao->validateUsername($_POST["register-uname"])){
        $_SESSION["reg-errors"]["sameusername"] = "Username already in use.";
    }

    $logger->addLog("Errors:".print_r($_SESSION, true));

    //if any errors, return to registration
    if(count($_SESSION["reg-errors"]) != 0){
        $_SESSION["reg-form"] = $_POST;
        header("Location: /register.php");
        exit();
    }
    else{
        $_SESSION["new_user"] = true;
        header("Location: login.php");
        exit();
    }
        
    



?>