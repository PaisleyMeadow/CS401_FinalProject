<div id="new-element-container">
    <form id="new-element-form" method="post" action="upload-element.php" enctype="multipart/form-data">
        <input type="radio" name="type" value="note">
        <label for="note">Note</label><br>
        <label for="note-color">Note Color: </label>
        <input type="text" name="note-color" value="fdf0d5"><br>
        <input type="radio" name="type" value="image" required>
        <label for="image">Image</label><br>
        <label for="img_url">Upload Image URL: </label>
        <input type="text" name="img_url" placeholder="URL">
        <label for="img">OR Upload Image File: </label>
        <input type="file" id="img" name="img" value="img" accept="image/*">
        <input type="submit" value="Add">
        <!-- figure out video stuff later-->
        <!-- <input type="radio" name="type" value="image">
        <label for="image">Image</label> -->

</div>
<div class="errors-container">
    <?php
        if(isset($_SESSION["upload-errors"])){
            echo '<div class="errors ubuntu-font">'.$_SESSION["upload-errors"].'</div><br>';
            unset($_SESSION["upload-errors"]);
        }
    ?>
</div>