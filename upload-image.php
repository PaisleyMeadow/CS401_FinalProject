<?php

if($_POST["img_url"] == "" && $_FILES["img"]["name"] == ""){
    $logger->addLog("No image given");
    exit();
}

//saves uploaded image file or url
if($_FILES["img"]["name"] != ""){ 
    move_uploaded_file($_FILES["img"]["tmp_name"], "uploaded/".$_FILES["img"]["name"]);
    $src = "uploaded/".$_FILES["img"]["name"];
}
else{
    $src = $_POST["img_url"];
}

//uploads file location to database
$dao->addImage($src, false, $_SESSION["currspace"], $user->id);


?>