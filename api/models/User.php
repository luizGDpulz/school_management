<?php
// models/User.php

class User {
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $name;
    public $email;
    public $role;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to create a new user
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, role=:role, password=:password";

        $stmt = $this->conn->prepare($query);

        // Sanitizing the data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Binding parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method to read all users
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method to read a specific user
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    // Method to update a user
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, role = :role WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        // Sanitizing the data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Binding parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":user_id", $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method to delete a user
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
