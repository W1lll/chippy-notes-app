
<?php
// getNoteContent.php
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

$noteId = $_GET['noteId'] ?? null;
$userId = $_GET['userId'] ?? null;
if ($noteId) {
    $note = $noteModel->getNoteById($noteId);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($note);
}

if ($userId) {
    $notes = $noteModel->getNotesByUserID($userId);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($notes);
}