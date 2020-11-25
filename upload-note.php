<?php

$color = str_replace("#", "", $_POST["note-color"]);

$dao->addNote($color, $_SESSION["currspace"], $user->id);

?>