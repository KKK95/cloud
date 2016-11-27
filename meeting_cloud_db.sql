-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-11-27 06:47:34
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
(10, 'a@', '教務會議', '2016-11-22 19:35:36.000000');

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_now`
--

CREATE TABLE `group_meeting_now` (
  `meeting_id` int(11) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `server_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `member_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `action` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_meeting_now`
--

INSERT INTO `group_meeting_now` (`meeting_id`, `member_id`, `server_id`, `member_ip`, `action`) VALUES
(4, 'b@', 'none', 'none', 'none');

-- --------------------------------------------------------

--
-- 資料表結構 `group_meeting_topics`
--

CREATE TABLE `group_meeting_topics` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `topic` varchar(2000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `group_meeting_topics`
--

INSERT INTO `group_meeting_topics` (`meeting_id`, `topic_id`, `topic`) VALUES
(4, 1, '有關各單位填報之「國立高雄大學內部控制制度作業項目一覽表（暫訂）」內容及相關事項'),
(4, 2, '有關本校內部控制制度目前執行進度與情形'),
(1, 1, '擬訂本校內部控制制度業務單位作業分工表（草案）。'),
(1, 2, '有關本校各單位內部控制制度建立之相關事項。'),
(1, 3, '有關辦理本校內部控制制度教育訓練研習相關事宜。'),
(4, 3, '有關本校內部控制制度目前執行進度與情形'),
(4, 4, '有關各單位填報之「國立高雄大學內部控制制度作業項目一覽表（暫訂）」內容及相關事項'),
(0, 1, '有關各單位填報之「國立高雄大學內部控制制度作業項目一覽表（暫訂）」內容及相關事項'),
(0, 2, '有關本校內部控制制度目前執行進度與情形'),
(0, 3, '有關各單位填報之「國立高雄大學內部控制制度作業項目一覽表（暫訂）」內容及相關事項'),
(3, 1, '為落實各系、所、學位學程、通識教育中心學生核心能力與課程之關係，並配合大學系所評鑑之要求，在經100年4月26日本校99學年度第2次教務會議討論通過同意試行下，本處業已商請圖書資訊館協助開發完成相關資訊系統。'),
(3, 2, '檢陳本校各學院分配教室排課規劃方案，敬請各院、系、所、學位學程、通識教育中心配合辦理。'),
(3, 3, '有關「國立高雄大學亞太工商管理學系課程委員會設置辦法」修正草案。'),
(3, 4, '有關「國立高雄大學人文社會科學院課程委員會設置辦法」修正草案。'),
(3, 5, '檢陳「國立高雄大學東亞語文學系修業規則」草案。'),
(3, 6, '檢陳「國立高雄大學法律學系碩士(專)班畢業論文審查及學位考試」修正草案。'),
(3, 7, '有關本校「微型教室管理要點」草案。'),
(3, 8, '檢陳「國立高雄大學資訊基本能力檢定實施要點」修正草案。'),
(3, 9, '檢陳本校優良學生學習成果獎勵補助標準草案。'),
(3, 10, '檢陳本校課程開課辦法條文說明表草案。'),
(3, 11, '檢陳本校學生選課要點修正條文對照表。'),
(3, 12, '檢陳本校學生抵免學分辦法修正條文對照表。'),
(3, 13, '修正本校學則第9條、第15條、第18條、第40條及第56條（詳如附件十八，P50~70）。'),
(2, 1, '有關本校「微型教室管理要點」草案（詳如附件十二，P35），提請討論。'),
(2, 2, '檢陳「國立高雄大學資訊基本能力檢定實施要點」修正草案(詳如附件十三，P36~37)，提請討論。'),
(2, 3, '檢陳本校優良學生學習成果獎勵補助標準草案(詳如附件十四，P38)，提請討論。'),
(2, 4, '檢陳本校課程開課辦法條文說明表草案（詳如附件十五，P39~41），提請討論。'),
(2, 5, '檢陳本校學生選課要點修正條文對照表（詳如附件十六，P42~45），提請討論。'),
(2, 6, '檢陳本校學生抵免學分辦法修正條文對照表（詳如附件十七，P46~49），提請討論。'),
(2, 7, '修正本校學則第9條、第15條、第18條、第40條及第56條（詳如附件十八，P50~70），提請討論。'),
(2, 8, '研修本校通識課程修習要點乙案(詳如附件十九，P71)，提請 討論。'),
(2, 9, '有關「國立高雄大學體育修課辦法」部分條文修正草案，提請　討論。');

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
(15, 10, 'b@'),
(16, 10, 'c@'),
(17, 10, 'd@');

-- --------------------------------------------------------

--
-- 資料表結構 `join_meeting_member`
--

CREATE TABLE `join_meeting_member` (
  `meeting_id` int(11) NOT NULL,
  `member_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `joined` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `join_meeting_member`
--

INSERT INTO `join_meeting_member` (`meeting_id`, `member_id`, `joined`) VALUES
(4, 'b@', 1),
(4, 'c@', 1),
(4, 'd@', 1),
(4, 'a@', 1),
(1, 'b@', 1),
(1, 'c@', 1),
(1, 'd@', 1),
(1, 'a@', 1),
(2, 'b@', 1),
(2, 'c@', 1),
(2, 'd@', 1),
(2, 'a@', 1),
(3, 'b@', 1),
(3, 'c@', 1),
(3, 'd@', 1),
(3, 'a@', 1);

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

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_minutes`
--

CREATE TABLE `meeting_minutes` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `meeting_minutes_id` int(11) NOT NULL,
  `meeting_minutes` varchar(1000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_minutes`
--

INSERT INTO `meeting_minutes` (`meeting_id`, `topic_id`, `meeting_minutes_id`, `meeting_minutes`) VALUES
(4, 1, 1, '請各單位針對重要性與風險性較高的業務，增加納入內控制度之作業項目，特別是與校務評鑑相關之業務請完整納入，交由秘書室彙整後續提下次會議審議。'),
(1, 1, 1, '授權各單位審視所屬業務之重要性與風險性，決定納入內部控制制度之業務項目，並交由秘書室進行彙整，續提下次會議討論。'),
(1, 2, 1, '各權責單位請於明（101）年4月中旬前研訂完成擇定之各項標準作業流程及控制重點，送秘書室彙整後續提下次會議討論。'),
(0, 0, 0, ''),
(1, 3, 1, '請人事室於明（101）年2月規劃辦理內部控制相關研習課程，講座人選可參考主計處網站內部控制專區之內控教師名單中遴選或自行遴選具備內部控制實務經驗之專家學者擔任。'),
(1, 3, 2, '各單位務請指派負責內部控制制度之承辦人員參加是項訓練研習，以利文件撰寫與後續推動。'),
(3, 1, 1, '准予備查。'),
(3, 2, 1, '准予備查。'),
(3, 3, 1, '准予備查。'),
(3, 4, 1, '准予備查。'),
(3, 5, 1, '准予備查。'),
(3, 6, 1, '准予備查。'),
(3, 7, 1, '本案照案通過。'),
(3, 7, 2, '建請編製教室使用須知及教室使用回饋問卷，俾利後續檢討與改善。'),
(3, 8, 1, '照案通過。'),
(3, 9, 1, '為符應本標準設立宗旨，請修正法規名稱為「國立高雄大學教務處獎勵補助優良學生學習成果標準」。'),
(3, 9, 2, '餘者照案通過。'),
(3, 10, 1, '原草案第二條條文之進階課程修正為博雅通識課程。'),
(3, 10, 2, '原草案第五條第五款第一目條文後面請再加註「惟若情況特殊，開課單位得經專案簽准後開設。」'),
(3, 10, 3, '餘者照案通過。'),
(3, 11, 1, '照案通過。'),
(3, 12, 1, '照案通過。'),
(3, 13, 1, '照案通過。'),
(2, 1, 1, '本案照案通過。'),
(2, 1, 2, '建請編製教室使用須知及教室使用回饋問卷，俾利後續檢討與改善。'),
(2, 2, 1, '照案通過。'),
(2, 3, 1, '為符應本標準設立宗旨，請修正法規名稱為「國立高雄大學教務處獎勵補助優良學生學習成果標準」。'),
(2, 3, 2, '餘者照案通過。'),
(2, 4, 1, '原草案第二條條文之進階課程修正為博雅通識課程。'),
(2, 4, 2, '原草案第五條第五款第一目條文後面請再加註「惟若情況特殊，開課單位得經專案簽准後開設。」'),
(2, 4, 3, '餘者照案通過。'),
(2, 5, 1, '照案通過。'),
(2, 6, 1, '照案通過。'),
(2, 7, 1, '照案通過。'),
(2, 8, 1, '照案通過。'),
(2, 9, 1, '照案通過。');

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
(4, 0, 1, '晚餐吃甚麼?', '', '2016-11-25 18:00:00'),
(4, 0, 2, '', '', '2016-11-25 11:06:41'),
(4, 1, 1, '明天吃甚麼?', '', '2016-11-25 19:00:00'),
(4, 0, 3, '明天吃甚麼?', '', '2016-11-25 16:47:16');

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
(1, 10, '2016-11-24 07:00:00'),
(2, 10, '2016-11-27 06:30:40'),
(3, 10, '2016-11-26 16:55:31'),
(4, 10, '2016-11-23 02:28:51');

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_scheduler`
--

CREATE TABLE `meeting_scheduler` (
  `meeting_id` int(11) NOT NULL,
  `group_id` int(4) NOT NULL,
  `title` varchar(40) COLLATE utf8_bin NOT NULL,
  `moderator_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `minutes_taker_id` varchar(4) COLLATE utf8_bin NOT NULL,
  `time` datetime NOT NULL,
  `over` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_scheduler`
--

INSERT INTO `meeting_scheduler` (`meeting_id`, `group_id`, `title`, `moderator_id`, `minutes_taker_id`, `time`, `over`) VALUES
(1, 10, '第一次教務會議', 'a@', 'b@', '2016-11-24 23:00:00', 1),
(2, 10, '第二次教務會議', 'a@', 'b@', '2016-11-25 00:00:00', 1),
(3, 10, '第三次教務會議', 'a@', 'b@', '2016-11-26 20:00:00', 1),
(4, 10, '第四次教務會議', 'a@', 'b@', '2016-12-10 00:00:00', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `meeting_topic_contents`
--

CREATE TABLE `meeting_topic_contents` (
  `meeting_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `content` varchar(2000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `meeting_topic_contents`
--

INSERT INTO `meeting_topic_contents` (`meeting_id`, `topic_id`, `content_id`, `content`) VALUES
(4, 1, 1, '依本校第1次內部控制專案小組會議決議，該一覽表之作業項目，係授權各單位審視所屬業務之重要性與風險性決定納入。'),
(4, 1, 2, '本校各單位擇定內控制度之作業項目，初步規劃如附件一，提請 討論。'),
(4, 1, 3, '另依「教育部中程施政計畫（102至105年度）共同性目標及指標」中，有關「落實政府內部控制機制」之指標，教育部將按年度要求各校填報增（修）訂內部控制作業項目之執行情形，故本校應配合於每年度增修之。'),
(4, 2, 1, '依據本校第1次內部控制專案小組會議決議，並為因應行政院之規定，需於今年年底前完成本校內部控制制度，各單位應研訂完成擇定之作業項目，續提本次會議討論。'),
(4, 2, 2, '有關教務業務目前執行進度與情形，請教務處說明（詳如附件二-1，pp 24~28）。'),
(1, 1, 1, '依據教育部100年3月23日台會（四）字第1000040629號函頒行政院訂定之「健全內部控制實施方案」，以及教育部100年9月19日台會（四）字第1000160248號函轉行政院內部控制推動及督導小'),
(1, 1, 2, '本案前經會計室、秘書室分別於100年3月24日及100年9月19日簽准有案，並於3月31日、 9月20日轉知本校各權責單位參考（如附件一-3、一-4），請各單位檢視是否適當並增修之。'),
(1, 2, 1, '依行政院健全內部控制實施方案規定，本校應參採各權責機關所訂之內部控制制度共通性作業範例，並審視個別性業務之重要性及風險性，訂定合宜之內部控制制度及內部稽核作業規定，並於完成後報送教育部備查。'),
(1, 2, 2, '有關報部備查之時程及內容細節，俟教育部另行研議後再通知辦理方式，惟已被行政院列為明年度之工作重點。為順利完成本校內部控制制度，請各單位開始逐步訂定建立。'),
(1, 2, 3, '檢附行政院100年7月4日院授主信字第1000004094號函訂定之「內部控制制度設計原則」乙份供參（如附件）。'),
(1, 3, 1, '依行政院健全內部控制實施方案及本校內部控制專案小組設置要點辦理。'),
(1, 3, 2, '另依行政院內部控制推動及督導小組第五次委員會會議紀錄決議，為落實辦理內部控制教育訓練，強化內部控制觀念，人事行政局於101年度後將各機關、學校辦理內部控制教育訓練情形納入「人事業務績效考核項目及評分標'),
(1, 3, 3, '為使各單位主管、同仁對內部控制議題瞭解與認識，擬請人事室協助辦理訓練研習，有關辦理時程、內容與授課講座人選。'),
(1, 3, 4, '檢附行政院100年5月27日院授主信字第1000003260號函訂定之「辦理內部控制宣導及教育訓練應注意事項」供參（如附件）。'),
(3, 1, 1, '依據100年4月26日本校99學年度第2次教務會議決議辦理。'),
(3, 1, 2, '相關作業系統分為教務處、系所學位學程通識教育中心、教師、學生等4個操作端'),
(3, 1, 3, '相關資料業已於100年11月17日以書面與電子郵件通知各學院、系、所、學位學程、通識教育中心在案。'),
(3, 2, 1, '本校五大學院大樓日前皆已建設完備，人文社會科學院預計於101年1月初搬遷完竣，基於教學大樓空間自主管理原則，本(100)學年度第2學期起擬由各學院依所屬教室安排課程，以利有效管理及運用教室。'),
(3, 2, 2, '有關教室分配原則、100學年度第2學期開課作業方式、101學年度起規劃開課作業方式請詳見附件一，P17~18。'),
(3, 3, 1, '本案業經亞太工商管理學系100年9月15日系務會議（詳附件三，P21）暨管理學院100年11月22日第十八次院務會議（詳附件四，P22~23）討論通過。'),
(3, 4, 1, '本案業經本院100年9月22日100學年度第1次院務會議（詳附件六，P27）討論通過。'),
(3, 5, 1, '本案業經東亞語文學系100年10月12日100學年度第1學期第2次系務會議（詳附件八，P29）暨本院100年11月17日100學年度第2次院務會議（詳附件九，P30）討論通過。'),
(3, 6, 1, '本案業經100年11月17日本院100學年度第一學期第一次院務會議(詳附件十一，P34)通過。'),
(3, 6, 2, '依法律系99學年度第2學期第2次系會議決議，刪減該系碩士(專)班之初稿審核程序，故修正該系碩士(專)班畢業論文審查學位考試辦法第四條第二項，原訂「經論文發表及系主任召集三人以上組成委員會之審查」，其程序擬刪除。'),
(3, 7, 1, '為協助教師精進教學技能、提升教學品質，特設置微型教室，並訂定本要點。'),
(3, 8, 1, '資訊基本能力檢定委員會題庫建置小組提議將考科名稱「智慧財產權」修改為「資訊素養與倫理」，因該考科考試內容為資訊倫理相關範疇議題，不適宜以「智慧財產權」做為考科名稱。爰此，擬將本考科名稱改為「資訊素養與倫理」。'),
(3, 8, 2, '本案業經100年4月22日題庫建置小組工作會議討論通過與100年6月21日99學年度第二學期資訊基本能力檢定委員會會議決議通過。'),
(3, 9, 1, '因應本校教務處統籌之各類計畫項下舉辦獎勵活動業務所需，特擬訂本標準，以此明訂活動適用範圍及獎勵金額上限，並規範往後相關業務執行之合理範圍。'),
(3, 9, 2, '本案經100學年度第2次本處處務會議通過，續提教務會議討論。'),
(3, 10, 1, '本校為強化各系、所、學位學程、通識教育中心等課程結構與內容，促進辦理開課相關作業，並落實學生學習成效，特訂定本辦法。'),
(3, 11, 1, '本次修正第十二點，將現行條文有關各種課程修課最低人數限制移至本校課程開課辦法中訂定。'),
(3, 12, 1, '本次計修正第一、五、六、八、九等5條條文，內容包含法源出處、各種學制抵免學分後提高編級之限制、抵免學分上限與交換學生抵免學分規定、各系、所、學位學程自訂之抵免學分辦法之法定程序、本辦法之法定程序等之新訂或修正。'),
(3, 13, 1, '依據教育部100年9月23日臺高（二）字第1000173506號函辦理；於本校學則第9條增訂通知其他大專校院及相關機關（構）之條款。'),
(3, 13, 2, '為放寬學業成績前20％學生能超修，特修訂本校學則第15條。'),
(3, 13, 3, '依據教育部函示修訂本校學則第15條；增訂海外中五學制畢(結)業生，以同等學力資格入學者，應增加其畢業學分數或延長其修業年限並明訂於招生簡章。'),
(3, 13, 4, '為因應學生參與公職考試或其他特殊因素，特修改於本校學則第40條及第50條條文。'),
(3, 13, 5, '修正通過後續提校務會議討論。'),
(2, 1, 1, '為協助教師精進教學技能、提升教學品質，特設置微型教室，並訂定本要點。'),
(2, 2, 1, '資訊基本能力檢定委員會題庫建置小組提議將考科名稱「智慧財產權」修改為「資訊素養與倫理」，因該考科考試內容為資訊倫理相關範疇議題，不適宜以「智慧財產權」做為考科名稱。爰此，擬將本考科名稱改為「資訊素養與倫理」。'),
(2, 2, 2, '本案業經100年4月22日題庫建置小組工作會議討論通過與100年6月21日99學年度第二學期資訊基本能力檢定委員會會議決議通過。'),
(2, 3, 1, '因應本校教務處統籌之各類計畫項下舉辦獎勵活動業務所需，特擬訂本標準，以此明訂活動適用範圍及獎勵金額上限，並規範往後相關業務執行之合理範圍。'),
(2, 3, 2, '本案經100學年度第2次本處處務會議通過，續提教務會議討論。'),
(2, 4, 1, '本校為強化各系、所、學位學程、通識教育中心等課程結構與內容，促進辦理開課相關作業，並落實學生學習成效，特訂定本辦法。'),
(2, 5, 1, '本次修正第十二點，將現行條文有關各種課程修課最低人數限制移至本校課程開課辦法中訂定。'),
(2, 6, 1, '本次計修正第一、五、六、八、九等5條條文，內容包含法源出處、各種學制抵免學分後提高編級之限制、抵免學分上限與交換學生抵免學分規定、各系、所、學位學程自訂之抵免學分辦法之法定程序、本辦法之法定程序等之新訂或修正。'),
(2, 7, 1, '依據教育部100年9月23日臺高（二）字第1000173506號函辦理；於本校學則第9條增訂通知其他大專校院及相關機關（構）之條款。'),
(2, 7, 2, '為放寬學業成績前20％學生能超修，特修訂本校學則第15條。'),
(2, 7, 3, '依據教育部函示修訂本校學則第15條；增訂海外中五學制畢(結)業生，以同等學力資格入學者，應增加其畢業學分數或延長其修業年限並明訂於招生簡章。'),
(2, 7, 4, '為因應學生參與公職考試或其他特殊因素，特修改於本校學則第40條及第50條條文。'),
(2, 7, 5, '修正通過後續提校務會議討論。'),
(2, 8, 1, '依據100年6月7日99學年度第2次校課程委員會指示辦理，修正本要點審議單位。'),
(2, 9, 1, '依據100年11月23日100學年度第1學期第4次通識中心會議續辦。'),
(2, 9, 2, '為符應本校體育教學現況，擬定「國立高雄大學體育修課辦法」修正草案，修正前後對照表（詳如附件二十，P72~77）。');

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
(4, 1, 1, '明天午餐吃甚麼?');

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
(4, 1, 1, 1, '拉面', 0),
(4, 1, 1, 2, '也竹', 0),
(4, 1, 1, 3, '大炒特炒', 0);

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
  MODIFY `group_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用資料表 AUTO_INCREMENT `group_member`
--
ALTER TABLE `group_member`
  MODIFY `water` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用資料表 AUTO_INCREMENT `meeting_scheduler`
--
ALTER TABLE `meeting_scheduler`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
