<?php
// controllers/ColorController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/color.php';

class ColorController {
    private $db;
    private $color;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->color = new Color($this->db);
    }

    public function createColor($name, $hex_code) {
        $this->color->name = $name;
        $this->color->hex_code = $hex_code;

        if ($this->color->create()) {
            return json_encode(["message" => "Color created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create color."]);
        }
    }

    public function readColors() {
        $stmt = $this->color->read();
        $colors = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $colors[] = $row;
        }

        return json_encode($colors);
    }

    public function readColor($color_id) {
        $this->color->color_id = $color_id;
        $stmt = $this->color->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            return json_encode(["message" => "Color not found."]);
        }
    }

    public function updateColor($color_id, $name, $hex_code) {
        $this->color->color_id = $color_id;
        $this->color->name = $name;
        $this->color->hex_code = $hex_code;

        if ($this->color->update()) {
            return json_encode(["message" => "Color updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update color."]);
        }
    }

    public function deleteColor($color_id) {
        $this->color->color_id = $color_id;

        if ($this->color->delete()) {
            return json_encode(["message" => "Color deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete color."]);
        }
    }
}
?> 