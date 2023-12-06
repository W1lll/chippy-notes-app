<?php

// Controllers/NoteController.php
class NoteController {
    private $model;

    public function __construct($noteModel) {
        $this->model = $noteModel;
    }

    public function displayText() {
        $displayText = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputText'])) {
            $displayText = $this->model->getText($_POST['inputText']);
        }

        require_once 'Views/noteView.php';
    }
}
