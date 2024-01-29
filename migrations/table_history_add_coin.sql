CREATE TABLE `table_history_add_coin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(50) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `table_history_add_coin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `table_history_add_coin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
