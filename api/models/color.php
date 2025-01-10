<?php
// models/Color.php

class Color {
    private $conn;
    private $table_name = "colors";

    public $color_id;
    public $name;
    public $hex_code;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, hex_code=:hex_code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":hex_code", $this->hex_code);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE color_id = :color_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":color_id", $this->color_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, hex_code = :hex_code WHERE color_id = :color_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":hex_code", $this->hex_code);
        $stmt->bindParam(":color_id", $this->color_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE color_id = :color_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":color_id", $this->color_id);
        return $stmt->execute();
    }
}
?> 