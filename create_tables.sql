-- Create the 'booklist' database before executing this SQL

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `isbn` varchar(40) NOT NULL,
  `title` varchar(120) NOT NULL,
  `author` varchar(120) NOT NULL,
  `selfLink` varchar(255) NOT NULL,
  `publisheddate` year(4) NOT NULL,
  `saveddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `thumbnail` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  PRIMARY KEY (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `library`;
CREATE TABLE `library` (
  `isbn` varchar(40) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `readit` tinyint(1) NOT NULL,
  `wishlist` tinyint(1) NOT NULL,
  `saveddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
