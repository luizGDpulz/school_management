<?php
// models/RoomType.php

class RoomType {
    private $conn;
    private $table_name = "room_types";

    public $type_id;
    public $type_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET type_name=:type_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":type_name", $this->type_name);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE type_id = :type_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":type_id", $this->type_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET type_name = :type_name WHERE type_id = :type_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":type_name", $this->type_name);
        $stmt->bindParam(":type_id", $this->type_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE type_id = :type_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":type_id", $this->type_id);
        return $stmt->execute();
    }
}
?> 