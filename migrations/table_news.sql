CREATE TABLE `table_news` (
  `id` int(10) NOT NULL,
  `name` varchar(355) DEFAULT NULL,
  `other_name` varchar(355) DEFAULT NULL,
  `image` varchar(355) DEFAULT NULL,
  `image_big` varchar(355) DEFAULT NULL,
  `de_cu` varchar(10) NOT NULL DEFAULT 'false',
  `view` int(10) DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `keyword` longtext,
  `seo_title` longtext,
  `public` varchar(50) DEFAULT NULL,
  `time` varchar(155) DEFAULT NULL,
  `timestap` varchar(100) DEFAULT NULL,
  `seo_tap` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `table_news`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `table_news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=807;
COMMIT;