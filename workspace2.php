<?php
    $thisPage = "workspace2";
    require_once("app-header.php");
    require_once("app-tabs.php");
?>

<div class="workspace-container"> <!-- yes, this is a div for aesthetic -->
    <div class="workspace-border-container">
        <div class="workspace">
            <textarea class="ubuntu-font">This is another note, on a different board.</textarea>
            <a href="images/ex4.jpg"><img class="" src="images/ex4.jpg"></a>
            <a href="images/ex5.png"><img class="" src="images/ex5.jpg"></a>
            <a href="images/ex6.jpg"><img class="" src="images/ex6.jpg"></a>
        </div>
    </div>
</div>

<?php
    require_once("sidebar.php");
    require_once("app-footer.php");
?>