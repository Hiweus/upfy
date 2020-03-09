-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2020 at 05:07 PM
-- Server version: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upfy`
--
CREATE DATABASE IF NOT EXISTS `upfy` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `upfy`;

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `token` char(64) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`token`, `fk_user`, `creation_time`, `last_visit`) VALUES
('110a8830e53b18cb52f326bac1e05d9edd42512fe1cf319e3099e4074d039345', 13, '2020-03-09 10:12:41', '2020-03-09 10:12:41'),
('28cd72b6f7865d35f34f304f1add9d3af292c95790b67acd0300327395f50fa7', 13, '2020-03-09 10:23:29', '2020-03-09 10:23:29'),
('371a16acc7fb2561dc504879f00e181eb322d7decd85924f23f9d679fe5d8dc7', 13, '2020-03-09 10:23:30', '2020-03-09 10:23:30'),
('40fc651d5ff85788d1e0aa76e288520c48c5e6e310a5ea7d401cfcf43f91a1d6', 13, '2020-03-09 10:23:29', '2020-03-09 10:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pass` char(64) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `pass`, `creation_time`, `update_time`) VALUES
(13, 'andre', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '2020-03-08 19:55:26', '2020-03-09 07:38:43'),
(14, 'andre', 'cbeb0102202435f4c80d0ce7c5fb54070a2ab0a7e98f0fc57efd4005561a20c0', '2020-03-08 19:55:47', '2020-03-08 19:55:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
