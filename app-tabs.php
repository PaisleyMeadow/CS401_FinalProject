<?php

    //Get workspaces belonging to user 
    $workspaces = $dao->getWorkspaces($user->id); 

    //make these workspace files
    foreach($workspaces as $space){
        $filepath = "bin/".$space["name"].".php";
        $file = fopen($filepath, "a") or die ("Unable to access workspace.");
    }

?>
<div id="app-container">
            <div id="tabs-container">
                <a href="app.php" class="
                    <?php if($thisPage == "app") echo "active-tab" ?> workspace-tabs ubuntu-font">All</a>
                <?php
                    if($workspaces != false){

                        foreach($workspaces as $space){

                            echo '<a href=bin/'.$space["name"].'.php class="workspace-tabs ubuntu-font">'.$space["name"].'</a>';
                        }

                    }
                ?>
                
                <!-- <a href="workspace1.php" class="
                    <?php if($thisPage  == "workspace1") echo "active-tab" ?> 
                    workspace-tabs ubuntu-font">Workspace1</a>
                <a href="workspace2.php" class="
                    <?php if($thisPage  == "workspace2") echo "active-tab" ?> 
                    workspace-tabs ubuntu-font">Workspace2</a> -->


                <div id="plus-tab" class="workspace-tabs ubuntu-font">+</div>
            </div>