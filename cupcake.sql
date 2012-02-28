-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2012 at 01:19 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cupcake`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_comment`
--

CREATE TABLE IF NOT EXISTS `c_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `c_reported`
--

CREATE TABLE IF NOT EXISTS `c_reported` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_reported`
--


-- --------------------------------------------------------

--
-- Table structure for table `c_status`
--

CREATE TABLE IF NOT EXISTS `c_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `c_topic`
--

CREATE TABLE IF NOT EXISTS `c_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 for disabled, 1 for enabled',
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `color` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `premium` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--


-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `sidebar` text NOT NULL,
  `permission_level` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `user_id`, `status_id`, `date_modified`, `title`, `body`, `sidebar`, `permission_level`) VALUES
(1, 1, 1, '2012-02-27 13:14:57', '', 'LOL, HOMEPAGE GO', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `u_activity`
--

CREATE TABLE IF NOT EXISTS `u_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_play` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `u_activity`
--


-- --------------------------------------------------------

--
-- Table structure for table `u_premium`
--

CREATE TABLE IF NOT EXISTS `u_premium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `u_premium`
--


-- --------------------------------------------------------

--
-- Table structure for table `u_user`
--

CREATE TABLE IF NOT EXISTS `u_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'MD5 of password',
  `confirmcode` varchar(32) DEFAULT NULL,
  `joinDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `displayname` text NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1' COMMENT '0 for banned, 1 for user, 9 for admin',
  `last_ip` text NOT NULL,
  `premium_ex_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of premium expiration',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `u_user`
--

INSERT INTO `u_user` (`id`, `name`, `email`, `username`, `password`, `confirmcode`, `joinDate`, `lastDate`, `displayname`, `status_id`, `last_ip`, `premium_ex_date`) VALUES
(1, 'admin', '', 'admin', 'e229dca52dbfa50c12f80f746c8d6867', 'y', '2012-02-27 13:14:31', '0000-00-00 00:00:00', 'Administrator', 9, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `v_episode`
--

CREATE TABLE IF NOT EXISTS `v_episode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL DEFAULT '1',
  `name` text NOT NULL,
  `number` int(11) NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `hits` int(11) NOT NULL DEFAULT '0',
  `date_added` date NOT NULL,
  `rating` text NOT NULL,
  `tvdb_episode_id` int(11) NOT NULL DEFAULT '0',
  `tvdb_season_id` int(11) NOT NULL DEFAULT '0',
  `tvdb_series_id` int(11) NOT NULL DEFAULT '0',
  `date_aired` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `v_episode`
--


-- --------------------------------------------------------

--
-- Table structure for table `v_movie`
--

CREATE TABLE IF NOT EXISTS `v_movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `description` text NOT NULL,
  `filename` text NOT NULL,
  `active` int(11) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `date_added` date NOT NULL,
  `votes_up` int(11) NOT NULL DEFAULT '0',
  `votes_down` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `v_movie`
--


-- --------------------------------------------------------

--
-- Table structure for table `v_season`
--

CREATE TABLE IF NOT EXISTS `v_season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `date_added` date NOT NULL,
  `date_aired` date NOT NULL,
  `tvdb_season_id` int(11) NOT NULL DEFAULT '0',
  `tvdb_series_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `v_season`
--


-- --------------------------------------------------------

--
-- Table structure for table `v_show`
--

CREATE TABLE IF NOT EXISTS `v_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `author_id` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1',
  `date_added` date NOT NULL,
  `date_aired` date NOT NULL,
  `tvdb_series_id` int(11) NOT NULL DEFAULT '0',
  `filepath` text NOT NULL,
  `genre` text NOT NULL,
  `airs_dayofweek` text NOT NULL,
  `airs_time` text NOT NULL,
  `content_rating` text NOT NULL,
  `network` text NOT NULL,
  `actors` text NOT NULL,
  `imdb_id` text NOT NULL,
  `runtime` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `v_show`
--

