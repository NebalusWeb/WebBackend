-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 25, 2024 at 02:10 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
                            `id` int NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                            `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                            `username` varchar(25) NOT NULL,
                            `passwd_hash` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                            `passwd_salt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                            `passwd_algo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `creationdate`, `username`, `passwd_hash`, `passwd_salt`, `passwd_algo`) VALUES
    (1, '2024-02-28 21:28:40', 'Nebalus', '<paouisfhöoi<sydzhgföoi<shzföiouh', '67847', 'sha256');

-- --------------------------------------------------------

--
-- Table structure for table `linktrees`
--

CREATE TABLE `linktrees` (
                             `id` int NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `accountid` int NOT NULL COMMENT 'The ID of the account that owns this entry',
                             `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'This text is shown as the description',
                             `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `viewcount` int NOT NULL DEFAULT '0' COMMENT 'The amount of times this entry was accessed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `linktree_entrys`
--

CREATE TABLE `linktree_entrys` (
                                   `id` int NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                                   `linktreeid` int NOT NULL,
                                   `label` varchar(84) NOT NULL,
                                   `link` text NOT NULL,
                                   `position` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
                             `id` int NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `accountid` int NOT NULL COMMENT 'The ID of the account that owns this entry',
                             `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'A unique code that is used for /ref?q=code',
                             `pointer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/' COMMENT 'Points to the Final URL (''/'' is the root path from the aktual webserver)',
                             `viewcount` int NOT NULL DEFAULT '0' COMMENT 'The amount of times this referral entry has been accessed',
                             `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Defines if this referral is enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `accountid`, `code`, `pointer`, `viewcount`, `creationdate`, `enabled`) VALUES
                                                                                                           (1, 1, 'TEST', '/', 0, '2024-02-25 00:00:00', 1),
                                                                                                           (3, 1, 'TEST1', '/', 0, '2024-02-25 00:00:00', 1),
                                                                                                           (5, 1, 'TEST42', '/', 0, '2024-02-27 11:04:20', 1),
                                                                                                           (6, 1, '42', '/', 0, '2024-02-28 21:30:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
                          `id` int NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                          `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                          `expiredate` datetime NOT NULL COMMENT 'The expire date of this entry',
                          `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linktrees`
--
ALTER TABLE `linktrees`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `account` (`accountid`);

--
-- Indexes for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `refcode` (`code`,`accountid`) USING BTREE;

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `linktrees`
--
ALTER TABLE `linktrees`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
