<?php
// models/Room.php

class Room {
    private $conn;
    private $table_name = "rooms";

    public $room_id;
    public $floor_id;
    public $name;
    public $capacity;
    public $room_type_id;
    public $color_id;
    public $status_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET floor_id=:floor_id, name=:name, capacity=:capacity, room_type_id=:room_type_id, color_id=:color_id, status_id=:status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":floor_id", $this->floor_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":room_type_id", $this->room_type_id);
        $stmt->bindParam(":color_id", $this->color_id);
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":room_id", $this->room_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET floor_id = :floor_id, name = :name, capacity = :capacity, room_type_id = :room_type_id, color_id = :color_id, status_id = :status_id WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":floor_id", $this->floor_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":room_type_id", $this->room_type_id);
        $stmt->bindParam(":color_id", $this->color_id);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->bindParam(":room_id", $this->room_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE room_id = :room_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":room_id", $this->room_id);
        return $stmt->execute();
    }
}
?> 