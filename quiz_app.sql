-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2025 at 01:45 PM
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
-- Database: `quiz_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `is_active`) VALUES
(1, 'What does HTML stand for?', 'Hyper Text Makeup Language', 'Hyperlinks and Text Markup Language', 'Home Tool Markup Language', 'Hyper Text Markup Language', 4, 1),
(2, 'Which HTML tag creates a clickable link?', '< a > (anchor)', '< link >', '< href >', '< img >', 1, 1),
(3, 'Which tag is used to display images?', '&lt;img&gt;', '&lt;picture&gt;', '&lt;image&gt;', '&lt;src&gt;', 1, 1),
(4, 'CSS stands for?', 'Cascading Style Sheets', 'Computer Style Sheets', 'Creative Style Syntax', 'Colorful Style Sheets', 1, 1),
(5, 'Which CSS property changes text color?', 'font-color', 'text-color', 'color', 'font-style', 3, 1),
(6, 'Which keyword declares a block-scoped variable in JavaScript?', 'var', 'let', 'constexpr', 'function', 2, 1),
(7, 'Which SQL statement retrieves data from a database?', 'GET', 'FETCH', 'SELECT', 'OPEN', 3, 1),
(8, 'Which HTTP method is commonly used to submit form data?', 'GET', 'PUT', 'DELETE', 'POST', 4, 1),
(9, 'Which element is used to play audio in HTML?', '&lt;audio&gt;', '&lt;sound&gt;', '&lt;music&gt;', '&lt;media&gt;', 1, 1),
(10, 'Which symbol starts a single-line comment in PHP?', '// or #', '--', '/*', '%%', 1, 0),
(11, 'Who is making the Web standards?', 'Microsoft', 'The World Wide Web consortium', 'Google', 'Mozilla', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date_taken` datetime DEFAULT current_timestamp(),
  `answers` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `score`, `total`, `date_taken`, `answers`) VALUES
(1, '', 0, 0, '2025-12-11 22:21:24', ''),
(2, '', 0, 0, '2025-12-11 22:27:18', ''),
(3, '', 0, 0, '2025-12-11 22:34:46', ''),
(4, 'sdb123', 0, 9, '2025-12-11 22:39:37', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\"}'),
(5, 'sdb123', 0, 9, '2025-12-11 22:53:14', '{\"1\":null,\"2\":null,\"3\":null,\"4\":null,\"5\":null,\"6\":null,\"7\":null,\"8\":null,\"9\":null}'),
(6, 'sdb123', 3, 9, '2025-12-11 23:01:03', '{\"1\":\"1\",\"2\":\"1\",\"3\":\"1\",\"4\":\"3\",\"5\":\"2\",\"6\":\"3\",\"7\":\"4\",\"8\":\"1\",\"9\":\"1\",\"0\":\"4\"}'),
(7, 'sdb123', 9, 9, '2025-12-11 23:06:20', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\"}'),
(8, 'sdb123', 9, 9, '2025-12-11 23:11:27', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\"}'),
(9, 'sdb123', 9, 9, '2025-12-12 11:29:06', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\"}'),
(10, 'sdb123', 10, 10, '2025-12-12 11:44:03', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(11, 'sdb123', 10, 10, '2025-12-12 14:00:22', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(12, 'sdb123', 10, 10, '2025-12-12 14:12:45', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(13, 'sdb123', 10, 10, '2025-12-12 14:15:36', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(14, 'cm_trm', 10, 11, '2025-12-12 14:36:55', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(15, 'cm_trm', 10, 12, '2025-12-12 14:59:31', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\"}'),
(16, 'cm_trm', 0, 11, '2025-12-12 15:07:45', '[]'),
(17, 'cm_trm', 11, 11, '2025-12-12 15:25:35', '{\"11\":\"2\",\"9\":\"1\",\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"16\":\"2\"}'),
(18, 'sdb123', 10, 11, '2025-12-12 16:00:44', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\",\"16\":\"2\"}'),
(19, 'sdb123', 9, 11, '2025-12-12 16:11:08', '{\"1\":\"4\",\"2\":\"1\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\",\"16\":\"2\"}'),
(20, 'sdb123', 7, 11, '2025-12-12 16:58:18', '{\"1\":\"4\",\"3\":\"1\",\"4\":\"1\",\"5\":\"3\",\"6\":\"2\",\"7\":\"3\",\"8\":\"4\",\"9\":\"1\",\"11\":\"2\",\"16\":\"2\"}'),
(21, 'sdb123', 9, 11, '2025-12-12 17:15:28', '{\"1\":4,\"2\":1,\"3\":1,\"4\":1,\"5\":3,\"6\":2,\"7\":3,\"8\":4,\"9\":1,\"11\":2,\"16\":2}'),
(22, 'sdb123', 11, 11, '2025-12-12 17:17:39', '{\"1\":4,\"2\":1,\"3\":1,\"4\":1,\"5\":3,\"6\":2,\"7\":3,\"8\":4,\"9\":1,\"11\":2,\"16\":2}'),
(23, 'cm_trm', 10, 10, '2025-12-12 17:20:58', '{\"1\":4,\"2\":1,\"3\":1,\"4\":1,\"5\":3,\"6\":2,\"7\":3,\"8\":4,\"9\":1,\"11\":2}'),
(24, 'cm_trm', 10, 10, '2025-12-12 20:27:43', '{\"1\":4,\"2\":1,\"3\":1,\"4\":1,\"5\":3,\"6\":2,\"7\":3,\"8\":4,\"9\":1,\"11\":2}');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT 'guest',
  `score` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `taken_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `username`, `score`, `total`, `taken_on`) VALUES
(1, 'sdb', 10, 10, '2025-12-11 03:15:14'),
(2, 'guest', 9, 10, '2025-12-11 09:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `password`) VALUES
(0, '[value-2]', '[value-3]', '[value-4]'),
(2, 'sdb123', 'sdb', '$2y$10$0u3FGiqqWJp9DdaEZ.muAu5jBrVYbaqbgQ9hlb7G4OMiSZHWL8mgG'),
(5, 'cm_trm', 'trm', '$2y$10$4qDmrlefHwyrCCSikCNF1O.9t0uBQD2b/CdGr9BgZk7gthCP6BLja');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
