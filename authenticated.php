<?php
//included in files that should not be accessible to non-users
    if(!isset($_SESSION["authenticated"])){
        header("Location: login.php");
    }
?>