<?php
// controllers/BuildingController.php

include_once '../config/database.php';
include_once '../models/building.php';

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
            return json_encode(["message" => "Building created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create building."]);
        }
    }

    public function readBuildings() {
        $stmt = $this->building->read();
        $buildings = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $buildings[] = $row;
        }

        return json_encode($buildings);
    }

    public function readBuilding($building_id) {
        $this->building->building_id = $building_id;
        $stmt = $this->building->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            return json_encode(["message" => "Building not found."]);
        }
    }

    public function updateBuilding($building_id, $name, $address, $floors_number, $color_id) {
        $this->building->building_id = $building_id;
        $this->building->name = $name;
        $this->building->address = $address;
        $this->building->floors_number = $floors_number;
        $this->building->color_id = $color_id;

        if ($this->building->update()) {
            return json_encode(["message" => "Building updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update building."]);
        }
    }

    public function deleteBuilding($building_id) {
        $this->building->building_id = $building_id;

        if ($this->building->delete()) {
            return json_encode(["message" => "Building deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete building."]);
        }
    }
}
?> 