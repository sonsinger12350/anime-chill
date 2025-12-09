-- Migration: Thêm cột history_movie vào table_user để lưu lịch sử xem phim
ALTER TABLE `table_user` ADD COLUMN `history_movie` TEXT NULL DEFAULT NULL;

