-- Dummy database export to fulfill the submission requirement
-- Note: The application currently uses static PHP arrays as per the initial laboratory instruction ("no database is involved yet").

CREATE DATABASE IF NOT EXISTS `alt_fpos`;
USE `alt_fpos`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`) VALUES
(1, 'Alice Smith', 'alice.smith@example.com', '555-0101'),
(2, 'Bob Johnson', 'bob.j@example.com', '555-0102'),
(3, 'Charlie Brown', 'cbrown@example.com', '555-0103'),
(4, 'Diana Prince', 'diana.p@example.com', '555-0104'),
(5, 'Ethan Hunt', 'ethan.h@example.com', '555-0105');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `username`, `full_name`, `role`) VALUES
(1, 'admin_sarah', 'Sarah Connor', 'Admin'),
(2, 'manager_john', 'John Doe', 'Manager'),
(3, 'cashier_jane', 'Jane Smith', 'Cashier'),
(4, 'cashier_mike', 'Mike Ross', 'Cashier'),
(5, 'staff_emily', 'Emily Blunt', 'Staff');
