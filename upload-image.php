<?php

if($_POST["img_url"] == "" && $_FILES["img"]["name"] == ""){
    $logger->addLog("No image given");
    exit();
}

//saves uploaded image file or url
if($_FILES["img"]["name"] != ""){ 
    $check = move_uploaded_file($_FILES["img"]["tmp_name"], "bin/images/".$_FILES["img"]["name"]);
    $src = "bin/images/".$_FILES["img"]["name"];
}
else{
    $src = $_POST["img_url"];
}

//uploads file location to database
//returns generated id of image inserted
$imageId = $dao->addImage($src, false, $_SESSION["currspace"], $user->id);

echo print_r($imageId, true);

?>