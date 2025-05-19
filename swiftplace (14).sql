-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 02:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swiftplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

CREATE TABLE `client_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`id`, `user_id`, `bio`, `contact`, `address`, `profile_pic`, `created_at`, `updated_at`) VALUES
(3, 6, 'wrerer', 'qerqer', 'qerqer', '', '2025-03-16 00:51:49', '2025-03-16 00:51:49'),
(4, 7, '123', 'qefeq', 'qfeqe', '', '2025-03-16 00:59:33', '2025-03-16 00:59:33'),
(5, 12, 'hello', '1234', 'tubog ubay bohol', '417358263_888466056293448_8936602137059994440_n.jpg', '2025-04-14 08:38:20', '2025-04-14 08:38:20'),
(6, 15, '', '', '', '438065413_3851754771721597_545182695080796179_n.jpg', '2025-04-14 13:23:45', '2025-04-17 02:53:07'),
(7, 17, 'hello', '1234', 'tubog ubay bohol', 'Screenshot 2024-02-11 135620.png', '2025-04-19 15:51:19', '2025-04-28 10:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `freelancers`
--

CREATE TABLE `freelancers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `job_category` varchar(100) NOT NULL,
  `experience` enum('Beginner','Intermediate','Expert') NOT NULL,
  `skills` text NOT NULL,
  `portfolio_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancers`
--

INSERT INTO `freelancers` (`id`, `first_name`, `last_name`, `email`, `password`, `job_category`, `experience`, `skills`, `portfolio_link`, `created_at`) VALUES
(10, 'Sukuna', 'Ryiomen', 'Sukuna@gmail.com', '$2y$10$h9N7J9ARD41FpDr/9p7kHugUPYCE0Iw0qR6etJmprfuHNyARseRX2', 'Programming', 'Expert', 'Fighting', NULL, '2025-03-16 01:00:44'),
(11, 'Dzey Arcel', 'Saavedera', 'arcelp@gmail.com', '$2y$10$j/jxOVQsEXXNPGswSswoTuk2cPi6dbLIhtSMNOaFYPFmK4c8WqxBy', 'Web Development', 'Beginner', 'ML', NULL, '2025-04-03 09:44:34'),
(12, 'Regino', 'Mundoc', 'hinoy@gmail.com', '$2y$10$m5hWMZOt6KvSQHkrqTg5.uIfkAmer72EmZtedGhQhhxOlu.nmZr9i', 'Programming', 'Expert', 'Coding, Singing', NULL, '2025-04-07 11:11:02'),
(14, 'buds', 'world', 'w@gmail.com', '$2y$10$Ze1O/JMK7H9sEGhyXR68wO4Nm7S1UqvUokFC3Q86crcva5R9GGDMC', 'Web Development', 'Intermediate', 'sadsad', NULL, '2025-04-14 21:48:04'),
(15, 'buds', 'erojo', 'eroj@gmail.com', '$2y$10$u.rGDlx0HcEZwVBNXGvAeOZO2ZBBP3Zd9mJ.j1tZfAC1gxGtmdkcK', 'Content Writing', 'Beginner', 'nothing', NULL, '2025-04-14 21:52:11'),
(16, 'kaiser', 'Pino', 'kaiser@gmail.com', '$2y$10$yGrBqmvrwGn72vHgsxMxXO.jFu2WZqB3aCF6vuW1oVHo2N2845WUy', 'Web Development', 'Beginner', 'nothing', NULL, '2025-04-15 01:28:52'),
(17, 'Louie Jay', 'Pino', 'l@gmail.com', '$2y$10$pAQcPDgaZ1lZPZHl6a2aTe3yXOtuthcaiS9.h8c6hVzXtsfhtNjr.', 'Graphic Design', 'Beginner', 'nothing', NULL, '2025-04-15 01:46:59'),
(18, 'Manuel', 'Pino', 'Manny@gmail.com', '$2y$10$YKfVpC2QYdelswhmEd4LdOh2.K16.00cMW8ZZT39EkXj2ai.3SIsO', 'Graphic Design', 'Beginner', 'nothing', NULL, '2025-04-16 04:23:15'),
(20, 'Manuel', 'Pino', 'Mani@gmail.com', '$2y$10$23kZnKgxu/GiMYde5g47fuduqWNumpY855z7.q0D4bSuG3FT1oi2e', 'Graphic Design', 'Beginner', 'nothing', NULL, '2025-04-16 04:24:51'),
(21, 'ZORO', 'RORONOA', 'PIECE@gmail.com', '$2y$10$s0zpWAiF4yRw4w8q1baqOO8f1z4SnyyBzSUQcPJzwLAD.T8XnwuIG', 'Business', 'Expert', 'Swordsman', NULL, '2025-04-18 22:42:19');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_profile`
--

CREATE TABLE `freelancer_profile` (
  `id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer_profile`
--

INSERT INTO `freelancer_profile` (`id`, `freelancer_id`, `phone`, `address`, `skills`, `experience`, `bio`, `profile_picture`) VALUES
(9, 10, '', '', '', '', '', '682970f233ee7_hand.png'),
(10, 20, '90807078', '4', '4t3', 'rgsgs', 'sfgfdg', '68007393d1ac9_arcel.jpg'),
(11, 21, '097779869', 'tubog ubay bohol', 'nothingwefewfwf', 'tktktu', 'tkukyky', '6803c6babe8f1_Screenshot 2025-01-04 193032.png');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `required_skill` varchar(255) DEFAULT NULL,
  `job_type` varchar(100) DEFAULT NULL,
  `experience_level` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `posted_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'open',
  `final_attachment` varchar(255) DEFAULT NULL,
  `external_link` text DEFAULT NULL,
  `completion_comments` text DEFAULT NULL,
  `is_submitted` tinyint(1) DEFAULT 0,
  `is_paid` tinyint(1) DEFAULT 0,
  `approval_comments` text DEFAULT NULL,
  `rejection_comments` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `client_id`, `job_title`, `job_description`, `category`, `budget`, `deadline`, `receipt`, `required_skill`, `job_type`, `experience_level`, `created_at`, `posted_at`, `status`, `final_attachment`, `external_link`, `completion_comments`, `is_submitted`, `is_paid`, `approval_comments`, `rejection_comments`, `approved_at`, `is_completed`) VALUES
(3, 7, 'reincarnation ', 'to reincarnate gojo', 'necromancy/miracle', 1000000.00, '2029-06-29', NULL, 'necromancy, shamanic spells', 'Fixed', 'Expert', '2025-04-06 10:28:06', '2025-04-14 19:45:47', 'open', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0),
(40, 17, 'asfdda', 'adfaf', 'afd', 23.00, '2025-05-31', NULL, 'afdaf', 'Hourly', 'Beginner', '2025-05-17 22:28:26', '2025-05-18 06:28:26', 'open', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0),
(41, 17, 'ASDSAD', 'ASDASD', 'ASDA', 3.00, '2025-05-27', NULL, 'ASDA', 'Fixed', 'Intermediate', '2025-05-18 00:48:42', '2025-05-18 08:48:42', 'in-progress', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `cover_letter` text NOT NULL,
  `expected_duration` varchar(100) DEFAULT NULL,
  `experience_summary` text DEFAULT NULL,
  `skills_used` text DEFAULT NULL,
  `questions_clarifications` text DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `applied_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `freelancer_id`, `job_id`, `cover_letter`, `expected_duration`, `experience_summary`, `skills_used`, `questions_clarifications`, `availability`, `attachment`, `status`, `applied_at`) VALUES
(1, 21, 26, 'hrwgwgwr', 'gwrg', 'adwdv', 'svsd', NULL, NULL, '68031311bf98a_archer.png', 'pending', '2025-04-19 11:05:53'),
(2, 10, 3, 'wdfwfas', 'fasdf', 'adfaf', 'adfadf', 'adfadfadf', '2', '6809fa96b8e2d_4874918b-9663-4c34-998f-f6b8e0eaa7fe.jpeg', 'pending', '2025-04-24 16:47:18'),
(31, 21, 31, 'adfdafaf', '1', 'adfad', 'adfda', 'adfad', '3', NULL, 'rejected', '2025-05-04 07:51:50'),
(32, 10, 31, 'asfdafdadaf', 'adafadf', 'fdafdafadf', 'dafafa', 'fafa', '2', NULL, '', '2025-05-04 18:04:28'),
(33, 10, 31, 'qfqdfda', 'fadfa', 'adfadf', 'aadfad', 'adfdaff', '1', NULL, '', '2025-05-04 18:45:44'),
(34, 10, 31, 'adfadfda', 'adfad', 'fafadf', 'fadfda', 'fadfadf', '1', NULL, '', '2025-05-04 18:45:59'),
(35, 21, 31, 'adfafddafaf', 'adfa', 'afafaf', 'afadfad', 'adfafd', '4', NULL, 'rejected', '2025-05-04 18:46:15'),
(37, 21, 31, 'qereqr', 'qer', 'qereq', 'qerre', 'qerre', '2', NULL, 'rejected', '2025-05-04 18:57:13'),
(38, 21, 31, 'ewfewf', 'wefwef', 'wfef', 'wfwefe', 'wfewfw', '1', NULL, 'rejected', '2025-05-04 20:36:07'),
(39, 10, 31, 'asdqd', 'as', 'asfadf', 'adfa', 'afdadf', '2', NULL, '', '2025-05-04 20:36:24'),
(40, 10, 32, 'adfdf', '3', 'efwf', 'wefwef', 'wefwf', '2', NULL, '', '2025-05-04 20:41:40'),
(41, 10, 31, 'acafad', 'cdac', 'aca', 'dacadc', 'cddcaad', '1', NULL, '', '2025-05-04 20:42:08'),
(42, 21, 32, 'dfwdf', 'fw', 'wfdwf', 'wdfwdfw', 'wfdw', '3', NULL, 'rejected', '2025-05-04 20:42:31'),
(43, 21, 31, 'fwc', 'wfew', 'cewcwc', 'cew', 'cewcw', '3', NULL, 'rejected', '2025-05-04 20:42:36'),
(44, 10, 32, 'asfsqf', 'afs', 'asfasf', 'afsfas', 'afsfas', '2', NULL, '', '2025-05-06 20:13:56'),
(45, 10, 31, 'adfaf', 'adfda', 'fdaf', 'adfda', 'afdaf', '2', NULL, '', '2025-05-07 00:01:46'),
(46, 10, 32, 'adfa', 'adfad', 'fadf', 'fdaf', 'afdaf', '2', '681ee969944ae_417358263_888466056293448_8936602137059994440_n.jpg', '', '2025-05-10 13:51:37'),
(47, 10, 32, 'adfaf', 'adfdaf', 'adfaf', 'dafaf', 'afaf', '3', NULL, '', '2025-05-10 13:52:52'),
(48, 10, 32, 'adf', 'afa', 'adf', 'fadf', 'afadf', '2', NULL, '', '2025-05-10 13:53:53'),
(49, 10, 33, 'safd', 'fadf', 'adfa', 'afadf', 'fad2', '2', NULL, 'accepted', '2025-05-10 15:23:45'),
(50, 10, 34, 'asda', 'adfaf', 'adfadf', 'dafaf', 'adfaf', '3', '681f52fb66cbb_438051467_1955018548248799_1013182607477101067_n.jpg', 'accepted', '2025-05-10 21:22:03'),
(51, 10, 35, 'asfadf', 'afafaf', 'adfdafa', 'fadfadf', 'adfafa', '1', '68280efd3a41f_438051467_1955018548248799_1013182607477101067_n.jpg', '', '2025-05-17 12:22:21'),
(52, 10, 3, 'rgwg', '3', 'afdadf', 'dfaf', 'adfdaf', '1', '682845c21eb44_438051467_1955018548248799_1013182607477101067_n.jpg', 'pending', '2025-05-17 16:16:02'),
(53, 10, 3, 'adfdaf', 'adfad', 'dafadf', 'adfadf', 'adfadf', '1', '682845d4c56f6_02e79830c88b2dcd32cee9b937d79486.jpg', 'pending', '2025-05-17 16:16:20'),
(55, 10, 36, 'adfadf', 'dafadf', 'adfadf', 'adfdaf', 'adfadf', '2', '6828463a52ed6_412470296_250869574556051_2785614715771652835_n.jpg', 'accepted', '2025-05-17 16:18:02'),
(56, 10, 3, 'afad', 'dafdf', 'adfa', 'afdf', 'adffd', '2', '682908439d07d_438051467_1955018548248799_1013182607477101067_n.jpg', 'pending', '2025-05-18 06:05:55'),
(58, 10, 41, 'ASDDASD', 'ASDA', 'DAFAD', 'FAFAF', 'DAFADF', '3', NULL, '', '2025-05-18 08:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `job_milestones`
--

CREATE TABLE `job_milestones` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `due_date` date DEFAULT NULL,
  `freelancer_id` int(11) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_milestones`
--

INSERT INTO `job_milestones` (`id`, `job_id`, `title`, `description`, `status`, `due_date`, `freelancer_id`, `attachment`) VALUES
(28, 41, 'ASADA', 'ADSAD', 'in_progress', '2025-05-20', 0, '1747529492_438051478_352201920742669_5749653685159685037_n.jpg'),
(33, 41, 'asdsda', 'asd', 'in_progress', '2025-05-20', 0, '1747532397_417358263_888466056293448_8936602137059994440_n.jpg'),
(34, 41, 'asdsa', 'asd', 'in_progress', '2025-05-23', 0, '1747532407_438051478_352201920742669_5749653685159685037_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `job_ratings`
--

CREATE TABLE `job_ratings` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('client','freelancer') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 4, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(3, 11, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(4, 1, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(5, 3, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(6, 5, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(7, 12, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(10, 8, 'freelancer', 'New job posted: Hitman', 'job-details.php?id=4', 0, '2025-04-08 00:46:43'),
(11, 4, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(13, 11, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(14, 1, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(15, 3, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(16, 5, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(17, 12, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(20, 8, 'freelancer', 'New job posted: wewe', 'job-details.php?id=5', 0, '2025-04-08 01:04:19'),
(21, 4, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(23, 11, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(24, 1, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(25, 3, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(26, 5, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(27, 12, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(30, 8, 'freelancer', 'New job posted: qwfqfqef', 'job-details.php?id=6', 0, '2025-04-08 01:05:41'),
(31, 4, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(33, 11, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(34, 1, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(35, 3, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(36, 5, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(37, 12, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(40, 8, 'freelancer', 'New job posted: Become Pirate King', 'job-details.php?id=7', 0, '2025-04-08 01:45:29'),
(41, 4, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(43, 11, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(44, 1, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(45, 3, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(46, 5, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(47, 12, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(50, 8, 'freelancer', 'New job posted: qer', 'job-details.php?id=8', 0, '2025-04-09 05:28:16'),
(51, 4, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(53, 11, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(54, 1, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(55, 3, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(56, 5, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(57, 12, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(60, 8, 'freelancer', 'New job posted: Film Editor qef ', 'job-details.php?id=9', 0, '2025-04-09 06:34:50'),
(61, 2, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(62, 4, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(63, 8, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(64, 3, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(65, 5, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(67, 6, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(69, 1, 'client', 'New service/application posted: pogi', 'serevice-details.php?id=15', 0, '2025-04-09 08:10:48'),
(70, 4, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(72, 11, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(73, 1, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(74, 3, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(75, 5, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(76, 12, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(79, 8, 'freelancer', 'New job posted: Luffy', 'job-details.php?id=10', 0, '2025-04-09 08:11:35'),
(80, 2, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(81, 4, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(82, 8, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(83, 3, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(84, 5, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(86, 6, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(88, 1, 'client', 'New service/application posted: Music design Kupal', 'serevice-details.php?id=16', 0, '2025-04-09 08:17:03'),
(89, 4, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(90, 11, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(91, 1, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(92, 3, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(93, 5, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(94, 12, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(97, 8, 'freelancer', 'New job posted: Jujutsu', 'job-details.php?id=11', 0, '2025-04-09 08:22:53'),
(99, 4, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(100, 11, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(101, 1, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(102, 3, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(103, 5, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(104, 12, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(107, 8, 'freelancer', 'New job posted: Film Derictor', 'job-details.php?id=12', 0, '2025-04-09 08:29:21'),
(108, 4, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(109, 11, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(110, 1, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(111, 3, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(112, 5, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(113, 12, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(116, 8, 'freelancer', 'New job posted: Director', 'job-details.php?id=13', 0, '2025-04-09 08:32:32'),
(117, 2, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(118, 4, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(119, 8, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(120, 3, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(121, 5, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(122, 7, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 1, '2025-04-09 08:41:41'),
(123, 6, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(125, 1, 'client', 'New service/application posted by freelancer: Music designer', 'service-details.php?id=21', 0, '2025-04-09 08:41:41'),
(126, 4, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(127, 11, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(128, 1, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(129, 3, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(130, 5, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(131, 12, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(134, 8, 'freelancer', 'New job posted: Dzey', 'job-details.php?id=14', 0, '2025-04-09 08:42:25'),
(135, 7, '', 'A freelancer applied to your job <strong>Luffy</strong>.', NULL, 1, '2025-04-09 12:34:58'),
(136, 7, '', 'A freelancer applied to your job: Film Editor qef .', NULL, 1, '2025-04-09 14:22:32'),
(137, 7, '', 'A freelancer applied to your job: Director.', NULL, 0, '2025-04-09 14:34:38'),
(138, 7, '', 'A freelancer applied to your job: Hitman.', NULL, 0, '2025-04-09 14:50:45'),
(141, 4, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(142, 7, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(143, 11, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(144, 1, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(145, 3, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(146, 5, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(147, 12, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 1, '2025-04-09 21:59:48'),
(149, 8, 'freelancer', 'New job posted: Virtual Assistant', 'job-details.php?id=15', 0, '2025-04-09 21:59:48'),
(150, 4, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(151, 7, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(152, 11, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(153, 1, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(154, 3, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(155, 5, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(156, 12, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 1, '2025-04-09 22:10:14'),
(158, 8, 'freelancer', 'New job posted: SJBG', 'job-details.php?id=16', 0, '2025-04-09 22:10:14'),
(159, 4, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(160, 7, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(161, 11, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(162, 1, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(163, 3, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(164, 5, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(165, 12, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(167, 8, 'freelancer', 'New job posted: Anime', 'job-details.php?id=17', 0, '2025-04-09 22:20:01'),
(169, 4, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(170, 7, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(171, 11, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(172, 1, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(173, 3, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(174, 5, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(175, 12, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(177, 8, 'freelancer', 'New job posted: reincarnation ', 'job-details.php?id=18', 0, '2025-04-09 22:21:52'),
(179, 4, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(180, 7, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(181, 11, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(182, 1, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(183, 3, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(184, 5, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(185, 12, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(187, 8, 'freelancer', 'New job posted: qfqefewfwwef', 'job-details.php?id=19', 0, '2025-04-09 22:24:58'),
(188, 12, '', 'Your application for the job reincarnation  was accepted!', NULL, 1, '2025-04-09 22:31:49'),
(189, 2, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(190, 4, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(191, 8, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(192, 3, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(193, 5, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(194, 7, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 1, '2025-04-10 00:54:06'),
(195, 6, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(197, 1, 'client', 'New service/application posted: daddy', 'service-details.php?id=22', 0, '2025-04-10 00:54:06'),
(198, 4, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(199, 11, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(200, 1, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(201, 3, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(202, 5, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(203, 12, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(206, 8, 'freelancer', 'New job posted: fasd', 'job-details.php?id=20', 0, '2025-04-10 00:56:03'),
(207, 7, 'client', 'A freelancer has applied to your job: Job ID #.', 'view-applicants.php?job_id=20', 1, '2025-04-10 00:56:59'),
(209, 4, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(210, 7, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(211, 1, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(212, 3, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(213, 5, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(214, 12, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(216, 9, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(217, 8, 'freelancer', 'New job posted: Film Editor', 'job-details.php?id=21', 0, '2025-04-10 01:21:48'),
(218, 11, 'client', 'A freelancer has applied to your job: Job ID #.', 'view-applicants.php?job_id=21', 0, '2025-04-10 01:33:10'),
(219, 4, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(220, 7, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(221, 11, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(222, 1, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(223, 3, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(224, 5, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(226, 9, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(227, 8, 'freelancer', 'New job posted: hello', 'job-details.php?id=22', 0, '2025-04-14 11:53:03'),
(228, 4, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(229, 7, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(230, 11, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(231, 1, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(232, 3, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(233, 5, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(234, 12, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(236, 9, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(237, 8, 'freelancer', 'New job posted: fewfwfwf', 'job-details.php?id=23', 0, '2025-04-14 13:11:16'),
(238, 4, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(239, 11, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(240, 1, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(241, 3, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(242, 15, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(243, 5, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(244, 12, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(246, 14, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(247, 9, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(248, 8, 'freelancer', 'New job posted: hello kitty', 'job-details.php?id=24', 0, '2025-04-15 01:27:26'),
(249, 4, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(250, 7, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(251, 11, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(252, 1, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(253, 3, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(254, 5, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(255, 12, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(256, 16, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(257, 17, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(259, 14, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(260, 9, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(261, 8, 'freelancer', 'New job posted: Gamer', 'job-details.php?id=25', 0, '2025-04-16 04:03:42'),
(262, 8, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(263, 13, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(264, 10, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(265, 7, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(266, 14, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(267, 11, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(268, 15, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(269, 12, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(270, 6, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(271, 9, 'client', 'New service posted: Building Bomber', 'index.php?controller=service&action=view&id=23', 0, '2025-04-16 05:12:01'),
(272, 8, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(273, 13, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(274, 10, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(275, 7, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(276, 14, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(277, 11, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(278, 15, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(279, 12, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(280, 6, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(281, 9, 'client', 'New service posted: Building Bombers', 'index.php?controller=service&action=view&id=24', 0, '2025-04-16 07:16:22'),
(282, 11, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(283, 15, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(284, 12, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(285, 16, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(286, 20, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(287, 18, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(288, 21, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 1, '2025-04-18 23:37:59'),
(290, 14, 'freelancer', 'New job posted: Footballer', 'job-details.php?id=26', 0, '2025-04-18 23:37:59'),
(291, 11, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(292, 15, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(293, 12, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(294, 16, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(295, 20, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(296, 18, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(297, 21, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 1, '2025-04-18 23:46:42'),
(299, 14, 'freelancer', 'New job posted: hellow', 'job-details.php?id=27', 0, '2025-04-18 23:46:42'),
(300, 8, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(301, 13, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(302, 10, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(303, 7, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(304, 14, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(305, 11, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(306, 15, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(307, 17, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 1, '2025-04-18 23:47:44'),
(308, 12, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(309, 6, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(310, 9, 'client', 'New service posted: Pirate', 'index.php?controller=service&action=view&id=25', 0, '2025-04-18 23:47:44'),
(311, 11, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(312, 15, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(313, 12, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(314, 16, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(315, 20, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(316, 18, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(317, 21, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(319, 14, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=28', 0, '2025-04-24 07:45:59'),
(320, 11, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(321, 15, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(322, 12, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(323, 16, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(324, 20, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(325, 18, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(326, 21, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(328, 14, 'freelancer', 'New job posted: Film Maker', 'job-details.php?id=29', 0, '2025-04-24 07:51:30'),
(329, 11, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(330, 12, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(331, 16, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(332, 17, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(333, 20, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(334, 18, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(335, 21, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(337, 14, 'freelancer', 'New job posted: qsfafasfasf', 'job-details.php?id=30', 0, '2025-04-27 00:00:11'),
(338, 11, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(339, 15, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(340, 12, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(341, 16, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(342, 20, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(343, 18, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(344, 21, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(346, 14, 'freelancer', 'New job posted: qfqfasf', 'job-details.php?id=31', 0, '2025-04-27 00:00:53'),
(347, 17, 'client', 'Manuel Pino applied for your job \"qfqfasf\".', NULL, 1, '2025-04-27 00:12:24'),
(348, 17, 'client', 'Manuel Pino applied for your job \"qfqfasf\".', NULL, 0, '2025-04-27 00:39:06'),
(349, 20, '', 'Your application has been rejected by the client.', '', 0, '2025-04-27 00:40:30'),
(350, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 1, '2025-04-28 10:43:35'),
(351, 10, '', 'Your application has been rejected by the client.', '', 0, '2025-04-28 10:44:25'),
(352, 21, '', 'Your application has been rejected by the client.', '', 0, '2025-04-28 10:47:02'),
(353, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:09:12'),
(362, 21, '', 'Your application has been rejected by the client.', '', 0, '2025-04-28 11:09:38'),
(363, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:16:31'),
(364, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-04-28 11:18:39'),
(365, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:18:55'),
(366, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-04-28 11:18:58'),
(367, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:24:48'),
(368, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-04-28 11:24:52'),
(369, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:26:34'),
(370, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-04-28 11:26:52'),
(371, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:29:07'),
(372, 21, '', 'Your application has been rejected by the client.', '', 0, '2025-04-28 11:29:11'),
(373, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-04-28 11:29:45'),
(376, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-04-28 11:30:04'),
(377, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 05:43:39'),
(379, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 05:51:01'),
(382, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 05:51:34'),
(383, 21, '', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 05:55:32'),
(387, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 1, '2025-05-01 05:57:52'),
(388, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 05:59:18'),
(389, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-01 06:41:42'),
(390, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-02 09:56:24'),
(391, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-02 12:33:47'),
(392, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-02 12:33:55'),
(393, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-02 12:34:22'),
(394, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-03 22:41:30'),
(395, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-03 23:02:02'),
(396, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-03 23:33:10'),
(397, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-03 23:46:13'),
(398, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-03 23:51:50'),
(399, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-04 00:01:04'),
(400, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:04:28'),
(402, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-04 10:11:42'),
(403, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:45:44'),
(404, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:45:59'),
(405, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:46:15'),
(406, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:48:16'),
(407, 21, 'freelancer', 'Your application for the job \'qfqfasf\' has been rejected by the client.', '', 0, '2025-05-04 10:52:05'),
(408, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 10:57:13'),
(409, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 12:36:07'),
(410, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 12:36:24'),
(411, 11, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(412, 15, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(413, 12, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(414, 16, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(415, 20, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(416, 18, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(417, 21, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(419, 14, 'freelancer', 'New job posted: qererqr', 'job-details.php?id=32', 0, '2025-05-04 12:37:35'),
(420, 17, 'client', 'Sukuna Ryiomen applied for your job \"qererqr\".', NULL, 0, '2025-05-04 12:41:40'),
(421, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 12:42:08'),
(422, 17, 'client', 'ZORO RORONOA applied for your job \"qererqr\".', NULL, 0, '2025-05-04 12:42:31'),
(423, 17, 'client', 'ZORO RORONOA applied for your job \"qfqfasf\".', NULL, 0, '2025-05-04 12:42:37'),
(424, 17, 'client', 'Sukuna Ryiomen applied for your job \"qererqr\".', NULL, 0, '2025-05-06 12:13:56'),
(425, 17, 'client', 'Sukuna Ryiomen applied for your job \"qfqfasf\".', NULL, 0, '2025-05-06 16:01:46'),
(426, 17, 'client', 'Sukuna Ryiomen applied for your job \"qererqr\".', NULL, 0, '2025-05-10 05:51:37'),
(427, 17, 'client', 'Sukuna Ryiomen applied for your job \"qererqr\".', NULL, 0, '2025-05-10 05:52:52'),
(428, 17, 'client', 'Sukuna Ryiomen applied for your job \"qererqr\".', NULL, 0, '2025-05-10 05:53:53'),
(430, 11, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(431, 15, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(432, 12, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(433, 16, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(434, 20, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(435, 18, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(436, 21, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(438, 14, 'freelancer', 'New job posted: asdas', 'job-details.php?id=33', 0, '2025-05-10 07:23:27'),
(439, 17, 'client', 'Sukuna Ryiomen applied for your job \"asdas\".', NULL, 0, '2025-05-10 07:23:45'),
(441, 11, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(442, 15, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(443, 12, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(444, 16, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(445, 20, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(446, 18, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(447, 21, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(449, 14, 'freelancer', 'New job posted: fhgdjfykuli;guo', 'job-details.php?id=34', 0, '2025-05-10 13:21:47'),
(450, 17, 'client', 'Sukuna Ryiomen applied for your job \"fhgdjfykuli;guo\".', NULL, 0, '2025-05-10 13:22:03'),
(467, 17, 'client', 'A freelancer has submitted the final file for your job \'qfqfasf\'.', 'index.php?controller=client&action=viewJob&job_id=31', 0, '2025-05-13 10:00:01'),
(470, 17, 'client', 'A freelancer has submitted the final file for your job \'fhgdjfykuli;guo\'.', 'index.php?controller=client&action=viewJob&job_id=34', 0, '2025-05-13 12:56:45'),
(474, 17, 'client', 'A freelancer has marked your job \'qfqfasf\' as paid and submitted the final file.', 'index.php?controller=client&action=viewJob&job_id=31', 0, '2025-05-17 04:08:25'),
(475, 17, 'client', 'A freelancer has marked your job \'qfqfasf\' as paid and submitted the final file.', 'index.php?controller=client&action=viewJob&job_id=31', 0, '2025-05-17 04:08:31'),
(476, 11, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(477, 15, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(478, 12, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(479, 16, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(480, 20, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(481, 18, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(482, 21, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:51'),
(483, 10, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:52'),
(484, 14, 'freelancer', 'New job posted: adfa', 'job-details.php?id=35', 0, '2025-05-17 04:09:52'),
(485, 17, 'client', 'Sukuna Ryiomen applied for your job \"adfa\".', NULL, 0, '2025-05-17 04:22:21'),
(486, 10, 'freelancer', 'Congratulations! Your application for the job \'adfa\' has been accepted by the client.', '', 0, '2025-05-17 04:22:30'),
(487, 17, 'client', 'A freelancer has withdrawn from your job \'adfa\'.', 'index.php?controller=client&action=viewJob&job_id=35', 0, '2025-05-17 06:36:47'),
(488, 17, 'client', 'A freelancer has marked your job \'qererqr\' as paid and submitted the final file.', 'index.php?controller=client&action=viewJob&job_id=32', 0, '2025-05-17 08:14:01'),
(489, 17, 'client', 'A freelancer has marked your job \'qererqr\' as paid and submitted the final file.', 'index.php?controller=client&action=viewJob&job_id=32', 0, '2025-05-17 08:14:10'),
(490, 17, 'client', 'A freelancer has withdrawn from your job \'qererqr\'.', 'index.php?controller=client&action=viewJob&job_id=32', 0, '2025-05-17 08:14:54'),
(491, 17, 'client', 'A freelancer has withdrawn from your job \'qfqfasf\'.', 'index.php?controller=client&action=viewJob&job_id=31', 0, '2025-05-17 08:14:57'),
(492, 7, 'client', 'Sukuna Ryiomen applied for your job \"reincarnation \".', NULL, 0, '2025-05-17 08:16:02'),
(493, 7, 'client', 'Sukuna Ryiomen applied for your job \"reincarnation \".', NULL, 0, '2025-05-17 08:16:20'),
(494, 8, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(495, 13, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(496, 7, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(497, 14, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(498, 11, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(499, 15, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(500, 17, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(501, 12, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(502, 6, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(503, 9, 'client', 'New service posted: afsdaf', 'index.php?controller=service&action=view&id=26', 0, '2025-05-17 08:16:46'),
(504, 11, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(505, 15, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(506, 12, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(507, 16, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(508, 20, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(509, 18, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(510, 21, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(511, 10, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(512, 14, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=36', 0, '2025-05-17 08:17:09'),
(513, 17, 'client', 'Sukuna Ryiomen applied for your job \"adfaf\".', NULL, 0, '2025-05-17 08:17:23'),
(514, 10, 'freelancer', 'Your application for the job \'adfaf\' has been rejected by the client.', '', 0, '2025-05-17 08:17:39'),
(515, 17, 'client', 'Sukuna Ryiomen applied for your job \"adfaf\".', NULL, 0, '2025-05-17 08:18:02'),
(516, 10, 'freelancer', 'Congratulations! Your application for the job \'adfaf\' has been accepted by the client.', '', 0, '2025-05-17 08:18:07'),
(517, 7, 'client', 'Sukuna Ryiomen applied for your job \"reincarnation \".', NULL, 0, '2025-05-17 22:05:55'),
(518, 11, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(519, 15, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(520, 12, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(521, 16, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(522, 20, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(523, 18, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(524, 21, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(525, 10, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(526, 14, 'freelancer', 'New job posted: afa', 'job-details.php?id=37', 0, '2025-05-17 22:06:19'),
(527, 11, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(528, 15, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(529, 12, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(530, 16, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(531, 20, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(532, 18, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(533, 21, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(534, 10, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(535, 14, 'freelancer', 'New job posted: adfaf', 'job-details.php?id=38', 0, '2025-05-17 22:07:22'),
(536, 11, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(537, 15, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(538, 12, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(539, 16, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(540, 20, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(541, 18, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(542, 21, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(543, 10, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 1, '2025-05-17 22:14:12'),
(544, 14, 'freelancer', 'New job posted: sfafdd', 'job-details.php?id=39', 0, '2025-05-17 22:14:12'),
(545, 8, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(546, 13, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(547, 7, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(548, 14, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(549, 11, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(550, 15, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(551, 17, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(552, 12, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(553, 6, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(554, 9, 'client', 'New service posted: adf', 'index.php?controller=service&action=view&id=27', 0, '2025-05-17 22:27:44'),
(555, 11, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(556, 15, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(557, 12, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(558, 16, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(559, 20, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(560, 18, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(561, 21, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(562, 10, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26');
INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `link`, `is_read`, `created_at`) VALUES
(563, 14, 'freelancer', 'New job posted: asfdda', 'job-details.php?id=40', 0, '2025-05-17 22:28:26'),
(564, 17, 'client', 'Sukuna Ryiomen applied for your job \"asfdda\".', NULL, 0, '2025-05-17 22:29:09'),
(565, 10, 'freelancer', 'Your application for the job \'asfdda\' has been rejected by the client.', '', 0, '2025-05-17 22:29:23'),
(566, 11, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(567, 15, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(568, 12, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(569, 16, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(570, 20, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(571, 18, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(572, 21, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(573, 10, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 1, '2025-05-18 00:48:42'),
(574, 14, 'freelancer', 'New job posted: ASDSAD', 'job-details.php?id=41', 0, '2025-05-18 00:48:42'),
(575, 17, 'client', 'Sukuna Ryiomen applied for your job \"ASDSAD\".', NULL, 0, '2025-05-18 00:50:32'),
(576, 10, 'freelancer', 'Congratulations! Your application for the job \'ASDSAD\' has been accepted by the client.', '', 1, '2025-05-18 00:50:35'),
(577, 17, 'client', 'A freelancer has withdrawn from your job \'ASDSAD\'.', 'index.php?controller=client&action=viewJob&job_id=41', 0, '2025-05-18 02:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `receipt_file` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `job_id`, `client_id`, `receipt_file`, `uploaded_at`) VALUES
(1, 34, 17, '68228425b6cb9_02e79830c88b2dcd32cee9b937d79486.jpg', '2025-05-13 07:28:37'),
(2, 34, 17, '682286eac97c0_02e79830c88b2dcd32cee9b937d79486.jpg', '2025-05-13 07:40:26'),
(3, 34, 17, '682287aad5b82_02e79830c88b2dcd32cee9b937d79486.jpg', '2025-05-13 07:43:38'),
(4, 34, 17, '6822894261717_02e79830c88b2dcd32cee9b937d79486.jpg', '2025-05-13 07:50:26'),
(5, 34, 17, '68228d01c47c4_412470296_250869574556051_2785614715771652835_n.jpg', '2025-05-13 08:06:25'),
(6, 34, 17, '6822906ed4dfb_412470296_250869574556051_2785614715771652835_n.jpg', '2025-05-13 08:21:02'),
(7, 34, 17, '6822948995c71_412470296_250869574556051_2785614715771652835_n.jpg', '2025-05-13 08:38:33'),
(8, 34, 17, '682300477c69f_417358263_888466056293448_8936602137059994440_n.jpg', '2025-05-13 16:18:15'),
(9, 34, 17, '682301579fc54_417358263_888466056293448_8936602137059994440_n.jpg', '2025-05-13 16:22:47'),
(10, 34, 17, '682302d53dbec_417358263_888466056293448_8936602137059994440_n.jpg', '2025-05-13 16:29:09'),
(11, 34, 17, '68230359e4357_438051467_1955018548248799_1013182607477101067_n.jpg', '2025-05-13 16:31:21'),
(12, 34, 17, '682312b3c2802_02e79830c88b2dcd32cee9b937d79486.jpg', '2025-05-13 17:36:51'),
(13, 34, 17, '682342e50caff_417358263_888466056293448_8936602137059994440_n.jpg', '2025-05-13 21:02:29'),
(14, 31, 17, '68280ba411ada_438051478_352201920742669_5749653685159685037_n.jpg', '2025-05-17 12:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `service_title` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `delivery_time` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `expertise` varchar(50) DEFAULT NULL,
  `rating` float DEFAULT 0,
  `duration` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `freelancer_id`, `service_title`, `category`, `description`, `skills`, `delivery_time`, `tags`, `media_path`, `created_at`, `price`, `expertise`, `rating`, `duration`, `expires_at`) VALUES
(1, 10, 'Graphic designing ', 'Web Development', 'i know how to design and im pogi', 'Drawing', '3', '0', '0', '2025-04-06 06:56:39', 0.00, 'Beginner', 0, NULL, NULL),
(3, 11, 'Web Development', 'Web Development', 'i am a web developer, i can do shopify or anything about web', 'HTML, CSS, all the front end an also the some backend', '5 days', 'Coding, programming, web', '../uploads/1743924779_WIN_20240917_13_15_26_Pro.jpg', '2025-04-06 07:32:59', 50.00, 'Intermediate', 0, NULL, NULL),
(6, 10, 'Game Developer', 'Programming', 'I am a God of Programming', 'coding', '5', 'Coding, programming, Game Dev, C#', NULL, '2025-04-07 11:09:29', 100.00, 'Expert', 0, NULL, NULL),
(7, 12, 'ML content creator', 'Content Creating', 'i am top 1 julian of Bohol', 'Jungling, Jungler, Retri Gods, Teamfight', '7', 'gaming, MLBB, content, jungler, core , user', '../uploads/1744024394_gojo-hand-sign-jujutsu-kaisen-thumb.jpg', '2025-04-07 11:13:14', 10000.00, 'Expert', 0, NULL, NULL),
(8, 10, 'dwdf', 'dwfwdf', 'adfwfwf', 'Drawing', '3', 'wfewf', NULL, '2025-04-09 05:26:25', -0.01, 'Beginner', 0, NULL, NULL),
(24, 20, 'Building Bombers', 'Graphic Design', 'rgergre', 'gegrreger', '1', 'edwgsdgdg', NULL, '2025-04-16 07:16:22', 50.00, 'Beginner', 0, 3, '2025-04-19 15:16:22'),
(25, 21, 'PirateS', 'Web Development', 'wefsdfF', 'nothing', '2', 'edwgsdgdgcxv', 'public/uploads/1745020064_ib3.png', '2025-04-18 23:47:44', 10.00, 'Expert', 0, 1, '2025-04-20 07:47:44'),
(26, 10, 'afsdaf', 'adfadf', 'adfadf', 'adfda', 'adfad', 'afdaf', 'public/uploads/1747469806_417358263_888466056293448_8936602137059994440_n.jpg', '2025-05-17 08:16:46', 32.00, 'Beginner', 0, 5, '2025-05-22 16:16:46'),
(27, 10, 'adf', 'adf', 'adf', 'afd', 'adf', 'afd', 'public/uploads/1747520863_438051478_352201920742669_5749653685159685037_n.jpg', '2025-05-17 22:27:44', 234.00, 'Beginner', 0, 10, '2025-05-28 06:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `service_ratings`
--

CREATE TABLE `service_ratings` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_ratings`
--

INSERT INTO `service_ratings` (`id`, `service_id`, `client_id`, `rating`, `created_at`) VALUES
(1, 1, 17, 3, '2025-05-17 13:27:31'),
(2, 6, 17, 2, '2025-05-17 13:27:42'),
(3, 8, 17, 3, '2025-05-17 13:27:47'),
(4, 26, 17, 4, '2025-05-17 21:49:17'),
(5, 27, 17, 4, '2025-05-18 00:50:02'),
(6, 24, 17, 4, '2025-05-18 04:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(6, 'regino', 'peter', 'r@gmail.com', '$2y$10$xVVKHw5.JaQvCc9A1NDaau0QH/igD9bhzGZz6S/ZOG19mzp6SS7dC', '2025-03-16 00:37:29'),
(7, 'Gojo', 'Saturo', 'gojo@gmail.com', '$2y$10$F4gWJEecAR2Jr2eDa7oesOt9ThVqf1Xn2/KXbJ02nVs4S1gBNwJlq', '2025-03-16 00:59:16'),
(8, 'jaja', 'aaaa', 'avenx@gmail.com', '$2y$10$z7lg53OmaqRigZWGg5Gh3.rupExeKQWyZfTt27czmgeY477pvjZ5O', '2025-04-03 09:53:29'),
(9, 'Peter Racist', 'Avenido', 'racist@gmail.com', '$2y$10$i5K39BQvBRQp/BWO7yfFO.2R8pdskMpEmj8VrVFu8mqheo.EBboza', '2025-04-08 01:38:29'),
(10, 'Jerrymie', 'Diaz', 'diddy@gmail.com', '$2y$10$0MRY6MuqCBNcrClYoQd1Ae06TYYhSkdW0wq2z/UEzLU7M8LILuhfK', '2025-04-10 01:07:29'),
(11, 'jp', 'avenido', 'jp@gmail.com', '$2y$10$Dq/ljG7fxmLwsl7cvvb6uerki2tyFHr6yT7CWJxlUGNfxSBhCWCWG', '2025-04-10 01:13:31'),
(12, 'Louie Jay', 'Pino', 'pino@gmail.com', '$2y$10$uKLzTQMQqluTlZiIN7Mk3O8yNbpHU7ZOvL41lNgA51pXftzFJ8S6.', '2025-04-13 09:03:26'),
(13, 'buds', 'erojo', 'buds@gmail.com', '$2y$10$QFSGtMfk4Uughs1bMZQK7urJWficSOgcMU9h.6wOTVtr3zmprRJhq', '2025-04-14 02:50:24'),
(14, 'hello', 'world', 'hello@gmail.com', '$2y$10$VDYFSLiuO9zUszGNKR1B2uxTSFXWFmvnIHFdsIe/8gB8VtO15G/ZK', '2025-04-14 02:55:20'),
(15, 'kaiser', 'weji', 'kai@gmail.com', '$2y$10$7e3nK913kGyEC5ylSrycO.R0a/sea4DHqWTp/lzKZY.qqX8IysGva', '2025-04-14 08:10:46'),
(17, 'LUFFY', 'MONKEY', 'ONE@gmail.com', '$2y$10$a9zB1c1IAs62Q2oPVbEc0uKfyyZR5ZcRtGc7A6S.UGQHPNdbKmEGW', '2025-04-18 22:41:27'),
(18, 'ace', 'donut', 'hot@gmail.com', '$2y$10$L1/EkmpFKn5V3dIi7ZwrjuT6BUSYG06jmHpvt6I/tasBOc8HTkxTS', '2025-05-18 12:03:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `freelancer_profile`
--
ALTER TABLE `freelancer_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_milestones`
--
ALTER TABLE `job_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `job_ratings`
--
ALTER TABLE `job_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_id` (`job_id`,`freelancer_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `service_ratings`
--
ALTER TABLE `service_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_id` (`service_id`,`client_id`);

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
-- AUTO_INCREMENT for table `client_profiles`
--
ALTER TABLE `client_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `freelancers`
--
ALTER TABLE `freelancers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `freelancer_profile`
--
ALTER TABLE `freelancer_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `job_milestones`
--
ALTER TABLE `job_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `job_ratings`
--
ALTER TABLE `job_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `service_ratings`
--
ALTER TABLE `service_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD CONSTRAINT `client_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_profile`
--
ALTER TABLE `freelancer_profile`
  ADD CONSTRAINT `freelancer_profile_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_milestones`
--
ALTER TABLE `job_milestones`
  ADD CONSTRAINT `job_milestones_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_ratings`
--
ALTER TABLE `job_ratings`
  ADD CONSTRAINT `job_ratings_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_ratings_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
