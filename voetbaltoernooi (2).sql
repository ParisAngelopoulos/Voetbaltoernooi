-- Database voor Voetbaltoernooi
-- Importeer dit bestand in een database met de naam `voetbaltoernooi`.
-- Testaccounts: admin / admin123, en per team een account met wachtwoord welkom123.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `matches`, `players`, `teams`, `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `loggedin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `loggedin`) VALUES
(1, 'admin', '$2y$10$rgSNNmzZ/tJrl6LtHDboGu1tz1rEfxXrxjkYgWEWXowqbSjCP9eCO', 'admin', 0),
(2, 'fcveenendaal', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(3, 'edeunited', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(4, 'rhenen', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(5, 'wolves', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(6, 'barneveld', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(7, 'stars', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0);

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `teams` (`team_id`, `team_name`, `user_id`) VALUES
(1, 'FC Veenendaal', 2),
(2, 'Ede United', 3),
(3, 'Rhenen Rangers', 4),
(4, 'Wageningen Wolves', 5),
(5, 'Barneveld Boys', 6),
(6, 'Scherpenzeel Stars', 7);

CREATE TABLE `players` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_name` varchar(100) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`player_id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `players` (`player_id`, `player_name`, `team_id`) VALUES
(1, 'Daan de Groot', 1),
(2, 'Milan Visser', 1),
(3, 'Thomas Smit', 1),
(4, 'Luuk Mulder', 1),
(5, 'Sem Bos', 1),
(6, 'Noah Peters', 2),
(7, 'Jesse Hendriks', 2),
(8, 'Finn Dekker', 2),
(9, 'Bram Vos', 2),
(10, 'Lars Meijer', 2),
(11, 'Youssef El Idrissi', 3),
(12, 'Ruben Kok', 3),
(13, 'Tim Jacobs', 3),
(14, 'Stijn de Wit', 3),
(15, 'Mees Willems', 3),
(16, 'Julian Brouwer', 4),
(17, 'Daniël Koster', 4),
(18, 'Sven van Dijk', 4),
(19, 'Max Bakker', 4),
(20, 'Gijs Prins', 4),
(21, 'Thijs Vermeulen', 5),
(22, 'Niels de Boer', 5),
(23, 'Koen Schouten', 5),
(24, 'Rick Hoekstra', 5),
(25, 'Jens Post', 5),
(26, 'Mohamed Amrani', 6),
(27, 'Jayden Kuipers', 6),
(28, 'Olivier Verbeek', 6),
(29, 'Siem Lammers', 6),
(30, 'Hugo Bosman', 6);

CREATE TABLE `matches` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `team1_id` int(11) DEFAULT NULL,
  `team2_id` int(11) DEFAULT NULL,
  `match_date` date DEFAULT NULL,
  `team1_results` int(11) DEFAULT NULL,
  `team2_results` int(11) DEFAULT NULL,
  PRIMARY KEY (`match_id`),
  KEY `team1_id` (`team1_id`),
  KEY `team2_id` (`team2_id`),
  CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`team_id`),
  CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Gespeelde wedstrijden hebben een uitslag, geplande nog niet (NULL)
INSERT INTO `matches` (`match_id`, `team1_id`, `team2_id`, `match_date`, `team1_results`, `team2_results`) VALUES
(1, 1, 2, '2025-05-03', 3, 1),
(2, 3, 4, '2025-05-03', 2, 2),
(3, 5, 6, '2025-05-03', 0, 1),
(4, 1, 3, '2025-05-10', 1, 2),
(5, 2, 5, '2025-05-10', 4, 0),
(6, 4, 6, '2025-05-10', 3, 3),
(7, 1, 4, '2025-05-17', 2, 0),
(8, 2, 6, '2025-05-17', 1, 1),
(9, 3, 5, '2025-05-17', 5, 2),
(10, 1, 5, '2025-05-24', NULL, NULL),
(11, 2, 3, '2025-05-24', NULL, NULL),
(12, 4, 6, '2025-05-31', NULL, NULL);
