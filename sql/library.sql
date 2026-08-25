-- Library Management System - MySQL schema
-- Run this on your MySQL server, then update application/config/database.php
-- to use the 'mysqli' driver with your credentials.

CREATE DATABASE IF NOT EXISTS `library` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `library`;

CREATE TABLE `categories` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(120) NOT NULL,
  `description` TEXT,
  `created_at`  DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `books` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`            VARCHAR(255) NOT NULL,
  `author`           VARCHAR(255) NOT NULL,
  `isbn`             VARCHAR(40) DEFAULT NULL,
  `publisher`        VARCHAR(160) DEFAULT NULL,
  `year`             INT(4) DEFAULT NULL,
  `category_id`      INT(11) UNSIGNED DEFAULT NULL,
  `total_copies`     INT(11) NOT NULL DEFAULT 1,
  `available_copies` INT(11) NOT NULL DEFAULT 1,
  `created_at`       DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `members` (
  `id`              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(160) NOT NULL,
  `email`           VARCHAR(160) DEFAULT NULL,
  `phone`           VARCHAR(40) DEFAULT NULL,
  `address`         TEXT,
  `membership_date` DATE DEFAULT NULL,
  `status`          VARCHAR(20) NOT NULL DEFAULT 'active',
  `created_at`      DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `issues` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id`    INT(11) UNSIGNED NOT NULL,
  `member_id`  INT(11) UNSIGNED NOT NULL,
  `issue_date` DATE DEFAULT NULL,
  `due_date`   DATE DEFAULT NULL,
  `return_date` DATE DEFAULT NULL,
  `status`     VARCHAR(20) NOT NULL DEFAULT 'issued',
  `fine`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `created_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(80) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `name`       VARCHAR(160) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default administrator (password: admin123)
INSERT INTO `users` (`username`, `password`, `name`, `created_at`)
VALUES ('admin', '$2y$12$6Vy/kcy41LU24Mo9YEnOTe0T9hqmpjHOaBdIMsN/87J/P3nKqmcUq', 'Administrator', NOW());
