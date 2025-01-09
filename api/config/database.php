<?php
// config/database.php

class Database {
    // Database credentials
    private $host = "localhost";
    private $db_name = "school_management";
    private $username = "root";
    private $password = "";
    public $conn;

    // Method to get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            // Create a new PDO instance
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Handle connection error
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
