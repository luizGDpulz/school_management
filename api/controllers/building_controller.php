<?php
// controllers/BuildingController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/building.php';

class BuildingController {
    private $db;
    private $building;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->building = new Building($this->db);
    }

    public function createBuilding($name, $address, $floors_number, $color_id) {
        $this->building->name = $name;
        $this->building->address = $address;
        $this->building->floors_number = $floors_number;
        $this->building->color_id = $color_id;

        if ($this->building->create()) {
            return ["message" => "Building created successfully."];
        } else {
            return ["message" => "Failed to create building."];
        }
    }

    public function readBuildings() {
        $stmt = $this->building->read();
        $buildings = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $buildings[] = $row;
        }

        return $buildings;
    }

    public function readBuilding($building_id) {
        $this->building->building_id = $building_id;
        $stmt = $this->building->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Building not found."];
        }
    }

    public function updateBuilding($building_id, $name, $address, $floors_number, $color_id) {
        $this->building->building_id = $building_id;
        $this->building->name = $name;
        $this->building->address = $address;
        $this->building->floors_number = $floors_number;
        $this->building->color_id = $color_id;

        if ($this->building->update()) {
            return ["message" => "Building updated successfully."];
        } else {
            return ["message" => "Failed to update building."];
        }
    }

    public function deleteBuilding($building_id) {
        $this->building->building_id = $building_id;

        if ($this->building->delete()) {
            return ["message" => "Building deleted successfully."];
        } else {
            return ["message" => "Failed to delete building."];
        }
    }
}
?> 