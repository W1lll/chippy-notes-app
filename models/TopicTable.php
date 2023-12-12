<?php
namespace Models;
class TopicTable
{
    private $_topicId, $_name;

    // Constructor to initialize TopicTable object with data from a database row
    public function __construct($dbRow) {
        $this->_topicId = $dbRow['topic_id'];
        $this->_name = $dbRow['name'];
    }

    // Getters
    public function getTopicId() {
        return $this->_topicId;
    }
    public function getName() {
        return $this->_name;
    }
}