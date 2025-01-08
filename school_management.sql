-- Base Database Schema for School Management System
CREATE DATABASE IF NOT EXISTS `school_management`;
USE `school_management`;

-- Table for Colors
CREATE TABLE `colors` (
  `color_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `hex_code` CHAR(7) NOT NULL
);

-- Table for Buildings
CREATE TABLE `buildings` (
  `building_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `floors_number` INT DEFAULT 1,
  `color_id` INT,
  FOREIGN KEY (`color_id`) REFERENCES `colors`(`color_id`) ON DELETE SET NULL
);

-- Table for Floors
CREATE TABLE `floors` (
  `floor_id` INT PRIMARY KEY AUTO_INCREMENT,
  `building_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `rooms_number` INT DEFAULT 1,
  `color_id` INT,
  FOREIGN KEY (`building_id`) REFERENCES `buildings`(`building_id`) ON DELETE CASCADE,
  FOREIGN KEY (`color_id`) REFERENCES `colors`(`color_id`) ON DELETE SET NULL
);

-- Table for Rooms
CREATE TABLE `rooms` (
  `room_id` INT PRIMARY KEY AUTO_INCREMENT,
  `floor_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `capacity` INT DEFAULT 1,
  `room_type` ENUM('classroom', 'laboratory', 'office', 'auditorium', 'other') DEFAULT 'other',
  `color_id` INT,
  FOREIGN KEY (`floor_id`) REFERENCES `floors`(`floor_id`) ON DELETE CASCADE,
  FOREIGN KEY (`color_id`) REFERENCES `colors`(`color_id`) ON DELETE SET NULL
);

-- Table for Resources
CREATE TABLE `resources` (
  `resource_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `quantity` INT DEFAULT 1,
  `status` ENUM('available', 'reserved', 'unavailable') DEFAULT 'available'
);

-- Table for Users
CREATE TABLE `users` (
  `user_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `role` ENUM('teacher', 'admin', 'staff') DEFAULT 'staff',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table for Classes
CREATE TABLE `classes` (
  `class_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `teacher_id` INT NOT NULL,
  `schedule` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  FOREIGN KEY (`teacher_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
);

-- Table for Room Reservations
CREATE TABLE `room_reservations` (
  `reservation_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `room_id` INT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `status` ENUM('reserved', 'canceled', 'completed') DEFAULT 'reserved',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`room_id`) REFERENCES `rooms`(`room_id`) ON DELETE CASCADE
);

-- Table for Resource Reservations
CREATE TABLE `resource_reservations` (
  `reservation_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `resource_id` INT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `status` ENUM('reserved', 'canceled', 'completed') DEFAULT 'reserved',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`resource_id`) REFERENCES `resources`(`resource_id`) ON DELETE CASCADE
);

-- Table for Access Logs
CREATE TABLE `access_logs` (
  `log_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `action` VARCHAR(255) NOT NULL,
  `timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
);

-- Table for Notifications
CREATE TABLE `notifications` (
  `notification_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read') DEFAULT 'unread',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
);
