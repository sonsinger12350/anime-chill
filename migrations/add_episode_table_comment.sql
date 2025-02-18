ALTER TABLE `table_comment`
ADD COLUMN `episode` INT(10) NULL;

ALTER TABLE `table_episode`
ADD COLUMN `vip` TINYINT(1) DEFAULT 0;