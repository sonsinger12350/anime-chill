SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `table_follow` (
  `id` int(10) NOT NULL,
  `from` int(10) DEFAULT NULL,
  `to` int(10) DEFAULT NULL,
  `created_at` date DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `table_follow`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `table_follow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;