<?php

require_once 'vendor/autoload.php';
require_once 'models/Database.php';
require_once 'models/User.php';

session_start();

// Redirect if Already Logged In
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getDbConnection();
$userModel = new UserModel($dbConnection);

// Check for AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// POST Request Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest($userModel, $isAjax);
    exit; // Stop script execution after handling POST request
}

// Rendering View
include 'views/login.php';

/**
 * Handles the POST request.
 */
function handlePostRequest($userModel, $isAjax) {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'login':
            handleLogin($userModel, $isAjax);
            break;
        case 'register':
            handleRegistration($userModel, $isAjax);
            break;
        default:
            http_response_code(400); // Bad request
            sendResponse($isAjax, ['error' => 'Invalid action'], 'login.php?error=invalid_action');
            break;
    }
}

/**
 * Handles user login.
 */
function handleLogin($userModel, $isAjax) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $userModel->getUserByUsername($username);
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        sendResponse($isAjax, $user, 'index.php');
    } else {
        http_response_code(401); // Unauthorized
        sendResponse($isAjax, ['error' => 'Invalid credentials'], 'login.php?error=invalid_credentials');
    }
}

/**
 * Handles user registration.
 */
function handleRegistration($userModel, $isAjax) {
    $newUsername = $_POST['new_username'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    if ($userModel->getUserByUsername($newUsername)) {
        http_response_code(409); // Conflict
        sendResponse($isAjax, ['error' => 'Username already exists'], 'login.php?error=username_exists');
    } else {
        $userModel->createUser($newUsername, $newPassword);
        $_SESSION['user_id'] = $userModel->getUserByUsername($newUsername)['UserID'];
        $_SESSION['username'] = $newUsername;
        sendResponse($isAjax, ['success' => true, 'username' => $newUsername], 'index.php');
    }
}

/**
 * Send JSON response for AJAX or redirect for standard requests.
 */
function sendResponse($isAjax, $data, $redirectUrl) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        header('Location: ' . $redirectUrl);
    }
}

?>
