<?php
// controllers/RoomReservationController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/room_reservation.php';

class RoomReservationController {
    private $db;
    private $roomReservation;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->roomReservation = new RoomReservation($this->db);
    }

    public function createRoomReservation($user_id, $room_id, $start_time, $end_time, $status_id) {
        $this->roomReservation->user_id = $user_id;
        $this->roomReservation->room_id = $room_id;
        $this->roomReservation->start_time = $start_time;
        $this->roomReservation->end_time = $end_time;
        $this->roomReservation->status_id = $status_id;

        if ($this->roomReservation->create()) {
            return ["message" => "Room reservation created successfully."];
        } else {
            return ["message" => "Failed to create room reservation."];
        }
    }

    public function readRoomReservations() {
        $stmt = $this->roomReservation->read();
        $reservations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    public function readRoomReservation($reservation_id) {
        $this->roomReservation->reservation_id = $reservation_id;
        $stmt = $this->roomReservation->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "Room reservation not found."];
        }
    }

    public function updateRoomReservation($reservation_id, $user_id, $room_id, $start_time, $end_time, $status_id) {
        $this->roomReservation->reservation_id = $reservation_id;
        $this->roomReservation->user_id = $user_id;
        $this->roomReservation->room_id = $room_id;
        $this->roomReservation->start_time = $start_time;
        $this->roomReservation->end_time = $end_time;
        $this->roomReservation->status_id = $status_id;

        if ($this->roomReservation->update()) {
            return ["message" => "Room reservation updated successfully."];
        } else {
            return ["message" => "Failed to update room reservation."];
        }
    }

    public function deleteRoomReservation($reservation_id) {
        $this->roomReservation->reservation_id = $reservation_id;

        if ($this->roomReservation->delete()) {
            return ["message" => "Room reservation deleted successfully."];
        } else {
            return ["message" => "Failed to delete room reservation."];
        }
    }
}
?> 