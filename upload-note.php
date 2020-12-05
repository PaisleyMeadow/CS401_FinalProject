<?php

$color = str_replace("#", "", $_POST["note-color"]);

$noteId = $dao->addNote($color, $_SESSION["currspace"], $user->id);

echo print_r($noteId, true);

?>