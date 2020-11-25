<?php
    require_once("app-header.php");
    if(isset($_GET["name"])){
        $thisPage = $_GET["name"];
    }
    else{
        $thisPage = "add";
    }
    require_once("app-tabs.php");
    
    require_once("bin/".$_GET["name"].".php");
    
    require_once("create-new-space-form.php");

    require_once("add-new-element-form.php");   
    
    require_once("sidebar.php");

    echo '<div id="delete-element"class="element-button">-</div><div id="open-add-element" class="ubuntu-font element-button">+</div>';

    require_once("app-footer.php");
?>

<script src="js/app.js"></script>