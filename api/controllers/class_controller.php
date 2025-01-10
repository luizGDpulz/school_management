<?php
// controllers/ClassController.php

include_once '../config/database.php';
include_once '../models/class.php';

class ClassController {
    private $db;
    private $class;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->class = new ClassModel($this->db);
    }

    public function createClass($name, $teacher_id, $schedule, $status_id) {
        $this->class->name = $name;
        $this->class->teacher_id = $teacher_id;
        $this->class->schedule = $schedule;
        $this->class->status_id = $status_id;

        if ($this->class->create()) {
            return json_encode(["message" => "Class created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create class."]);
        }
    }

    public function readClasses() {
        $stmt = $this->class->read();
        $classes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $classes[] = $row;
        }

        return json_encode($classes);
    }

    public function readClass($class_id) {
        $this->class->class_id = $class_id;
        $stmt = $this->class->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            return json_encode(["message" => "Class not found."]);
        }
    }

    public function updateClass($class_id, $name, $teacher_id, $schedule, $status_id) {
        $this->class->class_id = $class_id;
        $this->class->name = $name;
        $this->class->teacher_id = $teacher_id;
        $this->class->schedule = $schedule;
        $this->class->status_id = $status_id;

        if ($this->class->update()) {
            return json_encode(["message" => "Class updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update class."]);
        }
    }

    public function deleteClass($class_id) {
        $this->class->class_id = $class_id;

        if ($this->class->delete()) {
            return json_encode(["message" => "Class deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete class."]);
        }
    }
}
?> 