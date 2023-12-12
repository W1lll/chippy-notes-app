<?php
namespace Models;
// Class representing thoughts table
class ThoughtTable
{
    private $_thoughtId, $_userId, $_content, $_topicId, $_createdAt, $_updatedAt;

    // Constructor to initialize ThoughtTable object with data from a database row
    public function __construct($dbRow) {
        $this->_thoughtId = $dbRow['thought_id'];
        $this->_userId = $dbRow['user_id'];
        $this->_content = $dbRow['content'];
        $this->_topicId = $dbRow['topic_id'];
        $this->_createdAt = $dbRow['created_at'];
        $this->_updatedAt = $dbRow['updated_at'];
    }

    // Getters
    public function getThoughtId() {
        return $this->_thoughtId;
    }
    public function getUserId() {
        return $this->_userId;
    }
    public function getContent() {
        return $this->_content;
    }
    public function getTopicId() {
        return $this->_topicId;
    }
    public function getCreatedAt() {
        return $this->_createdAt;
    }
    public function getUpdatedAt() {
        return $this->_updatedAt;
    }
}