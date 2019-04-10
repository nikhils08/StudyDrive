-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2019 at 11:14 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studyshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `filecontents`
--

CREATE TABLE `filecontents` (
  `blob_id` int(11) NOT NULL,
  `blob_path` text NOT NULL,
  `blob_size` varchar(255) NOT NULL,
  `blob_hash` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_refrenced` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `blob_id` int(11) NOT NULL,
  `parent_file_id` int(11) DEFAULT NULL,
  `isdirectory` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_name`, `blob_id`, `parent_file_id`, `isdirectory`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'nikhilshadija2@gmail.com', 0, NULL, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `filetokens`
--

CREATE TABLE `filetokens` (
  `file_token_id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `group_user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `noti_id` int(11) NOT NULL,
  `user_file_tokens_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `share_id` int(11) NOT NULL,
  `share_type` tinyint(1) NOT NULL,
  `share_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(22) NOT NULL,
  `token_value` bigint(22) NOT NULL,
  `validity` int(11) NOT NULL,
  `validity_type` text NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `shares`
--
DELIMITER $$
CREATE TRIGGER `delete_file_from_users` AFTER UPDATE ON `shares` FOR EACH ROW UPDATE files set files.deleted=1 where files.file_id in (SELECt userfiletokens.user_file_token_file_id from userfiletokens join usertokens where userfiletokens.user_token_id=usertokens.user_token_id and usertokens.share_id=OLD.share_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `userfiletokens`
--

CREATE TABLE `userfiletokens` (
  `user_file_tokens_id` int(11) NOT NULL,
  `user_token_id` int(11) NOT NULL,
  `file_token_id` int(11) NOT NULL,
  `user_file_token_file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `about_me` text NOT NULL,
  `profile_photo` text NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `created_at`, `updated_at`, `about_me`, `profile_photo`, `token`) VALUES
(1, 'NikhilS', 'Shadija', 'nikhilshadija2@gmail.com', '$2y$10$CAXhnR08FFY6Ofry4j1O1OgiNz5BvabPRksl.rtueno7l4fTeSf82', '0000-00-00 00:00:00', '2018-10-25 15:35:15', 'Tp', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_activity`
--

CREATE TABLE `users_activity` (
  `ua_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logged_in_time` datetime NOT NULL,
  `logged_out_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usertokens`
--

CREATE TABLE `usertokens` (
  `user_token_id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filecontents`
--
ALTER TABLE `filecontents`
  ADD PRIMARY KEY (`blob_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `filetokens`
--
ALTER TABLE `filetokens`
  ADD PRIMARY KEY (`file_token_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`group_user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`share_id`);

--
-- Indexes for table `userfiletokens`
--
ALTER TABLE `userfiletokens`
  ADD PRIMARY KEY (`user_file_tokens_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_activity`
--
ALTER TABLE `users_activity`
  ADD PRIMARY KEY (`ua_id`);

--
-- Indexes for table `usertokens`
--
ALTER TABLE `usertokens`
  ADD PRIMARY KEY (`user_token_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filecontents`
--
ALTER TABLE `filecontents`
  MODIFY `blob_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2848;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8773;
--
-- AUTO_INCREMENT for table `filetokens`
--
ALTER TABLE `filetokens`
  MODIFY `file_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_users`
--
ALTER TABLE `group_users`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
  MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `userfiletokens`
--
ALTER TABLE `userfiletokens`
  MODIFY `user_file_tokens_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users_activity`
--
ALTER TABLE `users_activity`
  MODIFY `ua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `usertokens`
--
ALTER TABLE `usertokens`
  MODIFY `user_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
