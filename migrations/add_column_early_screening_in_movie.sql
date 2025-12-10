-- Migration: Thêm cột early_screening vào table_movie để lưu trạng thái phim chiếu sớm
ALTER TABLE `table_movie` ADD COLUMN `early_screening` TINYINT(1) NULL DEFAULT 0;