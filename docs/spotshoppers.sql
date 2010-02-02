-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 02 月 02 日 18:08
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
  `a_sdate` date NOT NULL COMMENT '开始时间',
  `a_edate` date NOT NULL COMMENT '结束时间',
  `c_id` int(11) NOT NULL,
  `a_recommend` tinyint(1) NOT NULL,
  `a_order` mediumint(9) NOT NULL,
  `cs_id` int(11) NOT NULL,
  `a_cost` float(5,2) NOT NULL COMMENT '消费金额',
  `a_fdate` datetime NOT NULL COMMENT '任务完成时间',
  `a_hasphoto` tinyint(1) NOT NULL COMMENT '必须上传图片',
  `a_hasaudio` tinyint(1) NOT NULL COMMENT '必须上传音频',
  `a_finish` float NOT NULL COMMENT '完成度',
  PRIMARY KEY (`a_id`),
  KEY `c_id` (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `assignment`
--

INSERT INTO `assignment` (`a_id`, `a_title`, `a_desc`, `a_sdate`, `a_edate`, `c_id`, `a_recommend`, `a_order`, `cs_id`, `a_cost`, `a_fdate`, `a_hasphoto`, `a_hasaudio`, `a_finish`) VALUES
(1, '缘来是你的', '大法师的', '2010-02-13', '2010-02-26', 5, 0, 0, 1, 0.00, '0000-00-00 00:00:00', 1, 1, 0),
(3, '如果这就是爱情', '', '2010-02-01', '2010-02-10', 6, 0, 0, 4, 0.00, '0000-00-00 00:00:00', 1, 1, 0),
(4, '就来抢', '', '2010-02-02', '2010-02-17', 5, 0, 0, 5, 0.00, '0000-00-00 00:00:00', 0, 0, 0);

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
  `c_name` varchar(18) NOT NULL,
  `c_initial` char(1) NOT NULL,
  `c_intro` text NOT NULL,
  `c_password` char(32) NOT NULL,
  `c_title` varchar(100) NOT NULL,
  `c_contacter` varchar(30) NOT NULL,
  `c_phone` varchar(50) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `corporation`
--

INSERT INTO `corporation` (`c_id`, `c_name`, `c_initial`, `c_intro`, `c_password`, `c_title`, `c_contacter`, `c_phone`) VALUES
(5, 'gmail', 'G', '来他家吃过两次了，冲着酸汤鱼来的。环境还不错，适合聚餐。\n他家的酸汤鱼，鱼嫩，汤美。我很喜欢，本人比较喜欢吃酸的。\n干锅鸡，忘了吃的哪两种了，味道不错的。第二次来正好是拿点评优惠券来的，很实惠。\n酸菜鱼，油很多。味道一般。\n点击率很高的土豆泥，个人觉得一般，没大家说的那么好，也挺油的，还算香。\n凉菜一个什么木耳，蕨根粉，都还可以，口味适中。\n新出的酸汤饭，量不小，口味一般，还是觉得酸汤鱼里的酸汤味道比较好。\n饮料喝过几种，但都记不住名和味道，也就没什么可推荐的了。\n总体说来，喜欢酸汤鱼和干锅的朋友可以来试一下。服务时好时坏，看赶上什么服务员了。后来这次服务还不错，经常帮我们炒干锅。吃完还可以免费办点评贵宾卡，我有了，朋友又办了一张。', '96e79218965eb72c92a549dd5a330112', '干锅居餐饮有限公司', '吴先生', '13774424728'),
(6, 'kfc', 'K', '沙龙封杀封杀了房间搜', 'f86317e23e3fc3b01e863b83eb06db47', '肯德基餐饮有限公司', '陈先生', '12321321321321');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `forget_pwd`
--

INSERT INTO `forget_pwd` (`id`, `user`, `code`, `start_ts`, `state`) VALUES
(1, 'kakapowu@gmail.com', 'd7b010952b4c9fdbed7d284cbb9651c3', 1264829265, 1);

-- --------------------------------------------------------

--
-- 表的结构 `msg_box`
--

CREATE TABLE IF NOT EXISTS `msg_box` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_date` datetime NOT NULL,
  `m_title` varchar(120) NOT NULL,
  `m_content` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `msg_box`
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
('nl3j26aepj79tfvq09edjbvs74', 'kakapowu@gmail.com', 1265129520, '{"user_id":"1","user":"kakapowu@gmail.com","user_password":"78fb66bee250b7ea217610ba762aff18","user_email":"kakapowu@gmail.com","user_nickname":"administrator","user_sex":"1","user_state":"1","user_reg_time":"1263486757","user_reg_ip":"127.0.0.1","user_lastlogin_time":"1265032460","user_lastlogin_ip":"127.0.0.1","user_question":"","user_answer":"","autologin":"0","ticket":"nl3j26aepj79tfvq09edjbvs74"}');

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
  `cs_abbr` char(6) NOT NULL,
  `cs_address` varchar(255) NOT NULL,
  `cs_name` varchar(255) NOT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `c_id` (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `store`
--

INSERT INTO `store` (`cs_id`, `cs_abbr`, `cs_address`, `cs_name`, `c_id`) VALUES
(1, 'ZDGC', '浦东世纪大道234号', '正大广场店', 5),
(3, '', '老闵行路wew', '南方商城店', 6),
(4, '', '昌里路234', '浦东商城昌里店', 6),
(5, 'RMGC', '首都师大', '人民广场店', 5);

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
(1, 'kakapowu@gmail.com', '78fb66bee250b7ea217610ba762aff18', 'kakapowu@gmail.com', 'administrator', 1, 1, 1263486757, '127.0.0.1', 1265128080, '127.0.0.1', '', '');

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
  `a_num` smallint(6) NOT NULL COMMENT '任务数量',
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
