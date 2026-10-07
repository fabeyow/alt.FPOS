-- phpMyAdmin SQL Dump
-- alt.FPOS Database Export
-- Database: `altfpos_db`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `altfpos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(1, 'Maria Clara Santos', 'maria.santos@email.com', '+63 917 123 4567', '2025-01-15 08:30:00'),
(2, 'Juan Carlos Dela Cruz', 'jc.delacruz@email.com', '+63 928 234 5678', '2025-02-20 10:15:00'),
(3, 'Angela Mae Reyes', 'angela.reyes@email.com', '+63 935 345 6789', '2025-03-10 14:45:00'),
(4, 'Roberto Miguel Torres', 'roberto.torres@email.com', '+63 906 456 7890', '2025-04-05 09:00:00'),
(5, 'Patricia Anne Garcia', 'patricia.garcia@email.com', '+63 912 567 8901', '2025-05-18 16:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'Staff',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
-- Default password for all users: password123
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `avatar`, `created_at`) VALUES
(1, 'admin_jose', '$2y$10$bVjyKhnp.Jb5hMHmYEbjeuoTUblKOWz/UHj2gq8fZ/2WRaC1NXgvO', 'Jose Andres Mendoza', 'Admin', NULL, '2025-01-01 08:00:00'),
(2, 'mgr_carmela', '$2y$10$bVjyKhnp.Jb5hMHmYEbjeuoTUblKOWz/UHj2gq8fZ/2WRaC1NXgvO', 'Carmela Rose Villanueva', 'Manager', NULL, '2025-01-15 09:30:00'),
(3, 'cash_diego', '$2y$10$bVjyKhnp.Jb5hMHmYEbjeuoTUblKOWz/UHj2gq8fZ/2WRaC1NXgvO', 'Diego Martin Flores', 'Cashier', NULL, '2025-02-01 10:00:00'),
(4, 'cash_liza', '$2y$10$bVjyKhnp.Jb5hMHmYEbjeuoTUblKOWz/UHj2gq8fZ/2WRaC1NXgvO', 'Liza Mae Aquino', 'Cashier', NULL, '2025-02-15 11:00:00'),
(5, 'staff_marco', '$2y$10$bVjyKhnp.Jb5hMHmYEbjeuoTUblKOWz/UHj2gq8fZ/2WRaC1NXgvO', 'Marco Antonio Bautista', 'Staff', NULL, '2025-03-01 08:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
