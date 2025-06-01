-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 02:24 PM
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
-- Database: `4624163_lostfound`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('lost','found') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `title`, `description`, `category`, `status`, `created_at`) VALUES
(3, 2, 'Lost Backpack', 'Black Adidas backpack lost near the cafeteria.', 'bags', 'lost', '2025-05-31 12:40:57'),
(4, 2, 'Found Calculator', 'Casio calculator found in library.', 'electronics', 'found', '2025-05-31 12:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `item_id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(3, 3, 3, 2, 'Hey, I think I found your backpack near the benches.', '2025-05-31 12:42:35'),
(4, 3, 2, 3, 'Thanks! Can we meet in the library?', '2025-05-31 12:42:35'),
(5, 3, 2, 2, 'hey', '2025-05-31 18:24:23'),
(6, 3, 2, 2, 'where did you find teh item', '2025-05-31 18:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(2, 'Ali Test', 'ali@test.com', '$2y$10$J4RSUvHbrvIO2WrqZFVtfuOf0SkCjULsbMe1SxYwbMGh94v/5fBYO', '2025-05-31 12:37:12'),
(3, 'Ali2 User', 'ali2@example.com', '$2y$10$J4RSUvHbrvIO2WrqZFVtfuOf0SkCjULsbMe1SxYwbMGh94v/5fBYO', '2025-05-31 12:38:15'),
(4, NULL, NULL, '$2y$10$i1C5dWJxUjGI8ymot3G.O.HSPEM/OTJtgO7ilD5D.3OAB2r20.RM6', '2025-05-31 12:51:10'),
(5, NULL, NULL, '$2y$10$m3vbcJyIGlkpb5wmE8UGGOithDDS52Iq6XxnbpkbhVRZ9Dt7RF7ya', '2025-05-31 18:26:42'),
(6, 'Alito', 'alito@gmail.com', '$2y$10$e5tjx1WRzVGkapUeSoGYC.8VIEH/UFsIEFwo7kQ0fwJF.V2whfKXa', '2025-05-31 18:26:42'),
(7, NULL, NULL, '$2y$10$tQ4.aPE7xiM.nNrn81wuWuCZ91KgF4qfV8PitT4i1yZ91zuLJOtsS', '2025-05-31 18:26:50'),
(9, NULL, NULL, '$2y$10$ae67yP7zN7XwTr8q/rM.V.RLEKdvj8eDfAqS4tioDfSj0UNq18wBi', '2025-05-31 18:28:48'),
(10, 'Alito123', 'alitotesting@gmail.com', '$2y$10$v6hfe0meJLmFGfKd8326H.EH4FBSApLIRZvWa7z6RNZYVPDRNxyy2', '2025-05-31 18:28:48'),
(11, NULL, NULL, '$2y$10$MRZ7wacCyxt/oEYOkXyI.e93kLK7h0/34iR/tHl.vbtVnC2GZBSpK', '2025-05-31 18:36:38'),
(12, 'hassan', 'hassan@test.com', '$2y$10$24oIB6Y7r.ZAguCZvWEQWeh6zTvek5.Z6o17i/j2ejsqOhk2BIAcO', '2025-05-31 18:36:38'),
(13, NULL, NULL, '$2y$10$Vsn1vdsXrMZadk8UlXABie5d./4UhIdkukon2EkwE20YsNNFSyjfy', '2025-05-31 18:40:13'),
(14, 'hadi', 'hadi@test.com', '$2y$10$TB2QOO.wXmhQYOGTu0gmcObBHI8fqtOLSpe68Ivnll0yujdRqhlrm', '2025-05-31 18:40:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
