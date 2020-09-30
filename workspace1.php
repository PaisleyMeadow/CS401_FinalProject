<?php
    $thisPage = "workspace1";
    require_once("app-header.php");
    require_once("app-tabs.php");
?>

<div class="workspace-container"> <!-- yes, this is a div for aesthetic -->
    <div class="workspace-border-container">
        <div class="workspace">
            <a href="images/ex1.jpg"><img class="" src="images/ex1.jpg"></a>
            <a href="images/ex2.png"><img class="" src="images/ex2.png"></a>
            <a href="images/ex3.jpg"><img class="" src="images/ex3.jpg"></a>
            <textarea class="ubuntu-font">This is a note.</textarea>
        </div>
    </div>
</div>

<?php
    require_once("sidebar.php");
    require_once("app-footer.php");
?>