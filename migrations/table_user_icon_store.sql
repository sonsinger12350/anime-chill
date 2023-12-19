CREATE TABLE `table_user_icon_store` (
  `user_id` int(11) NOT NULL,
  `icon_id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `transaction_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `table_user_icon_store`
  ADD PRIMARY KEY (`user_id`,`icon_id`);
COMMIT;