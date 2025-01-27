<?php
// controllers/user_controller.php

include_once ROOT_PATH . '/config/database.php'; 
include_once ROOT_PATH . '/models/user.php'; 

class UserController {
    private $db;
    private $user;

    public function __construct() {
        // Instantiate database and user model
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Method to create a password hash
    private function createPasswordHash($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    // Method to verify the password
    private function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    // Method to create a new user
    public function createUser($name, $email, $role, $password) {
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;
        $this->user->password = $this->createPasswordHash($password); 

        if ($this->user->create()) {
            return ["message" => "User created successfully."];
        } else {
            return ["message" => "Failed to create user."];
        }
    }

    // Method to read all users
    public function readUsers() {
        $stmt = $this->user->read();
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }

        return $users;
    }

    // Method to read a specific user
    public function readUser($user_id) {
        $this->user->user_id = $user_id;
        $stmt = $this->user->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return ["message" => "User not found."];
        }
    }

    // Method to obtain the password of a user
    public function getUserPassword($user_id) {
        $this->user->user_id = $user_id;
        $stmt = $this->user->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return ["password" => $row['password']];
        } else {
            return ["message" => "User not found."];
        }
    }

    // Method to update user attributes
    public function updateUser($user_id, $name, $email, $role) {
        $this->user->user_id = $user_id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->role = $role;

        if ($this->user->update()) {
            return ["message" => "User updated successfully."];
        } else {
            return ["message" => "Failed to update user."];
        }
    }

    // Method to update the user's password
    public function updateUserPassword($user_id, $new_password) {
        $this->user->user_id = $user_id;
        $this->user->password = $this->createPasswordHash($new_password); // Using the hash method

        if ($this->user->updatePassword()) {
            return ["message" => "Password updated successfully."];
        } else {
            return ["message" => "Failed to update password."];
        }
    }

    // Method to verify the user's password
    public function verifyUserPassword($user_id, $password) {
        $this->user->user_id = $user_id;
        $stmt = $this->user->readOne();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Check if the provided password matches the hash
            if ($this->verifyPassword($password, $row['password'])) {
                return ["message" => "Password is valid."];
            } else {
                return ["message" => "Invalid password."];
            }
        } else {
            return ["message" => "User not found."];
        }
    }

    // Method to delete a user
    public function deleteUser($user_id) {
        $this->user->user_id = $user_id;

        if ($this->user->delete()) {
            return ["message" => "User deleted successfully."];
        } else {
            return ["message" => "Failed to delete user."];
        }
    }
}
?>
