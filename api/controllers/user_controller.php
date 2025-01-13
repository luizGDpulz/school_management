<?php
// controllers/user_controller.php

include_once ROOT_PATH . '/config/database.php'; 
include_once ROOT_PATH . '/models/user.php'; 
include_once ROOT_PATH . '/utils/password_manager.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        // Instantiate database and user model
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Method to create a new user
    public function createUser($name, $email, $role, $password) {
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->password = PasswordManager::createPasswordHash($password);

        if ($this->user->create()) {
            return json_encode(["message" => "User created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create user."]);
        }
    }

    // Method to read all users
    public function readUsers() {
        $stmt = $this->user->read();
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }

        return json_encode($users);
    }

    // Method to read a specific user
    public function readUser($user_id) {
        $this->user->user_id = $user_id;
        $stmt = $this->user->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            return json_encode(["message" => "User not found."]);
        }
    }

    // Method to update user attributes
    public function updateUser($user_id, $name, $email, $role) {
        $this->user->user_id = $user_id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;

        if ($this->user->update()) {
            return json_encode(["message" => "User updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update user."]);
        }
    }

    // Method to update user password
    public function updateUserPassword($user_id, $new_password) {
        $this->user->user_id = $user_id;
        $this->user->password = PasswordManager::createPasswordHash($new_password);

        if ($this->user->updatePassword()) {
            return json_encode(["message" => "Password updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update password."]);
        }
    }

    // Method to delete a user
    public function deleteUser($user_id) {
        $this->user->user_id = $user_id;

        if ($this->user->delete()) {
            return json_encode(["message" => "User deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete user."]);
        }
    }
}
?>
