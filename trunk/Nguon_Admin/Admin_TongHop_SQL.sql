-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 09, 2014 at 10:35 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smartshop2`
--
CREATE DATABASE IF NOT EXISTS `smartshop2` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `smartshop2`;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`) VALUES
(35, 38, 'Menu 2.1', '', '', 1, 4),
(36, 35, 'Menu 2.1.1', '', '', 1, 4),
(37, 36, 'Menu 2.1.2', '', '', 1, 4),
(38, 31, 'Menu 2.2', '', '', 2, 4),
(34, 32, 'Menu 2', '', '', 2, 4),
(33, 32, 'Menu 1.2', '', '', 1, 4),
(32, 31, 'Menu 1.1', '', '', 1, 4),
(51, 49, 'Nguyễn Tuấn Anh', 'Nguyễn', 'Tuấn Anh', 1, 4),
(49, 36, 'gsdf', 's dfsdf ', 'sd fsdf sd', 2, 4),
(31, 0, 'Menu 1', '', '', 2, 4),
(1, 53, 'Home', '/cvxcv', 'xcvxcv', 1, 1),
(50, 0, 'sd fsdf', 's dfsdf ', 's dfsdf sdf', 1, 11),
(53, 0, 'fghfghf', 'saab', 'current', 1, 1),
(54, 51, 'sdfs', 'saab', 'sdfsdf', 1, 4),
(56, 0, 'ghjkl;''', 'cfhjklkhhgjk', '', 3, 4),
(57, 0, 'hjkl;''', 'vhbnkm,l', 'fghjkl', 4, 4),
(58, 0, 'Trang chủ', 'http://dantri.com.vn', '', 1, 4),
(61, 1, '2332', 'http://localhost/SmartShop/', '23', 1, 1),
(63, 0, 'erterter', 'http://localhost/SmartShop/', 'ertert', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `menu_group`
--

DROP TABLE IF EXISTS `menu_group`;
CREATE TABLE IF NOT EXISTS `menu_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `menu_group`
--

INSERT INTO `menu_group` (`id`, `title`) VALUES
(1, 'Menu chính'),
(4, 'gdf'),
(11, 'dfgdfgdfg'),
(8, 'Foorter'),
(9, 'Trang con');

-- --------------------------------------------------------

--
-- Table structure for table `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_reminders`
--

INSERT INTO `password_reminders` (`email`, `token`, `created_at`) VALUES
('anhntseo@gmail.com', '97b8361e2fb030bf9e54469407c72aa3b90dc569', '2014-05-21 09:48:19'),
('anhntseo@gmail.com', '66b4798d3f6d525096cc7e13c7f9e82b2d748697', '2014-05-21 09:49:46'),
('anhntseo@gmail.com', '0840f4e4fc7667be20e0766a9ed837275d55c1f8', '2014-05-21 09:50:53'),
('anhntseo@gmail.com', 'b0d2036669b4eeb4a10b3f95eb1981055090f1fd', '2014-05-21 09:59:00'),
('anhntseo@gmail.com', '107a2e679065e67fc8a45708db551db1fdc15de9', '2014-05-21 10:00:06'),
('anhntseo@gmail.com', '0bbced357f35d907e05d85faf9dcd97dc00a2d09', '2014-05-21 10:27:14'),
('anhntseo@gmail.com', '2861cf479cf5285b7c7d8190f8b08bf1678784a9', '2014-05-21 10:33:25'),
('anhntseo@gmail.com', '74be4220c243ecbbfe77801e1176a93d5a77c54a', '2014-05-22 01:08:09'),
('anhntseo@gmail.com', '512c1aa7c29e72fd7919a85ec43a7fe17ed63727', '2014-05-22 01:31:36'),
('anhntseo@gmail.com', '12fb6e819e8917d5536f8001985de55c991cb23a', '2014-05-22 01:32:08'),
('anhntseo@gmail.com', 'ede037147d4d9061890e200f8f4de197de469472', '2014-05-22 01:38:05'),
('anhntseo@gmail.com', '59804f2c9c3d48ecc1691867f7a72c6d028d1e8d', '2014-05-22 01:38:19'),
('anhntseo@gmail.com', '96fa820bb6eda597c999a3716862a9273b428222', '2014-05-22 01:38:46'),
('anhntseo@gmail.com', 'efa20a06d5b9953ed9a2c21bf93df8f081127579', '2014-05-22 01:39:52'),
('pubweb.vn@gmail.com', 'd442cd07dd7ee5c8a05bc74868c28de7c4e7b9ea', '2014-07-08 10:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_roles`
--

DROP TABLE IF EXISTS `tbl_admin_roles`;
CREATE TABLE IF NOT EXISTS `tbl_admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rolesCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rolesDescription` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_admin_roles`
--

INSERT INTO `tbl_admin_roles` (`id`, `rolesCode`, `rolesDescription`, `time`, `status`) VALUES
(1, 'NewsController', 'Quản lý tin tức', 1396656000, 1),
(2, 'AdminController', 'Quản lý admin', 1396656000, 1),
(3, 'ProductController', 'Quản lý sản phẩm', 1396656000, 1),
(4, 'OrderController', 'Quản lý đơn hàng', 1396656000, 1),
(6, 'SupporterController', 'Quản lý hỗ trợ viên', 1396656000, 1),
(7, 'UserController', 'Quản lý khách hàng', 1396656000, 1),
(8, 'PageController', 'Quản lý các trang', 1396656000, 1),
(9, 'SettingController', 'Quản lý cấu hình', 1396656000, 1),
(10, 'MenusController', 'Quản lý menu', 1396656000, 1),
(11, 'ProjectController', 'Quản lý dự án', 1396656000, 1),
(12, 'HistoryUserController', 'Quản lý lịch sử', 1396656000, 1),
(13, 'FeedbackController', 'Quản lý phản hồi', 1396656000, 1),
(15, 'StatisticView', 'Xem thống kê', 213123123123123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attachment`
--

DROP TABLE IF EXISTS `tbl_attachment`;
CREATE TABLE IF NOT EXISTS `tbl_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `destinyID` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `attachmentName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachmentURL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed_back`
--

DROP TABLE IF EXISTS `tbl_feed_back`;
CREATE TABLE IF NOT EXISTS `tbl_feed_back` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feedbackUserEmail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feedbackUserName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feedbackSubject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feedbackContent` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_feed_back`
--

INSERT INTO `tbl_feed_back` (`id`, `feedbackUserEmail`, `feedbackUserName`, `feedbackSubject`, `feedbackContent`, `time`, `status`) VALUES
(2, 'ngoquanghuyhn@gmail.com', 'Quanghuy', 'chan qua', 'chán quá', 131231231231, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

DROP TABLE IF EXISTS `tbl_menus`;
CREATE TABLE IF NOT EXISTS `tbl_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menuURL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menuParent` int(11) DEFAULT NULL,
  `menuPosition` int(11) DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

DROP TABLE IF EXISTS `tbl_news`;
CREATE TABLE IF NOT EXISTS `tbl_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newsName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newsImg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newsDescription` longtext COLLATE utf8_unicode_ci,
  `newsKeywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newsContent` longtext COLLATE utf8_unicode_ci,
  `newsTag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `newsSlug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adminID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsSlug` (`newsSlug`),
  UNIQUE KEY `newsSlug_2` (`newsSlug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`id`, `newsName`, `newsImg`, `newsDescription`, `newsKeywords`, `newsContent`, `newsTag`, `newsSlug`, `adminID`, `time`, `status`) VALUES
(28, 'Trung Quốc phát hành bản đồ nuốt trọn Biển Đông', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/ban-do1-1443-1403692157.jpg', 'Trung Quốc vừa phát hành một bản đồ mới trong đó ngang nhiên tuyên bố chủ quyền phi pháp với hầu hết Biển Đông, bao gồm cả các quần đảo và vùng biển của Việt Nam. ', 'Trung quốc,bản đồ,lưỡi bò,biển đông', '<p><em>T&acirc;n Hoa X&atilde;</em>&nbsp;đưa tin bản đồ tr&ecirc;n được vẽ&nbsp;theo chiều dọc,&nbsp;do Nh&agrave; xuất bản Bản đồ tỉnh Hồ Nam ph&aacute;t h&agrave;nh.&nbsp;</p>\r\n\r\n<p>Bản đồ mới cho thấy r&otilde; ngo&agrave;i&nbsp;phần lục địa của Trung Quốc, phạm vi m&agrave; nước n&agrave;y gọi l&agrave; &quot;chủ quyền&quot; của m&igrave;nh c&ograve;n mở rộng ra khắp Biển Đ&ocirc;ng, k&eacute;o d&agrave;i đến tận bờ biển của Malaysia v&agrave; Philippines theo h&igrave;nh lưỡi b&ograve;, &ocirc;m trọn cả hai quần đảo Ho&agrave;ng Sa v&agrave; Trường Sa của Việt Nam.&nbsp;V&ugrave;ng biển v&agrave; c&aacute;c đảo tr&ecirc;n Biển Đ&ocirc;ng được vẽ với tỷ lệ tương đương phần đất liền, kh&aacute;c với bản đồ truyền thống l&acirc;u nay của Trung Quốc.</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:350px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="ban-do1-1443-1403692157.jpg" src="http://m.f29.img.vnecdn.net/2014/06/25/ban-do1-1443-1403692157.jpg" style="margin:0px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Bản đồ dọc với tuy&ecirc;n bố&nbsp;&quot;đường lưỡi b&ograve;&quot; phi ph&aacute;p m&agrave; Trung Quốc vừa ph&aacute;t h&agrave;nh. Ảnh:&nbsp;<em>Xinhua</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Trong c&aacute;c bản đồ trước đ&acirc;y, ch&iacute;nh quyền Trung Quốc cũng trắng trợn tuy&ecirc;n bố chủ quyền với trọn Biển Đ&ocirc;ng nhưng chỉ đưa c&aacute;c đảo v&agrave;o một &ocirc; vu&ocirc;ng nhỏ ở g&oacute;c ph&iacute;a dưới.&nbsp;</p>\r\n\r\n<p><em>Nh&acirc;n d&acirc;n Nhật b&aacute;o</em>&nbsp;biện bạch rằng c&aacute;ch vẽ mới sẽ gi&uacute;p người d&acirc;n &quot;đọc được đầy đủ v&agrave; trực tiếp to&agrave;n bộ bản đồ của Trung Quốc&quot;, trong khi nh&agrave; xuất bản th&igrave; mạnh miệng rằng bản đồ dọc &quot;mang &yacute; nghĩa th&uacute;c đẩy hiểu biết của người d&acirc;n&quot;.</p>\r\n\r\n<p>&quot;Đường lưỡi b&ograve;&quot; hay đường 9 đoạn l&agrave; kh&aacute;i niệm được Trung Quốc đưa ra nhằm khẳng định tuy&ecirc;n bố chủ quyền với hầu hết Biển Đ&ocirc;ng. Y&ecirc;u s&aacute;ch n&agrave;y của Trung Quốc bị c&aacute;c nước c&oacute; li&ecirc;n quan, trong đ&oacute; c&oacute; Việt Nam v&agrave; Philippines, cực lực phản đối.</p>\r\n\r\n<p>Việt Nam khẳng định &quot;đường lưỡi b&ograve;&quot; của Trung Quốc vi phạm chủ quyền của Việt Nam đối với hai quần đảo Ho&agrave;ng Sa v&agrave; Trường Sa, cũng như chủ quyền, quyền chủ quyền v&agrave; quyền t&agrave;i ph&aacute;n của Việt Nam đối với c&aacute;c v&ugrave;ng biển li&ecirc;n quan ở Biển Đ&ocirc;ng.</p>\r\n\r\n<p>Những h&agrave;nh động r&aacute;o riết của Trung Quốc gần đ&acirc;y nhằm hiện thực h&oacute;a y&ecirc;u s&aacute;ch tr&ecirc;n, trong đ&oacute; việc hạ đặt tr&aacute;i ph&eacute;p gi&agrave;n khoan Hải Dương 981 s&acirc;u trong thềm lục địa v&agrave; v&ugrave;ng đặc quyền kinh tế của Việt Nam, vấp phải sự ph&ecirc; ph&aacute;n mạnh mẽ của dư luận thế giới.</p>\r\n\r\n<p>Trong hội thảo quốc tế với chủ đề &ldquo;Ho&agrave;ng Sa - Trường Sa: Sự thật lịch sử&rdquo; vừa diễn ra tại th&agrave;nh phố Đ&agrave; Nẵng, c&aacute;c học giả trong v&agrave; ngo&agrave;i nước nhất tr&iacute; rằng y&ecirc;u s&aacute;ch &quot;đường lưỡi b&ograve;&quot; của Bắc Kinh l&agrave; kh&ocirc;ng c&oacute; cơ sở ph&aacute;p l&yacute;, lịch sử v&agrave; v&ocirc; gi&aacute; trị.</p>\r\n', 'Trung quốc,bản đồ,biển đông', 'trung-quoc-phat-hanh-ban-do-nuot-tron-bien-dong', '24', 1403715947, 1),
(29, 'Thủ tướng Singapore: Lẽ phải không thuộc về kẻ mạnh ở Biển Đông', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/ly-hien-long-4086-1403662263.jpg', 'Thủ tướng Singapore hôm qua cho rằng luật pháp quốc tế cần được dùng để quyết định cách giải quyết tranh chấp ở Biển Đông, thay vì tư tưởng "lẽ phải thuộc về kẻ mạnh". ', 'Lưỡi bò,biển đông,kẻ mạnh,trung quốc,singapore,lý hiển long', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="ly-hien-long-4086-1403662263.jpg" src="http://m.f29.img.vnecdn.net/2014/06/25/ly-hien-long-4086-1403662263.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Thủ tướng Singapore L&yacute; Hiển Long. Ảnh:&nbsp;<em>Todayonline</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&quot;Với quan điểm của một quốc gia phải tồn tại trong hệ thống quốc tế, nơi c&oacute; những nước nhỏ v&agrave; nước lớn, kết quả kh&ocirc;ng thể được quyết định chỉ bằng tư tưởng lẽ phải thuộc về kẻ mạnh&quot;, &ocirc;ng L&yacute; h&ocirc;m qua n&oacute;i tại Hội đồng Quan hệ Đối ngoại, trong chuyến thăm Washington, Mỹ.&nbsp;</p>\r\n\r\n<p>&quot;T&ocirc;i nghĩ luật quốc tế phải c&oacute; trọng lượng lớn trong việc giải quyết tranh chấp&quot;,&nbsp;<em>AP&nbsp;</em>dẫn lời &ocirc;ng Lee n&oacute;i th&ecirc;m v&agrave; khen ngợi Mỹ nh&igrave;n chung tu&acirc;n theo những nguy&ecirc;n tắc n&agrave;y. Thủ tướng Singapore trả lời c&acirc;u hỏi về y&ecirc;u s&aacute;ch chủ quyền của Trung Quốc tại những v&ugrave;ng biển nhiều t&agrave;i nguy&ecirc;n, điều đang khiến c&aacute;c nước l&aacute;ng giềng giận dữ.</p>\r\n\r\n<p>Singapore kh&ocirc;ng phải quốc gia c&oacute; tuy&ecirc;n bố chủ quyền ở Biển Đ&ocirc;ng, nhưng nước n&agrave;y ủng hộ nỗ lực của Hiệp hội c&aacute;c Quốc gia Đ&ocirc;ng Nam &Aacute; (ASEAN) trong việc đ&agrave;m ph&aacute;n với Trung Quốc về một bộ quy tắc ứng xử nhằm xử l&yacute; v&agrave; giải quyết tranh chấp l&atilde;nh thổ. Quốc đảo n&agrave;y cũng c&acirc;n bằng giữa quan hệ chặt chẽ với Washington v&agrave; quan hệ nồng ấm với Bắc Kinh.&nbsp;</p>\r\n\r\n<p>Mỹ th&igrave; chỉ tr&iacute;ch c&aacute;c h&agrave;nh động khi&ecirc;u kh&iacute;ch của Trung Quốc khi khẳng định y&ecirc;u s&aacute;ch chủ quyền, m&agrave; gần đ&acirc;y nhất l&agrave; việc hạ đặt gi&agrave;n khoan tại v&ugrave;ng biển thuộc thềm lục địa v&agrave; v&ugrave;ng đặc quyền kinh tế của Việt Nam. Trung Quốc cũng từng c&oacute; những cuộc đối đầu tr&ecirc;n biển với Philippines, một đồng minh của Mỹ.&nbsp;</p>\r\n</div>\r\n', 'Lý hiển long,Trung quốc,lưỡi bò,biển đông,kẻ mạnh', 'thu-tuong-singapore-le-phai-khong-thuoc-ve-ke-manh-o-bien-dong', '24', 1403716067, 1),
(30, 'Thủ tướng Singapore lo nguy cơ chiến tranh ở châu Á', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/lhl-8668-1400818880.jpg', 'Thủ tướng Singapore Lý Hiển Long cho rằng châu Á có nguy cơ xảy ra chiến tranh nếu những căng thẳng trong khu vực không được giải quyết một cách có trách nhiệm.', 'Lý hiển long,singapore,trung quốc,nguy cơ,chiến tranh,châu á', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="lhl-8668-1400818880.jpg" src="http://m.f29.img.vnecdn.net/2014/05/23/lhl-8668-1400818880.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Thủ tướng Singapore L&yacute; Hiển Long tại hội nghị Tương lai ch&acirc;u &Aacute;. Ảnh:&nbsp;<em>Straitstimes</em></p>\r\n\r\n			<div>&nbsp;</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'Lý hiển long,singapore,trung quốc,nguy cơ,chiến tranh,châu á', 'thu-tuong-singapore-lo-nguy-co-chien-tranh-o-chau-a', '24', 1403716164, 1),
(31, 'Triều Tiên cảnh báo Mỹ về bộ phim chế giễu lãnh tụ', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/kim-7905-1403709015.png', 'Triều Tiên hôm nay lên án bộ phim hài của Mỹ, dựa trên cốt truyện ám sát nhà lãnh đạo Kim Jong-un, là một hành động khủng bố và đe dọa sẽ có biện pháp phản đối thích đáng nếu Washington không cấm phát hành bộ phim ngay lập tức.', 'Mỹ,triều tiên,Kim jong un,Phim hài,cảnh báo', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="kim-7905-1403709015.png" src="http://m.f29.img.vnecdn.net/2014/06/25/kim-7905-1403709015.png" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Tạo h&igrave;nh l&atilde;nh tụ Triều Ti&ecirc;n Kim Jong Un trong phim. Ảnh:&nbsp;<em>Reuters</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Bộ phim h&agrave;i mang ti&ecirc;u đề &quot;Cuộc phỏng vấn&quot; của h&atilde;ng Columbia Pictures, với sự tham gia của hai ng&ocirc;i sao James Franco v&agrave; Seth Rogen, dự kiến ph&aacute;t h&agrave;nh v&agrave;o th&aacute;ng 10 tới, theo&nbsp;<em>Reuters</em>.</p>\r\n\r\n<p>&quot;Sản xuất v&agrave; ph&aacute;t h&agrave;nh một bộ phim với &acirc;m mưu l&agrave;m tổn hại l&atilde;nh đạo cấp cao nhất của ch&uacute;ng t&ocirc;i l&agrave; một h&agrave;nh động khủng bố v&agrave; g&acirc;y hấn r&agrave;nh r&agrave;nh v&agrave; chắc chắn kh&ocirc;ng được dung thứ&quot;, h&atilde;ng tin ch&iacute;nh thức&nbsp;<em>KCNA</em>&nbsp;của Triều Ti&ecirc;n dẫn lời người ph&aacute;t ng&ocirc;n Bộ Ngoại giao nước n&agrave;y n&oacute;i.</p>\r\n\r\n<p>Bộ phim của Hollywood kể về một người dẫn chương tr&igrave;nh truyền h&igrave;nh (do James Franco thủ vai&nbsp;) v&agrave; nh&agrave; sản xuất (Seth Rogen) được&nbsp;Cơ quan T&igrave;nh b&aacute;o Mỹ (CIA) tuyển mộ với nhiệm vụ &aacute;m s&aacute;t Kim Jong-un.&nbsp;Hai người đến Triều Ti&ecirc;n để thực hiện cuộc phỏng vấn độc quyền với &ocirc;ng Kim, người lu&ocirc;n đe dọa ph&oacute;ng t&ecirc;n lửa hạt nh&acirc;n v&agrave;o Washington.</p>\r\n\r\n<p>Ph&aacute;t ng&ocirc;n vi&ecirc;n bộ Ngoại giao Triều Ti&ecirc;n cho biết người d&acirc;n nước n&agrave;y coi cuộc sống của vị l&atilde;nh tụ qu&yacute; gi&aacute; hơn cả cuộc sống của ch&iacute;nh họ. Nếu ch&iacute;nh quyền Mỹ ngầm th&ocirc;ng qua hoặc ủng hộ ph&aacute;t h&agrave;nh bộ phim, Triều Ti&ecirc;n sẽ c&oacute; biện ph&aacute;p trả đũa ki&ecirc;n quyết v&agrave; th&iacute;ch đ&aacute;ng.</p>\r\n\r\n<p>H&ocirc;m 23/6, Triều Ti&ecirc;n cũng đe dọa&nbsp;sẽ &quot;trừng phạt&quot; Ngoại trưởng Australia Julie Bishop do b&agrave;&nbsp;chỉ tr&iacute;ch nh&agrave; l&atilde;nh đạo Kim Jong-un trong một cuộc phỏng vấn&nbsp;tuần trước.&nbsp;Ngoại trưởng Australia cho rằng c&aacute;c vụ thử hạt nh&acirc;n v&agrave; ph&oacute;ng t&ecirc;n lửa tạo ra nguy hiểm kh&ocirc;ng cần thiết về tai nạn hoặc trả đũa.</p>\r\n</div>\r\n', 'Mỹ,triều tiên,Kim Jong un,Phim hài,cảnh báo', 'trieu-tien-canh-bao-my-ve-bo-phim-che-gieu-lanh-tu', '24', 1403716265, 1),
(32, 'Thượng viện Nga hủy lệnh điều quân đến Ukraine', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/pu-7034-1403704917.jpg', 'Theo yêu cầu của chính ông Vladimir Putin, Thượng viện Nga hôm nay bãi bỏ nghị quyết cho phép Tổng thống sử dụng quân đội ở Ukraine.', 'Nga,Ukraine,Liên bang,Nghị viện,sử dụng,quân đội', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="pu-7034-1403704917.jpg" src="http://m.f29.img.vnecdn.net/2014/06/25/pu-7034-1403704917.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Tổng thống Nga Vladimir Putin. Ảnh:&nbsp;<em>Itar-Tass</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&Ocirc;ng Putin h&ocirc;m qua gửi thư cho Chủ tịch Thượng viện Nga đề nghị hủy bỏ nghị quyết n&oacute;i tr&ecirc;n. Kết quả chỉ c&oacute; một phiếu chống, c&ograve;n lại 153 phiếu ủng hộ đề nghị huỷ bỏ n&agrave;y, theo&nbsp;<em>CNN</em>.</p>\r\n\r\n<p>Ph&aacute;t ng&ocirc;n vi&ecirc;n của Tổng thống, &ocirc;ng Dmitry Peskov cho hay, y&ecirc;u cầu của &ocirc;ng Putin được đưa ra trong bối cảnh những thảo luận giải quyết khủng hoảng ở miền đ&ocirc;ng Ukraine vẫn đang diễn ra. Đề nghị n&agrave;y nhằm hỗ trợ tiến tr&igrave;nh h&ograve;a b&igrave;nh ở Ukraine, vừa được nhen nh&oacute;m với lệnh ngừng bắn h&ocirc;m 20/6.</p>\r\n\r\n<p>Nghị quyết n&agrave;y do &ocirc;ng Putin n&ecirc;u ra, được Hội đồng Li&ecirc;n bang chấp thuận hồi đầu th&aacute;ng 3, khi căng thẳng giữa Nga v&agrave; Ukraine l&ecirc;n cao sau khi Nga s&aacute;p nhập Crimea v&agrave; triển khai qu&acirc;n đội dọc bi&ecirc;n giới Ukraine.</p>\r\n\r\n<p>Bất chấp tuy&ecirc;n bố của Nga, &ocirc;ng Anders Fogh Rasmussen, Tổng thư k&yacute; Tổ chức Hiệp ước Bắc Đại T&acirc;y Dương (NATO) h&ocirc;m nay khẳng định kh&ocirc;ng c&oacute; dấu hiệu n&agrave;o cho thấy Nga t&ocirc;n trọng c&aacute;c cam kết về Ukraine.</p>\r\n\r\n<p>Do đ&oacute; NATO sẽ xem x&eacute;t quan hệ với Nga v&agrave; quyết định cần l&agrave;m g&igrave; tiếp theo, đồng thời thảo luận l&agrave;m sao c&oacute; thể gi&uacute;p Ukraine x&acirc;y dựng năng lực qu&acirc;n sự, &ocirc;ng Rasmussen n&oacute;i khi đang ở Bỉ tham dự hội nghị ngoại trưởng NATO.</p>\r\n\r\n<p>T&acirc;n Tổng thống Ukraine Petro Poroshenko cuối tuần qua tuy&ecirc;n bố lệnh ngừng bắn nhằm giảm căng thẳng ở miền đ&ocirc;ng nước n&agrave;y. &Ocirc;ng Poroshenko h&ocirc;m qua dọa bỏ lệnh ngừng bắn n&agrave;y sau khi một chiếc trực thăng của ch&iacute;nh phủ bị qu&acirc;n biểu t&igrave;nh bắn hạ, l&agrave;m 9 người thiệt mạng.</p>\r\n\r\n<p>Tuy nhi&ecirc;n, Ngoại trưởng Ukraine Pavlo Klimkin h&ocirc;m nay khẳng định nước n&agrave;y cam kết giữ nguy&ecirc;n lệnh ngừng bắn nhằm xuống thang t&igrave;nh h&igrave;nh ở Donetsk v&agrave; Lugansk, d&ugrave; những h&agrave;nh động khi&ecirc;u kh&iacute;ch của qu&acirc;n biểu t&igrave;nh cực kỳ nguy hiểm đối với việc đạt được lệnh ngừng bắn bền vững.</p>\r\n\r\n<p>H&ocirc;m qua, &ocirc;ng Putin th&uacute;c giục Ukraine gia hạn th&ecirc;m lệnh ngừng bắn v&agrave; đ&agrave;m ph&aacute;n với phe biểu t&igrave;nh. Việc hạ vũ kh&iacute; trong một tuần l&agrave; kh&ocirc;ng thực tế, c&oacute; thể khiến người biểu t&igrave;nh lưỡng lự do sợ Kiev trả đũa.</p>\r\n</div>\r\n', 'Nga,Ukraina,Liên bang nga,Nghị viên,sử dụng,quân đội', 'thuong-vien-nga-huy-lenh-dieu-quan-den-ukraine', '24', 1403716381, 1),
(33, 'Sáng kiến giúp tháo nút đạn cối dễ dàng', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/thietbi-8838-1402302645.jpg', 'Các cán bộ thuộc Cục Quân khí đã nghiên cứu, chế tạo thành công thiết bị tháo và làm sạch nút phòng ẩm của đạn pháo và đạn cối.', 'công nghệ,tháo ngòi nổ đạn phao,việt nam', '<div>&nbsp;\r\n<div id="left_calculator" style="margin: 0px; padding: 0px;">\r\n<div class="fck_detail width_common" style="margin: 0px; padding: 0px 0px 10px; width: 480.015625px; float: left; overflow: hidden; font-size: 14px; line-height: normal; font-family: arial;">\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="margin:0px auto 10px; max-width:100%; padding:0px; width:380px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="Đoàn công tác Cục Quân khí kiểm tra sáng kiến thiết bị tháo nút phòng ẩm đạn cối của Kho KV2." src="http://m.f29.img.vnecdn.net/2014/06/09/thietbi-8838-1402302645.jpg" style="margin:0px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Đo&agrave;n c&ocirc;ng t&aacute;c Cục Qu&acirc;n kh&iacute; kiểm tra s&aacute;ng kiến thiết bị th&aacute;o n&uacute;t ph&ograve;ng ẩm đạn cối của Kho KV2. Ảnh:&nbsp;<em>QĐND.</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Nghi&ecirc;n cứu tr&ecirc;n xuất ph&aacute;t từ thực tế c&aacute;c n&uacute;t ph&ograve;ng ẩm của đạn thường bị trương nở v&agrave; bẩn, n&ecirc;n việc th&aacute;o v&agrave; l&agrave;m sạch gặp rất nhiều kh&oacute; khăn; trong khi việc th&aacute;o v&agrave; l&agrave;m sạch ph&ograve;ng ẩm đạn ph&aacute;o, đạn cối cần thực hiện đ&uacute;ng quy tr&igrave;nh, nhằm đảm bảo chất lượng v&agrave; tuổi thọ của đạn.</p>\r\n\r\n<p>Thiết bị do kỹ sư Đinh Thế Dương, c&aacute;n bộ kỹ thuật Kho KV2 (Cục Qu&acirc;n kh&iacute;, Tổng cục Kỹ thuật) c&ugrave;ng c&aacute;c đồng nghiệp đ&atilde; nghi&ecirc;n cứu thiết kế v&agrave; chế tạo. Trong đ&oacute;, thiết bị th&aacute;o n&uacute;t ph&ograve;ng ẩm gồm ng&agrave;m, tay quay, ốc cố định l&agrave;m bằng vật liệu tận dụng, kết cấu đơn giản, gọn nhẹ, dễ thao t&aacute;c. Khi đưa v&agrave;o ứng dụng, năng suất lao động của thiết bị tăng 2,8 lần so với sử dụng thiết bị cũ.&nbsp;</p>\r\n\r\n<p>Thiết bị l&agrave;m sạch n&uacute;t ph&ograve;ng ẩm được chế tạo bằng th&eacute;p, t&ocirc;n tấm, gi&uacute;p người thợ chuẩn bị v&agrave; l&agrave;m sạch n&uacute;t ph&ograve;ng ẩm nhanh, năng suất tăng gấp 5 lần so với c&aacute;ch l&agrave;m cũ thủ c&ocirc;ng, bảo đảm an to&agrave;n.</p>\r\n\r\n<p>S&aacute;ng kiến đ&atilde; được Cục Qu&acirc;n kh&iacute; (Tổng cục Kỹ thuật) cấp giấy chứng nhận, cho ph&eacute;p &aacute;p dụng.</p>\r\n\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'công nghệ,tháo ngòi nổ,đạn pháo,quân đội,việt nam', 'sang-kien-giup-thao-nut-dan-coi-de-dang', '24', 1403716660, 1),
(34, 'Hệ thống định vị Trung Quốc', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/ve-tinh480-1361509432-500x0-4344-1403235505.jpg', 'Ba trạm vệ tinh mô hình dựa trên hệ thống định vị Bắc Đẩu của Trung Quốc mới được giới thiệu tại một khu công nghiệp ở Thái Lan hôm 18/6, đánh dấu bước đi đầu tiên trong mục tiêu chinh phục thị trường ASEAN.', 'Công nghệ,GPS,Asean,Trung quốc', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="ve-tinh480-1361509432-500x0-4344-1403235" src="http://m.f29.img.vnecdn.net/2014/06/20/ve-tinh480-1361509432-500x0-4344-1403235505.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>H&igrave;nh minh họa một vệ tinh trong hệ thống định vị to&agrave;n cầu Bắc Đẩu của Trung Quốc. Ảnh:&nbsp;<em>china.org.cn</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Theo&nbsp;<em>Xinhua</em>, đ&acirc;y l&agrave; một phần trong thỏa thuận hợp t&aacute;c được k&yacute; kết giữa ch&iacute;nh phủ Trung Quốc v&agrave; Th&aacute;i Lan. C&aacute;c trạm cơ sở sẽ ho&agrave;n th&agrave;nh tại Th&aacute;i Lan trong v&ograve;ng hai năm.</p>\r\n\r\n<p>Hai b&ecirc;n sẽ h&igrave;nh th&agrave;nh một mạng lưới li&ecirc;n kết phủ s&oacute;ng mọi khu vực tại Th&aacute;i Lan, tiến tới mở rộng trong c&aacute;c quốc gia thuộc Hiệp hội c&aacute;c quốc gia Đ&ocirc;ng Nam &Aacute; ASEAN. C&aacute;c hoạt động hợp t&aacute;c với Myanmar v&agrave; Malaysia sẽ được tăng cường trong hai năm tới.</p>\r\n\r\n<p>&quot;Hệ thống vệ tinh định vị Bắc Đẩu được dự kiến sẽ phủ s&oacute;ng to&agrave;n cầu cho đến năm 2020 với khoảng 32 vệ tinh&quot;, Li Deren, chủ tịch Tập đo&agrave;n C&ocirc;ng nghiệp Th&ocirc;ng tin Kh&ocirc;ng gian địa l&yacute; Bắc Đẩu tại tỉnh Vũ H&aacute;n, một đơn vị tham gia dự &aacute;n, cho hay.</p>\r\n\r\n<p>Mạng lưới vệ tinh sẽ cải thiện t&iacute;nh ch&iacute;nh x&aacute;c, độ nhạy v&agrave; tăng tốc độ c&aacute;c dịch vụ định vị. Khi phủ s&oacute;ng khắp thế giới, n&oacute; c&oacute; thể hỗ trợ c&aacute;c hoạt động sản xuất điện, khai th&aacute;c dầu, kho&aacute;ng sản, n&ocirc;ng nghiệp, gi&aacute;m s&aacute;t m&ocirc;i trường, điều khiển giao th&ocirc;ng v&agrave; nhiều lĩnh vực kh&aacute;c.</p>\r\n\r\n<p>Bắc Đẩu l&agrave; hệ thống vệ tinh định vị của Trung Quốc, c&oacute; chức năng tương tự như hệ thống GPS của Mỹ, GLONASS của Nga v&agrave; Galileo của ch&acirc;u &Acirc;u. Trước đ&acirc;y, chỉ ch&iacute;nh phủ v&agrave; qu&acirc;n đội Trung Quốc sử dụng hệ thống n&agrave;y để dự b&aacute;o thời tiết, kiểm so&aacute;t giao th&ocirc;ng v&agrave; hỗ trợ hoạt động cứu nạn.</p>\r\n</div>\r\n', 'Công nghệ,GPS,Asean', 'he-thong-dinh-vi-trung-quoc', '24', 1403716764, 0),
(35, 'Bộ trưởng Giao thông xin lỗi về việc Vietjet Air bay nhầm', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/btdinhlathang0-1403692435_490x294.jpg', 'Bộ trưởng Đinh La Thăng cũng đề xuất có hình thức tăng cường giám sát với hãng, đồng thời không cho tăng số lượng tàu bay nếu không đủ điều kiện.', 'Bộ trưởng,Đinh la thăng,Viet Jetair,Bay nhầm', '<p>Gần một tuần sau vụ &quot;nhầm&quot; s&acirc;n bay của phi cơ Vietjet Air, chiều 25/6, Bộ trưởng Giao th&ocirc;ng Vận tải - Đinh La Thăng đ&atilde; chủ tr&igrave; cuộc họp kết luận sự cố. Thay mặt ng&agrave;nh giao th&ocirc;ng, Bộ trưởng đ&atilde; xin lỗi to&agrave;n d&acirc;n v&igrave; để xảy ra sự cố n&ecirc;u tr&ecirc;n. Trước đ&oacute;, trong cuộc họp, &ocirc;ng Thăng cũng&nbsp;kh&ocirc;ng ngừng &quot;chất vấn&quot; đại diện Cục H&agrave;ng kh&ocirc;ng về việc liệu Vietjet Air c&oacute; đủ khả năng, điều kiện để tiếp tục bay hay kh&ocirc;ng.</p>\r\n\r\n<p>&quot;Đ&acirc;y l&agrave; sự cố nghi&ecirc;m trọng, uy hiếp trực tiếp đến an to&agrave;n bay. Chuyến bay kh&ocirc;ng c&oacute; hậu quả n&agrave;o l&agrave; một điều may mắn. Nhưng ch&uacute;ng ta c&oacute; may mắn m&atilde;i được kh&ocirc;ng?&quot;, Bộ trưởng Đinh La Thăng đặt c&acirc;u hỏi.</p>\r\n\r\n<p>Với nhận định n&agrave;y, Bộ trưởng Thăng y&ecirc;u cầu Cục H&agrave;ng kh&ocirc;ng đ&aacute;nh gi&aacute; lại điều kiện của h&atilde;ng h&agrave;ng kh&ocirc;ng tư nh&acirc;n Vietjet v&agrave; kh&ocirc;ng cho ph&eacute;p đơn vị n&agrave;y nhận th&ecirc;m t&agrave;u bay nếu kh&ocirc;ng đủ điều kiện. &quot;Thậm ch&iacute; sau khi r&agrave; so&aacute;t lại, nếu năng lực của h&atilde;ng kh&ocirc;ng đủ th&igrave; cất bớt t&agrave;u bay đi&quot;, vị tư lệnh ng&agrave;nh giao th&ocirc;ng n&oacute;i. Hiện Vietjet Air c&oacute; 15 t&agrave;u bay v&agrave; dự định sẽ nhập th&ecirc;m nhiều chiếc trong c&aacute;c năm tới.</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="Bo-truong-Thang-6466-1403689840.jpg" src="http://m.f25.img.vnecdn.net/2014/06/25/Bo-truong-Thang-6466-1403689840.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Bộ trưởng Đinh La Thăng nhận định do Vietjet ph&aacute;t triển qu&aacute; nhanh n&ecirc;n năng lực chuy&ecirc;n m&ocirc;n, đội ngũ nh&acirc;n lực chưa theo kịp. Ảnh:&nbsp;<em>Thanh B&igrave;nh</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><span style="color:rgb(0, 0, 0)">Ph&acirc;n t&iacute;ch s&acirc;u hơn về vụ việc, Thứ trưởng Phạm Qu&yacute; Ti&ecirc;u nhận định c&oacute; nhiều lỗi như tiếp vi&ecirc;n của h&atilde;ng biết kh&aacute;ch đi Đ&agrave; Lạt, nhưng suốt chuyến bay kh&ocirc;ng trao đổi g&igrave; với phi c&ocirc;ng về việc n&agrave;y. Cơ trưởng cũng cho m&aacute;y bay thẳng hướng Cam Ranh v&agrave; tưởng m&igrave;nh đi đ&uacute;ng đường cho đến khi chỉ c&ograve;n c&aacute;ch s&acirc;n bay 5 dặm (khoảng 8 km). L&uacute;c n&agrave;y, t&agrave;u bay kh&ocirc;ng thể chuyển hướng được nữa v&agrave; bắt buộc phải hạ c&aacute;nh.</span></p>\r\n\r\n<p>Ngo&agrave;i ra, nh&acirc;n vi&ecirc;n điều độ của h&atilde;ng thực hiện nhiệm vụ đưa kế hoạch bay cho phi c&ocirc;ng ng&agrave;y h&ocirc;m đ&oacute; l&agrave; người học việc, chưa c&oacute; giấy ph&eacute;p. Do chưa c&oacute; kinh nghiệm, người n&agrave;y đ&atilde; kh&ocirc;ng đưa kế hoạch bay cho phi c&ocirc;ng k&yacute;, dẫn đến phi c&ocirc;ng kh&ocirc;ng c&oacute; th&ocirc;ng tin.</p>\r\n\r\n<p>B&ecirc;n cạnh đ&oacute;, b&ecirc;n quản l&yacute; bay cũng đ&atilde; c&oacute; lỗi chậm th&ocirc;ng b&aacute;o t&agrave;u bay cất c&aacute;nh. Theo quy định của ICAO, b&ecirc;n quản l&yacute; bay phải ph&aacute;t đi điện văn th&ocirc;ng b&aacute;o cho s&acirc;n bay ngay l&acirc;p tức sau khi t&agrave;u bay cất c&aacute;nh. Tuy nhi&ecirc;n, thực tế cho thấy sau khi t&agrave;u bay đ&atilde; cất c&aacute;nh 28 ph&uacute;t, b&ecirc;n quản l&yacute; bay mới th&ocirc;ng b&aacute;o. &quot;Nếu ph&aacute;t hiện nhầm lẫn ra sớm hơn, phi c&ocirc;ng c&oacute; thể thực hiện thay đổi đường bay đi Đ&agrave; Lạt&quot;, Thứ trưởng Ti&ecirc;u nhận định.</p>\r\n\r\n<p>Với những nhận định tr&ecirc;n, Bộ trưởng Đinh La Thăng nhận định Cục H&agrave;ng kh&ocirc;ng cần tăng cường gi&aacute;m s&aacute;t với Vietjet Air. Theo Bộ trưởng, do h&atilde;ng h&agrave;ng kh&ocirc;ng tư nh&acirc;n n&agrave;y c&oacute; quy m&ocirc; ph&aacute;t triển nhanh n&ecirc;n tr&igrave;nh độ năng lực chuy&ecirc;n m&ocirc;n, đội ngũ nh&acirc;n lực chưa theo kịp. Theo Bộ trưởng, với m&ocirc; h&igrave;nh như thế phải đưa ra chế t&agrave;i gi&aacute;m s&aacute;t đặc biệt, thậm ch&iacute; gi&aacute;m s&aacute;t h&agrave;ng ng&agrave;y.</p>\r\n\r\n<p>Trao đổi tại cuộc họp, Tổng gi&aacute;m đốc Vietjet Air - Nguyễn Thị Phương Thảo một lần nữa đưa ra lời xin lỗi h&agrave;nh kh&aacute;ch v&agrave; l&atilde;nh đạo ng&agrave;nh giao th&ocirc;ng về sự cố n&ecirc;u tr&ecirc;n, cam kết kh&ocirc;ng để t&aacute;i diễn. Đại diện h&atilde;ng cũng cam kết chấp h&agrave;nh c&aacute;ch h&igrave;nh thức gi&aacute;m s&aacute;t của l&atilde;nh đạo ng&agrave;nh giao th&ocirc;ng v&agrave; cho biết đ&atilde; tiến h&agrave;nh kiểm điểm v&agrave; cho th&ocirc;i việc một số c&aacute; nh&acirc;n c&oacute; li&ecirc;n quan.</p>\r\n\r\n<p><span style="color:rgb(0, 0, 0)">Cũng tại buổi l&agrave;m việc, Bộ trưởng Đinh La Thăng đ&atilde; đề nghị khiển tr&aacute;ch Cục trưởng Cục H&agrave;ng kh&ocirc;ng do &quot;b&aacute;o c&aacute;o chậm v&agrave; c&oacute; hiện tượng bưng b&iacute;t th&ocirc;ng tin&quot;. Người đứng đầu ng&agrave;nh Giao th&ocirc;ng cam kết c&oacute; h&igrave;nh thức kỷ luật cao hơn nếu những sự cố tương tự lặp lại.</span></p>\r\n', 'Bộ trưởng,Đinh la thăng,Viêt Jetair,bay nhầm', 'bo-truong-giao-thong-xin-loi-ve-viec-vietjet-air-bay-nham', '24', 1403716877, 1),
(36, 'Cảnh sát Thanh Hóa đi công tác địa bàn bằng xe đạp', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/160815-Xe-dap-2-1474-1403693677.jpg', 'Công an phường Nam Ngạn (TP Thanh Hóa) mong muốn mô hình này sẽ góp phần xây dựng hình ảnh người cảnh sát gần gũi, thân thiện với người dân trên địa bàn.', 'Công an,đi xe đạp,thanh hóa', '<p>Trao đổi với&nbsp;<em>VnExpress</em>, thượng t&aacute; L&ecirc; Kim B&ugrave;i, Trưởng c&ocirc;ng an phường Nam Ngạn cho biết, xuất ph&aacute;t từ thực tế trong qu&aacute; tr&igrave;nh l&agrave;m nhiệm vụ ở cơ sở n&ecirc;n một số c&aacute;n bộ, chiến sĩ trong đơn vị đưa ra đề xuất n&agrave;y v&agrave; nhanh ch&oacute;ng được ch&iacute;nh quyền địa phương v&agrave; c&ocirc;ng an cấp tr&ecirc;n đồng &yacute; cho triển khai.</p>\r\n\r\n<p>Trước mắt, 10 chiếc xe đạp được giao cho 10 cảnh s&aacute;t khu vực của c&ocirc;ng an phường quản l&yacute; sử dụng. H&agrave;ng ng&agrave;y, thay v&igrave; sử dụng xe m&aacute;y như trước đ&acirc;y, c&aacute;c c&aacute;n bộ chiến sĩ&nbsp;sẽ đạp xe trực tiếp xuống từng khu phố được ph&acirc;n c&ocirc;ng phụ tr&aacute;ch để gặp gỡ, thăm hỏi v&agrave; tuy&ecirc;n truyền, vận động nh&acirc;n d&acirc;n chấp h&agrave;nh nghi&ecirc;m c&aacute;c qui định của ph&aacute;p luật, t&iacute;ch cực tham gia ph&ograve;ng ngừa, đấu tranh tố gi&aacute;c tội phạm, tệ nạn x&atilde; hội...</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:480px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="160956-Xe-dap-1-3186-1403693677.jpg" src="http://m.f29.img.vnecdn.net/2014/06/25/160956-Xe-dap-1-3186-1403693677.jpg" style="margin:0px; width:480px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Mỗi ng&agrave;y, c&aacute;c cảnh s&aacute;t khu vực ở phường Nam Ngạn sẽ d&ugrave;ng xe đạp di chuyển thực hiện&nbsp;c&ocirc;ng vụ&nbsp;thay v&igrave; đi&nbsp;xe m&aacute;y như trước đ&acirc;y. Ảnh:<em>&nbsp;Th&aacute;i&nbsp;Thanh.</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Thượng t&aacute; L&ecirc; Kim B&ugrave;i cho hay, m&ocirc; h&igrave;nh đang trong qu&aacute; tr&igrave;nh thử nghiệm nhưng đ&atilde; nhận được c&aacute;i nh&igrave;n thiện cảm từ quần ch&uacute;ng nh&acirc;n d&acirc;n. &quot;Theo đ&aacute;nh gi&aacute; bước đầu, loại phương tiện n&agrave;y c&oacute; nhiều ưu điểm, vừa tiết kiệm nhi&ecirc;n liệu, th&acirc;n thiện với m&ocirc;i trường lại gần gũi với nh&acirc;n d&acirc;n...&quot;, thượng t&aacute; B&ugrave;i chia sẻ.</p>\r\n\r\n<p>Dự kiến, sau một thời gian thử nghiệm, c&ocirc;ng an TP Thanh H&oacute;a sẽ nghiệm thu đ&aacute;nh gi&aacute; hiệu quả để l&agrave;m cơ sở nh&acirc;n rộng m&ocirc; h&igrave;nh n&agrave;y.</p>\r\n', 'Công an,Thanh hoa,đi xe đạp', 'canh-sat-thanh-hoa-di-cong-tac-dia-ban-bang-xe-dap', '24', 1403716974, 1),
(37, 'Hà Nội đề xuất phạt nặng hành vi tổ chức nhảy múa thoát y', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/mua-trong-vu-truong-1-2881-1403686098.jpg', 'Những hoạt động mang tính chất đồi trụy gây nhận thức lệch lạc, không phù hợp với thuần phong mỹ tục, lối sống và nét thanh lịch của người Thủ đô được đề nghị tăng gấp đôi mức phạt.', 'Múa thoát y,Hà Nội,Phạt nặng', '<p>UBND TP H&agrave; Nội đang x&acirc;y dựng Dự thảo quy định mức tiền phạt với c&aacute;c vi phạm h&agrave;nh ch&iacute;nh trong lĩnh vực văn h&oacute;a, theo đ&oacute;, 28 h&agrave;nh vi sẽ bị phạt gấp đ&ocirc;i so với quy định hiện h&agrave;nh của Ch&iacute;nh phủ.</p>\r\n\r\n<p>Việc tổ chức cho kh&aacute;ch nhảy m&uacute;a tho&aacute;t y hoặc tổ chức hoạt động kh&aacute;c mang t&iacute;nh đồi trụy tại vũ trường, nh&agrave; h&agrave;ng ăn uống, karaoke... được kiến nghị phạt từ 50-60 triệu đồng. Th&agrave;nh phố H&agrave; Nội cho rằng, những hoạt động&nbsp;n&agrave;y ảnh hưởng đến gi&aacute;o dục thẩm mỹ v&agrave; định h&igrave;nh nh&acirc;n c&aacute;ch của giới trẻ.&nbsp;</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:400px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="mua-trong-vu-truong-1-2881-1403686098.jp" src="http://m.f29.img.vnecdn.net/2014/06/25/mua-trong-vu-truong-1-2881-1403686098.jpg" style="margin:0px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Việc tổ chức cho kh&aacute;ch nhảy m&uacute;a tho&aacute;t y hoặc tổ chức hoạt động kh&aacute;c mang t&iacute;nh chất đồi trụy tại vũ trường, nh&agrave; h&agrave;ng ăn uống, karaooke... được kiến nghị phạt từ 50-60 triệu đồng.<em>&nbsp;Ảnh minh họa.</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>H&agrave;nh vi bao che cho c&aacute;c hoạt động mang t&iacute;nh chất khi&ecirc;u d&acirc;m, k&iacute;ch động bạo lực, đồi trụy, nhảy m&uacute;a tho&aacute;t y tại c&aacute;c cơ sở tr&ecirc;n bị đề xuất mức phạt từ 40-50 triệu đồng. Việc treo tranh ảnh, lịch hay đồ vật c&oacute; t&iacute;nh khi&ecirc;u d&acirc;m, k&iacute;ch động bạo lực, đồi trụy... v&agrave; việc d&ugrave;ng c&aacute;c phương thức phục vụ c&oacute; t&iacute;nh chất khi&ecirc;u d&acirc;m cũng bị đề nghị n&acirc;ng mức phạt gấp đ&ocirc;i quy định hiện h&agrave;nh.</p>\r\n\r\n<p>C&aacute;c vi phạm quy định về nếp sống văn h&oacute;a như xem b&oacute;i, gọi hồn, xin xăm, xin thẻ, yểm b&ugrave;a, ph&ugrave; ch&uacute;, truyền b&aacute; sấm trạng bị đề nghị mức phạt tối đa 10 triệu đồng.</p>\r\n\r\n<p>Những vi phạm quy định về bảo vệ c&ocirc;ng tr&igrave;nh văn h&oacute;a, nghệ thuật, di sản văn h&oacute;a như viết, vẽ, l&agrave;m bẩn hoặc &ocirc; uế di t&iacute;ch lịch sử-văn h&oacute;a, danh lam thắng cảnh, c&ocirc;ng tr&igrave;nh văn h&oacute;a nghệ thuật bị đề nghị mức phạt từ 2-6 triệu đồng.</p>\r\n\r\n<p>Ngo&agrave;i ra, Dự thảo cũng đề xuất tăng mức phạt với c&aacute;c h&agrave;nh vi vi phạm: t&agrave;ng trữ, phổ biến ghi &acirc;m, ghi h&igrave;nh ca m&uacute;a nhạc, s&acirc;n khấu; điều kiện tổ chức văn h&oacute;a, kinh doanh dịch vụ văn h&oacute;a c&ocirc;ng cộng; giấy ph&eacute;p tổ chức văn h&oacute;a, kinh doanh dịch vụ c&ocirc;ng cộng; sản xuất, lưu h&agrave;nh băng, đĩa tr&ograve; chơi điện tử.</p>\r\n\r\n<p>Theo th&agrave;nh phố H&agrave; Nội, mức tiền phạt hiện nay &aacute;p dụng chung cho cả nước chưa t&iacute;nh đến yếu tố đặc th&ugrave; của Thủ đ&ocirc; n&ecirc;n chưa đủ sức t&aacute;c động mạnh mẽ đến &yacute; thức chấp h&agrave;nh ph&aacute;p luật v&agrave; chưa thực sự c&oacute; t&iacute;nh răn đe. Dự thảo sẽ được xem x&eacute;t, thảo luận v&agrave; th&ocirc;ng qua tại kỳ họp thứ 10 HĐND TP H&agrave; Nội diễn ra ng&agrave;y 8-11/7.</p>\r\n', 'Múa thoát y,Hà nội,phạt nặng', 'ha-noi-de-xuat-phat-nang-hanh-vi-to-chuc-nhay-mua-thoat-y', '24', 1403717075, 1),
(38, '50 CĐV Chile và chiếc tivi của một người Brazil tốt bụng', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/anh-1-4417-1403694761.jpg', 'Luiz Gonzaga, một người khuôn vác 50 tuổi làm việc trong tòa nhà Sel tại Rio de Janeiro, đã chia sẻ chiếc tivi 14 inch nhỏ bé cho một nhóm CĐV Chile - những người không đủ tiền mua vé vào sân.', 'Chile,Mược tivi,Thể thao,World cup', '<p>Trước trận đấu giữa Chile v&agrave; T&acirc;y Ban Nha ở lượt trận thứ hai v&ograve;ng bảng World Cup h&ocirc;m 18/6 vừa qua, một nh&oacute;m CĐV Chile đ&atilde; g&acirc;y n&aacute;o loạn khi đập ph&aacute;, l&agrave;m loạn khu vực b&aacute;o ch&iacute; của s&acirc;n Maracana. L&iacute; do l&agrave; họ muốn v&agrave;o s&acirc;n để cổ vũ cho đội nh&agrave; nhưng lại kh&ocirc;ng c&oacute; v&eacute;. Kết quả của vụ việc l&agrave; 100 kẻ qu&aacute; kh&iacute;ch bị ch&iacute;nh quyền Brazil trục xuất. Một c&acirc;u chuyện buồn cho sự cuồng nhiệt nhưng thiếu b&igrave;nh tĩnh của những người đ&atilde; cất c&ocirc;ng sang tận Brazil để theo d&otilde;i đội b&oacute;ng qu&ecirc; hương thi đấu.</p>\r\n\r\n<p>Cũng ở trận đấu đ&oacute;, 50 CĐV Chile kh&aacute;c đ&atilde; được một người d&acirc;n lao động Brazil chia sẻ chiếc TV 14 inch để c&ugrave;ng tận hưởng những khoảnh khắc tr&ecirc;n s&acirc;n.</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:490px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="anh-1-4417-1403694761.jpg" src="http://m.f1.img.vnecdn.net/2014/06/25/anh-1-4417-1403694761.jpg" style="margin:0px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>50 CĐV Chile theo d&otilde;i trận đấu với T&acirc;y Ban Nha qua chiếc TV 14 inch của Luiz Gonzaga. Ảnh:&nbsp;<em>Luiz Gonzaga</em>.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&ldquo;T&ocirc;i đang xem trận đấu th&igrave; họ đến v&agrave; n&agrave;i nỉ t&ocirc;i đem chiếc TV đặt ra ngo&agrave;i sảnh để họ c&oacute; thể đứng từ ngo&agrave;i đường xem v&agrave;o&rdquo;, &ocirc;ng Luiz Gonzaga n&oacute;i. &ldquo;Sau mỗi b&agrave;n thắng, họ h&eacute;t ầm l&ecirc;n v&agrave; khiến một người sống ở t&ograve;a nh&agrave; n&agrave;y thấy phiền&rdquo;. Người đ&agrave;n &ocirc;ng n&agrave;y sau đ&oacute; y&ecirc;u cầu Luiz chấm dứt &ldquo;buổi chiếu b&oacute;ng c&ocirc;ng cộng&rdquo; nhưng bị từ chối.</p>\r\n\r\n<p>Juan Diaz &ndash; người vượt 6000 km bằng xe hơi trong 15 ng&agrave;y từ Santiago (Chile) đến Rio, l&agrave; một trong số những CĐV Chile được Luiz cứu rỗi. Con trai &ocirc;ng - Michel Diaz - n&oacute;i: &ldquo;M&agrave;n h&igrave;nh rất nhỏ nhưng c&ograve;n tốt hơn l&agrave; bạn kh&ocirc;ng thể xem được g&igrave;. &Ocirc;ng ấy (Luiz) đ&atilde; cứu rỗi ch&uacute;ng t&ocirc;i, nếu kh&ocirc;ng cả đ&aacute;m sẽ kh&ocirc;ng xem được trận đấu đ&oacute;&rdquo;. Hai bố con người Chile kh&ocirc;ng t&agrave;i n&agrave;o mua được v&eacute; từ ban tổ chức, trong khi d&acirc;n chợ đen h&eacute;t gi&aacute; gần 500 đ&ocirc;la cho một tấm v&eacute; v&agrave;o s&acirc;n Maracana - nơi chỉ c&aacute;ch chỗ l&agrave;m của &ocirc;ng Luiz v&agrave;i chục bước ch&acirc;n.</p>\r\n\r\n<p>Sau khi tiếng c&ograve;i kết th&uacute;c trận đấu vang l&ecirc;n, chiến thắng 2-0 của Chile đ&atilde; khiến c&aacute;c CĐV vỡ &ograve;a. Luiz được nh&oacute;m người mới quen ca tụng l&agrave; &ldquo;vị vua của người Chile&rdquo; nhờ h&agrave;nh động rộng lượng của m&igrave;nh. Người đ&agrave;n &ocirc;ng 50 tuổi sau đ&oacute; h&ograve;a m&igrave;nh v&agrave;o bữa tiệc k&eacute;o d&agrave;i hai tiếng của những người bạn Chile.</p>\r\n', 'World cup,Thể thao', '50-cdv-chile-va-chiec-tivi-cua-mot-nguoi-brazil-tot-bung', '24', 1403717337, 1),
(39, 'Suarez phải nộp đơn giải trình cho FIFA', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/1-2528-1403688644.jpg', 'Tiền đạo của Uruguay mới là trường hợp thứ hai trong lịch sử bị luận tội trong thời gian diễn ra World Cup, sau vụ cắn Giorgio Chiellini của Italy hôm qua.', 'Cắn nhau,Suarez,Worldcup', '<p>Hạn ch&oacute;t để Uruguay v&agrave; Suarez giải tr&igrave;nh l&agrave; 17h h&ocirc;m nay 25/6, giờ Brasilia.</p>\r\n\r\n<p>FIFA đ&atilde; mở cuộc điều tra về h&agrave;nh vi cắn vai hậu vệ Chiellini của Luis Suarez chỉ v&agrave;i tiếng đồng hồ sau trận Uruguay thắng Italy 1-0 ở lượt cuối bảng D.</p>\r\n\r\n<p>FIFA sẽ căn cứ v&agrave;o c&aacute;c bằng chứng thu thập được v&agrave; đồng thời sẽ mổ băng để x&eacute;t xử c&aacute;c &quot;lỗi r&otilde; r&agrave;ng&quot; m&agrave; trọng t&agrave;i điều khiển trận đấu kh&ocirc;ng ph&aacute;t hiện ra.</p>\r\n\r\n<table align="center" border="0" cellpadding="3" cellspacing="0" class="tplCaption" style="font-family:arial; font-size:14px; line-height:normal; margin:0px auto 10px; max-width:100%; padding:0px; width:500px">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="1-2528-1403688644.jpg" src="http://m.f1.img.vnecdn.net/2014/06/25/1-2528-1403688644.jpg" style="margin:0px" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Suarez nhăn nh&oacute; &ocirc;m mặt sau t&igrave;nh huống va chạm m&agrave; anh bị cho l&agrave; đ&atilde; cắn v&agrave;o vai Chiellini. Ảnh:&nbsp;<em>AP</em>.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Trong trường hợp Suarez bị x&aacute;c định l&agrave; &quot;c&oacute; h&agrave;nh vi bạo lực với đối thủ&quot;, FIFA sẽ đưa ra &aacute;n phạt, với khung dao động từ hai trận đến hai năm treo gi&ograve;.</p>\r\n\r\n<p>H&igrave;nh thức kỷ luật Suarez sẽ được FIFA th&ocirc;ng b&aacute;o trước ng&agrave;y thứ bảy tuần n&agrave;y 28/6, khi tuyển Uruguay của anh gặp Colombia tr&ecirc;n s&acirc;n Maracana trong trận đấu ở v&ograve;ng 16 đội.</p>\r\n\r\n<p>Suarez mới l&agrave; trường hợp thứ hai trong lịch sử FIFA phải mổ băng để luận tội một cầu thủ dự World Cup khi giải đang diễn ra.</p>\r\n\r\n<p>Trường hợp đầu diễn ra năm 1994 khi hậu vệ tuyển Italy Mauro Tassotti đ&aacute;nh c&ugrave;i chỏ l&agrave;m vỡ mũi cầu thủ T&acirc;y Ban Nha Luis Enrique. Trọng t&agrave;i điều khiển trận tứ kết h&ocirc;m đ&oacute; kh&ocirc;ng ph&aacute;t hiện ra h&agrave;nh vi của Tassotti, nhưng sau khi mổ băng, FIFA quyết định phạt treo gi&ograve; hậu vệ n&agrave;y t&aacute;m trận thi đấu quốc tế.</p>\r\n', 'Cắn nhau,Suarez,Worldcup', 'suarez-phai-nop-don-giai-trinh-cho-fifa', '24', 1403717482, 1),
(40, 'Tiến sĩ Nguyễn Nhã: ''Cơ hội thoát Trung ngàn năm có một', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/aston-martin-lagonda-1-6954-1403494788.jpg', 'Để tìm kiếm một chuỗi bên trong một chuỗi khác, bạn có thể sử dụng một trong ba hàm strstr(), strchr(), strrchar() hay stristr(). Nhưng để tìm kiếm vị trí xuất hiện str1 trong chuỗi ', 'tin noi bo', '<p style="text-align:justify">Để t&igrave;m kiếm một chuỗi b&ecirc;n trong một chuỗi kh&aacute;c, bạn c&oacute; thể sử dụng một trong ba h&agrave;m&nbsp;<em>strstr(), strchr(), strrchar()&nbsp;</em>hay<em>stristr().&nbsp;</em>Nhưng để t&igrave;m kiếm vị tr&iacute; xuất hiện<em>&nbsp;str1&nbsp;</em>trong chuỗi&nbsp;<em>str2</em>, bạn c&oacute; thể sử dụng c&aacute;c h&agrave;m như:&nbsp;<em>strpos(), strrpos().</em>H&agrave;m&nbsp;<em>strpos()&nbsp;</em>trả về vị tr&iacute; t&igrave;m thấy chuỗi<em>str1&nbsp;</em>trong chuỗi<em>&nbsp;str2</em>, ngược lại h&agrave;m trả về gi&aacute; trị -1. Nếu c&oacute; nhiều chuỗi&nbsp;<em>str1</em>&nbsp;giống nhau, h&agrave;m n&agrave;y chỉ trả về vị tr&iacute; chuỗi&nbsp;<em>str1</em>&nbsp;đầu ti&ecirc;n</p>\r\n\r\n<p style="text-align:justify">C&uacute; ph&aacute;p:&nbsp;<span style="color:rgb(128, 0, 128)">int strpos(string str1, string str2 [int off]);</span></p>\r\n\r\n<p style="text-align:justify">K&iacute; tự đầu ti&ecirc;n của chuỗi t&iacute;nh từ 0. Xem v&iacute; dụ:</p>\r\n', 'tin noi bo', 'tien-si-nguyen-nha-co-hoi-thoat-trung-ngan-nam-co-mot', '24', 1404449882, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_category`
--

DROP TABLE IF EXISTS `tbl_news_category`;
CREATE TABLE IF NOT EXISTS `tbl_news_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catenewsName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `catenewsDescription` longtext COLLATE utf8_unicode_ci,
  `catenewsParent` int(11) DEFAULT NULL,
  `catenewsSlug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `catenewsSlug` (`catenewsSlug`),
  UNIQUE KEY `catenewsSlug_2` (`catenewsSlug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumping data for table `tbl_news_category`
--

INSERT INTO `tbl_news_category` (`id`, `catenewsName`, `catenewsDescription`, `catenewsParent`, `catenewsSlug`, `time`, `status`) VALUES
(47, 'Tin nội bộ', 'Toàn bộ tin tức nội bộ', 0, 'tin-noi-bo', 1403715609, 1),
(48, 'Tin thời sự', 'toàn bộ tin tức thời sự', 0, 'tin-thoi-su', 1403715637, 1),
(49, 'Tin khuyến mại', 'Toàn bộ tin tức khuyến mại', 0, 'tin-khuyen-mai', 1403715651, 1),
(50, 'Tin hot', 'toàn bộ tin hot', 0, 'tin-hot', 1403715661, 1),
(51, 'Tin thế giới', 'Tin tức thế giới', 0, 'tin-the-gioi', 1403715681, 1),
(52, 'Tin châu á', 'toàn bộ tin châu á', 51, 'tin-chau-a', 1403715696, 1),
(56, 'Tin tuyển dụng', 'bản tin tuyển dụng', 0, 'tin-tuyen-dung', 1403715762, 1),
(58, 'Tin công nghệ', 'toàn bộ tin tức công nghệ', 0, 'tin-cong-nghe', 1403716565, 1),
(59, 'Tin thể thao', 'tin thể thao', 0, 'tin-the-thao', 1403717153, 1),
(61, 'Chuyên mục world cup', 'Chuyên mục world cup', 0, 'chuyen-muc-world-cup', 1404449752, 1),
(64, 'Tin châu mỹ', 'toàn bộ tin châu mỹ', 51, 'tin-chau-my', 1404460553, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_views`
--

DROP TABLE IF EXISTS `tbl_news_views`;
CREATE TABLE IF NOT EXISTS `tbl_news_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `cat_news_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

--
-- Dumping data for table `tbl_news_views`
--

INSERT INTO `tbl_news_views` (`id`, `news_id`, `cat_news_id`) VALUES
(13, 28, 48),
(14, 28, 50),
(15, 28, 55),
(16, 28, 52),
(17, 29, 48),
(18, 29, 50),
(19, 29, 55),
(20, 29, 51),
(21, 29, 52),
(22, 30, 50),
(23, 30, 55),
(24, 30, 51),
(25, 30, 52),
(26, 31, 48),
(27, 31, 50),
(28, 31, 55),
(29, 31, 51),
(30, 31, 52),
(31, 32, 48),
(32, 32, 50),
(33, 32, 55),
(34, 32, 51),
(35, 32, 53),
(36, 33, 48),
(37, 33, 50),
(38, 33, 55),
(45, 35, 48),
(46, 35, 50),
(47, 35, 55),
(48, 36, 48),
(49, 36, 50),
(50, 36, 55),
(51, 37, 48),
(52, 37, 50),
(53, 37, 55),
(54, 38, 59),
(55, 38, 60),
(56, 39, 50),
(57, 39, 55),
(58, 39, 59),
(59, 39, 60),
(60, 34, 58),
(61, 34, 50),
(62, 34, 55),
(63, 34, 51),
(64, 34, 52),
(65, 34, 48),
(66, 40, 47);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

DROP TABLE IF EXISTS `tbl_pages`;
CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pageName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pageContent` longtext COLLATE utf8_unicode_ci,
  `pageKeywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pageTag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pageSlug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`id`, `pageName`, `pageContent`, `pageKeywords`, `pageTag`, `pageSlug`, `time`, `status`) VALUES
(1, 'fdgdfg', '<p><img alt="" src="/SmartShop/uploadimg/ed648ac60605bf74e283dbeef41dc830/images/vi.jpg.gif" style="height:12px; width:19px" /></p>\r\n', 'sfasdf', 'asdfasdfsdf', 'fdgdfgasfasdf', 1401350439, 0),
(2, 'dgfhdfgasfasdfa fasd fasf asf a', '<p>dfgdfg</p>\r\n', 'adfasfasf', 'asf asdf as,as fasf a,s', 'dgfhdfgasfasdfa-fasd-fasf-asf-a', 1401350495, 0),
(3, 'Trang con', '<p>Nội dung trang con</p>\r\n', 'trang con', 'trang con', 'dgfhdfgasfasdfa-fasd-fasf-asf-aert-ert-ert-ert-ert-er', 1401350540, 0),
(4, 'Giới thiệu', '<p>Nội dung trang giới thiệu</p>\r\n', 'giới thiệu', 'Tags,Giới thiệu', 'jgfjghfghjd-hdfgh-dfh-dfh', 1401350742, 1),
(5, 'Liên hệ', '<p>Nội dung trang li&ecirc;n hệ</p>\r\n', 'Liên hệ', 'Liên hệ,admin', 'test', 1401969283, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `productName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `productDescription` longtext COLLATE utf8_unicode_ci,
  `productAttributes` longtext COLLATE utf8_unicode_ci,
  `images` longtext COLLATE utf8_unicode_ci,
  `import_prices` decimal(20,2) DEFAULT '0.00',
  `productPrice` decimal(20,2) DEFAULT NULL,
  `salesPrice` decimal(20,2) DEFAULT NULL,
  `startSales` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endSales` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_votes` int(11) DEFAULT NULL,
  `total_value` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quantity_sold` int(11) DEFAULT NULL,
  `productSlug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `productTag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufactureID` int(11) DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productSlug` (`productSlug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `productCode`, `productName`, `productDescription`, `productAttributes`, `images`, `import_prices`, `productPrice`, `salesPrice`, `startSales`, `endSales`, `total_votes`, `total_value`, `quantity`, `quantity_sold`, `productSlug`, `productTag`, `manufactureID`, `time`, `status`) VALUES
(13, 'Jean-01', 'Quần Jean', '<p><span style="color:rgb(0, 0, 0); font-family:arial,helvetica,sans-serif; font-size:12px">C&ugrave;ng với ch&acirc;n v&aacute;y, quần short l&agrave; một trong những trang phục quen mặt của m&ugrave;a h&egrave;. L&yacute; do khiến ph&aacute;i đẹp th&iacute;ch mặc quần short kh&ocirc;ng chỉ bởi n&oacute; cực kỳ ph&ugrave; hợp với thời tiết m&agrave; c&ograve;n gi&uacute;p đ&ocirc;i ch&acirc;n của c&aacute;c c&ocirc; g&aacute;i trở n&ecirc;n thon v&agrave; d&agrave;i hơn, điều m&agrave; ai cũng muốn.</span></p>\r\n', '<p><span style="color:rgb(0, 0, 0); font-family:arial,helvetica,sans-serif; font-size:12px">C&ugrave;ng với ch&acirc;n v&aacute;y, quần short l&agrave; một trong những trang phục quen mặt của m&ugrave;a h&egrave;. L&yacute; do khiến ph&aacute;i đẹp th&iacute;ch mặc quần short kh&ocirc;ng chỉ bởi n&oacute; cực kỳ ph&ugrave; hợp với thời tiết m&agrave; c&ograve;n gi&uacute;p đ&ocirc;i ch&acirc;n của c&aacute;c c&ocirc; g&aacute;i trở n&ecirc;n thon v&agrave; d&agrave;i hơn, điều m&agrave; ai cũng muốn.</span></p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/03_single_shop.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/02_single_shop.jpg', '100000.00', '400000.00', '300000.00', '1403715600', '1404061200', NULL, NULL, 90, NULL, 'quan-jean-13', 'Quần jean,Trung quốc', 59, 1403718944, 2),
(14, 'AO-PHONG-1', 'Áo phông nữ', '<p><span style="color:rgb(0, 0, 0); font-family:arial,helvetica,sans-serif; font-size:12px">C&ugrave;ng với ch&acirc;n v&aacute;y, quần short l&agrave; một trong những trang phục quen mặt của m&ugrave;a h&egrave;. L&yacute; do khiến ph&aacute;i đẹp th&iacute;ch mặc quần short kh&ocirc;ng chỉ bởi n&oacute; cực kỳ ph&ugrave; hợp với thời tiết m&agrave; c&ograve;n gi&uacute;p đ&ocirc;i ch&acirc;n của c&aacute;c c&ocirc; g&aacute;i trở n&ecirc;n thon v&agrave; d&agrave;i hơn, điều m&agrave; ai cũng muốn.</span></p>\r\n', '', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/04_single_shop.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/03_shop.jpg', '0.00', '200000.00', '199999.00', '0', '0', NULL, NULL, 200, NULL, 'ao-phong-nu-14', 'Áo phông nữ,Khuyến mại,hot', 64, 1403719108, 2),
(15, 'IPHONE-4', 'Iphone 4', '<p><span style="font-family:open sans,helvetica,arial,sans-serif; font-size:14px">Kể từ khi ra đời, iPhone d&ugrave; thế hệ n&agrave;o lu&ocirc;n được coi l&agrave; ti&ecirc;u chuẩn khi n&oacute;i smartphone v&agrave; l&agrave; ti&ecirc;u chuẩn để c&aacute;c h&atilde;ng&nbsp;</span><a href="http://www.thegioididong.com/dtdd" target="_blank">điện thoại</a><span style="font-family:open sans,helvetica,arial,sans-serif; font-size:14px">&nbsp;kh&aacute;c cải thiện c&aacute;c sản phẩm của m&igrave;nh. Nếu như iPhone ra đời đ&atilde; tạo n&ecirc;n định nghĩa của việc trải nghiệm&nbsp;</span><a href="http://www.thegioididong.com/dtdd?f=smartphone" target="_blank">smartphone</a><span style="font-family:open sans,helvetica,arial,sans-serif; font-size:14px">&nbsp;th&igrave;&nbsp;</span><strong>iPhone 4</strong><span style="font-family:open sans,helvetica,arial,sans-serif; font-size:14px">&nbsp;ra đời đ&atilde; tạo n&ecirc;n định nghĩa mới cho đẳng cấp trong thiết kế của smartphone.</span></p>\r\n', '<p><strong>Chức năng, cấu h&igrave;nh</strong>&nbsp;iPhone 4 8GB:</p>\r\n\r\n<div class="spec-chart" style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: inherit; font-style: inherit; font-family: inherit; vertical-align: baseline; float: left; width: 308px !important;">\r\n<table class="clearfix compare-chart nolist" style="border-collapse:collapse; border-spacing:0px; border:0px; font-family:inherit; font-style:inherit; font-weight:inherit; line-height:13px; list-style:none; margin:0px; max-width:100%; outline:0px; padding:0px; vertical-align:baseline">\r\n	<tbody>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">M&agrave;n h&igrave;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">DVGA, 3.5&quot;, 640 x 960 pixels</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">CPU:</td>\r\n			<td style="vertical-align:baseline; width:229px">Apple A4, 1 nh&acirc;n, 1 GHz</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">RAM</td>\r\n			<td style="vertical-align:baseline; width:229px">512 MB</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Hệ điều h&agrave;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">iOS 7.0</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Camera ch&iacute;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">5.0 MP, Quay phim HD 720p@30fps</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Camera phụ:</td>\r\n			<td style="vertical-align:baseline; width:229px">VGA (0.3 Mpx)</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Bộ nhớ trong:</td>\r\n			<td style="vertical-align:baseline; width:229px">8 GB</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Thẻ nhớ ngo&agrave;i:</td>\r\n			<td style="vertical-align:baseline; width:229px">Kh&ocirc;ng</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="vertical-align:baseline; width:115px">Dung lượng pin:</td>\r\n			<td style="vertical-align:baseline; width:229px">1420 mAh</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan="2" style="text-align:center; vertical-align:baseline">&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/images.jpg', '0.00', '12000000.00', '11500000.00', '0', '0', NULL, NULL, 303, NULL, 'iphone-4-15', 'Iphone 4,Apple,Chờ đợi', 63, 1403719255, 1),
(16, 'IPHONE-5', 'Iphone 5', '<h2><a href="http://www.thegioididong.com/dtdd-apple-iphone" target="_blank">iPhone</a>&nbsp;5&nbsp; - Thay đổi tất cả một lần nữa</h2>\r\n\r\n<p style="text-align:justify"><em><strong>Sau bao th&aacute;ng ng&agrave;y mong chờ, cả thế giới C&ocirc;ng nghệ đ&atilde; được đ&oacute;n nhận sự ra đời của si&ecirc;u phẩm&nbsp;<a href="http://www.thegioididong.com/dtdd?f=smartphone" target="_blank">điện thoại th&ocirc;ng minh</a>&nbsp;iPhone 5, một trong những chiếc&nbsp;<a href="http://www.thegioididong.com/dtdd" target="_blank">điện thoại</a>&nbsp;được mong mỏi nhất năm 2012. Với những cải tiến mạnh mẽ cả về mặt thiết kế lẫn phần cứng, n&ecirc;n ngay từ khi l&ecirc;n kệ, iPhone 5 li&ecirc;n tục ch&aacute;y h&agrave;ng. iPhone 5 hứa hẹn sẽ tiếp tục khẳng định vị tr&iacute; dẫn đầu tr&ecirc;n thị trường Smartphone hiện nay.</strong></em></p>\r\n', '<div class="left" style="margin: 0px; padding: 0px 10px 0px 0px; border: 0px; outline: 0px; font-weight: inherit; font-style: inherit; font-family: inherit; vertical-align: baseline; width: 342px; float: left;">\r\n<p style="text-align:center"><a href="http://cdn.tgdd.vn/Products/Images/42/57240/Kit/iPhone-5-kich-800x496-thuoc.jpg"><img src="http://cdn.tgdd.vn/Products/Images/42/57240/Kit/iPhone-5-kich-355x220-thuoc.jpg" style="margin:0px" /></a></p>\r\n</div>\r\n\r\n<div class="right" style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: inherit; font-style: inherit; font-family: inherit; vertical-align: baseline; width: 308px; float: left;">\r\n<p><strong>Chức năng, cấu h&igrave;nh</strong>&nbsp;iPhone 5 16GB:</p>\r\n\r\n<div class="spec-chart" style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: inherit; font-style: inherit; font-family: inherit; vertical-align: baseline; float: left; width: 308px !important;">\r\n<table class="clearfix compare-chart nolist" style="border-collapse:collapse; border-spacing:0px; border:0px; font-family:inherit; font-style:inherit; font-weight:inherit; line-height:13px; list-style:none; margin:0px; max-width:100%; outline:0px; padding:0px; vertical-align:baseline">\r\n	<tbody>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">M&agrave;n h&igrave;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">DVGA, 4.0&quot;, 640 x 1136 pixels</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">CPU:</td>\r\n			<td style="vertical-align:baseline; width:229px">Apple A6, 2 nh&acirc;n, 1.3 GHz</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">RAM</td>\r\n			<td style="vertical-align:baseline; width:229px">1 GB</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Hệ điều h&agrave;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">iOS 6</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Camera ch&iacute;nh:</td>\r\n			<td style="vertical-align:baseline; width:229px">8.0 MP, Quay phim FullHD 1080p@30fps</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Camera phụ:</td>\r\n			<td style="vertical-align:baseline; width:229px">1.2 MP</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Bộ nhớ trong:</td>\r\n			<td style="vertical-align:baseline; width:229px">16 GB</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="border-color:rgb(255, 255, 255) rgb(255, 255, 255) rgb(221, 221, 221); vertical-align:baseline; width:115px">Thẻ nhớ ngo&agrave;i:</td>\r\n			<td style="vertical-align:baseline; width:229px">Kh&ocirc;ng</td>\r\n		</tr>\r\n		<tr>\r\n			<td style="vertical-align:baseline; width:115px">Dung lượng pin:</td>\r\n			<td style="vertical-align:baseline; width:229px">1440 mAh</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan="2" style="text-align:center; vertical-align:baseline">&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n</div>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/iphone_5_folders_hero.jpg,http://localhost/SmartShop/files/b3c1c1567fef3f22ede1fc0e6ef79837/images/vi.jpg.gif', '190000.00', '18000000.00', '17500000.00', '1404061200', '1404061200', NULL, NULL, 200, NULL, 'iphone-5-16', 'Iphone 5,apple,Hàng khuyến mại,hàng hot', 63, 1403719437, 2),
(17, 'R-V720PG1 ', 'Tủ lạnh Hitachi', '<p><span style="color:rgb(34, 34, 34); font-family:arial,helvetica,sans-serif; font-size:small">Tủ lạnh Hitachi R-V720PG1 600 l&iacute;t ngăn đ&aacute; tr&ecirc;n 2 cửa với hệ thống l&agrave;m lạnh nhanh khắp tủ v&agrave; giữ kh&ocirc;ng kh&iacute; lạnh đều to&agrave;n diện c&ugrave;ng với hệ thống khử m&ugrave;i, kh&aacute;ng khuẩn loại bỏ ho&agrave;n to&agrave;n vi khuẩn, nấm mốc v&agrave; kh&ocirc;ng g&acirc;y m&ugrave;i kh&oacute; chịu. Với những t&iacute;nh năng tiện lợi của chiếc tủ lạnh n&agrave;y, bạn ho&agrave;n to&agrave;n y&ecirc;n t&acirc;m khi sử dụng những thức ăn, đồ uống được chứa trong tủ lạnh.</span></p>\r\n', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<table border="1" cellpadding="5" cellspacing="0" style="border:1px solid rgb(237, 237, 237); color:rgb(34, 34, 34); font-family:arial,helvetica,sans-serif; font-size:12px; line-height:normal; margin:0px; padding:0px; width:796px">\r\n	<tbody>\r\n		<tr>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">Kiểu tủ</span></td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">Ngăn đ&aacute; tr&ecirc;n</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Số cửa</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">2 cửa</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Tổng dung t&iacute;ch</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">600 l&iacute;t</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Dung t&iacute;ch ngăn đ&aacute;</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">&nbsp;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Dung t&iacute;ch ngăn lạnh</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">&nbsp;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">C&ocirc;ng nghệ l&agrave;m lạnh</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">Quạt k&eacute;p</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Chống đ&oacute;ng tuyết</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">C&oacute;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Kh&aacute;ng Khuẩn, Khử m&ugrave;i</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">C&oacute;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Chất liệu khay ngăn</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">&nbsp;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Chu&ocirc;ng B&aacute;o Mở cửa qu&aacute; l&acirc;u</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">&nbsp;</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan="4">\r\n			<div style="margin: 0px; padding: 0px;"><strong><span style="font-family:arial,helvetica,sans-serif; font-size:small">Th&ocirc;ng tin chung</span></strong></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">K&iacute;ch thước</span></td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">910 x 810 x 1835</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Khối lượng</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">95 Kg</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div style="margin: 0px; padding: 0px;"><span style="font-family:arial,helvetica,sans-serif; font-size:small">Nơi sản xuất</span></div>\r\n			</td>\r\n			<td><span style="font-family:arial,helvetica,sans-serif; font-size:small">Nhật Bản</span></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/files/1721_0_tu_lanh_hitachi_r_v720pg1_4.jpg', '0.00', '19000000.00', '17500000.00', '1403715600', '1406739600', NULL, NULL, 10, NULL, 'tu-lanh-hitachi-17', 'Tủ lạnh,hitachi', 69, 1403719661, 1),
(18, 'AASD-21313123', 'Sản phẩm test', '<p>Test</p>\r\n', '', 'http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/2014-06-24_090447.png,http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/vi.jpg.gif,http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/vi(2).jpg.gif,http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/Vector%20Smart%20Object.png', '10000.00', '11000.00', '10500.00', '1404320400', '1406221200', NULL, NULL, 12, NULL, 'san-pham-test-18', 'Test sản phẩm', 66, 1404101197, 1),
(19, 'Iphone-123456789', 'Iphone 6', '<p>sdfasdfdsaafsd</p>\r\n', '', '', '0.00', '0.00', '0.00', '0', '0', NULL, NULL, 0, NULL, 'iphone-6-19', 'sdfdsf', 72, 1404449994, 2),
(20, 'Iphone-1234567891', 'Iphone 6', '<p>sdfsdffsd</p>\r\n', '', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/Shuffle1.png', '3243340.00', '324324344.00', '234234234.00', '1404406800', '1404406800', NULL, NULL, 0, NULL, 'iphone-6-20', 'sdfsdf', 63, 1404450020, 1),
(21, 'TuLanh-04', 'Tủ lạnh Hitachi', '<p>Tủ lạnh hitachi m&ocirc; tả</p>\r\n', '<p>Thuộc t&iacute;nh tủ lạnh hitachi</p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/aston-martin-lagonda-1-6954-1403494788.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/160815-Xe-dap-2-1474-1403693677.jpg', '1000000.00', '5000000.00', '4000000.00', '1404838800', '1404838800', NULL, NULL, 10, NULL, 'tu-lanh-hitachi-21', 'tủ lanh,hitachi', 69, 1404460813, 1),
(22, 'Jean-03', 'Quần Jean', 'M&ocirc; tả', 'a', 'http://localhost/SmartShop/files/30513e50e257d483ad748ad448cb36d9/files/03_single_shop.jpg,http://localhost/SmartShop/files/30513e50e257d483ad748ad448cb36d9/files/04_shop.jpg,http://localhost/SmartShop/files/30513e50e257d483ad748ad448cb36d9/files/04_single_shop.jpg', '1000000.00', '2000000.00', '1800000.00', '1404838800', '1404838800', NULL, NULL, 36, NULL, 'quan-jean-22', 'Jean,Trung quốc', 64, 1404900679, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

DROP TABLE IF EXISTS `tbl_product_category`;
CREATE TABLE IF NOT EXISTS `tbl_product_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cateName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cateParent` int(11) DEFAULT NULL,
  `cateSlug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cateDescription` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cateSlug` (`cateSlug`),
  UNIQUE KEY `cateSlug_2` (`cateSlug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=103 ;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `cateName`, `cateParent`, `cateSlug`, `cateDescription`, `time`, `status`) VALUES
(65, 'Quần áo', 0, 'quan-ao', 'Quần áo', 1403718097, 1),
(66, 'Quần nam', 65, 'quan-nam', 'Quần nam', 1403718107, 1),
(67, 'Áo nam', 65, 'ao-nam', 'Áo nam', 1403718119, 1),
(68, 'Quần nữ', 65, 'quan-nu', 'quần nữ', 1403718129, 1),
(69, 'Áo nữ', 65, 'ao-nu', 'áo nữ', 1403718141, 1),
(70, 'Váy', 65, 'vay', 'Váy công sở', 1403718153, 1),
(71, 'Quần leging nữ', 65, 'quan-leging-nu', 'leging nữ', 1403718180, 1),
(72, 'Đồ điện tử', 0, 'do-dien-tu', 'toàn bộ đồ điện tử', 1403718196, 1),
(73, 'Quạt điện', 72, 'quat-dien', 'quạt', 1403718207, 1),
(74, 'Đèn led', 72, 'den-led', 'đèn led', 1403718222, 1),
(75, 'Nồi cơm điện', 72, 'noi-com-dien', 'nồi cơm điện', 1403718234, 1),
(76, 'Điều hòa', 72, 'dieu-hoa', 'Điều hòa', 1403718244, 1),
(77, 'Tủ lạnh', 72, 'tu-lanh', 'tủ lạnh', 1403718253, 1),
(78, 'Máy giặt', 72, 'may-giat', 'máy giặt', 1403718264, 1),
(79, 'Đồ công nghệ', 0, 'do-cong-nghe', 'đồ công nghệ', 1403718279, 1),
(80, 'Điện thoại', 79, 'dien-thoai', 'điện thoại', 1403718289, 1),
(81, 'Laptop', 79, 'laptop', 'laptop', 1403718299, 1),
(82, 'Tablet', 79, 'tablet', 'tablet', 1403718316, 1),
(83, 'Phương tiện đi lại', 0, 'phuong-tien-di-lai', 'phương tiện đi lại', 1403718335, 1),
(84, 'Ô tô', 83, 'o-to', 'ô tô', 1403718351, 1),
(85, 'Xe máy', 83, 'xe-may', 'xe máy', 1403718361, 1),
(86, 'Xe đạp', 83, 'xe-dap', 'xe đạp', 1403718370, 1),
(87, 'Lương thực thực phẩm', 0, 'luong-thuc-thuc-pham', 'lương thực thực phẩm', 1403718390, 1),
(88, 'Lương thực', 87, 'luong-thuc', 'lương thực', 1403718404, 1),
(89, 'Thực phẩm', 87, 'thuc-pham', 'thực phẩm', 1403718413, 1),
(90, 'Số hóa', 0, 'so-hoa', 'số hóa', 1403718431, 1),
(91, 'Thẻ điện thoại', 90, 'the-dien-thoai', 'thẻ điện thoại', 1403718443, 1),
(92, 'Thẻ game', 90, 'the-game', 'thẻ game', 1403718452, 1),
(93, 'Thẻ K+', 90, 'the-k', 'thẻ K+', 1403718463, 1),
(94, 'Nội thất', 0, 'noi-that', 'nội thất', 1403718483, 1),
(95, 'Bàn ghế', 94, 'ban-ghe', 'bàn ghế', 1403718494, 1),
(96, 'Giường tủ', 94, 'giuong-tu', 'giường tủ', 1403718506, 1),
(97, 'Ngoại thất', 0, 'ngoai-that', 'Ngoại thất', 1403718521, 1),
(98, 'Cây cảnh', 97, 'cay-canh', 'cây cảnh', 1403718533, 1),
(99, 'Bàn ghế ngoại thất', 97, 'ban-ghe-ngoai-that', 'bàn ghế ngoại thất', 1403718577, 1),
(100, 'Hàng khuyến mại', 0, 'hang-khuyen-mai', 'hàng đang khuyến mại', 1403718978, 1),
(101, 'Hàng hot', 0, 'hang-hot', 'hot', 1403718986, 1),
(102, 'Hàng mới', 0, 'hang-moi', 'hàng mới', 1403719002, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_manufacturer`
--

DROP TABLE IF EXISTS `tbl_product_manufacturer`;
CREATE TABLE IF NOT EXISTS `tbl_product_manufacturer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturerName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturerDescription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturerPlace` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturerLogo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Dumping data for table `tbl_product_manufacturer`
--

INSERT INTO `tbl_product_manufacturer` (`id`, `manufacturerName`, `manufacturerDescription`, `manufacturerPlace`, `manufacturerLogo`, `time`, `status`) VALUES
(58, 'D&G', 'toàn bộ sản phẩm D&G', 'trung quốc', 'http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/Vector%20Smart%20Object.png', 1403717851, 1),
(59, 'H&M', 'toàn bộ sản phẩm H&M', 'trung quốc', NULL, 1403717870, 1),
(60, 'Zara', 'Toàn bộ sản phẩm Zara', 'Trung quốc', NULL, 1403717898, 1),
(61, 'Luis Viuton', 'Toàn bộ sản phẩm Luis Viutons', 'Việt nam', NULL, 1403717928, 1),
(62, 'Dell', 'Sản phẩm Dell', 'trung quốc', NULL, 1403717943, 1),
(63, 'Apple', 'Toàn bộ sản phẩm Apple', 'Trung quốc', 'http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/vi.jpg.gif', 1403717957, 1),
(64, 'Espirits', 'Sản phẩm của Espirits', 'Thái lan', NULL, 1403717989, 1),
(65, 'Hải hà kotobuki', 'bánh kẹo hải hà', 'Việt nam', NULL, 1403718017, 1),
(66, 'Euro window', 'Sản phẩm cửa nhựa', 'Việt nam', NULL, 1403718042, 1),
(67, 'Panasonic', 'sản phẩm panasonic', 'Trung quốc', NULL, 1403718067, 1),
(68, 'Samsung', 'toàn bộ sản phẩm samsung', 'Việt nam', NULL, 1403718082, 1),
(69, 'Hitachi', '', 'Trung quốc', NULL, 1403719558, 1),
(72, 'sđsf', '', 'ff23f23', NULL, 1404449982, 1),
(73, 'Sony', '', 'china', NULL, 1404796255, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_meta`
--

DROP TABLE IF EXISTS `tbl_product_meta`;
CREATE TABLE IF NOT EXISTS `tbl_product_meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_values` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_product_meta`
--

INSERT INTO `tbl_product_meta` (`id`, `product_id`, `meta_key`, `meta_values`, `time`, `status`) VALUES
(7, 22, '', 'a:3:{s:5:"color";s:1:"7";s:4:"size";s:1:"2";s:8:"quantity";s:2:"12";}', 1404901016, NULL),
(8, 22, '', 'a:3:{s:5:"color";s:1:"8";s:4:"size";s:1:"2";s:8:"quantity";s:2:"12";}', 1404901016, NULL),
(9, 22, '', 'a:3:{s:5:"color";s:2:"12";s:4:"size";s:1:"2";s:8:"quantity";s:2:"12";}', 1404901016, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_order`
--

DROP TABLE IF EXISTS `tbl_product_order`;
CREATE TABLE IF NOT EXISTS `tbl_product_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `receiverName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiverPhone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderAddress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_product_order`
--

INSERT INTO `tbl_product_order` (`id`, `orderCode`, `user_id`, `receiverName`, `receiverPhone`, `orderAddress`, `payment_type`, `time`, `status`) VALUES
(1, 'Pubweb-1', 3, 'Ngô quang huy', '0989333537', '40 Hòa bình 2', 0, 1401019932, 1),
(2, 'Pubweb-2', 3, 'adkadkj', '123456432', 'àdsgsgs', 1, 1401106332, 0),
(3, 'Pubweb-3', 3, 'ádsfasf', '11231231', 'sadasd12412', 0, 1401192732, 0),
(4, 'Pubweb-4', 3, '12asdasd', '12312312', 'dâfasdasd', 1, 1401279132, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_order_detail`
--

DROP TABLE IF EXISTS `tbl_product_order_detail`;
CREATE TABLE IF NOT EXISTS `tbl_product_order_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `productPrice` decimal(20,2) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_product_order_detail`
--

INSERT INTO `tbl_product_order_detail` (`id`, `order_id`, `product_id`, `productPrice`, `amount`, `total`, `time`, `status`) VALUES
(1, 1, 13, '234567.00', 1, '100000.00', 1234567, 1),
(2, 1, 13, '123123.00', 1, '500000.00', 1234543234, 1),
(3, 2, 14, '100000.00', 1, '100000.00', 123123123123, 1),
(4, 2, 14, '500000.00', 1, '500000.00', 123123123, 1),
(5, 3, 15, '200000.00', 1, '200000.00', 12312312313, 1),
(6, 4, 15, '20000.00', 3, '60000.00', 123123123132, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_views`
--

DROP TABLE IF EXISTS `tbl_product_views`;
CREATE TABLE IF NOT EXISTS `tbl_product_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `category_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=208 ;

--
-- Dumping data for table `tbl_product_views`
--

INSERT INTO `tbl_product_views` (`id`, `product_id`, `category_product_id`) VALUES
(130, 13, 68),
(131, 14, 101),
(132, 14, 100),
(133, 14, 102),
(134, 14, 65),
(135, 14, 69),
(153, 17, 79),
(154, 17, 72),
(155, 17, 77),
(156, 17, 101),
(157, 17, 100),
(158, 17, 102),
(159, 18, 79),
(160, 18, 80),
(166, 16, 79),
(167, 16, 80),
(168, 16, 101),
(169, 16, 100),
(170, 16, 102),
(171, 19, 79),
(181, 21, 79),
(182, 21, 80),
(183, 21, 81),
(184, 21, 82),
(185, 21, 72),
(186, 21, 77),
(187, 21, 101),
(188, 21, 100),
(189, 21, 102),
(202, 22, 79),
(203, 22, 96),
(204, 22, 71),
(205, 22, 66),
(206, 22, 68),
(207, 22, 70);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_wishlist`
--

DROP TABLE IF EXISTS `tbl_product_wishlist`;
CREATE TABLE IF NOT EXISTS `tbl_product_wishlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects`
--

DROP TABLE IF EXISTS `tbl_projects`;
CREATE TABLE IF NOT EXISTS `tbl_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `projectDescription` longtext COLLATE utf8_unicode_ci,
  `projectContent` longtext COLLATE utf8_unicode_ci,
  `img` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_projects`
--

INSERT INTO `tbl_projects` (`id`, `projectName`, `from`, `to`, `projectDescription`, `projectContent`, `img`, `time`, `status`) VALUES
(2, 'Dự án 3', '1398877200', '1400173200', '<p>M&ocirc; tả dự &aacute;n 3</p>\r\n', '<p>Nội dung dự &aacute;n 3</p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/aston-martin-lagonda-1-6954-1403494788.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/gold-bloomberg-8969-1403571279.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/masan_tech11_48_35_000000.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/160815-Xe-dap-2-1474-1403693677.jpg', 1401356926, 2),
(3, 'Dự án 2', '1398877200', '1400173200', '<p>M&ocirc; tả dự &aacute;n 2</p>\r\n', '<p>Nội dung dự &aacute;n 2</p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/160815-Xe-dap-2-1474-1403693677.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/masan_tech11_48_35_000000.jpg', 1401356948, 1),
(4, 'Dự án 1', '1401814800', '1403110800', '<p>M&ocirc; tả dự &aacute;n 1</p>\r\n', '<p>Nội dung dự &aacute;n 1</p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/aston-martin-lagonda-1-6954-1403494788.jpg,http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/gold-bloomberg-8969-1403571279.jpg', 1401968957, 1),
(5, 'lkjhgfd', '1404147600', '1406134800', '<p>ffdfd</p>\r\n', '<p>dfdf</p>\r\n', '', 1404450473, 0),
(6, 'Dự án 3', '1404234000', '1405530000', '<p>&agrave;dsghfdfsdg</p>\r\n', '<p>sdffsadfasd</p>\r\n', 'http://localhost/SmartShop/files/c3b1dcd82af38ea22972a8cacbb68f07/images/aston-martin-lagonda-1-6954-1403494788.jpg', 1404461188, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

DROP TABLE IF EXISTS `tbl_setting`;
CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settingKey` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settingValue` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `settingKey`, `settingValue`, `time`, `status`) VALUES
(1, '_settingsite', 'a:27:{s:12:"titlewebsite";s:24:"Trang admin tổng hợp";s:7:"tagline";s:0:"";s:11:"description";s:18:"Pubweb - free site";s:13:"keywordsearch";s:12:"xxxxxxxxxxxx";s:8:"smtphost";s:7:"sdfghjk";s:8:"smtpport";s:0:"";s:8:"frommail";s:0:"";s:8:"fromname";s:0:"";s:12:"usernamemail";s:0:"";s:12:"passwordmail";s:0:"";s:10:"baokimuser";s:0:"";s:13:"nganluonguser";s:0:"";s:6:"tiente";s:4:"VNĐ";s:11:"logowebsite";s:86:"http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/vi(1).jpg.gif";s:6:"footer";s:217:"<p>asdfghjkl;kjhgfdsaSDFGKJL;KJHGFDASDFGHJKL;&#39;LKJGFD&aacute;dasd<img alt="" src="/SmartShop/uploadimg/ed648ac60605bf74e283dbeef41dc830/images/Vector%20Smart%20Object.png" style="height:173px; width:891px" /></p>\r\n";s:9:"tencongty";s:6:"BUFFCO";s:12:"diachicongty";s:20:"Ngõ Chùa Hưng Ký";s:17:"sodienthoaicongty";s:6:"ádfgh";s:19:"sodienthoaiddcongty";s:5:"ádfg";s:11:"emailcongty";s:5:"sadfg";s:9:"webcongty";s:9:"sadsadasd";s:15:"facebookfanpage";s:7:"dfsfsdf";s:9:"commentfb";s:1:"1";s:9:"googleanc";s:13:"2345678976543";s:10:"googlemaps";s:142:"https://www.google.com/maps/place/Ch%C3%B9a+H%C6%B0ng+K%C3%BD/@20.9945544,105.8550815,19z/data=!4m2!3m1!1s0x3135ac128c3ada83:0xcb1aa11230af3ba";s:8:"slideimg";s:187:"http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/Vector%20Smart%20Object.png,http://localhost/SmartShop/files/ed648ac60605bf74e283dbeef41dc830/images/vi(1).jpg.gif";s:10:"menuheader";s:1:"8";}', 1404465905, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supporter`
--

DROP TABLE IF EXISTS `tbl_supporter`;
CREATE TABLE IF NOT EXISTS `tbl_supporter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supporterGroupID` int(11) DEFAULT NULL,
  `supporterName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supporterNickYH` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supporterNickSkype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supporterPhone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_supporter`
--

INSERT INTO `tbl_supporter` (`id`, `supporterGroupID`, `supporterName`, `supporterNickYH`, `supporterNickSkype`, `supporterPhone`, `time`, `status`) VALUES
(17, 16, 'Ngô quang huy', 'huy_yahoo', 'huy_skype', '0989333537', 1404451033, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supporter_group`
--

DROP TABLE IF EXISTS `tbl_supporter_group`;
CREATE TABLE IF NOT EXISTS `tbl_supporter_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supporterGroupName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_supporter_group`
--

INSERT INTO `tbl_supporter_group` (`id`, `supporterGroupName`, `time`, `status`) VALUES
(13, 'Kinh doanh', 1403720227, 1),
(16, 'Chăm sóc khách hàng', 1403720249, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateofbirth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `email`, `password`, `firstname`, `lastname`, `dateofbirth`, `address`, `phone`, `verify`, `remember_token`, `time`, `status`, `admin`, `roles`, `created_at`, `updated_at`) VALUES
(1, 'anhntseo@gmail.com', '$2y$10$jBeyAJrBpZ3YP9YEVEgiYe7yAQINxMfFrOmpKBpV.wUHC9njscbxK', 'Nguyen', 'Anh', '-25200', 'Địa chỉ demo', '1234567897654', NULL, 'Ehc08sMaTkEnWNfOIT8JN8f9xv73JsECKUA7IPlcUATfMbNurPCjTj3bdJb5', 123456, 1, 1, 'a:11:{i:0;s:14:"NewsController";i:1;s:17:"ProductController";i:2;s:15:"OrderController";i:3;s:19:"SupporterController";i:4;s:14:"UserController";i:5;s:14:"PageController";i:6;s:15:"MenusController";i:7;s:17:"ProjectController";i:8;s:21:"HistoryUserController";i:9;s:18:"FeedbackController";i:10;s:13:"StatisticView";}', '2014-05-21 09:38:36', '2014-07-08 05:15:51'),
(2, 'tuananh@gmail.com', '$2y$10$5NXPujl7JKElMhtLae0Axu89LG9XfGMUT7bQqSLV7DFBP91d1lo2y', 'Nguyen', 'Tuan', '2653200', 'Địa chỉ demo', '0987652134', '', 'zSZBY2dsp4TW7t7HwXsCiI1G8VSHrW5w2eAC43StRp6oxWsDxUPO5nIw9dBd', 1400127013, 1, 1, NULL, '2014-05-21 09:38:36', '2014-06-26 05:08:06'),
(3, 'huy@gmail.com', '$2y$10$qXJDessXh66RSp/mSuO4Yuq0HB7z3v5ddiPxuGPgHuxaXsQBWODci', 'Ngô', 'Quang Huy', '2653200', '', '', '', '', 1400127246, 1, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:36:53'),
(4, 'huy1@gmail.com', '$2y$10$19mQRnA5Esd2G/cvV0GiSOAH881JexnAmW6VW3bNQ9FURwvjLcZxu', 'Ngô', 'Quang Huy', '123456', '', '', '', '', 1400127282, 1, 0, NULL, '2014-05-21 09:38:36', '0000-00-00 00:00:00'),
(5, 'huy2@gmail.com', '$2y$10$0d6T9t7cN/xxNwmdU.XVdO3rhp6BQpmIKYLjh/1ZWK7XesvEvYYT2', 'Ngô', 'Quang Huy', '123456', '', '', '', '', 1400127367, 1, 0, NULL, '2014-05-21 09:38:36', '0000-00-00 00:00:00'),
(6, 'huy22@gmail.com', '$2y$10$GX9w1bkC8HfbROtEPRfzTeSEJo7mw4WWYb1HJyawXFO0AbX8WFBmu', 'Ngô', 'Quang Huy', '123456', '', '', '', '', 1400127464, 1, 0, NULL, '2014-05-21 09:38:36', '0000-00-00 00:00:00'),
(7, 'huy222@gmail.com', '$2y$10$x4gb0ASxu40acKSoyRohtulSOM.btgTFRkm4fRS1w1Z/8LtWnw5m6', 'Ngô', 'Quang Huy', '123456', '', '', '', '', 1400127548, 1, 0, NULL, '2014-05-21 09:38:36', '0000-00-00 00:00:00'),
(8, 'huy2222@gmail.com', '$2y$10$ewWdt5HkJQH4ez550GMDvug647nr145006Lg.Td5ScM6rzIAzADrq', 'Ngô', 'Quang Huy', '2653200', 'fsdfsdfsdf', '', '', '', 1400127664, 1, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 04:20:25'),
(9, 'werwerwer@yahoo.com', '$2y$10$lhqHyGDkbiE139b5ICBD9.71qizp8sxu1UvXVL4GD6oQNUsoXUz1a', 'Ngo Quang', 'Huy', '61200', '40 hòa bình 2', '84989333537', '', '', 1400129178, 0, 0, NULL, '2014-05-21 09:38:36', '2014-06-25 18:11:43'),
(10, 'dasda2345sd@gmail.com', '$2y$10$C8JPCIJerz2Xr1scxY6DSOz23h1peWfgxH5MiocpUzazkwvi3R.BK', 'sdfghjk', 'asdfgh', '2653200', 'vbnm,./', 'er567890-ơ=ư\\', '', '', 1400129215, 1, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:33:18'),
(11, 'admi23456n@gmail.com', '$2y$10$tOU899bmRQKzuTd0Gc.SjOpYqRPJT3gaLIbRzEM5mU7/xiwe9oR9W', 'Nguyendfgh', 'Quang Huy', '123456', '213456', '4567y', '', '', 1400141417, 2, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:32:27'),
(12, 'admin1@gmail.com', '$2y$10$7v/yCtWWlhmcjCq7nRiYpuB7tj.Dj/Yavmsy8T4oXY2Pxa9wQxRQO', 'Nguyễn', 'Tuấn Anh', '123456', 'Hà nội việt nam lào ', '093743648', '', '', 1400144862, 2, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:32:32'),
(13, 'dasdasdsfsdd@gmail.com', '$2y$10$3yuBI7Ow.VKr87OLdCDwI.2gpHczKjEjmmdQolGN1clVUS428BrAK', 'ẻtdyt', 'rqwedfdf', '2653200', 'asdghjkl;jhgfdsa', 'sdfgh', '', '', 1400149522, 2, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:32:22'),
(14, 'demo1@yahoo.com', '$2y$10$taJgLcTJ.OVm2BATCmyFZOS13qr9bGm3l.zZtYiSn.NKhN/qEAV32', 'Nguyễn', 'Tuấn Anh', '2653200', '823749827409sdf sdf sdf sdf sdf sdf sdf sdf', '093284023', '', '', 1400149574, 2, 0, NULL, '2014-05-21 09:38:36', '2014-05-22 10:32:16'),
(15, 'hangladynguyen1905@gmail.com', '$2y$10$OuD5SqrRNZpIaw/EBLbVJeSIV2bvoea6R1w5fSV.Xkq4WlbNN7EaG', 'Nguyen', 'Cho Hang', '', 'kjfgkjlsjf s sfsd', '29802984203', '', '', 1400734823, 2, 0, NULL, '2014-05-22 05:00:23', '2014-05-22 10:24:15'),
(16, 'demodaica@yaho.com', '$2y$10$EoUVbFjEtpMXHMwPIVHqu.TOEuFXu.o.78YQ/.zVsZP0rF5XuDbOW', 'Nguyen Tuan Anh', 'Nguyen', '-843894000', 'cvbnm,nbvcxzcvbnmbvcxvbn345678654321', '2345y', '', '', 1400735100, 1, 0, NULL, '2014-05-22 05:05:00', '2014-05-22 10:38:42'),
(17, 'anhntseo1@gmail.com', '$2y$10$SyxLgLpB2RuTxonf78YrvueCLqzdd5gyZ4usBU6xMXM2PhCdFQMWy', 'dfghgfds', 'sdfghj', '0', 'sdfghj', 'sdfghj', '', '', 1400735130, 1, 0, NULL, '2014-05-22 05:05:30', '2014-05-22 10:38:12'),
(18, 'fghjgfd32@yahoo.com', '$2y$10$izrZneRWn9RwSNCz7prCc.w/yfmzZGVTSxB2yK7wu7wgNYzpbBSd.', '2134564', '23456432', '1400864400', '123456y', '45612345', '', '', 1400735222, 1, 0, NULL, '2014-05-22 05:07:02', '2014-05-22 10:32:43'),
(19, 'anhnt1@yahoo.com', '$2y$10$InPF/ueVu6Ib7U22FThcs.PBcwmwYH/oFpVdbI5ddvOObabvBV3nW', 'Nguyễn Tuấn', 'Anh', '0', 'Hà Nội', '0989333537', '', '', 1400735706, 1, 1, NULL, '2014-05-22 05:15:06', '2014-06-26 05:08:07'),
(20, 'anhntseo2@gmail.com', '$2y$10$Lc1Y2UN8AoM9X/O01HPY2uGohrIHsS4hOAy9kNKeikLzg89cpTIPa', 'Nguyễn', 'TuấN Anh', '0', '12345trew', '12345', '', '', 1400742134, 1, 1, NULL, '2014-05-22 07:02:14', '2014-06-26 05:07:54'),
(21, 'demo123456789@yahoo.com', '$2y$10$kjvrD7gfMlzkBdfONvj.m.nH4QCupvRYf2Vt6W/mqBpjS/BGgzv0a', 'sđsađá', 'sadfghk', '1399222800', '2134567890', '456789', '', '', 1400750565, 1, 0, NULL, '2014-05-22 09:22:45', '2014-07-07 08:55:33'),
(22, 'fghjg4566fd32@yahoo.com', '$2y$10$3aFUSo2OTlIzzMBzTh7UuuKAyCfQcc9ekU2m74izkAl152feQdxXq', '43567', '24356', '0', '', 'ẻwerwer', '', '', 1400754895, 2, 0, NULL, '2014-05-22 10:34:55', '2014-06-25 18:10:44'),
(23, 'anhntseo2345@gmail.com', '$2y$10$WXzks1Yc8wHRrG.P5ZCbqOFW2Sf0TP6mf.GDI7IyIsFNir2AXda4S', 'Nguyễn tuấn', 'Anh', '631299600', 'Hà Nội', '3245633333', '', '', 1400755051, 1, 0, NULL, '2014-05-22 10:37:31', '2014-06-25 18:10:38'),
(24, 'pubweb.vn@gmail.com', '$2y$10$jBeyAJrBpZ3YP9YEVEgiYe7yAQINxMfFrOmpKBpV.wUHC9njscbxK', 'Ngô Quang', 'Huy', '494096400', '40 Hòa Bình 2 Minh khai, Hà nội', '0989333537', NULL, 'MbUmCTNIDt44Nq5BSB74byAGZdPlDM1etRKoVyepwTOCEWYyTh1u0lkJo9TI', 1234567890, 5, 1, 'a:15:{i:0;s:33:"NewsController,CateNewsController";i:1;s:15:"AdminController";i:2;s:66:"CategoryProductController,ProductController,ManufacturerController";i:3;s:15:"OrderController";i:4;s:15:"StoreController";i:5;s:44:"SupporterController,SupporterGroupController";i:6;s:14:"UserController";i:7;s:14:"PageController";i:8;s:17:"SettingController";i:9;s:15:"MenusController";i:10;s:17:"ProjectController";i:11;s:21:"HistoryUserController";i:12;s:18:"FeedbackController";i:13;s:19:"StatisticController";i:14;s:13:"StatisticView";}', NULL, '2014-07-07 02:11:30'),
(25, 'pubweb.vn12@gmail.com', '$2y$10$ZJJWO6MsY7P4zmobKshR1O1KYzy6VAxrOmUMunCeWd2S.G1UhR9ki', 'Ngô Quang', 'Huy', '1386176400', 'Số 40 ngõ hòa bình 2 minh khai hà nội', '0989333537', '', '', 1402736263, 1, 1, NULL, '2014-06-14 08:57:43', '2014-06-26 05:06:58'),
(26, 'pubweb.vn23@gmail.com', '$2y$10$L7VMyI4IB7n0ax3jJsvdG.3vhPHDzE/BOXQPz6jJgOo/NgceY.3wW', 'Ngô Quang', 'Huy', '1386176400', 'Số 40 ngõ hòa bình 2 minh khai hà nội', '0989333537', '', '', 1402736726, 1, 1, NULL, '2014-06-14 09:05:26', '2014-06-16 09:20:23'),
(27, 'pubweb.vn25@gmail.com', '$2y$10$QP3HWOlfkLyLv.xSD1l7E.q2tVAGVA4dikvqSK5J9rfH4Ctu9irk2', 'Ngô Quang', 'Huy', '1402246800', 'Số 16/11 Ngõ Chùa Hưng Ký, Minh Khai, Hà nội', '0989333537', '', '', 1402736936, 1, 1, NULL, '2014-06-14 09:08:56', '2014-06-16 09:29:23'),
(28, 'pubweb.vn28@gmail.com', '$2y$10$5jZhVWf8ugi45S6T2sCn/OUxVD0WrZtQfa395dxNbxHA0qpyndwlS', 'Ngô Quang', 'Huy 12', '-25200', 'Số 16/11 Ngõ Chùa Hưng Ký, Minh Khai, Hà nội', '0989333537', '', 'ZGdqju4hLBjiUUoZr18VEfggu2gZ0X2zHENg9Y3xrqvXeDKkRHQFQU6G9QPp', 1402737116, 0, 1, NULL, '2014-06-14 09:11:56', '2014-07-04 08:11:18'),
(29, 'pubweb.vn38@gmail.com', '$2y$10$FqIoQPak65INg2/Krq2laefjsCCY22sXWyBhi15Phv8vIpK5AQb.6', 'Ngô Quang', 'Huy', '1402246800', 'Số 16/11 Ngõ Chùa Hưng Ký, Minh Khai, Hà nội', '0989333537', '', '', 1402737140, 2, 1, NULL, '2014-06-14 09:12:20', '2014-07-04 08:10:02'),
(30, 'ngoquanghuy_hn@yahoo.com.vn', '$2y$10$N0xmT4WbrigZzWYXT.kqPe1CgB7XD0lvt6vnFOX8sid4dpeObgPMy', 'Ngô Quang', 'Huy', '494096400', '40 hòa bình 2 minh khai', '0989333537', '', '', 1403714290, 1, 1, NULL, '2014-06-25 16:38:10', '2014-06-25 16:38:10'),
(31, 'test_admin@gmail.com', '$2y$10$tNrI7LY7D.Mvu0C3uVN00.EbEgnfyaDuXGCQtujQGDq1Tb6vUc4km', 'Ngô Quang', 'Huy', '494096400', '40 hòa bình 2 phố minh khai', '0989333537', '', '', 1404443403, 2, 1, NULL, '2014-07-04 03:10:03', '2014-07-04 08:10:25'),
(32, 'pubweb.vn123@gmail.com', '$2y$10$L/KuwnvMiSejfFnbyfGkkufHigz6PvT005YTSgKGx3Am6gZVTi3zi', 'Ngô Quang', 'Huy', '1404147600', '40 hòa bình 2', '0989333537', '', '', 1404443932, 2, 1, 'a:9:{i:0;s:33:"NewsController,CateNewsController";i:1;s:15:"AdminController";i:2;s:66:"CategoryProductController,ProductController,ManufacturerController";i:3;s:15:"OrderController";i:4;s:15:"StoreController";i:5;s:44:"SupporterController,SupporterGroupController";i:6;s:14:"UserController";i:7;s:14:"PageController";i:8;s:17:"SettingController";}', '2014-07-04 03:18:52', '2014-07-04 08:10:11'),
(33, 'pubweb.vn12233@gmail.com', '$2y$10$3IYiO4NQEHDQI.2qK10qtutVL4HmKh/MLvnsItR4UmTw6SW./q1IK', 'Ngô Quang', 'Huy', '1410022800', 'ádasda', '09893335371', '', '', 1404464159, 1, 1, 's:0:"";', '2014-07-04 08:55:59', '2014-07-04 08:56:13'),
(34, 'ngoquanghuyhn213@gmail.com', '$2y$10$102WSlrLnjGBh7dc.0n7ieYidO1S3t7DTJEQ2BLv8e9MBEMVwhs6u', 'Ngô Quang', 'Huy', '1406653200', 'sadasdas', '1231321231', '', '', 1404464291, 1, 1, 'a:9:{i:0;s:33:"NewsController,CateNewsController";i:1;s:66:"CategoryProductController,ProductController,ManufacturerController";i:2;s:44:"SupporterController,SupporterGroupController";i:3;s:14:"UserController";i:4;s:17:"SettingController";i:5;s:15:"MenusController";i:6;s:17:"ProjectController";i:7;s:18:"FeedbackController";i:8;s:19:"StatisticController";}', '2014-07-04 08:58:11', '2014-07-04 08:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_history`
--

DROP TABLE IF EXISTS `tbl_users_history`;
CREATE TABLE IF NOT EXISTS `tbl_users_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `historyContent` longtext COLLATE utf8_unicode_ci,
  `time` double(20,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=104 ;

--
-- Dumping data for table `tbl_users_history`
--

INSERT INTO `tbl_users_history` (`id`, `user_id`, `historyContent`, `time`, `status`) VALUES
(1, 3, '123asdasd', 1402531200, 1),
(2, 3, '1231easdasdas', 1402531000, 1),
(3, 3, '123asdasdad', 1402530900, 1),
(4, 3, 'asdasdad', 1402330900, 1),
(5, 3, 'asdasdasd', 1401530900, 1),
(6, 24, 'Cập nhật thông tin nhân viên:  anhnt1@yahoo.com', 1403756244, 1),
(7, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1403756346, 0),
(8, 24, 'Kích hoạt nhân viên:  anhntseo2@gmail.com', 1403759175, 0),
(9, 24, 'Kích hoạt nhân viên:  pubweb.vn12@gmail.com', 1403759218, 0),
(10, 24, 'Kích hoạt nhân viên:  anhntseo2@gmail.com', 1403759223, 0),
(11, 24, 'Kích hoạt nhân viên:  anhntseo2@gmail.com', 1403759274, 0),
(12, 24, 'Xóa nhân viên:  anhnt1@yahoo.com', 1403759276, 1),
(13, 24, 'Xóa nhân viên:  tuananh@gmail.com', 1403759279, 1),
(14, 24, 'Xóa nhân viên:  anhntseo@gmail.com', 1403759281, 1),
(15, 24, 'Kích hoạt nhân viên:  anhntseo@gmail.com', 1403759284, 1),
(16, 24, 'Kích hoạt nhân viên:  tuananh@gmail.com', 1403759286, 0),
(17, 24, 'Kích hoạt nhân viên:  anhnt1@yahoo.com', 1403759287, 0),
(18, 1, 'Kích hoạt sản phẩm: AASD-21313123', 1404101197, 0),
(19, 1, 'Cập nhật sản phẩm: IPHONE-5', 1404120018, 0),
(20, 1, 'Cập nhật sản phẩm: IPHONE-5', 1404120040, 0),
(21, 1, 'Xoá nhà sản xuất : 70', 1404271685, 2),
(22, 1, 'Xoá nhà sản xuất : 71', 1404271688, 2),
(23, 1, 'Cập nhật nhà sản xuất : Apple', 1404290089, 0),
(24, 1, 'Cập nhật nhà sản xuất : D&G', 1404291077, 0),
(25, 24, 'Cập nhật thông tin cá nhân: ', 1404441870, 0),
(26, 24, 'Cập nhật thông tin cá nhân: ', 1404441991, 0),
(27, 24, 'Cập nhật thông tin cá nhân: ', 1404442013, 0),
(28, 24, 'Cập nhật thông tin cá nhân: ', 1404442123, 1),
(29, 24, 'Thêm mới nhân viên:  test_admin@gmail.com', 1404443403, 0),
(30, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn123@gmail.com', 1404444720, 0),
(31, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn123@gmail.com', 1404444760, 0),
(32, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn123@gmail.com', 1404445053, 0),
(33, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn123@gmail.com', 1404445061, 0),
(34, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1404445432, 0),
(35, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1404445891, 0),
(36, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404446050, 0),
(37, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404446060, 0),
(38, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404446070, 0),
(39, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404446110, 1),
(40, 1, 'Cập nhật thông tin cá nhân: ', 1404446126, 2),
(41, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404448028, 2),
(42, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1404448067, 0),
(43, 24, 'Cập nhật danh mục tin tức: Chuyên mục world cup', 1404449593, 0),
(44, 24, 'Cập nhật tin tức: Hệ thống định vị Trung Quốc', 1404449698, 0),
(45, 24, 'Thêm mới danh mục tin tức: chuyen-muc-world-cup', 1404449752, 0),
(46, 24, 'Thêm mới danh mục tin tức: chuyen-muc-world-cup2014', 1404449782, 0),
(47, 24, 'Thêm mới tin tức: Tiến sĩ Nguyễn Nhã: ''Cơ hội thoát Trung ngàn năm có một', 1404449882, 0),
(48, 24, 'Thêm mới nhà sản xuất : sđsf', 1404449983, 0),
(49, 24, 'Kích hoạt sản phẩm: Iphone-123456789', 1404449994, 0),
(50, 24, 'Kích hoạt sản phẩm: Iphone-1234567891', 1404450020, 0),
(51, 24, 'Cập nhật sản phẩm: Iphone-1234567891', 1404450088, 0),
(52, 24, 'Cập nhật sản phẩm: Iphone-1234567891', 1404450114, 0),
(53, 24, 'Xóa đơn hàng:  Pubweb-2', 1404450204, 0),
(54, 24, 'Cập nhật hỗ trợ viên: Nguyễn tuấn anh', 1404450265, 0),
(55, 24, 'Cập nhật nhóm hỗ trợ viên: Kỹ thuật', 1404450281, 0),
(56, 24, 'Cập nhật thông tin cá nhân: ', 1404450327, 0),
(57, 24, 'Thêm mới dự ánlkjhgfd', 1404450473, 0),
(58, 24, 'Thêm mới hỗ trợ viên : Ngô quang huy', 1404451033, 0),
(59, 24, 'Thêm mới hỗ trợ viên : Hà ngọc quân', 1404451050, 0),
(60, 24, 'Cập nhật hỗ trợ viên: Hà ngọc quân', 1404451057, 0),
(61, 24, 'Cập nhật thông tin cá nhân: ', 1404452043, 0),
(62, 24, 'Cập nhật thông tin cá nhân: ', 1404452123, 0),
(63, 24, 'Cập nhật thông tin cá nhân: ', 1404459856, 0),
(64, 24, 'Thêm mới danh mục tin tức: tin-chau-my', 1404460535, 0),
(65, 24, 'Xoá danh mục tin tức: Tin châu mỹ', 1404460540, 0),
(66, 24, 'Thêm mới danh mục tin tức: tin-chau-my', 1404460553, 0),
(67, 24, 'Cập nhật danh mục tin tức: Tin châu mỹ', 1404460564, 0),
(68, 24, 'Xoá sản phẩm: Iphone-123456789', 1404460673, 0),
(69, 24, 'Kích hoạt sản phẩm: TuLanh-04', 1404460813, 0),
(70, 24, 'Xóa phản hồi : 1', 1404460861, 0),
(71, 24, 'Xử lý đơn hàng:  Pubweb-2', 1404460884, 0),
(72, 24, 'Xử lý đơn hàng:  Pubweb-4', 1404461145, 0),
(73, 24, 'Thêm mới dự ánDự án 3', 1404461188, 0),
(74, 24, 'Cập nhật PageTrang con', 1404461327, 0),
(75, 24, 'Xóa nhân viên:  pubweb.vn38@gmail.com', 1404461402, 0),
(76, 24, 'Xóa nhân viên:  pubweb.vn123@gmail.com', 1404461411, 0),
(77, 24, 'Xóa nhân viên:  test_admin@gmail.com', 1404461425, 0),
(78, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn28@gmail.com', 1404461478, 0),
(79, 24, 'Xóa nhóm menu : ', 1404461575, 0),
(80, 24, 'Thêm mới menu : gfghfghf', 1404461597, 0),
(81, 24, 'Xoá menu : ', 1404461607, 0),
(82, 24, 'Cập nhật menu : 2332', 1404461618, 0),
(83, 24, 'Cập nhật menu : 2332', 1404461623, 0),
(84, 24, 'Thêm mới nhân viên:  pubweb.vn12233@gmail.com', 1404464159, 0),
(85, 24, 'Cập nhật thông tin nhân viên:  pubweb.vn12233@gmail.com', 1404464173, 0),
(86, 24, 'Thêm mới nhân viên:  ngoquanghuyhn213@gmail.com', 1404464291, 0),
(87, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404471698, 2),
(88, 1, 'Cập nhật thông tin nhân viên:  pubweb.vn@gmail.com', 1404471771, 1),
(89, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1404471824, 1),
(90, 0, 'Cập nhật thông tin cá nhân: ', 1404698644, 0),
(91, 0, 'Cập nhật thông tin cá nhân: ', 1404698700, 0),
(92, 24, 'Cập nhật thông tin cá nhân: ', 1404698770, 1),
(93, 24, 'Cập nhật thông tin cá nhân: ', 1404698806, 0),
(94, 24, 'Cập nhật thông tin cá nhân: ', 1404699090, 1),
(95, 24, 'Khóa tài khoản:  demo123456789@yahoo.com', 1404723330, 0),
(96, 24, 'Kích hoạt khách hàng:  demo123456789@yahoo.com', 1404723333, 0),
(97, 24, 'Trả lời phản hồi : ngoquanghuyhn@gmail.com', 1404723669, 0),
(98, 24, 'Thêm mới nhà sản xuất : Sony', 1404796255, 0),
(99, 24, 'Cập nhật thông tin nhân viên:  anhntseo@gmail.com', 1404796551, 0),
(100, 1, 'Cập nhật sản phẩm: TuLanh-04', 1404872573, 0),
(101, 24, 'Kích hoạt sản phẩm: Jean-03', 1404900679, 0),
(102, 24, 'Cập nhật sản phẩm: Jean-03', 1404901001, 0),
(103, 24, 'Cập nhật sản phẩm: Jean-03', 1404901016, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
