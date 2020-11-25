<?php
    $thisPage = "app";
    require_once("app-header.php");
    require_once("app-tabs.php");
?>
            <div id="workspace-icons-container">
                <?php 
                    if($workspaces != false){
                        foreach($workspaces as $space){
                            echo '<a href="workspace.php?name='.$space["name"].'" class="workspace-icon ubuntu-font" style="background-color:'.$space["color"].';">'.
                                    $space["name"].'</a>';
                        }
                    }
                    else{
                        echo '<p id="no-workspaces" class="ubuntu-font">No workspaces created yet.</p>';
                    }
                    //^implement later for showing preview elements in workspace squares >>v
                    // <a href="workspace.php" class="workspace-icon ubuntu-font">
                    //     <img class="workspace-icon-image" src="images/ex1.jpg">
                    //     <img class="workspace-icon-image" src="images/ex2.png">
                    //     <img class="workspace-icon-image" src="images/ex3.jpg">
                    //     Workspace1
                    // </a>
                ?>
            </div>
<?php 
    require_once("create-new-space-form.php");
    require_once("app-footer.php");
?>