<?php

class UserController {
    private $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function getUsers() {
        return $this->userModel->getUsers();
    }

    public function createUser($username, $password) {
        $this->userModel->createUser($username, $password);
        // Additional code like returning a success response or redirecting the user
    }

    public function updateUserPassword($userId, $newPassword) {
        $this->userModel->updateUserPassword($userId, $newPassword);
        // Handle post-update logic
    }

    public function updateUsername($userId, $newUsername) {
        $this->userModel->updateUsername($userId, $newUsername);
        // Handle post-update logic
    }

    public function deleteUser($userId) {
        $this->userModel->deleteUser($userId);
        // Handle post-delete logic
    }
}
