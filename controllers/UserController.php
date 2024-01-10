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
    }

    public function updateUserPassword($userId, $newPassword) {
        $this->userModel->updateUserPassword($userId, $newPassword);
    }

    public function updateUsername($userId, $newUsername) {
        $this->userModel->updateUsername($userId, $newUsername);
    }

    public function deleteUser($userId) {
        $this->userModel->deleteUser($userId);
    }
}
