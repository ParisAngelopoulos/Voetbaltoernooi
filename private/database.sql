-- Database of Voetbaltoernooi (SQLite). Created automatically by database_connection.php
-- the first time private/database.sqlite does not exist yet.
-- Test accounts: admin / admin123, and one account per team with the password welkom123.

CREATE TABLE users (
  user_id INTEGER PRIMARY KEY AUTOINCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(10) NOT NULL DEFAULT 'user' CHECK (role IN ('admin', 'user')),
  loggedin INTEGER DEFAULT 0
);

CREATE TABLE teams (
  team_id INTEGER PRIMARY KEY AUTOINCREMENT,
  team_name VARCHAR(100) NOT NULL,
  user_id INTEGER DEFAULT NULL REFERENCES users (user_id)
);

CREATE TABLE players (
  player_id INTEGER PRIMARY KEY AUTOINCREMENT,
  player_name VARCHAR(100) NOT NULL,
  team_id INTEGER DEFAULT NULL REFERENCES teams (team_id)
);

-- Played matches have a result, planned ones not yet (NULL)
CREATE TABLE matches (
  match_id INTEGER PRIMARY KEY AUTOINCREMENT,
  team1_id INTEGER DEFAULT NULL REFERENCES teams (team_id),
  team2_id INTEGER DEFAULT NULL REFERENCES teams (team_id),
  match_date DATE DEFAULT NULL,
  team1_results INTEGER DEFAULT NULL,
  team2_results INTEGER DEFAULT NULL
);

INSERT INTO users (user_id, username, password_hash, role, loggedin) VALUES
(1, 'admin', '$2y$10$rgSNNmzZ/tJrl6LtHDboGu1tz1rEfxXrxjkYgWEWXowqbSjCP9eCO', 'admin', 0),
(2, 'fcveenendaal', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(3, 'edeunited', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(4, 'rhenen', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(5, 'wolves', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(6, 'barneveld', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0),
(7, 'stars', '$2y$10$NzYQQPJn63vmWhUl.H22C.84CPqtQ/tWbQiCK9YDjFfsS/qNH7Nma', 'user', 0);

INSERT INTO teams (team_id, team_name, user_id) VALUES
(1, 'FC Veenendaal', 2),
(2, 'Ede United', 3),
(3, 'Rhenen Rangers', 4),
(4, 'Wageningen Wolves', 5),
(5, 'Barneveld Boys', 6),
(6, 'Scherpenzeel Stars', 7);

INSERT INTO players (player_id, player_name, team_id) VALUES
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

INSERT INTO matches (match_id, team1_id, team2_id, match_date, team1_results, team2_results) VALUES
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
