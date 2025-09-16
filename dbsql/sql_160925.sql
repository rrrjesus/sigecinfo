-- ========================
-- DATABASE
-- ========================
CREATE DATABASE IF NOT EXISTS sigecinfo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sigecinfo;

-- ========================
-- USERS
-- ========================
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status TINYINT(1) DEFAULT 1,
    level_id INT(11) UNSIGNED NULL,
    position_id INT(11) UNSIGNED NULL,
    church_id INT(11) UNSIGNED NULL, -- antes era unit_id
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- LEVELS
-- ========================
CREATE TABLE levels (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- USER POSITIONS
-- ========================
CREATE TABLE user_positions (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- CHURCHES
-- ========================
CREATE TABLE churches (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- MEETINGS
-- ========================
CREATE TABLE meetings (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    meeting_date DATETIME NOT NULL,
    meeting_type ENUM('online','presential') NOT NULL,
    link VARCHAR(255) NULL,
    church_id INT(11) UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- INVITATIONS
-- ========================
CREATE TABLE invitations (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    meeting_id INT(11) UNSIGNED NOT NULL,
    sent TINYINT(1) DEFAULT 0,
    sent_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    login_created INT(11) UNSIGNED NULL,
    login_updated INT(11) UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================
-- REPORT_ACCESS
-- ========================
CREATE TABLE report_access (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  users INT(11) NOT NULL DEFAULT 1,
  views INT(11) NOT NULL DEFAULT 1,
  pages INT(11) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ========================
-- REPORT_ONLINE
-- ========================
CREATE TABLE report_online (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  user INT(11) UNSIGNED DEFAULT NULL,
  ip VARCHAR(50) NOT NULL DEFAULT '',
  url VARCHAR(255) NOT NULL DEFAULT '',
  agent VARCHAR(255) NOT NULL DEFAULT '',
  pages INT(11) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ========================
-- FOREIGN KEYS
-- ========================

-- Users
ALTER TABLE users
    ADD CONSTRAINT fk_users_level FOREIGN KEY (level_id) REFERENCES levels(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_users_position FOREIGN KEY (position_id) REFERENCES user_positions(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_users_church FOREIGN KEY (church_id) REFERENCES churches(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_users_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_users_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Levels
ALTER TABLE levels
    ADD CONSTRAINT fk_levels_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_levels_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- User Positions
ALTER TABLE user_positions
    ADD CONSTRAINT fk_positions_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_positions_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Churches
ALTER TABLE churches
    ADD CONSTRAINT fk_churches_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_churches_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Meetings
ALTER TABLE meetings
    ADD CONSTRAINT fk_meetings_church FOREIGN KEY (church_id) REFERENCES churches(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_meetings_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_meetings_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Invitations
ALTER TABLE invitations
    ADD CONSTRAINT fk_invitations_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_invitations_meeting FOREIGN KEY (meeting_id) REFERENCES meetings(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_invitations_created_by FOREIGN KEY (login_created) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT fk_invitations_updated_by FOREIGN KEY (login_updated) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Report Online
ALTER TABLE report_online
    ADD CONSTRAINT fk_report_online_user FOREIGN KEY (user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION;
