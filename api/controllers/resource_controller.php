<?php
// controllers/ResourceController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/resource.php';

class ResourceController {
    private $db;
    private $resource;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->resource = new Resource($this->db);
    }

    public function createResource($name, $quantity, $status_id) {
        $this->resource->name = $name;
        $this->resource->quantity = $quantity;
        $this->resource->status_id = $status_id;

        if ($this->resource->create()) {
            return ["message" => "Resource created successfully."];
        } else {
            return ["message" => "Failed to create resource."];
        }
    }

    public function readResources() {
        $stmt = $this->resource->read();
        $resources = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resources[] = $row;
        }

        return $resources;
    }

    public function readResource($resource_id) {
        $this->resource->resource_id = $resource_id;
        $stmt = $this->resource->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Resource not found."];
        }
    }

    public function updateResource($resource_id, $name, $quantity, $status_id) {
        $this->resource->resource_id = $resource_id;
        $this->resource->name = $name;
        $this->resource->quantity = $quantity;
        $this->resource->status_id = $status_id;

        if ($this->resource->update()) {
            return ["message" => "Resource updated successfully."];
        } else {
            return ["message" => "Failed to update resource."];
        }
    }

    public function deleteResource($resource_id) {
        $this->resource->resource_id = $resource_id;

        if ($this->resource->delete()) {
            return ["message" => "Resource deleted successfully."];
        } else {
            return ["message" => "Failed to delete resource."];
        }
    }
}
?> 