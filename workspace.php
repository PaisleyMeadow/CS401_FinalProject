<?php
    if(isset($_GET["name"])){
        $thisPage = $_GET["name"];
    }
    else{
        $thisPage = "add";
    }
    require_once("app-header.php");
    require_once("app-tabs.php");
?>

<div class="workspace-container"> <!-- yes, this is a div for aesthetic (workspace border)-->
    <div class="workspace-border-container">
        <div class="workspace">
            <?php 
                if(isset($_GET["add"])){
                    $_SESSION["current-space"] = $_GET["name"];
                    require_once("add-new-element-form.php");   //form for adding new element
                }

                if(isset($_GET["new"])){
                    require_once("create-new-space-form.php");
                }
                else{
                    require_once("bin/".$_GET["name"].".php");
                    echo '<a id="add-element" class="ubuntu-font" href="workspace.php?name='.$_GET["name"].'&add=true">+</a>';
                }

            ?>
        </div>
    </div>
</div>

<?php
    require_once("sidebar.php");
    require_once("app-footer.php");
?>