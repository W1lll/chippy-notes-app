<?php

/**
 * Database Singleton Class
 * 
 * Manages the database connection using PDO and implements the Singleton pattern to ensure only one instance of the database connection is created.
 */
class Database {
    /**
     * The single instance of the Database class.
     *
     * @var Database|null
     */
    protected static $_instance = null;

    /**
     * The PDO database handle.
     *
     * @var PDO|null
     */
    protected $_dbHandle = null;

    /**
     * Private constructor to prevent creating a new instance of the class via the `new` operator from outside of this class.
     *
     * @param string $username Database username.
     * @param string $password Database password.
     * @param string $host     Database host.
     * @param string $database Database name.
     */
    private function __construct($username, $password, $host, $database) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            // Handle the exception here
            // Consider logging this error instead of just displaying it
            error_log($e->getMessage());
            exit('Database connection error.');
        }
    }

    /**
     * Prevent cloning of the instance.
     */
    private function __clone() {}

    /**
     * Prevent unserializing of the instance.
     */
    public function __wakeup() {}

    /**
     * Returns the singleton instance of the Database.
     *
     * @return Database The Database instance.
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $host = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];

            self::$_instance = new self($username, $password, $host, $dbName);
        }

        return self::$_instance;
    }

    /**
     * Gets the PDO database connection handle.
     *
     * @return PDO|null The PDO database connection handle.
     */
    public function getDbConnection() {
        return $this->_dbHandle;
    }

    /**
     * Destructor to ensure the database connection is closed when the instance is destroyed.
     */
    public function __destruct() {
        $this->_dbHandle = null;
    }
}
