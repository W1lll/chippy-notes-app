<?php

require_once 'vendor/autoload.php';
require_once 'models/Database.php';
require_once 'models/Note.php';
require_once 'controllers/NoteController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getDbConnection();

$noteModel = new NoteModel($dbConnection);

$noteId = $_POST['noteId'] ?? null;
$title = $_POST['title'] ?? null;

if ($noteId && $title) {
    $noteModel->updateNote($noteId, ['Title' => $title]);
    echo('Success');
}
