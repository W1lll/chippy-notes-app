<?php

class UserTable
{
    // Properties
    private $_userId, $_nickname, $_ipAddress, $_userIdentifier, $_lastVisit;

    // Constructor to initialize UserTable object with data from a database row
    public function __construct($dbRow) {
        $this->_userId = $dbRow['user_id'];
        $this->_nickname = $dbRow['nickname'];
        $this->_ipAddress = $dbRow['ip_address'];
        $this->_userIdentifier = $dbRow['user_identifier'];
        $this->_lastVisit = $dbRow['last_visit'];
    }

    // Getters
    public function getUserId() {
        return $this->_userId;
    }
    public function getNickname() {
        return $this->_nickname;
    }
    public function getIpAddress() {
        return $this->_ipAddress;
    }
    public function getUserIdentifier() {
        return $this->_userIdentifier;
    }
    public function getLastVisit() {
        return $this->_lastVisit;
    }
}