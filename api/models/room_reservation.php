<?php
// models/RoomReservation.php

class RoomReservation {
    private $conn;
    private $table_name = "room_reservations";

    public $reservation_id;
    public $user_id;
    public $room_id;
    public $start_time;
    public $end_time;
    public $status_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, room_id=:room_id, start_time=:start_time, end_time=:end_time, status_id=:status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":room_id", $this->room_id);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":reservation_id", $this->reservation_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET user_id = :user_id, room_id = :room_id, start_time = :start_time, end_time = :end_time, status_id = :status_id WHERE reservation_id = :reservation_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":room_id", $this->room_id);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->bindParam(":reservation_id", $this->reservation_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":reservation_id", $this->reservation_id);
        return $stmt->execute();
    }
}
?> 