<?php

require_once 'Controllers/NoteController.php';
require_once 'Models/NoteModel.php';
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$model = new NoteModel();
$controller = new NoteController($model);
$controller->displayText();