-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2026 at 09:08 AM
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
-- Database: `fintrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expenseID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `recurring` enum('yes','no') DEFAULT 'no',
  `userID` int(11) NOT NULL,
  `category` enum('lifestyle','essential','financial','other') DEFAULT 'other',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expenseID`, `amount`, `title`, `date`, `recurring`, `userID`, `category`, `created_at`) VALUES
(6, 232.00, 'dwd', '2026-06-12', 'no', 8, 'lifestyle', '2026-06-12 09:59:51'),
(8, 6767.00, 'test expense', '2026-07-03', 'yes', 8, 'lifestyle', '2026-06-12 10:00:13'),
(9, 3434.00, 'grgr', '2026-06-22', 'no', 8, 'essential', '2026-06-22 09:25:25'),
(10, 434.00, 'hhh', '2026-06-22', 'yes', 8, 'other', '2026-06-22 09:25:49'),
(11, 2.00, 'f', '2026-07-05', 'no', 23, 'lifestyle', '2026-07-05 06:56:12'),
(12, 3.00, 'd', '2026-07-05', 'no', 23, 'essential', '2026-07-05 06:56:25'),
(13, 4.00, 'q', '2026-07-05', 'no', 23, 'financial', '2026-07-05 06:56:36'),
(14, 50000.00, 'h', '2026-07-05', 'no', 23, 'financial', '2026-07-05 06:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `expensechart`
--

CREATE TABLE `expensechart` (
  `chartID` int(11) NOT NULL,
  `chartType` enum('line','bar','doughnut','pie') NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `userID` int(11) NOT NULL,
  `category` enum('lifestyle','essential','financial','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expensechart`
--

INSERT INTO `expensechart` (`chartID`, `chartType`, `startDate`, `endDate`, `userID`, `category`) VALUES
(7, 'doughnut', '2026-07-02', '2026-07-17', 23, 'essential'),
(9, 'doughnut', '2026-07-04', '2026-07-30', 23, ''),
(10, 'doughnut', '2026-07-04', '2026-07-07', 23, 'essential');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE `goal` (
  `goalID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('achieved','unachieved') DEFAULT 'unachieved',
  `originalID` int(11) DEFAULT NULL,
  `originalType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goal`
--

INSERT INTO `goal` (`goalID`, `userID`, `title`, `amount`, `status`, `originalID`, `originalType`) VALUES
(36, 23, 'asas', 200000.00, 'unachieved', 21, 'income'),
(37, 23, 'ddd', 4.00, 'unachieved', 21, 'income'),
(38, 23, 'sd', 300.00, 'unachieved', 13, 'expense'),
(39, 23, 'd', 1.00, 'unachieved', 12, 'expense');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `incomeID` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `recurring` enum('yes','no') DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `category` enum('Salary','Freelance','Business','Investment','Allowance/Gifts','Other') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`incomeID`, `amount`, `title`, `date`, `recurring`, `userID`, `category`, `created_at`) VALUES
(18, 1212.00, 'wewe', '2026-06-12', 'no', 8, 'Salary', '2026-06-12 09:59:40'),
(19, 32323.00, 'income 1', '2026-06-22', 'yes', 8, 'Allowance/Gifts', '2026-06-22 09:20:32'),
(20, 4444.00, 'sdsds', '2026-06-22', 'no', 8, 'Investment', '2026-06-22 09:20:47'),
(21, 1.00, 'ddd', '2026-07-09', 'no', 23, 'Investment', '2026-07-05 06:54:10'),
(22, 222.00, 'fffr', '2026-07-06', 'no', 23, 'Salary', '2026-07-05 06:54:23'),
(23, 7777.00, 'fff', '2026-07-05', 'no', 23, 'Business', '2026-07-05 06:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `incomechart`
--

CREATE TABLE `incomechart` (
  `chartID` int(11) NOT NULL,
  `chartType` enum('line','bar','doughnut','pie') DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incomechart`
--

INSERT INTO `incomechart` (`chartID`, `chartType`, `startDate`, `endDate`, `userID`, `category`) VALUES
(33, 'pie', '2026-05-07', '2026-07-10', 8, 'Salary'),
(35, 'pie', '2026-06-05', '2026-07-06', 8, 'Salary'),
(37, 'line', '2026-05-01', '2026-10-15', 23, 'Allowance/Gifts'),
(38, 'doughnut', '2026-03-07', '2026-12-24', 23, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questionID` int(11) NOT NULL,
  `quizID` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`questionID`, `quizID`, `question`, `answer`) VALUES
(38, 35, 'a', 'a'),
(39, 36, 'a', 'a'),
(40, 36, 'b', 'b'),
(41, 36, 'c', 'c'),
(42, 36, 'd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quizID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `category` enum('BUDGETING','INVESTING','DEBT_MANAGEMENT','SAVING_MONEY','TAXES','FINANCIAL_LITERACY','STUDENT_FINANCE','CAREER_INCOME','SCAM_AWARENESS') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizID`, `userID`, `category`, `description`, `title`) VALUES
(35, 10, 'BUDGETING', 'dwdw', 'wdwd'),
(36, 10, 'BUDGETING', 'description description description description description description description description description description description description description description description description description description description description description description description description ', 'financial quiz');

-- --------------------------------------------------------

--
-- Table structure for table `quizlog`
--

CREATE TABLE `quizlog` (
  `quizlogID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `quizID` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizlog`
--

INSERT INTO `quizlog` (`quizlogID`, `userID`, `quizID`, `score`) VALUES
(1, 8, 35, 100),
(2, 8, 35, 0),
(3, 8, 35, 100),
(4, 8, 36, 75),
(5, 23, 35, 100),
(6, 23, 36, 50);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `requestID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`requestID`, `name`, `email`, `password`, `reason`, `status`, `created_at`) VALUES
(9, 'as', 'as', 'asa', 'asas', 'approved', '2026-06-12 10:09:57'),
(10, 'f', 'f', 'd', 'f', 'approved', '2026-06-12 10:10:08'),
(11, 'j', 'j', 'j', 'j', 'approved', '2026-06-12 10:11:00'),
(12, 'bryan', 'bryan', '123', 'reason', 'approved', '2026-07-04 16:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('user','moderator','admin') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(8, 'a', 'a', 'a', 'user', '2026-06-05 17:37:09'),
(9, 'min', 'min', 'min', 'admin', '2026-06-05 17:37:09'),
(10, 'low', 'low@gmail.com', '123', 'moderator', '2026-06-09 01:49:30'),
(13, '3r3r', 'lolipop', '3r3r', 'moderator', '2026-06-09 01:50:55'),
(16, 'hjhjhj', 'hjhjhj', 'jhjh', 'moderator', '2026-06-09 01:58:42'),
(17, 'j', 'j', 'j', 'moderator', '2026-06-25 01:47:56'),
(18, 'f', 'f', 'd', 'moderator', '2026-06-25 01:48:02'),
(19, 'as', 'as', 'asa', 'moderator', '2026-06-25 01:48:14'),
(20, 'bryan', 'bryan', '123', 'moderator', '2026-07-05 00:06:12'),
(21, 'kieran', 'kieran123', '123', 'user', '2026-07-05 14:52:20'),
(22, 'cayleb', 'cayleb', '123', 'user', '2026-07-05 14:52:49'),
(23, 'q', 'q', 'q', 'user', '2026-07-05 14:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `videoID` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `videoUrl` text DEFAULT NULL,
  `category` enum('Budgeting','Investing','Debt Management','Saving Money','Taxes','Financial Literacy','Student Finance','Career & Income','Scam Awareness & Safety') DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`videoID`, `title`, `videoUrl`, `category`, `userID`) VALUES
(11, 'wswsw', '-JVZI7McIFE', 'Budgeting', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expenseID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `expensechart`
--
ALTER TABLE `expensechart`
  ADD PRIMARY KEY (`chartID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `goal`
--
ALTER TABLE `goal`
  ADD PRIMARY KEY (`goalID`),
  ADD KEY `goal_ibfk_1` (`userID`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`incomeID`),
  ADD KEY `income_ibfk_1` (`userID`);

--
-- Indexes for table `incomechart`
--
ALTER TABLE `incomechart`
  ADD PRIMARY KEY (`chartID`),
  ADD KEY `incomechart_ibfk_1` (`userID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questionID`),
  ADD KEY `quizID` (`quizID`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quizID`),
  ADD KEY `quiz_ibfk_1` (`userID`);

--
-- Indexes for table `quizlog`
--
ALTER TABLE `quizlog`
  ADD PRIMARY KEY (`quizlogID`),
  ADD KEY `quizlog_ibfk_1` (`userID`),
  ADD KEY `quizlog_ibfk_2` (`quizID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`requestID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`videoID`),
  ADD KEY `video_ibfk_1` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `expensechart`
--
ALTER TABLE `expensechart`
  MODIFY `chartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `goal`
--
ALTER TABLE `goal`
  MODIFY `goalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `incomeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `incomechart`
--
ALTER TABLE `incomechart`
  MODIFY `chartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quizID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `quizlog`
--
ALTER TABLE `quizlog`
  MODIFY `quizlogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `videoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `expensechart`
--
ALTER TABLE `expensechart`
  ADD CONSTRAINT `expensechart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `goal`
--
ALTER TABLE `goal`
  ADD CONSTRAINT `goal_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `incomechart`
--
ALTER TABLE `incomechart`
  ADD CONSTRAINT `incomechart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quizID`) REFERENCES `quiz` (`quizID`) ON DELETE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `quizlog`
--
ALTER TABLE `quizlog`
  ADD CONSTRAINT `quizlog_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizlog_ibfk_2` FOREIGN KEY (`quizID`) REFERENCES `quiz` (`quizID`) ON DELETE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
