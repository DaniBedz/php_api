<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Database
{
    // DB Params
    private $_host;
    private $_db_name;
    private $_username;
    private $_password;
    private $_connection;

    public function __construct()
    {
        // Load .env file into $_ENV super global
        $_dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $_dotenv->load();

        $this->_host = $_ENV['DB_HOST'];
        $this->_db_name = $_ENV['DB_NAME'];
        $this->_username = $_ENV['DB_USER'];
        $this->_password = $_ENV['DB_PASSWORD'];
    }

    /**
     * DB Connect
     *
     * @return object;
     * */
    public function connect()
    {
        $this->_connection = null;

        try {
            $dsn = "mysql:host=$this->_host;dbname=$this->_db_name";
            $this->_connection = new PDO($dsn, $this->_username, $this->_password);
        } catch(PDOException $error) {
            echo 'Connection Error: ' . $error->getMessage();
        }
        return $this->_connection;
    }
}