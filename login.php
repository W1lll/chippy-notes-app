<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'vendor/autoload.php';
require_once 'models/Database.php';
require_once 'models/User.php';

session_start();

var_dump($_SESSION);
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getDbConnection();
$userModel = new UserModel($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Authentication logic
        $user = $userModel->getUserByUsername($username);
        if ($user && password_verify($password, $user['Password'])) {
            // User authenticated successfully
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            // Redirect to a logged-in page
            header('Location: index.php');
        } else {
            // Authentication failed
            header('Location: login.php?error=invalid_credentials');
        }
    } elseif ($action === 'register') {
        $newUsername = $_POST['new_username'];
        $newPassword = $_POST['new_password'];

        // Registration logic
        if ($userModel->getUserByUsername($newUsername)) {
            // Username already exists
            header('Location: login.php?error=username_exists');
        } else {
            // Create new user
            $userModel->createUser($newUsername, $newPassword);
            // Redirect to login page or directly log the user in
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            // Redirect to a logged-in page
            header('Location: index.php');
        }
    } else {
        // Invalid action
        header('Location: login.php?error=invalid_action');
    }
    exit;
}

include 'views/login.php';
