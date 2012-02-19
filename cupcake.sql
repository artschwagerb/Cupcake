-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2012 at 12:57 AM
-- Server version: 5.5.17
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `u_user`
--

CREATE TABLE IF NOT EXISTS `u_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone_number` varchar(16) NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'MD5 of password',
  `confirmcode` varchar(32) DEFAULT NULL,
  `votes_up` int(11) NOT NULL DEFAULT '0',
  `votes_down` int(11) NOT NULL DEFAULT '0',
  `joinDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text NOT NULL,
  `displayname` text NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1' COMMENT '0 for banned, 1 for user, 9 for admin',
  `last_ip` text NOT NULL,
  `premium_ex_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of premium expiration',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=926 ;

-- --------------------------------------------------------

--
-- Table structure for table `v_episode_view`
--

CREATE TABLE IF NOT EXISTS `v_episode_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tvdb_episode_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_play` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
