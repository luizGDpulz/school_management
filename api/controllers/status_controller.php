<?php
// controllers/StatusController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/status.php';

class StatusController {
    private $db;
    private $status;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->status = new Status($this->db);
    }

    public function createStatus($status_name) {
        $this->status->status_name = $status_name;

        if ($this->status->create()) {
            return ["message" => "Status created successfully."];
        } else {
            return ["message" => "Failed to create status."];
        }
    }

    public function readStatuses() {
        $stmt = $this->status->read();
        $statuses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $statuses[] = $row;
        }

        return $statuses;
    }

    public function readStatus($status_id) {
        $this->status->status_id = $status_id;
        $stmt = $this->status->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Status not found."];
        }
    }

    public function updateStatus($status_id, $status_name) {
        $this->status->status_id = $status_id;
        $this->status->status_name = $status_name;

        if ($this->status->update()) {
            return ["message" => "Status updated successfully."];
        } else {
            return ["message" => "Failed to update status."];
        }
    }

    public function deleteStatus($status_id) {
        $this->status->status_id = $status_id;

        if ($this->status->delete()) {
            return ["message" => "Status deleted successfully."];
        } else {
            return ["message" => "Failed to delete status."];
        }
    }
}
?> 