-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-02 03:03:41
-- 服务器版本： 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpexcel`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `score`, `class`, `grade`, `created_at`, `updated_at`) VALUES
(200700001, '打色', '89', '1', '1', '2018-01-02 01:53:57', '2018-01-02 01:53:57'),
(200700002, '的德国人', '80', '1', '2', '2018-01-02 01:54:26', '2018-01-02 01:54:26'),
(200700003, '所反映', '60', '1', '3', '2018-01-02 01:54:41', '2018-01-02 01:54:41'),
(200700004, '和发', '78', '2', '1', '2018-01-02 01:56:25', '2018-01-02 01:56:25'),
(200700005, '和热', '90', '2', '1', '2018-01-02 01:56:51', '2018-01-02 01:56:51'),
(200700006, '大卫', '79', '3', '1', '2018-01-02 01:57:08', '2018-01-02 01:57:08'),
(200700007, '反色', '69', '3', '1', '2018-01-02 01:57:24', '2018-01-02 01:57:24'),
(200700008, '对人体', '79', '2', '2', '2018-01-02 01:57:40', '2018-01-02 01:57:40'),
(200700009, '格房东', '60', '3', '2', '2018-01-02 01:57:58', '2018-01-02 01:57:58'),
(200700010, '房东4', '76', '3', '2', '2018-01-02 01:58:17', '2018-01-02 01:58:17'),
(200700011, '淡粉色', '88', '3', '2', '2018-01-02 01:58:30', '2018-01-02 01:58:30'),
(200700012, '会费', '85', '2', '2', '2018-01-02 01:58:49', '2018-01-02 01:58:49'),
(200700013, '3', '79', '3', '3', '2018-01-02 01:59:01', '2018-01-02 01:59:01'),
(200700014, '大的', '87', '3', '3', '2018-01-02 01:59:21', '2018-01-02 01:59:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_index` (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200700015;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
