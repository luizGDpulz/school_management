<?php
// models/Resource.php

class Resource {
    private $conn;
    private $table_name = "resources";

    public $resource_id;
    public $name;
    public $quantity;
    public $status_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, quantity=:quantity, status_id=:status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":status_id", $this->status_id);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE resource_id = :resource_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":resource_id", $this->resource_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, quantity = :quantity, status_id = :status_id WHERE resource_id = :resource_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->bindParam(":resource_id", $this->resource_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE resource_id = :resource_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":resource_id", $this->resource_id);
        return $stmt->execute();
    }
}
?> 