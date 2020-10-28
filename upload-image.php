<?php

$logger->addLog("Adding image.");

if($_POST["img_url"] == "" && $_FILES["img"]["name"] == ""){
    $_SESSION["upload-errors"] = "No image source given. Please enter a URL or upload a file.";
    header("Location: workspace.php?name=".$_SESSION["current-space"]."&add=true");
    exit();
}

//saves uploaded image file or url
if($_FILES["img"]["name"] != ""){ 
    move_uploaded_file($_FILES["img"]["tmp_name"], "bin/images/".$_FILES["img"]["name"]);
    $src = "bin/images/".$_FILES["img"]["name"];
}
else{
    $src = $_POST["img_url"];
}

//uploads file location to database
$dao->addImage($src, false, $_SESSION["current-space"], $user->id);

header("Location: workspace.php?name=".$_SESSION["current-space"]);
unset($_SESSION["current-space"]);
exit();

?>