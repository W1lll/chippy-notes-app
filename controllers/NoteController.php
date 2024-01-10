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
        return $this->noteModel->createNote($userId, $content, $groupId, $category, $tags, $title);
    }

    public function updateNote($noteId, $updatedValues) {
        return $this->noteModel->updateNote($noteId, $updatedValues);
    }

    public function deleteNote($noteId) {
        return $this->noteModel->deleteNote($noteId);
    }
}
