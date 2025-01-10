<?php
// models/Status.php

class Status {
    private $conn;
    private $table_name = "statuses";

    public $status_id;
    public $status_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET status_name=:status_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status_name", $this->status_name);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status_id = :status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET status_name = :status_name WHERE status_id = :status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status_name", $this->status_name);
        $stmt->bindParam(":status_id", $this->status_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE status_id = :status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status_id", $this->status_id);
        return $stmt->execute();
    }
}
?> 