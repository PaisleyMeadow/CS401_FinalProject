<?php
    require_once("authenticated.php");
    require_once("Dao.php");
    require_once("Logger.php");
    $logger = new Logger;

    $dao = new Dao();

    //Get workspaces belonging to user 
    $workspaces = $dao->getWorkspaces($user->id); 

    //make workspaces php pages
    //pretty much adding all html to string and writing it to file

    //happens upon initial loading of app page
    if(!isset($_SESSION["change"])){
        if($workspaces != false){
            foreach($workspaces as $space){
               createWorkspaceFile($space, $dao);
            }

            $_SESSION["change"] = false;
        }
    }

    //for some reason, on heroku, my session variables are being ignored
    //making some of the below if statements not work (or something?) it's hard to debug
    //so this is a fix for that
    if(isset($_SESSION["currspace"])){
        foreach($workspaces as $space){
            if($space["name"] == $_SESSION["currspace"]){
                createWorkspaceFile($space, $dao);
            }
        }
    }

    //if new workspace(s) were added, create those pages
    if(isset($_SESSION["newSpaces"])){
        foreach($_SESSION["newSpaces"] as $newSpace){
            foreach($workspaces as $space){
                if($space["name"] == $newSpace){
                    createWorkspaceFile($space, $dao);
                }
            }
        }

        unset($_SESSION["newSpaces"]);
    }

    //if workspace color change happened or an image was added, we should redo just that page
    if(isset($_SESSION["reloadMe"])){
        foreach($workspaces as $space){
            if($space["name"] == $_SESSION["reloadMe"]){
                createWorkspaceFile($space, $dao);
            }
        }
        unset($_SESSION["reloadMe"]);
    }

function createWorkspaceFile($space, $dao)
{

    $filepath = $space["name"].".php";
    $file = fopen("bin/".$filepath, "w") or die ("Unable to access workspace.");

    //add elements for each workspace into page
    $elements = $dao->getElements($space["id"]); 
    $space["elements"] = $elements;

    $st = "<?php \$_SESSION['currspace'] = '".$space["name"]."';?>"; //session variable to know which workspace we're in when we're on that page

    //divs for workspace
    //this is only time I use inline styline, so shhhhhh (actually 1/2 times but...)
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
           