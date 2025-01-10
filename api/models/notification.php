<?php
// models/Notification.php

class Notification {
    private $conn;
    private $table_name = "notifications";

    public $notification_id;
    public $user_id;
    public $message;
    public $status_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, message=:message, status_id=:status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":message", $this->message);
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE notification_id = :notification_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":notification_id", $this->notification_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET user_id = :user_id, message = :message, status_id = :status_id WHERE notification_id = :notification_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->bindParam(":notification_id", $this->notification_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE notification_id = :notification_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":notification_id", $this->notification_id);
        return $stmt->execute();
    }
}
?> 