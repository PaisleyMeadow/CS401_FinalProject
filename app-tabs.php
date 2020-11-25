<?php
    require_once("authenticated.php");
    require_once("Dao.php");
    require_once("Logger.php");
    $logger = new Logger;

    $dao = new Dao();

    //Get workspaces belonging to user 
    $workspaces = $dao->getWorkspaces($user->id); 

    //make these workspaces php pages
    //pretty much adding all html to string and writing it to file
    //BUT only do this if a change has occured 
    if(!isset($_SESSION["change"]) || $_SESSION["change"] == true){
        if($workspaces != false){
            foreach($workspaces as $space){
                $filepath = $space["name"].".php";
                $file = fopen("bin/".$filepath, "w") or die ("Unable to access workspace.");

                //add elements for each workspace into page
                $elements = $dao->getElements($space["id"]); 
                $space["elements"] = $elements;

                $st = "<?php \$_SESSION['currspace'] = '".$space["name"]."';?>"; //session variable to know which workspace we're in

                //divs for workspace
                //this is only time I use inline styline, so shhhhhh
                $st .= '<div class="workspace-container">';
                $st .= '<div class="workspace-border-container" style="background-color:#'.$space["color"].';">';
                $st .= '<div class="workspace" id="'.$space["name"].'" style="background-color:#'.$space["color"].';">';

                foreach($elements as $key => $el){
                    if($el != false){
                        foreach($el as $item){
                            if($key == "images"){
                                $st .= '<div><img class="draggable" data-id="'.$item["id"].'" src="'.$item["location"].'"></div>'."\n";
                            }
                            else if($key == "notes"){
                                $st .= '<textarea class="ubuntu-font draggable" data-id="'.$item["id"].'" style="background-color:'.$item["color"].';">'.htmlspecialchars($item["content"]).'</textarea>'."\n";
                            }
                        }
                    }
                }

                $st .= "</div></div></div>";

                fwrite($file, $st);

                $_SESSION["change"] = false;
            }
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

                <div id="plus-tab" 
                    <?php
                        if($thisPage == "add"){
                            echo 'class="workspace-tabs ubuntu-font active-tab"';
                        }
                        else{
                            echo 'class="workspace-tabs ubuntu-font"';
                        }
                    ?>
                >+</div>
            </div>
           