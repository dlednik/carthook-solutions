-- This is the structure for the MySQL database.
-- Tested on version 8.0.15

-- Each team has its unique ID and can also be queried by name which has unique index
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `logo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- This table contains all the players
-- Indexes enable search by name/surname
CREATE TABLE `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_name_idx` (`name`),
  KEY `player_surname_ixd` (`surname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- This table links players to a team.TABLE
-- I used id as primary key to allow for events when player leaves a team but at some point returns to the team.
-- So we need id as primary key here.
-- We record when player joined and when he left particular team
CREATE TABLE `player_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `joined_date` date NOT NULL,
  `left_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_idx` (`player_id`),
  KEY `team_idx` (`team_id`),
  KEY `joined_idx` (`joined_date`),
  KEY `left_idx` (`left_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- This is where we store all the played games
-- we have the score and the date/time when it was played as well as which teams were playing
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `home_team` int(11) NOT NULL,
  `guest_team` int(11) NOT NULL,
  `played_date` datetime NOT NULL,
  `home_points` int(4) NOT NULL,
  `guest_points` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `home_idx` (`home_team`),
  KEY `guest_idx` (`guest_team`),
  KEY `played_idx` (`played_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- This table contains players statistics
-- It contains all the possible statistics values for a given match
CREATE TABLE `player_stats` (
  `player_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `points_1` int(4) NOT NULL DEFAULT '0',
  `points_1_shots` int(4) NOT NULL DEFAULT '0',
  `points_2` int(4) NOT NULL DEFAULT '0',
  `points_2_shots` int(4) NOT NULL DEFAULT '0',
  `points_3` int(4) NOT NULL DEFAULT '0',
  `points_3_shots` int(4) NOT NULL DEFAULT '0',
  `rebounds` int(4) NOT NULL DEFAULT '0',
  `blocks` int(4) NOT NULL DEFAULT '0',
  `steals` int(4) NOT NULL DEFAULT '0',
  `assists` int(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `player_game_idx` (`player_id`,`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- This table structure and indexes also satisfies the most frequent searches.
-- If there would be more complexes searches in the future it is a simple matter of adding indexes to improve performance.
