-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Erstellungszeit: 05. Nov 2024 um 23:03
-- Server-Version: 9.1.0
-- PHP-Version: 8.2.23

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

--
-- Daten für Tabelle `analytics_referral_clicks`
--

INSERT INTO `analytics_referral_clicks` (`referral_id`, `clicked_at`) VALUES
                                                                          (6, '2024-11-05 15:41:25'),
                                                                          (6, '2024-11-05 15:41:30'),
                                                                          (6, '2024-11-05 15:41:35'),
                                                                          (6, '2024-11-05 15:50:28'),
                                                                          (6, '2024-11-05 15:50:28'),
                                                                          (6, '2024-11-05 15:50:29'),
                                                                          (6, '2024-11-05 15:50:29'),
                                                                          (6, '2024-11-05 15:50:30'),
                                                                          (6, '2024-11-05 23:02:33'),
                                                                          (6, '2024-11-05 23:02:34'),
                                                                          (6, '2024-11-05 23:02:34'),
                                                                          (1, '2024-11-05 23:02:38'),
                                                                          (1, '2024-11-05 23:02:39'),
                                                                          (1, '2024-11-05 23:02:42'),
                                                                          (1, '2024-11-05 23:02:46'),
                                                                          (5, '2024-11-05 23:02:49'),
                                                                          (5, '2024-11-05 23:02:50'),
                                                                          (5, '2024-11-05 23:02:51'),
                                                                          (6, '2024-11-05 23:02:54');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `linktrees`
--

CREATE TABLE `linktrees` (
                             `linktree_id` int UNSIGNED NOT NULL,
                             `user_id` int UNSIGNED NOT NULL,
                             `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                             `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
                             `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `linktree_entrys`
--

CREATE TABLE `linktree_entrys` (
                                   `linktree_entry_id` int UNSIGNED NOT NULL,
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
                             `referral_id` int UNSIGNED NOT NULL,
                             `user_id` int UNSIGNED NOT NULL,
                             `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                             `pointer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/',
                             `disabled` tinyint(1) NOT NULL DEFAULT '0',
                             `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `referrals`
--

INSERT INTO `referrals` (`referral_id`, `user_id`, `code`, `pointer`, `disabled`, `created_at`, `updated_at`) VALUES
                                                                                                                  (1, 1, 'TEST', '/', 0, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
                                                                                                                  (3, 1, 'TEST1', '/', 0, '2024-02-25 00:00:00', '2024-09-28 15:35:26'),
                                                                                                                  (5, 1, 'TEST42', '/', 0, '2024-02-27 11:04:20', '2024-09-28 15:35:26'),
                                                                                                                  (6, 1, '42', '/', 0, '2024-02-28 21:30:24', '2024-09-28 15:35:26'),
                                                                                                                  (7, 1, 'dfghdfgh', '/', 0, '2024-08-03 23:20:58', '2024-09-28 15:35:26');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
                         `user_id` int UNSIGNED NOT NULL,
                         `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `password` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `description_for_admins` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                         `is_admin` tinyint(1) NOT NULL DEFAULT '0',
                         `disabled` tinyint(1) NOT NULL DEFAULT '0',
                         `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `description_for_admins`, `is_admin`, `disabled`, `created_at`, `updated_at`) VALUES
    (1, 'Nebalus', '$2y$10$9xaR/88aZteW49ExqqveWe6O./RkNfrAj3tSNGPCc/keJsT95EcEu', 'contact@nebalus.dev', 'Is the default test User', 1, 0, '2024-02-28 21:28:40', '2024-08-03 23:07:10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_invitation_tokens`
--

CREATE TABLE `user_invitation_tokens` (
                                          `owner_user_id` int UNSIGNED NOT NULL,
                                          `invited_user_id` int UNSIGNED DEFAULT NULL,
                                          `token_field_1` smallint UNSIGNED NOT NULL,
                                          `token_field_2` smallint UNSIGNED NOT NULL,
                                          `token_field_3` smallint UNSIGNED NOT NULL,
                                          `token_field_4` smallint UNSIGNED NOT NULL,
                                          `token_field_5` smallint UNSIGNED NOT NULL,
                                          `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                          `used_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `user_invitation_tokens`
--

INSERT INTO `user_invitation_tokens` (`owner_user_id`, `invited_user_id`, `token_field_1`, `token_field_2`, `token_field_3`, `token_field_4`, `token_field_5`, `created_at`, `used_at`) VALUES
                                                                                                                                                                                            (1, NULL, 2485, 2764, 9211, 4695, 4788, '2024-11-05 08:12:38', NULL),
                                                                                                                                                                                            (1, NULL, 4586, 5863, 8326, 9386, 7040, '2024-11-05 08:12:38', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_login_history`
--

CREATE TABLE `user_login_history` (
                                      `login_history_id` int UNSIGNED NOT NULL,
                                      `user_id` int UNSIGNED NOT NULL,
                                      `ip_address` blob NOT NULL,
                                      `success` tinyint(1) NOT NULL DEFAULT '0',
                                      `logged_in_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `analytics_linktree_clicks`
--
ALTER TABLE `analytics_linktree_clicks`
    ADD KEY `analytics_linktree_clicks_ibfk_1` (`linktree_id`);

--
-- Indizes für die Tabelle `analytics_linktree_entry_clicks`
--
ALTER TABLE `analytics_linktree_entry_clicks`
    ADD KEY `linktree_entry_id` (`linktree_entry_id`);

--
-- Indizes für die Tabelle `analytics_referral_clicks`
--
ALTER TABLE `analytics_referral_clicks`
    ADD KEY `referral_id` (`referral_id`);

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
  ADD UNIQUE KEY `refcode` (`code`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indizes für die Tabelle `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
    ADD PRIMARY KEY (`token_field_1`,`token_field_2`,`token_field_3`,`token_field_4`,`token_field_5`),
  ADD UNIQUE KEY `invited_user_id` (`invited_user_id`),
  ADD KEY `owner_user_id` (`owner_user_id`);

--
-- Indizes für die Tabelle `user_login_history`
--
ALTER TABLE `user_login_history`
    ADD PRIMARY KEY (`login_history_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `linktrees`
--
ALTER TABLE `linktrees`
    MODIFY `linktree_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    MODIFY `linktree_entry_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `referrals`
--
ALTER TABLE `referrals`
    MODIFY `referral_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `user_login_history`
--
ALTER TABLE `user_login_history`
    MODIFY `login_history_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `analytics_linktree_clicks`
--
ALTER TABLE `analytics_linktree_clicks`
    ADD CONSTRAINT `analytics_linktree_clicks_ibfk_1` FOREIGN KEY (`linktree_id`) REFERENCES `linktrees` (`linktree_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `analytics_linktree_entry_clicks`
--
ALTER TABLE `analytics_linktree_entry_clicks`
    ADD CONSTRAINT `analytics_linktree_entry_clicks_ibfk_1` FOREIGN KEY (`linktree_entry_id`) REFERENCES `linktree_entrys` (`linktree_entry_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `analytics_referral_clicks`
--
ALTER TABLE `analytics_referral_clicks`
    ADD CONSTRAINT `analytics_referral_clicks_ibfk_1` FOREIGN KEY (`referral_id`) REFERENCES `referrals` (`referral_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `linktrees`
--
ALTER TABLE `linktrees`
    ADD CONSTRAINT `linktrees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    ADD CONSTRAINT `linktree_entrys_ibfk_1` FOREIGN KEY (`linktree_id`) REFERENCES `linktrees` (`linktree_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `referrals`
--
ALTER TABLE `referrals`
    ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `user_invitation_tokens`
--
ALTER TABLE `user_invitation_tokens`
    ADD CONSTRAINT `user_invitation_tokens_ibfk_1` FOREIGN KEY (`owner_user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_invitation_tokens_ibfk_2` FOREIGN KEY (`invited_user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints der Tabelle `user_login_history`
--
ALTER TABLE `user_login_history`
    ADD CONSTRAINT `user_login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;