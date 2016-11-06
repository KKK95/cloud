-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-11-07 00:35:10
-- 伺服器版本: 10.1.8-MariaDB
-- PHP 版本： 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `meeting_cloud_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `group_chat_room`
--

CREATE TABLE `group_chat_room` (
  `water_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `send_time` datetime NOT NULL,
  `msg` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_chat_room`
--

INSERT INTO `group_chat_room` (`water_id`, `group_id`, `member_id`, `send_time`, `msg`) VALUES
(1, 2, 'emaa', '2016-09-09 01:00:00', 'hi~　我係emaa'),
(2, 2, 'emac', '2016-09-09 01:00:10', 'hi~　我係emac'),
(3, 2, 'emad', '2016-09-09 02:00:00', 'hi~　我係emad'),
(4, 2, 'emad', '2016-09-09 02:00:10', '你在幹嘛?'),
(5, 2, 'emaa', '2016-09-09 02:00:20', '我在吃飯'),
(6, 2, 'emac', '2016-09-09 02:00:30', '我在拉屎'),
(7, 2, 'emaa', '2016-09-11 17:19:47', '你一邊拉一邊吃?'),
(8, 2, 'emaa', '2016-09-11 17:28:18', '呵呵 笑你');

-- --------------------------------------------------------

--
-- 資料表結構 `group_leader`
--

CREATE TABLE `group_leader` (
  `group_id` int(4) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `group_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `date_time` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_leader`
--

INSERT INTO `group_leader` (`group_id`, `member_id`, `group_name`, `date_time`) VALUES
(1, 'emac', 'testing', '2016-10-01 05:23:32.000000'),
(2, 'emaa', 'emab', '2016-07-04 04:59:55.000000');

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_now`
--

CREATE TABLE `group_meeting_now` (
  `meeting_id` int(11) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `server_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `member_ip` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_topics`
--

CREATE TABLE `group_meeting_topics` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `topic` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_topics_disc`
--

CREATE TABLE `group_meeting_topics_disc` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `disc` varchar(1000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `group_member`
--

CREATE TABLE `group_member` (
  `water` int(8) NOT NULL,
  `group_id` int(4) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_member`
--

INSERT INTO `group_member` (`water`, `group_id`, `member_id`) VALUES
(1, 1, 'emaa'),
(4, 2, 'emac'),
(6, 2, 'emad');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_questions`
--

CREATE TABLE `meeting_questions` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question` varchar(100) COLLATE utf8_bin NOT NULL,
  `answer` varchar(100) COLLATE utf8_bin NOT NULL,
  `asking_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_record`
--

CREATE TABLE `meeting_record` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `meeting_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_scheduler`
--

CREATE TABLE `meeting_scheduler` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `title` varchar(40) COLLATE utf8_bin NOT NULL,
  `moderator_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_scheduler`
--

INSERT INTO `meeting_scheduler` (`meeting_id`, `group_id`, `title`, `moderator_id`, `time`) VALUES
(1, 1, '武林群英會', 'emaa', '2016-11-01 08:30:00'),
(2, 2, '全球氣候變化導致日本東京温度上升的影嚮', 'emac', '2016-11-02 13:00:00'),
(3, 1, '因少年得痔對於少年成長過程中所引發的問題', 'emac', '2016-11-03 10:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_vote`
--

CREATE TABLE `meeting_vote` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `issue` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_voting_options`
--

CREATE TABLE `meeting_voting_options` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `voting_option` varchar(50) COLLATE utf8_bin NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `id` varchar(8) COLLATE utf8_bin NOT NULL,
  `pw` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(12) COLLATE utf8_bin NOT NULL,
  `sex` varchar(1) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(12) COLLATE utf8_bin NOT NULL,
  `mail` varchar(40) COLLATE utf8_bin NOT NULL,
  `access` varchar(2) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `member`
--

INSERT INTO `member` (`id`, `pw`, `name`, `sex`, `telephone`, `mail`, `access`) VALUES
('emaa', '12', 'big loser', 'm', '', '', 'em'),
('emab', '1', 'one', 'f', '', '', 'em'),
('emac', '1', 'two', 'f', '', '', 'em'),
('emad', '1', 'three', 'm', '', '', 'em'),
('emae', '1', 'four', 'm', '', '', 'em'),
('lsaa', '12', 'machine', 'm', '', '', 'ls'),
('root', '1', 'root', 'm', '12345678', 'aaa@hotmail.com', 'rt');

-- --------------------------------------------------------

--
-- 資料表結構 `server_running_now`
--

CREATE TABLE `server_running_now` (
  `server_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `group_chat_room`
--
ALTER TABLE `group_chat_room`
  ADD PRIMARY KEY (`water_id`);

--
-- 資料表索引 `group_leader`
--
ALTER TABLE `group_leader`
  ADD PRIMARY KEY (`group_id`);

--
-- 資料表索引 `group_meeting_now`
--
ALTER TABLE `group_meeting_now`
  ADD PRIMARY KEY (`meeting_id`);

--
-- 資料表索引 `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`water`);

--
-- 資料表索引 `meeting_record`
--
ALTER TABLE `meeting_record`
  ADD PRIMARY KEY (`meeting_id`);

--
-- 資料表索引 `meeting_scheduler`
--
ALTER TABLE `meeting_scheduler`
  ADD PRIMARY KEY (`meeting_id`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `server_running_now`
--
ALTER TABLE `server_running_now`
  ADD PRIMARY KEY (`meeting_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `group_chat_room`
--
ALTER TABLE `group_chat_room`
  MODIFY `water_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `group_leader`
--
ALTER TABLE `group_leader`
  MODIFY `group_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `group_member`
--
ALTER TABLE `group_member`
  MODIFY `water` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用資料表 AUTO_INCREMENT `meeting_scheduler`
--
ALTER TABLE `meeting_scheduler`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
