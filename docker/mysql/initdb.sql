-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Erstellungszeit: 05. Nov 2024 um 08:09
-- Server-Version: 9.1.0
-- PHP-Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `main`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `analytics_linktree_clicks`
--

CREATE TABLE `analytics_linktree_clicks` (
  `linktree_id` int UNSIGNED NOT NULL,
  `clicked_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `analytics_linktree_entry_clicks`
--

CREATE TABLE `analytics_linktree_entry_clicks` (
  `linktree_entry_id` int UNSIGNED NOT NULL,
  `clicked_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `analytics_referral_clicks`
--

CREATE TABLE `analytics_referral_clicks` (
  `referral_id` int UNSIGNED NOT NULL,
  `clicked_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `linktrees`
--

CREATE TABLE `linktrees` (
  `linktree_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
  `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'This text is shown as the description',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `linktree_entrys`
--

CREATE TABLE `linktree_entrys` (
  `linktree_entry_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
  `linktree_id` int UNSIGNED NOT NULL,
  `position` int UNSIGNED NOT NULL,
  `label` varchar(84) NOT NULL,
  `link` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `referrals`
--

CREATE TABLE `referrals` (
  `referral_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
  `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'A unique code that is used for /ref/code',
  `pointer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/' COMMENT 'Points to the Final URL (''/'' is the root path from the aktual webserver)',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Defines if this referral is enabled',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `referrals`
--

INSERT INTO `referrals` (`referral_id`, `user_id`, `code`, `pointer`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 1, 'TEST', '/', 1, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
(3, 1, 'TEST1', '/', 1, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
(5, 1, 'TEST42', '/', 1, '2024-02-27 11:04:20', '2024-09-28 15:35:26'),
(6, 1, '42', '/', 1, '2024-02-28 21:30:24', '2024-09-28 15:35:26'),
(7, 1, 'dfghdfgh', '/', 1, '2024-08-03 23:20:58', '2024-09-28 15:35:26');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key) 	',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `passwd_hash` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description_for_admins` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `username`, `passwd_hash`, `description_for_admins`, `is_admin`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Nebalus', 'f381ef6d4e5e29889f967cd06d71dd0fcd4af7f7aad53ae4931b07d4ee6b8144', 'Is the default test User', 1, 1, '2024-02-28 21:28:40', '2024-08-03 23:07:10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_emails`
--

CREATE TABLE `user_emails` (
  `email_id` int NOT NULL,
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `user_emails`
--

INSERT INTO `user_emails` (`email_id`, `user_id`, `email`, `is_confirmed`, `confirmed_at`, `created_at`) VALUES
(1, 1, 'contact@nebalus.dev', 1, '2024-11-05 09:09:08', '2024-11-05 08:08:40');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_invitation_tokens`
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
-- Daten für Tabelle `user_invitation_tokens`
--

INSERT INTO `user_invitation_tokens` (`invitation_token_id`, `owner_user_id`, `invited_user_id`, `token_field_1`, `token_field_2`, `token_field_3`, `token_field_4`, `token_field_5`) VALUES
(1, 1, NULL, 2485, 2764, 9211, 4695, 4788),
(6, 1, 1, 4586, 5863, 8326, 9386, 7040);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_login_history`
--

CREATE TABLE `user_login_history` (
  `login_history_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `logged_in_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` blob NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `linktrees`
--
ALTER TABLE `linktrees`
  ADD PRIMARY KEY (`linktree_id`),
  ADD UNIQUE KEY `account` (`user_id`);

--
-- Indizes für die Tabelle `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
  ADD PRIMARY KEY (`linktree_entry_id`),
  ADD UNIQUE KEY `linktree_id` (`linktree_id`,`position`);

--
-- Indizes für die Tabelle `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`referral_id`),
  ADD UNIQUE KEY `refcode` (`code`) USING BTREE;

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indizes für die Tabelle `user_emails`
--
ALTER TABLE `user_emails`
  ADD PRIMARY KEY (`email_id`),
  ADD UNIQUE KEY `Email` (`email`),
  ADD UNIQUE KEY `Userid` (`user_id`);

--
-- Indizes für die Tabelle `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
  ADD PRIMARY KEY (`invitation_token_id`),
  ADD UNIQUE KEY `unique_token` (`token_field_1`,`token_field_2`,`token_field_3`,`token_field_4`,`token_field_5`),
  ADD UNIQUE KEY `invited_user_id` (`invited_user_id`);

--
-- Indizes für die Tabelle `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD PRIMARY KEY (`login_history_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `linktrees`
--
ALTER TABLE `linktrees`
  MODIFY `linktree_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT für Tabelle `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
  MODIFY `linktree_entry_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT für Tabelle `referrals`
--
ALTER TABLE `referrals`
  MODIFY `referral_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key) 	', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `user_emails`
--
ALTER TABLE `user_emails`
  MODIFY `email_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
  MODIFY `invitation_token_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `user_login_history`
--
ALTER TABLE `user_login_history`
  MODIFY `login_history_id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
