<?php
// controllers/FloorController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/floor.php';

class FloorController {
    private $db;
    private $floor;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->floor = new Floor($this->db);
    }

    public function createFloor($building_id, $name, $rooms_number, $color_id) {
        $this->floor->building_id = $building_id;
        $this->floor->name = $name;
        $this->floor->rooms_number = $rooms_number;
        $this->floor->color_id = $color_id;

        if ($this->floor->create()) {
            return ["message" => "Floor created successfully."];
        } else {
            return ["message" => "Failed to create floor."];
        }
    }

    public function readFloors() {
        $stmt = $this->floor->read();
        $floors = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $floors[] = $row;
        }

        return $floors;
    }

    public function readFloor($floor_id) {
        $this->floor->floor_id = $floor_id;
        $stmt = $this->floor->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Floor not found."];
        }
    }

    public function updateFloor($floor_id, $building_id, $name, $rooms_number, $color_id) {
        $this->floor->floor_id = $floor_id;
        $this->floor->building_id = $building_id;
        $this->floor->name = $name;
        $this->floor->rooms_number = $rooms_number;
        $this->floor->color_id = $color_id;

        if ($this->floor->update()) {
            return ["message" => "Floor updated successfully."];
        } else {
            return ["message" => "Failed to update floor."];
        }
    }

    public function deleteFloor($floor_id) {
        $this->floor->floor_id = $floor_id;

        if ($this->floor->delete()) {
            return ["message" => "Floor deleted successfully."];
        } else {
            return ["message" => "Failed to delete floor."];
        }
    }
}
?> 