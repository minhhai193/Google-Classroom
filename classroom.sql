-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th3 02, 2021 lúc 02:13 PM
-- Phiên bản máy phục vụ: 10.3.16-MariaDB
-- Phiên bản PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `id15472119_classroom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '2',
  `active` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`user_id`, `username`, `password`, `email`, `name`, `role`, `active`, `token`) VALUES
(77, 'admin', '$2y$10$WThKdUWCY353ngLfgtjW5ec.pDMCERk30RkbLfjhRUeP6TU36iyq.', 'cntt@tdtu.edu.vn', 'Khoa CNTT', '0', 1, 'fd757a91'),
(105, 'pnts1999', '$2y$10$x6olKUB4/Jb0LemdcFzBCu7l/C2w2qFzt2gYsKnM3CCJnDWET1Erq', 'pnts1999@gmail.com', 'Sang Pham', '2', 0, 'a44f96ee'),
(107, 'vddat09', '$2y$10$ze2fICw05qxt/cUyylqPfObNxBG6XAL9kLz21X8ukjT3rqn93U75K', 'dinhdat187199@gmail.com', 'Vũ Đình Đạt', '2', 0, '52c7f82d'),
(108, 'hcthanh99', '$2y$10$P6zK5lfld.AR/D9d3deuE.WkllkrAqwcjnv0H7doTRf1nY/wn.Fwq', 'fifapro194@gmail.com', 'Hồng Cơ Thành', '2', 0, 'bf33c018'),
(109, 'luanle99', '$2y$10$ZuD89oRCj5VlxnIMhVwVyOW.OR.XHFwQ2/Z8x98jxldeUxgeT1Xce', 'luanle02468@gmail.com', 'Lê Hữu Luân', '2', 0, '8d1653a2'),
(110, 'mvmanh', '$2y$10$TD5wM0a69wbNBJxNeAwLd.HK4y50TyUKr39LF7eOl38.fM3MWhizC', 'mvmanh@gmail.com', 'Mai Van Manh', '1', 1, '360ec7ef'),
(113, 'admin', '$2y$10$jX3o5M4eYCyF/RueRQn13e.RFzwcTsChHUTy1i9E0pn7.eBXdYFTq', 'admin@gmail.com', 'Mai Van Manh', '0', 0, '741ca2f6'),
(114, 'hcnghiep99', '$2y$10$ana1w5b51kzPTqsnchx8FuCDicfEiCZ5hnzV4Q8/6KKkQLWNi/mY6', 'hcnghiep99@gmail.com', 'Hồng Cơ Nghiệp', '2', 1, '4246605b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classroom`
--

CREATE TABLE `classroom` (
  `classroom_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `description` text COLLATE utf8_vietnamese_ci NOT NULL,
  `staring_date` date DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `classroom_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `component_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `component`
--

CREATE TABLE `component` (
  `component_id` int(11) NOT NULL,
  `classroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL,
  `material` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timeline` datetime NOT NULL DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `people`
--

CREATE TABLE `people` (
  `people_id` int(11) NOT NULL,
  `classroom_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `passed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submission`
--

CREATE TABLE `submission` (
  `classroom_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `component_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `timeline` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`classroom_id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Chỉ mục cho bảng `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`component_id`,`classroom_id`,`user_id`);

--
-- Chỉ mục cho bảng `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`people_id`,`classroom_id`,`user_id`);

--
-- Chỉ mục cho bảng `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`classroom_id`,`component_id`,`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT cho bảng `component`
--
ALTER TABLE `component`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `people`
--
ALTER TABLE `people`
  MODIFY `people_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
