ALTER TABLE `admins` ADD `left_menu_display_type` CHAR(1) NOT NULL DEFAULT '0' AFTER `password`; 
ALTER TABLE `questions` ADD `is_sponsored` ENUM('N','Y') NOT NULL DEFAULT 'N' COMMENT 'N - Not, Y - Sponsored' AFTER `steps_completed`; ALTER TABLE `questions` CHANGE `visibility` `visibility` ENUM('public','private') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'public - for published question sets, private - for un published'; 



-- questions_unpublished table

ALTER TABLE `notifications` ADD `sender_type` ENUM('1','2') NOT NULL DEFAULT '2' COMMENT '1 - Admin, 2 - Other users' AFTER `sender_id`; 

ALTER TABLE `notifications` CHANGE `notification_type` `notification_type` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '1 - Clinical, 2 - Administrative'; 

ALTER TABLE `notifications` CHANGE `is_seen` `is_seen` ENUM('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT ' 0 - Not seen or Read, 1 Seen/Read'; 

ALTER TABLE `notifications` CHANGE `notification_type` `notification_type` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 - Clinical, 2 - Administrative'; 

ALTER TABLE `questions_unpublished` ADD `created_by` INT NOT NULL AFTER `question_id`; 

ALTER TABLE `questions_unpublished` CHANGE `created_by` `created_by` CHAR(1) NOT NULL DEFAULT '1' COMMENT '1 - Admin'; 

ALTER TABLE `notifications` ADD `question_id` INT NOT NULL AFTER `id`; 

ALTER TABLE `users` ADD `last_logged_in` DATETIME NOT NULL AFTER `parent_id`; 

ALTER TABLE `questions` ADD `active` ENUM('Y','N','D') NOT NULL DEFAULT 'Y' COMMENT 'Y - active, N - Inactive, D - Disabled' AFTER `updated_at`; 