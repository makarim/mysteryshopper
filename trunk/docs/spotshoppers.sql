-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 01 月 19 日 17:35
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `spotshoppers`
--

-- --------------------------------------------------------

--
-- 表的结构 `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_title` varchar(255) NOT NULL,
  `a_desc` text NOT NULL,
  `a_date` date NOT NULL,
  `c_id` int(11) NOT NULL,
  `a_recommend` tinyint(1) NOT NULL,
  `a_order` mediumint(9) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`a_id`),
  KEY `c_id` (`c_id`),
  KEY `s_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `assignment`
--


-- --------------------------------------------------------

--
-- 表的结构 `assignment_rel`
--

CREATE TABLE IF NOT EXISTS `assignment_rel` (
  `a_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selected` tinyint(1) NOT NULL,
  KEY `a_id` (`a_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `assignment_rel`
--


-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `client_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `domain` varchar(60) NOT NULL,
  `private_key` char(32) NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `client`
--


-- --------------------------------------------------------

--
-- 表的结构 `corporation`
--

CREATE TABLE IF NOT EXISTS `corporation` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(100) NOT NULL,
  `c_intro` text NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `corporation`
--


-- --------------------------------------------------------

--
-- 表的结构 `forget_pwd`
--

CREATE TABLE IF NOT EXISTS `forget_pwd` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user` varchar(64) NOT NULL,
  `code` char(32) NOT NULL,
  `start_ts` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `forget_pwd`
--


-- --------------------------------------------------------

--
-- 表的结构 `onlineuser`
--

CREATE TABLE IF NOT EXISTS `onlineuser` (
  `ticket` char(32) NOT NULL,
  `user` varchar(64) NOT NULL,
  `expiry` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  UNIQUE KEY `session_id` (`ticket`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `onlineuser`
--

INSERT INTO `onlineuser` (`ticket`, `user`, `expiry`, `data`) VALUES
('qbc7a17cqmcgmh456m95di5p76', 'kakapowu@gmail.com', 1263919498, '{"user_id":"1","user":"kakapowu@gmail.com","user_password":"78fb66bee250b7ea217610ba762aff18","user_email":"kakapowu@gmail.com","user_nickname":"administrator","user_sex":"1","user_state":"1","user_reg_time":"1263486757","user_reg_ip":"127.0.0.1","user_lastlogin_time":"1263831860","user_lastlogin_ip":"127.0.0.1","user_question":"","user_answer":"","autologin":"0","ticket":"qbc7a17cqmcgmh456m95di5p76"}');

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL,
  `q_group` enum('E','S','P') NOT NULL,
  `q_type` tinyint(1) NOT NULL,
  `q_question` varchar(255) NOT NULL,
  `q_answer` varchar(200) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `question`
--


-- --------------------------------------------------------

--
-- 表的结构 `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) NOT NULL,
  `re_date` date NOT NULL,
  `c_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `re_sum` int(11) NOT NULL,
  PRIMARY KEY (`re_id`),
  KEY `s_id` (`user_id`),
  KEY `c_id` (`c_id`),
  KEY `a_id` (`a_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `report`
--


-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `k` varchar(32) NOT NULL DEFAULT '',
  `v` text NOT NULL,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`k`, `v`) VALUES
('app_status', 'dev'),
('timezone', 'Asia/Shanghai'),
('ssomode', 'ticket');

-- --------------------------------------------------------

--
-- 表的结构 `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(255) NOT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `c_id` (`c_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `store`
--


-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) unsigned NOT NULL,
  `user` varchar(64) NOT NULL,
  `user_password` char(32) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_nickname` varchar(16) NOT NULL,
  `user_sex` tinyint(1) NOT NULL,
  `user_state` tinyint(1) NOT NULL,
  `user_reg_time` int(11) unsigned NOT NULL,
  `user_reg_ip` varchar(16) NOT NULL,
  `user_lastlogin_time` int(11) unsigned NOT NULL,
  `user_lastlogin_ip` varchar(16) NOT NULL,
  `user_question` varchar(128) NOT NULL,
  `user_answer` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user`, `user_password`, `user_email`, `user_nickname`, `user_sex`, `user_state`, `user_reg_time`, `user_reg_ip`, `user_lastlogin_time`, `user_lastlogin_ip`, `user_question`, `user_answer`) VALUES
(1, 'kakapowu@gmail.com', '78fb66bee250b7ea217610ba762aff18', 'kakapowu@gmail.com', 'administrator', 1, 1, 1263486757, '127.0.0.1', 1263918058, '127.0.0.1', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `user_ext`
--

CREATE TABLE IF NOT EXISTS `user_ext` (
  `user_id` int(11) NOT NULL,
  `realname` varchar(8) NOT NULL,
  `initial` char(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(18) NOT NULL,
  `province` varchar(12) NOT NULL,
  `zipcode` varchar(8) NOT NULL,
  `email` varchar(60) NOT NULL,
  `cellphone` varchar(15) NOT NULL,
  `homephone` varchar(18) NOT NULL,
  `birthdate` date NOT NULL,
  `marital` enum('M','S') NOT NULL,
  `interests` varchar(255) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `occupation` varchar(60) NOT NULL,
  `education` varchar(60) NOT NULL,
  `annual_income` varchar(60) NOT NULL,
  `clothing_size` varchar(12) NOT NULL,
  `own_camera` tinyint(1) NOT NULL,
  `own_recorder` tinyint(1) NOT NULL,
  `speak_english` tinyint(1) NOT NULL,
  `payment` varchar(12) NOT NULL,
  `receive_email` tinyint(1) NOT NULL,
  KEY `s_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_ext`
--


-- --------------------------------------------------------

--
-- 表的结构 `user_index`
--

CREATE TABLE IF NOT EXISTS `user_index` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(64) NOT NULL,
  `user_nickname` varchar(16) NOT NULL,
  `user_reg_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user` (`user`),
  KEY `user_nickname` (`user_nickname`),
  KEY `user_reg_time` (`user_reg_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user_index`
--

INSERT INTO `user_index` (`user_id`, `user`, `user_nickname`, `user_reg_time`) VALUES
(1, 'kakapowu@gmail.com', 'administrator', 1263486757);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
