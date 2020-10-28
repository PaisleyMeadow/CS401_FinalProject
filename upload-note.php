<?php

$logger->addLog("Adding note.");

$dao->addNote($_POST["note-color"], $_SESSION["current-space"], $user->id);

?>