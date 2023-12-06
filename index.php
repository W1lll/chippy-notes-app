<?php

require_once 'Controllers/NoteController.php';
require_once 'Models/NoteModel.php';

$model = new NoteModel();
$controller = new NoteController($model);
$controller->displayText();