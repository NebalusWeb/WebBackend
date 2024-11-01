-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 27, 2024 at 08:37 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.22

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
-- Table structure for table `linktrees`
--

CREATE TABLE `linktrees` (
                             `linktree_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
                             `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'This text is shown as the description',
                             `view_count` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The amount of times this entry was accessed',
                             `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
                             `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `last_time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `linktree_entrys`
--

CREATE TABLE `linktree_entrys` (
                                   `linktree_entry_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                                   `linktree_id` int UNSIGNED NOT NULL,
                                   `position` int UNSIGNED NOT NULL,
                                   `label` varchar(84) NOT NULL,
                                   `link` text NOT NULL,
                                   `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                   `last_time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
                             `referral_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
                             `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'A unique code that is used for /ref/code',
                             `pointer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/' COMMENT 'Points to the Final URL (''/'' is the root path from the aktual webserver)',
                             `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Defines if this referral is enabled',
                             `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `last_time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`referral_id`, `user_id`, `code`, `pointer`, `enabled`, `creation_date`, `last_time_updated`) VALUES
                                                                                                                           (1, 1, 'TEST', '/', 1, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
                                                                                                                           (3, 1, 'TEST1', '/', 1, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
                                                                                                                           (5, 1, 'TEST42', '/', 1, '2024-02-27 11:04:20', '2024-09-28 15:35:26'),
                                                                                                                           (6, 1, '42', '/', 1, '2024-02-28 21:30:24', '2024-09-28 15:35:26'),
                                                                                                                           (7, 1, 'dfghdfgh', '/', 1, '2024-08-03 23:20:58', '2024-09-28 15:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `referral_clicks`
--

CREATE TABLE `referral_clicks` (
                                   `referral_id` int UNSIGNED NOT NULL,
                                   `click_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key) 	',
                         `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `passwd_hash` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                         `description_for_admins` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                         `is_admin` tinyint(1) NOT NULL DEFAULT '0',
                         `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
                         `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                         `last_time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `passwd_hash`, `email`, `description_for_admins`, `is_admin`, `is_enabled`, `creation_date`, `last_time_updated`) VALUES
    (1, 'Nebalus', 'f381ef6d4e5e29889f967cd06d71dd0fcd4af7f7aad53ae4931b07d4ee6b8144', 'nebalus@tuta.io', 'Is the default test User', 1, 1, '2024-02-28 21:28:40', '2024-08-03 23:07:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_invitation_tokens`
--

CREATE TABLE `user_invitation_tokens` (
                                          `invitation_token_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                                          `owner_user_id` int UNSIGNED NOT NULL COMMENT 'The Foreign ID of an User (Foreign Key) 	',
                                          `invited_user_id` int UNSIGNED DEFAULT NULL COMMENT 'The User Id of the Invited User',
                                          `token_field_1` smallint UNSIGNED NOT NULL COMMENT 'Token Field 1 (XXXX-????-????-????-????)',
                                          `token_field_2` smallint UNSIGNED NOT NULL COMMENT 'Token Field 2 (????-XXXX-????-????-????)',
                                          `token_field_3` smallint UNSIGNED NOT NULL COMMENT 'Token Field 3 (????-????-XXXX-????-????)',
                                          `token_field_4` smallint UNSIGNED NOT NULL COMMENT 'Token Field 4 (????-????-????-XXXX-????)',
                                          `token_field_5` smallint UNSIGNED NOT NULL COMMENT 'Token Field 5 (????-????-????-????-XXXX)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_invitation_tokens`
--

INSERT INTO `user_invitation_tokens` (`invitation_token_id`, `owner_user_id`, `invited_user_id`, `token_field_1`, `token_field_2`, `token_field_3`, `token_field_4`, `token_field_5`) VALUES
                                                                                                                                                                                          (1, 1, NULL, 2485, 2764, 9211, 4695, 4788),
                                                                                                                                                                                          (6, 1, 1, 4586, 5863, 8326, 9386, 7040);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE `user_login_history` (
                                      `login_history_id` int UNSIGNED NOT NULL,
                                      `user_id` int UNSIGNED NOT NULL,
                                      `login_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      `ip_address` blob NOT NULL,
                                      `success` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `linktrees`
--
ALTER TABLE `linktrees`
    ADD PRIMARY KEY (`linktree_id`),
  ADD UNIQUE KEY `account` (`user_id`);

--
-- Indexes for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    ADD PRIMARY KEY (`linktree_entry_id`),
  ADD UNIQUE KEY `linktree_id` (`linktree_id`,`position`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
    ADD PRIMARY KEY (`referral_id`),
  ADD UNIQUE KEY `refcode` (`code`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
    ADD PRIMARY KEY (`invitation_token_id`),
  ADD UNIQUE KEY `unique_token` (`token_field_1`,`token_field_2`,`token_field_3`,`token_field_4`,`token_field_5`),
  ADD UNIQUE KEY `invited_user_id` (`invited_user_id`);

--
-- Indexes for table `user_login_history`
--
ALTER TABLE `user_login_history`
    ADD PRIMARY KEY (`login_history_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `linktrees`
--
ALTER TABLE `linktrees`
    MODIFY `linktree_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    MODIFY `linktree_entry_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
    MODIFY `referral_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key) 	', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
    MODIFY `invitation_token_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_login_history`
--
ALTER TABLE `user_login_history`
    MODIFY `login_history_id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;