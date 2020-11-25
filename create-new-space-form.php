<div id="add-new-workspace-container">
    <form id="new-workspace-form" method="POST">
        <input type="text" name="workspace-name" 
            <?php
                if(isset($_SESSION["workspace-errors"])){
                    echo "class=login-error";
                }
            ?>
        placeholder="Name" pattern='^[a-zA-Z0-9]*$' required>
        <input type="text" name="workspace-color" id="new-workspace-color" autocomplete="off" required>
        <input type="submit" value="Create New">
        <button type="button" id="new-workspace-cancel">Cancel</button><br>
        <p class="ubuntu-font">*Workspace names may only contain letters and numbers (no spaces or special characters).</p>
    </form>
</div> 