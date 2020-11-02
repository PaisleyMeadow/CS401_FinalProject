<?php
    require_once("authenticated.php");
    require_once("Dao.php");

    $dao = new Dao();

    //if adding new workspace, do before creating tabs so the new one shows up too
    if(isset($_GET["workspace-name"])){

        //returns false if workspace name already exists
        $check = $dao->addWorkspace($_GET["workspace-name"], $_GET["workspace-color"], $user->id);


        if(!$check){    //if the workspace already exists, informs user and goes back to new workspace form
            $_SESSION["workspace-errors"] = "Workspace already exists. Please try again.";

            header("Location: workspace.php?new");
            exit();
        }
        else{
            $_GET["name"] = $_GET["workspace-name"];
            $thisPage = "";
        }
    }

    //Get workspaces belonging to user 
    $workspaces = $dao->getWorkspaces($user->id); 

    //make these workspaces php pages
    if($workspaces != false){
        foreach($workspaces as $space){
            $filepath = $space["name"].".php";
            $file = fopen("bin/".$filepath, "w") or die ("Unable to access workspace.");

            //add elements for each workspace into page
            $elements = $dao->getElements($space["id"]); 
            $space["elements"] = $elements;

            $st = "";
            foreach($elements as $key => $el){
                if($el != false){
                    foreach($el as $item){
                        if($key == "images"){
                            $st .= '<a href="'.$item["location"].'"><img class="" src="'.$item["location"].'"></a>'."\n";
                        }
                        else if($key == "notes"){
                            $st .= '<textarea class="ubuntu-font">'.htmlspecialchars($item["content"]).'</textarea>'."\n";
                        }
                    }
                }
            }
            fwrite($file, $st);
        }
    }

?>
 
<div id="app-container">
            <div id="tabs-container">
                <a href="app.php" class="
                    <?php if($thisPage == "app") echo "active-tab" ?> workspace-tabs ubuntu-font">All</a>
                <?php
                    if($workspaces != false){
                        foreach($workspaces as $space){

                            echo '<a href="workspace.php?name='.htmlspecialchars($space["name"]);
                            if(isset($_GET["name"]) && $space["name"] == $_GET["name"]){
                                echo '" class="workspace-tabs ubuntu-font active-tab">'.htmlspecialchars($space["name"]).'</a>';
                            }
                            else{
                                echo '" class="workspace-tabs ubuntu-font">'.htmlspecialchars($space["name"]).'</a>';
                            }
                        }

                    }
                ?>

                <a href="workspace.php?new=true" id="plus-tab" 
                    <?php
                        if($thisPage == "add"){
                            echo 'class="workspace-tabs ubuntu-font active-tab"';
                        }
                        else{
                            echo 'class="workspace-tabs ubuntu-font"';
                        }
                    ?>
                >+</a>
            </div>
           