-- Base Database Schema for School Management System
CREATE DATABASE IF NOT EXISTS `school_management`;
USE `school_management`;

-- Table for Colors
CREATE TABLE `colors` (
  `color_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `hex_code` CHAR(7) NOT NULL
);

-- Table for Room Types
CREATE TABLE `room_types` (
  `type_id` INT PRIMARY KEY AUTO_INCREMENT,
  `type_name` VARCHAR(50) NOT NULL UNIQUE
);

-- Insert Room Types
INSERT INTO `room_types` (`type_name`) VALUES
('classroom'),
('laboratory'),
('office'),
('auditorium'),
('other');

-- Table for Statuses
CREATE TABLE `statuses` (
  `status_id` INT PRIMARY KEY AUTO_INCREMENT,
  `status_name` VARCHAR(50) NOT NULL UNIQUE
);

-- Insert Statuses
INSERT INTO `statuses` (`status_name`) VALUES
('available'),
('reserved'),
('unavailable'),
('active'),
('inactive'),
('unread'),
('read'),
('canceled'),
('completed');

-- Table for Users
CREATE TABLE `users` (
  `user_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `role` ENUM('teacher', 'admin', 'staff', 'root') DEFAULT 'staff',  -- Adicionando a nova role 'root'
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
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
  `capacity` INT DEFAULT 30,  -- Default capacity set to 30
  `room_type_id` INT,
  `color_id` INT,
  `status_id` INT,  -- Referencing `statuses` table
  FOREIGN KEY (`floor_id`) REFERENCES `floors`(`floor_id`) ON DELETE CASCADE,
  FOREIGN KEY (`room_type_id`) REFERENCES `room_types`(`type_id`) ON DELETE SET NULL,
  FOREIGN KEY (`color_id`) REFERENCES `colors`(`color_id`) ON DELETE SET NULL,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

-- Table for Resources
CREATE TABLE `resources` (
  `resource_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `quantity` INT DEFAULT 10,  -- Default quantity set to 10
  `status_id` INT,  -- Referencing `statuses` table
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

-- Table for Classes
CREATE TABLE `classes` (
  `class_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `teacher_id` INT,
  `schedule` VARCHAR(255) NOT NULL,
  `status_id` INT DEFAULT 1,  -- Referencing `statuses` table (default: 'available')
  CONSTRAINT fk_teacher_id FOREIGN KEY (`teacher_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL,
  CONSTRAINT fk_status_id FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

-- Table for Room Reservations
CREATE TABLE `room_reservations` (
  `reservation_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `room_id` INT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `status_id` INT,  -- Referencing `statuses` table
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`room_id`) REFERENCES `rooms`(`room_id`) ON DELETE CASCADE,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

-- Table for Resource Reservations
CREATE TABLE `resource_reservations` (
  `reservation_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `resource_id` INT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `status_id` INT,  -- Referencing `statuses` table
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`resource_id`) REFERENCES `resources`(`resource_id`) ON DELETE CASCADE,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

-- Table for Access Logs
CREATE TABLE `access_logs` (
  `log_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `action` VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `device_info` VARCHAR(255) NOT NULL, 
  `timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`, `timestamp`)
)
PARTITION BY RANGE (TO_DAYS(`timestamp`)) (
  -- Partitions for 2025
  PARTITION p2025_01 VALUES LESS THAN (TO_DAYS('2025-02-01')),
  PARTITION p2025_02 VALUES LESS THAN (TO_DAYS('2025-03-01')),
  PARTITION p2025_03 VALUES LESS THAN (TO_DAYS('2025-04-01')),
  PARTITION p2025_04 VALUES LESS THAN (TO_DAYS('2025-05-01')),
  PARTITION p2025_05 VALUES LESS THAN (TO_DAYS('2025-06-01')),
  PARTITION p2025_06 VALUES LESS THAN (TO_DAYS('2025-07-01')),
  PARTITION p2025_07 VALUES LESS THAN (TO_DAYS('2025-08-01')),
  PARTITION p2025_08 VALUES LESS THAN (TO_DAYS('2025-09-01')),
  PARTITION p2025_09 VALUES LESS THAN (TO_DAYS('2025-10-01')),
  PARTITION p2025_10 VALUES LESS THAN (TO_DAYS('2025-11-01')),
  PARTITION p2025_11 VALUES LESS THAN (TO_DAYS('2025-12-01')),
  PARTITION p2025_12 VALUES LESS THAN (TO_DAYS('2026-01-01')),

  -- Partitions for 2026
  PARTITION p2026_01 VALUES LESS THAN (TO_DAYS('2026-02-01')),
  PARTITION p2026_02 VALUES LESS THAN (TO_DAYS('2026-03-01')),
  PARTITION p2026_03 VALUES LESS THAN (TO_DAYS('2026-04-01')),
  PARTITION p2026_04 VALUES LESS THAN (TO_DAYS('2026-05-01')),
  PARTITION p2026_05 VALUES LESS THAN (TO_DAYS('2026-06-01')),
  PARTITION p2026_06 VALUES LESS THAN (TO_DAYS('2026-07-01')),
  PARTITION p2026_07 VALUES LESS THAN (TO_DAYS('2026-08-01')),
  PARTITION p2026_08 VALUES LESS THAN (TO_DAYS('2026-09-01')),
  PARTITION p2026_09 VALUES LESS THAN (TO_DAYS('2026-10-01')),
  PARTITION p2026_10 VALUES LESS THAN (TO_DAYS('2026-11-01')),
  PARTITION p2026_11 VALUES LESS THAN (TO_DAYS('2026-12-01')),
  PARTITION p2026_12 VALUES LESS THAN (TO_DAYS('2027-01-01'))
);

-- Table for Notifications
CREATE TABLE `notifications` (
  `notification_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `message` TEXT NOT NULL,
  `status_id` INT,  -- Referencing `statuses` table
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`status_id`) ON DELETE SET NULL
);

DELIMITER $$

-- Trigger to check if the resource quantity is not negative (before insert)
CREATE TRIGGER check_negative_quantity_before_insert
BEFORE INSERT ON `resources`
FOR EACH ROW
BEGIN
  -- If the quantity is less than 0, signal an error
  IF NEW.quantity < 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Resource quantity cannot be negative';
  END IF;
END $$

-- Trigger to check if the resource quantity is not negative (before update)
CREATE TRIGGER check_negative_quantity_before_update
BEFORE UPDATE ON `resources`
FOR EACH ROW
BEGIN
  -- If the quantity is less than 0, signal an error
  IF NEW.quantity < 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Resource quantity cannot be negative';
  END IF;
END $$

-- Trigger to ensure `start_time` is less than `end_time` for reservations (before insert)
CREATE TRIGGER check_start_time_before_insert
BEFORE INSERT ON `room_reservations`
FOR EACH ROW
BEGIN
  -- If the start time is greater than or equal to end time, signal an error
  IF NEW.start_time >= NEW.end_time THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Start time must be earlier than end time';
  END IF;
END $$

-- Trigger to ensure `start_time` is less than `end_time` for reservations (before update)
CREATE TRIGGER check_start_time_before_update
BEFORE UPDATE ON `room_reservations`
FOR EACH ROW
BEGIN
  -- If the start time is greater than or equal to end time, signal an error
  IF NEW.start_time >= NEW.end_time THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Start time must be earlier than end time';
  END IF;
END $$

-- Trigger to ensure `start_time` is less than `end_time` for resource reservations (before insert)
CREATE TRIGGER check_start_time_before_insert_resource
BEFORE INSERT ON `resource_reservations`
FOR EACH ROW
BEGIN
  -- If the start time is greater than or equal to end time, signal an error
  IF NEW.start_time >= NEW.end_time THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Start time must be earlier than end time';
  END IF;
END $$

-- Trigger to ensure `start_time` is less than `end_time` for resource reservations (before update)
CREATE TRIGGER check_start_time_before_update_resource
BEFORE UPDATE ON `resource_reservations`
FOR EACH ROW
BEGIN
  -- If the start time is greater than or equal to end time, signal an error
  IF NEW.start_time >= NEW.end_time THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Start time must be earlier than end time';
  END IF;
END $$

DELIMITER ;
