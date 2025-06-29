-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--
CREATE DATABASE IF NOT EXISTS `school` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `school`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `price`) VALUES
(1, 'engels book', 29.50),
(2, 'nederland\'s book', 30.00),
(3, 'Mathematics Basics', 35.75),
(4, 'History of Europe', 42.00),
(5, 'Science Workbook', 28.25),
(6, 'Programming Fundamentals', 45.99),
(7, 'Art & Design', 39.50),
(8, 'Business Studies', 41.25);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240925120001', '2024-09-25 14:00:23', 24),
('DoctrineMigrations\\Version20240925131135', '2024-09-25 15:11:54', 26),
('DoctrineMigrations\\Version20240925151921', '2024-09-25 17:20:46', 77),
('DoctrineMigrations\\Version20241122110539', '2024-11-22 12:05:56', 69),
('DoctrineMigrations\\Version20250623102734', '2025-06-23 12:27:57', 24),
('DoctrineMigrations\\Version20250623104508', '2025-06-23 12:45:21', 15),
('DoctrineMigrations\\Version20250623104858', '2025-06-23 12:49:16', 12),
('DoctrineMigrations\\Version20250623110546', '2025-06-23 13:05:59', 32),
('DoctrineMigrations\\Version20250623122108', '2025-06-23 14:21:20', 142),
('DoctrineMigrations\\Version20250629061418', '2025-06-29 06:14:24', 40);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `purchase_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `postal_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `user_id`, `purchase_date`, `total_amount`, `first_name`, `last_name`, `email`, `phone_number`, `postal_code`) VALUES
(1, 4, '2025-06-29 06:09:15', 29.50, '', '', '', '', ''),
(2, 4, '2025-06-29 06:09:24', 29.50, '', '', '', '', ''),
(3, 4, '2025-06-29 06:15:24', 29.50, 'Abdullah', 'Koudimati', 'abdullahkoudimati@GMAIL.COM', '0685874556', '2622AS');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `id` int(11) NOT NULL,
  `books_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`id`, `books_id`, `purchase_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 29.50),
(2, 1, 2, 1, 29.50),
(3, 1, 3, 1, 29.50);

-- --------------------------------------------------------

--
-- Table structure for table `school_group`
--

CREATE TABLE `school_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `teacher` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_group`
--

INSERT INTO `school_group` (`id`, `name`, `year`, `teacher`) VALUES
(1, 'B1J', 1, 'S Bechoe'),
(2, 'B1K', 1, 'K Mooijman'),
(3, 'B1L', 1, 'L Govea'),
(4, 'B1M', 1, 'P Thong'),
(5, 'B1P', 1, 'M Hutten'),
(6, 'B2H', 2, 'L Govea'),
(7, 'B2J', 2, 'M Kleijwegt'),
(8, 'B2K', 2, 'K Mooijman'),
(9, 'B2L', 2, 'F Dasci'),
(10, 'B3M', 3, 'M Sarikaya');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `school_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `email`, `last_name`, `age`, `school_group_id`) VALUES
(2, 'Klaas', 'k.devries@rocmondriaan.nl', 'de Vries', 17, 2),
(3, 'Rias', 'r.degraaf@rocmondriaan.nl', 'de Graaf', 16, 3),
(8, 'Abdullah', 'abdullahkoudimati@GMAIL.COM', 'Koudimati', 22, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@admin', '[\"ROLE_ADMIN\"]', '$2y$13$9zKC1X4NJBBvh41Ci3rAFelQiTpy0UMoQbFWtzdqXX5B4G3MO4vqS'),
(2, 'mario22', '[]', '$2y$13$SRDgoiAfjU9AiJQj78bhcOmvMSCLDhT.i/qGuuYqXM6b3sCUkjrAu'),
(3, 'mario@gmail.com', '[]', '$2y$13$D4up.POqhjarYq17/qjybuEDW9DmCNGBIo4swXvlMFxC2m5Oa0pY.'),
(4, 'mario22@gmail.com', '[]', '$2y$13$5PMOsyfUVIZy5VJln4kZReo/xKmlGYKucKqFPY/ESE.4C6S7y4bq6');

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`id`, `name`, `start_date`, `end_date`) VALUES
(1, 'Herfstvakantie', '2024-10-26', '2024-11-03'),
(2, 'Kerstvakantie', '2024-12-21', '2025-01-05'),
(3, 'Voorjaarsvakantie', '2025-02-22', '2025-03-02'),
(4, 'Meivakantie', '2025-04-19', '2025-05-04'),
(5, 'Zomervakantie', '2025-07-19', '2025-08-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6117D13BA76ED395` (`user_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6FA8ED7D7DD8AC20` (`books_id`),
  ADD KEY `IDX_6FA8ED7D558FBEB9` (`purchase_id`);

--
-- Indexes for table `school_group`
--
ALTER TABLE `school_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B723AF3312ED03` (`school_group_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_group`
--
ALTER TABLE `school_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD CONSTRAINT `FK_6FA8ED7D558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`),
  ADD CONSTRAINT `FK_6FA8ED7D7DD8AC20` FOREIGN KEY (`books_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF3312ED03` FOREIGN KEY (`school_group_id`) REFERENCES `school_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
