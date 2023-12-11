<?php

/**
 * User Class
 * 
 * Manages the User.
 */
class UserModel {
    /**
     * The PDO instance for the database connection.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructor for the UserModel class.
     *
     * @param PDO $pdo A PDO instance for database operations.
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Retrieves all users from the database.
     *
     * @return array An array of all users.
     */
    public function getUsers() {
        $stmt = $this->pdo->query("SELECT * FROM Users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new user in the database.
     *
     * @param string $username The username of the new user.
     * @param string $password The password of the new user.
     */
    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Users (Username, Password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
    }

    /**
     * Updates the password for a user.
     *
     * @param int    $userId      The ID of the user.
     * @param string $newPassword The new password for the user.
     */
    public function updateUserPassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE Users SET Password = ? WHERE UserID = ?");
        $stmt->execute([$hashedPassword, $userId]);
    }

    /**
     * Updates the username for a user.
     *
     * @param int    $userId      The ID of the user.
     * @param string $newUsername The new username for the user.
     */
    public function updateUsername($userId, $newUsername) {
        $stmt = $this->pdo->prepare("UPDATE Users SET Username = ? WHERE UserID = ?");
        $stmt->execute([$newUsername, $userId]);
    }

    /**
     * Deletes a user from the database.
     *
     * @param int $userId The ID of the user to delete.
     */
    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM Users WHERE UserID = ?");
        $stmt->execute([$userId]);
    }
}
