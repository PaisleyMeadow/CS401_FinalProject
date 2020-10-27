<?php
    session_start();

    require_once("Dao.php");
    require_once("User.php");
    require_once("Logger.php");

    $_SESSION["login-errors"] = array();

    $logger = new Logger();

    $dao = new Dao();

    $userData = $dao->getUser($_POST["login-uname"], $_POST["login-pw"]);

    if($userData == false){
        $_SESSION["login-errors"] = "Incorrect username or password. Please try again.";
        $_SESSION["login-form"] = $_POST;
        header("Location: login.php");
        exit();
    }
    else{
        $_SESSION["authenticated"] = true;

        //create user object
        $user = new User($userData["id"], $userData["email"], $userData["username"], $userData["fname"], $userData["lname"], $userData["color"]);
    
        $_SESSION["user"] = serialize($user);

        header("Location: app.php");
        exit();
    }
?>