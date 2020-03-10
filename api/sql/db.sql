-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `upfy`;
CREATE DATABASE `upfy` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `upfy`;

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `token` char(64) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `auth` (`token`, `fk_user`, `creation_time`, `last_visit`) VALUES
('5026d80099cbf1871065e5a331380f025a392698f52981c9dd074f74d28fde19',	14,	'2020-03-09 19:03:24',	'2020-03-09 19:03:24'),
('688f4eafe4c8aa55e498902f2593c1e64efdb84f4b3e541d65e51c049d3493aa',	14,	'2020-03-09 19:02:43',	'2020-03-09 19:02:43'),
('7c82c02a2218cfae5dc6d2d9c6d5efd995596158abaffa0950e76900a5d4e998',	14,	'2020-03-09 19:04:05',	'2020-03-09 19:20:13'),
('9c9df8e1ce3ed5abd48f8887c2f1ca2c77a0e4c9fa37e03c823fce1ec7403d1c',	14,	'2020-03-09 19:03:25',	'2020-03-09 19:03:25'),
('asd',	14,	'2020-03-09 18:32:15',	'2020-03-09 18:56:08');

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
(13,	'andreus',	'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',	'2020-03-08 19:55:26',	'2020-03-09 19:20:13'),
(14,	'andre',	'cbeb0102202435f4c80d0ce7c5fb54070a2ab0a7e98f0fc57efd4005561a20c0',	'2020-03-08 19:55:47',	'2020-03-08 19:55:47');

-- 2020-03-10 00:56:11
