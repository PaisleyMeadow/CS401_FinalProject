<div id="add-new-workspace-container">
    <form id="new-workspace-form">
        <input type="text" name="workspace-name" 
            <?php
                if(isset($_SESSION["workspace-errors"])){
                    echo "class=login-error";
                }
            ?>
        placeholder="Name" required>
        <input type="text" name="workspace-color" value="fdf0d5" placeholder="Color">
        <input type="submit" value="Create New">
    </form>
</div> 

<div class="errors-container">
    <?php
        if(isset($_SESSION["workspace-errors"])){
            echo '<div class="errors ubuntu-font">'.$_SESSION["workspace-errors"].'</div><br>';
            unset($_SESSION["workspace-errors"]);
        }
    ?>
</div>