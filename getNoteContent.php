
<?php
// getNoteContent.php
require_once 'vendor/autoload.php'; // Adjust the path as needed
require_once 'models/Database.php';
require_once 'models/Note.php';
require_once 'controllers/NoteController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getDbConnection();

$noteModel = new NoteModel($dbConnection);

$noteId = $_GET['noteId'] ?? null;
if ($noteId) {
    $note = $noteModel->getNoteById($noteId);
    echo json_encode($note);
    // You can add more HTML structure here as needed
}