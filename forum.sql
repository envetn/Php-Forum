-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 21 dec 2014 kl 21:26
-- Serverversion: 5.6.12-log
-- PHP-version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `filter` varchar(255) NOT NULL,
  `published` datetime NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `Creator` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `blog`
--

INSERT INTO `blog` (`id`, `type`, `title`, `data`, `filter`, `published`, `created`, `updated`, `deleted`, `Creator`) VALUES
(1, 'Blog', 'RINGEN', 'Härsken på ringen, Berättelse om de äventyr som Frito, hans trogne vän Skam, trollkarlen Goodguy, utbygdsjägaren Arrowroot, alven Legolam och dvärgen Strimli mötte då de förde den där ringen till Ändalyktsklyftan i Fordor.\r\nTrots att det krävdes en bok och inte tre är det en lång och farofylld resa för de opålitliga kamraterna som har den dolske Goddam i hasorna och jagas av Snarktrupper, Nerziler och Svarta ryttare. Vågar du följa dem på deras färd?\r\nHärsken på ringen är en fyndig, fräck och emellanåt riktigt fånig, men ständigt lika kärleksfull parodi på en av det gångna århundradets mest storartade böcker.\r\nTre ringar på alvkungars mök på plan två. \r\nSju för dvärgarna som borstar på alltför korta ben. \r\nNio för de nödiga som klämmer köttets deg. \r\nEn För murken herre som stånkar sig seg, i motbjudande luva.\r\n\r\nEn ring att sitta på. \r\nEn ring att titta på. \r\nEn ring djupt i mörksens rike inte gitta nå, i Fordor där skuggan får snuva.', 'bbcode,nl2br', '2014-01-15 00:24:11', '2014-02-04 17:13:48', NULL, NULL, 'Admin\r\n'),
(2, 'Blog', 'Min hemsida', 'asdasd', 'bbcode,nl2br', '2013-12-11 22:18:57', '2014-02-04 17:22:04', NULL, NULL, 'admin');

-- --------------------------------------------------------

--
-- Tabellstruktur `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `last_post_date` date DEFAULT NULL,
  `last_user_posted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `categories`
--

INSERT INTO `categories` (`id`, `category_title`, `category_description`, `last_post_date`, `last_user_posted`) VALUES
(1, 'Forum', 'A category about everything', '2014-09-22', 6),
(2, 'Coding', 'Category about coding', '2014-09-23', 10),
(3, 'Animals', 'Categori about animals', '2014-10-05', 10);

-- --------------------------------------------------------

--
-- Tabellstruktur `galleryimages`
--

CREATE TABLE IF NOT EXISTS `galleryimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `galleryId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=257 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` tinyint(4) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_creator` int(11) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `topic_id`, `post_creator`, `post_content`, `post_date`) VALUES
(39, 3, 12, 1, 'Need help with array in java coding', '2014-09-22 09:42:33'),
(40, 3, 12, 9, 'what do you need?', '2014-09-22 09:43:54'),
(41, 2, 13, 6, 'blabla bla, meningless content', '2014-09-22 09:49:05'),
(42, 2, 13, 1, 'this is a replay to your post', '2014-09-22 09:52:00'),
(43, 3, 12, 1, 'REPLay in java', '2014-09-22 10:05:36'),
(44, 1, 14, 6, '', '2014-09-22 11:00:11'),
(47, 3, 12, 6, 'asd', '2014-09-22 11:15:24'),
(48, 3, 12, 6, 'asd', '2014-09-22 11:15:26'),
(49, 3, 12, 6, 'asd', '2014-09-22 11:15:27'),
(50, 3, 12, 6, 'asd', '2014-09-22 11:15:29'),
(51, 3, 12, 6, 'asd', '2014-09-22 11:15:31'),
(52, 3, 12, 6, 'asd', '2014-09-22 11:15:33'),
(53, 3, 12, 6, 'asd', '2014-09-22 11:15:34'),
(54, 3, 12, 6, 'asd', '2014-09-22 11:15:36'),
(55, 3, 12, 6, 'asd', '2014-09-22 11:15:37'),
(56, 3, 12, 6, 'asd', '2014-09-22 11:15:38'),
(57, 3, 12, 6, 'asd', '2014-09-22 11:15:40'),
(58, 3, 12, 6, 'dasdasd', '2014-09-22 11:15:43'),
(59, 3, 12, 6, 'asdasdasd', '2014-09-22 11:15:45'),
(60, 3, 12, 6, 'asd', '2014-09-22 11:37:33'),
(61, 3, 12, 6, 'asd', '2014-09-22 11:37:35'),
(62, 3, 12, 6, 'asd', '2014-09-22 11:37:37'),
(63, 3, 12, 6, 'asd', '2014-09-22 11:37:38'),
(64, 3, 12, 6, 'asd', '2014-09-22 11:37:39'),
(65, 3, 12, 6, 'asd', '2014-09-22 11:37:40'),
(66, 3, 12, 6, 'asd', '2014-09-22 11:37:42'),
(67, 3, 12, 6, 'asd', '2014-09-22 11:37:43'),
(68, 3, 12, 6, 'asd', '2014-09-22 11:37:44'),
(69, 3, 12, 6, 'asd', '2014-09-22 11:37:46'),
(70, 3, 12, 6, 'asd', '2014-09-22 11:37:49'),
(71, 3, 12, 6, 'asd', '2014-09-22 11:37:50'),
(72, 3, 12, 6, 'asd', '2014-09-22 11:37:51'),
(73, 3, 12, 6, 'asd', '2014-09-22 11:37:53'),
(74, 3, 12, 6, 'asd', '2014-09-22 11:37:54'),
(75, 3, 12, 6, 'asd', '2014-09-22 11:37:56'),
(76, 3, 12, 6, 'asd', '2014-09-22 11:37:57'),
(77, 3, 12, 1, 'duuuuude, aaah duuuude', '2014-09-22 12:00:11'),
(78, 2, 13, 9, 'ASSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS', '2014-09-22 12:29:18'),
(79, 2, 15, 9, 'what topic id is this', '2014-09-22 12:30:52'),
(80, 2, 15, 10, 'replay', '2014-09-22 12:35:03'),
(81, 3, 12, 1, 'qwersfgh', '2014-09-22 12:42:16'),
(82, 3, 12, 10, 'replay', '2014-09-22 12:43:33'),
(83, 3, 12, 10, '123', '2014-09-22 12:50:05'),
(84, 3, 12, 10, '123', '2014-09-22 12:50:07'),
(85, 3, 12, 10, '123', '2014-09-22 12:50:08'),
(86, 3, 12, 10, '123', '2014-09-22 12:50:11'),
(87, 3, 12, 10, '123', '2014-09-22 12:50:15'),
(88, 2, 15, 10, 'l<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nl<br />\r\nll<br />\r\nl<br />\r\nl<br />\r\n<br />\r\nll', '2014-09-23 12:02:03'),
(89, 3, 12, 9, 'asdasd', '2014-10-05 20:42:24'),
(90, 3, 12, 9, 'asdasd', '2014-10-05 20:42:27'),
(91, 3, 16, 9, '123', '2014-10-05 20:45:55'),
(92, 3, 16, 10, '123123', '2014-10-05 20:46:20');

-- --------------------------------------------------------

--
-- Tabellstruktur `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` tinyint(4) NOT NULL,
  `topic_title` varchar(150) NOT NULL,
  `topic_creator` int(11) NOT NULL,
  `topic_last_user` int(11) DEFAULT NULL,
  `topic_date` datetime NOT NULL,
  `topic_replay_date` datetime NOT NULL,
  `topic_views` int(11) NOT NULL DEFAULT '0',
  `topic_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumpning av Data i tabell `topic`
--

INSERT INTO `topic` (`id`, `category_id`, `topic_title`, `topic_creator`, `topic_last_user`, `topic_date`, `topic_replay_date`, `topic_views`, `topic_content`) VALUES
(12, 3, 'Java, help Array', 1, 9, '2014-09-22 09:42:33', '2014-10-05 20:42:27', 604, 'Need help with array in java coding'),
(13, 2, 'c++ recursive function', 6, 9, '2014-09-22 09:49:05', '2014-09-22 12:29:18', 17, 'blabla bla, meningless content'),
(14, 1, 'category id 1', 6, NULL, '2014-09-22 11:00:11', '2014-09-22 11:00:11', 9, ''),
(15, 2, 'what topic is this', 9, 10, '2014-09-22 12:30:52', '2014-09-23 12:02:03', 41, 'what topic id is this'),
(16, 3, '123', 9, 10, '2014-10-05 20:45:55', '2014-10-05 20:46:20', 31, '123');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `forum_notify` enum('0','1') NOT NULL DEFAULT '1',
  `Registered` date DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `forum_notify`, `Registered`, `avatar`, `admin`) VALUES
(1, 'lofie', 'caf1a3dfb505ffed0d024130f58c5cfa', 'lofielus@gmail.com', '1', '2013-02-01', 'userImg/admin.jpg', 1),
(6, 'asd', '3dad9cbf9baaa0360c0f2ba372d25716', 'asd', '1', '2014-02-01', 'userImg/asd.jpg', 0),
(9, '123', 'd9b1d7db4cd6e70935368a1efb10e377', 'olle.ch@hotmail.com', '1', '2014-02-04', 'userImg/user.gif', 0),
(10, 'envetn', '202cb962ac59075b964b07152d234b70', 'envetn.@ngt.com', '1', '2014-09-22', 'userImg/beewbs.gif', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
