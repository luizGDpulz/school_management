<?php
// models/Class.php

class ClassModel {
    private $conn;
    private $table_name = "classes";

    public $class_id;
    public $name;
    public $teacher_id;
    public $schedule;
    public $status_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, teacher_id=:teacher_id, schedule=:schedule, status_id=:status_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":teacher_id", $this->teacher_id);
        $stmt->bindParam(":schedule", $this->schedule);
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE class_id = :class_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, teacher_id = :teacher_id, schedule = :schedule, status_id = :status_id WHERE class_id = :class_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":teacher_id", $this->teacher_id);
        $stmt->bindParam(":schedule", $this->schedule);
        $stmt->bindParam(":status_id", $this->status_id);
        $stmt->bindParam(":class_id", $this->class_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE class_id = :class_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":class_id", $this->class_id);
        return $stmt->execute();
    }
}
?> 