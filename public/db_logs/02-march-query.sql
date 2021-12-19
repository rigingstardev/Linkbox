ALTER TABLE `notifications` CHANGE `notification_type` `notification_type` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 - Clinical (Physician), 2 - Administrative (Physician), 3 - Notifications (Patients), 4, Approvals( (Patients)'; 

ALTER TABLE `notifications` CHANGE `sender_type` `sender_type` ENUM('1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '2' COMMENT '1 - Admin, 2 - Physician, 3 - Patient';

ALTER TABLE `notifications` ADD `receiver_type` INT(1) NOT NULL DEFAULT '1' COMMENT '- Physician, 2 - Patient' AFTER `receiver_id`; 

ALTER TABLE `notifications` ADD `status` CHAR(1) NULL DEFAULT 'N' COMMENT 'N - Not applicable, A - Approved, P -- Pending, D - Declined' AFTER `receiver_type`; 

ALTER TABLE notifications
  DROP FOREIGN KEY notifications_receiver_id_foreign
  
