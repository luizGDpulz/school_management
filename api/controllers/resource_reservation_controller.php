<?php
// controllers/ResourceReservationController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/resource_reservation.php';

class ResourceReservationController {
    private $db;
    private $resourceReservation;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->resourceReservation = new ResourceReservation($this->db);
    }

    public function createResourceReservation($user_id, $resource_id, $start_time, $end_time, $status_id) {
        $this->resourceReservation->user_id = $user_id;
        $this->resourceReservation->resource_id = $resource_id;
        $this->resourceReservation->start_time = $start_time;
        $this->resourceReservation->end_time = $end_time;
        $this->resourceReservation->status_id = $status_id;

        if ($this->resourceReservation->create()) {
            return ["message" => "Resource reservation created successfully."];
        } else {
            return ["message" => "Failed to create resource reservation."];
        }
    }

    public function readResourceReservations() {
        $stmt = $this->resourceReservation->read();
        $reservations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    public function readResourceReservation($reservation_id) {
        $this->resourceReservation->reservation_id = $reservation_id;
        $stmt = $this->resourceReservation->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Resource reservation not found."];
        }
    }

    public function updateResourceReservation($reservation_id, $user_id, $resource_id, $start_time, $end_time, $status_id) {
        $this->resourceReservation->reservation_id = $reservation_id;
        $this->resourceReservation->user_id = $user_id;
        $this->resourceReservation->resource_id = $resource_id;
        $this->resourceReservation->start_time = $start_time;
        $this->resourceReservation->end_time = $end_time;
        $this->resourceReservation->status_id = $status_id;

        if ($this->resourceReservation->update()) {
            return ["message" => "Resource reservation updated successfully."];
        } else {
            return ["message" => "Failed to update resource reservation."];
        }
    }

    public function deleteResourceReservation($reservation_id) {
        $this->resourceReservation->reservation_id = $reservation_id;

        if ($this->resourceReservation->delete()) {
            return ["message" => "Resource reservation deleted successfully."];
        } else {
            return ["message" => "Failed to delete resource reservation."];
        }
    }
}
?> 