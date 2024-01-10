<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Autoloading and Database Connection
require_once 'vendor/autoload.php';
require_once 'models/Database.php';
require_once 'models/Note.php';
require_once 'models/NLP.php';
require_once 'controllers/NoteController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getDbConnection();

// Controllers
$noteModel = new NoteModel($dbConnection);
$noteController = new NoteController($noteModel);
$titleGenerator = new NLP();

// POST Request Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest($noteController, $titleGenerator);
    exit; // Stop script execution after handling POST request
}

// Fetching Notes
$userId = $_SESSION['user_id'];
$notes = $noteModel->getNotesByUserID($userId);

// Rendering Views
include 'views/partials/sideBar.php';
include 'views/noteView.php';

/**
 * Handles the POST request.
 *
 * @param NoteController $noteController The note controller.
 * @param titleGenerator $noteController The NLP system.
 */
function handlePostRequest($noteController, $titleGenerator) {
    $noteContent = $_POST['noteInputText'] ?? '';
    $noteTitle = $_POST['noteTitle'] ?? '';
    $noteId = $_POST['noteId'] ?? null;

    header('Content-Type: application/json'); // Set content type for JSON response

    if ($noteId) {
        $existingNote = $noteController->getNoteById($noteId)['Content'];
        $newContent = $existingNote.'<br/><br/>'.$noteContent;

        $noteController->updateNote($noteId, [
            'Content' => $newContent,
            'Title' => $noteTitle,
        ]);

        $newNote = $noteController->getNoteById($noteId);
        echo json_encode(['success' => true, 'content' => $newNote]);
    } else {
        // Create new note
        $userId = $_SESSION['user_id'];
        $noteTitle = $titleGenerator->categoriseNoteWithChatGPT($noteContent);
        $newNote = $noteController->createNote($userId, $noteContent, null, null, null, $noteTitle);
        echo $newNote
            ? json_encode(['success' => true, 'note' => $newNote])
            : json_encode(['success' => false, 'message' => 'Failed to create note']);
    }
}

?>
