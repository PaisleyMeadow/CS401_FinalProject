<div id="new-element-container">
    <h2 class="ubuntu-font">What type of element would you like to add?</h2>
    <form id="new-element-form" class="ubuntu-font" method="post" action="upload-element.php" enctype="multipart/form-data">
        <h2><input type="radio" name="type" value="note" id="note-opt">
        <label for="note-opt">Note</label></h2><br>
        <div id="note-color-div">
            <label for="note-color">Note Color: </label>
            <input type="text" name="note-color" value="#fdf0d5" id="note-color-picker">
        </div>
        <h2><input type="radio" name="type" value="image" id="image-opt" required>
        <label for="image-opt">Image</label></h2><br>
        <div id="upload-image-div">
            <label for="img_url">Image URL: </label>
            <input type="text" name="img_url" placeholder="URL">
            <p>OR
            <!-- <label for="img" id="file-upload-label">Upload Image File</label></p><br> -->
            <input type="file" id="img" name="img" value="img" accept="image/*">
            <p> You can also drag and drop an image onto the workspace at any time.</p>
        </div>
        <br>
        <input type="submit" value="Add" id="add-element">
        <button id="close-new-element">Cancel</button>
    </form>
</div>
<div class="errors-container">
    <?php
        if(isset($_SESSION["upload-errors"])){
            echo '<div class="errors ubuntu-font">'.$_SESSION["upload-errors"].'</div><br>';
            unset($_SESSION["upload-errors"]);
        }
    ?>
</div>