-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `upfy` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `upfy`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` char(64) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `name`, `pass`, `creation_time`, `update_time`) VALUES
(13,	'andre',	'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',	'2020-03-08 19:55:26',	'2020-03-08 20:11:06'),
(14,	'andre',	'cbeb0102202435f4c80d0ce7c5fb54070a2ab0a7e98f0fc57efd4005561a20c0',	'2020-03-08 19:55:47',	'2020-03-08 19:55:47');

-- 2020-03-08 23:24:14