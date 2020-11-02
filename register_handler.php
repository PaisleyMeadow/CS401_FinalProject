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
    else if($dao->validateEmail($_POST["register-email"])){ //check email is not already in database
        $_SESSION["reg-errors"]["sameemail"] = "Email already in use.";
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

    //make sure username only contains numbers/letters/underscores
    $upattern = '/^[a-zA-Z0-9_]+$/';   
    if(!preg_match($upattern, $_POST["register-uname"])){
        $_SESSION["reg-errors"]["badusername"] = "Username may only contain letters, numbers, and underscores.";
    }
    else if($dao->validateUsername($_POST["register-uname"])){  //and then check username isn't already in database
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
        $dao->addUser($_POST);

        $_SESSION["new_user"] = true;
        header("Location: login.php");
        exit();
    }
        
    



?>