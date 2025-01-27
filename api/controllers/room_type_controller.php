<?php
// controllers/RoomTypeController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/room_type.php';

class RoomTypeController {
    private $db;
    private $roomType;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->roomType = new RoomType($this->db);
    }

    public function createRoomType($type_name) {
        $this->roomType->type_name = $type_name;

        if ($this->roomType->create()) {
            return ["message" => "Room type created successfully."];
        } else {
            return ["message" => "Failed to create room type."];
        }
    }

    public function readRoomTypes() {
        $stmt = $this->roomType->read();
        $roomTypes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roomTypes[] = $row;
        }

        return $roomTypes;
    }

    public function readRoomType($type_id) {
        $this->roomType->type_id = $type_id;
        $stmt = $this->roomType->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Room type not found."];
        }
    }

    public function updateRoomType($type_id, $type_name) {
        $this->roomType->type_id = $type_id;
        $this->roomType->type_name = $type_name;

        if ($this->roomType->update()) {
            return ["message" => "Room type updated successfully."];
        } else {
            return ["message" => "Failed to update room type."];
        }
    }

    public function deleteRoomType($type_id) {
        $this->roomType->type_id = $type_id;

        if ($this->roomType->delete()) {
            return ["message" => "Room type deleted successfully."];
        } else {
            return ["message" => "Failed to delete room type."];
        }
    }
}
?> 