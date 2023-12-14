<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$noteController = new NoteController($noteModel);

// Check if form data has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noteContent = $_POST['noteInputText'] ?? '';
    $noteTitle = $_POST['noteTitle'] ?? '';
    $noteId = $_POST['noteId'] ?? null;

    if ($noteId) {
        // Update note
        $noteController->updateNote($noteId, [
            'Content' => $noteContent,
            'Title' => $noteTitle,
            // Add other fields as needed
        ]);
    } else {
        // Create new note
        $userId = $_SESSION['user_id']; // Example user ID
        $noteController->createNote($userId, $noteContent, null, null, null, $noteTitle);
    }
    
    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$userId = $_SESSION['user_id']; // Get the user ID from the session
$notes = $noteModel->getNotesByUserID($userId); // Fetch notes for the user

include 'views/partials/sideBar.php';

// Include the view
include 'views/noteView.php';