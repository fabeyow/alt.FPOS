-- ============================================================
-- alt.FPOS Database Setup Script
-- Run this via phpMyAdmin (Import tab) or MySQL CLI:
--   mysql -u root < create_database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `altfpos_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `altfpos_db`;

-- -----------------------------------------------------------
-- Customers Table
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customers` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `full_name`  VARCHAR(100) NOT NULL,
    `email`      VARCHAR(100) NOT NULL,
    `phone`      VARCHAR(20),
    `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Users Table (includes role column for role-based display)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `username`   VARCHAR(50) NOT NULL UNIQUE,
    `full_name`  VARCHAR(100) NOT NULL,
    `role`       VARCHAR(20) NOT NULL DEFAULT 'Staff',
    `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Seed Data: Customers (5 records)
-- -----------------------------------------------------------
INSERT INTO `customers` (`full_name`, `email`, `phone`, `created_at`) VALUES
('Maria Clara Santos',     'maria.santos@email.com',    '+63 917 123 4567', '2025-01-15 08:30:00'),
('Juan Carlos Dela Cruz',  'jc.delacruz@email.com',     '+63 928 234 5678', '2025-02-20 10:15:00'),
('Angela Mae Reyes',       'angela.reyes@email.com',    '+63 935 345 6789', '2025-03-10 14:45:00'),
('Roberto Miguel Torres',  'roberto.torres@email.com',  '+63 906 456 7890', '2025-04-05 09:00:00'),
('Patricia Anne Garcia',   'patricia.garcia@email.com', '+63 912 567 8901', '2025-05-18 16:20:00');

-- -----------------------------------------------------------
-- Seed Data: Users (5 records)
-- -----------------------------------------------------------
INSERT INTO `users` (`username`, `full_name`, `role`, `created_at`) VALUES
('admin_jose',   'Jose Andres Mendoza',     'Admin',   '2025-01-01 08:00:00'),
('mgr_carmela',  'Carmela Rose Villanueva', 'Manager', '2025-01-15 09:30:00'),
('cash_diego',   'Diego Martin Flores',     'Cashier', '2025-02-01 10:00:00'),
('cash_liza',    'Liza Mae Aquino',         'Cashier', '2025-02-15 11:00:00'),
('staff_marco',  'Marco Antonio Bautista',  'Staff',   '2025-03-01 08:30:00');
