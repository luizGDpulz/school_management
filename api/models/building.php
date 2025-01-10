<?php
// models/Building.php

class Building {
    private $conn;
    private $table_name = "buildings";

    public $building_id;
    public $name;
    public $address;
    public $floors_number;
    public $color_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, address=:address, floors_number=:floors_number, color_id=:color_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":floors_number", $this->floors_number);
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE building_id = :building_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":building_id", $this->building_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, address = :address, floors_number = :floors_number, color_id = :color_id WHERE building_id = :building_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":floors_number", $this->floors_number);
        $stmt->bindParam(":color_id", $this->color_id);
        $stmt->bindParam(":building_id", $this->building_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE building_id = :building_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":building_id", $this->building_id);
        return $stmt->execute();
    }
}
?> 