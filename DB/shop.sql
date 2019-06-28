-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2019 at 11:51 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `allowComments` tinyint(4) NOT NULL DEFAULT '0',
  `allowAds` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent`, `ordering`, `visibility`, `allowComments`, `allowAds`) VALUES
(1, 'Game', '', 0, 1, 0, 0, 0),
(2, 'Toy', 'lot of toys here', 0, 2, 1, 1, 1),
(3, 'Electronics', 'lot of electronics here', 0, 3, 0, 0, 0),
(4, 'Juice', 'some juices here', 0, 6, 1, 0, 1),
(6, 'Orange', 'some juices here', 4, 6, 0, 1, 0),
(7, 'Peach', 'some juices here', 4, 7, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `commentDate` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `status`, `commentDate`, `item_id`, `user_id`) VALUES
(2, 'comment #2', 1, '2019-05-25', 5, 12),
(3, 'comment #3', 1, '2019-05-29', 6, 12),
(4, 'comment #3', 1, '2019-05-29', 6, 12),
(5, 'efeffffff', 1, '2019-05-25', 6, 12),
(9, 'uuuuuuuuuuuuuu', 1, '2019-05-25', 7, 12),
(11, 'This is my comment', 1, '2019-05-30', 3, 12),
(12, 'hello from me', 1, '2019-05-30', 3, 12),
(13, 'HHHHHHHHHHHHHHHHH', 1, '2019-05-30', 3, 12),
(14, 'WDWJDWIHDWHDUWKD\r\n', 1, '2019-05-30', 3, 12),
(15, 'ggggggggggg', 1, '2019-05-30', 3, 12),
(16, 'my second Ad', 1, '2019-05-30', 10, 33),
(17, 'good component', 1, '2019-05-30', 8, 33),
(18, 'Nice', 1, '2019-05-30', 3, 33),
(19, 'Nice', 1, '2019-05-30', 3, 33),
(20, 'very cool', 0, '2019-05-30', 3, 33),
(22, 'kkkkkkkkkk', 0, '2019-05-31', 12, 33);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `addDate` date NOT NULL,
  `countryMade` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `mbr_id` int(11) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `addDate`, `countryMade`, `image`, `status`, `rating`, `cat_id`, `mbr_id`, `approve`) VALUES
(3, 'item1', 'item1', '$100', '2019-05-25', 'Japan', '', '2', 0, 2, 12, 1),
(5, 'item3', 'item3', '$300', '2019-05-25', 'America', '', '1', 0, 2, 20, 1),
(6, 'item4', 'item4', '$400', '2019-05-25', 'Egypt', '', '2', 0, 3, 21, 1),
(7, 'item3', 'item3', '$300', '2019-05-26', 'Almania', '', '4', 0, 1, 1, 1),
(8, 'item2', 'item2', '$200', '2019-05-26', 'Egypt', '', '3', 0, 3, 12, 1),
(9, 'item6', 'it is my new item', '600', '2019-05-28', 'Almania', '', '2', 0, 1, 12, 1),
(10, 'Diode', 'Elenctronic Component', '1', '2019-05-30', 'America', '', '1', 0, 3, 33, 1),
(11, 'Diode', 'Elenctronic Component', '1', '2019-05-30', 'America', '', '1', 0, 3, 33, 1),
(12, 'Transistor', 'Elenctronic Component', '3', '2019-05-30', 'America', '', '1', 0, 3, 33, 1),
(13, 'OP-AMP', 'Elenctronic Component', '5', '2019-05-30', 'America', '', '1', 0, 3, 33, 1),
(14, 'Wire-Jumper', 'Elenctronic Component', '5', '2019-05-30', 'Egypt', '', '1', 0, 3, 33, 1),
(15, 'Resistors', 'Elenctronic Component', '05', '2019-05-30', 'Japan', '', '1', 0, 3, 33, 1),
(16, 'Breadboard', 'Electronic Component', '25', '2019-05-30', 'Egypt', '', '1', 0, 3, 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'To identify user',
  `username` varchar(50) NOT NULL COMMENT 'Username to login',
  `password` varchar(255) NOT NULL COMMENT 'Password to login',
  `email` varchar(50) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Define user group',
  `trustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Selle rank',
  `regStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'To approve user',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullName`, `group_id`, `trustStatus`, `regStatus`, `date`) VALUES
(1, 'Abdallah', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'abuzeed@yahoo.com', 'Abdallah Abuzead', 1, 0, 1, '0000-00-00'),
(12, 'Mohamed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm@m.com', 'Mohamed Eid', 0, 0, 1, '0000-00-00'),
(18, 'Mahmoud', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm@m.com', 'Mahmoud Yahya', 0, 0, 1, '0000-00-00'),
(19, 'Fekry', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'f@f.com', 'Fekry Mohamed', 0, 0, 1, '0000-00-00'),
(20, 'Ibrahim', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'i@i.com', 'Ibrahim Abuzead', 0, 0, 1, '0000-00-00'),
(21, 'Islam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'i@i.com', 'Islam Maged', 0, 0, 1, '2019-05-20'),
(26, 'asad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm@m.com', 'e5tryyy', 0, 0, 1, '2019-05-21'),
(29, 'Eid', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm@m.com', 'Eid Ahmed', 1, 0, 1, '2019-05-27'),
(32, 'sas', '7ddbb6309d14a74d92e31b26f3ff5454dfa0708b', 'm@m.com', '', 0, 0, 1, '2019-05-28'),
(33, 'Omar', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'o@o.com', '', 0, 0, 1, '2019-05-28'),
(34, 'Moneeb', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm@m.com', '', 0, 0, 1, '2019-05-28'),
(35, 'Kago', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'k@k.com', '', 0, 0, 1, '2019-05-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_item` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_user` (`mbr_id`),
  ADD KEY `item_cat` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify user', AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `item_cat` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_user` FOREIGN KEY (`mbr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
