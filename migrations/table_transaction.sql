CREATE TABLE `table_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` bigint(15) DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `table_transaction`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `table_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;