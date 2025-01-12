<?php
// controllers/NotificationController.php

include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/models/notification.php';

class NotificationController {
    private $db;
    private $notification;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->notification = new Notification($this->db);
    }

    public function createNotification($user_id, $message, $status_id) {
        $this->notification->user_id = $user_id;
        $this->notification->message = $message;
        $this->notification->status_id = $status_id;

        if ($this->notification->create()) {
            return json_encode(["message" => "Notification created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create notification."]);
        }
    }

    public function readNotifications() {
        $stmt = $this->notification->read();
        $notifications = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notifications[] = $row;
        }

        return json_encode($notifications);
    }

    public function readNotification($notification_id) {
        $this->notification->notification_id = $notification_id;
        $stmt = $this->notification->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            return json_encode(["message" => "Notification not found."]);
        }
    }

    public function updateNotification($notification_id, $user_id, $message, $status_id) {
        $this->notification->notification_id = $notification_id;
        $this->notification->user_id = $user_id;
        $this->notification->message = $message;
        $this->notification->status_id = $status_id;

        if ($this->notification->update()) {
            return json_encode(["message" => "Notification updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update notification."]);
        }
    }

    public function deleteNotification($notification_id) {
        $this->notification->notification_id = $notification_id;

        if ($this->notification->delete()) {
            return json_encode(["message" => "Notification deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete notification."]);
        }
    }
}
?> 