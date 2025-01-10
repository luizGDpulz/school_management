<?php
// models/Floor.php

class Floor {
    private $conn;
    private $table_name = "floors";

    public $floor_id;
    public $building_id;
    public $name;
    public $rooms_number;
    public $color_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET building_id=:building_id, name=:name, rooms_number=:rooms_number, color_id=:color_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":building_id", $this->building_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":rooms_number", $this->rooms_number);
        $stmt->bindParam(":color_id", $this->color_id);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE floor_id = :floor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":floor_id", $this->floor_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET building_id = :building_id, name = :name, rooms_number = :rooms_number, color_id = :color_id WHERE floor_id = :floor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":building_id", $this->building_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":rooms_number", $this->rooms_number);
        $stmt->bindParam(":color_id", $this->color_id);
        $stmt->bindParam(":floor_id", $this->floor_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE floor_id = :floor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":floor_id", $this->floor_id);
        return $stmt->execute();
    }
}
?> 