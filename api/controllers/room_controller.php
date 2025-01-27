<?php
// controllers/RoomController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/room.php';

class RoomController {
    private $db;
    private $room;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->room = new Room($this->db);
    }

    public function createRoom($floor_id, $name, $capacity, $room_type_id, $color_id, $status_id) {
        $this->room->floor_id = $floor_id;
        $this->room->name = $name;
        $this->room->capacity = $capacity;
        $this->room->room_type_id = $room_type_id;
        $this->room->color_id = $color_id;
        $this->room->status_id = $status_id;

        if ($this->room->create()) {
            return ["message" => "Room created successfully."];
        } else {
            return ["message" => "Failed to create room."];
        }
    }

    public function readRooms() {
        $stmt = $this->room->read();
        $rooms = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rooms[] = $row;
        }

        return $rooms;
    }

    public function readRoom($room_id) {
        $this->room->room_id = $room_id;
        $stmt = $this->room->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Room not found."];
        }
    }

    public function updateRoom($room_id, $floor_id, $name, $capacity, $room_type_id, $color_id, $status_id) {
        $this->room->room_id = $room_id;
        $this->room->floor_id = $floor_id;
        $this->room->name = $name;
        $this->room->capacity = $capacity;
        $this->room->room_type_id = $room_type_id;
        $this->room->color_id = $color_id;
        $this->room->status_id = $status_id;

        if ($this->room->update()) {
            return ["message" => "Room updated successfully."];
        } else {
            return ["message" => "Failed to update room."];
        }
    }

    public function deleteRoom($room_id) {
        $this->room->room_id = $room_id;

        if ($this->room->delete()) {
            return ["message" => "Room deleted successfully."];
        } else {
            return ["message" => "Failed to delete room."];
        }
    }
}
?> 