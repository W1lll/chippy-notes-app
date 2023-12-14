<?php

/**
 * Note Class
 * 
 * Manages the Note.
 */
class NoteModel {
    /**
     * The PDO instance for database connection.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructor for the NoteModel class.
     *
     * @param PDO $pdo A PDO instance for database operations.
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Retrieves all notes from the database, sorted by last modification date in descending order.
     *
     * @return array An array of all notes.
     */
    public function getAllNotes() {
        $stmt = $this->pdo->query("SELECT * FROM Notes ORDER BY LastModified DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a specific note by its ID.
     *
     * @param int $noteId The ID of the note.
     * @return array|null The note data or null if not found.
     */
    public function getNoteById($noteId) {
        $stmt = $this->pdo->prepare("SELECT * FROM Notes WHERE NoteID = ?");
        $stmt->execute([$noteId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves notes that match a specific title.
     *
     * @param string $title The title of the notes.
     * @return array An array of notes that match the title.
     */
    public function getNoteByTitle($title) {
        $stmt = $this->pdo->prepare("SELECT * FROM Notes WHERE Title = ?");
        $stmt->execute([$title]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all collaborative notes.
     *
     * @return array An array of collaborative notes.
     */
    public function getCollaborativeNotes() {
        $stmt = $this->pdo->query("SELECT * FROM Notes WHERE IsCollaborative = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all notes, sorted by the number of upvotes in descending order.
     *
     * @return array An array of notes sorted by upvotes.
     */
    public function getNotesSortedByUpvotes() {
        $stmt = $this->pdo->query("SELECT * FROM Notes ORDER BY Upvotes DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves notes that belong to a specific category.
     *
     * @param string $category The category to filter notes by.
     * @return array An array of notes that belong to the specified category.
     */
    public function getNotesByCategory($category) {
        $stmt = $this->pdo->prepare("SELECT * FROM Notes WHERE Category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves notes that contain a specific tag.
     *
     * @param string $tag The tag to filter notes by.
     * @return array An array of notes that contain the specified tag.
     */
    public function getNotesByTag($tag) {
        $stmt = $this->pdo->prepare("SELECT * FROM Notes WHERE Tags LIKE ?");
        $stmt->execute(["%$tag%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new note with the given details.
     *
     * @param int    $userId          The ID of the user creating the note.
     * @param string $content         The content of the note.
     * @param int    $groupId         The group ID the note belongs to.
     * @param string $category        The category of the note.
     * @param string $tags            The tags associated with the note.
     * @param string $title           The title of the note.
     */
    public function createNote($userId, $content, $groupId, $category, $tags, $title) {
        $stmt = $this->pdo->prepare("INSERT INTO Notes (UserID, Content, GroupID, Category, Tags, Title) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $content, $groupId, $category, $tags, $title]);
    }

    /**
     * Updates the details of an existing note with optional parameters.
     *
     * @param int         $noteId          The ID of the note to update.
     * @param array       $updatedValues   An associative array of column names and their new values.
     */
    public function updateNote($noteId, $updatedValues) {
        $query = "UPDATE Notes SET ";
        $fieldsToUpdate = [];
        foreach ($updatedValues as $column => $value) {
            $fieldsToUpdate[] = "$column = :$column";
        }

        // Join all fields to be updated with a comma
        $query .= implode(", ", $fieldsToUpdate);
        $query .= " WHERE NoteID = :noteId";

        // Prepare the statement
        $stmt = $this->pdo->prepare($query);
        foreach ($updatedValues as $column => &$value) {
            $stmt->bindParam(":$column", $value);
        }

        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
    }

    /**
     * Deletes a note from the database.
     *
     * @param int $noteId The ID of the note to delete.
     */
    public function deleteNote($noteId) {
        $stmt = $this->pdo->prepare("DELETE FROM Notes WHERE NoteID = ?");
        $stmt->execute([$noteId]);
    }

    public function getNotesByUserID($userId) {
        // Prepare a SELECT statement to fetch notes by user ID
        $stmt = $this->pdo->prepare("SELECT * FROM Notes WHERE UserID = ?");
        $stmt->execute([$userId]);

        // Fetch and return the notes
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
