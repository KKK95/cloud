-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-11-21 06:50:38
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
(2, 'emaa', 'emab', '2016-07-04 04:59:55.000000'),
(3, 'a@', 'a_group', '2016-11-01 07:00:00.000000'),
(4, 'b@', 'b_group', '2016-11-02 14:00:00.000000'),
(8, 'a@', 'hello world', '2016-11-13 10:07:50.000000'),
(9, 'a@', 'hello world2', '2016-11-14 05:06:32.000000');

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

--
-- 資料表的匯出資料 `group_meeting_now`
--

INSERT INTO `group_meeting_now` (`meeting_id`, `member_id`, `server_id`, `member_ip`) VALUES
(1, 'emaa', 'none', 'none'),
(4, 'a@', 'none', 'none'),
(4, 'b@', 'none', 'none');

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_topics`
--

CREATE TABLE `group_meeting_topics` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `topic` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_meeting_topics`
--

INSERT INTO `group_meeting_topics` (`meeting_id`, `topic_id`, `topic`) VALUES
(4, 2, '全盛時期的林大神 的肚子到底可以裝多少東西?'),
(7, 1, '林韋丞肚子的彈性系數有多大?'),
(7, 2, '林韋丞肚子還可以變多大?'),
(4, 1, '全盛時期的林大神到底一次可以吃多少碗沙茶拌飯?'),
(4, 3, '今晚吃甚麼?'),
(12, 1, '會議議題該寫甚麼才讓人認為這是有意義的議題呢?'),
(4, 4, 'hihihi');

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
(2, 3, 'b@'),
(3, 3, 'c@'),
(4, 2, 'emac'),
(5, 3, 'd@'),
(6, 2, 'emad'),
(7, 4, 'c@'),
(8, 4, 'a@'),
(9, 8, 'b@'),
(10, 8, 'c@'),
(12, 3, 'emaa'),
(13, 9, 'emaa'),
(14, 9, 'd@');

-- --------------------------------------------------------

--
-- 資料表結構 `join_meeting_member`
--

CREATE TABLE `join_meeting_member` (
  `meeting_id` int(11) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `join_meeting_member`
--

INSERT INTO `join_meeting_member` (`meeting_id`, `member_id`) VALUES
(4, 'a@'),
(4, 'b@'),
(4, 'c@'),
(4, 'd@'),
(16, 'b@'),
(16, 'c@'),
(16, 'd@'),
(17, 'emaa'),
(17, 'd@'),
(5, 'a@'),
(7, 'a@'),
(8, 'a@'),
(16, 'a@');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_member_vote`
--

CREATE TABLE `meeting_member_vote` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_member_vote`
--

INSERT INTO `meeting_member_vote` (`meeting_id`, `topic_id`, `issue_id`, `option_id`, `member_id`) VALUES
(4, 1, 1, 1, 'a@');

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

--
-- 資料表的匯出資料 `meeting_questions`
--

INSERT INTO `meeting_questions` (`meeting_id`, `topic_id`, `question_id`, `question`, `answer`, `asking_time`) VALUES
(7, 0, 1, '今天中午該吃甚麼好呢?', '吃草吧~', '2016-11-01 02:00:00'),
(7, 1, 2, '今天能回家睡覺嗎?', '準備看日出吧，呵呵~', '2016-11-01 02:05:00'),
(4, 0, 1, '今天可以讓老師不啪啪我們嗎?', '', '2016-11-30 16:00:00'),
(4, 2, 1, '已經掰不出問題了嗎?', '對啊', '2016-11-30 17:00:00'),
(4, 2, 2, '大神出產 UI 的平均速度', '1 筆/day', '2016-11-18 11:41:24');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_record`
--

CREATE TABLE `meeting_record` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `meeting_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_record`
--

INSERT INTO `meeting_record` (`meeting_id`, `group_id`, `meeting_time`) VALUES
(1, 1, '2016-11-07 01:19:57'),
(4, 3, '2016-11-15 17:43:24'),
(7, 3, '2016-11-01 01:00:00'),
(8, 3, '2016-11-02 15:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_scheduler`
--

CREATE TABLE `meeting_scheduler` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `title` varchar(40) COLLATE utf8_bin NOT NULL,
  `moderator_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `time` datetime NOT NULL,
  `over` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_scheduler`
--

INSERT INTO `meeting_scheduler` (`meeting_id`, `group_id`, `title`, `moderator_id`, `time`, `over`) VALUES
(1, 1, '武林群英會', 'emaa', '2016-11-07 08:30:00', 1),
(2, 2, '全球氣候變化導致日本東京温度上升的影嚮', 'emac', '2016-11-02 13:00:00', 1),
(3, 1, '因少年得痔對於少年成長過程中所引發的問題', 'emac', '2016-11-03 10:00:00', 1),
(4, 3, 'testing_by_android', 'a@', '2016-11-30 09:00:00', 0),
(5, 3, 'testing_by_android2', 'a@', '2016-11-30 10:00:00', 0),
(6, 4, 'group_b_testing_by_android', 'b@', '2016-11-30 11:00:00', 0),
(7, 3, '測試用會議記錄', 'a@', '2016-11-01 00:00:00', 1),
(8, 3, '測試用會議記錄2', 'a@', '2016-11-02 00:00:00', 1),
(16, 3, 'test set meeting', 'a@', '2016-12-01 00:00:00', 0),
(17, 9, 'test', 'a@', '2016-12-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_topics_contents`
--

CREATE TABLE `meeting_topics_contents` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `content` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

--
-- 資料表的匯出資料 `meeting_vote`
--

INSERT INTO `meeting_vote` (`meeting_id`, `topic_id`, `issue_id`, `issue`) VALUES
(4, 0, 1, '你喜歡吃甚麼?'),
(4, 1, 1, '你的興趣是甚麼?'),
(4, 1, 2, '你喜歡吃甚麼?');

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

--
-- 資料表的匯出資料 `meeting_voting_options`
--

INSERT INTO `meeting_voting_options` (`meeting_id`, `topic_id`, `issue_id`, `option_id`, `voting_option`, `votes`) VALUES
(4, 0, 1, 1, '鼻屎', 2),
(4, 0, 1, 2, '土', 10),
(4, 1, 1, 1, '跟大神聊天', 1),
(4, 1, 1, 2, '跟大神吃飯', 0),
(4, 1, 1, 3, '和大神一起上課', 0),
(4, 1, 1, 4, 'hihi', 0),
(4, 1, 1, 5, 'fu', 0),
(4, 1, 2, 1, '薯條', 0);

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
('a@', '', 'apple', '', '', '', 'em'),
('b@', '', 'boy', '', '', '', 'em'),
('c@', '', 'cat', '', '', '', 'em'),
('d@', '', 'dog', '', '', '', 'em'),
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
  MODIFY `group_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `group_member`
--
ALTER TABLE `group_member`
  MODIFY `water` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用資料表 AUTO_INCREMENT `meeting_scheduler`
--
ALTER TABLE `meeting_scheduler`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
