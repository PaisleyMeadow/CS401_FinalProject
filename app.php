<?php
    require_once("app-header.php");
?>
        <div id="app-container">
            <div id="tabs-container">
                <div class="active-tab workspace-tabs ubuntu-font">All</div>
                <div class="workspace-tabs ubuntu-font">Workspace1</div>
                <div class="workspace-tabs ubuntu-font">Workspace2</div>
                <div id="plus-tab" class="workspace-tabs ubuntu-font">+</div>
            </div>
            <div id="workspaces-container">
                <a href="workspace1.php" class="workspace-icon ubuntu-font">
                    <img class="workspace-icon-image" src="images/ex1.jpg">
                    <img class="workspace-icon-image" src="images/ex2.png">
                    <img class="workspace-icon-image" src="images/ex3.jpg">
                    Workspace1
                </a>
                <div class="workspace-icon ubuntu-font">
                    <img class="workspace-icon-image" src="images/ex1.jpg">
                    <img class="workspace-icon-image" src="images/ex2.png">
                    <img class="workspace-icon-image" src="images/ex3.jpg">
                    Workspace2
                </div>
            </div>
        </div>
    </body>
</html>