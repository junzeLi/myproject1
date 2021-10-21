USE mydb;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `path` text NOT NULL,
  `username` varchar(15) NOT NULL,
  `upload_time` int(10) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `likes` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `files` (`id`, `filename`, `path`, `username`, `upload_time`, `description`, `likes`) VALUES
(58, 'Screen_Shot_2021-05-20_at_7_16_20_pm.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_16_20_pm.png', 'junze', 1621503235, 'Hello, this is a test post', 0),
(59, 'Screen_Shot_2021-05-20_at_7_16_06_pm.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_16_06_pm.png', 'junze', 1621503251, 'so pretty', 0),
(60, 'Screen_Shot_2021-05-20_at_7_15_50_pm.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_15_50_pm.png', 'junze', 1621503273, 'natural', 0),
(61, 'Screen_Shot_2021-05-20_at_7_15_39_pm.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_15_39_pm.png', 'junze', 1621503289, 'take photo!', 0),
(62, 'Screen_Shot_2021-04-07_at_7_50_22_pm1.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-04-07_at_7_50_22_pm1.png', 'testing1', 1621503405, 'Hello, this is a test post', 0),
(63, 'Screen_Shot_2021-05-20_at_7_16_06_pm1.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_16_06_pm1.png', 'testing1', 1621503483, 'testing', 0),
(64, 'Screen_Shot_2021-05-20_at_7_15_59_pm.png', '/var/www/htdocs/myproject/uploads/Screen_Shot_2021-05-20_at_7_15_59_pm.png', 'junze', 1621503562, 'testing in ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file_comments`
--

CREATE TABLE `file_comments` (
  `comment_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_comments`
--

INSERT INTO `file_comments` (`comment_id`, `file_id`, `user_id`, `comment`, `comment_time`) VALUES
(20, 63, 27, 'hi', '2021-05-20 09:42:30'),
(21, 63, 27, 'hi ', '2021-05-20 09:42:42'),
(22, 63, 27, 'hello', '2021-05-20 09:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `file_tag`
--

CREATE TABLE `file_tag` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `tag` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_tag`
--

INSERT INTO `file_tag` (`id`, `file_id`, `tag`) VALUES
(110, 58, 'BEAUTY'),
(111, 58, 'TRAVEL'),
(112, 58, 'FOOD'),
(113, 59, 'FASHION'),
(114, 59, 'DANCE'),
(115, 59, 'MUSIC'),
(116, 60, 'TRAVEL'),
(117, 60, 'VLOG'),
(118, 60, 'SPORT'),
(119, 61, 'BEAUTY'),
(120, 61, 'PLOG'),
(121, 61, 'PETS'),
(122, 62, 'FOOD'),
(123, 63, 'BEAUTY'),
(124, 63, 'TRAVEL'),
(125, 63, 'FOOD'),
(126, 64, 'TRAVEL'),
(127, 64, 'VLOG'),
(128, 64, 'MOVIE');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_name`) VALUES
('BEAUTY'),
('DANCE'),
('FASHION'),
('FOOD'),
('GAME'),
('MOVIE'),
('MUSIC'),
('PETS'),
('PLOG'),
('SPORT'),
('TRAVEL'),
('VLOG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(10) NOT NULL,
  `email` varchar(320) NOT NULL,
  `token` varchar(32) NOT NULL,
  `email_verified` tinyint(1) NOT NULL,
  `following` int(10) NOT NULL,
  `follower` int(10) NOT NULL,
  `profile_path` text NOT NULL,
  `profile_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `email`, `token`, `email_verified`, `following`, `follower`, `profile_path`, `profile_name`) VALUES
(27, 'junze', '$2y$10$ORoGJkjUqvkbnhNvfPg9HOoMP14PJxJTiXHaHkkyBPtJqfNbqsc7O', 1617715692, 'junze.li@uq.net.au', '', 1, 0, 0, './uploads/Screen_Shot_2021-05-20_at_7_16_28_pm.png', 'Screen_Shot_2021-05-20_at_7_16_28_pm'),
(35, 'testing1', '$2y$10$5DLf4QYb.TWWrLWyVPFSJ.Yfe3GsfbheIPignvIvV141e21W4OdnO', 1620185573, 's4518552@student.uq.edu.au', '', 1, 0, 0, './uploads/Screen_Shot_2021-05-20_at_7_15_50_pm1.png', 'Screen_Shot_2021-05-20_at_7_15_50_pm1');

-- --------------------------------------------------------

--
-- Table structure for table `user_follow`
--

CREATE TABLE `user_follow` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_like_file`
--

CREATE TABLE `user_like_file` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_upload` (`username`);

--
-- Indexes for table `file_comments`
--
ALTER TABLE `file_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `FK_comment_of_file` (`file_id`),
  ADD KEY `FK_comment_by_user` (`user_id`);

--
-- Indexes for table `file_tag`
--
ALTER TABLE `file_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_file_id` (`file_id`),
  ADD KEY `FK_tag_name` (`tag`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_follow`
--
ALTER TABLE `user_follow`
  ADD PRIMARY KEY (`follow_id`),
  ADD KEY `FK_follower` (`follower_id`),
  ADD KEY `FK_following` (`following_id`);

--
-- Indexes for table `user_like_file`
--
ALTER TABLE `user_like_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_like` (`user_id`),
  ADD KEY `FK_file_liked` (`file_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `file_comments`
--
ALTER TABLE `file_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `file_tag`
--
ALTER TABLE `file_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_follow`
--
ALTER TABLE `user_follow`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_like_file`
--
ALTER TABLE `user_like_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `FK_user_upload` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `file_comments`
--
ALTER TABLE `file_comments`
  ADD CONSTRAINT `FK_comment_by_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_comment_of_file` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `file_tag`
--
ALTER TABLE `file_tag`
  ADD CONSTRAINT `FK_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `FK_tag_name` FOREIGN KEY (`tag`) REFERENCES `tags` (`tag_name`);

--
-- Constraints for table `user_follow`
--
ALTER TABLE `user_follow`
  ADD CONSTRAINT `FK_follower` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_following` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_like_file`
--
ALTER TABLE `user_like_file`
  ADD CONSTRAINT `FK_file_liked` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `FK_user_like` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;
