<?php

class NoteController {
    private $noteModel;

    public function __construct(NoteModel $noteModel) {
        $this->noteModel = $noteModel;
    }

    public function getAllNotes() {
        return $this->noteModel->getAllNotes();
    }

    public function getNoteById($noteId) {
        return $this->noteModel->getNoteById($noteId);
    }

    public function createNote($userId, $content, $groupId, $category, $tags, $title) {
        $this->noteModel->createNote($userId, $content, $groupId, $category, $tags, $title);
        // Additional code like returning a success response or redirecting the user
    }

    public function updateNote($noteId, $updatedValues) {
        $this->noteModel->updateNote($noteId, $updatedValues);
        // Handle post-update logic
    }

    public function deleteNote($noteId) {
        $this->noteModel->deleteNote($noteId);
        // Handle post-delete logic
    }
}
